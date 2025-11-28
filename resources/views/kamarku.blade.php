@extends('layouts.app')

@section('title', 'KamarKu')

@section('content')
<div class="container mx-auto mt-28">

    <h1 class="text-3xl font-bold mb-6">KamarKu</h1>

    @if ($kamar)
        <div class="p-6 bg-white rounded-2xl shadow-lg flex flex-col md:flex-row gap-6">

            <div class="w-full md:w-1/3">
                <img
                    src="{{ asset('storage/kamar/' . $kamar->gambar) }}"
                    alt="Foto Kamar"
                    class="rounded-xl shadow-md w-full object-cover"
                >
            </div>

            <div class="w-full md:w-2/3 space-y-3">

                <h2 class="text-2xl font-semibold mb-3">Informasi Kamar</h2>

                <p>
                    <strong>Nomor Kamar:</strong> {{ $kamar->nomor_kamar }}
                </p>

                <p>
                    <strong>Status:</strong>
                    <span class="capitalize">{{ $kamar->status_kamar }}</span>
                </p>

                <p>
                    <strong>Harga:</strong>
                    Rp {{ number_format($kamar->kategori->harga, 0, ',', '.') }}/bulan
                </p>

                <p>
                    <strong>Perabotan:</strong>
                    {{ $kamar->perabotan ?? '-' }}
                </p>

                <p>
                    <strong>Lantai:</strong>
                    Lantai {{ $kamar->lantai }}
                </p>

                <p>
                    <strong>Kode Kunci:</strong>
                    <span class="font-mono text-lg">{{ $kamar->kode_kunci }}</span>
                </p>

            </div>

        </div>

    @else
        <div class="p-6 bg-yellow-100 text-yellow-800 rounded-lg shadow-md">
            Anda belum menyewa kamar.
        </div>
    @endif

</div>
@endsection
