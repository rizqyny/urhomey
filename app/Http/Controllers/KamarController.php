<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        $kamar = Kamar::with('kategori')
              ->orderBy('nomor_kamar', 'asc')
              ->get();
        $kategori = Kategori::all();
        return view('datakamar', compact('kamar', 'kategori'));
    }


    public function create()
    {
        $kategori = Kategori::all();
        return view('datakamar', compact('kategori'));
    }

    // public function store(Request $request)
    // {
    //     dd($request->all());
    // }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar' => 'required|unique:kamar',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'perabotan' => 'required|array',
            'lokasi_lantai' => 'required',
            'status_kamar' => 'required',
            'gambar' => 'image|mimes:jpg,jpeg,png',
            'kode_kunci' => 'nullable|string'
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('img_kamar', 'public');
        }

        Kamar::create([
            'nomor_kamar' => $request->nomor_kamar,
            'id_kategori' => $request->id_kategori,
            'id_penyewa' => null,
            'perabotan' => json_encode($request->perabotan),
            'lokasi_lantai' => $request->lokasi_lantai,
            'status_kamar' => $request->status_kamar,
            'gambar' => $gambar,
            'kode_kunci' => $request->kode_kunci
        ]);

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil ditambahkan');
    }


    public function edit($id)
    {
        $kamar = Kamar::findOrFail($id);
        $kategori = Kategori::all();
        return view('datakamar', compact('kamar', 'kategori'));
    }

    public function update(Request $request, $nomor_kamar)
    {
        $kamar = Kamar::where('nomor_kamar', $nomor_kamar)->firstOrFail();

        $request->validate([
            'id_kategori' => 'required',
            'perabotan' => 'required',
            'lokasi_lantai' => 'required',
            'status_kamar' => 'required',
            'gambar' => 'image|mimes:jpg,jpeg,png|max:2048',
            'kode_kunci' => 'nullable|string'
        ]);

        $gambar = $kamar->gambar;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('img_kamar', 'public');
        }

        $kamar->update([
            'id_kategori' => $request->id_kategori,
            'perabotan' => json_encode($request->perabotan), // WAJIB JSON!
            'lokasi_lantai' => $request->lokasi_lantai,
            'status_kamar' => $request->status_kamar,
            'gambar' => $gambar,
            'kode_kunci' => $request->kode_kunci
        ]);

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil diperbarui');
    }


    public function destroy($id)
    {
        $kamar = Kamar::findOrFail($id);
        $kamar->delete();

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil dihapus');
    }

    public function kamarku()
    {
        $sessionPenyewa = session('penyewa');

        if (!$sessionPenyewa) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $kamar = Kamar::with('kategori')
                    ->where('id_penyewa', $sessionPenyewa['id_penyewa'])
                    ->first();

        return view('kamarku', compact('kamar'));
    }

}
