@extends('admin.home-admin')
@section('content')

<div class="container mt-5">
    <h2 class="mb-4">Pesanan dengan Status 'Waiting'</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>No. Transaksi</th>
                <th>Alamat</th>
                <th>Ongkir</th>
                <th>Total Harga</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan as $p)
                <tr>
                    <td>{{ $p->nomor_transaksi }}</td>
                    <td>{{ $p->alamat }}</td>
                    <td>Rp{{ number_format($p->ongkir, 2, ',', '.') }}</td>
                    <td>Rp{{ number_format($p->total_harga, 2, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('pembayaran.inputJarak', $p->nomor_transaksi) }}" method="POST" class="d-flex">
                            @csrf
                            @method('PATCH')
                            <select name="jarak" class="form-select me-2" required>
                                <option value="5">Kurang dari 5 km</option>
                                <option value="10">5-10 km</option>
                                <option value="15">10-15 km</option>
                                <option value="more_than_15">Lebih dari 15 km</option>
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
