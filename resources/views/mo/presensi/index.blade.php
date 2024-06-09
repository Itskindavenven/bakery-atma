@extends('mo.home-mo')

@section('content')

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-center">Daftar Presensi</h2>
        <a href="{{ route('create-presensi') }}" class="btn btn-primary">Buat Presensi</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nama Pegawai</th>
                    <th>tanggal presensi</th>
                    <th>jam masuk</th>
                    <th>jam keluar</th>
                    <th>status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($presensi as $item)
                <tr>
                    <td><strong>{{ $item->nama_lengkap }}</strong></td>
                    <td>{{ $item->tanggal_presensi}}</td>
                    <td>{{ $item->jam_masuk }}</td>
                    <td>{{ $item->jam_keluar }}</td>
                    <td>{{ $item->status_presensi}}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('edit-presensi', [$item->id_presensi]) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('destroy-presensi', [$item->id_presensi])}}" method="POST">
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
                        Data Presensi masih kosong.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
