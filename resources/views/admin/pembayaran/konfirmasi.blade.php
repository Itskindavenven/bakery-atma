@extends('admin.home-admin')
@section('content')

<div class="container mt-5">
    <h2 class="mb-4">Pesanan dengan Status 'Menunggu Konfirmasi'</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>No. Transaksi</th>
                <th>Alamat</th>
                <th>Jarak</th>
                <th>Ongkir</th>
                <th>Total Harga</th>
                <th>Uang Dibayarkan</th>
                <th>Bukti Pembayaran</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan as $p)
                <tr>
                    <td>{{ $p->nomor_transaksi }}</td>
                    <td>{{ $p->alamat }}</td>
                    <td>{{ $p->jarak }} km</td>
                    <td>Rp{{ number_format($p->ongkir, 2, ',', '.') }}</td>
                    <td>Rp{{ number_format($p->total_harga, 2, ',', '.') }}</td>
                    <td>Rp{{ number_format($p->pembayaran->uang_diterima, 2, ',', '.') }}</td>
                    <td>
                        @if($p->pembayaran->bukti_pembayaran)
                            <a href="{{ asset('storage/' . $p->pembayaran->bukti_pembayaran) }}" target="_blank">
                                <img src="{{ asset('storage/' . $p->pembayaran->bukti_pembayaran) }}" alt="Bukti Pembayaran"
                                    style="width: 100px; height: auto;">
                            </a>
                        @else
                            Tidak ada bukti pembayaran
                        @endif
                    </td>
                    <td>
                        <form onsubmit="return confirm('Pastikan sebelum konfirmasi, sudah benar?');"
                            action="{{ route('pembayaran.inputStatusPembayaran', $p->nomor_transaksi) }}" method="POST" class="d-flex">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-select me-2" required>
                                <option value="Menunggu Diproses" {{ old('status') == 'Menunggu Diproses' ? 'selected' : '' }}>Lanjutkan Pesanan</option>
                                <option value="Batal" {{ old('status') == 'Batal' ? 'selected' : '' }}>Batalkan Pesanan</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
