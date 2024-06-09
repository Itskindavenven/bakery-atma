@extends('home')
@section('content')

<div class="container mt-5">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama Produk/Hampers</th>
                <th>Harga Produk/Hampers</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($produk as $item)
                <tr>
                    <td><strong>{{ $item->nama }}</strong></td>
                    <td>Rp{{ number_format($item->harga, 2, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('produk.detailStok', ['id_produk' => $item->id_produk]) }}" method="POST">
                            @csrf
                            @method('GET')
                            <input type="hidden" name="nomor_transaksi" value="{{ $transaksi->nomor_transaksi }}">
                            <button type="submit" class="btn btn-primary">Detail Stok</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center alert alert-danger">
                        Data Produk masih kosong.
                    </td>
                </tr>
            @endforelse
            @forelse ($hampers as $item)
                <tr>
                    <td><strong>{{ $item->nama }}</strong></td>
                    <td>Rp{{ number_format($item->harga, 2, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('hampers.detailStok', ['id_hampers' => $item->id_hampers]) }}" method="POST">
                            @csrf
                            @method('GET')
                            <input type="hidden" name="nomor_transaksi" value="{{ $transaksi->nomor_transaksi }}">
                            <button type="submit" class="btn btn-primary">Detail Stok</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center alert alert-danger">
                        Data hampers masih kosong.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="row mt-5">
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

                    <form action="{{ route('transaksi.inputProduk', $transaksi->nomor_transaksi) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label class="form-label">Nama Produk (Pilih Antara Produk atau Hampers)</label>
                            <select name="id_produk" class="form-control @error('id_produk') is-invalid @enderror">
                                <option value="">Pilih Produk</option>
                                @foreach($produk as $p)
                                    <option value="{{ $p->id_produk }}" {{ old('id_produk') == $p->id_produk ? 'selected' : '' }}>
                                        {{ $p->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_produk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Nama Hampers (Pilih Antara Produk atau Hampers)</label>
                            <select name="id_hampers" class="form-control @error('id_hampers') is-invalid @enderror">
                                <option value="">Pilih Hampers</option>
                                @foreach($hampers as $h)
                                    <option value="{{ $h->id_hampers }}" {{ old('id_hampers') == $h->id_hampers ? 'selected' : '' }}>
                                        {{ $h->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_hampers')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" class="form-control @error('jumlah_produk') is-invalid @enderror"
                                name="jumlah_produk" value="{{ old('jumlah_produk') }}" placeholder="Jumlah yang dipesan">
                            @error('jumlah_produk')
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
