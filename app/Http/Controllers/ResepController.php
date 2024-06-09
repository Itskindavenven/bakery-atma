<?php

namespace App\Http\Controllers;

use App\Models\bahan_baku;
use App\Models\customer;
use App\Models\pembayaran;
use App\Models\produk;
use App\Models\Resep;
use App\Models\resep_bahan;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class ResepController extends Controller
{
    public function index()
    {
        $resep = Resep::with('produk')->latest('id_resep')->paginate(10);

        return view('admin.resep.index', compact('resep'));
    }

    public function detail($id_resep)
    {
        $resep = resep::with('produk')->where('id_resep', $id_resep)->get();
        $produk = produk::where('id_produk', $resep->pluck('id_produk'))->get();
        $bahanResep = resep_bahan::where('id_resep', $id_resep)->get();
        $bahanBaku = bahan_baku::whereIn('id_bahan', $bahanResep->pluck('id_bahan'))->get();
        return view('admin.resep.detailresep', compact('resep', 'bahanResep', 'produk', 'bahanBaku'));
    }

    public function create()
    {
        $produk = produk::select('id_produk', 'nama')->where('jenis', 'Produk Sendiri')->get();
        return view('admin.resep.create', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validateWithBag('post', [
            'id_produk' => 'required',
        ]);

        resep::create([
            'id_produk' => $request->id_produk,
        ]);

        return redirect()->route('resep.index')->with('success', 'Berhasil menambah resep baru!');
    }

    public function edit($id_resep)
    {
        $resep = resep::findOrFail($id_resep);
        $bahanBaku = bahan_baku::select('id_bahan', 'nama')->get();
        $produk = Produk::select('id_produk', 'nama')->where('jenis', 'Produk Sendiri')->get();
        $bahanResep = resep_bahan::where('id_resep', $id_resep)->first();
        $id_produk = $resep ? $resep->id_produk : null;
        $id_bahan_baku = $bahanResep ? $bahanResep->id_bahan_baku : null;

        return view('admin.resep.edit', compact('resep', 'produk', 'id_produk', 'bahanBaku', 'id_bahan_baku'));
    }

    public function update(Request $request, $id_resep)
    {
        $resep = resep::findOrFail($id_resep);

        $request->validateWithBag('post', [
            'id_produk' => 'required',
            'id_bahan_baku' => 'required',
            'kuantitas' => 'required',
            'satuan' => 'required',
        ]);

        $resep->id_produk = $request->id_produk;

        resep_bahan::create([
            'id_resep' => $resep->id_resep,
            'id_bahan' => $request->id_bahan_baku,
            'jumlah' => $request->kuantitas,
            'satuan' => $request->satuan,
        ]);

        $resep->save();

        return redirect()->route('resep.index')->with('success', 'Berhasil mengubah data resep!');
    }

    public function editResep($id_resep)
    {

        $resep = resep::findOrFail($id_resep);
        $produk = Produk::select('id_produk', 'nama')->where('jenis', 'Produk Sendiri')->get();
        $bahanResep = resep_bahan::where('id_resep', $id_resep)->first();
        $id_produk = $resep ? $resep->id_produk : null;

        return view('admin.resep.editResep', compact('resep', 'produk', 'id_produk'));
    }

    public function updateResep(Request $request, $id_resep)
    {
        $resep = resep::findOrFail($id_resep);

        $request->validateWithBag('post', [
            'id_produk' => 'required',
        ]);

        $resep->id_produk = $request->id_produk;
        $resep->save();

        return redirect()->route('resep.index')->with('success', 'Berhasil mengubah data resep!');
    }

    public function destroy($id_resep)
    {
        $resep = resep::findOrFail($id_resep);
        resep_bahan::where('id_resep', $id_resep)->delete();
        $resep->delete();

        return redirect()->route('resep.index')->with('success', 'Berhasil menghapus data resep!');
    }

    public function kurangi($id_bahan_baku)
    {
        resep_bahan::where('id_bahan_baku', $id_bahan_baku)->delete();
        $id_resep = resep_bahan::where('id_bahan_baku', $id_bahan_baku)->pluck('id_resep');
        $resep = resep::whereIn('id_resep', $id_resep)->get();
        $bahanResep = resep_bahan::whereIn('id_resep', $id_resep)->get();
        $bahanBaku = bahan_baku::whereIn('id_bahan_baku', $bahanResep->pluck('id_bahan_baku'))->get();
        $produk = produk::whereIn('id_produk', $bahanResep->pluck('id_produk'))->get();

        if (! $resep->isEmpty() && ! $bahanBaku->isEmpty()) {
            return redirect()->route('resep.detail', [
                'id_resep' => $id_resep->first(),
                'nama_produk' => $produk->first()->nama,
                'nama_bahan_baku' => $bahanBaku->first()->nama,
                'kuantitas' => $bahanResep->first()->kuantitas,
                'satuan' => $bahanResep->first()->satuan,

            ])->with('success', 'Berhasil menghapus bahan baku dari resep!');
        } else {
            return back()->with('error', 'Tidak dapat menemukan resep atau bahan baku dengan id yang diberikan.');
        }
    }
    public function search(Request $request)
    {
        $search = $request->get('search');

        $resep = Resep::whereHas('produk', function ($query) use ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        })->with([
                    'produk' => function ($query) use ($search) {
                        $query->where('nama', 'like', '%' . $search . '%');
                    }
                ])->paginate(10);

        return view('resep.index', compact('resep'));
    }
    public function kurangiBahan($id_produk)
    {
        // Temukan produk berdasarkan id_produk
        $produk = Produk::find($id_produk);

        // Pastikan produk ditemukan
        if (!$produk) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }

        // Daftar bahan dan jumlah yang harus dikurangi
        $bahanList1 = [
            'Tepung Terigu' => 250,
            'Gula Pasir' => 200,
            'Telur' => 4,
            'Susu Cair' => 200,
            'Baking Powder' => 5,
            'Vanili' => 3,
            'Garam' => 2,
            'Minyak Goreng' => 100
        ];

        $bahanList2 = [
            'Tepung Beras' => 250,
            'Gula Pasir' => 200,
            'Santan' => 700,
            'Pasta Pandan' => 5,
            'Garam' => 5
        ];

        // Pilih bahanList berdasarkan id_produk
        $bahanList = $id_produk == 1 ? $bahanList1 : $bahanList2;

        // Daftar bahan yang kurang
        $bahanKurang = [];

        // Kurangi bahan baku
        foreach ($bahanList as $nama_bahan => $jumlah) {
            $bahanBaku = bahan_baku::where('nama', $nama_bahan)->first();
            if ($bahanBaku) {
                $bahanBaku->stock -= $jumlah; // Mengurangi jumlah bahan baku berdasarkan kuantitas dalam daftar
                $bahanBaku->save();

                // Jika jumlah bahan baku menjadi negatif, tambahkan ke daftar bahan yang kurang
                if ($bahanBaku->stock < 0) {
                    $bahanKurang[$nama_bahan] = abs($bahanBaku->stock);
                }
            }
        }

        // Temukan transaksi yang terkait dengan produk ini
        $transaksi = Transaksi::whereHas('keranjang', function ($query) use ($id_produk) {
            $query->where('status', 'Sudah bayar. Menunggu Konfirmasi')->where('id_produk', $id_produk);
        })->first();

        // Pastikan transaksi ditemukan
        if (!$transaksi) {
            return back()->with('error', 'Transaksi tidak ditemukan.');
        }

        // Perbarui status transaksi
        $transaksi->status = 'Dikonfirmasi';
        $transaksi->save();

        // Temukan customer yang terkait dengan transaksi ini
        $customer = customer::find($transaksi->id_customer);

        // Pastikan customer ditemukan
        if (!$customer) {
            return back()->with('error', 'Customer tidak ditemukan.');
        }

        // Tambahkan poin transaksi ke saldo poin customer
        $customer->poin += $transaksi->poin;
        $customer->save();

        // Jika ada bahan yang kurang, tampilkan dalam pesan sukses
        $message = 'Transaksi berhasil dikonfirmasi dan poin telah ditambahkan.';
        if (!empty($bahanKurang)) {
            $message .= ' Namun, beberapa bahan kurang: ';
            foreach ($bahanKurang as $nama_bahan => $jumlah) {
                $message .= $nama_bahan . ' kurang ' . $jumlah . ' gr, ';
            }
            $message = rtrim($message, ', ') . '.';
        }

        return redirect()->route('konfirmasiPesanan')->with('success', $message);
    }



    public function tolakPesanan($nomor_transaksi)
    {
        // Temukan transaksi berdasarkan nomor_transaksi
        $transaksi = Transaksi::where('nomor_transaksi', $nomor_transaksi)->first();

        // Pastikan transaksi ditemukan
        if (!$transaksi) {
            return back()->with('error', 'Transaksi tidak ditemukan.');
        }

        // Ubah status transaksi menjadi 'Ditolak'
        $transaksi->status = 'Ditolak';
        $transaksi->save();

        // Temukan pembayaran yang terkait dengan transaksi ini
        $pembayaran = pembayaran::where('nomor_transaksi', $nomor_transaksi)->first();

        // Pastikan pembayaran ditemukan
        if (!$pembayaran) {
            return back()->with('error', 'Pembayaran tidak ditemukan.');
        }

        // Temukan customer yang terkait dengan transaksi ini
        $customer = Customer::find($transaksi->id_customer);

        // Pastikan customer ditemukan
        if (!$customer) {
            return back()->with('error', 'Customer tidak ditemukan.');
        }

        // Tambahkan uang yang diterima ke saldo customer
        $customer->saldo += $pembayaran->uang_diterima;
        $customer->save();

        return redirect()->route('konfirmasiPesanan')->with('success', 'Transaksi berhasil ditolak dan uang telah dikembalikan ke saldo customer.');
    }
}
