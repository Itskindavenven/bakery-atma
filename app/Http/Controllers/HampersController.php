<?php

namespace App\Http\Controllers;

use App\Models\produk;
use App\Models\produk_hampers;
use Illuminate\Http\Request;
use App\Models\Hampers;

class HampersController extends Controller
{
    public function index()
    {
        $hampers = hampers::latest('id_hampers')->paginate(10);
        return response()->json([
            'status' => true,
            'data' => $hampers
        ], 200);
    }
    public function detail($id){
        $hampers = Hampers::where('id_hampers', $id)->get();
        $produk_hampers = produk_hampers::where('id_hampers', $id)->get();
        $produk = produk::whereIn('id_produk', $produk_hampers->pluck('id_produk'))->get();
        
        return response()->json([
            'status'=> true,
            'hampers'=> $hampers,
            'produk_hampers'=> $produk_hampers,
            'produk'=> $produk
        ], 200);
    }
    public function fetch_produk()
    {
        $produk = produk::select('id_produk', 'nama')->where('jenis_produk', 'Produk Toko')->get();
        return response()->json([
            'status'=> true,
            'produk'=> $produk
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        $hampers = Hampers::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Hampers created successfully.',
            'data' => $hampers
        ], 201);
    }

    public function show($id)
    {
        try {
            $hampers = Hampers::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $hampers
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Hampers not found.',
                'error' => $e->getMessage()
            ], 404);
        }
    }
    public function fetch_data_update($id){
        $hampers = Hampers::findOrFail($id);
        $produk = produk::select('id_produk', 'nama')->where('jenis_produk', 'Produk Toko')->get();
        $produk_hampers = produk_hampers::where('id_hampers', $id)->first();
        $id_produk = $produk_hampers ? $produk_hampers->id_produk : null;

        return response()->json([
            'status'=> true,
            'hampers'=> $hampers,
            'produk'=> $produk,
            'id_produk'=> $id_produk
        ], 200);
    }
    public function update_produk(Request $request, $id){
        $hampers = Hampers::findOrFail($id);

        $request->validate([
            'nama'=> 'required',
            'harga'=> 'required',
            'id_produk'=>'required'
        ]);

        $hampers->nama = $request->nama;
        $hampers->harga = $request->harga;
        $hampers->save();

        produk_hampers::create([
            'id_hampers'=> $hampers->id_hampers,
            'harga'=> $hampers->harga,
            'id_produk'=> $request->id_produk
        ],);

        return response()->json([
            'status'=> true,
            'hampers'=> $hampers,
            'produk'=> $request->id_produk
        ], 200);
    }
    public function fetch_edit_hampers($id){
        $hampers = Hampers::findOrFail($id);

        return response()->json([
            'status'=> true,
            'hampers'=> $hampers
        ], 200);
    }
    public function edit_hampers(Request $request, $id){
        $hampers = Hampers::findOrFail($id);
        $request->validate([
            'nama'=> 'required',
            'harga'=> 'required'
        ], 200);

        $hampers->update($request->all());

        return response()->json([
            'status'=> true,
            'data'=> $hampers
        ], 200);
    }
    public function destroy_produk($id){
        produk_hampers::where('id_produk', $id)->delete();
        $id_hampers = produk_hampers::where('id_produk', $id)->pluck('id_hampers');
        $hampers = Hampers::whereIn('id_hampers', $id_hampers)->first();
        $produk_hampers = produk_hampers::whereIn('id_hampers', $id_hampers)->get();
        $produk = produk::whereIn('id_produk', $produk_hampers->pluck('id_produk'))->get();

        
        return response()->json([
            'status'=> true,
            'message'=> 'berhasil destroy produk',
        ], 200);
    }
    public function destroy($id)
    {
        try {
            $hampers = Hampers::findOrFail($id);
            $hampers->delete();

            return response()->json([
                'status' => true,
                'message' => 'Hampers deleted successfully.'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Hampers not found.',
                'error' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete hampers.',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
