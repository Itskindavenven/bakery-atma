<?php

namespace App\Http\Controllers;

use App\Models\bahan_baku;
use App\Models\keranjang;
use App\Models\produk;
use App\Models\resep_bahan;
use App\Models\transaksi;
use App\Models\customer;
use App\Models\stock_produk;
use App\Models\resep;
use App\Models\bahanResep;
use App\Models\bahanBaku;
use App\Models\pemakaianBahanBaku;
use App\Models\detailPemakaianBahanBaku;
use Carbon\Carbon;
use Illuminate\Http\Request;

class prosesController extends Controller
{

    public function pesananHarian()
    {
        $daftarPesanan = [];
        $today = Carbon::today();
        $tanggalMulai = $today->copy()->addDays(2);
        $nomor_transaksi = transaksi::where('tanggal_pengambilan', $tanggalMulai)->where('status', 'Menunggu Dibuat')->pluck('nomor_transaksi');
        foreach ($nomor_transaksi as $no_transaksi) {
            $status = transaksi::where('nomor_transaksi', $no_transaksi)->where('status', 'Menunggu Dibuat')->value('status');
            $produkKeranjang = keranjang::where('nomor_transaksi', $no_transaksi)->get(['id_produk', 'jumlah_produk']);
            $produk = produk::whereIn('id_produk', $produkKeranjang->pluck('id_produk'))->get(['id_produk', 'nama']);
            foreach ($produkKeranjang as $produk) {
                $daftarPesanan[] = [
                    'nomor_transaksi' => $no_transaksi,
                    'id_produk' => $produk->id_produk,
                    'nama_produk' => $produk->produk->nama,
                    'jumlah_pesanan' => $produk->jumlah_produk,
                    'status' => $status,
                ];
            }
        }
        return view('mo.proses.pesananHarian', compact('daftarPesanan'));
    }

    public function kurangiStok(Request $request, $nomor_transaksi)
    {
        $pesanan = transaksi::where('nomor_transaksi', $nomor_transaksi)->first();
        $status = $request->status;
        $pesanan->status = $status;
        $pesanan->save();

        $pemakaianBahan = new pemakaianBahanBaku();
        $pemakaianBahan->tanggal_pemakaian = Carbon::now();
        $pemakaianBahan->save();

        if ($status == 'Menunggu Dibuat') {
            return redirect()->route('proses.pesananHarian');
        } else {
            $id_produk = keranjang::where('nomor_transaksi', $nomor_transaksi)->pluck('id_produk');
            $bahanKurang = [];
            foreach ($id_produk as $id) {
                $jumlah_pesanan = keranjang::where('nomor_transaksi', $nomor_transaksi)
                    ->where('id_produk', $id)
                    ->value('jumlah_produk');

                $id_resep = resep::where('id_produk', $id)->value('id_resep');
                $bahanResep = resep_bahan::where('id_resep', $id_resep)->get();

                foreach ($bahanResep as $r) {
                    $stokBahan = bahan_baku::where('id_bahan', $r->id_bahan)->value('stock');
                    $bahanDipakai = $r->kuantitas * $jumlah_pesanan;
                    $sisaBahan = $stokBahan - ($r->kuantitas * $jumlah_pesanan);

                    if ($sisaBahan <= 0) {
                        $bahanKurang[$r->bahanBaku->nama_bahan_baku] = abs($sisaBahan);
                        $pesanan->status = 'Menunggu Dibuat';
                        $pesanan->save();

                    } else {
                        bahan_baku::where('id_bahan', $r->id_bahan)->update(['stock' => $sisaBahan]);
                        $stokSekarang = bahan_baku::where('id_bahan', $r->id_bahan)->value('stock');

                        if ($stokSekarang <= 0) {
                            $bahanKurang[$r->bahan_baku->nama] = abs($stokSekarang);
                        }

                        if (detailPemakaianBahanBaku::where('id_bahan', $r->id_bahan)->exists()) {

                            $bahanDipakai += detailPemakaianBahanBaku::where('id_bahan_baku', $r->id_bahan)->sum('kuantitas');

                            detailPemakaianBahanBaku::where('id_bahan_baku', $r->id_bahan)
                                ->update(['kuantitas' => $bahanDipakai]);
                        } else {
                            $detailPemakaianBahanBaku = new detailPemakaianBahanBaku();
                            $detailPemakaianBahanBaku->id_pemakaian = $pemakaianBahan->id_pemakaian;
                            $detailPemakaianBahanBaku->id_bahan_baku = $r->id_bahan;
                            $detailPemakaianBahanBaku->kuantitas = $bahanDipakai;
                            $detailPemakaianBahanBaku->save();
                        }
                    }
                }
            }

            if ($pesanan->status == "Menunggu Dibuat") {
                $message = 'Pesanan tidak bisa dibuat!';
                if (! empty($bahanKurang)) {
                    $message .= ' Beberapa bahan kurang: ';
                    foreach ($bahanKurang as $r->bahan_baku->nama => $stokSekarang) {
                        $message .= $r->bahan_baku->nama. ' kurang ' . $stokSekarang . ', ';
                    }
                    $message = rtrim($message, ', ') . '.';
                }
            } else {
                $message = 'Pesanan mulai dibuat.';
                if (! empty($bahanKurang)) {
                    $message .= ' Namun, beberapa bahan kurang: ';
                    foreach ($bahanKurang as $r->bahanBaku->nama_bahan_baku => $stokSekarang) {
                        $message .= $r->bahan_baku->nama . ' kurang ' . $stokSekarang . ',';
                    }
                    $message = rtrim($message, ', ') . '.';
                }
            }
            $pesanan = transaksi::with(['customer', 'produk', 'keranjang', 'resep', 'pembayaran'])->where('status', 'Menunggu Diproses')->get();
            return redirect()->route('proses.pesananHarian')->with('success', $message);
        }
    }

    public function pemakaianBahanBaku()
    {
        $pemakaianBahan = pemakaianBahanBaku::all();
        return view('mo.pemakaianBahan.pemakaianBahan', compact('pemakaianBahan'));
    }
}