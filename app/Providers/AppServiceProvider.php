<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Transaksi;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if (session()->has('penyewa.username')) {
                $username = session('penyewa.username');

                // Cari id penyewa berdasarkan username
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
