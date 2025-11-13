<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';

    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
        'harga'
    ];

    public function kamars()
    {
        return $this->hasMany(Kamar::class);
    }
}
