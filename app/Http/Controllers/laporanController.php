<?php

namespace App\Http\Controllers;

use App\Models\bahan_baku;
use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\keranjang;
use App\Models\produk;
use App\Models\transaksi;
use Barryvdh\DomPDF\Facade\PDF;

class laporanController extends Controller
{
    public function laporanBahanBaku()
    {
        $data = bahan_baku::orderBy('nama', 'asc')->get();
        $pdf = PDF::loadView('laporan.laporanStokBahan', ['data' => $data]);
        return $pdf->download('stock-bahan-baku.pdf');
    }

    public function laporanPenjualanProduk(Request $request)
    {
        $bulanNama = $request->input('bulan');
        $bulanMap = [
            'Januari' => '01',
            'Februari' => '02',
            'Maret' => '03',
            'April' => '04',
            'Mei' => '05',
            'Juni' => '06',
            'Juli' => '07',
            'Agustus' => '08',
            'September' => '09',
            'Oktober' => '10',
            'November' => '11',
            'Desember' => '12',
        ];

        $bulan = $bulanMap[$bulanNama];
        $tahun = date('Y');

        $data = [];
        $nomor_transaksi = transaksi::where('status', 'selesai')
            ->whereYear('tanggal_pengambilan', $tahun)
            ->whereMonth('tanggal_pengambilan', $bulan)
            ->pluck('nomor_transaksi');

        foreach ($nomor_transaksi as $no_transaksi) {
            $id_produk = keranjang::where('nomor_transaksi', $no_transaksi)->pluck('id_produk');
            foreach ($id_produk as $id) {
                $jumlah_produk = keranjang::where('nomor_transaksi', $no_transaksi)->where('id_produk', $id)->value('jumlah_produk');
                $nama_produk = produk::where('id_produk', $id)->value('nama');
                $harga_produk = produk::where('id_produk', $id)->value('harga');
                $total_harga = $harga_produk * $jumlah_produk;

                $data[] = [
                    'nama_produk' => $nama_produk,
                    'jumlah_produk' => $jumlah_produk,
                    'harga_produk' => $harga_produk,
                    'total_harga' => $total_harga,
                ];
            }
        }

        $pdf = PDF::loadView('laporan.laporanPenjualanProduk', ['data' => $data]);
        return $pdf->download('laporan-penjualan-produk-bulanan.pdf');
    }
}