<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bahan_baku;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BahanBakuController extends Controller
{
    public function index()
    {
        $bahan = bahan_baku::latest('id_bahan')->paginate(10);
        return view('admin.bahan.index', compact('bahan'));
    }

    public function create()
    {
        return view('admin.bahan.create');
    }

    public function store(Request $request)
    {
        $request->validateWithBag('post', [
            'nama_bahan_baku' => 'required',
            'jumlah_bahan_baku' => 'required',
            'satuan' => 'required',
            'harga_bahan_baku' => 'required',
        ]);

        bahan_baku::create([
            'nama' => $request->nama_bahan_baku,
            'stock' => $request->jumlah_bahan_baku,
            'satuan' => $request->satuan,
            'harga' => $request->harga_bahan_baku,
        ]);

        return redirect()->route('bahan.index')->with('success', 'Berhasil menambah data baru!');
    }

    public function edit($id_bahan_baku)
    {
        $bahan = bahan_baku::findOrFail($id_bahan_baku);
        return view('admin.bahan.edit', compact('bahan'));
    }

    public function update(Request $request, $id_bahan_baku)
    {
        $bahan = bahan_baku::findOrFail($id_bahan_baku);

        $request->validateWithBag('post', [
            'nama_bahan_baku' => 'required',
            'jumlah_bahan_baku' => 'required',
            'satuan' => 'required',
            'harga_bahan_baku' => 'required',
        ]);

        $bahan->nama = $request->nama_bahan_baku;
        $bahan->stock = $request->jumlah_bahan_baku;
        $bahan->satuan = $request->satuan;
        $bahan->harga = $request->harga_bahan_baku;
        $bahan->save();

        return redirect()->route('bahan.index')->with('success', 'Berhasil mengubah data event!');
    }

    public function destroy($id_bahan_baku)
    {
        $bahan = bahan_baku::findOrFail($id_bahan_baku);
        $bahan->delete();

        return redirect()->route('bahan.index')->with('success', 'Berhasil menghapus data event!');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $bahan = bahan_baku::where('nama_bahan_baku', 'like', '%' . $search . '%')->paginate(10);
        return view('admin.bahan.index', compact('bahan'));
    }
}
