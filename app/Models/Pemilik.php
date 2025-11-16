<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemilik extends Model
{
    protected $table = 'pemilik';

    protected $primaryKey = 'id_pemilik';

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'nomor_telepon'
    ];
}