@extends('layouts.app')

@section('title', 'Data Transaksi')

@section('content')
<div class="pt-24 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

    <div class="flex items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">
                Data Transaksi Penyewa
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Riwayat pembayaran kamar beserta status dan detail metodenya.
            </p>
        </div>
    </div>

    @if (session('success'))
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
        <div class="border-b border-slate-100 px-4 sm:px-6 py-3 flex items-center justify-between">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">
                Riwayat transaksi
            </p>
            <span class="text-xs text-gray-400">
                Total: {{ count($transaksi) }} transaksi
            </span>
        </div>

        <ul class="divide-y divide-slate-100">
            @foreach ($transaksi as $t)
                <li class="px-4 sm:px-6 py-4 hover:bg-slate-50/70 transition">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">

                        {{-- Kiri: info utama --}}
                        <div class="flex-1 space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-[0.16em]">
                                    ID #{{ $t->id_transaksi }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-slate-100 text-[11px] font-medium text-slate-700">
                                    Kamar {{ $t->nomor_kamar }}
                                </span>
                            </div>

                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-700">
                                <p>
                                    <span class="font-semibold text-gray-900">Metode:</span>
                                    <span class="ml-1">{{ $t->metode->nama_metode }}</span>
                                </p>
                                <p>
                                    <span class="font-semibold text-gray-900">Nominal:</span>
                                    <span class="ml-1 text-[#940000] font-bold">
                                        Rp{{ number_format($t->nominal, 0, ',', '.') }}
                                    </span>
                                </p>
                            </div>

                            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                <p>
                                    <span class="font-semibold text-gray-700">Tanggal:</span>
                                    <span class="ml-1">{{ $t->tanggal_transaksi }}</span>
                                </p>

                                <p class="flex items-center gap-1">
                                    <span class="font-semibold text-gray-700">Status:</span>
                                    @if ($t->status == 'menunggu')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[11px] font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Menunggu
                                        </span>
                                    @elseif($t->status == 'selesai')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 text-[11px] font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Dibatalkan
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        {{-- Kanan: aksi --}}
                        <div class="mt-2 md:mt-0 md:ml-6 flex items-center justify-start md:justify-end gap-2">
                            @if ($t->bukti_pembayaran)
                                    <a href="{{ asset('/bukti_pembayaran/' . $t->bukti_pembayaran) }}"
                                    target="_blank"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-sm transition">
                                        Lihat Bukti
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400 italic">Tidak ada bukti</span>
                                @endif

                            @if ($t->status == 'menunggu')
                                <form action="{{ route('transaksi.selesai', $t->id_transaksi) }}" method="POST">
                                    @csrf
                                    <button
                                        class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-sm transition">
                                        Tandai Selesai
                                    </button>
                                </form>

                                <form action="{{ route('transaksi.batalkan', $t->id_transaksi) }}" method="POST">
                                    @csrf
                                    <button
                                        class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-sm transition">
                                        Batalkan
                                    </button>
                                </form>
                            @elseif ($t->status == 'selesai')
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-700">
                                    <span class="w-4 h-4 flex items-center justify-center rounded-full bg-emerald-100 text-emerald-600 text-[10px]">
                                        ✓
                                    </span>
                                    Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-rose-700">
                                    <span class="w-4 h-4 flex items-center justify-center rounded-full bg-rose-100 text-rose-600 text-[10px]">
                                        !
                                    </span>
                                    Dibatalkan
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
