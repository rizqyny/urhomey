@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section class="pt-10 space-y-10">

    <div class="relative overflow-hidden rounded-3xl shadow-xl">
        <div class="absolute inset-0">
            <img src="{{ asset('images/kos2.jpg') }}" class="w-full h-full object-cover" alt="Background Image">
            <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/40 to-black/10"></div>
        </div>

        <div class="relative z-10 px-6 py-10 md:px-12 md:py-14">
            <div class="max-w-2xl bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 md:p-8 shadow-lg">
                <p class="text-xs font-semibold tracking-[0.25em] uppercase text-white/80 mb-2">
                    UrHomey
                </p>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight">
                    Selamat datang di UrHomey!
                </h2>
                <p class="mt-4 text-sm md:text-base text-white/90 leading-relaxed">
                    UrHomey adalah sistem informasi kos berbasis web yang mempermudah administrasi dan komunikasi
                    antara pemilik kos dan penyewa, mulai dari melihat ketersediaan kamar hingga melakukan pemesanan
                    secara langsung tanpa menunggu respon manual.
                </p>
                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/15 text-white text-xs md:text-sm font-medium backdrop-blur">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Booking online 24/7
                    </span>
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 text-white/90 text-xs md:text-sm">
                        Wifi, Dapur, Kulkas, Dispenser, Jemuran.
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between gap-4">
        <div>
            <h3 class="text-xl md:text-2xl font-bold text-gray-900">
                Daftar Kamar
            </h3>
            <p class="text-sm text-gray-500 mt-1">
                Klik kartu kamar untuk melihat detail lengkap, perabotan, dan melakukan pemesanan.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 pt-4">

        @foreach ($kamar as $item)
        <div
            class="group relative bg-gradient-to-b from-white to-slate-50 border border-slate-100/80 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-200 cursor-pointer overflow-hidden"
            onclick="openDetailModal({{ json_encode($item) }})">

            <div class="absolute top-3 left-3 z-10">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold
                    {{ $item->status_kamar == 'kosong'
                        ? 'bg-emerald-100 text-emerald-700'
                        : 'bg-rose-100 text-rose-700' }}">
                    {{ ucfirst($item->status_kamar) }}
                </span>
            </div>

            @if($item->gambar)
                <div class="relative h-40">
                    <img src="{{ asset('storage/'.$item->gambar) }}"
                        class="w-full h-full object-cover transition duration-200 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                </div>
            @else
                <div class="h-40 w-full bg-slate-100 flex items-center justify-center text-slate-400 text-xs font-medium">
                    Tidak ada gambar
                </div>
            @endif

            <div class="p-4 space-y-2">
                <h4 class="text-lg font-semibold text-gray-900 flex items-center justify-between">
                    <span>Kamar {{ $item->nomor_kamar }}</span>
                    <span class="text-xs text-gray-400">
                        Lantai {{ $item->lokasi_lantai }}
                    </span>
                </h4>

                <p class="text-xs text-gray-500">
                    Kategori:
                    <span class="font-medium text-gray-700">
                        {{ $item->kategori->nama_kategori ?? '-' }}
                    </span>
                </p>

                <p class="text-sm text-gray-600">
                    Harga:
                    <span class="font-semibold text-rose-600">
                        Rp{{ number_format($item->kategori->harga, 0, ',', '.') }}
                    </span>
                    <span class="text-xs text-gray-400">/bulan</span>
                </p>

                <div class="pt-2 flex items-center justify-between">
                    <span class="text-[11px] text-gray-400">
                        Klik untuk lihat detail
                    </span>
                    <span class="inline-flex items-center gap-1 text-[11px] font-medium text-blue-600 group-hover:text-blue-700">
                        Lihat
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.293 3.293a1 1 0 011.414 0l5 5a.997.997 0 01.21.326.997.997 0 010 .762.997.997 0 01-.21.326l-5 5a1 1 0 11-1.414-1.414L13.586 11H4a1 1 0 110-2h9.586l-3.293-3.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</section>

