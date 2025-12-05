@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-24 px-4 sm:px-6 lg:px-8 space-y-6">

    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                Daftar Laporan Kerusakan
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Pantau dan tindak lanjuti laporan kerusakan dari penyewa secara terstruktur.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-start gap-3 bg-emerald-50 text-emerald-800 border border-emerald-100 px-4 py-3 rounded-2xl text-sm shadow-sm">
            <div class="mt-0.5">
                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 text-xs font-bold">
                    ✓
                </span>
            </div>
            <div>
                <p class="font-semibold">Berhasil</p>
                <p class="mt-0.5">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif

    <div class="bg-white/90 backdrop-blur rounded-3xl shadow-xl border border-slate-100">
        <div class="px-4 sm:px-6 py-3 border-b border-slate-100 flex items-center justify-between">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">
                Laporan kerusakan
            </p>
            <span class="text-xs text-gray-400">
                Total: {{ count($laporan) }} laporan
            </span>
        </div>

        <ul class="divide-y divide-slate-100">
            @foreach($laporan as $l)
                <li class="px-4 sm:px-6 py-4 hover:bg-slate-50/70 transition">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">

                        {{-- Kiri: info laporan --}}
                        <div class="flex-1 space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-[0.16em]">
                                    ID #{{ $l->id_laporan }}
                                </span>

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-slate-900/80 text-slate-50 text-[11px] font-medium">
                                    Kamar {{ $l->nomor_kamar }}
                                </span>

                                @if($l->penyewa)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 text-[11px] font-medium">
                                        {{ $l->penyewa->nama_lengkap }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 text-[11px] font-medium">
                                        Penyewa tidak diketahui
                                    </span>
                                @endif
                            </div>

                            <p class="mt-1 text-sm text-gray-800 line-clamp-2">
                                {{ $l->deskripsi_kerusakan }}
                            </p>

                            <div class="mt-1 text-xs text-gray-500 flex flex-wrap items-center gap-3">
                                <span class="font-semibold text-gray-700">Status:</span>
                                @if($l->status_laporan === 'belum ditangani')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[11px] font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Belum ditangani
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Sudah ditangani
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Kanan: aksi --}}
                        <div class="mt-2 md:mt-0 md:ml-6 flex items-center justify-start md:justify-end">
                            @if($l->status_laporan === 'belum ditangani')
                                <form method="POST" action="{{ route('laporan.updateStatus', $l->id_laporan) }}">
                                    @csrf
                                    <button
                                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-sm transition">
                                        Tandai Selesai
                                    </button>
                                </form>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-gray-500 italic">
                                    <span class="w-4 h-4 flex items-center justify-center rounded-full bg-emerald-100 text-emerald-600 text-[10px]">
                                        ✓
                                    </span>
                                    Sudah ditangani
                                </span>
                            @endif
                        </div>

                    </div>
                </li>
            @endforeach
        </ul>
    </div>

</div>
@endsection
