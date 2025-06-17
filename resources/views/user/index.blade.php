@extends('layouts.app')

@section('content')
    <h3>Daftar {{ $title }}</h3>
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">+ Tambah User</a>

    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listData as $data)
                <tr>
                    <td>{{ $data->name}}</td>
                    <td>{{ $data->email }}</td>
                    <td>
                        <a href="{{ route('users.show', $data->id) }}" class="btn btn-info">Detail</a>
                        <a href="{{ route('users.edit', $data->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('users.destroy', $data->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    <!-- Tempat untuk tabel -->
@endsection
