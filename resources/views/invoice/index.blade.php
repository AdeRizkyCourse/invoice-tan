
@extends('layouts.app')

@section('content')
    <h3>Daftar {{ $title }}</h3>
    <a href="{{ route('invoices.create') }}" class="btn btn-primary mb-3">+ Tambah {{ $title }}</a>

    <table class="table">
        <thead>
            <tr>
                <th>No Invoice</th>
                <th>Nama Klien</th>
                <th>Alamat Klien</th>
                <th>Nama User</th>
                <th>Email User</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listData as $data)
                <tr>
                    <td>{{ $data->no_invoice }}</td>
                    <td>{{ $data->client->nama }}</td>
                    <td>{{ $data->client->alamat }}</td>
                    <td>{{ $data->user->name }}</td>
                    <td>{{ $data->user->email }}</td>
                    <td>{{ $data->total_harga }}</td>
                    <td>{{ $data->status }}</td>
                    <td>
                        <a href="{{ route('invoices.show', $data->id) }}" class="btn btn-info">Detail</a>
                        <a href="{{ route('invoices.edit', $data->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('invoices.destroy', $data->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus klien ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    <!-- Tempat untuk tabel -->
@endsection
