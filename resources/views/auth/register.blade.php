@extends('layouts.login')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg rounded p-4 w-100" style="max-width: 500px;">
        <h4 class="text-center mb-4">🔐 Tambah User Baru</h4>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">👤 Nama</label>
                <input type="text" name="name" value="{{ old('name', $data->name ?? '') }}" class="form-control" required>
                @error('name')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">📧 Email</label>
                <input type="email" name="email" value="{{ old('email', $data->email ?? '') }}" class="form-control" required>
                @error('email')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">🔒 Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success">
                    ✅ Simpan
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                    ⬅️ Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
