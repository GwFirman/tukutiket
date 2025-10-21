<?php

use App\Http\Controllers\All\BerandaController;
use App\Http\Controllers\PembuatAcara\AcaraController as PembuatAcaraController;
use App\Http\Controllers\Pembeli\AcaraController as PembeliAcaraController;
use App\Http\Controllers\Pembeli\DashboardController as DashboardPembeliController;
use App\Http\Controllers\Pembeli\PesananController;
use App\Http\Controllers\Pembeli\TiketController;
use App\Http\Controllers\PembuatAcara\DashboardController as DashboardPembuatController;
// use App\Http\Controllers\PembuatAcaraController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [BerandaController::class,'index'])->name('beranda');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->hasRole('pembeli')) {
            return redirect()->route('pembeli.dashboard');
        } elseif ($user->hadRole('pembuat_event')) {
            return redirect()->route('pembuat.dashboard');
        }

        abort(403, 'Akses Ditolak');
    })->name('dashboard');
});

Route::middleware(['auth', 'role:pembuat_event'])
    ->prefix('pembuat_acara')
    ->name('pembuat.')
    ->group(function () {
        Route::get('/dashboard', [DashboardPembuatController::class, 'index'])->name('dashboard');
        Route::resource('/acara', PembuatAcaraController::class);
});

Route::middleware(['auth','role:pembeli'])
    ->prefix('pembeli')
    ->name('pembeli.')
    ->group(function () {
        Route::get('/dasboard',[DashboardPembeliController::class,'index'])->name('dashboard');
        Route::resource('tiket',TiketController::class);
        Route::resource('acara',PembeliAcaraController::class);
        Route::resource('checkout',PesananController::class);
        // Route::resource('tiket')
});
// Route::get('/dashboard', function () {
//     return view('beranda');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::middleware(['auth', 'role:pembuat_event'])->group(function () {
//     Route::get('/dashboard', [PembuatAcaraController::class, 'index'])->name('dashboard');
//     Route::get('/event/create', [AcaraController::class, 'create'])->name('event.create');
//     Route::post('/event/create', [AcaraController::class, 'store'])->name('event.store');
// });
require __DIR__.'/auth.php';
