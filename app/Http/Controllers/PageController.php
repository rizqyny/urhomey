<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Kategori;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function dashboard()
    {
        $username = session('username');

        $kamar = Kamar::with('kategori:id_kategori,nama_kategori,harga')->get();

        return view('dashboard', [
            'username' => $username,
            'kamar' => $kamar
        ]);
    }
}
