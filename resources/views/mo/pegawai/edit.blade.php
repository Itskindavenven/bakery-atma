@extends('mo.home-mo')
@section('content')
<style>
    body,
    html {
        height: 100%;
        background-repeat: no-repeat;
        background: black;
        position: relative;
        background-image: url('/img/atmabakery.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        font-family: 'Nunito', sans-serif;
    }

    .card {
        border: none;
        border-radius: 10px;
        background: rgba(48, 46, 45, 0.85);
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .card-body {
        color: white;
    }

    .card-footer {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .form-control {
        border-radius: 5px;
        background: rgb(98, 96, 96);
        border: 0px;
        color: white;
        margin-bottom: 10px;
    }

    .form-control:focus {
        box-shadow: none;
    }

    .invalid-feedback {
        color: #ff5252;
    }

    .btn-success {
        background-color: #ff5252;
        border-color: #ff5252;
    }

    .btn-success:hover {
        background-color: rgba(48, 46, 45, 1);
        border-color: #ff5252;
    }

    .text-muted a {
        color: #ff5252;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Atma Bakery - Edit Pegawai</h4>
                </div>
                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{ route('update-pegawai', $pegawai->id_pegawai) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="nama_pegawai">Nama Lengkap</label>
                            <input class="form-control" type="text" name="nama_lengkap" placeholder="Nama Lengkap" required value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="username_pegawai">Username</label>
                            <input class="form-control" type="text" name="username_pegawai" placeholder="Username" required value="{{ old('username_pegawai', $pegawai->username) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir) }}" placeholder="Enter Tanggal Lahir">
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="email_pegawai">Email</label>
                            <input class="form-control" type="email" name="email_pegawai" placeholder="Email" required value="{{ old('email_pegawai', $pegawai->email) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="id_role">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id_role }}" {{ $pegawai->id_role == $role->id_role ? 'selected' : '' }}>{{ $role->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-user"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p class="text-muted">
                        Cancel? <a href="{{ route('index-pegawai') }}" class="text-decoration-none" style="color: #ff5252;">Back</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
