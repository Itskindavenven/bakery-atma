<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transaksi;
use App\Models\Produk;
use App\Models\pembayaran;

class pembayaranController extends Controller
{
    public function waitingList()
    {
        $pesanan = transaksi::where('status', 'Waiting')->get();
        return view('admin.pembayaran.waitingList', compact('pesanan'));
    }

    public function konfirmasiPembayaran()
    {
        $pesanan = transaksi::where('status', 'Menunggu Konfirmasi')->get();
        return view('admin.pembayaran.konfirmasi', compact('pesanan'));
    }

    public function inputJarak(Request $request, $nomor_transaksi)
    {
        $request->validate([
            'jarak' => 'required|numeric',
        ]);

        $pesanan = transaksi::find($nomor_transaksi);
        $jarak = $request->jarak;
        $ongkir = $pesanan->ongkir + $this->calculateCost($jarak);
        $total = $pesanan->total_harga + $ongkir;
        $pesanan->ongkir = $ongkir;
        $pesanan->total_harga = $total;
        $pesanan->status = 'Menunggu Pembayaran';
        $pesanan->jarak = $jarak;
        $pesanan->save();

        $pembayaran = pembayaran::where('nomor_transaksi', $pesanan->nomor_transaksi)->first();
        $pembayaran->total_harga = $pesanan->total_harga;
        $pembayaran->where('nomor_transaksi', $pesanan->nomor_transaksi)->update(['total_harga' => $pembayaran->total_harga]);

        $pesanan = transaksi::where('status', 'Waiting')->get();
        return redirect()->route('pembayaran.waitingList')->with('success', 'Jarak berhasil diinput dan total harga dihitung');
    }

    public function inputStatusPembayaran(Request $request, $nomor_transaksi)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $pesanan = transaksi::find($nomor_transaksi);
        $status = $request->status;
        $pesanan->status = $status;
        $pesanan->save();

        $pesanan = transaksi::where('status', 'Menunggu Konfirmasi')->get();
        return redirect()->route('pembayaran.konfirmasiPembayaran')->with('success', 'Status pembayaran berhasil diinput');
    }

    private function calculateCost($jarak)
    {
        if ($jarak <= 5) {
            return 10000;
        } elseif ($jarak <= 10) {
            return 15000;
        } elseif ($jarak <= 15) {
            return 20000;
        } else {
            return 25000;
        }
    }
}