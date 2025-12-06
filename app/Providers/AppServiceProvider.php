<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Transaksi;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot()
    {
        View::composer('*', function ($view) {
            if (session()->has('penyewa.username')) {
                $username = session('penyewa.username');
                $penyewa = \App\Models\Penyewa::where('username', $username)->first();
                if ($penyewa) {
                    $notifikasi = \App\Models\Transaksi::whereHas('kamar', function ($q) use ($penyewa) {
                        $q->where('id_penyewa', $penyewa->id);
                    })
                    ->whereDate('berakhir', '=', now()->addDay()->toDateString())
                    ->first();
                    $view->with('notifikasiKamarHabis', $notifikasi);
                }
            }
        });
    }
}
