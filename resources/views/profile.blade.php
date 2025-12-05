@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="min-h-screen bg-white from-slate-900 via-slate-950 to-slate-900 flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-3xl">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Pengaturan Akun</p>
                <h1 class="text-3xl md:text-4xl font-semibold text-white mt-1">Profil Saya</h1>
                <p class="text-sm text-slate-400 mt-2">
                    Kelola informasi dasar akunmu agar tetap up to date dan aman.
                </p>
            </div>
        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div class="mb-5 rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200 shadow-lg shadow-emerald-900/40">
                {{ session('success') }}
            </div>
        @endif

        {{-- Card --}}
        <div
            class="relative overflow-hidden rounded-2xl border border-white/10 bg-white/5 shadow-[0_18px_60px_rgba(15,23,42,0.9)] backdrop-blur-xl">
            {{-- Decorative top border --}}
            <div class="h-1 w-full bg-gradient-to-r from-rose-500 via-amber-400 to-emerald-400"></div>

            <div class="p-6 md:p-8">
                {{-- Profile mini header --}}
                <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-rose-500 to-amber-400 text-xl font-semibold text-white shadow-lg shadow-rose-900/40">
                            {{ strtoupper(substr($penyewa->nama_lengkap, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm text-slate-400">Masuk sebagai</p>
                            <p class="text-base font-medium text-black">{{ $penyewa->nama_lengkap }}</p>
                            <p class="text-xs text-slate-500">Username: {{ $penyewa->username }}</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-slate-700/60 px-3 py-1 text-[11px] font-medium uppercase tracking-[0.2em] text-black">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        Data tersimpan aman
                    </span>
                </div>

                {{-- Form --}}
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-black">
                            Nama Lengkap
                        </label>
                        <input
                            type="text"
                            name="nama_lengkap"
                            value="{{ $penyewa->nama_lengkap }}"
                            class="w-full rounded-xl border border-slate-700/80 bg-slate-900/60 px-3.5 py-2.5 text-sm text-slate-100 shadow-inner shadow-black/40 outline-none transition focus:border-rose-400 focus:bg-slate-900 focus:ring-2 focus:ring-rose-500/40 placeholder:text-slate-500"
                            placeholder="Masukkan nama lengkap"
                        >
                    </div>

                    {{-- Username --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-black">
                            Username
                        </label>
                        <input
                            type="text"
                            name="username"
                            value="{{ $penyewa->username }}"
                            class="w-full rounded-xl border border-slate-700/80 bg-slate-900/60 px-3.5 py-2.5 text-sm text-slate-100 shadow-inner shadow-black/40 outline-none transition focus:border-rose-400 focus:bg-slate-900 focus:ring-2 focus:ring-rose-500/40 placeholder:text-slate-500"
                            placeholder="Masukkan username"
                        >
                    </div>

                    {{-- Nomor Telepon --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-black">
                            Nomor Telepon
                        </label>
                        <input
                            type="text"
                            name="nomor_telepon"
                            value="{{ $penyewa->nomor_telepon }}"
                            class="w-full rounded-xl border border-slate-700/80 bg-slate-900/60 px-3.5 py-2.5 text-sm text-slate-100 shadow-inner shadow-black/40 outline-none transition focus:border-amber-400 focus:bg-slate-900 focus:ring-2 focus:ring-amber-400/40 placeholder:text-slate-500"
                            placeholder="Masukkan nomor telepon"
                        >
                    </div>

                    {{-- Password --}}
                    <div class="pt-1">
                        <div class="flex items-center justify-between">
                            <label class="mb-1.5 block text-sm font-medium text-black">
                                Password
                                <span class="text-[11px] font-normal text-slate-400">(opsional)</span>
                            </label>
                            <span class="text-[11px] text-slate-500">
                                Kosongkan jika tidak ingin mengubah
                            </span>
                        </div>
                        <input
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            class="w-full rounded-xl border border-slate-700/80 bg-slate-900/60 px-3.5 py-2.5 text-sm text-slate-100 shadow-inner shadow-black/40 outline-none transition focus:border-emerald-400 focus:bg-slate-900 focus:ring-2 focus:ring-emerald-400/40 placeholder:text-slate-500"
                        >
                    </div>

                    {{-- Footer actions --}}
                    <div class="mt-6 flex flex-col gap-3 border-t border-slate-800/80 pt-5 md:flex-row md:items-center md:justify-between">
                        <p class="text-xs text-slate-500">
                            Perubahan akan langsung tersimpan ke akunmu.
                        </p>
                        <div class="flex gap-3 justify-end">
                            <a
                                href="{{ url()->previous() }}"
                                class="inline-flex items-center justify-center rounded-xl border border-slate-700/80 bg-slate-900/60 px-4 py-2 text-xs md:text-sm font-medium text-slate-200 shadow-sm shadow-black/40 transition hover:border-slate-500 hover:bg-slate-900">
                                Batal
                            </a>
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-rose-600 via-red-700 to-amber-500 px-5 py-2 text-xs md:text-sm font-semibold text-white shadow-lg shadow-rose-900/50 transition hover:brightness-110 hover:shadow-xl hover:shadow-rose-900/70 focus:outline-none focus:ring-2 focus:ring-rose-500/60 focus:ring-offset-2 focus:ring-offset-slate-900">
                                <span>Simpan Perubahan</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
