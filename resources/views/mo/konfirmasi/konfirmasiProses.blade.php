@extends('mo.home-mo')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Pesanan dengan Status 'Menunggu Konfirmasi'</h2>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-dark">
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
                                        style="max-width: 100px; height: auto;">
                                </a>
                            @else
                                Tidak ada bukti pembayaran
                            @endif
                        </td>
                        <td>
                            <form onsubmit="return confirm('Pastikan sebelum konfirmasi, sudah benar?');"
                                action="{{ route('transaksi.kurangiStok', $p->nomor_transaksi) }}" method="POST"
                                class="update-form">
                                @csrf
                                @method('PUT')
                                <div class="input-group">
                                    <select name="status" required class="form-select">
                                        <option value="Diproses" {{ old('status') == 'Diproses' ? 'selected' : '' }}>Lanjutkan
                                            Pesanan</option>
                                        <option value="Batal" {{ old('status') == 'Batal' ? 'selected' : '' }}>Batalkan Pesanan
                                        </option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
