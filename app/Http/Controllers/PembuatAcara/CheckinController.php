<?php

namespace App\Http\Controllers\PembuatAcara;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckinController extends Controller
{
    public function index(Acara $acara)
    {
        return view('pembuat_acara.acara.checkin.index', compact('acara'));
    }

    public function checkIn(Request $request, $slugAcara)
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

        // 2. Ambil Data Tiket Lengkap (Termasuk masa berlaku dari jenis tiket)
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
                'jt.berlaku_mulai',  // Ambil kolom masa berlaku
                'jt.berlaku_sampai', // Ambil kolom masa berlaku
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
                'tipe' => 'IN',
                'status_scan' => 'invalid',
                'catatan' => 'Tiket tidak ditemukan / salah acara',
                'waktu_scan' => now(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => '❌ Tiket tidak valid untuk acara ini',
            ], 404);
        }

        // 4. Validasi Masa Berlaku Tiket (PENAMBAHAN BARU)
        $today = now()->toDateString();
        $berlakuMulai = $tiketData->berlaku_mulai;
        $berlakuSampai = $tiketData->berlaku_sampai;

        $isTooEarly = $berlakuMulai && $today < $berlakuMulai;
        $isTooLate = $berlakuSampai && $today > $berlakuSampai;

        if ($isTooEarly || $isTooLate) {
            $catatan = $isTooEarly
                ? 'Tiket belum berlaku (Mulai: '.\Carbon\Carbon::parse($berlakuMulai)->format('d-m-Y').')'
                : 'Tiket sudah kedaluwarsa (Sampai: '.\Carbon\Carbon::parse($berlakuSampai)->format('d-m-Y').')';

            DB::table('log_checkin_tiket')->insert([
                'nomor_tiket' => $tiketData->kode_tiket,
                'id_acara' => $acara->id,
                'id_petugas' => Auth::id(),
                'tipe' => 'IN',
                'status_scan' => 'invalid',
                'catatan' => $catatan,
                'waktu_scan' => now(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => '⏳ '.$catatan,
            ], 403);
        }

        // 5. Validasi Pembayaran
        if ($tiketData->status_pembayaran !== 'paid') {
            return response()->json([
                'status' => 'error',
                'message' => '⛔ Tiket belum dibayar ('.$tiketData->status_pembayaran.')',
            ], 403);
        }

        // 6. Cek log terakhir yang valid (untuk mendukung keluar/masuk area)
        $lastValidLog = DB::table('log_checkin_tiket')
            ->where('nomor_tiket', $tiketData->kode_tiket)
            ->where('id_acara', $acara->id)
            ->where('status_scan', 'valid')
            ->orderByDesc('waktu_scan')
            ->first();

        if ($lastValidLog && $lastValidLog->tipe === 'IN') {
            // Sudah IN dan belum OUT -> tolak check-in ulang
            DB::table('log_checkin_tiket')->insert([
                'nomor_tiket' => $tiketData->kode_tiket,
                'id_acara' => $acara->id,
                'id_petugas' => Auth::id(),
                'tipe' => 'IN',
                'status_scan' => 'invalid',
                'catatan' => 'Tiket sudah dalam status IN (belum check-out)',
                'waktu_scan' => now(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Tiket sudah check-in',
                'nama_peserta' => $tiketData->nama_peserta,
            ], 409);
        }

        // 7. Simpan Log Check-in (VALID)
        DB::table('log_checkin_tiket')->insert([
            'nomor_tiket' => $tiketData->kode_tiket,
            'id_acara' => $acara->id,
            'id_petugas' => Auth::id(),
            'tipe' => 'IN',
            'status_scan' => 'valid',
            'catatan' => 'Check-in berhasil',
            'waktu_scan' => now(),
        ]);

        // 8. Update Status Tiket (Mirror State)
        DB::table('tiket_peserta')
            ->where('id', $tiketData->id_tiket)
            ->update([
                'status_checkin' => 'sudah_digunakan',
                'waktu_checkin' => now(),
                'updated_at' => now(),
            ]);

        // 9. Response Berhasil
        return response()->json([
            'status' => 'valid',
            'tipe' => 'IN',
            'message' => '✅ Check-in berhasil',
            'nama_peserta' => $tiketData->nama_peserta,
            'email_peserta' => $tiketData->email_peserta,
            'no_telp_peserta' => $tiketData->no_telp_peserta,
            'kode_tiket' => $tiketData->kode_tiket,
            'jenis_tiket' => $tiketData->nama_jenis,
            'harga_tiket' => $tiketData->harga,
            'kode_pesanan' => $tiketData->kode_pesanan,
            'nama_pemesan' => $tiketData->nama_pemesan,
            'email_pemesan' => $tiketData->email_pemesan,
            'waktu' => now()->format('H:i:s'),
        ]);
    }
}
