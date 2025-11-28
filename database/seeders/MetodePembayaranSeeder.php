<?php

namespace Database\Seeders;

use App\Models\MetodePembayaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MetodePembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metodes = [
            [

                'nama_metode' => 'Transfer'
            ],
            [
                'nama_metode' => 'Cash'
            ]
        ];

        foreach ($metodes as $metode) {
            MetodePembayaran::create($metode);
        }
    }
}
