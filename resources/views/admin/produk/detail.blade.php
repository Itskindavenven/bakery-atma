@extends('admin.produk.detail')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Detail Produk</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3>{{ $produk->nama }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Jenis:</strong> {{ $produk->jenis }}</p>
            <p><strong>Harga:</strong> Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
            <p><strong>Penitip:</strong> {{ $produk->id_penitip == 0 ? 'Atma Kitchen' : $produk->penitip->nama_penitip }}</p>
            <p><strong>Deskripsi:</strong> {{ $produk->deskripsi }}</p>
        </div>
    </div>

    <h4 class="mt-4">Stok Produk</h4>
    <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Stok</th>
                    <th>Tanggal Tersedia</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produk as $item)
                    @forelse ($stokProduk as $stok)
                        <tr>
                            <td><strong>{{ $item->nama_produk }}</strong></td>
                            <td>{{ $stok->stok }}</td>
                            <td>{{ $stok->tanggal_tersedia }}</td>
                            <td>
                                <form onsubmit="return confirm('Apakah Anda Yakin akan menghapus Stok Produk ini?');"
                                    action="{{ route('produk.kurangi', ['id_produk' => $item->id_produk, 'tanggal_tersedia' => $stok->tanggal_tersedia]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete Stok</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <td colspan="4" class="text-center alert alert-danger">
                            Detail data Stok Produk masih kosong.
                        </td>
                    @endforelse
                @empty
                    <tr>
                        <td colspan="4" class="text-center alert alert-danger">
                            Detail data Stok Produk masih kosong.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    <a href="{{ route('index-produk') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
