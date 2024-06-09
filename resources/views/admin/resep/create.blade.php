@extends('admin.home-admin')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Tambah Resep</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('resep.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="id_produk" class="form-label">Nama Produk</label>
                <select name="id_produk" id="id_produk" class="form-control">
                    <option value="">Pilih Produk</option>
                    @foreach($produk as $p)
                        <option value="{{ $p->id_produk }}">{{ $p->nama }}</option>
                    @endforeach
                </select>
                @error('id_produk')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">SIMPAN</button>
            </div>
        </form>
    </div>
</div>

@endsection
