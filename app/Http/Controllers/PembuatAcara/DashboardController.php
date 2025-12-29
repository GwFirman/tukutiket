<?php

namespace App\Http\Controllers\PembuatAcara;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $idPembuat = Auth::id(); // Variable redundant, tapi kita biarkan sesuai kode asli

        // 1. Ambil List Acara
        $acaras = Acara::where('id_pembuat', $userId)->get();

        // 2. Statistik Basic
        $totalAcara = $acaras->count();

        $totalPendapatan = Pesanan::whereHas('detailPesanan.jenisTiket.acara', function ($query) use ($idPembuat) {
            $query->where('id_pembuat', $idPembuat);
        })
            ->where('status_pembayaran', 'paid')
            ->sum('total_harga');

        $totalPeserta = DB::table('tiket_peserta')
            ->join('detail_pesanan', 'tiket_peserta.id_detail_pesanan', '=', 'detail_pesanan.id')
            ->join('pesanan', 'detail_pesanan.id_pesanan', '=', 'pesanan.id')
            ->join('jenis_tiket', 'detail_pesanan.id_jenis_tiket', '=', 'jenis_tiket.id')
            ->join('acara', 'jenis_tiket.id_acara', '=', 'acara.id')
            ->where('acara.id_pembuat', $idPembuat)
            ->where('pesanan.status_pembayaran', 'paid')
            ->count();

        $totalTiketTerjual = DB::table('detail_pesanan')
            ->join('pesanan', 'detail_pesanan.id_pesanan', '=', 'pesanan.id')
            ->join('jenis_tiket', 'detail_pesanan.id_jenis_tiket', '=', 'jenis_tiket.id')
            ->join('acara', 'jenis_tiket.id_acara', '=', 'acara.id')
            ->where('acara.id_pembuat', $idPembuat)
            ->where('pesanan.status_pembayaran', 'paid')
            ->sum('detail_pesanan.jumlah');

        // 3. ACARA TERBARU (YANG BELUM LEWAT)
        $acaraTerbaru = Acara::where('id_pembuat', $idPembuat)
            ->where('status', 'published')
            // LOGIKA BARU: Hanya ambil jika waktu selesai >= sekarang (belum kedaluwarsa)
            ->where('waktu_selesai', '>=', now())
            ->latest('created_at') // Ambil yang paling baru dibuat
            ->first();

        // 4. Pendapatan Terbaru
        $pendapatanTerbaru = Pesanan::whereHas('detailPesanan.jenisTiket.acara', function ($query) use ($idPembuat) {
            $query->where('id_pembuat', $idPembuat);
        })
            ->where('status_pembayaran', 'paid')
            ->latest('created_at')
            ->first();

        $pendapatanTerbaru = $pendapatanTerbaru ? $pendapatanTerbaru->total_harga : 0;

        return view('pembuat_acara.dashboard', compact('acaras', 'totalAcara', 'totalPendapatan', 'totalPeserta', 'totalTiketTerjual', 'acaraTerbaru', 'pendapatanTerbaru'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
