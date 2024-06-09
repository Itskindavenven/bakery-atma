<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penitip;

class PenitipController extends Controller
{
    public function index()
    {
        $penitip = Penitip::all();
        return response()->json([
            'status' => true,
            'data' => $penitip
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'no_telp' => 'required'
        ]);

        $penitip = Penitip::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Penitip created successfully.',
            'data' => $penitip
        ], 201);
    }

    public function show($id)
    {
        $penitip = Penitip::find($id);
        if ($penitip) {
            return response()->json([
                'status' => true,
                'data' => $penitip
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Penitip not found.'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'no_telp' => 'required'
        ]);

        $penitip = Penitip::find($id);
        if ($penitip) {
            $penitip->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Penitip updated successfully.',
                'data' => $penitip
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Penitip not found.'
            ], 404);
        }
    }

    public function destroy($id)
    {
        $penitip = Penitip::find($id);
        if ($penitip) {
            $penitip->delete();
            return response()->json([
                'status' => true,
                'message' => 'Penitip deleted successfully.'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Penitip not found.'
            ], 404);
        }
    }
}
