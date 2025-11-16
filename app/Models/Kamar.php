<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table = 'kamar';

    protected $primaryKey = 'nomor_kamar';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $cast = [
        'perabotan' => 'array',
    ];

    protected $fillable = [
        'nomor_kamar',
        'id_kategori',
        'id_penyewa',
        'perabotan',
        'lokasi_lantai',
        'status_kamar',
        'gambar'
    ];

    public function kategori() {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function penyewa() {
        return $this->belongsTo(Penyewa::class, 'id_penyewa');
    }
}
