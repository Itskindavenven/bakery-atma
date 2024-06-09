<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\pemesanan_bahan;
use App\Models\bahan_baku;

class PemesananController extends Controller
{
    public function index()
    {
        $pemesanans = Pemesanan::latest('id_pembelian')->paginate(10);
        return response()->json([
            'status' => true,
            'data' => $pemesanans
        ], 200);
    }
    public function detail($id){
        $pemesanans = Pemesanan::where('id_pemesanan', $id)->get();
        $pemesanan_bahan = pemesanan_bahan::with('bahan_baku')->where('id_pemesanan', $id)->get();
        $bahan = bahan_baku::whereIn('id_bahan', $pemesanan_bahan->pluck('id_bahan'))->get();
        return response()->json([
            'status'=> true,
            'pemesanan'=> $pemesanans,
            'pemesanan_bahan'=> $pemesanan_bahan,
            'bahan'=> $bahan
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'=> 'required',
        ]);

        $pemesanan = Pemesanan::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Pemesanan created successfully.',
            'data' => $pemesanan
        ], 201);
    }
    public function fetch_update_bahan($id){
        $pemesanan = Pemesanan::findOrFail($id);
        $bahan = bahan_baku::select('id_bahan', 'nama')->get();
        $pemesanan_bahan = pemesanan_bahan::where('id_pemesanan', $id)->first();
        $id_bahan = $pemesanan_bahan ? $pemesanan_bahan->id_bahan : null;

        return response()->json([
            'status'=> true,
            'pemesanan'=> $pemesanan,
            'bahan'=> $bahan,
            'id_bahan'=> $id_bahan
        ]);
    }
    public function update_bahan(Request $request, $id)
    {
        $pemesanan = pemesanan::findOrFail($id);
        
        $request->validate([
            'tanggal' => 'required',
            'id_bahan' => 'required',
            'jumlah' => 'required|integer',
            'satuan' => 'required|string',
            'harga' => 'required|numeric',
        ]);

        $pemesanan->tanggal = $request->tanggal;

        pemesanan_bahan::create([
            'id_pemesanan'=> $pemesanan->id_pemesanan,
            'id_bahan'=> $request->id_bahan,
            'jumlah'=> $request->jumlah,
            'satuan'=> $request->satuan,
            'harga'=> $request->harga
        ]);

        
        $pemesanan_bahan = pemesanan_bahan::where('id_pemesanan', $pemesanan->id_pemesanan)->get();
        $total = $pemesanan_bahan->sum('harga');
        $pemesanan->total = $total;
        $pemesanan->save();

        return response()->json([
            'status' => true,
            'message' => 'Pemesanan updated successfully.',
            'data' => [
                'pemesanan' => $pemesanan,
                'bahan_baku' => $pemesanan_bahan
            ]
        ], 200);
    }

    public function destroy($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->delete();

        return response()->json([
            'status' => true,
            'message' => 'Pemesanan deleted successfully.'
        ], 200);
    }
}
