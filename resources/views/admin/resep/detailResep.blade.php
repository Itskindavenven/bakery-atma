@extends('admin.home-admin')

@section('content')

<div class="container">
    <div class="btn-container">
        <a href="{{ route('resep.index') }}" class="add-event-btn btn btn-block btn-success">
            <strong class="text-white" style="font-size: 24px;"><span class="plus-logo"></span> Halaman Resep Sebelumnya </strong>
        </a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Resep</th>
                <th>Nama Bahan</th>
                <th>Kuantitas</th>
                <th>Satuan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($resep as $item)
                @forelse ($bahanResep as $detailItem)
                    <tr>
                        <td><strong>{{ $item->produk->nama }}</strong></td>
                        <td>{{ $detailItem->bahan_baku->nama}}</td>
                        <td>{{ $detailItem->jumlah }}</td>
                        <td>{{ $detailItem->satuan}}</td>
                        <td>
                            <form onsubmit="return confirm('Apakah Anda Yakin akan menghapus Produk ini?');"
                                action="{{ route('resep.kurangi', ['id_bahan_baku' => $detailItem->bahanBaku->id_bahan, 'id_pembelian' => $item->id_pembelian]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Bahan</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center alert alert-danger">
                            Detail data resep masih kosong.
                        </td>
                    </tr>
                @endforelse
            @empty
                <tr>
                    <td colspan="5" class="text-center alert alert-danger">
                        Data resep masih kosong.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
