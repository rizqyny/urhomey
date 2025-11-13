<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/login', function () {
    return view('logreg.login');
})->name('logreg.login');

Route::get('/register', function () {
    return view('logreg.register');
})->name('logreg.register');
