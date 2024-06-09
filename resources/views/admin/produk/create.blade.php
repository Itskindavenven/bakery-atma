@extends('admin.home-admin')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Tambah Produk Baru</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('store-produk') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
        </div>
        <div class="mb-3">
            <label for="jenis" class="form-label">Jenis Produk</label>
            <select class="form-control" id="jenis" name="jenis" required>
                <option value="">Pilih Jenis Produk</option>
                <option value="Produk Sendiri" {{ old('jenis') == 'Produk Sendiri' ? 'selected' : '' }}>Produk Sendiri</option>
                <option value="Produk Titipan" {{ old('jenis') == 'Produk Titipan' ? 'selected' : '' }}>Produk Titipan</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga Produk</label>
            <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga') }}" required>
        </div>
        <div class="form-group">
            <label for="foto">Foto Produk</label>
            <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto">
            @error('foto_produk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="id_penitip" class="form-label">Penitip</label>
            <select class="form-control" id="id_penitip" name="id_penitip">
                <option value="">Atma Kitchen</option>
                @foreach($penitip as $item)
                    <option value="{{ $item->id_penitip }}" {{ old('id_penitip') == $item->id_penitip ? 'selected' : '' }}>{{ $item->nama_penitip }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Produk</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('index-produk') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
