<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'id_kategori' => 1,
                'nama_kategori' => 'Kamar Mandi Dalam',
                'harga' => 600000,
            ],
            [
                'id_kategori' => 2,
                'nama_kategori' => 'Kamar Mandi Luar',
                'harga' => 450000,
            ]
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}
