<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atma Bakery</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        body {
            position: relative;
            min-height: 100vh;
            background-image: url('/img/atmabakery.jpg');
            background-size: cover;
            background-position: center;
        }
        .container {
            position: relative;
            overflow: hidden;
            padding-bottom: 70px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa;
            padding: 15px 0;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Atma Bakery</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('dataStokProduk')}}">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transaksi.create', session('customer')->id_customer) }}">Pesan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transaksi.cekPesanan', session('customer')->id_customer)}}">Cek Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                    <!-- Formulir Logout -->
                    <form id="logout-form" action="{{ route('logout-customer')}}" method="POST" style="display: none;">
                        @csrf <!-- CSRF Token -->
                    </form>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Content -->
    
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
        <div class="card shadow-lg">
    <div class="card-header text-center bg-primary text-white">
        <h3>Detail Transaksi</h3>
    </div>
    <div class="card-body">
        <div class="form-group mb-3 border-bottom pb-2">
            <label class="form-label fw-bold">Nomor Transaksi:</label>
            <p class="ms-3">{{ $transaksi->nomor_transaksi }}</p>
        </div>

        <div class="form-group mb-3 border-bottom pb-2">
            <label class="form-label fw-bold">Nama Customer:</label>
            <p class="ms-3">{{ session('customer')->nama_lengkap }}</p>
        </div>

        <div class="form-group mb-3 border-bottom pb-2">
            <label class="form-label fw-bold">Produk/Hampers:</label>
            <ul class="ms-3">
                @foreach($produk as $p)
                    <li>{{ $p->nama }}</li>
                @endforeach
                @foreach($hampers as $h)
                    <li>{{ $h->nama }}</li>
                @endforeach
            </ul>
        </div>

        <div class="form-group mb-3 border-bottom pb-2">
            <label class="form-label fw-bold">Jumlah:</label>
            <ul class="ms-3">
                @foreach($transaksi->keranjang as $keranjang)
                    <li>{{ $keranjang->jumlah_produk }}</li>
                @endforeach
            </ul>
        </div>

        <div class="form-group mb-3 border-bottom pb-2">
            <label class="form-label fw-bold">Subtotal Produk/Hampers:</label>
            <ul class="ms-3">
                @foreach($transaksi->keranjang as $keranjang)
                    <li>Rp{{ number_format($keranjang->subtotal, 2, ',', '.') }}</li>
                @endforeach
            </ul>
        </div>

        <div class="form-group mb-3 border-bottom pb-2">
            <label class="form-label fw-bold">Tanggal Pemesanan:</label>
            <p class="ms-3">{{ $transaksi->tanggal_pemesanan }}</p>
        </div>

        <div class="form-group mb-3 border-bottom pb-2">
            <label class="form-label fw-bold">Tanggal Pengambilan:</label>
            <p class="ms-3">{{ $transaksi->tanggal_pengambilan }}</p>
        </div>

        <div class="form-group mb-3 border-bottom pb-2">
            <label class="form-label fw-bold">Metode Pengambilan:</label>
            <p class="ms-3">{{ $transaksi->pengambilan }}</p>
        </div>

        <div class="form-group mb-3 border-bottom pb-2">
            <label class="form-label fw-bold">Alamat:</label>
            <p class="ms-3">{{ $transaksi->alamat }}</p>
        </div>

        <div class="form-group mb-3 border-bottom pb-2">
            <label class="form-label fw-bold">Ongkir:</label>
            <p class="ms-3">Rp{{ number_format($transaksi->ongkir, 2, ',', '.') }}</p>
        </div>

        <div class="form-group mb-3 border-bottom pb-2">
            <label class="form-label fw-bold">Total Harga:</label>
            <p class="ms-3">Rp{{ number_format($transaksi->total_harga, 2, ',', '.') }}</p>
        </div>

        <div class="form-group mb-3 border-bottom pb-2">
            <label class="form-label fw-bold">Poin:</label>
            <p class="ms-3">{{ $transaksi->poin }}</p>
        </div>

        <div class="btn-container d-grid mb-3">
            <a class="nav-link btn btn-primary" href="{{ route('transaksi.cekPesanan', session('customer')->id_customer) }}">
                Cek Pesanan
            </a>
        </div>

        @if ($transaksi->status != 'Batal')
            <div class="btn-container d-grid">
                <a class="nav-link btn btn-primary" href="{{ route('transaksi.cetakNota', $transaksi->nomor_transaksi) }}">
                    Cetak Nota
                </a>
            </div>
        @endif
    </div>
</div>

        </div>
    </div>
</div>

</div>
<!-- Footer -->
<footer class="footer">
    <div class="container">
        <span class="text-muted">@atmabakery</span>
    </div>
</footer>
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>