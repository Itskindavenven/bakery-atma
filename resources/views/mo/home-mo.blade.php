<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atma Bakery</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        body {
            position: relative;
            min-height: 100vh;
        }
        .container-fluid {
            padding-bottom: 70px;
            position: relative;
            overflow: hidden;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa;
        }
        .background-image {
            /* background-image: url('/img/atmabakery.jpg'); */
            background-size: cover;
            background-position: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Atma Bakery</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('index-pegawai') }}">Karyawan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('index-role') }}">Jabatan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('index-presensi') }}">Presensi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Penitip</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pengeluaran lain</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('transaksi.konfirmasiProses')}}">Konfirmasi Pesanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('proses.pesananHarian')}}">Pesanan Harian</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <!-- Logout Form -->
                        <form id="logout-form" action="{{ route('logout-pegawai') }}" method="POST" style="display: none;">
                            @csrf <!-- CSRF Token -->
                        </form>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Content -->
        <div class="background-image"></div>
        <div class="container">
            @yield('content')
        </div>
        <!-- Footer -->
        <footer class="footer mt-auto py-3">
            <div class="container text-center">
                <span class="text-muted">@atmabakery</span>
            </div>
        </footer>
    </div>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-vqgOZ7a8gL4GA2i7/XlQQPyxXhERv1xuH1AHDcHXw6IcZsbcfssj/HHI5d6fLw7P" crossorigin="anonymous"></script>
</body>
</html>
