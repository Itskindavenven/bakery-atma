@extends('mo.home-mo')

@section('content')
<div class="container">
    <h2>Pesanan Hari Ini</h2>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
    @endif
    <table>
        <thead>
            <tr>
                <th>Nomor Transaksi</th>
                <th>Produk</th>
                <th>Jumlah Pesanan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($daftarPesanan as $pesanan)
                <tr>
                    <td>{{ $pesanan['nomor_transaksi'] }}</td>
                    <td>{{ $pesanan['nama_produk'] }}</td>
                    <td>{{ $pesanan['jumlah_pesanan'] }}</td>
                    <td>
                        @if ($pesanan['status'] == 'Menunggu Dibuat')
                            <form onsubmit="return confirm('Pastikan sebelum konfirmasi, sudah benar?');"
                                action="{{ route('proses.kurangiStok', ['nomor_transaksi' => $pesanan['nomor_transaksi']]) }}"
                                method="POST" class="update-form">
                                @csrf
                                @method('PUT')
                                <select name="status" required>
                                    <option value="Diproses" {{ old('status') == 'Diproses' ? 'selected' : '' }}>Proses
                                        Pesanan</option>
                                    <option value="Menunggu Dibuat" {{ old('status') == 'Menunggu Dibuat' ? 'selected' : '' }}>Tunggu Dibuat
                                    </option>
                                </select>
                                <button type="submit">Update</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center alert alert-danger">
                        Tidak ada pesanan untuk hari ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
