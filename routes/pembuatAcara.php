<?php

use App\Http\Controllers\AcaraController;
use App\Http\Controllers\PembuatAcaraController;
use Illuminate\Routing\Route;

Route::middleware(['auth', 'role:pembuat_event'])->group(function () {
    Route::get('/dashboard', [PembuatAcaraController::class, 'index'])->name('dashboard');
    Route::get('/event/create', [AcaraController::class, 'create'])->name('event.create');
    Route::post('/event/create', [AcaraController::class, 'store'])->name('event.store');
});
