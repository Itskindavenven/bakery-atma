@extends('home')
@section('content')

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Pembayaran</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label class="form-label">Nomer Transaksi:</label>
                <p>{{ $transaksi->nomor_transaksi }}</p>
            </div>
            <div class="form-group">
                <label class="form-label">Nama Customer:</label>
                <p>{{ session('customer')->nama_customer }}</p>
            </div>
            <div class="form-group">
                <label class="form-label">Produk/Hampers:</label>
                <ul>
                    @foreach($produk as $p)
                        <li>{{ $p->nama_produk }}</li>
                    @endforeach
                    @foreach($hampers as $h)
                        <li>{{ $h->nama_hampers }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="form-group">
                <label class="form-label">Jumlah:</label>
                <ul>
                    @foreach($transaksi->keranjang as $keranjang)
                        <li>{{ $keranjang->jumlah_produk }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="form-group">
                <label class="form-label">Subtotal Produk/Hampers:</label>
                <ul>
                    @foreach($transaksi->keranjang as $keranjang)
                        <li>Rp{{ number_format($keranjang->subtotal, 2, ',', '.') }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Pemesanan:</label>
                <p>{{ $transaksi->tanggal_pemesanan }}</p>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Pengambilan:</label>
                <p>{{ $transaksi->tanggal_pengambilan }}</p>
            </div>
            <div class="form-group">
                <label class="form-label">Metode Pengambilan:</label>
                <p>{{ $transaksi->pengambilan }}</p>
            </div>
            <div class="form-group">
                <label class="form-label">Alamat:</label>
                <p>{{ $transaksi->alamat }}</p>
            </div>
            <div class="form-group">
                <label class="form-label">Ongkir:</label>
                <p>Rp{{ number_format($transaksi->ongkir, 2, ',', '.')}}</p>
            </div>
            <div class="form-group">
                <label class="form-label">Total Harga:</label>
                <p>Rp{{ number_format($transaksi->total_harga, 2, ',', '.')}}</p>
            </div>
            <div class="form-group">
                <label class="form-label">Poin:</label>
                <p>{{ $transaksi->poin }}</p>
            </div>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('transaksi.inputPembayaran', $transaksi->nomor_transaksi)}}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Penggunaan Poin (Opsional)</label>
                    <input type="number" name="penggunaanPoin" placeholder="Poin yang akan Digunakan"
                        class="form-control @error('penggunaanPoin') is-invalid @enderror" value="{{ old('penggunaanPoin') }}">
                    @error('penggunaanPoin')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                        <label class="form-label">Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran" class="form-control"
                            value="{{ old('bukti_pembayaran') }}">
                        @error('bukti_pembayaran')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                <div class="form-group">
                    <label class="form-label">Nominal Pembayaran</label>
                    <input type="number" name="uangDiterima" placeholder="Nominal Pembayaran"
                        class="form-control @error('uangDiterima') is-invalid @enderror" value="{{ old('uangDiterima') }}">
                    @error('uangDiterima')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group-button mt-5">
                    <button type="submit" class="btn btn-primary btn-block">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
