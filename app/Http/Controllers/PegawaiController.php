<?php

namespace App\Http\Controllers;

use App\Models\pegawai;
use App\Models\Role;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::with('role')->latest('id_pegawai')->paginate(10);
        return view('mo.pegawai.index', compact('pegawai'));
    }
    public function edit($id_pegawai)
    {
        $pegawai = pegawai::findOrFail($id_pegawai);
        $roles = Role::all();
        return view('mo.pegawai.edit', compact('pegawai', 'roles'));
    }
    public function update(Request $request, $id_pegawai)
{
    $pegawai = Pegawai::findOrFail($id_pegawai);

    $request->validate([
        'nama_lengkap' => 'required',
        'email_pegawai' => 'required|email',
        'username_pegawai' => 'required',
        'id_role' => 'required',
    ]);

    $pegawai->nama_lengkap = $request->nama_lengkap;
    $pegawai->email = $request->email_pegawai;
    $pegawai->username = $request->username_pegawai;
    $pegawai->id_role = $request->id_role;
    $pegawai->save();

    return redirect()->route('index-pegawai')->with('success', 'Berhasil mengubah data pegawai!');
}


    public function destroy($id_pegawai)
    {
        $pegawai = pegawai::findOrFail($id_pegawai);
        $pegawai->delete();

        return redirect()->route('mo.pegawai.index')->with('success', 'Berhasil menghapus data pegawai!');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $pegawai = pegawai::where('nama_pegawai', 'like', '%' . $search . '%')->paginate(10);
        return route('mo.pegawai.index', compact('pegawai'));
    }
}
