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

    public function login()
    {
        return view('logreg.login');
    }

    public function register()
    {
        return view('logreg.register');
    }
}