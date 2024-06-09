@extends('admin.home-admin')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <a href="{{asset('images\logoWhite.png')}}" class="navbar-brand">
                <img style="width: 10rem" src="{{asset('images\logoWhite.png')}}" alt="logo" />
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('bahan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Bahan Baku</label>
                    <input type="text" class="form-control @error('nama_bahan_baku') is-invalid @enderror"
                        name="nama_bahan_baku" value="{{ old('nama_bahan_baku') }}"
                        placeholder="Enter Nama Bahan Baku">
                    @error('nama_bahan_baku')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Jumlah Bahan Baku</label>
                    <input type="text" class="form-control @error('jumlah_bahan_baku') is-invalid @enderror"
                        name="jumlah_bahan_baku" value="{{ old('jumlah_bahan_baku') }}"
                        placeholder="Enter Jumlah Bahan Baku">
                    @error('jumlah_bahan_baku')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Satuan</label>
                    <select class="form-control @error('satuan') is-invalid @enderror" name="satuan"
                        id="inputGroupSelect02" value="{{ old('satuan') }}">
                        <option selected>Pilih</option>
                        <option value="Gram">Gram</option>
                        <option value="Butir">Butir</option>
                        <option value="Buah">Buah</option>
                        <option value="Ml">Ml</option>
                    </select>
                    @error('satuan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Harga Bahan Baku</label>
                    <input type="text" class="form-control @error('harga_bahan_baku') is-invalid @enderror"
                        name="harga_bahan_baku" value="{{ old('harga_bahan_baku') }}"
                        placeholder="Enter Harga Bahan">
                    @error('harga_bahan_baku')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group-button">
                    <button type="submit" class="btn btn-primary btn-block">SIMPAN</button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
