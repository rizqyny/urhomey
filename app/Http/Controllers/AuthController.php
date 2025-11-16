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
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'username' => 'required|string|max:50|unique:penyewa,username',
            'password' => 'required|string',
        ]);

        Penyewa::create([
            'nama_lengkap'  => $request->nama_lengkap,
            'nomor_telepon' => $request->nomor_telepon,
            'username'      => $request->username,
            'password'      => $request->password,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil!');
    }

    public function showLogin()
    {
        return view('logreg.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $penyewa = DB::table('penyewa')->where('username', $request->username)->first();

        if ($penyewa) {
            if ($penyewa->password === $request->password) {

                Session::put('penyewa', [
                    'id_penyewa' => $penyewa->id_penyewa,
                    'username' => $penyewa->username
                ]);

                return redirect()->route('dashboard')->with('success', 'Login berhasil sebagai penyewa!');
            } else {
                return back()->with('error', 'Password salah!');
            }
        }

        $pemilik = DB::table('pemilik')->where('username', $request->username)->first();

        if ($pemilik) {
            if ($pemilik->password === $request->password) {

                Session::put('pemilik', [
                    'id_pemilik' => $pemilik->id_pemilik,
                    'username' => $pemilik->username
                ]);

                return redirect()->route('dashboard')->with('success', 'Login berhasil sebagai pemilik!');
            } else {
                return back()->with('error', 'Password salah!');
            }
        }

        return back()->with('error', 'Username tidak ditemukan di sistem!');
    }

    public function logout()
    {
        if (Session::has('penyewa')) {
            Session::forget('penyewa');
        }

        if (Session::has('pemilik')) {
            Session::forget('pemilik');
        }

        return redirect()->route('dashboard')->with('success', 'Anda telah logout');
    }
}
