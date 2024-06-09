<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\promo_point;

class PromoController extends Controller
{
    public function index()
    {
        $promo = promo_point::all();
        return response()->json([
            'status' => true,
            'data' => $promo
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_promo' => 'required|string',
            'jumlah' => 'required|numeric',
        ]);

        promo_point::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Promo created successfully.'
        ], 201);
    }

    public function show($id)
    {
        $promo = promo_point::find($id);
        if ($promo) {
            return response()->json([
                'status' => true,
                'data' => $promo
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Promo not found.'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_promo' => 'required|string',
            'jumlah' => 'required|numeric',
        ]);

        $promo = promo_point::findOrFail($id);
        $promo->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Promo updated successfully.'
        ], 200);
    }

    public function destroy($id)
    {
        $promo = promo_point::findOrFail($id);
        $promo->delete();

        return response()->json([
            'status' => true,
            'message' => 'Promo deleted successfully.'
        ], 200);
    }
}
