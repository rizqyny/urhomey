<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKerusakan extends Model
{
    protected $table = 'laporan_kerusakan';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_penyewa',
        'nomor_kamar',
        'deskripsi_kerusakan',
        'status_laporan',
    ];

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class, 'id_penyewa', 'id_penyewa');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'nomor_kamar', 'nomor_kamar');
    }
}
