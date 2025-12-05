<?php

namespace App\Http\Controllers;

use App\Models\LaporanKerusakan;
use App\Models\Kamar;
use Illuminate\Http\Request;

class LaporanKerusakanController extends Controller
{
    public function index()
    {
        $sessionPenyewa = session('penyewa');
        if (!$sessionPenyewa) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }
        $kamar = Kamar::where('id_penyewa', $sessionPenyewa['id_penyewa'])->first();
        return view('laporan', compact('kamar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi_kerusakan' => 'required|min:5'
        ]);
        $sessionPenyewa = session('penyewa');
        $kamar = Kamar::where('id_penyewa', $sessionPenyewa['id_penyewa'])->first();
        LaporanKerusakan::create([
            'id_penyewa' => $sessionPenyewa['id_penyewa'],
            'nomor_kamar' => $kamar->nomor_kamar,
            'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
            'status_laporan' => 'belum ditangani'
        ]);
        return redirect()->back()->with('success', 'Laporan kerusakan berhasil dikirim!');
    }

    public function adminIndex()
    {
        $laporan = LaporanKerusakan::with('penyewa')->orderBy('id_laporan', 'desc')->get();

        return view('datalaporan', compact('laporan'));
    }

    public function updateStatus($id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);

        $laporan->update([
            'status_laporan' => 'sudah ditangani'
        ]);

        return redirect()->back()->with('success', 'Status laporan telah diperbarui.');
    }
}
