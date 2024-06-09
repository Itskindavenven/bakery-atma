@extends('mo.home-mo')

@section('content')

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-center">Daftar Pegawai</h2>
        <a href="{{ route('register-pegawai') }}" class="btn btn-primary">Register Pegawai</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nama Pegawai</th>
                    <th>Email Pegawai</th>
                    <th>Username Pegawai</th>
                    <th>Jabatan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pegawai as $item)
                <tr>
                    <td><strong>{{ $item->nama_lengkap }}</strong></td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->role->nama }}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('edit-pegawai', [$item->id_pegawai]) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('destroy-pegawai', [$item->id_pegawai])}}" method="POST">
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
                        Data Pegawai masih kosong.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
