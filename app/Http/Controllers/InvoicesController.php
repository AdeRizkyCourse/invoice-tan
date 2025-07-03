<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;
use App\Models\clients;
use App\Models\User;
use App\Models\invoices_items;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Invoices';
        $listData = invoices::with('client', 'user')->get();

        return view('invoice.index', compact('listData', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Invoice';
        $clients = clients::all(); // Mengambil data client untuk dropdown
        $users = User::all(); // Mengambil data user untuk dropdown
        return view('invoice.create', compact('title', 'clients', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;

       $invoice = invoices::create([
            'no_invoice' => $request->input('no_invoice'),
            'id_client' => $request->input('id_client'),
            'id_user' => $request->input('id_user'),
            'total_harga' => $request->input('total_harga'),
            'status' => $request->input('status'),
        ]);

        // Create invoice items from the request arrays
        for ($i = 0; $i < count($request->nama_barang); $i++) {
            invoices_items::create([
                'id_invoice' => $invoice->id,
                'nama_barang' => $request->nama_barang[$i],
                'jumlah' => $request->jumlah[$i],
                'harga_satuan' => $request->harga_satuan[$i],
                'total_harga' => $request->total_harga[$i]
            ]);
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = 'Invoice';
        $data = invoices::with('client', 'user', 'items')->find($id);

        return view('invoice.show', compact('data', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Invoice';
        $data = invoices::with('client', 'user', 'items')->find($id);
        $clients = Clients::all(); 
        $users = User::all();

        return view('invoice.edit', compact('data', 'title', 'clients', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    // Validasi dasar
    $request->validate([
        'no_invoice' => 'required',
        'id_client' => 'required',
        'id_user' => 'required',
        'total_harga' => 'required|numeric',
        'status' => 'required',
    ]);

    // Update invoice utama
    $invoice = invoices::findOrFail($id);
    $invoice->update([
        'no_invoice' => $request->input('no_invoice'),
        'id_client' => $request->input('id_client'),
        'id_user' => $request->input('id_user'),
        'total_harga' => $request->input('total_harga'),
        'status' => $request->input('status'),
    ]);

    // Cek apakah data item dikirim
    if ($request->has('nama_barang')) {
        // Hapus semua item lama (opsional: atau update jika ingin lebih kompleks)
        invoices_items::where('id_invoice', $invoice->id)->delete();

        // Tambahkan ulang item baru dari form
        for ($i = 0; $i < count($request->nama_barang); $i++) {
            invoices_items::create([
                'id_invoice' => $invoice->id,
                'nama_barang' => $request->nama_barang[$i],
                'jumlah' => $request->jumlah[$i],
                'harga_satuan' => $request->harga_satuan[$i],
                'total_harga' => $request->total_harga[$i],
            ]);
        }
    }

    return redirect()->route('invoices.index')->with('success', 'Invoice berhasil diperbarui');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Hapus data dari database
        invoices::find($id)->delete();
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('invoices.index')->with('success', 'Data berhasil dihapus');
    }
}