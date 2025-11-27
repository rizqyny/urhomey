<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PenyewaController;

Route::get('/', [PageController::class, 'dashboard'])->name('dashboard');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');

Route::get('/kamarku', [PageController::class, 'kamarku'])
    ->middleware('isvalid:penyewa')
    ->name('kamarku');

Route::middleware('isvalid:pemilik')->group(function () {

    Route::get('/datakamar', [KamarController::class, 'index'])->name('kamar.index');
    Route::get('/datakamar/create', [KamarController::class, 'create'])->name('kamar.create');
    Route::post('/datakamar', [KamarController::class, 'store'])->name('kamar.store');
    Route::get('/datakamar/{nomor_kamar}/edit', [KamarController::class, 'edit'])->name('kamar.edit');
    Route::put('/datakamar/{nomor_kamar}', [KamarController::class, 'update'])->name('kamar.update');
    Route::delete('/datakamar/{nomor_kamar}', [KamarController::class, 'destroy'])->name('kamar.destroy');

    Route::get('/datapenyewa', [PenyewaController::class, 'index'])->name('penyewa.index');
});
