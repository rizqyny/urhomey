<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function dashboard()
    {
        $username = session('username');
        return view('dashboard', ['username' => $username]);
    }

    public function kamarku()
    {
        return view('kamarku');
    }

    public function datakamar()
    {
        return view('datakamar');
    }

}