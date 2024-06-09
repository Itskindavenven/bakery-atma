<?php
date_default_timezone_set('Asia/Jakarta');
?>

<p hidden>{{ session('mo') }}</p>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan per Produk</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tfoot {
            background-color: #f0f0f0;
            font-weight: bold;
        }
    </style>
</head>

<body>
    @php
        use Carbon\Carbon;

        $totalHarga = 0;
    @endphp
    <div class="container">
        <h2>Atma Kitchen</h2>
        <p>Jl. Kenangan No. 10 Yogyakarta</p>
        <h2>Laporan Penjualan per Produk</h2>
        <p>Tanggal Cetak: {{ Carbon::parse(today())->format('d, F Y') }}</p>
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Kuantitas</th>
                    <th>Harga</th>
                    <th>Jumlah Uang</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                    @php
                        $totalHarga += $item['total_harga'];
                    @endphp
                    <tr>
                        <td>{{ $item['nama'] }}</td>
                        <td>{{ $item['jumlah'] }}</td>
                        <td>Rp{{ number_format($item['harga'], 2, ',', '.') }}</td>
                        <td>Rp{{ number_format($item['total_harga'], 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" style="text-align:right">Total:</th>
                    <th>Rp{{ number_format($totalHarga, 2, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>