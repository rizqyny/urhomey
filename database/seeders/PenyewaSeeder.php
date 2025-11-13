<?php

namespace Database\Seeders;

use App\Models\Penyewa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenyewaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penyewas = [
            [
                'username' => 'apenk',
                'password' => 'Apenk123',
                'nama_lengkap' => 'Raffel Prajadinata',
                'nomor_telepon' => '081234567890'
            ]
        ];

        foreach ($penyewas as $penyewa) {
            Penyewa::create($penyewa);
        }
    }
}
