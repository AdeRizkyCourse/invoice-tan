<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function loginForm() {
        return view('auth.login');
    }
    public function registerForm() {
        return view('auth.register');
    }
    // Proses login
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard'); // ganti sesuai tujuan
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);

     // Kalau gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput(); // Supaya form tetap isi email
    }
    public function register(Request $request)
    {

        // Validasi data
        $request->validate([
            'name' => 'required',
            'email' =>'required | email | unique:clients',
        ]);

        // Simpan data ke dalam database
        User::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('auth.login')->with('success', 'User berhasil ditambahkan');
    }

    // Proses logout (opsional)
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    
}

}