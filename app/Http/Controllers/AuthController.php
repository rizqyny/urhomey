<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        return view('logreg.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Cek ke tabel penyewa
        $penyewa = DB::table('penyewa')->where('username', $request->username)->first();

        // Jika username tidak ditemukan
        if (!$penyewa) {
            return back()->with('error', 'Username tidak ditemukan!');
        }

        // Cek password (tanpa hash)
        if ($penyewa->password !== $request->password) {
            return back()->with('error', 'Password salah!');
        }

        // Jika sesuai, simpan sesi login
        Session::put('penyewa', [
            'id' => $penyewa->id,
            'username' => $penyewa->username,
        ]);

        return redirect()->route('dashboard')->with('success', 'Login berhasil!');
    }

    /**
     * Logout
     */
    public function logout()
    {
        Session::forget('penyewa');
        return redirect()->route('logreg.login')->with('success', 'Anda telah logout');
    }
}
