<?php

namespace App\Http\Controllers;

use App\Models\Acara;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout
     */
    public function index($slug)
    {
        $acara = Acara::where('slug', $slug)->with('jenisTiket')->firstOrFail();

        return view('pembeli.acara.checkout', compact('acara'));
    }

    /**
     * Simpan pesanan dan detail pesanan
     */
    public function store(Request $request)
    {
        // Validasi data pemesan
        $validated = $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'email_pemesan' => 'required|email',
            'no_telp_pemesan' => 'nullable|string|max:20',
            'metode_pembayaran' => 'required|in:bank_transfer,e_wallet,virtual_account',
            'tickets' => 'required|array',
            'tickets.*.id' => 'required|exists:jenis_tiket,id',
            'tickets.*.quantity' => 'required|integer|min:1',
            'tickets.*.price' => 'required|numeric|min:0',
            'tickets.*.total' => 'required|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'peserta' => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            // 1. Buat record Pesanan
            $pesanan = Pesanan::create([
                'id_user' => Auth::id(),
                'id_acara' => request('acara_id'), // Pastikan acara_id dikirim dari frontend
                'nama_pemesan' => $validated['nama_pemesan'],
                'email_pemesan' => $validated['email_pemesan'],
                'no_telp_pemesan' => $validated['no_telp_pemesan'],
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'total_harga' => $validated['grand_total'],
                'status' => 'pending', // Status awal
                'kode_pesanan' => $this->generateOrderCode(),
            ]);

            // 2. Simpan setiap detail pesanan dengan data peserta
            foreach ($validated['tickets'] as $ticket) {
                $ticketId = $ticket['id'];
                $quantity = $ticket['quantity'];

                // Ambil data peserta untuk ticket ini
                $pesertaData = $request->input("peserta.{$ticketId}", []);

                // Gabungkan nama peserta dari array peserta
                $namaPesertaList = [];
                if (is_array($pesertaData)) {
                    foreach ($pesertaData as $index => $peserta) {
                        if (isset($peserta['nama'])) {
                            $namaPesertaList[] = $peserta['nama'];
                        }
                    }
                }

                // Simpan detail pesanan (satu record per jenis tiket dengan jumlah)
                DetailPesanan::create([
                    'id_pesanan' => $pesanan->id,
                    'id_jenis_tiket' => $ticketId,
                    'jumlah' => $quantity,
                    'harga_per_tiket' => $ticket['price'],
                    'nama_peserta' => implode(', ', $namaPesertaList), // Gabung semua nama peserta
                    'email_peserta' => $pesertaData[0]['email'] ?? null,
                    'no_telp_peserta' => $pesertaData[0]['telp'] ?? null,
                ]);

                // 3. Buat tiket individual untuk setiap peserta (opsional, jika perlu tracking per peserta)
                // Uncomment jika ada model TiketPeserta
                // foreach ($pesertaData as $index => $peserta) {
                //     TiketPeserta::create([
                //         'id_detail_pesanan' => $detailPesanan->id,
                //         'nama_peserta' => $peserta['nama'],
                //         'email_peserta' => $peserta['email'] ?? null,
                //         'no_telp_peserta' => $peserta['telp'] ?? null,
                //         'kode_tiket' => $this->generateTicketCode(),
                //         'status' => 'active',
                //     ]);
                // }
            }

            DB::commit();

            return redirect()->route('pembeli.pesanan.show', $pesanan->id)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage())
                ->withInput();
        }
    }

    /**
     * Generate kode pesanan unik
     */
    private function generateOrderCode()
    {
        return 'ORD-'.date('YmdHis').'-'.random_int(1000, 9999);
    }

    /**
     * Generate kode tiket unik
     */
    private function generateTicketCode()
    {
        return 'TKT-'.date('YmdHis').'-'.random_int(10000, 99999);
    }
}
