<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\TransaksiController;

Route::get('/', [PageController::class, 'dashboard'])->name('dashboard');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');

Route::middleware('isvalid:penyewa')->group(function () {

    // halaman transaksi detail
    Route::get('/transaksi/{nomor_kamar}', [TransaksiController::class, 'index'])
        ->name('transaksi.index');

    // proses order
    Route::post('/transaksi/store/{nomor_kamar}', [TransaksiController::class, 'store'])
        ->name('transaksi.store');

    Route::get('/kamarku', [PageController::class, 'kamarku'])->name('kamarku');

    Route::get('/datatransaksi', [TransaksiController::class, 'dataTransaksi'])
        ->name('transaksi.data');

    Route::post('/transaksi/selesai/{id_transaksi}', [TransaksiController::class, 'markSelesai'])
        ->name('transaksi.selesai');
});

Route::middleware('isvalid:pemilik')->group(function () {

    Route::get('/datakamar', [KamarController::class, 'index'])->name('kamar.index');
    Route::get('/datakamar/create', [KamarController::class, 'create'])->name('kamar.create');
    Route::post('/datakamar', [KamarController::class, 'store'])->name('kamar.store');
    Route::get('/datakamar/{nomor_kamar}/edit', [KamarController::class, 'edit'])->name('kamar.edit');
    Route::put('/datakamar/{nomor_kamar}', [KamarController::class, 'update'])->name('kamar.update');
    Route::delete('/datakamar/{nomor_kamar}', [KamarController::class, 'destroy'])->name('kamar.destroy');

    Route::get('/datapenyewa', [PenyewaController::class, 'index'])->name('penyewa.index');
    Route::get('/datapenyewa/create', [PenyewaController::class, 'create'])->name('penyewa.create');
    Route::post('/datapenyewa', [PenyewaController::class, 'store'])->name('penyewa.store');
    Route::get('/datapenyewa/{id_penyewa}/edit', [PenyewaController::class, 'edit'])->name('penyewa.edit');
    Route::put('/datapenyewa/{id_penyewa}', [PenyewaController::class, 'update'])->name('penyewa.update');
    Route::delete('/datapenyewa/{id_penyewa}', [PenyewaController::class, 'destroy'])->name('penyewa.destroy');
});
