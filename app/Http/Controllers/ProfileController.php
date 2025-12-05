<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewa;

class ProfileController extends Controller
{
    public function index()
    {
        // Ambil session penyewa
        $sessionPenyewa = session('penyewa');

        // Ambil data penyewa dari database
        $penyewa = Penyewa::where('id_penyewa', $sessionPenyewa['id_penyewa'])->first();

        return view('profile', compact('penyewa'));
    }

    public function update(Request $request)
    {
        $sessionPenyewa = session('penyewa');

        $penyewa = Penyewa::findOrFail($sessionPenyewa['id_penyewa']);

        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required',
            'nomor_telepon' => 'required',
            'password' => 'nullable', // tidak wajib
        ]);

        // update data
        $penyewa->nama_lengkap = $request->nama_lengkap;
        $penyewa->username = $request->username;
        $penyewa->nomor_telepon = $request->nomor_telepon;

        // update password jika diisi
        if ($request->password) {
            $penyewa->password = $request->password; // TANPA HASH sesuai permintaan
        }

        $penyewa->save();

        session([
            'penyewa' => [
                'id_penyewa' => $penyewa->id_penyewa,
                'nama_lengkap' => $penyewa->nama_lengkap,
                'username' => $penyewa->username,
                'nomor_telepon' => $penyewa->nomor_telepon
            ]
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
