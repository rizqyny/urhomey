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
            }
        }
    }
</script>

<div x-data="penyewaPage()" class="max-w-7xl mx-auto mt-24 px-4 sm:px-6 lg:px-8 space-y-6">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-2">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-gray-900">
                Data Penyewa
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Kelola akun penyewa, informasi kontak, dan kamar yang ditempati.
            </p>
        </div>
    </div>

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

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-5">
        @foreach ($penyewa as $item)
            <div class="relative bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-200 overflow-hidden flex flex-col">

                {{-- Header kecil --}}
                <div class="px-4 pt-4 flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-[#940000]/10 flex items-center justify-center text-[#940000] font-bold text-sm">
                            {{ strtoupper(substr($item->nama_lengkap, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-[0.16em]">
                                ID {{ $item->id_penyewa }}
                            </p>
                            <h2 class="text-sm font-bold text-gray-900">
                                {{ $item->nama_lengkap }}
                            </h2>
                            <p class="text-xs text-gray-500">
                                {{ '@'.$item->username }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-gray-400">Kamar</p>
                        @if($item->kamar)
                            <span class="inline-flex items-center px-2 py-1 rounded-full bg-indigo-50 text-indigo-700 text-[11px] font-semibold">
                                {{ $item->kamar->nomor_kamar }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full bg-slate-100 text-slate-500 text-[11px] font-medium">
                                Tidak ada kamar
                            </span>
                        @endif
                    </div>
                </div>

                <div class="px-4 pb-3 pt-2 space-y-2 text-xs text-gray-600">
                    <p>
                        <span class="font-semibold text-gray-800">Telepon:</span>
                        <span class="ml-1">{{ $item->nomor_telepon }}</span>
                    </p>
                    <p class="flex items-center gap-1">
                        <span class="font-semibold text-gray-800">Password:</span>
                        <span class="ml-1 truncate text-[11px] text-gray-500" title="{{ $item->password }}">
                            {{ $item->password }}
                        </span>
                    </p>
                </div>

                <div class="mt-auto px-4 pb-4 pt-2 border-t border-slate-100 bg-slate-50/60">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div class="flex flex-wrap gap-1 text-[10px] text-gray-400">
                            @if($item->kamar)
                                <button
                                    type="button"
                                    @click="pindahKamar({
                                        id_penyewa: '{{ $item->id_penyewa }}',
                                        nama_lengkap: '{{ $item->nama_lengkap }}'
                                    })"
                                    class="inline-flex items-center px-2 py-1 rounded-full bg-amber-50 text-amber-700 font-medium hover:bg-amber-100 transition">
                                </button>

                                <button
                                    type="button"
                                    @click="kosongkanKamar({
                                        id_penyewa: '{{ $item->id_penyewa }}',
                                        nama_lengkap: '{{ $item->nama_lengkap }}',
                                        kamar: { nomor_kamar: '{{ $item->kamar->nomor_kamar }}' }
                                    })"
                                    class="inline-flex items-center px-2 py-1 rounded-full bg-rose-50 text-rose-700 font-medium hover:bg-rose-100 transition">
                                </button>
                            @endif
                        </div>

                        <div class="flex items-center gap-2">
                            <button
                                @click="openEditModal({
                                    id_penyewa: '{{ $item->id_penyewa }}',
                                    username: '{{ $item->username }}',
                                    nama_lengkap: '{{ $item->nama_lengkap }}',
                                    nomor_telepon: '{{ $item->nomor_telepon }}',
                                    kamar: {
                                        nomor_kamar: '{{ $item->kamar->nomor_kamar ?? '' }}'
                                    }
                                })"
                                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1.5 rounded-xl shadow-sm transition">
                                Edit
                            </button>

                            <form action="{{ route('penyewa.destroy', $item->id_penyewa) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus penyewa {{ $item->nama_lengkap }}?')">
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

    <div x-show="openEdit"
         class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-40"
         x-transition>
        <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl p-6 sm:p-7 relative"
             @click.away="openEdit = false">

            <h2 class="text-2xl font-bold mb-4 text-gray-900">Edit Penyewa</h2>

            <form :action="editRoute" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-semibold mb-1">ID Penyewa</label>
                    <input type="text" x-model="editData.id_penyewa" readonly
                           class="w-full border border-slate-200 px-3 py-2 rounded-xl bg-gray-100 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Username</label>
                    <input type="text" name="username" x-model="editData.username" required
                           class="w-full border border-slate-200 px-3 py-2 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" x-model="editData.nama_lengkap" required
                           class="w-full border border-slate-200 px-3 py-2 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" x-model="editData.nomor_telepon" required
                           class="w-full border border-slate-200 px-3 py-2 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Password Baru (opsional)</label>
                    <input type="password" name="password" x-model="editData.password"
                           class="w-full border border-slate-200 px-3 py-2 rounded-xl text-sm"
                           placeholder="Kosongkan jika tidak ingin mengubah">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" x-model="editData.password_confirmation"
                           class="w-full border border-slate-200 px-3 py-2 rounded-xl text-sm"
                           placeholder="Konfirmasi password baru">
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
