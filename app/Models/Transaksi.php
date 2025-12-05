<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'nomor_kamar',
        'id_metode',
        'tanggal_transaksi',
        'nominal',
        'status',
        'berakhir',
        'bukti_pembayaran'
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'nomor_kamar');
    }

    public function metode()
    {
        return $this->belongsTo(MetodePembayaran::class, 'id_metode');
    }
}
