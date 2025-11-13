<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kamar;

class KamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kamars = [
            ['nomor_kamar' => 101, 'id_kategori' => 1, 'perabotan' => 'Tempat Tidur, Lemari, Meja Belajar, Kursi', 'lokasi_lantai' => 'Lantai 1', 'status_kamar' => 'Tersedia'],
            ['nomor_kamar' => 102, 'id_kategori' => 1, 'perabotan' => 'Tempat Tidur, Lemari, Meja Belajar, Kursi', 'lokasi_lantai' => 'Lantai 1', 'status_kamar' => 'Tersedia'],
            ['nomor_kamar' => 103, 'id_kategori' => 1, 'perabotan' => 'Tempat Tidur, Lemari, Meja Belajar, Kursi', 'lokasi_lantai' => 'Lantai 1', 'status_kamar' => 'Tersedia'],
            ['nomor_kamar' => 104, 'id_kategori' => 1, 'perabotan' => 'Tempat Tidur, Lemari, Meja Belajar, Kursi', 'lokasi_lantai' => 'Lantai 1', 'status_kamar' => 'Tersedia'],
            ['nomor_kamar' => 105, 'id_kategori' => 1, 'perabotan' => 'Tempat Tidur, Lemari, Meja Belajar, Kursi', 'lokasi_lantai' => 'Lantai 1', 'status_kamar' => 'Tersedia'],
            ['nomor_kamar' => 106, 'id_kategori' => 2, 'perabotan' => 'Tempat Tidur, Lemari, Meja Belajar, Kursi', 'lokasi_lantai' => 'Lantai 1', 'status_kamar' => 'Tersedia'],
            ['nomor_kamar' => 107, 'id_kategori' => 2, 'perabotan' => 'Tempat Tidur, Lemari, Meja Belajar, Kursi', 'lokasi_lantai' => 'Lantai 1', 'status_kamar' => 'Tersedia'],
            ['nomor_kamar' => 108, 'id_kategori' => 2, 'perabotan' => 'Tempat Tidur, Lemari, Meja Belajar, Kursi', 'lokasi_lantai' => 'Lantai 1', 'status_kamar' => 'Tersedia'],
            ['nomor_kamar' => 109, 'id_kategori' => 2, 'perabotan' => 'Tempat Tidur, Lemari, Meja Belajar, Kursi', 'lokasi_lantai' => 'Lantai 1', 'status_kamar' => 'Tersedia'],
            ['nomor_kamar' => 110, 'id_kategori' => 2, 'perabotan' => 'Tempat Tidur, Lemari, Meja Belajar, Kursi', 'lokasi_lantai' => 'Lantai 1', 'status_kamar' => 'Tersedia'],
            ['nomor_kamar' => 201, 'id_kategori' => 1, 'perabotan' => 'Tempat Tidur, Lemari, Meja Belajar, Kursi', 'lokasi_lantai' => 'Lantai 2', 'status_kamar' => 'Tersedia'],
            ['nomor_kamar' => 202, 'id_kategori' => 1, 'perabotan' => 'Tempat Tidur, Lemari, Meja Belajar, Kursi', 'lokasi_lantai' => 'Lantai 2', 'status_kamar' => 'Tersedia'],
            ['nomor_kamar' => 203, 'id_kategori' => 1, 'perabotan' => 'Tempat Tidur, Lemari, Meja Belajar, Kursi', 'lokasi_lantai' => 'Lantai 2', 'status_kamar' => 'Tersedia'],
            ['nomor_kamar' => 204, 'id_kategori' => 1, 'perabotan' => 'Tempat Tidur, Lemari, Meja Belajar, Kursi', 'lokasi_lantai' => 'Lantai 2', 'status_kamar' => 'Tersedia'],
            ['nomor_kamar' => 205, 'id_kategori' => 1, 'perabotan' => 'Tempat Tidur, Lemari, Meja Belajar, Kursi', 'lokasi_lantai' => 'Lantai 2', 'status_kamar' => 'Tersedia'],
        ];

        foreach ($kamars as $kamar) {
            Kamar::create($kamar);
        }
    }
}
