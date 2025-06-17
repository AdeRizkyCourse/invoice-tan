<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // //*
    //  Display a listing of the resource.
    //  */
    public function index()
    {
        $title = 'Users';
        $listData = User::all();
        return view('user.index', compact('listData', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Users';
        $listData = User::all();
        return view('user.create', compact('listData', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validasi data
        $request->validate([
            'name' => 'required',
            'email' =>'required | email | unique:clients',
        ]);

        // Simpan data ke dalam database
        User::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
         $title = 'Users';
         $data = User::with('invoices')->find($id);

        return view('user.show', compact('data', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Users';
        $data = User::find($id);

        return view('user.edit', compact('data','title'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       if ($request->password) {
            // validasi data
            $request->validate([
                'name' => 'required',
                'email' =>'required | email',
                'password' =>'required|min:6',
            ]);

            // Simpan data ke dalam database
            User::find($id)->update($request->all());
        } else {
            // validasi data
            $request->validate([
                'name' =>'required',
                'email' =>'required | email',
            ]);

            // Simpan data ke dalam database
            User::find($id)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }



        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Hapus data dari database
        user::find($id)->delete();
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'Data berhasil dihapus');
    }
}
