<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\TiketPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function bayar(Request $request)
    {
        $validated = $request->validate([
            'kode_pesanan' => 'required|string|exists:pesanan,kode_pesanan',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,jpg,png|max:5120', // max 5MB
            'bank_tujuan' => 'required|string',
        ]);

        // Cari pesanan berdasarkan kode pesanan
        $pesanan = Pesanan::where('kode_pesanan', $validated['kode_pesanan'])->firstOrFail();

        // Upload bukti pembayaran
        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = time().'_'.$validated['kode_pesanan'].'.'.$file->getClientOriginalExtension();
            $buktiPath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
        }

        // Update pesanan dengan bukti pembayaran dan ubah status ke pending
        $pesanan->update([
            'bukti_pembayaran' => $buktiPath,
            'status_pembayaran' => 'pending',
            'metode_pembayaran' => $validated['bank_tujuan'],
        ]);

        return redirect()
            ->route('pembeli.pembayaran.show', $pesanan->kode_pesanan)
            ->with('success', 'Bukti pembayaran berhasil diupload! Pesanan Anda sedang dalam proses verifikasi.');
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
            ->route('pembeli.tiket-saya')
            ->with('success', 'Pembayaran berhasil diverifikasi dan tiket peserta telah dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pesanan = \App\Models\Pesanan::where('kode_pesanan', $id)->with('detailPesanan', 'detailPesanan.jenisTiket', 'detailPesanan.jenisTiket.acara')->firstOrFail();
        // dd($pesanan);
        $namaAcara = optional($pesanan->detailPesanan->first()->jenisTiket->acara)->nama_acara;
        $isOnline = optional($pesanan->detailPesanan->first()->jenisTiket->acara)->is_online;
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
        // dd($daftarTiket);

        return view('pembeli.acara.bayar', compact('pesanan', 'namaAcara', 'lokasi', 'waktuMulai', 'daftarTiket', 'isOnline'));
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
    public function update(Request $request)
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
