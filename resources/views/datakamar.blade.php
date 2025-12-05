@extends('layouts.app')

@section('title', 'Data Kamar')

@section('content')
<script>
    function kamarPage() {
        return {
            openTambah: false,
            openEdit: false,

            editData: {
                nomor_kamar: '',
                id_kategori: '',
                lokasi_lantai: '',
                status_kamar: '',
                perabotan: []
            },

            editRoute: '',

            openEditModal(item) {
                this.openEdit = true;

                this.editData.nomor_kamar = item.nomor_kamar;
                this.editData.id_kategori = item.id_kategori;
                this.editData.lokasi_lantai = item.lokasi_lantai;
                this.editData.status_kamar = item.status_kamar;
                this.editData.perabotan = JSON.parse(item.perabotan);

                this.editRoute = '/datakamar/' + item.nomor_kamar;
            }
        }
    }
</script>

<div x-data="kamarPage()" class="max-w-7xl mx-auto mt-24 px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-gray-900">Data Kamar</h1>
            <p class="mt-1 text-sm text-gray-500">
                Kelola informasi kamar kos, termasuk status, perabotan, dan kode kunci.
            </p>
        </div>

        <button
            @click="openTambah = true"
            class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-md hover:shadow-lg transition mt-2 md:mt-6">
            <span class="text-lg leading-none">+</span>
            <span>Tambah Kamar</span>
        </button>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="flex items-start gap-3 mb-2 bg-emerald-50 text-emerald-800 border border-emerald-100 px-4 py-3 rounded-2xl text-sm shadow-sm">
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

    {{-- GRID CARD DATA KAMAR --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-5">
        @foreach ($kamar as $item)
            <div class="relative bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-200 overflow-hidden flex flex-col">

                {{-- Badge status + lantai --}}
                <div class="absolute top-3 left-3 flex flex-col gap-2 z-10">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold
                        {{ $item->status_kamar == 'kosong'
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'bg-rose-50 text-rose-700' }}">
                        {{ ucfirst($item->status_kamar) }}
                    </span>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium bg-slate-900/70 text-slate-50 backdrop-blur">
                        Lantai {{ $item->lokasi_lantai }}
                    </span>
                </div>

                {{-- Gambar --}}
                <div class="h-36 w-full bg-slate-100 relative">
                    @if($item->gambar)
                        <img src="{{ asset('storage/'.$item->gambar) }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-xs text-slate-400">
                            Tidak ada gambar
                        </div>
                    @endif
                    <div class="absolute inset-x-0 bottom-0 h-10 bg-gradient-to-t from-black/40 to-transparent"></div>
                </div>

                {{-- Isi kartu --}}
                <div class="flex-1 p-4 space-y-3">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-[0.18em]">
                                Kamar
                            </p>
                            <h2 class="text-lg font-bold text-gray-900">
                                {{ $item->nomor_kamar }}
                            </h2>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $item->kategori->nama_kategori ?? 'Tidak ada kategori' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-gray-400">Kode Kunci</p>
                            <p class="font-mono text-xs font-semibold text-gray-800 bg-slate-100 px-2 py-1 rounded">
                                {{ $item->kode_kunci }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-1 text-xs text-gray-600">
                        <p class="line-clamp-2">
                            <span class="font-semibold text-gray-800">Perabotan:</span>
                            <span class="ml-1">{{ $item->perabotan ?: '-' }}</span>
                        </p>
                    </div>
                </div>

                {{-- Aksi --}}
                <div class="px-4 pb-4 pt-2 border-t border-slate-100 bg-slate-50/60">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[10px] text-gray-400">
                            Terakhir diperbarui oleh admin.
                        </span>
                        <div class="flex items-center gap-2">
                            <button
                                @click="openEditModal({
                                    nomor_kamar: '{{ $item->nomor_kamar }}',
                                    id_kategori: '{{ $item->id_kategori }}',
                                    lokasi_lantai: '{{ $item->lokasi_lantai }}',
                                    status_kamar: '{{ $item->status_kamar }}',
                                    perabotan: '{{ addslashes($item->perabotan) }}'
                                })"
                                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1.5 rounded-xl shadow-sm transition">
                                Edit
                            </button>

                            <form action="{{ route('kamar.destroy', $item->nomor_kamar) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus kamar ini?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-1.5 rounded-xl shadow-sm transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

    {{-- MODAL TAMBAH KAMAR --}}
    <div x-show="openTambah"
         class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-40"
         x-transition>
        <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl p-6 sm:p-7 relative"
             @click.away="openTambah = false">

            <h2 class="text-2xl font-bold mb-4 text-gray-900">Tambah Kamar</h2>

            <form action="{{ route('kamar.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-semibold mb-1">Nomor Kamar</label>
                    <input type="text" name="nomor_kamar" required
                           class="w-full border border-slate-200 px-3 py-2 rounded-xl text-sm focus:ring-2 focus:ring-[#940000]/20 focus:border-[#940000]">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Kategori</label>
                    <select name="id_kategori" required
                            class="w-full border border-slate-200 px-3 py-2 rounded-xl text-sm focus:ring-2 focus:ring-[#940000]/20 focus:border-[#940000]">
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Lantai</label>
                    <select name="lokasi_lantai"
                            class="w-full border border-slate-200 px-3 py-2 rounded-xl text-sm focus:ring-2 focus:ring-[#940000]/20 focus:border-[#940000]">
                        <option value="1">Lantai 1</option>
                        <option value="2">Lantai 2</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Status</label>
                    <select name="status_kamar"
                            class="w-full border border-slate-200 px-3 py-2 rounded-xl text-sm focus:ring-2 focus:ring-[#940000]/20 focus:border-[#940000]">
                        <option value="kosong">Kosong</option>
                        <option value="terisi">Terisi</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Perabotan</label>
                    <div class="flex flex-col gap-2 text-sm">
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="perabotan[]" value="Tempat tidur" class="h-4 w-4">
                            <span>Tempat Tidur</span>
                        </label>

                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="perabotan[]" value="Lemari" class="h-4 w-4">
                            <span>Lemari</span>
                        </label>

                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="perabotan[]" value="Meja Belajar" class="h-4 w-4">
                            <span>Meja Belajar</span>
                        </label>

                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="perabotan[]" value="Kursi" class="h-4 w-4">
                            <span>Kursi</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Kode Kunci</label>
                    <input type="text" name="kode_kunci" required
                           class="w-full border border-slate-200 px-3 py-2 rounded-xl text-sm focus:ring-2 focus:ring-[#940000]/20 focus:border-[#940000]">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Gambar</label>
                    <input type="file" name="gambar"
                           class="w-full border border-slate-200 px-3 py-2 rounded-xl text-sm">
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="openTambah = false"
                            class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-xl">
                        Batal
                    </button>
                    <button
                        class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT KAMAR --}}
    <div x-show="openEdit"
         class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-40"
         x-transition>
        <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl p-6 sm:p-7 relative"
             @click.away="openEdit = false">

            <h2 class="text-2xl font-bold mb-4 text-gray-900">Edit Kamar</h2>

            <form :action="editRoute" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-semibold mb-1">Nomor Kamar</label>
                    <input type="text" name="nomor_kamar" x-model="editData.nomor_kamar"
                           class="w-full border border-slate-200 px-3 py-2 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Kategori</label>
                    <select name="id_kategori" x-model="editData.id_kategori"
                            class="w-full border border-slate-200 px-3 py-2 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Lantai</label>
                    <select name="lokasi_lantai" x-model="editData.lokasi_lantai"
                            class="w-full border border-slate-200 px-3 py-2 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <option value="1">Lantai 1</option>
                        <option value="2">Lantai 2</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Status</label>
                    <select name="status_kamar" x-model="editData.status_kamar"
                            class="w-full border border-slate-200 px-3 py-2 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <option value="kosong">Kosong</option>
                        <option value="terisi">Terisi</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Perabotan</label>
                    <div class="flex flex-col gap-2 text-sm">
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" value="Tempat tidur" name="perabotan[]"
                                   :checked="editData.perabotan?.includes('Tempat tidur')">
                            <span>Tempat Tidur</span>
                        </label>

                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" value="Lemari" name="perabotan[]"
                                   :checked="editData.perabotan?.includes('Lemari')">
                            <span>Lemari</span>
                        </label>

                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" value="Meja Belajar" name="perabotan[]"
                                   :checked="editData.perabotan?.includes('Meja Belajar')">
                            <span>Meja Belajar</span>
                        </label>

                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" value="Kursi" name="perabotan[]"
                                   :checked="editData.perabotan?.includes('Kursi')">
                            <span>Kursi</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Gambar Baru</label>
                    <input type="file" name="gambar"
                           class="w-full border border-slate-200 px-3 py-2 rounded-xl text-sm">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Kode Kunci</label>
                    <input type="text" name="kode_kunci" x-model="editData.kode_kunci"
                           class="w-full border border-slate-200 px-3 py-2 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="openEdit = false"
                            class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-xl">
                        Batal
                    </button>
                    <button
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
