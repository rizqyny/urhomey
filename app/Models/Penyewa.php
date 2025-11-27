<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    protected $table = 'penyewa';

    protected $primaryKey = 'id_penyewa';
    public $incrementing = false;
    protected $keyType = 'integer';

    protected $fillable = [
        'id_penyewa',
        'username',
        'password',
        'nama_lengkap',
        'nomor_telepon'
    ];

    /**
     * Relasi One to One dengan Kamar
     * Penyewa memiliki satu Kamar
     */
    public function kamar()
    {
        return $this->hasOne(Kamar::class, 'id_penyewa', 'id_penyewa');
    }
}