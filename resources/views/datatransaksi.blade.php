@extends('layouts.app')

@section('title', 'Data Transaksi')

@section('content')

<div class="pt-8 container mx-auto">

    <h2 class="text-3xl font-bold text-gray-800 mb-6">
        Data Transaksi Penyewa
    </h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-2xl shadow">
        <table class="w-full border-collapse">
            <thead class="bg-[#940000] text-white">
                <tr>
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Kamar</th>
                    <th class="p-3 text-left">Metode</th>
                    <th class="p-3 text-left">Nominal</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody class="bg-gray-200">
                @foreach ($transaksi as $t)
                    <tr class="border-b">
                        <td class="p-3">{{ $t->id_transaksi }}</td>
                        <td class="p-3">Kamar {{ $t->nomor_kamar }}</td>
                        <td class="p-3">{{ $t->metode->nama_metode }}</td>
                        <td class="p-3">Rp{{ number_format($t->nominal, 0, ',', '.') }}</td>
                        <td class="p-3">
                            @if ($t->status == 'menunggu')
                                <span class="text-yellow-600 font-semibold">Menunggu</span>
                            @else
                                <span class="text-green-600 font-semibold">Selesai</span>
                            @endif
                        </td>

                        <td class="p-3">{{ $t->tanggal_transaksi }}</td>

                        <td class="p-3">
                            @if ($t->status == 'menunggu')
                                <div class="flex gap-2">

                                    <form action="{{ route('transaksi.selesai', $t->id_transaksi) }}" method="POST">
                                        @csrf
                                        <button class="bg-green-600 text-white px-4 py-2 rounded-lg">
                                            Tandai Selesai
                                        </button>
                                    </form>

                                    <form action="{{ route('transaksi.batalkan', $t->id_transaksi) }}" method="POST">
                                        @csrf
                                        <button class="bg-red-600 text-white px-4 py-2 rounded-lg">
                                            Batalkan
                                        </button>
                                    </form>

                                </div>
                            @elseif ($t->status == 'selesai')
                                <span class="text-green-600 font-semibold">✓ Selesai</span>
                            @else
                                <span class="text-red-600 font-semibold">Dibatalkan</span>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection
