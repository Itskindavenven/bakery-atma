@extends('home')
@section('content')


<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header text-center">
                    <a href="{{ asset('images/logoWhite.png') }}" class="navbar-brand">
                        <img style="width: 10rem" src="{{ asset('images/logoWhite.png') }}" alt="logo" />
                    </a>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('transaksi.inputPengambilan', $transaksi->nomor_transaksi) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @php
                            $minDate = date('Y-m-d', strtotime('+2 days'));
                        @endphp

                        <div class="form-group mb-3">
                            <label class="form-label">Tanggal Pengambilan</label>
                            <input type="date" name="tanggal_pengambilan" class="form-control @error('tanggal_pengambilan') is-invalid @enderror"
                                value="{{ old('tanggal_pengambilan') }}" min="{{ $minDate }}">
                            @error('tanggal_pengambilan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Metode Pengambilan</label>
                            <select name="pengambilan" class="form-control @error('pengambilan') is-invalid @enderror">
                                <option value="">Pilih Metode Pengambilan</option>
                                <option value="Ambil di Toko" {{ old('pengambilan') == 'Ambil di Toko' ? 'selected' : '' }}>Ambil di Toko</option>
                                <option value="Kirim ke Alamat" {{ old('pengambilan') == 'Kirim ke Alamat' ? 'selected' : '' }}>Kirim ke Alamat</option>
                            </select>
                            @error('pengambilan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Alamat Pengantaran (Apabila Dikirim)</label>
                            <select name="alamat" class="form-control @error('alamat') is-invalid @enderror">
                                <option value="">Pilih Alamat</option>
                                @foreach($alamat as $a)
                                    <option value="{{ $a->alamat }}" {{ old('alamat') == $a->alamat ? 'selected' : '' }}>
                                        {{ $a->alamat }}
                                    </option>
                                @endforeach
                                <option value="Alamat Baru">Alamat Baru</option>
                            </select>
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Alamat Baru (Apabila bukan alamat rumah sendiri)</label>
                            <input type="text" name="alamatBaru" placeholder="Alamat Baru" class="form-control @error('alamatBaru') is-invalid @enderror"
                                value="{{ old('alamatBaru') }}">
                            @error('alamatBaru')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-block">SIMPAN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
