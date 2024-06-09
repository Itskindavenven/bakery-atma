<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\stock_produk;
use App\Models\Penitip;
use Illuminate\Support\Carbon;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = produk::with('penitip')->orderBy('nama', 'asc')->simplePaginate(10);
        $produkKurang = [];
        $tanggalTersedia = Carbon::today()->addDays(2);
        
        foreach ($produk as $r) {
            $stokSekarang = stock_produk::where('id_produk', $r->id_produk)
                ->where('tanggal_tersedia', $tanggalTersedia)
                ->value('stock');
            if ($stokSekarang <= 0) {
                $produkKurang[$r->nama_produk] = abs($stokSekarang);
            }
        }

        $message = '';
        if (! empty($produkKurang)) {
            foreach ($produkKurang as $nama_produk => $stokSekarang) {
                $message .= '[' . $nama_produk . ' kurang ' . $stokSekarang . ' ] - ';
            }
            $message = rtrim($message, ', ') . '';
        } else {
            $message = 'Semua Produk tersedia.';
        }
        
        return view('admin.produk.index', compact('produk', 'message'));
    }
    public function detail($id_produk)
    {
        $produk = Produk::where('id_produk', $id_produk)->first();

        $stokProduk = stock_produk::where('id_produk', $id_produk)->get();

        return view('admin.produk.detail', compact('produk', 'stokProduk'));
        // return response()->json([
        //     'produk'=> $produk,
        //     'stok'=> $stokProduk
        // ]);
    }
    public function detailStok(Request $request, $id_produk)
    {
        $transaksi = Transaksi::where('nomor_transaksi', $request->nomor_transaksi)->first();
        $produk = produk::where('id_produk', $id_produk)->get();
        $stokProduk = stock_produk::where('id_produk', $id_produk)->get();
        return view('customer.detailStok', compact('produk', 'stokProduk', 'transaksi'));
    }
    public function create()
    {
        $penitip = penitip::select('id_penitip', 'nama')->get();
        return view('admin.produk.create', compact('penitip'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'jenis' => 'required|string',
            'harga' => 'required|numeric',
            'id_penitip' => 'nullable',
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->jenis_produk == 'Produk Sendiri' && $request->id_penitip != 0) {
            return back()->withErrors(['jenis' => 'Produk Sendiri harus menilih Atma Kitchen sebagai penitip/penyedia']);
        }

        if ($request->jenis_produk == 'Produk Titipan' && $request->id_penitip == 0) {
            return back()->withErrors(['jenis' => ' Produk Titipan harus disesuaikan dengan nama penitip/penyedia']);
        }

        $produk = new Produk();
        $produk->nama = $request->nama;
        $produk->harga = $request->harga;
        $produk->jenis = $request->jenis;
        $produk->id_penitip = $request->id_penitip;
        // $produk->foto_produk = $request->file('foto')->store('produk', 'public');
        $produk->save();
        
        return redirect()->route('index-produk')->with('success', 'Berhasil menambah data baru!');
    }

    public function show($id)
    {
        $produk = Produk::find($id);
        if ($produk) {
            return response()->json([
                'status' => true,
                'data' => $produk
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Produk not found.'
            ], 404);
        }
    }
    public function edit($id_produk)
    {
        $produk = produk::findOrFail($id_produk);
        $id_penitip = penitip::select('id_penitip')->get();
        return view('admin.produk.edit', ['id_penitip' => $id_penitip], compact('produk'));
    }
    public function update(Request $request, $id_produk)
    {
        $request->validate([
            'nama' => 'required|string',
            'jenis' => 'required|string',
            'harga' => 'required|numeric',
            'status' => 'required|string',
            'id_penitip', 'nullable',
            'deskripsi' => 'nullable|string'
        ]);

        $produk = Produk::findOrFail($id_produk);
        $produk->update($request->all());

        return redirect()->route('admin.produk.index')->with('success', 'Berhasil mengubah data produk!');
    }
    public function editStock($id_produk)
    {
        $produk = produk::findOrFail($id_produk);
        $id_produk = $produk ? $produk->id_produk : null;
        $produk = Produk::select('id_produk', 'nama')->where('id_produk', $id_produk)->first();
        return view('admin.produk.editStock', compact('produk', 'id_produk'));
    }
    public function update_stock(Request $request, $id){
        $produk = produk::findOrFail($id);

        $request->validateWithBag('post',[
            'stock' => 'required',
            'tanggal_tersedia' => 'required'
        ]);

        $produk->id_produk = $request->id_produk;

        $existingStock = stock_produk::where('id_produk', $produk->id_produk)
                ->where('tanggal_tersedia', $request->tanggal_tersedia)->first();

        if($existingStock){
            return back()->withErrors(['tanggal_tersedia' => 'Tanggal tersebut telah diisi!']);
        }

        stock_produk::create([
            'id_produk'=> $produk->id_produk,
            'stock' => $request->stock,
            'tanggal_tersedia' => $request->tanggal_tersedia
        ]);

        $produk->save();

        return redirect()->route('index-produk')->with('success', 'Berhasil mengubah data produk!');
    }
    public function destroy_stock($id, $tanggal_tersedia){
        $produk = produk::findOrFail($id);
        $stock_produk = stock_produk::where('id_produk', $id)
                        ->where('tanggal_tersedia', $tanggal_tersedia)->delete();
        
        return redirect()->route('produk.detail', [
            'id_produk' => $produk->id_produk,
        ])->with('success', 'Berhasil menghapus Stok Produk');
    }
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Berhasil menghapus data produk!');
    }

    public function search(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string'
        ]);

        $keyword = $request->input('keyword');

        $produk = Produk::where('nama', 'like', "%$keyword%")
                        ->orWhere('jenis', 'like', "%$keyword%")
                        ->get();

        return view('admin.produk.index', compact('produk'));
    }
    public function dataProduk()
    {
        $stokProduks = stock_produk::with(['produk' => function ($query) {
            $query->select('id_produk', 'nama_produk', 'harga_produk', 'foto_produk');
        }])->get();

        return view('admin.produk.dataStokProduk', compact('stokProduks'));
    }
    public function dataProdukHome()
    {
        $today = Carbon::today()->toDateString();

        $produk = Produk::join('stock_produk', 'produk.id_produk', '=', 'stock_produk.id_produk')
                    ->where('stock_produk.tanggal_tersedia', $today)
                    ->select('produk.*', 'stock_produk.stock', 'stock_produk.tanggal_tersedia')
                    ->get();
        return view('customer.produk', compact('produk'));
    }
    public function stok($id_produk)
    {
        $produk = produk::where('id_produk', $id_produk)->get();
        $stokProduk = stock_produk::where('id_produk', $id_produk)->get();
        return view('customer.detailStok', compact('produk', 'stokProduk'));
    }
}

