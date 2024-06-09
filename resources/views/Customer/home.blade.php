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
            background-attachment: fixed;
            color: #fff;
        }
        .navbar {
            background-color: rgba(255, 255, 255, 0.8);
        }
        .navbar-brand {
            font-family: 'Brush Script MT', cursive;
            font-size: 2rem;
            color: #d2691e !important;
        }
        .nav-link {
            color: #555 !important;
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
            background-color: rgba(255, 255, 255, 0.9);
            padding: 15px 0;
            text-align: center;
            color: #555;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }
        .footer span {
            font-weight: bold;
            color: #d2691e;
        }
        .content {
            background: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
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
    <div class="content">
        @yield('content')
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
