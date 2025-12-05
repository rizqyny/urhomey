@extends('layouts.app')

@section('title', 'KamarKu')

@section('content')
<div class="max-w-6xl mx-auto mt-28 px-4 sm:px-6 lg:px-8 space-y-6">

    <div class="flex items-center justify-between gap-4">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
            KamarKu
        </h1>
        @if ($kamar)
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium
                {{ $kamar->status_kamar === 'kosong'
                    ? 'bg-emerald-50 text-emerald-700'
                    : 'bg-blue-50 text-blue-700' }}">
                <span class="w-2 h-2 rounded-full
                    {{ $kamar->status_kamar === 'kosong' ? 'bg-emerald-500' : 'bg-blue-500' }}">
                </span>
                {{ ucfirst($kamar->status_kamar) }}
            </span>
        @endif
    </div>

    @if ($kamar)
        <div class="relative overflow-hidden rounded-3xl bg-white shadow-xl border border-slate-100">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                <div class="md:col-span-1">
                    <div class="h-full">
                        <img
                            src="{{ asset('storage/' . $kamar->gambar) }}"
                            alt="Foto Kamar"
                            class="h-full w-full object-cover md:rounded-l-3xl rounded-t-3xl md:rounded-tr-none"
                        >
                    </div>
                </div>

                {{-- DETAIL KAMAR --}}
                <div class="md:col-span-2 p-6 md:p-8 space-y-4">

                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-900">
                                Informasi Kamar
                            </h2>
                            <p class="text-sm text-gray-500 mt-1">
                                Detail kamar yang sedang Anda tempati saat ini.
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-xs text-gray-500">Harga per bulan</p>
                            <p class="text-2xl font-extrabold text-[#940000]">
                                Rp {{ number_format($kamar->kategori->harga, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 text-sm text-gray-700">
                        <p>
                            <strong class="font-semibold text-gray-900">Nomor Kamar:</strong>
                            <span class="ml-1">{{ $kamar->nomor_kamar }}</span>
                        </p>

                        <p>
                            <strong class="font-semibold text-gray-900">Status:</strong>
                            <span class="ml-1 capitalize">{{ $kamar->status_kamar }}</span>
                        </p>

                        <p>
                            <strong class="font-semibold text-gray-900">Perabotan:</strong>
                            <span class="ml-1">{{ $kamar->perabotan ?? '-' }}</span>
                        </p>

                        <p>
                            <strong class="font-semibold text-gray-900">Lantai:</strong>
                            <span class="ml-1">Lantai {{ $kamar->lokasi_lantai }}</span>
                        </p>

                        <p class="sm:col-span-2">
                            <strong class="font-semibold text-gray-900">Kode Kunci:</strong>
                            <span class="ml-1 font-mono text-lg tracking-wide bg-slate-100 px-2 py-1 rounded-md">
                                {{ $kamar->kode_kunci }}
                            </span>
                        </p>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs text-gray-500">
                        <p>
                            Simpan kode kunci dengan baik dan jangan dibagikan ke orang lain.
                        </p>
                        <p class="italic">
                            Hubungi pemilik kos jika ada kendala akses kamar.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    @else
        <div class="p-6 bg-amber-50 text-amber-800 rounded-2xl shadow-md border border-amber-100">
            <p class="font-semibold">
                Anda belum menyewa kamar.
            </p>
            <p class="text-sm mt-1">
                Silakan pilih kamar pada halaman dashboard atau hubungi pemilik kos untuk informasi lebih lanjut.
            </p>
        </div>
    @endif

</div>
@endsection
