@extends('layouts.app')

@section('content')
    <h3>Detail {{ $title }}</h3>
    <a href="{{ route('invoices.index') }}" class="btn btn-primary mb-3">Kembali ke list {{ $title }}</a>

    <table class="table">
        <tr>
            <th>No Invoice</th>
            <td>{{ $data->no_invoice }}</td>
        </tr>
        <tr>
            <th>Nama Klien</th>
            <td>{{ $data->client->nama }}</td>
        </tr>
        <tr>
            <th>Alamat Klien</th>
            <td>{{ $data->client->alamat }}</td>
        </tr>
        <tr>
            <th>Nama User</th>
            <td>{{ $data->user->name }}</td>
        </tr>
        <tr>
            <th>Email User</th>
            <td>{{ $data->user->email }}</td>
        </tr>
        <tr>
            <th>Detail Item</th>
            <td>
                @foreach($data->items as $item)
                    {{ $item->nama_barang }} | {{ $item->jumlah }} x {{ $item->harga_satuan }} = {{ $item->total_harga }}<br>
                @endforeach
            </td>
        </tr>
        <tr>
            <th>Total Harga</th>
            <td>{{ $data->total_harga }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                @if($data->status == 'terbayar')
                    <span class="badge bg-success">{{ $data->status }}</span>
                @else
                    <span class="badge bg-danger">{{ $data->status }}</span>
                @endif
            </td>
        </tr>
    </table>
    <!-- Tempat untuk tabel -->
@endsection