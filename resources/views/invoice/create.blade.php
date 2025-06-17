
@extends('layouts.app')
@section('content')
<h4>{{ $title }}</h4>

<form action="{{ route('invoices.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>No Invoice</label>
        <input type="text" name="no_invoice" value="{{ old('no_invoice', $data->no_invoice ?? '') }}" class="form-control" required>
        @error('no_invoice')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Client</label>
        <select name="id_client" class="form-control" required>
            <option value="">Select Client</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ old('id_client', $data->id_client ?? '') == $client->id ? 'selected' : '' }}>
                    {{ $client->nama }}
                </option>
            @endforeach
        </select>
        @error('id_client')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Users</label>
        <select name="id_user" class="form-control" required>
            <option value="">Select User</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('id_user', $data->id_user ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        @error('id_user')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <h5>Item Invoice</h5>
    <table class="table table-bordered" id="item-table">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input name="nama_barang[]" class="form-control" required></td>
                <td><input name="jumlah[]" type="number" class="form-control" required></td>
                <td><input name="harga_satuan[]" type="number" class="form-control" required></td>
                <td><input name="total_harga[]" type="number" class="form-control" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
            </tr>
        </tbody>
    </table>
    <button type="button" id="add-row" class="btn btn-secondary mb-3">+ Tambah Item</button>



    <div class="mb-3">
        <label>Total Price</label>
        <input type="number" name="total_harga" value="{{ old('total_harga', $data->total_harga ?? '') }}" class="form-control" required>
        @error('total_harga')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control" required>
            <option value="">Select Status</option>
            <option value="terbayar" {{ old('status', $data->status ?? '') == 'terbayar' ? 'selected' : '' }}>Terbayar</option>
            <option value="belum terbayar" {{ old('status', $data->status ?? '') == 'belum terbayar' ? 'selected' : '' }}>Belum Terbayar</option>
        </select>
        @error('status')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Kembali</a>
</form>

@push('scripts')
<script>
// Function to calculate row total
function calculateRowTotal(row) {
    const jumlah = parseFloat(row.querySelector('input[name="jumlah[]"]').value) || 0;
    const hargaSatuan = parseFloat(row.querySelector('input[name="harga_satuan[]"]').value) || 0;
    const totalHarga = jumlah * hargaSatuan;
    row.querySelector('input[name="total_harga[]"]').value = totalHarga;
}

// Function to calculate grand total
function updateGrandTotal() {
    const rows = document.querySelectorAll('#item-table tbody tr');
    let grandTotal = 0;

    rows.forEach(row => {
        const totalHarga = parseFloat(row.querySelector('input[name="total_harga[]"]').value) || 0;
        grandTotal += totalHarga;
    });

    document.querySelector('input[name="total_harga"]').value = grandTotal;
}

// Add row button functionality
document.getElementById('add-row').addEventListener('click', function () {
    let table = document.getElementById('item-table').getElementsByTagName('tbody')[0];
    let row = table.rows[0].cloneNode(true);
    row.querySelectorAll('input').forEach(input => input.value = '');

    // Add event listeners to new row
    row.querySelector('input[name="jumlah[]"]').addEventListener('input', function() {
        calculateRowTotal(row);
        updateGrandTotal();
    });

    row.querySelector('input[name="harga_satuan[]"]').addEventListener('input', function() {
        calculateRowTotal(row);
        updateGrandTotal();
    });

    // Remove row button functionality
    row.querySelector('.remove-row').addEventListener('click', function() {
        row.remove();
        updateGrandTotal();
    });

    table.appendChild(row);
});

// Add event listeners to initial row
const initialRow = document.querySelector('#item-table tbody tr');
if (initialRow) {
    initialRow.querySelector('input[name="jumlah[]"]').addEventListener('input', function() {
        calculateRowTotal(initialRow);
        updateGrandTotal();
    });

    initialRow.querySelector('input[name="harga_satuan[]"]').addEventListener('input', function() {
        calculateRowTotal(initialRow);
        updateGrandTotal();
    });

    initialRow.querySelector('.remove-row').addEventListener('click', function() {
        if (document.querySelectorAll('#item-table tbody tr').length > 1) {
            initialRow.remove();
            updateGrandTotal();
        }
    });
}
</script>
@endpush

@endsection
