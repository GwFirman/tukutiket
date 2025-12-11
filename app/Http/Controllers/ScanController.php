<?php

namespace App\Http\Controllers;

use App\Models\Acara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScanController extends Controller
{
    public function scan() {}

    /**
     * Display a listing of the resource.
     */
    public function index(Acara $acara)
    {
        // $routeAcara = request()->route('acara');
        // // dd($routeAcara);

        // // Cek apakah parameter berupa Model atau ID
        // if (is_object($routeAcara)) {
        //     // Jika Route Model Binding aktif, $routeAcara adalah instance Model Acara
        //     $acaraId = $routeAcara->id;
        //     $acaraNama = $routeAcara->nama_acara;
        //     $acaraSlug = $routeAcara->slug;
        // } else {
        //     // Jika tidak, $routeAcara adalah ID (integer/string)
        //     $acaraId = $routeAcara;
        //     $acaraNama = null;
        //     $acaraSlug = null;
        // }

        // dd($acaraId, $acaraNama, $acaraSlug);

        // $acara = Acara::where('slug', $acara)->firstOrFail();

        return view('pembuat_acara.acara.scan.index', compact('acara'));
    }

    // Proses check-in
    public function check(Request $request, $acara)
    {
        $acara = Acara::where('slug', $acara)->firstOrFail();

        $kodeTiket = $request->kode_tiket; // Menggunakan kode_tiket dari request

        // Query berdasarkan kode_tiket dan id_acara
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
                'tp.status_checkin',
                'tp.waktu_checkin',
                'dp.id as id_detail_pesanan',
                'p.kode_pesanan',
                'p.nama_pemesan',
                'p.email_pemesan',
                'jt.id as id_jenis_tiket',
                'jt.nama_jenis as jenis_tiket',
                'jt.harga as harga_tiket',
                'a.id as id_acara',
                'a.nama_acara',
                'a.lokasi',
                'a.waktu_mulai',
                'a.waktu_selesai'
            )
            ->first();

        if (! $tiketData) {
            return response()->json([
                'status' => 'error',
                'message' => '❌ Tiket tidak ditemukan atau tidak valid untuk acara ini',
            ]);
        }

        // VALIDASI: sudah check-in?
        if ($tiketData->status_checkin == 'sudah_digunakan') {
            return response()->json([
                'status' => 'error',
                'message' => '⚠️ Tiket sudah digunakan sebelumnya',
            ]);
        }

        // Tandai check-in di tiket_peserta
        DB::table('tiket_peserta')
            ->where('id', $tiketData->id_tiket)
            ->update([
                'status_checkin' => 'sudah_digunakan',
                'waktu_checkin' => now(),
            ]);

        return response()->json([
            'status' => 'valid',
            'message' => '✅ Check-in Berhasil!',
            'kode_tiket' => $tiketData->kode_tiket,
            'nama_peserta' => $tiketData->nama_peserta,
            'email_peserta' => $tiketData->email_peserta,
            'no_telp_peserta' => $tiketData->no_telp_peserta,
            'jenis_tiket' => $tiketData->jenis_tiket,
            'harga_tiket' => $tiketData->harga_tiket,
            'kode_pesanan' => $tiketData->kode_pesanan,
            'nama_pemesan' => $tiketData->nama_pemesan ?? 'Tanpa Nama',
            'email_pemesan' => $tiketData->email_pemesan,
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
