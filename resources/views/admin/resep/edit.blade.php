@extends('admin.home-admin')

@section('content')

<div class="card-body">
    <form action="{{ route('resep.update', $resep->id_resep) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Nama Produk</label>
            <select name="id_produk" class="form-control" disabled>
                <option value="">Pilih Produk</option>
                @foreach($produk as $p)
                <option value="{{ $p->id_produk }}" {{ (old('id_produk') ?? $id_produk) == $p->id_produk ? 'selected' : '' }}>
                    {{ $p->nama }}
                </option>
                @endforeach
            </select>
            <input type="hidden" name="id_produk" value="{{ old('id_produk') ?? $id_produk }}">
            @error('id_produk')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Nama Bahan</label>
            <select name="id_bahan_baku" class="form-control">
                <option value="">Pilih Bahan Baku</option>
                @foreach($bahanBaku as $b)
                <option value="{{ $b->id_bahan }}" {{ old('id_bahan', $id_bahan_baku) == $b->id_bahan? 'selected' : '' }}>
                    {{ $b->nama }}
                </option>
                @endforeach
            </select>
            @error('id_bahan_baku')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Kuantitas Bahan Baku</label>
            <input type="number" class="form-control @error('kuantitas') is-invalid @enderror" name="kuantitas"
                value="{{ old('kuantitas') }}" placeholder="Enter Kuantitas Bahan Baku">
            @error('kuantitas')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Satuan</label>
            <select class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="{{ old('satuan') }}">
                <option value="" selected disabled>Pilih Satuan Bahan</option>
                <option value="Gram" {{ old('satuan') == 'Gram' ? 'selected' : '' }}>Gram</option>
                <option value="Butir" {{ old('satuan') == 'Butir' ? 'selected' : '' }}>Butir</option>
                <option value="Buah" {{ old('satuan') == 'Buah' ? 'selected' : '' }}>Buah</option>
                <option value="Ml" {{ old('satuan') == 'Ml' ? 'selected' : '' }}>Ml</option>
            </select>
            @error('satuan')
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
