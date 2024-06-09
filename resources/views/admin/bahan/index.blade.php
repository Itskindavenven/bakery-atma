@extends('admin.home-admin')

@section('content')
<div class="container">
    <div class="btn-container">
        <a href="{{ route('bahan.create') }}" class="add-event-btn btn btn-block btn-success">
            <strong class="text-white" style="font-size: 24px;"><span class="plus-logo">+</span> Add Bahan Baku</strong>
        </a>
    </div>
    <form style="margin-top: 20px; float: right; margin-bottom: 20px" action="{{ route('bahan.search') }}" method="GET">
        <input type="text" name="search" required />
        <button type="submit" class="add-event-btn btn btn-block btn-success">Search</button>
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
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
                    <td><strong>{{ $item->nama}}</strong></td>
                    <td>{{ $item->stock }}</td> 
                    <td>{{ $item->satuan }}</td>
                    <td>Rp{{ number_format($item->harga, 2, ',', '.') }}</td>
                    <td>
                        <div class="btn-container">
                            <a href="{{ route('bahan.edit', $item->id_bahan) }}" class="btn btn-warning">Edit</a>
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
                    <td colspan="4" class="text-center alert alert-danger">
                        Data bahan baku masih kosong.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
