@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<section class="pt-10">

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-3xl shadow-lg space-y-8">

        {{-- HEADER --}}
        <h2 class="text-3xl font-bold text-gray-800">
            Transaksi Pemesanan Kamar
        </h2>

        {{-- INFORMASI KAMAR --}}
        <div class="bg-gray-100 p-5 rounded-2xl">
            <h3 class="text-xl font-semibold text-gray-700">Informasi Kamar</h3>
            <p class="text-gray-700"><strong>Kamar:</strong> {{ $kamar->nomor_kamar }}</p>
            <p class="text-gray-700"><strong>Kategori:</strong> {{ $kamar->kategori->nama_kategori }}</p>
            <p class="text-gray-700"><strong>Harga:</strong> Rp{{ number_format($kamar->kategori->harga, 0, ',', '.') }}</p>
        </div>

        {{-- INFORMASI PENYEWA --}}
        <div class="bg-gray-100 p-5 rounded-2xl">
            <h3 class="text-xl font-semibold text-gray-700">Data Penyewa</h3>
            <p class="text-gray-700"><strong>Nama:</strong> {{ $penyewa->nama_lengkap }}</p>
            <p class="text-gray-700"><strong>Username:</strong> {{ $penyewa->username }}</p>
            <p class="text-gray-700"><strong>No. Telepon:</strong> {{ $penyewa->nomor_telepon }}</p>
        </div>

        {{-- FORM PEMESANAN --}}
        <form action="{{ route('transaksi.store', $kamar->nomor_kamar) }}" method="POST" class="space-y-6">
            @csrf

            {{-- Hidden semua wajib --}}
            <input type="hidden" name="id_penyewa" value="{{ $penyewa->id_penyewa }}">
            <input type="hidden" name="nomor_kamar" value="{{ $kamar->nomor_kamar }}">
            <input type="hidden" name="nominal" value="{{ $kamar->kategori->harga }}">

            {{-- METODE PEMBAYARAN --}}
            <div>
                <label class="font-semibold">Pilih Metode Pembayaran:</label>
                <select name="id_metode" class="w-full border p-3 rounded-xl" required>
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    @foreach ($metode as $m)
                        <option value="{{ $m->id_metode }}">{{ $m->nama_metode }}</option>
                    @endforeach
                </select>
            </div>

            {{-- TOMBOL SUBMIT --}}
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl">
                Pesan Sekarang
            </button>
        </form>

    </div>

</section>
@endsection