{{-- MODAL DETAIL --}}
<div id="detailModal"
     class="fixed inset-0 z-50 hidden">
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

    {{-- Dialog wrapper --}}
    <div class="relative z-10 flex items-center justify-center min-h-screen px-4">
        <div class="relative w-full max-w-3xl rounded-3xl bg-white/95 backdrop-blur-xl shadow-2xl border border-slate-100/80 overflow-hidden">

            {{-- Top accent bar --}}
            <div class="h-1 w-full bg-gradient-to-r from-[#940000] via-rose-500 to-amber-400"></div>

            {{-- Close button --}}
            <button
                onclick="closeDetailModal()"
                class="absolute top-4 right-4 inline-flex items-center justify-center w-9 h-9 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition text-xl font-bold shadow-sm">
                &times;
            </button>

            <div class="p-6 md:p-7">
                <div class="flex items-center justify-between gap-3 mb-4">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-gray-400">
                            Detail kamar
                        </p>
                        <h2 id="modalNomor" class="text-2xl font-bold text-gray-900"></h2>
                    </div>
                    <span id="modalStatus"
                          class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700">
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                    <div id="modalGambar"
                         class="h-64 w-full rounded-2xl bg-slate-100 overflow-hidden flex items-center justify-center shadow-inner">
                        <span class="text-slate-400 text-sm">Tidak ada gambar</span>
                    </div>

                    <div class="flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold text-gray-800">Kategori:</span>
                                <span id="modalKategori" class="ml-1"></span>
                            </p>

                            <p class="text-sm text-gray-600">
                                <span class="font-semibold text-gray-800">Lantai:</span>
                                <span id="modalLantai" class="ml-1"></span>
                            </p>

                            <p class="text-lg text-gray-800 mt-3">
                                <span class="font-semibold">Harga:</span>
                                <span id="modalHarga" class="text-rose-600 font-extrabold ml-1"></span>
                                <span class="text-xs text-gray-400">/bulan</span>
                            </p>
                        </div>

                        <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl shadow-sm">
                            <p class="font-semibold text-gray-800 mb-1 text-sm">Perabotan</p>
                            <div id="modalPerabotan" class="text-gray-700 text-sm leading-relaxed"></div>
                        </div>

                        <div class="pt-1">
                            <a id="pesanButton"
                               href="#"
                               class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-semibold py-3 px-4 rounded-xl text-center block transition duration-200 shadow-md hover:shadow-lg">
                                Pesan Sekarang
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
function openDetailModal(item) {
    document.getElementById('modalNomor').innerText = "Kamar " + item.nomor_kamar;
    document.getElementById('modalKategori').innerText = item.kategori?.nama_kategori ?? "-";
    document.getElementById('modalLantai').innerText = item.lokasi_lantai;

    const statusElement = document.getElementById('modalStatus');
    statusElement.innerText = item.status_kamar;

    if (item.status_kamar === 'kosong') {
        statusElement.className = 'ml-1 text-emerald-600 font-semibold';
    } else {
        statusElement.className = 'ml-1 text-rose-600 font-semibold';
    }

    document.getElementById('modalHarga').innerText =
        `Rp ${new Intl.NumberFormat('id-ID').format(item.kategori.harga)}`;

    document.getElementById('modalPerabotan').innerText = item.perabotan ?? "-";

    const gambarContainer = document.getElementById('modalGambar');
    if (item.gambar) {
        gambarContainer.innerHTML =
            `<img src="/storage/${item.gambar}" class="w-full h-full object-cover">`;
    } else {
        gambarContainer.innerHTML =
            `<span class="text-slate-500 text-sm">Tidak ada gambar</span>`;
    }

    const pesanButton = document.getElementById('pesanButton');
    if (item.status_kamar === 'kosong') {
        pesanButton.href = `/transaksi/${item.nomor_kamar}`;
        pesanButton.className =
            'w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl text-center block transition duration-200';
        pesanButton.innerText = 'Pesan Sekarang';
        pesanButton.onclick = null;
    } else {
        pesanButton.href = '#';
        pesanButton.className =
            'w-full bg-gray-400 text-white font-semibold py-3 px-4 rounded-xl text-center block cursor-not-allowed';
        pesanButton.innerText = 'Tidak Tersedia';
        pesanButton.onclick = function(e) { e.preventDefault(); };
    }

    document.getElementById('detailModal').classList.remove('hidden');
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
}
</script>

@endsection
