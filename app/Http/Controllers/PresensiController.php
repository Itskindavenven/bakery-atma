<?php

namespace App\Http\Controllers;

use App\Models\pegawai;
use Illuminate\Http\Request;
use App\Models\presensi;

class PresensiController extends Controller
{
    public function indexMo()
    {
        $presensi = presensi::latest('id_presensi')->paginate(10);
        return view('mo.presensi.index', compact('presensi'));
    }
    public function createMo(){
        $pegawai = pegawai::all();
        return view('mo.presensi.create', compact('pegawai'));
    }
    public function storeMo(Request $request){
        $request->validate([
            'id_pegawai' => 'required',
            'tanggal_presensi' => 'required|date',
            
            'jam_masuk' => 'required|date_format:H:i:s',
            'jam_keluar' => 'required|date_format:H:i:s',
            'status_presensi_karyawan' => 'required|in:hadir,izin,alpha',
        ]);

        $presensi = new presensi();
        $presensi->id_pegawai = $request->id_pegawai;
        $presensi->tanggal_presensi = $request->tanggal_presensi;
        $presensi->jam_masuk = $request->jam_masuk;
        $presensi->jam_keluar = $request->jam_keluar;
        $presensi->status_presensi_karyawan = $request->status_presensi_karyawan;
        $presensi->save();

        return redirect()->route('index-presensi')->with('success', 'Berhasil menambah data baru!');
    }
    public function editMo($id_presensi){
        $presensi = Presensi::findOrFail($id_presensi);
        $pegawai = pegawai::all();

        return view('mo.presensi.edit', compact('presensi', 'pegawai'));
    }
    public function update(Request $request, $id_presensi)
    {
        $request->validateWithBag('post' , [ 
            'tanggal_presensi' => 'required|date',
            'jam_masuk' => 'required|date_format:H:i:s',
            'jam_keluar' => 'required|date_format:H:i:s',
            'status_presensi_karyawan' => 'required|in:hadir,izin,alpha',
        ]);

        // Perbarui presensi berdasarkan ID yang diberikan
        $presensi = Presensi::findOrFail($id_presensi);
        $presensi->tanggal_presensi = $request->tanggal_presensi;
        $presensi->jam_masuk = $request->jam_masuk;
        $presensi->jam_keluar = $request->jam_keluar;
        $presensi->status_presensi_karyawan = $request->status_presensi_karyawan;
        $presensi->save();

        return redirect()->route('presensi.index')->with('success', 'Presensi berhasil diperbarui.');
    }
}
