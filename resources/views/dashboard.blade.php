@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section class="pt-8 space-y-10">

    {{-- BAGIAN ATAS --}}
    <div class="flex flex-col md:flex-row items-center gap-8 bg-white p-6 rounded-3xl shadow ">
        <div class="md:w-1/2">
            <img src="{{ asset('images/kos2.jpg') }}" class="rounded-3xl w-full shadow-md ">
        </div>

        <div class="md:w-1/2 space-y-4">
            <h2 class="text-4xl font-bold text-gray-800">
                Selamat datang!
            </h2>

            <p class="text-gray-600 text-lg leading-relaxed">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolorum vel corporis porro delectus autem, expedita atque quo architecto fuga, deserunt accusantium repellat odio ut quis eveniet, labore amet consequuntur nisi? Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium rerum dolores impedit. Eveniet reprehenderit tenetur, nemo pariatur quam temporibus odit quidem, atque fuga possimus laborum veritatis delectus adipisci rem deleniti.
            </p>
        </div>
    </div>


    {{-- GRID CARD --}}

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 pt-7">

        @foreach ($kamar as $item)
        <div class="bg-gray-100 rounded-2xl shadow-lg hover:shadow-2xl transition cursor-pointer overflow-hidden"
            onclick="openDetailModal({{ json_encode($item) }})">

            {{-- GAMBAR KAMAR --}}
            @if($item->gambar)
                <img src="{{ asset('storage/'.$item->gambar) }}"
                    class="w-full h-40 object-cover">
            @else
                <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-500 text-sm">
                    Tidak ada gambar
                </div>
            @endif

            {{-- ISI CARD --}}
            <div class="p-4 space-y-2">

                <h4 class="text-xl font-bold text-gray-800">
                    Kamar {{ $item->nomor_kamar }}
                </h4>

                <p class="text-gray-600 text-sm">
                    Harga:
                    <span class="font-semibold text-gray-800">Rp{{ number_format($item->kategori->harga, 0, ',', '.') }}</span>
                </p>

                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                    {{ $item->status_kamar == 'kosong'
                        ? 'bg-green-100 text-green-700'
                        : 'bg-red-100 text-red-700' }}">
                    {{ ucfirst($item->status_kamar) }}
                </span>

            </div>
        </div>
        @endforeach
    </div>

</div>
</section>


{{-- MODAL DETAIL KAMAR --}}
<div id="detailModal"
     class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">

    <div class="bg-white w-[700px] rounded-3xl p-6 shadow-2xl relative">

        <!-- Tombol Close -->
        <button onclick="closeDetailModal()"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold">
            &times;
        </button>

        <div class="grid grid-cols-2 gap-6">

            <!-- Gambar -->
            <div id="modalGambar"
                 class="h-64 w-full rounded-xl bg-gray-200 overflow-hidden flex items-center justify-center">
                <span class="text-gray-400 text-sm">Tidak ada gambar</span>
            </div>

            <!-- Informasi Kamar -->
            <div class="flex flex-col justify-between">

                <div>
                    <h2 id="modalNomor" class="text-2xl font-bold text-gray-800 mb-3"></h2>

                    <p class="text-gray-700 text-base mb-1">
                        <span class="font-semibold">Kategori:</span>
                        <span id="modalKategori"></span>
                    </p>

                    <p class="text-gray-700 text-base mb-1">
                        <span class="font-semibold">Lantai:</span>
                        <span id="modalLantai"></span>
                    </p>

                    <p class="text-gray-700 text-base mb-1">
                        <span class="font-semibold">Status:</span>
                        <span id="modalStatus"></span>
                    </p>

                    <p class="text-gray-700 text-lg mt-3">
                        <span class="font-semibold">Harga:</span>
                        <span id="modalHarga" class="text-red-600 font-bold"></span>
                    </p>
                </div>

                <!-- Perabotan -->
                <div class="bg-gray-100 p-4 rounded-xl mt-4">
                    <p class="font-semibold text-gray-800 mb-1">Perabotan:</p>
                    <div id="modalPerabotan" class="text-gray-700 text-sm leading-relaxed"></div>
                </div>

            </div>

        </div>
    </div>
</div>



<script>
function openDetailModal(item) {

    // Nomor kamar
    document.getElementById('modalNomor').innerText = "Kamar " + item.nomor_kamar;

    // Kategori
    document.getElementById('modalKategori').innerText = item.kategori?.nama_kategori ?? "-";

    // Lantai
    document.getElementById('modalLantai').innerText = item.lokasi_lantai;

    // Status
    document.getElementById('modalStatus').innerText = item.status_kamar;

    // Harga
    document.getElementById('modalHarga').innerText = `Rp ${new Intl.NumberFormat('id-ID').format(item.kategori.harga)}`;

    // Perabotan
    document.getElementById('modalPerabotan').innerText = item.perabotan ?? "-";

    // Gambar
    const gambarContainer = document.getElementById('modalGambar');
    if (item.gambar) {
        gambarContainer.innerHTML = `<img src="/storage/${item.gambar}" class="w-full h-full object-cover">`;
    } else {
        gambarContainer.innerHTML = `<span class="text-gray-500 text-sm">Tidak ada gambar</span>`;
    }

    // Tampilkan modal
    document.getElementById('detailModal').classList.remove('hidden');
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
}
</script>

@endsection
