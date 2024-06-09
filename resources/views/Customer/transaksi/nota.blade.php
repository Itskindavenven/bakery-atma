@extends('home')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Detail Transaksi</h3>
        </div>
        <div class="card-body">
            <div class="form-group mb-3">
                <label class="form-label">Nomer Transaksi:</label>
                <p>{{ $transaksi->nomor_transaksi }}</p>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Nama Customer:</label>
                <p>{{ session('customer')->nama }}</p>
                <label class="form-label">Email Customer:</label>
                <p>{{ session('customer')->email }}</p>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Produk/Hampers:</label>
                <ul>
                    @foreach($produk as $p)
                        <li>{{ $p->nama }}</li>
                    @endforeach
                    @foreach($hampers as $h)
                        <li>{{ $h->nama }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Jumlah:</label>
                <ul>
                    @foreach($transaksi->keranjang as $keranjang)
                        <li>{{ $keranjang->jumlah_produk }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Subtotal Produk/Hampers:</label>
                <ul>
                    @foreach($transaksi->keranjang as $keranjang)
                        <li>Rp{{ number_format($keranjang->subtotal, 2, ',', '.') }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Tanggal Pemesanan:</label>
                <p>{{ $transaksi->tanggal_pemesanan }}</p>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Tanggal Pengambilan:</label>
                <p>{{ $transaksi->tanggal_pengambilan }}</p>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Metode Pengambilan:</label>
                <p>{{ $transaksi->pengambilan }}</p>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Alamat:</label>
                <p>{{ $transaksi->alamat }}</p>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Ongkir:</label>
                <p>Rp{{ number_format($transaksi->ongkir, 2, ',', '.') }}</p>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Total Harga:</label>
                <p>Rp{{ number_format($transaksi->total_harga, 2, ',', '.') }}</p>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Poin diperoleh:</label>
                <p>{{ $transaksi->poin }}</p>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Uang Dibayarkan:</label>
                <p>Rp{{ number_format($pembayaran->uang_diterima, 2, ',', '.') }}</p>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Tip:</label>
                <p>Rp{{ number_format($pembayaran->tip, 2, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
