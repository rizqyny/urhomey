@extends('layouts.app')

@section('title', 'Lapor Kerusakan')

@section('content')
<div class="max-w-3xl mx-auto mt-28 px-4 sm:px-6 lg:px-8 space-y-6">

    <div>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
            Lapor Kerusakan
        </h1>
        <p class="mt-1 text-sm text-gray-500">
            Sampaikan keluhan terkait kerusakan fasilitas kamar agar segera ditindaklanjuti.
        </p>
    </div>

    @if (session('success'))
        <div class="flex items-start gap-3 bg-emerald-50 text-emerald-800 border border-emerald-100 px-4 py-3 rounded-2xl text-sm shadow-sm">
            <div class="mt-0.5">
                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 text-xs font-bold">
                    ✓
                </span>
            </div>
            <div>
                <p class="font-semibold">Laporan terkirim</p>
                <p class="mt-0.5">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif

    @if ($kamar)
        <div class="relative overflow-hidden rounded-3xl bg-white shadow-xl border border-slate-100">
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-[#940000] via-orange-500 to-amber-400"></div>

            <div class="p-6 sm:p-8 space-y-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-[0.2em]">
                            Detail kamar
                        </p>
                        <p class="mt-1 text-lg font-semibold text-gray-900">
                            Kamar {{ $kamar->nomor_kamar }}
                        </p>
                    </div>
                </div>

                <form action="{{ route('laporan.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="space-y-2">
                        <label for="deskripsi_kerusakan" class="block text-sm font-semibold text-gray-800">
                            Deskripsi Kerusakan
                        </label>
                        <p class="text-xs text-gray-500">
                            Jelaskan kerusakan secara jelas, misalnya lokasi, tingkat kerusakan, dan sejak kapan terjadi.
                        </p>
                        <textarea
                            id="deskripsi_kerusakan"
                            name="deskripsi_kerusakan"
                            rows="5"
                            class="mt-1 w-full rounded-2xl border border-slate-200 bg-slate-50/60 px-3 py-3 text-sm text-gray-800 shadow-sm focus:border-[#940000] focus:ring-2 focus:ring-[#940000]/20 focus:outline-none resize-y placeholder:text-gray-400"
                            placeholder="Contoh: Lampu kamar mati sejak kemarin malam, AC tidak dingin meskipun sudah disetel 18°C, dll..."
                            required></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <span class="text-xs text-gray-400">
                            Laporan akan diteruskan ke pemilik kos.
                        </span>
                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-[#940000] px-5 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-[#7a0000] hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#940000]/70 transition">
                            <span>Kirim Laporan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="p-6 bg-amber-50 text-amber-800 rounded-2xl shadow-md border border-amber-100 space-y-1">
            <p class="font-semibold">
                Anda belum menyewa kamar.
            </p>
            <p class="text-sm">
                Penyewa hanya dapat mengirim laporan kerusakan setelah memiliki kamar aktif.
            </p>
        </div>
    @endif

</div>
@endsection
