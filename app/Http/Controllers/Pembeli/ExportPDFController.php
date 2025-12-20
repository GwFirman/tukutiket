<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ExportPDFController extends Controller
{
    public function downloadPdf($kode_pesanan)
    {
        // 1. Ambil data dari database
        $pesanan = Pesanan::with('detailPesanan.jenisTiket.acara')
            ->where('kode_pesanan', $kode_pesanan)
            ->firstOrFail();

        // 2. Load view yang kita buat tadi
        $pdf = Pdf::loadView('export.pdf.pesanan', [
            'pesanan' => $pesanan,
        ]);

        // Opsional: Atur ukuran kertas
        $pdf->setPaper('A4', 'portrait');

        // 3. Download file (bisa ganti ->stream() kalau mau preview dulu)
        return $pdf->download('Tiket-'.$pesanan->kode_pesanan.'.pdf');
    }

    public function downloadTiketPdf($id_tiket)
    {
        // 1. Ambil data tiket lengkap dari database
        $tiket = DB::table('tiket_peserta as tp')
            ->join('detail_pesanan as dp', 'tp.id_detail_pesanan', '=', 'dp.id')
            ->join('pesanan as p', 'dp.id_pesanan', '=', 'p.id')
            ->join('jenis_tiket as jt', 'dp.id_jenis_tiket', '=', 'jt.id')
            ->join('acara as a', 'jt.id_acara', '=', 'a.id')
            ->where('tp.id', $id_tiket)
            ->select(
                'tp.id AS id_tiket',
                'tp.kode_tiket',
                'tp.nama_peserta',
                'tp.email_peserta',
                'tp.no_telp_peserta',
                'tp.status_checkin',
                'tp.waktu_checkin',

                'p.kode_pesanan',
                'p.nama_pemesan',
                'p.email_pemesan',
                'p.no_telp_peserta AS no_telp_pemesan',

                'jt.nama_jenis AS jenis_tiket',
                'jt.harga AS harga_tiket',

                'a.id AS id_acara',
                'a.nama_acara',
                'a.lokasi',
                'a.waktu_mulai',
                'a.waktu_selesai',
                'a.slug AS slug_acara'
            )
            ->firstOrFail();

        // 2. Load tampilan PDF
        $pdf = Pdf::loadView('export.pdf.tiket', [
            'tiket' => $tiket,
        ]);

        // $pdf->setOptions(['isPhpEnabled' => true, 'isRemoteEnabled' => true]);
        // $pdf->set_option('isHtml5ParserEnabled', true);
        // $pdf->set_option('isFontSubsettingEnabled', true);
        // $pdf->set_option('dpi', 96);
        // $pdf->set_option('imageBackend', 'gd');  // <- ini paling penting

        // 3. Opsional: ukuran kertas
        $pdf->setPaper('A4', 'portrait');

        // 4. Download file PDF
        return $pdf->download('Tiket-'.$tiket->kode_tiket.'.pdf');
    }

    public function previewTiket($id_tiket)
    {
        // Ambil data tiket sama seperti fungsi download
        $tiket = DB::table('tiket_peserta as tp')
            ->join('detail_pesanan as dp', 'tp.id_detail_pesanan', '=', 'dp.id')
            ->join('pesanan as p', 'dp.id_pesanan', '=', 'p.id')
            ->join('jenis_tiket as jt', 'dp.id_jenis_tiket', '=', 'jt.id')
            ->join('acara as a', 'jt.id_acara', '=', 'a.id')
            ->where('tp.id', $id_tiket)
            ->select(
                'tp.id AS id_tiket',
                'tp.kode_tiket',
                'tp.nama_peserta',
                'tp.email_peserta',
                'tp.no_telp_peserta',
                'tp.status_checkin',
                'tp.waktu_checkin',

                'p.kode_pesanan',
                'p.nama_pemesan',
                'p.email_pemesan',
                'p.no_telp_peserta AS no_telp_pemesan',

                'jt.nama_jenis AS jenis_tiket',
                'jt.harga AS harga_tiket',

                'a.id AS id_acara',
                'a.nama_acara',
                'a.lokasi',
                'a.waktu_mulai',
                'a.waktu_selesai',
                'a.slug AS slug_acara'
            )
            ->firstOrFail();

        // Kembalikan tampilan HTML biasa (untuk preview)
        return view('pembeli.tiket.preview', compact('tiket'));
    }
}
