<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    protected $table = 'penyewa';

    protected $primaryKey = 'id_penyewa';

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'nomor_telepon'
    ];

    public function penyewa()
    {
        return $this->belongsTo(Kamar::class);
    }
}
