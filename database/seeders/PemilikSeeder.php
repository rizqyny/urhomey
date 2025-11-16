<?php

namespace Database\Seeders;

use App\Models\Pemilik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PemilikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pemilik = [
                'username' => 'admin',
                'password' => 'admin',
                'nama_lengkap' => 'Anna Xevanya',
                'nomor_telepon' => '081234567890'
        ];

        Pemilik::create($pemilik);
    }
}
