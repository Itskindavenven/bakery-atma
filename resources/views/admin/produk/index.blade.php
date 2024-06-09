@extends('admin.home-admin')
@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Daftar Produk</h2>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-3">
                <a href="{{ route('create-produk') }}" class="btn btn-primary">Tambah Produk</a>
            </div>
            <div class="mb-3 mt-5">
                <form action="{{ route('search-produk') }}" method="GET" class="d-flex">
                    <input type="text" name="keyword" class="form-control me-2" placeholder="Cari produk...">
                    <button type="submit" class="btn btn-outline-secondary">Cari</button>
                </form>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Harga</th>
                        <th>Foto Produk</th>
                        <th>Penitip</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produk as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jenis }}</td>
                            <td>{{ $item->harga }}</td>
                            <td>
                                @if($item->foto_produk)
                                    <a href="{{ asset('storage/' . $item->foto_produk) }}" target="_blank">
                                        <img style="border-radius: 50%; width: 180px; height: 180px;" src="{{ asset('storage/' . $item->foto_produk) }}"
                                            alt="Foto Produk">
                                    </a>
                                @else
                                    Belum ada Foto
                                @endif
                            </td>
                            <td>{{ $item->penitip->nama ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('detail-produk', $item->id_produk) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('edit-produk', $item->id_produk) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('destroy-produk', $item->id_produk) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus produk ini?')">Hapus</button>
                                </form>
                                <a href="{{ route('editStock-produk', $item->id_produk) }}" class="btn btn-secondary btn-sm">Edit Stok</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{ $produk->links() }}
            </div>
        </div>
    </div>
</div>
@endsection