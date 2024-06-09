<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengeluaranLain;

class PengeluaranLainController extends Controller
{
    public function index()
    {
        $pengeluarans = PengeluaranLain::all();
        return response()->json([
            'status' => true,
            'data' => $pengeluarans
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'dana' => 'required|numeric',
        ]);

        $pengeluaran = PengeluaranLain::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Pengeluaran lain berhasil dibuat.',
            'data' => $pengeluaran
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'dana' => 'required|numeric',
        ]);

        $pengeluaran = PengeluaranLain::findOrFail($id);
        $pengeluaran->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Pengeluaran lain berhasil diperbarui.',
            'data' => $pengeluaran
        ], 200);
    }

    public function destroy($id)
    {
        $pengeluaran = PengeluaranLain::findOrFail($id);
        $pengeluaran->delete();

        return response()->json([
            'status' => true,
            'message' => 'Pengeluaran lain berhasil dihapus.'
        ], 200);
    }
}
