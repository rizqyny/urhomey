@extends('layouts.app')

@section('title', 'Data Penyewa')

@section('content')
<script>
    function penyewaPage() {
        return {
            openEdit: false,
            editData: {
                id_penyewa: '',
                username: '',
                nama_lengkap: '',
                nomor_telepon: '',
                nomor_kamar: '',
                password: '',
                password_confirmation: ''
            },
            editRoute: '',

            openEditModal(item) {
                this.openEdit = true;

                this.editData.id_penyewa = item.id_penyewa;
                this.editData.username = item.username;
                this.editData.nama_lengkap = item.nama_lengkap;
                this.editData.nomor_telepon = item.nomor_telepon;
                this.editData.nomor_kamar = item.kamar?.nomor_kamar || '';
                this.editData.password = '';
                this.editData.password_confirmation = '';

                this.editRoute = '/datapenyewa/' + item.id_penyewa;
            },

            pindahKamar(item) {
                const kamarBaru = prompt('Masukkan nomor kamar baru untuk ' + item.nama_lengkap + ':');
                if (kamarBaru) {
                    if (confirm(`Pindahkan ${item.nama_lengkap} ke kamar ${kamarBaru}?`)) {
                        fetch(`/datapenyewa/${item.id_penyewa}/pindah-kamar`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ nomor_kamar_baru: kamarBaru })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert('Gagal memindahkan kamar: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat memindahkan kamar');
                        });
                    }
                }
            },

            kosongkanKamar(item) {
                if (confirm(`Kosongkan kamar ${item.kamar?.nomor_kamar} yang ditempati oleh ${item.nama_lengkap}?`)) {
                    fetch(`/datapenyewa/${item.id_penyewa}/kosongkan-kamar`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Gagal mengosongkan kamar: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengosongkan kamar');
                    });
                }
            }
        }
    }
</script>

