@extends('mo.home-mo')

@section('content')
    <h2>Laporan</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Laporan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Laporan Stok Bahan Baku</td>
                <td>
                    <a class="btn btn-primary" href="{{ route('laporan.laporanBahanBaku') }}">Cetak Laporan Stok</a>
                </td>
            </tr>
            <tr>
                <td>Laporan Penjualan Bulanan per Produk</td>
                <td>
                    <form action="{{ route('laporan.laporanPenjualanProduk') }}" method="POST" class="update-form">
                        @csrf
                        @method('GET')
                        <select name="bulan" required>
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April">April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="Juli">Juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                        <button type="submit">Cetak Laporan</button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
