<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewa;

class ProfileController extends Controller
{
    public function index()
    {
        $sessionPenyewa = session('penyewa');
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
            'password' => 'nullable',
        ]);

        $penyewa->nama_lengkap = $request->nama_lengkap;
        $penyewa->username = $request->username;
        $penyewa->nomor_telepon = $request->nomor_telepon;

        if ($request->password) {
            $penyewa->password = $request->password;
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
