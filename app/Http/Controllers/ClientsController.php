<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\clients;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Clients';
        $data = clients::all();
        return view('clients.index', compact('data', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama' => 'required',
            'email' =>'required | email | unique:clients',
            'no_hp' =>'required',
            'alamat' =>'required',
        ]);

        // Simpan data ke dalam database
        clients::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('clients.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
         $title = 'Clients';
         $data = clients::find($id);
        return view('clients.show', compact('data', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = clients::find($id);
        return view('clients.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi data
        $request->validate([
            'nama' => 'required',
            'email' =>'required | email',
            'no_hp' =>'required',
            'alamat' =>'required',
        ]);

        // Simpan data ke dalam database
        clients::find($id)->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('clients.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Hapus data dari database
        clients::find($id)->delete();
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('clients.index')->with('success', 'Data berhasil dihapus');
    }
}
