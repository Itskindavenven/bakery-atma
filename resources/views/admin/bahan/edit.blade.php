@extends('admin.home-admin')

@section('content')
<div class="card-body">
    <form action="{{ route('bahan.update', $bahan->id_bahan) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label class="form-label">Nama Bahan Baku</label>
            <input type="text" class="form-control @error('nama_bahan_baku') is-invalid @enderror" name="nama_bahan_baku" value="{{ old('nama_bahan_baku', $bahan->nama_bahan_baku) }}" placeholder="Enter Nama Bahan Baku">
            @error('nama_bahan_baku')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Jumlah Bahan Baku</label>
            <input type="text" class="form-control @error('jumlah_bahan_baku') is-invalid @enderror" name="jumlah_bahan_baku" value="{{ old('jumlah_bahan_baku', $bahan->jumlah_bahan_baku) }}" placeholder="Enter Jumlah Bahan Baku">
            @error('jumlah_bahan_baku')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Satuan</label>
            <select class="form-control @error('satuan') is-invalid @enderror" name="satuan" id="inputGroupSelect02">
                <option selected>Pilih</option>
                <option value="Gram" {{ old('satuan', $bahan->satuan) == 'Gram' ? 'selected' : '' }}>Gram</option>
                <option value="Butir" {{ old('satuan', $bahan->satuan) == 'Butir' ? 'selected' : '' }}>Butir</option>
                <option value="Buah" {{ old('satuan', $bahan->satuan) == 'Buah' ? 'selected' : '' }}>Buah</option>
                <option value="Ml" {{ old('satuan', $bahan->satuan) == 'Ml' ? 'selected' : '' }}>Ml</option>
            </select>
            @error('satuan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Harga Bahan Baku</label>
            <input type="text" class="form-control @error('harga_bahan_baku') is-invalid @enderror" name="harga_bahan_baku" value="{{ old('harga_bahan_baku', $bahan->harga_bahan_baku) }}" placeholder="Enter Harga Bahan">
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
@endsection