<div x-data="penyewaPage()">
    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-4xl font-extrabold">Data Penyewa</h1>
        {{-- TIDAK ADA TOMBOL TAMBAH --}}
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-500 text-white rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- ============================
          TABEL DATA PENYEWA
         ============================ --}}
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#940000] text-lg text-white">
                <tr>
                    <th class="p-3 border">ID Penyewa</th>
                    <th class="p-3 border">Username</th>
                    <th class="p-3 border">Password</th>
                    <th class="p-3 border">Nama Lengkap</th>
                    <th class="p-3 border">Nomor Telepon</th>
                    <th class="p-3 border">Kamar</th>
                    <th class="p-3 border text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="bg-gray-200">
                @foreach ($penyewa as $item)
                <tr class="hover:bg-gray-100 text-center">
                    <td class="p-3 border">{{ $item->id_penyewa }}</td>
                    <td class="p-3 border">{{ $item->username }}</td>
                    <td class="p-3 border">{{ $item->password }}</td>
                    <td class="p-3 border">{{ $item->nama_lengkap }}</td>
                    <td class="p-3 border">{{ $item->nomor_telepon }}</td>

                    {{-- KAMAR --}}
                    <td class="p-3 border">
                        @if($item->kamar)
                            <span class="font-semibold">{{ $item->kamar->nomor_kamar }}</span>
                        @else
                            <span class="text-gray-400 text-sm">Tidak ada kamar</span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td class="p-3 border text-center">
                        <div class="flex justify-center gap-2">
                            {{-- EDIT --}}
                            <button @click="openEditModal({
                                id_penyewa: '{{ $item->id_penyewa }}',
                                username: '{{ $item->username }}',
                                nama_lengkap: '{{ $item->nama_lengkap }}',
                                nomor_telepon: '{{ $item->nomor_telepon }}',
                                kamar: {
                                    nomor_kamar: '{{ $item->kamar->nomor_kamar ?? '' }}'
                                }
                            })"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-xl">
                                Edit
                            </button>

                            {{-- PINDAH KAMAR --}}
                            @if($item->kamar)
                            <button @click="pindahKamar({
                                id_penyewa: '{{ $item->id_penyewa }}',
                                nama_lengkap: '{{ $item->nama_lengkap }}',
                                kamar: {
                                    nomor_kamar: '{{ $item->kamar->nomor_kamar }}'
                                }
                            })"
                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded-xl">
                                Pindah Kamar
                            </button>
                            @endif

                            {{-- KOSONGKAN KAMAR --}}
                            @if($item->kamar)
                            <button @click="kosongkanKamar({
                                id_penyewa: '{{ $item->id_penyewa }}',
                                nama_lengkap: '{{ $item->nama_lengkap }}',
                                kamar: {
                                    nomor_kamar: '{{ $item->kamar->nomor_kamar }}'
                                }
                            })"
                            class="bg-orange-600 hover:bg-orange-700 text-white px-3 py-1 rounded-xl">
                                Kosongkan Kamar
                            </button>
                            @endif

                            {{-- HAPUS --}}
                            <form action="{{ route('penyewa.destroy', $item->id_penyewa) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus penyewa {{ $item->nama_lengkap }}?')">
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
          MODAL POPUP EDIT PENYEWA
         ============================ --}}
    <div x-show="openEdit" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-40"
         x-transition>
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-lg" @click.away="openEdit = false">

            <h2 class="text-2xl font-bold mb-4">Edit Penyewa</h2>

            <form :action="editRoute" method="POST">
                @csrf
                @method('PUT')

                {{-- ID PENYEWA (readonly) --}}
                <div class="mb-3">
                    <label class="font-semibold">ID Penyewa</label>
                    <input type="text" x-model="editData.id_penyewa" readonly
                        class="w-full border px-3 py-2 rounded bg-gray-100">
                </div>

                {{-- USERNAME --}}
                <div class="mb-3">
                    <label class="font-semibold">Username</label>
                    <input type="text" name="username" x-model="editData.username" required
                        class="w-full border px-3 py-2 rounded">
                </div>

                {{-- NAMA LENGKAP --}}
                <div class="mb-3">
                    <label class="font-semibold">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" x-model="editData.nama_lengkap" required
                        class="w-full border px-3 py-2 rounded">
                </div>

                {{-- NOMOR TELEPON --}}
                <div class="mb-3">
                    <label class="font-semibold">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" x-model="editData.nomor_telepon" required
                        class="w-full border px-3 py-2 rounded">
                </div>

                {{-- KAMAR --}}
                <div class="mb-3">
                    <label class="font-semibold">Kamar</label>
                    <select name="nomor_kamar" x-model="editData.nomor_kamar" class="w-full border px-3 py-2 rounded">
                        <option value="">-- Pilih Kamar --</option>
                        @foreach($kamars as $kamar)
                            <option value="{{ $kamar->nomor_kamar }}"
                                {{ $kamar->status_kamar == 'terisi' && $kamar->id_penyewa != $item->id_penyewa ? 'disabled' : '' }}>
                                Kamar {{ $kamar->nomor_kamar }} - Lantai {{ $kamar->lokasi_lantai }}
                                {{ $kamar->status_kamar == 'terisi' ? '(Terisi)' : '(Kosong)' }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-gray-500">Pilih kamar untuk penyewa ini</small>
                </div>

                {{-- PASSWORD (opsional) --}}
                <div class="mb-3">
                    <label class="font-semibold">Password Baru (opsional)</label>
                    <input type="password" name="password" x-model="editData.password"
                        class="w-full border px-3 py-2 rounded" placeholder="Kosongkan jika tidak ingin mengubah">
                </div>

                {{-- PASSWORD CONFIRMATION --}}
                <div class="mb-3">
                    <label class="font-semibold">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" x-model="editData.password_confirmation"
                        class="w-full border px-3 py-2 rounded" placeholder="Konfirmasi password baru">
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