<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ModKretorController;
use App\Http\Controllers\All\BerandaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\Pembeli\AcaraController as PembeliAcaraController;
use App\Http\Controllers\Pembeli\DashboardController as DashboardPembeliController;
use App\Http\Controllers\Pembeli\ExportPDFController;
use App\Http\Controllers\Pembeli\PesananController;
use App\Http\Controllers\Pembeli\TiketController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PembuatAcara\AcaraController as PembuatAcaraController;
use App\Http\Controllers\PembuatAcara\CheckinController;
use App\Http\Controllers\PembuatAcara\ChekoutController as ScanCheckoutController;
use App\Http\Controllers\PembuatAcara\DashboardController as DashboardPembuatController;
use App\Http\Controllers\PembuatAcara\KreatorController;
use App\Http\Controllers\PembuatAcara\LaporanPenjualanController;
// use App\Http\Controllers\PembuatAcaraController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\VerifikasiKreatorController;
use App\Models\Kreator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/acara/{acara}', [BerandaController::class, 'show'])->name('beranda.acara');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->hasRole('pembeli')) {
            return redirect()->route('pembeli.tiket-saya');
        } elseif ($user->hasRole('kreator')) {
            return redirect()->route('pembuat.dashboard');
        }

        abort(403, 'Akses Ditolak');
    })->name('dashboard');
    Route::get('/pembeli', function () {
        return redirect()->route('pembeli.tiket-saya');
    });

});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/mod-kreator', [ModKretorController::class, 'index'])->name('mod-kreator');
        Route::get('/mod-kreator/{vc}', [ModKretorController::class, 'show'])->name('mod-kreator.show');
        Route::post('/mod-kreator/{id}/approve', [ModKretorController::class, 'approve'])->name('mod-kreator.approve');
        Route::post('/mod-kreator/{id}/reject', [ModKretorController::class, 'reject'])->name('mod-kreator.reject');

    });

Route::middleware(['auth', 'role:kreator'])
    ->prefix('kreator')
    ->name('pembuat.')
    ->group(function () {
        Route::get('/dashboard', [DashboardPembuatController::class, 'index'])->name('dashboard');
        Route::resource('/acara', PembuatAcaraController::class);
        Route::get('/acara/daftar-peserta/{acara}', [PembuatAcaraController::class, 'daftarPeserta'])->name('acara.daftar-peserta');
        Route::get('/acara/laporan-penjualan/{acara}', [LaporanPenjualanController::class, 'LaporanPenjualan'])->name('acara.laporan-penjualan');

        Route::get('/acara/scan/{acara}', [ScanController::class, 'index'])->name('scan.index');
        Route::post('/acara/scan/check/{acara}', [ScanController::class, 'check'])
            ->name('scan.check');

        Route::get('/acara/checkin/{acara}', [CheckinController::class, 'index'])->name('checkin.index');
        Route::post('/acara/checkin/check/{acara}', [CheckinController::class, 'checkIn'])
            ->name('scan.checkin');

        Route::get('/acara/checkout/{acara}', [ScanCheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/acara/checkout/check/{acara}', [ScanCheckoutController::class, 'checkOut'])
            ->name('scan.checkout');

        Route::get('/create2', function () {
            return view('pembuat_acara.acara.create2');
        });

        // Tambah route untuk archive dan restore
        Route::patch('/acara/{acara}/archive', [PembuatAcaraController::class, 'archive'])->name('acara.archive');
        Route::patch('/acara/{acara}/restore', [PembuatAcaraController::class, 'restore'])->name('acara.restore');
        Route::patch('/acara/{acara}/publish', [PembuatAcaraController::class, 'publish'])->name('acara.publish');

        Route::get('/profile', [KreatorController::class, 'index'])
            ->name('profile');

        Route::post('/profile/update', [KreatorController::class, 'update'])
            ->name('profile.update');

        Route::resource('verifikasi-data', VerifikasiKreatorController::class);

        // Route::post('/scan/check')
    });

Route::post('/user/assign-role-pembuat', [PembeliController::class, 'assignRolePembuat'])->middleware('auth')->name('user.assign-role-pembuat');

Route::middleware(['auth', 'role:pembeli'])
    ->prefix('pembeli')
    ->name('pembeli.')
    ->group(function () {
        // Route::get('/dasboard', [DashboardPembeliController::class, 'index'])->name('dashboard');
        Route::get('/tiket-saya', [TiketController::class, 'index'])->name('tiket-saya');
        Route::get('/pesanan-saya', [PesananController::class, 'index'])->name('pesanan-saya');
        Route::resource('tiket', TiketController::class);
        Route::resource('pembayaran', PembayaranController::class);
        Route::resource('acara', PembeliAcaraController::class);
        Route::resource('checkout', PesananController::class);

        Route::get('/tiket/download/{id_tiket}', [ExportPDFController::class, 'downloadTiketPdf'])
            ->name('tiket.download');

        Route::get('/tiket/preview/{id_tiket}', [ExportPDFController::class, 'previewTiket'])
            ->name('tiket.preview');

        // Route::resource('tiket')
    });

// Route::get('/dashboard', function () {
//     return view('beranda');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:pembeli'])->group(function () {
    Route::get('/kreator-register', [KreatorController::class, 'create'])->name('kreator.register');
    Route::post('/kreator-register', [KreatorController::class, 'store'])->name('kreator.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::middleware(['auth', 'role:kreator'])->group(function () {
//     Route::get('/dashboard', [PembuatAcaraController::class, 'index'])->name('dashboard');
//     Route::get('/event/create', [AcaraController::class, 'create'])->name('event.create');
//     Route::post('/event/create', [AcaraController::class, 'store'])->name('event.store');
// });
require __DIR__.'/auth.php';
