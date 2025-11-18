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

{{-- <div x-data="{ openTambah: false }"> --}}

<div x-data="kamarPage()">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-4xl font-extrabold">Data Kamar</h1>

        {{-- BUTTON TAMBAH (BUKA MODAL) --}}
        <button @click="openTambah = true"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 mt-10 rounded-lg shadow">
            + Tambah Kamar
        </button>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-500 text-white rounded">
            {{ session('success') }}
        </div>
    @endif


    {{-- ============================
          TABEL DATA KAMAR
         ============================ --}}
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#940000] text-lg text-white">
                <tr>
                    <th class="p-3 border">Nomor Kamar</th>
                    <th class="p-3 border">Kategori</th>
                    <th class="p-3 border">Lantai</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border">Perabotan</th>
                    <th class="p-3 border">Gambar</th>
                    <th class="p-3 border text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="bg-gray-200">
                @foreach ($kamar as $item)
                <tr class="hover:bg-gray-100 text-center">
                    <td class="p-3 border">{{ $item->nomor_kamar }}</td>
                    <td class="p-3 border">{{ $item->kategori->nama_kategori ?? 'Tidak ada' }}</td>
                    <td class="p-3 border">{{ $item->lokasi_lantai }}</td>

                    <td class="p-3 border">
                        <span class="px-2 py-1 rounded font-bold
                            {{ $item->status_kamar == 'kosong' ? 'text-green-600' : 'text-red-600' }}">
                            {{ ucfirst($item->status_kamar) }}
                        </span>
                    </td>

                    <td class="p-3 border">{{ $item->perabotan }}</td>

                    <td class="p-3 border">
                        @if($item->gambar)
                            <img src="{{ asset('storage/'.$item->gambar) }}" class="h-14 rounded">
                        @else
                            <span class="text-gray-400 text-sm">Tidak ada</span>
                        @endif
                    </td>

                    <td class="p-3 border text-center">
                        <div class="flex justify-center gap-2">

                            <button @click="openEditModal({
                                nomor_kamar: '{{ $item->nomor_kamar }}',
                                id_kategori: '{{ $item->id_kategori }}',
                                lokasi_lantai: '{{ $item->lokasi_lantai }}',
                                status_kamar: '{{ $item->status_kamar }}',
                                perabotan: '{{ addslashes($item->perabotan) }}'
                            })"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-xl">
                                Edit
                            </button>

                            <form action="{{ route('kamar.destroy', $item->nomor_kamar) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus kamar ini?')">
                                @csrf @method('DELETE')
                                <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-xl">
                                    Hapus
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>


    {{-- ============================
           MODAL POPUP TAMBAH KAMAR
       ============================ --}}
    <div x-show="openTambah" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-40"
         x-transition>
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-lg" @click.away="openTambah = false">

            <h2 class="text-2xl font-bold mb-4">Tambah Kamar</h2>

            <form action="{{ route('kamar.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="font-semibold">Nomor Kamar</label>
                    <input type="text" name="nomor_kamar" required
                        class="w-full border px-3 py-2 rounded">
                </div>

                <div class="mb-3">
                    <label class="font-semibold">Kategori</label>
                    <select name="id_kategori" required class="w-full border px-3 py-2 rounded">
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="font-semibold">Lantai</label>
                    <select name="lokasi_lantai" class="w-full border px-3 py-2 rounded">
                        <option value="1">Lantai 1</option>
                        <option value="2">Lantai 2</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="font-semibold">Status</label>
                    <select name="status_kamar" class="w-full border px-3 py-2 rounded">
                        <option value="kosong">Kosong</option>
                        <option value="terisi">Terisi</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="font-semibold block mb-1">Perabotan</label>

                    <div class="flex flex-col gap-2">

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


                <div class="mb-3">
                    <label class="font-semibold">Gambar</label>
                    <input type="file" name="gambar" class="w-full border px-3 py-2 rounded">
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <button type="button" @click="openTambah = false"
                        class="px-4 py-2 bg-gray-400 text-white rounded">
                        Batal
                    </button>

                    <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
    {{-- ============================
      MODAL POPUP EDIT KAMAR
   ============================ --}}
    <div x-show="openEdit" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-40"
    x-transition>
    <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-lg" @click.away="openEdit = false">

    <h2 class="text-2xl font-bold mb-4">Edit Kamar</h2>

    <form :action="editRoute" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="font-semibold">Nomor Kamar</label>
            <input type="text" name="nomor_kamar" x-model="editData.nomor_kamar" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-3">
            <label class="font-semibold">Kategori</label>
            <select name="id_kategori" x-model="editData.id_kategori" class="w-full border px-3 py-2 rounded">
                @foreach($kategori as $kat)
                    <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="font-semibold">Lantai</label>
            <select name="lokasi_lantai" x-model="editData.lokasi_lantai" class="w-full border px-3 py-2 rounded">
                <option value="1">Lantai 1</option>
                <option value="2">Lantai 2</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="font-semibold">Status</label>
            <select name="status_kamar" x-model="editData.status_kamar" class="w-full border px-3 py-2 rounded">
                <option value="kosong">Kosong</option>
                <option value="terisi">Terisi</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="font-semibold block mb-1">Perabotan</label>

            <div class="flex flex-col gap-2">

                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" value="Tempat tidur"
                           name="perabotan[]"
                           :checked="editData.perabotan?.includes('Tempat tidur')">
                    <span>Tempat Tidur</span>
                </label>

                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" value="Lemari"
                           name="perabotan[]"
                           :checked="editData.perabotan?.includes('Lemari')">
                    <span>Lemari</span>
                </label>

                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" value="Meja Belajar"
                           name="perabotan[]"
                           :checked="editData.perabotan?.includes('Meja Belajar')">
                    <span>Meja Belajar</span>
                </label>

                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" value="Kursi"
                           name="perabotan[]"
                           :checked="editData.perabotan?.includes('Kursi')">
                    <span>Kursi</span>
                </label>

            </div>
        </div>

        <div class="mb-3">
            <label class="font-semibold">Gambar Baru</label>
            <input type="file" name="gambar" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="flex justify-end gap-3 mt-4">
            <button type="button" @click="openEdit = false"
                class="px-4 py-2 bg-gray-400 text-white rounded">
                Batal
            </button>

            <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                Simpan Perubahan
            </button>
        </div>
    </form>

    </div>
    </div>


</div>


@endsection
