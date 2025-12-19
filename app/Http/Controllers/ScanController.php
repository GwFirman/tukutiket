<?php

namespace App\Http\Controllers;

use App\Models\Acara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScanController extends Controller
{
    public function scan() {}

    /**
     * Display a listing of the resource.
     */
    public function index(Acara $acara)
    {

        $acara = Acara::where('slug', $acara)->firstOrFail();

        return view('pembuat_acara.acara.scan.index', compact('acara'));

    }

    public function check(Request $request, $slugAcara)
    {
        // 1. Cari Acara berdasarkan slug
        $acara = Acara::where('slug', $slugAcara)->first();

        if (! $acara) {
            return response()->json([
                'status' => 'error',
                'message' => '❌ Acara tidak ditemukan.',
            ], 404);
        }

        $kodeTiket = $request->kode_tiket;

        // 2. Query Data Tiket (Join Lengkap sesuai Schema)
        $tiketData = DB::table('tiket_peserta as tp')
            ->join('detail_pesanan as dp', 'tp.id_detail_pesanan', '=', 'dp.id')
            ->join('pesanan as p', 'dp.id_pesanan', '=', 'p.id')
            ->join('jenis_tiket as jt', 'dp.id_jenis_tiket', '=', 'jt.id')
            ->join('acara as a', 'jt.id_acara', '=', 'a.id')
            ->where('tp.kode_tiket', $kodeTiket)
            ->where('a.id', $acara->id) // Pastikan tiket milik acara yang sedang discan
            ->select(
                'tp.id as id_tiket',
                'tp.kode_tiket',
                'tp.nama_peserta',
                'tp.email_peserta',
                'tp.no_telp_peserta',
                'tp.status_checkin', // Enum: belum_digunakan, sudah_digunakan
                'p.status_pembayaran', // Enum: pending, paid, failed, expired
                'p.kode_pesanan',
                'p.nama_pemesan',
                'p.email_pemesan',
                'jt.nama_jenis',
                'jt.harga',
                'a.id as id_acara',
                'a.nama_acara'
            )
            ->first();

        // 3. Validasi Keberadaan Tiket
        if (! $tiketData) {
            // Catat log scan invalid (Opsional, agar tahu ada yang mencoba tiket salah)
            DB::table('log_checkin_tiket')->insert([
                'nomor_tiket' => $kodeTiket, // Menggunakan kode tiket karena nomor_tiket di DB kosong
                'id_acara' => $acara->id,
                'tipe' => 'IN',
                'status_scan' => 'invalid',
                'catatan' => 'Tiket tidak ditemukan atau salah acara',
                'waktu_scan' => now(),
                'id_petugas' => Auth::id() ?? null,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => '❌ Tiket tidak valid untuk acara ini',
            ]);
        }

        // 4. Validasi Status Pembayaran
        if ($tiketData->status_pembayaran !== 'paid') {
            return response()->json([
                'status' => 'error',
                'message' => '⛔ Pesanan tiket ini belum dibayar (Status: '.$tiketData->status_pembayaran.')',
            ]);
        }

        // 5. Cek Log Terakhir (Untuk menentukan IN atau OUT)
        // Menggunakan kode_tiket sebagai identifier di kolom nomor_tiket log
        $lastLog = DB::table('log_checkin_tiket')
            ->where('nomor_tiket', $tiketData->kode_tiket)
            ->where('id_acara', $acara->id)
            ->where('status_scan', 'valid')
            ->orderByDesc('waktu_scan')
            ->first();

        // Logika Toggle: Jika belum ada log atau log terakhir OUT, maka sekarang IN. Sebaliknya OUT.
        $tipeScan = (! $lastLog || $lastLog->tipe === 'OUT') ? 'IN' : 'OUT';

        // 6. Simpan Log Baru
        DB::table('log_checkin_tiket')->insert([
            'nomor_tiket' => $tiketData->kode_tiket,
            'id_acara' => $acara->id,
            'id_petugas' => Auth::id() ?? null, // Jika pakai auth
            'tipe' => $tipeScan, // IN atau OUT
            'waktu_scan' => now(),
            'status_scan' => 'valid',
            'catatan' => $tipeScan === 'IN' ? 'Check-in Berhasil' : 'Check-out Berhasil',
        ]);

        // 7. Update Status Tiket Peserta (Hanya jika IN)
        // Sesuai schema, ubah status menjadi 'sudah_digunakan' dan isi waktu_checkin
        if ($tipeScan === 'IN') {
            DB::table('tiket_peserta')
                ->where('id', $tiketData->id_tiket)
                ->update([
                    'status_checkin' => 'sudah_digunakan',
                    'waktu_checkin' => now(),
                    'updated_at' => now(),
                ]);
        }

        // 8. Return Response
        return response()->json([
            'status' => 'valid',
            'tipe' => $tipeScan,
            'message' => $tipeScan === 'IN'
                ? '✅ Berhasil Check-in: '.$tiketData->nama_peserta
                : '👋 Berhasil Check-out: '.$tiketData->nama_peserta,
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

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
    public function show(string $id)
    {
        //
    }

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
