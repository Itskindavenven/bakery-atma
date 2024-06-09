@extends('home')
@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <hr>
            <form class="d-flex justify-content-end mb-3" action="{{ route('transaksi.search') }}" method="GET">
                <input type="text" name="search" class="form-control me-2" placeholder="Search" required />
                <button type="submit" class="btn btn-success">Search</button>
            </form>

            @forelse ($pesanan as $item)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Nomor Transaksi: {{ $item->nomor_transaksi }}</h5>
                        <p class="card-text"><strong>Tanggal Transaksi:</strong> {{ $item->tanggal_pemesanan }}</p>
                        <p class="card-text"><strong>Tanggal Pengambilan:</strong> {{ $item->tanggal_pengambilan }}</p>
                        <p class="card-text"><strong>Total Harga:</strong> Rp{{ number_format($item->total_harga, 2, ',', '.') }}</p>
                        <p class="card-text"><strong>Status:</strong> {{ $item->status }}</p>
                        <div class="d-grid gap-2">
                            <a class="btn btn-warning" href="{{ route('transaksi.summary', $item->nomor_transaksi) }}">Summary</a>
                            @if ($item->status == 'Menunggu Pembayaran')
                                <a class="btn btn-primary" href="{{ route('transaksi.bayar', $item->nomor_transaksi) }}">Bayar</a>
                            @endif
                            @if ($item->status != 'Batal' && $item->status != 'Diproses')
                                <form onsubmit="return confirm('Apakah Anda Yakin Akan Membatalkan Pesanan?');"
                                      action="{{ route('transaksi.destroy', $item->nomor_transaksi)}}" method="POST" class="d-grid">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Batalkan Pesanan</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-danger text-center">
                    Transaksi Anda masih kosong.
                </div>
            @endforelse

            <hr>
        </div>
    </div>
</div>

@endsection
