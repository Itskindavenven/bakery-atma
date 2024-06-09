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
            <form action="{{ route('resep.updateResep', $resep->id_resep)}}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Nama Produk</label>
                    <select name="id_produk" class="form-control">
                        <option value="">Pilih Produk</option>
                        @foreach($produk as $p)
                            <option value="{{ $p->id_produk }}" {{ (old('id_produk') ?? $id_produk) == $p->id_produk ? 'selected' : '' }}>{{ $p->nama }}</option>
                        @endforeach
                    </select>
                    @error('id_produk')
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
