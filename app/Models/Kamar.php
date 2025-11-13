<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model {
    protected $table = 'kamar';

    protected $primaryKey = 'nomor_kamar';

    protected $fillable = [
        'id_kategori',
        'id_penyewa',
        'perabotan',
        'lokasi_lantai',
        'status_kamar'
    ];

    public function kategori() {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function penyewa() {
        return $this->belongsTo(Penyewa::class, 'id_penyewa');
    }
}