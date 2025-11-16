<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Penyewa;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{

    public function showRegister()
    {
        return view('logreg.register');
    }

    public function registerProcess(Request $request)
    {
        // Validasi
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'username' => 'required|string|max:50|unique:penyewa,username',
            'password' => 'required|string',
        ]);

        // Simpan ke database dgn Model Penyewa
        Penyewa::create([
            'nama_lengkap'  => $request->nama_lengkap,
            'nomor_telepon' => $request->nomor_telepon,
            'username'      => $request->username,
            'password'      => $request->password,
        ]);

        // Kembalikan popup sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil!');
    }

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
            'id_penyewa' => $penyewa->id_penyewa,
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
        return redirect()->route('dashboard')->with('success', 'Anda telah logout');
    }
}
