@extends('layouts.app')

@section('content')
    <h3>Detail {{ $title }}</h3>
    <a href="{{ route('users.index') }}" class="btn btn-primary mb-3">Kembali ke list {{ $title }}</a>

    <table class="table">
        <tr>
            <th>Nama User</th>
            <td>{{ $data->name }}</td>
        </tr>
        <tr>
            <th>Email User</th>
            <td>{{ $data->email }}</td>
        </tr>
        <tr>
            <th>Detail Invoice</th>
            <td>
                @foreach($data->invoices as $invoices)
                    {{ $invoices->no_invoice }} | {{ $invoices->total_harga }} | {{ $invoices->status}}<br>
                @endforeach
            </td>
        </tr>

        <tr>
            <th>Status</th>
            <td>
                @if($invoices->status == 'terbayar')
                    <span class="badge bg-success">{{ $invoices->status }}</span>
                @else
                    <span class="badge bg-danger">{{ $invoices->status }}</span>
                @endif
            </td>
        </tr>
    </table>
    <!-- Tempat untuk tabel -->
@endsection