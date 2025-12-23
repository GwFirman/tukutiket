<?php

namespace App\Http\Controllers\PembuatAcara;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Pesanan;
use App\Models\TiketPeserta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class kelolaTransaksiController extends Controller
{
    public function index(Acara $acara)
    {
        // $acara = Acara::where('slug', $acaraSlug)->firstOrFail();

        // Pastikan hanya pembuat acara yang dapat mengakses
        if ($acara->id_pembuat !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Ambil semua pesanan untuk acara ini dengan relasi melalui detail pesanan -> jenis tiket -> acara
        $pesanan = Pesanan::whereHas('detailPesanan.jenisTiket', function ($query) use ($acara) {
            $query->where('id_acara', $acara->id);
        })
            ->with(['detailPesanan.jenisTiket'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung ringkasan
        $totalTransaksi = $pesanan->count();
        $totalPendapatan = $pesanan->where('status_pembayaran', 'paid')->sum('total_harga');
        $transaksiPending = $pesanan->where('status_pembayaran', 'pending')->count();
        $transaksiCompleted = $pesanan->where('status_pembayaran', 'paid')->count();

        $ringkasan = (object) [
            'total_transaksi' => $totalTransaksi,
            'total_pendapatan' => $totalPendapatan,
            'transaksi_pending' => $transaksiPending,
            'transaksi_completed' => $transaksiCompleted,
        ];
        // dd($pesanan);

        return view('pembuat_acara.acara.laporan.transaksi', compact('acara', 'pesanan', 'ringkasan'));
    }

    public function Acc(Acara $acara, $kodePesanan)
    {
        $pesanan = Pesanan::where('kode_pesanan', $kodePesanan)->with('detailPesanan', 'detailPesanan.jenisTiket', 'detailPesanan.jenisTiket.acara')->firstOrFail();
        // dd($pesanan);
        $namaAcara = optional($pesanan->detailPesanan->first()->jenisTiket->acara)->nama_acara;
        $lokasi = optional($pesanan->detailPesanan->first()->jenisTiket->acara)->lokasi;
        $waktuMulai = optional($pesanan->detailPesanan->first()->jenisTiket->acara)->waktu_mulai;
        $waktuMulai = $waktuMulai ? \Carbon\Carbon::parse($waktuMulai)->locale('id')->translatedFormat('d F Y') : null;
        $daftarTiket = $pesanan->detailPesanan->map(function ($detail) {
            return [
                'id_jenis_tiket' => $detail->id_jenis_tiket,
                'nama_tiket' => $detail->jenisTiket->nama_jenis ?? '-',
                'harga' => $detail->jenisTiket->harga ?? 0,
                'jumlah' => $detail->jumlah ?? 0,
                'subtotal' => ($detail->jenisTiket->harga ?? 0) * ($detail->jumlah ?? 0),
            ];
        });
        // dd($pesanan);

        return view('pembuat_acara.acara.laporan.acc-pembayaran', compact('pesanan', 'namaAcara', 'lokasi', 'waktuMulai', 'daftarTiket', 'acara'));
    }

    public function store(\Illuminate\Http\Request $request, Acara $acara, $kodePesanan)
    {
        $validated = $request->validate([
            'id_detail_pesanan' => 'required',
            'nama_peserta' => 'required',
            'email_peserta' => 'nullable',
            'no_telp_peserta' => 'nullable',
            'kode_pesanan' => 'required|string',
        ]);

        // Simpan data ke tabel tiket_peserta
        foreach ($validated['id_detail_pesanan'] as $index => $idDetail) {
            // Ambil detail pesanan untuk mendapatkan jumlah tiket
            $detailPesanan = \App\Models\DetailPesanan::find($idDetail);
            $jumlahTiket = $detailPesanan->jumlah ?? 1;

            // Generate tiket sesuai jumlah yang dibeli
            for ($i = 0; $i < $jumlahTiket; $i++) {
                TiketPeserta::create([
                    'id_detail_pesanan' => $idDetail,
                    'nomor_tiket' => strtoupper(Str::random(10)),
                    'nama_peserta' => $validated['nama_peserta'][$index],
                    'email_peserta' => $validated['email_peserta'][$index] ?? null,
                    'no_telp_peserta' => $validated['no_telp_peserta'][$index] ?? null,
                    'kode_tiket' => strtoupper(Str::random(10)),
                ]);
            }
        }

        // Update status pembayaran menjadi "paid" berdasarkan kode pesanan
        Pesanan::where('kode_pesanan', $validated['kode_pesanan'])
            ->update(['status_pembayaran' => 'paid']);

        return redirect()
            ->route('pembuat.transaksi.index', $acara->slug)
            ->with('success', 'Pembayaran berhasil diverifikasi dan tiket peserta telah dibuat!');
    }
}
