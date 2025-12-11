<?php

namespace App\Http\Controllers\PembuatAcara;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function daftarPeserta(Acara $acara)
    {
        // Ambil semua peserta berdasarkan acara tertentu
        $peserta = DB::table('tiket_peserta as tp')
            ->join('detail_pesanan as dp', 'tp.id_detail_pesanan', '=', 'dp.id')
            ->join('jenis_tiket as jt', 'dp.id_jenis_tiket', '=', 'jt.id')
            ->join('pesanan as p', 'dp.id_pesanan', '=', 'p.id')
            ->where('jt.id_acara', $acara->id)
            ->select(
                'tp.id',
                'tp.kode_tiket',
                'tp.nama_peserta',
                'tp.email_peserta',
                'tp.no_telp_peserta',
                'tp.status_checkin',
                'tp.waktu_checkin',
                'jt.nama_jenis as jenis_tiket',
                'p.kode_pesanan',
                'p.nama_pemesan',
                'p.email_pemesan'
            )
            ->get();

        return view('pembuat_acara.acara.peserta.daftar-peserta', [
            'acara' => $acara,
            'peserta' => $peserta,
        ]);
    }
}
