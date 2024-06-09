<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index(){
        $role = Role::all();
        return view('mo.role.index', compact('role'));
    }
    public function create(){
        return view('mo.role.create');
    }
    public function store(Request $request){
        $request->validate([
            'nama' => 'required'
        ]);

        $role = new Role();
        $role->nama = $request->nama;
        $role->save();

        return redirect()->route('index-role')->with('success', 'Berhasil menambah data baru!');
    }
    public function edit($id_role){
        $role = Role::findOrFail($id_role);
        return view('mo.role.edit', compact('role'));
    }
    public function update(Request $request, $id_role){
        $role = Role::findOrFail($id_role);

        $request->validate([
            'nama' => 'required'
        ]);

        $role->nama = $request->nama;
        $role->save();

        return redirect()->route('index-role')->with('success', 'Berhasil update data baru!');
    }
    public function destroy($id_role){
        $role = Role::findOrFail($id_role);
        $role->delete();

        return redirect()->route('index-role')->with('success', 'Berhasil menghapus data baru!');
    }
}
