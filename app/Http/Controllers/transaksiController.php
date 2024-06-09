<?php

namespace App\Http\Controllers;

use App\Models\alamat;
use App\Models\bahan_baku;
use App\Models\customer;
use App\Models\Hampers;
use App\Models\keranjang;
use App\Models\produk;
use App\Models\Resep;
use App\Models\resep_bahan;
use App\Models\stock_produk;
use App\Models\Transaksi;
use App\Models\pembayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class transaksiController extends Controller
{
    public function hitungPoin($total_harga, $id_customer)
    {
        $poin = 0;

        for ($total_harga; $total_harga >= 1000000; $total_harga = $total_harga - 1000000) {
            $poin = $poin + 200;
        }
        for ($total_harga; $total_harga >= 500000; $total_harga = $total_harga - 500000) {
            $poin = $poin + 75;
        }
        for ($total_harga; $total_harga >= 100000; $total_harga = $total_harga - 100000) {
            $poin = $poin + 15;
        }
        for ($total_harga; $total_harga >= 10000; $total_harga = $total_harga - 10000) {
            $poin = $poin + 1;
        }

        $today = carbon::today();
        $customer = customer::where('id_customer', $id_customer)->first();
        $tanggalLahir = Carbon::parse($customer->tanggal_lahir);
        $ulangTahun = Carbon::createFromDate($tanggalLahir->month, $tanggalLahir->day);
        $start = Carbon::createFromDate($tanggalLahir->month, $tanggalLahir->day - 3);
        $end = Carbon::createFromDate($tanggalLahir->month, $tanggalLahir->day + 3);
        $double = $today->between($start, $end);

        if ($double) {
            $poin = $poin * 2;
        }

        return $poin;
    }
    public function create($id){
        $status = Transaksi::where('id_customer', $id)
            -> whereNotIn('status', ['Selesai', 'Batal'])
            -> first();
        
            $transaksi = new transaksi;
            $nomor_transaksi = transaksi::generateNomerTransaksi();
            $transaksi->nomor_transaksi = $nomor_transaksi;
            $transaksi->id_customer = $id;
            $transaksi->tanggal_pemesanan = Carbon::now();
            $transaksi->save();

            $pembayaran = new pembayaran;
            $pembayaran->nomor_transaksi = $nomor_transaksi;
            $pembayaran->save();

            $pesanan = transaksi::where('nomor_transaksi', $transaksi->nomor_transaksi)->first();
            $keranjang = keranjang::where('nomor_transaksi', $transaksi->nomor_transaksi)->get();
            $produk = produk::whereIn('id_produk', $keranjang->pluck('id_produk'))->get();
            $hampers = hampers::whereIn('id_hampers', $keranjang->pluck('id_hampers'))->get();

            return view('customer.keranjang.keranjang', compact('pesanan', 'keranjang', 'produk', 'hampers'));
        
    }
    public function keranjang($nomor_transaksi){
        $pesanan = transaksi::where('nomor_transaksi', $nomor_transaksi)->first();
        $keranjang = keranjang::where('nomor_transaksi', $nomor_transaksi)->get();
        $total_harga = $keranjang->sum('subtotal');
        $pesanan->total_harga = $total_harga;

        $id_customer = $pesanan->id_customer;
        $poin = $this->hitungPoin($pesanan->total_harga, $id_customer);
        $pesanan->poin = $poin;

        $pesanan->total_harga = $total_harga;
        $pesanan->save();
        $pesanan->save();
        $produk = produk::whereIn('id_produk', $keranjang->pluck('id_produk'))->get();
        $hampers = hampers::whereIn('id_hampers', $keranjang->pluck('id_hampers'))->get();

        return view('customer.keranjang.keranjang', compact('pesanan', 'keranjang', 'produk', 'hampers', 'total_harga'));
    }

    public function tambahProduk($nomor_transaksi){
        $nomor_transaksi = transaksi::select('nomor_transaksi')->where('nomor_transaksi', $nomor_transaksi)->first();
        $transaksi = transaksi::where('nomor_transaksi', $nomor_transaksi->nomor_transaksi)->first();
        $produk = produk::all();
        $hampers = hampers::all();

        return view('customer.keranjang.tambah', compact('produk', 'hampers', 'nomor_transaksi', 'transaksi'));
    }

    public function inputProduk(Request $request, $nomor_transaksi){
        $request->validate([
            'jumlah_produk' => 'required',
        ]);

        $keranjang = new keranjang;
        $keranjang->nomor_transaksi = $nomor_transaksi;
        $keranjang->id_produk = $request->id_produk;
        $keranjang->id_hampers = $request->id_hampers;
        $keranjang->jumlah_produk = $request->jumlah_produk;
        $transaksi = transaksi::where('nomor_transaksi', $nomor_transaksi)->first();
        $tanggal_pengambilan = $transaksi->tanggal_pengambilan;
        $stokProduk = stock_produk::where('id_produk', $request->id_produk)->first();
        $sisaStok = $stokProduk->stock;
        
        if ($keranjang->jumlah_produk > $sisaStok) {
            return back()->with('error', 'Stok produk tidak mencukupi');
        } else {
            if ($request->id_produk == null) {
                if ($request->id_hampers == null) {
                    return back()->with('error', 'Pilih salah satu produk atau hampers!');
                } else {
                    $subtotal = hampers::find($request->id_hampers)->harga * $request->jumlah_produk;
                }
            } elseif ($request->id_hampers == null) {
                $subtotal = produk::find($request->id_produk)->harga * $request->jumlah_produk;
            } else {
                return back()->with('error', 'Pilih salah satu produk atau hampers!');
            }

            $keranjang->subtotal = $subtotal;
            $keranjang->save();

            $sisaStokProduk = $sisaStok - $keranjang->jumlah_produk;
            stock_produk::where('id_produk', $keranjang->id_produk)
                ->update(['stock' => $sisaStokProduk]);

            return redirect()->route('transaksi.keranjang', $nomor_transaksi)->with('success', 'Berhasil menambahkan produk ke keranjang');
        }
    }

    public function tambahPengambilan($nomor_transaksi)
    {
        $transaksi = transaksi::where('nomor_transaksi', $nomor_transaksi)->first();
        $alamat = alamat::select('alamat')->where('id_customer', $transaksi->id_customer)->get();
        return view('customer.keranjang.pengambilan', compact('transaksi', 'alamat'));
    }

    public function inputPengambilan(Request $request, $nomor_transaksi)
    {
        $request->validate([
            'tanggal_pengambilan' => 'required',
            'pengambilan' => 'required',
        ]);

        $pesanan = transaksi::find($nomor_transaksi);
        $pesanan->tanggal_pengambilan = $request->tanggal_pengambilan;
        $pesanan->pengambilan = $request->pengambilan;
        $pesanan->save();

        if ($pesanan->pengambilan == 'Ambil di Toko') {
            $id_customer = $pesanan->id_customer;
            $pesanan->status = 'Menunggu Pembayaran';
            $pesanan->save();
            $pesanan = transaksi::where('id_customer', $id_customer)->get();
            return view('customer.transaksi.cekPesanan', compact('pesanan'))->with('success', 'Berhasil menambahkan pesanan');
        } else {
            if ($request->alamat == 'Alamat Baru') {
                $alamatBaru = new alamat();
                $alamatBaru->id_customer = $pesanan->id_customer;
                $alamatBaru->alamat = $request->alamatBaru;
                if ($request->alamatBaru == null) {
                    return back()->with('error', 'Alamat tidak boleh kosong');
                } else {
                    $alamatBaru->save();
                    $pesanan->alamat = $alamatBaru->alamat;
                    $pesanan->save();
                }
            } else {
                if ($request->alamat == null) {
                    return back()->with('error', 'Alamat tidak boleh kosong');
                } else {
                    $pesanan->alamat = $request->alamat;
                    $pesanan->save();
                }
            }

            return redirect()->route('transaksi.summary', $nomor_transaksi)->with('success', 'Berhasil menambahkan pengambilan');
        }
    }

    public function cekPesanan($id_customer)
    {
        $pesanan = transaksi::where('id_customer', $id_customer)->get();
        return view('customer.transaksi.cekPesanan', compact('pesanan'));
    }

    public function summary($nomor_transaksi){
        $transaksi = transaksi::find($nomor_transaksi);
        $keranjang = keranjang::where('nomor_transaksi', $nomor_transaksi)->get();
        $produk = produk::whereIn('id_produk', $keranjang->pluck('id_produk'))->get();
        $hampers = hampers::whereIn('id_hampers', $keranjang->pluck('id_hampers'))->get();

        return view('customer.transaksi.summary', compact('transaksi', 'keranjang', 'produk', 'hampers'));
    }
    public function search(Request $request)
    {
        $search = $request->search;
        $transaksi = transaksi::where('nomor_transaksi', 'like', "%" . $search . "%")->paginate(5);
        return view('customer.transaksi.cekPesanan', compact('transaksi'));
    }
    public function cetakNota($nomor_transaksi)
    {
        $transaksi = transaksi::find($nomor_transaksi);
        $keranjang = keranjang::where('nomor_transaksi', $nomor_transaksi)->get();
        $produk = produk::whereIn('id_produk', $keranjang->pluck('id_produk'))->get();
        $hampers = hampers::whereIn('id_hampers', $keranjang->pluck('id_hampers'))->get();
        $pembayaran = pembayaran::where('nomor_transaksi', $nomor_transaksi)->first();

        $data = [
            'transaksi' => $transaksi,
            'keranjang' => $keranjang,
            'produk' => $produk,
            'hampers' => $hampers,
            'pembayaran' => $pembayaran,
        ];

        $pdf = Pdf::loadView('customer.transaksi.nota', $data);

        return $pdf->download('nota.pdf');
    }
    public function bayar($nomor_transaksi)
    {
        $transaksi = transaksi::find($nomor_transaksi);
        $keranjang = keranjang::where('nomor_transaksi', $nomor_transaksi)->get();
        $produk = produk::whereIn('id_produk', $keranjang->pluck('id_produk'))->get();
        $hampers = hampers::whereIn('id_hampers', $keranjang->pluck('id_hampers'))->get();

        return view('customer.transaksi.bayar', compact('transaksi', 'keranjang', 'produk', 'hampers'));
    }
    public function inputPembayaran(Request $request, $nomor_transaksi)
    {
        $pembayaran = pembayaran::where('nomor_transaksi', $nomor_transaksi)->first();
        $pembayaran->uang_diterima = $request->uangDiterima;
        if ($request->uangDiterima < $pembayaran->total_harga) {
            return back()->with('error', 'Uang yang diterima kurang');
        } else {
            $tip = $pembayaran->uang_diterima - $pembayaran->total_harga;
            $pembayaran->tip = $tip;
            $pembayaran->tanggal_pembayaran = Carbon::now();

            if ($request->hasFile('bukti_pembayaran')) {
                $bukti_pembayaran = $request->file('bukti_pembayaran')->store('pembayarans', 'public');
                $pembayaran->bukti_pembayaran = $bukti_pembayaran;
            }

            $pembayaran->where('nomor_transaksi', $nomor_transaksi)->update(['uang_diterima' => $pembayaran->uang_diterima, 'tip' => $pembayaran->tip, 'tanggal_pembayaran' => $pembayaran->tanggal_pembayaran, 'bukti_pembayaran' => $pembayaran->bukti_pembayaran]);
            $pesanan = transaksi::find($nomor_transaksi);
            $pesanan->status = 'Menunggu Konfirmasi';
            $pesanan->save();
            $pesanan = transaksi::where('id_customer', $pesanan->id_customer)->get();
            return view('customer.transaksi.cekPesanan', compact('pesanan'));
        }
    }
    public function destroy($nomor_transaksi)
    {
        $transaksi = transaksi::where('nomor_transaksi', $nomor_transaksi)->first();

        if ($transaksi) {

            $transaksi->status = 'Batal';
            $transaksi->save();
            $pesanan = transaksi::where('id_customer', $transaksi->id_customer)->get();

            return view('customer.transaksi.cekPesanan', compact('pesanan'))->with('success', 'Berhasil menghapus transaksi');
        } else {
            return redirect()->route('transaksi.keranjang', $nomor_transaksi)->with('error', 'Transaksi tidak ditemukan');
        }

    }
    public function kurangi($nomor_transaksi, Request $request)
    {
        $transaksi = Transaksi::where('nomor_transaksi', $nomor_transaksi)->first();
        $id_hampers = $request->id_hampers;
        $id_produk = $request->id_produk;

        if ($transaksi) {
            if ($id_hampers) {
                Keranjang::where('nomor_transaksi', $nomor_transaksi)
                    ->where('id_hampers', $id_hampers)
                    ->delete();
            } elseif ($id_produk) {
                Keranjang::where('nomor_transaksi', $nomor_transaksi)
                    ->where('id_produk', $id_produk)
                    ->delete();
            }
            
                $jumlah_produk = keranjang::where('nomor_transaksi', $nomor_transaksi)->where('id_produk', $id_produk)->value('jumlah_produk');
                $produk = produk::where('id_produk', $id_produk)->first();
                $stokBaru = $produk->stok + $jumlah_produk;
                stock_produk::where('id_produk', $id_produk)->update(['stock' => $stokBaru]);
            
            return redirect()->route('transaksi.keranjang', $nomor_transaksi)
                ->with('success', 'Item berhasil dihapus dari keranjang');

        } else {
            return redirect()->route('transaksi.keranjang', $nomor_transaksi)
                ->with('error', 'Transaksi tidak ditemukan');
        }
    }

    public function kurangiStok(Request $request, $nomor_transaksi)
    {
        $pesanan = transaksi::where('nomor_transaksi', $nomor_transaksi)->first();
        $status = $request->status;
        $pesanan->status = $status;
        $pesanan->save();

        if ($status == 'Batal') {
            $uangKembali = $pesanan->total_harga;
            $customer = Customer::where('id_customer', $pesanan->id_customer)->first();
            $totalSaldo = $customer->saldo + $uangKembali;
            $customer->saldo = $totalSaldo;
            $customer->save();
            $id_produk = keranjang::where('nomor_transaksi', $nomor_transaksi)->pluck('id_produk');
            $tanggal_pengambilan = transaksi::where('nomor_transaksi', $nomor_transaksi)->value('tanggal_pengambilan');
            foreach ($id_produk as $id) {
                $jumlah_produk = keranjang::where('nomor_transaksi', $nomor_transaksi)->where('id_produk', $id)->value('jumlah_produk');
                $produk = produk::where('id_produk', $id)->first();
                $stokBaru = $produk->stok + $jumlah_produk;
                stock_produk::where('id_produk', $id)->where('tanggal_tersedia', $tanggal_pengambilan)->update(['stok' => $stokBaru]);
            }

            $pesanan = transaksi::where('status', 'Menunggu Diproses')->get();
            return redirect()->route('transaksi.konfirmasiProses')->with('success', 'Berhasil Konfirmasi Memproses Pesanan');
        } else {
            $customer = Customer::where('id_customer', $pesanan->id_customer)->first();
            $poin = $customer->poin + $pesanan->poin;
            $customer->poin = $poin;
            $customer->save();
            $id_produk = keranjang::where('nomor_transaksi', $nomor_transaksi)->pluck('id_produk');
            $tanggal_pengambilan = transaksi::where('nomor_transaksi', $nomor_transaksi)->value('tanggal_pengambilan');
            $bahanKurang = [];
            foreach ($id_produk as $id) {
                $produk = produk::where('id_produk', $id)->first();
                $jumlah_produk = keranjang::where('nomor_transaksi', $nomor_transaksi)->where('id_produk', $id)->value('jumlah_produk');

                $id_resep = resep::where('id_produk', $id)->value('id_resep');
                $bahanResep = resep_bahan::where('id_resep', $id_resep)->get();

                foreach ($bahanResep as $r) {
                    $stokBahan = bahan_baku::where('id_bahan', $r->id_bahan)->value('stock');

                    $sisaBahan = $stokBahan - ($r->kuantitas * $jumlah_produk);

                    if ($sisaBahan <= 1) {
                        $bahanKurang[$r->bahan_baku->nama] = abs($r->bahan_baku->stock);
                    }
                }
            }

            $message = 'Transaksi berhasil dikonfirmasi dan poin telah ditambahkan.';
            if (! empty($bahanKurang)) {
                $message .= ' Namun, beberapa bahan kurang: ';
                foreach ($bahanKurang as $r->bahanBaku->nama_bahan_baku => $sisaBahan) {
                    $message .= $r->bahanBaku->nama_bahan_baku . ' kurang ' . $sisaBahan . ' gr, ';
                }
                $message = rtrim($message, ', ') . '.';
            }

            $pesanan = transaksi::with(['customer', 'produk', 'keranjang', 'resep', 'pembayaran'])->where('status', 'Menunggu Diproses')->get();
            return redirect()->route('transaksi.konfirmasiProses')->with('success', $message);
        }
    }

    public function konfirmasiProses()
    {
        $pesanan = transaksi::where('status', 'Menunggu Diproses')->get();
        return view('mo.konfirmasi.konfirmasiProses', compact('pesanan'));
    }
    

}
