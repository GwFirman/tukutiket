<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use App\Models\TiketPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $tiketList = TiketPeserta::query()
            ->whereHas('detailPesanan.pesanan', function ($query) {
                $query->where('id_pembeli', Auth::id())
                    ->where('status_pembayaran', 'paid');
            })
            ->with([
                'detailPesanan.jenisTiket.acara',
                'detailPesanan.pesanan',
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        // dd($tiketList);
        $pesanan = Pesanan::where('id_pembeli', Auth::id())->with('detailPesanan', 'detailPesanan.jenisTiket', 'detailPesanan.jenisTiket.acara')->get();

        // dd($pesanan);
        return view('pembeli.pesanan.index', compact('pesanan', 'tiketList'));
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
        $pesanan = Pesanan::create([
            'id_pembeli' => Auth::id(),
            // 'id_acara' => $request->acara_id,
            'kode_pesanan' => 'ORD-'.strtoupper(Str::random(8)),
            'total_harga' => $request->grand_total,
            'status_pembayaran' => 'pending',
            'metode_pembayaran' => $request->metode_pembayaran,
            'email_pemesan' => $request->email_pemesan,
            'nama_pemesan' => $request->nama_pemesan,
            'no_telp_peserta' => $request->no_telp_pemesan,
        ]);

        // Simpan detail pesanan dengan data peserta
        foreach ($request->tickets as $ticket) {
            $ticketId = $ticket['id'];
            $quantity = $ticket['quantity'];

            // Ambil data peserta untuk ticket ini
            $pesertaData = $request->input("peserta.{$ticketId}", []);

            // Kumpulkan nama, email, dan telepon peserta
            $namaPesertaList = [];
            $emailPesertaList = [];
            $telpPesertaList = [];

            if (is_array($pesertaData)) {
                foreach ($pesertaData as $index => $peserta) {
                    if (isset($peserta['nama'])) {
                        $namaPesertaList[] = $peserta['nama'];
                    }
                    if (isset($peserta['email']) && ! empty($peserta['email'])) {
                        $emailPesertaList[] = $peserta['email'];
                    }
                    if (isset($peserta['telp']) && ! empty($peserta['telp'])) {
                        $telpPesertaList[] = $peserta['telp'];
                    }
                }
            }

            // Simpan detail pesanan dengan data peserta yang digabung
            DetailPesanan::create([
                'id_pesanan' => $pesanan->id,
                'id_jenis_tiket' => $ticketId,
                'jumlah' => $quantity,
                'harga_per_tiket' => $ticket['price'],
                'nama_peserta' => implode('; ', $namaPesertaList), // Gabung dengan semicolon
                'email_peserta' => implode('; ', $emailPesertaList) ?: null,
                'no_telp_peserta' => implode('; ', $telpPesertaList) ?: null,
            ]);
        }

        // Update kuota tiket
        foreach ($request->tickets as $ticket) {
            $jenisTiket = \App\Models\JenisTiket::find($ticket['id']);
            if ($jenisTiket) {
                $jenisTiket->kuota -= $ticket['quantity'];
                $jenisTiket->save();
            }
        }

        return redirect()->route('pembeli.pembayaran.show', $pesanan->kode_pesanan)
            ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Acara $checkout)
    {
        $checkout->load('jenisTiket');

        $user = Auth::user();

        $maksTiket = $checkout->maks_tiket_per_transaksi;

        return view('pembeli.acara.checkout', ['acara' => $checkout, 'user' => $user, 'maksTiket' => $maksTiket]);

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
