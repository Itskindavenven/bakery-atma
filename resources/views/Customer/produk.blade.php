@extends('home')

@section('content')
<div class="container mt-5">
    <div class="row">
        @forelse ($produk as $item)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($item->foto_produk)
                        <img class="card-img-top" src="{{ asset('images/' . $item->foto_produk) }}" alt="Foto Produk" style="width: 100%; height: 250px; object-fit: cover;">
                    @else
                        <img class="card-img-top" src="https://via.placeholder.com/250" alt="Foto Produk" style="width: 100%; height: 250px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->nama }}</h5>
                        <p class="card-text">Rp{{ number_format($item->harga, 2, ',', '.') }}</p>
                        <form action="{{ route('produk.stok', ['id_produk' => $item->id_produk]) }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-block">Detail Stok</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-danger text-center" role="alert">
                    Data Produk masih kosong.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
