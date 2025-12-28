<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Pesanan;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        // Total Events
        $totalEvents = Acara::count();

        // Total Kreators (users with role 'kreator')
        $kreatorRole = Role::where('name', 'kreator')->first();
        $totalKreators = $kreatorRole ? $kreatorRole->users()->count() : 0;

        // Total Users (users with role 'pembeli')
        $pembeliRole = Role::where('name', 'pembeli')->first();
        $totalPembeli = $pembeliRole ? $pembeliRole->users()->count() : 0;

        // Total Transactions (sum of all pesanan total_harga)
        $totalTransaksi = Pesanan::where('status_pembayaran', 'paid')->sum('total_harga') ?? 0;

        // Format total transaksi to Indonesian currency
        $totalTransaksiFormatted = 'Rp '.number_format($totalTransaksi, 0, ',', '.');

        return view('admin.dashboard', [
            'totalEvents' => $totalEvents,
            'totalKreators' => $totalKreators,
            'totalPembeli' => $totalPembeli,
            'totalTransaksi' => $totalTransaksiFormatted,
        ]);
    }
}
