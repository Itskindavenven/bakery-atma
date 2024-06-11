@extends('admin.home-admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('resep.create') }}" class="btn btn-success btn-lg">
            <strong class="text-white">
                <span class="mr-2">+</span> Add Resep 
            </strong>
        </a>
    </div>

    <form class="d-flex justify-content-end mb-3" action="{{ route('resep.search') }}" method="GET">
        <input type="text" name="search" class="form-control mr-2" placeholder="Search" required />
        <button type="submit" class="btn btn-success">Search</button>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>ID Resep</th>
                    <th>Nama Produk</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($resep as $item)
                    <tr>
                        <td><strong>{{ $item->id_resep }}</strong></td>
                        <td>{{ $item->produk->nama }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('resep.detail', $item->id_resep) }}" class="btn btn-primary mr-2">Detail Resep</a>
                                <a href="{{ route('resep.edit', $item->id_resep) }}" class="btn btn-warning mr-2">Tambah Bahan Baku & Produk</a>
                                <a href="{{ route('resep.editResep', $item->id_resep) }}" class="btn btn-warning mr-2">Edit Resep</a>
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('resep.destroy', $item->id_resep)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus data resep</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center alert alert-danger">Data Resep masih kosong.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
