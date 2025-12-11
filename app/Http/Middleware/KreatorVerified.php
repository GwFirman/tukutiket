<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KreatorVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Cek apakah user punya role kreator
        if (! $user->hasRole('kreator')) {
            return redirect()->route('beranda')
                ->with('error', 'Anda harus menjadi kreator terlebih dahulu.');
        }

        // Ambil data kreator
        $kreator = $user->kreator;

        // Cek apakah kreator sudah ada
        if (! $kreator) {
            return redirect()->route('kreator.register')
                ->with('error', 'Lengkapi data kreator terlebih dahulu.');
        }

        // Ambil data verifikasi
        $verifikasi = $kreator->verifikasi;

        // Cek apakah sudah ada data verifikasi dan status approved
        if (! $verifikasi || $verifikasi->status !== 'approved') {
            return redirect()->route('pembuat.verifikasi-data.index')
                ->with('warning', 'Akun Anda belum terverifikasi. Silakan lengkapi proses verifikasi untuk mengakses fitur ini.');
        }

        return $next($request);
    }
}
