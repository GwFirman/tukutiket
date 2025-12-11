<?php

namespace App\Http\Controllers\PembuatAcara;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use Illuminate\Support\Facades\DB;

class LaporanPenjualanController extends Controller
{
    public function LaporanPenjualan(Acara $acara)
    {
        // ================
        // 1. LAPORAN LEVEL ACARA
        // ================
        $rekapAcara = DB::table('acara as a')
            ->leftJoin('jenis_tiket as jt', 'jt.id_acara', '=', 'a.id')
            ->leftJoin('detail_pesanan as dp', 'dp.id_jenis_tiket', '=', 'jt.id')
            ->leftJoin('pesanan as p', 'p.id', '=', 'dp.id_pesanan')
            ->leftJoin('tiket_peserta as tp', 'tp.id_detail_pesanan', '=', 'dp.id')
            ->where('a.id', $acara->id)
            ->select(
                'a.id',
                'a.nama_acara',
                'a.lokasi',
                'a.waktu_mulai',
                'a.waktu_selesai',

                DB::raw("COUNT(DISTINCT CASE WHEN p.status_pembayaran = 'paid' THEN p.id END) AS total_transaksi"),
                DB::raw("COALESCE(SUM(CASE WHEN p.status_pembayaran = 'paid' THEN dp.jumlah END), 0) AS total_tiket_terjual"),
                DB::raw("COALESCE(SUM(CASE WHEN p.status_pembayaran = 'paid' THEN dp.jumlah * dp.harga_per_tiket END), 0) AS total_pendapatan"),
                DB::raw("COALESCE(SUM(CASE WHEN tp.status_checkin = 'sudah_digunakan' THEN 1 END), 0) AS total_sudah_checkin")
            )
            ->groupBy('a.id')
            ->first();

        // ================
        // 2. LAPORAN PER JENIS TIKET
        // ================
        $rekapJenisTiket = DB::table('jenis_tiket as jt')
            ->leftJoin('detail_pesanan as dp', 'dp.id_jenis_tiket', '=', 'jt.id')
            ->leftJoin('pesanan as p', 'p.id', '=', 'dp.id_pesanan')
            ->leftJoin('tiket_peserta as tp', 'tp.id_detail_pesanan', '=', 'dp.id')
            ->where('jt.id_acara', $acara->id)
            ->select(
                'jt.id',
                'jt.nama_jenis',
                'jt.harga',
                'jt.kuota',
                'jt.deskripsi',

                DB::raw("COALESCE(SUM(CASE WHEN p.status_pembayaran = 'paid' THEN dp.jumlah END), 0) AS tiket_terjual"),
                DB::raw("(jt.kuota - COALESCE(SUM(CASE WHEN p.status_pembayaran = 'paid' THEN dp.jumlah END), 0)) AS sisa_kuota"),
                DB::raw("COALESCE(SUM(CASE WHEN p.status_pembayaran = 'paid' THEN dp.jumlah * dp.harga_per_tiket END), 0) AS pendapatan"),
                DB::raw("COALESCE(SUM(CASE WHEN tp.status_checkin = 'sudah_digunakan' THEN 1 END), 0) AS checkin_count")
            )
            ->groupBy('jt.id')
            ->orderBy('jt.nama_jenis', 'ASC')
            ->get();

        return view('pembuat_acara.acara.laporan.penjualan', [
            'acara' => $acara,
            'rekapAcara' => $rekapAcara,
            'rekapJenisTiket' => $rekapJenisTiket,
        ]);
    }
}
