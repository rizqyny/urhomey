<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PenyewaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penyewa = Penyewa::with('kamar')
            ->orderBy('nama_lengkap', 'asc')
            ->get();

        $kamars = Kamar::where('status_kamar', 'kosong')->get();

        return view('datapenyewa', compact('penyewa', 'kamars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kamars = Kamar::where('status_kamar', 'kosong')->get();
        return view('datapenyewa', compact('kamars'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_penyewa' => 'required|unique:penyewa,id_penyewa',
            'username' => 'required|unique:penyewa,username|min:3|max:50',
            'password' => 'required|min:6|confirmed',
            'nama_lengkap' => 'required|max:100',
            'nomor_telepon' => 'required|max:15',
            'nomor_kamar' => 'nullable|exists:kamar,nomor_kamar'
        ]);

        // Buat penyewa baru
        $penyewa = Penyewa::create([
            'id_penyewa' => $request->id_penyewa,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'nomor_telepon' => $request->nomor_telepon
        ]);

        // Jika ada nomor kamar yang dipilih, update status kamar
        if ($request->nomor_kamar) {
            $kamar = Kamar::where('nomor_kamar', $request->nomor_kamar)->first();
            if ($kamar && $kamar->status_kamar === 'kosong') {
                $kamar->update([
                    'id_penyewa' => $penyewa->id_penyewa,
                    'status_kamar' => 'terisi'
                ]);
            }
        }

        return redirect()->route('penyewa.index')->with('success', 'Penyewa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id_penyewa)
    {
        $penyewa = Penyewa::with('kamar')->findOrFail($id_penyewa);
        return view('penyewa.show', compact('penyewa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_penyewa)
    {
        $penyewa = Penyewa::with('kamar')->findOrFail($id_penyewa);
        $kamars = Kamar::where('status_kamar', 'kosong')
            ->orWhere('nomor_kamar', $penyewa->kamar?->nomor_kamar)
            ->get();

        return view('datapenyewa', compact('penyewa', 'kamars'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_penyewa)
    {
        $penyewa = Penyewa::findOrFail($id_penyewa);

        $request->validate([
            'username' => [
                'required',
                'min:3',
                'max:50',
                Rule::unique('penyewa')->ignore($penyewa->id_penyewa, 'id_penyewa')
            ],
            'nama_lengkap' => 'required|max:100',
            'nomor_telepon' => 'required|max:15',
            'nomor_kamar' => 'nullable|exists:kamar,nomor_kamar',
            'password' => 'nullable|min:6|confirmed'
        ]);

        $updateData = [
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'nomor_telepon' => $request->nomor_telepon
        ];

        // Update password jika diisi
        if ($request->password) {
            $updateData['password'] = Hash::make($request->password);
        }

        $penyewa->update($updateData);

        // Handle perubahan kamar
        $this->updateKamarPenyewa($penyewa, $request->nomor_kamar);

        return redirect()->route('penyewa.index')->with('success', 'Data penyewa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_penyewa)
    {
        $penyewa = Penyewa::findOrFail($id_penyewa);

        // Kosongkan kamar yang ditempati penyewa
        if ($penyewa->kamar) {
            $penyewa->kamar->update([
                'id_penyewa' => null,
                'status_kamar' => 'kosong'
            ]);
        }

        $penyewa->delete();

        return redirect()->route('penyewa.index')->with('success', 'Penyewa berhasil dihapus');
    }

    /**
     * Update kamar yang ditempati penyewa
     */
    private function updateKamarPenyewa(Penyewa $penyewa, $nomorKamarBaru)
    {
        $kamarSekarang = $penyewa->kamar;
        $kamarBaru = $nomorKamarBaru ? Kamar::where('nomor_kamar', $nomorKamarBaru)->first() : null;

        // Kosongkan kamar sekarang jika ada
        if ($kamarSekarang) {
            $kamarSekarang->update([
                'id_penyewa' => null,
                'status_kamar' => 'kosong'
            ]);
        }

        // Isi kamar baru jika dipilih
        if ($kamarBaru && $kamarBaru->status_kamar === 'kosong') {
            $kamarBaru->update([
                'id_penyewa' => $penyewa->id_penyewa,
                'status_kamar' => 'terisi'
            ]);
        }
    }

    /**
     * API untuk mendapatkan kamar kosong (untuk AJAX)
     */
    public function getKamarKosong()
    {
        $kamars = Kamar::where('status_kamar', 'kosong')
            ->select('nomor_kamar', 'lokasi_lantai')
            ->get();

        return response()->json($kamars);
    }

    /**
     * Pindahkan penyewa ke kamar lain
     */
    public function pindahKamar(Request $request, $id_penyewa)
    {
        $request->validate([
            'nomor_kamar_baru' => 'required|exists:kamar,nomor_kamar'
        ]);

        $penyewa = Penyewa::findOrFail($id_penyewa);
        $this->updateKamarPenyewa($penyewa, $request->nomor_kamar_baru);

        return redirect()->route('penyewa.index')->with('success', 'Penyewa berhasil dipindahkan ke kamar baru');
    }

    /**
     * Kosongkan kamar penyewa
     */
    public function kosongkanKamar($id_penyewa)
    {
        $penyewa = Penyewa::findOrFail($id_penyewa);

        if ($penyewa->kamar) {
            $penyewa->kamar->update([
                'id_penyewa' => null,
                'status_kamar' => 'kosong'
            ]);
        }

        return redirect()->route('penyewa.index')->with('success', 'Kamar berhasil dikosongkan');
    }
}