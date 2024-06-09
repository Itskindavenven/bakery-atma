@extends('mo.home-mo')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-center">Daftar Role</h2>
        <a href="{{ route('create-role') }}" class="btn btn-primary">Tambah Role</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID Role</th>
                    <th>Nama Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($role as $item)
                <tr>
                    <td>{{ $item->id_role }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('edit-role', [$item->id_role]) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('destroy-role', [$item->id_role])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center alert alert-danger">
                        Data Role masih kosong.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
