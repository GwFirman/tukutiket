<?php

namespace App\Http\Controllers\PembuatAcara;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChekoutController extends Controller
{
    public function index(Acara $acara)
    {
        return view('pembuat_acara.acara.chekout.index', compact('acara'));
    }

    public function checkOut(Request $request, $slugAcara)
    {
        $request->validate([
            'kode_tiket' => 'required|string',
        ]);

        // 1. Cari Acara
        $acara = Acara::where('slug', $slugAcara)->first();

        if (! $acara) {
            return response()->json([
                'status' => 'error',
                'message' => '❌ Acara tidak ditemukan',
            ], 404);
        }

        $kodeTiket = $request->kode_tiket;

        // 2. Ambil Data Tiket Lengkap
        $tiketData = DB::table('tiket_peserta as tp')
            ->join('detail_pesanan as dp', 'tp.id_detail_pesanan', '=', 'dp.id')
            ->join('pesanan as p', 'dp.id_pesanan', '=', 'p.id')
            ->join('jenis_tiket as jt', 'dp.id_jenis_tiket', '=', 'jt.id')
            ->join('acara as a', 'jt.id_acara', '=', 'a.id')
            ->where('tp.kode_tiket', $kodeTiket)
            ->where('a.id', $acara->id)
            ->select(
                'tp.id as id_tiket',
                'tp.kode_tiket',
                'tp.nama_peserta',
                'tp.email_peserta',
                'tp.no_telp_peserta',
                'p.status_pembayaran',
                'p.kode_pesanan',
                'p.nama_pemesan',
                'p.email_pemesan',
                'jt.nama_jenis',
                'jt.harga',
                'a.id as id_acara',
                'a.nama_acara'
            )
            ->first();

        // 3. Tiket Tidak Ditemukan
        if (! $tiketData) {
            DB::table('log_checkin_tiket')->insert([
                'nomor_tiket' => $kodeTiket,
                'id_acara' => $acara->id,
                'id_petugas' => Auth::id(),
                'tipe' => 'OUT',
                'status_scan' => 'invalid',
                'catatan' => 'Tiket tidak ditemukan saat checkout',
                'waktu_scan' => now(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => '❌ Tiket tidak valid untuk acara ini',
            ], 404);
        }

        // 4. Validasi Pembayaran
        if ($tiketData->status_pembayaran !== 'paid') {
            return response()->json([
                'status' => 'error',
                'message' => '⛔ Tiket belum dibayar ('.$tiketData->status_pembayaran.')',
            ], 403);
        }

        // 5. Cek Status Terakhir (Validasi Logic Checkout)
        // Ambil log valid terakhir untuk tiket ini
        $lastLog = DB::table('log_checkin_tiket')
            ->where('nomor_tiket', $tiketData->kode_tiket)
            ->where('id_acara', $acara->id)
            ->where('status_scan', 'valid')
            ->orderByDesc('waktu_scan')
            ->first();

        // Logic: Hanya boleh Checkout jika log terakhir adalah 'IN'
        // Jika belum pernah scan (null) atau scan terakhir 'OUT', maka tolak.
        if (! $lastLog || $lastLog->tipe === 'OUT') {
            DB::table('log_checkin_tiket')->insert([
                'nomor_tiket' => $tiketData->kode_tiket,
                'id_acara' => $acara->id,
                'id_petugas' => Auth::id(),
                'tipe' => 'OUT',
                'status_scan' => 'invalid',
                'catatan' => 'Gagal Checkout: Peserta belum check-in atau sudah checkout',
                'waktu_scan' => now(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => '⚠️ Peserta belum Check-in atau sudah Check-out sebelumnya.',
                'nama_peserta' => $tiketData->nama_peserta,
            ], 409);
        }

        // 6. Simpan Log Check-out (VALID)
        DB::table('log_checkin_tiket')->insert([
            'nomor_tiket' => $tiketData->kode_tiket,
            'id_acara' => $acara->id,
            'id_petugas' => Auth::id(),
            'tipe' => 'OUT', // Tipe OUT
            'status_scan' => 'valid',
            'catatan' => 'Check-out berhasil',
            'waktu_scan' => now(),
        ]);

        // 7. Response Berhasil
        return response()->json([
            'status' => 'valid',
            'tipe' => 'OUT',
            'message' => '👋 Check-out berhasil',
            'nama_peserta' => $tiketData->nama_peserta,
            'email_peserta' => $tiketData->email_peserta,
            'no_telp_peserta' => $tiketData->no_telp_peserta,
            'kode_tiket' => $tiketData->kode_tiket,
            'jenis_tiket' => $tiketData->nama_jenis,
            'waktu' => now()->format('H:i:s'),
        ]);
    }
}
