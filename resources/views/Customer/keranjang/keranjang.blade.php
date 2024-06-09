@extends('home')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4 text-center">Detail Pesanan</h2>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between mb-4">
                <a href="{{ route('transaksi.tambahProduk', $pesanan->nomor_transaksi) }}" class="btn btn-primary">
                    <strong class="text-white"><span class="plus-logo">+</span> Tambah Produk/Hampers</strong>
                </a>
                <a href="{{ route('transaksi.tambahPengambilan', $pesanan->nomor_transaksi) }}" class="btn btn-warning">
                    <strong class="text-white"><span class="plus-logo">+</span> Checkout</strong>
                </a>
            </div>

            <div class="mb-3">
                <form action="{{ route('transaksi.search') }}" method="GET" class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari produk..." required />
                    <button type="submit" class="btn btn-outline-secondary">Cari</button>
                </form>
            </div>

            @foreach($keranjang as $item)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->id_produk ? $item->produk->nama : $item->hampers->nama_hampers }}</h5>
                        <p class="card-text">Jumlah: {{ $item->jumlah_produk }}</p>
                        <p class="card-text">Harga: Rp{{ number_format($item->subtotal, 2, ',', '.') }}</p>
                        <form onsubmit="return confirm('Apakah Anda Yakin Akan Menghapus Item Ini?');" 
                              action="{{ route('transaksi.kurangi', ['nomor_transaksi' => $item->nomor_transaksi]) }}" 
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id_produk" value="{{ $item->id_produk }}">
                            <input type="hidden" name="id_hampers" value="{{ $item->id_hampers }}">
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-center my-4">
                <form onsubmit="return confirm('Apakah Anda Yakin Akan Membatalkan Pesanan?');" 
                      action="{{ route('transaksi.destroy', $pesanan->nomor_transaksi) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Batalkan Pesanan</button>
                </form>
            </div>

            <div class="text-center mt-5">
                <h5>Total Harga: <span class="badge bg-success">Rp{{ number_format($pesanan->total_harga, 2, ',', '.') }}</span></h5>
                <h5>Total Poin: <span class="badge bg-primary">{{ $pesanan->poin }}</span></h5>
            </div>
        </div>
    </div>
</div>
@endsection
