@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<section class="pt-24 pb-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">
                Transaksi Pemesanan Kamar
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Periksa kembali detail kamar dan data Anda sebelum melanjutkan pemesanan.
            </p>
        </div>

        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
            <div class="h-1 w-full bg-gradient-to-r from-[#940000] via-rose-500 to-amber-400"></div>
            <div class="p-6 sm:p-8 space-y-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">
                            Ringkasan pesanan
                        </p>
                        <p class="mt-1 text-base font-semibold text-gray-900">
                            Kamar {{ $kamar->nomor_kamar }} • {{ $kamar->kategori->nama_kategori }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Total yang harus dibayar</p>
                        <p class="text-2xl font-extrabold text-[#940000]">
                            Rp{{ number_format($kamar->kategori->harga, 0, ',', '.') }}
                        </p>
                        <p class="text-[11px] text-gray-400">Per bulan</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="rounded-2xl border border-slate-100 bg-slate-50/60 p-4 space-y-1">
                        <h3 class="text-sm font-semibold text-gray-800 mb-1">
                            Informasi Kamar
                        </h3>
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Nomor:</span>
                            <span class="ml-1">Kamar {{ $kamar->nomor_kamar }}</span>
                        </p>
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Kategori:</span>
                            <span class="ml-1">{{ $kamar->kategori->nama_kategori }}</span>
                        </p>
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Harga:</span>
                            <span class="ml-1">
                                Rp{{ number_format($kamar->kategori->harga, 0, ',', '.') }}/bulan
                            </span>
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50/60 p-4 space-y-1">
                        <h3 class="text-sm font-semibold text-gray-800 mb-1">
                            Data Penyewa
                        </h3>
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Nama:</span>
                            <span class="ml-1">{{ $penyewa->nama_lengkap }}</span>
                        </p>
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Username:</span>
                            <span class="ml-1">{{ $penyewa->username }}</span>
                        </p>
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">No. Telepon:</span>
                            <span class="ml-1">{{ $penyewa->nomor_telepon }}</span>
                        </p>
                    </div>
                </div>

                <form action="{{ route('transaksi.store', $kamar->nomor_kamar) }}" method="POST" class="space-y-5" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id_penyewa" value="{{ $penyewa->id_penyewa }}">
                    <input type="hidden" name="nomor_kamar" value="{{ $kamar->nomor_kamar }}">
                    <input type="hidden" name="nominal" value="{{ $kamar->kategori->harga }}">

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800">
                            Pilih Metode Pembayaran
                        </label>
                        <p class="text-xs text-gray-500">
                            Pilih metode yang tersedia untuk menyelesaikan pemesanan kamar Anda.
                        </p>
                        <label class="block text-sm font-semibold text-gray-800">
                            Transfer ke:
                        </label>
                        <p class="text-xs text-black">
                            902 453 2920 2093
                        </p>
                        <select
                            name="id_metode"
                            class="mt-1 w-full border border-slate-200 rounded-2xl px-3 py-3 text-sm text-gray-800 bg-white focus:ring-2 focus:ring-[#940000]/20 focus:border-[#940000] outline-none"
                            required>
                            <option value="">-- Pilih Metode Pembayaran --</option>
                            @foreach ($metode as $m)
                                <option value="{{ $m->id_metode }}">{{ $m->nama_metode }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="block font-semibold mb-1">Upload Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran" class="border rounded p-2 w-full">
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-1">
                        <p class="text-xs text-gray-500">
                            Dengan melanjutkan, Anda menyetujui pemesanan kamar sesuai data di atas.
                        </p>
                        <button
                            type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center bg-[#940000] hover:bg-[#7a0000] text-white font-semibold text-sm px-6 py-3 rounded-2xl shadow-md hover:shadow-lg transition">
                            Pesan Sekarang
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</section>
@endsection
