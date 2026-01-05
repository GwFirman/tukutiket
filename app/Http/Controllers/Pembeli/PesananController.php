<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\DetailPesanan;
use App\Models\JenisTiket;
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
    public function show(Acara $checkout)
    {
        $checkout->load('jenisTiket');

        $user = Auth::user();

        $maksTiket = $checkout->maks_tiket_per_transaksi;

        return view('pembeli.acara.checkout', ['acara' => $checkout, 'user' => $user, 'maksTiket' => $maksTiket]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'acara_id' => 'required|exists:acara,id',
            'nama_pemesan' => 'required|string|max:255',
            'email_pemesan' => 'required|email|max:255',
            'tickets' => 'required|array|min:1',
            'tickets.*.id' => 'required|exists:jenis_tiket,id',
            'tickets.*.quantity' => 'required|integer|min:1',
            'tickets.*.price' => 'required|numeric|min:0',
            'tickets.*.total' => 'required|numeric|min:0',
            'peserta' => 'required|array',
        ]);

        // Validasi data peserta
        foreach ($request->tickets as $ticket) {
            $ticketId = $ticket['id'];
            $quantity = $ticket['quantity'];
            $pesertaData = $request->input("peserta.{$ticketId}", []);

            // // Pastikan jumlah peserta sesuai dengan quantity
            // if (count($pesertaData) !== $quantity) {
            //     return redirect()->back()
            //         ->withErrors(['peserta' => 'Jumlah data peserta untuk tiket '.$ticketId.' harus sesuai dengan jumlah tiket yang dibeli.'])
            //         ->withInput();
            // }

            // Validasi setiap peserta
            foreach ($pesertaData as $index => $peserta) {
                if (empty($peserta['nama'])) {
                    return redirect()->back()
                        ->withErrors(['peserta' => 'Nama peserta untuk tiket harus diisi.'])
                        ->withInput();
                }
                if (empty($peserta['email'])) {
                    return redirect()->back()
                        ->withErrors(['peserta' => 'Email peserta untuk tiket harus diisi.'])
                        ->withInput();
                }
                // Validasi format email
                if (! filter_var($peserta['email'], FILTER_VALIDATE_EMAIL)) {
                    return redirect()->back()
                        ->withErrors(['peserta' => 'Email peserta tidak valid.'])
                        ->withInput();
                }
                if (empty($peserta['telp'])) {
                    return redirect()->back()
                        ->withErrors(['peserta' => 'Nomor telepon peserta untuk tiket harus diisi.'])
                        ->withInput();
                }
                // Validasi format nomor telepon (minimal 8 karakter dan hanya angka)
                if (! preg_match('/^[0-9]{8,20}$/', str_replace(['-', ' ', '+'], '', $peserta['telp']))) {
                    return redirect()->back()
                        ->withErrors(['peserta' => 'Nomor telepon peserta tidak valid.'])
                        ->withInput();
                }
            }
        }

        $pesanan = Pesanan::create([
            'id_pembeli' => Auth::id(),
            // 'id_acara' => $request->acara_id,
            'kode_pesanan' => 'ORD-'.strtoupper(Str::random(8)),
            'total_harga' => $request->grand_total,
            'status_pembayaran' => $request->grand_total == 0 ? 'paid' : 'unpaid', // Jika gratis langsung paid
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
            $detailPesanan = DetailPesanan::create([
                'id_pesanan' => $pesanan->id,
                'id_jenis_tiket' => $ticketId,
                'jumlah' => $quantity,
                'harga_per_tiket' => $ticket['price'],
                'nama_peserta' => implode('; ', $namaPesertaList), // Gabung dengan semicolon
                'email_peserta' => implode('; ', $emailPesertaList) ?: null,
                'no_telp_peserta' => implode('; ', $telpPesertaList) ?: null,
            ]);

            // Jika total harga = 0 (gratis), langsung generate tiket peserta
            if ($request->grand_total == 0) {
                // Generate tiket sesuai jumlah yang dibeli
                for ($i = 0; $i < $quantity; $i++) {
                    TiketPeserta::create([
                        'id_detail_pesanan' => $detailPesanan->id,
                        'nomor_tiket' => strtoupper(Str::random(10)),
                        'nama_peserta' => $namaPesertaList[$i] ?? $request->nama_pemesan,
                        'email_peserta' => $emailPesertaList[$i] ?? $request->email_pemesan,
                        'no_telp_peserta' => $telpPesertaList[$i] ?? $request->no_telp_pemesan,
                        'kode_tiket' => strtoupper(Str::random(10)),
                    ]);
                }
            }
        }
        // Update kuota tiket
        foreach ($request->tickets as $ticket) {
            $jenisTiket = JenisTiket::find($ticket['id']);
            if ($jenisTiket) {
                $jenisTiket->kuota -= $ticket['quantity'];
                $jenisTiket->save();
            }
        }

        // Redirect berdasarkan status pembayaran
        if ($request->grand_total == 0) {
            return redirect()->route('pembeli.tiket-saya')
                ->with('success', 'Pesanan berhasil dibuat! Tiket Anda sudah tersedia.');
        } else {
            return redirect()->route('pembeli.pembayaran.show', $pesanan->kode_pesanan)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function detail($kodePesanan)
    {
        // Cari pesanan berdasarkan kode pesanan dan milik user yang login
        $pesanan = Pesanan::where('kode_pesanan', $kodePesanan)
            ->where('id_pembeli', Auth::id())
            ->with([
                'detailPesanan.jenisTiket.acara',
                'detailPesanan.tiketPeserta',
            ])
            ->firstOrFail();

        return view('pembeli.pesanan.show', compact('pesanan'));

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
