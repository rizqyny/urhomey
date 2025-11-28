<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isvalid
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role = null): Response
    {
        $penyewa = $request->session()->get('penyewa.username');
        $pemilik = $request->session()->get('pemilik.username');

        if ($role === 'transaksi') {

            if (!$penyewa && !$pemilik) {
                return redirect()->route('login');
            }

            if ($pemilik && !$penyewa) {
                return back()->with('error', 'Pemilik tidak bisa mengakses halaman transaksi.');
            }

            return $next($request);
        }

        if ($role === 'penyewa' && !$penyewa) {
            return back();
        }

        if ($role === 'pemilik' && !$pemilik) {
            return back();
        }

        return $next($request);
    }

}
