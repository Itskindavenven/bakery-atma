@extends('admin.home-admin')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('produk.updateStok', $produk->id_produk)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Stok</label>
                    <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock') }}" placeholder="Enter Stok">
                    @error('stock')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Tersedia</label>
                    <input type="date" class="form-control @error('tanggal_tersedia') is-invalid @enderror" name="tanggal_tersedia" value="{{ old('tanggal_tersedia') }}" min="{{ date('Y-m-d') }}" placeholder="Enter Tanggal Tersedia">
                    @error('tanggal_tersedia')
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
