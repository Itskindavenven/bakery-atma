@extends('admin.home-admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('bahan.create') }}" class="btn btn-success btn-lg">
            <strong class="text-white">
                <span class="mr-2">+</span> Add Bahan Baku
            </strong>
        </a>
    </div>

    <form class="d-flex justify-content-end mb-3" action="{{ route('bahan.search') }}" method="GET">
        <input type="text" name="search" class="form-control mr-2" placeholder="Search" required />
        <button type="submit" class="btn btn-success">Search</button>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Nama Bahan Baku</th>
                    <th scope="col">Stock Bahan Baku</th>
                    <th scope="col">Satuan Bahan Baku</th>
                    <th scope="col">Harga Bahan Baku</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bahan as $item)
                    <tr>
                        <td><strong>{{ $item->nama }}</strong></td>
                        <td>{{ $item->stock }}</td> 
                        <td>{{ $item->satuan }}</td>
                        <td>Rp{{ number_format($item->harga, 2, ',', '.') }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('bahan.edit', $item->id_bahan) }}" class="btn btn-warning mr-2">Edit</a>
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('bahan.destroy', $item->id_bahan) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete Bahan Baku</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center alert alert-danger">
                            Data bahan baku masih kosong.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
