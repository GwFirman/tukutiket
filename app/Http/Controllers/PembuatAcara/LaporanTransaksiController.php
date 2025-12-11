<?php

namespace App\Http\Controllers\PembuatAcara;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use Illuminate\Support\Facades\DB;

class LaporanTransaksiController extends Controller
{
    public function LaporanTransaksi(Acara $acara)
    {
        // RIWAYAT TRANSAKSI — 1 baris per transaksi
        $riwayatTransaksi = DB::table('pesanan as p')
            ->join('detail_pesanan as dp', 'dp.id_pesanan', '=', 'p.id')
            ->join('jenis_tiket as jt', 'dp.id_jenis_tiket', '=', 'jt.id')
            ->where('jt.id_acara', $acara->id)
            ->select(
                'p.id',
                'p.kode_pesanan',
                'p.nama_pemesan',
                'p.email_pemesan',
                'p.no_telp_peserta',
                'p.total_harga',
                'p.status_pembayaran',
                'p.metode_pembayaran',
                'p.created_at',
                DB::raw("GROUP_CONCAT(jt.nama_jenis SEPARATOR ', ') AS jenis_tiket_dibeli")
            )
            ->groupBy(
                'p.id',
                'p.kode_pesanan',
                'p.nama_pemesan',
                'p.email_pemesan',
                'p.no_telp_peserta',
                'p.total_harga',
                'p.status_pembayaran',
                'p.metode_pembayaran',
                'p.created_at'
            )
            ->orderBy('p.created_at', 'DESC')
            ->get();

        return view('pembuat_acara.acara.laporan-transaksi', [
            'acara' => $acara,
            'riwayatTransaksi' => $riwayatTransaksi,
        ]);
    }
}
