@extends('home')

@section('content')
<div class="container mt-5">
    <div class="text-center mb-4">
        <a href="{{ url('dataStokProduk') }}" class="btn btn-primary btn-lg">
            <strong class="text-white"><span class="glyphicon glyphicon-plus"></span> Back</strong>
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Produk Stok</h4>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Tanggal Tersedia</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produk as $item)
                        @php
                            $stokItems = $stokProduk->filter(function($stok) use ($item) {
                                return $stok->produk_id == $item->id;
                            });
                        @endphp
                        @forelse ($stokItems as $stok)
                            <tr>
                                <td><strong>{{ $item->nama }}</strong></td>
                                <td>{{ $stok->stock }}</td>
                                <td>{{ $stok->tanggal_tersedia }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center alert alert-danger">
                                    Detail data Stok Produk masih kosong.
                                </td>
                            </tr>
                        @endforelse
                    @empty
                        <tr>
                            <td colspan="3" class="text-center alert alert-danger">
                                Data produk masih kosong.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
