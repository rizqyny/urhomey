<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penyewa;
use App\Models\MetodePembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index($nomor_kamar)
    {
        $kamar = Kamar::with('kategori')->where('nomor_kamar', $nomor_kamar)->firstOrFail();

        $sessionPenyewa = session('penyewa');

        if (!$sessionPenyewa) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $penyewa = Penyewa::where('id_penyewa', $sessionPenyewa['id_penyewa'])->first();

        $metode = MetodePembayaran::all();

        return view('transaksi', compact('kamar', 'penyewa', 'metode'));
    }

    /**
     * Proses simpan transaksi
     */
    // public function store(Request $request, $nomor_kamar)
    // {
    //     dd($request->all());
    // }

    public function store(Request $request, $nomor_kamar)
    {
        $sessionPenyewa = session('penyewa');

        // Simpan transaksi
        Transaksi::create([
            'nomor_kamar'       => $nomor_kamar,
            'id_metode'         => $request->id_metode,
            'tanggal_transaksi' => now(),
            'nominal'           => $request->nominal,
            'status'            => 'menunggu',
        ]);

        $kamar = Kamar::where('nomor_kamar', $nomor_kamar)->first();
        $kamar->id_penyewa = $sessionPenyewa['id_penyewa'];
        $kamar->save();

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil dibuat!');
    }

    public function dataTransaksi()
    {
        $transaksi = Transaksi::with(['metode', 'kamar.kategori'])
            ->orderBy('id_transaksi', 'DESC')
            ->get();

        return view('datatransaksi', compact('transaksi'));
    }

    // public function markSelesai($id_transaksi)
    // {
    //     dd('FUNCTION DIPANGGIL', $id_transaksi);
    // }

    public function markSelesai($id_transaksi)
    {
        $transaksi = Transaksi::findOrFail($id_transaksi);

        $transaksi->status = "selesai";
        $transaksi->save();

        $kamar = Kamar::where('nomor_kamar', $transaksi->nomor_kamar)->first();
        $kamar->status_kamar = 'terisi';
        $kamar->save();

        return redirect()->back()->with('success', 'Transaksi selesai dan kamar terisi!');
    }

    public function batalkan($id_transaksi)
    {
        $transaksi = Transaksi::findOrFail($id_transaksi);

        $transaksi->status = "dibatalkan";
        $transaksi->save();

        $kamar = Kamar::where('nomor_kamar', $transaksi->nomor_kamar)->first();

        if ($kamar) {
            $kamar->status_kamar = 'kosong';
            $kamar->id_penyewa = null;
            $kamar->save();
        }

        return redirect()->back()->with('success', 'Transaksi telah dibatalkan dan kamar dikosongkan!');
    }

}
