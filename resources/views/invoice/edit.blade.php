
@extends('layouts.app')
@section('content')
<h4>{{ $title }}</h4>

<form action="{{ route('invoices.update', $data->id) }}" method="POST">
    @csrf
    @method('PUT')
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
    @if (!empty($data->items) && count($data->items))
        @foreach ($data->items as $item)
        <tr>
            <td><input name="nama_barang[]" value="{{ $item->nama_barang }}" class="form-control"></td>
            <td><input name="jumlah[]" type="number" value="{{ $item->jumlah }}" class="form-control"></td>
            <td><input name="harga_satuan[]" type="number" value="{{ $item->harga_satuan }}" class="form-control"></td>
            <td><input name="total_harga[]" type="number" value="{{ $item->total_harga }}" class="form-control" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
        </tr>
        @endforeach
    @else
        <tr>
            <td><input name="nama_barang[]" class="form-control"></td>
            <td><input name="jumlah[]" type="number" class="form-control"></td>
            <td><input name="harga_satuan[]" type="number" class="form-control"></td>
            <td><input name="total_harga[]" type="number" class="form-control" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
        </tr>
    @endif
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
function calculateRowTotal(row) {
    const jumlah = parseFloat(row.querySelector('input[name="jumlah[]"]').value) || 0;
    const hargaSatuan = parseFloat(row.querySelector('input[name="harga_satuan[]"]').value) || 0;
    const totalHarga = jumlah * hargaSatuan;
    row.querySelector('input[name="total_harga[]"]').value = totalHarga;
}

function updateGrandTotal() {
    const rows = document.querySelectorAll('#item-table tbody tr');
    let grandTotal = 0;

    rows.forEach(row => {
        const totalHarga = parseFloat(row.querySelector('input[name="total_harga[]"]').value) || 0;
        grandTotal += totalHarga;
    });

    document.querySelector('input[name="total_harga"]').value = grandTotal;
}

function attachListeners(row) {
    const jumlahInput = row.querySelector('input[name="jumlah[]"]');
    const hargaSatuanInput = row.querySelector('input[name="harga_satuan[]"]');

    jumlahInput.addEventListener('input', () => {
        calculateRowTotal(row);
        updateGrandTotal();
    });

    hargaSatuanInput.addEventListener('input', () => {
        calculateRowTotal(row);
        updateGrandTotal();
    });

    const removeBtn = row.querySelector('.remove-row');
    if (removeBtn) {
        removeBtn.addEventListener('click', () => {
            row.remove();
            updateGrandTotal();
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Tambahkan event listener ke semua baris yang sudah ada
    document.querySelectorAll('#item-table tbody tr').forEach(row => {
        attachListeners(row);
        calculateRowTotal(row); // Untuk inisialisasi saat load
    });

    // Tambah baris
    document.getElementById('add-row').addEventListener('click', function () {
        const tableBody = document.querySelector('#item-table tbody');
        const newRow = tableBody.rows[0].cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => input.value = '');
        tableBody.appendChild(newRow);
        attachListeners(newRow);
    });

    // Hitung total grand saat load awal
    updateGrandTotal();
});
</script>
@endpush


@endsection
