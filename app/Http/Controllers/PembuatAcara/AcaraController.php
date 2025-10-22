<?php

namespace App\Http\Controllers\PembuatAcara;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AcaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        $acaras = Acara::where('id_pembuat', $userId)->get();

        return view('pembuat_acara.acara.index', compact('acaras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pembuat_acara.acara.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validate = $request->validate([
            'banner_acara' => 'nullable|image|mimes:jpg,jpeg,png',
            'nama_acara' => 'required|string|max:255',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date',
            'lokasi' => 'required|string',
            'deskripsi_acara' => 'required|string',
            'maks_pembelian_per_akun' => 'required',
            'maks_tiket_per_transaksi' => 'required',
            'jenis_tiket' => 'required|in:gratis,berbayar',
        ]);

        $acara = new Acara;
        $acara->nama_acara = $request->nama_acara;
        $acara->id_pembuat = Auth::id();
        $acara->deskripsi = $request->deskripsi_acara;
        $acara->lokasi = $request->lokasi;
        $acara->waktu_mulai = $request->waktu_mulai;
        $acara->waktu_selesai = $request->waktu_selesai;
        $acara->info_kontak = $request->info_kontak;
        $acara->status = 'published';
        $acara->maks_pembelian_per_akun = $request->maks_pembelian_per_akun;
        $acara->maks_tiket_per_transaksi = $request->maks_tiket_per_transaksi;

        if ($request->hasFile('banner_acara')) {
            $path = $request->file('banner_acara')->store('banner_acara', 'public');
            $acara->banner_acara = $path;
        }

        $acara->save();

        // Jika jenis tiket berbayar, simpan kategori tiket
        if ($validate['jenis_tiket'] === 'berbayar' && $request->has('kategori_tiket')) {
            foreach ($request->kategori_tiket as $kategori) {
                $jenisTiket = new \App\Models\JenisTiket;
                $jenisTiket->id_acara = $acara->id;
                $jenisTiket->nama_jenis = $kategori['nama'];
                $jenisTiket->harga = $kategori['harga'];
                $jenisTiket->kuota = $kategori['kuota'];
                $jenisTiket->penjualan_mulai = $kategori['penjualan_mulai'];
                $jenisTiket->penjualan_selesai = $kategori['penjualan_selesai'];
                $jenisTiket->deskripsi = $kategori['deskripsi'] ?? null;
                $jenisTiket->save();
                // dd($request->kategori_tiket);
            }
        }

        return redirect()->route('pembuat.acara.index')->with('success', 'Acara berhasil dibuat!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Acara $acara)
    {
        $acara->load('jenisTiket');

        // dd($acara);
        return view('pembuat_acara.acara.show', compact('acara'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $acara)
    {
        $acara = Acara::with('jenisTiket')->findOrFail($acara);

        return view('pembuat_acara.acara.edit', compact('acara'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // ✅ Validasi input
        $validated = $request->validate([
            'banner_acara' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nama_acara' => 'required|string|max:255',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after_or_equal:waktu_mulai',
            'lokasi' => 'required|string',
            'deskripsi_acara' => 'required|string',
            'maks_pembelian_per_akun' => 'required|numeric|min:1',
            'maks_tiket_per_transaksi' => 'required|numeric|min:1',
            'jenis_tiket' => 'required|in:gratis,berbayar',
            'kategori_tiket' => 'array',
            'kategori_tiket.*.nama' => 'required_with:kategori_tiket|string',
            'kategori_tiket.*.harga' => 'nullable|numeric|min:0',
            'kategori_tiket.*.kuota' => 'nullable|numeric|min:0',
            // 'kategori_tiket.*.penjualan_mulai' => 'nullable|date',
            // 'kategori_tiket.*.penjualan_selesai' => 'nullable|date|after_or_equal:kategori_tiket.*.penjualan_mulai',
        ]);

        // ✅ Ambil data acara
        $acara = \App\Models\Acara::findOrFail($id);

        // Pastikan hanya pembuat acara yang boleh mengupdate
        if ($acara->id_pembuat !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki izin untuk mengubah acara ini.');
        }

        // ✅ Update data acara utama
        $acara->fill([
            'nama_acara' => $request->nama_acara,
            'deskripsi' => $request->deskripsi_acara,
            'lokasi' => $request->lokasi,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'info_kontak' => $request->info_kontak,
            'status' => 'published',
            'maks_pembelian_per_akun' => $request->maks_pembelian_per_akun,
            'maks_tiket_per_transaksi' => $request->maks_tiket_per_transaksi,
        ]);

        // ✅ Ganti banner jika ada file baru
        if ($request->hasFile('banner_acara')) {
            // Hapus file lama jika ada
            if ($acara->banner_acara && Storage::disk('public')->exists($acara->banner_acara)) {
                Storage::disk('public')->delete($acara->banner_acara);
            }

            // Simpan banner baru
            $path = $request->file('banner_acara')->store('banner_acara', 'public');
            $acara->banner_acara = $path;
        }

        $acara->save();

        // ✅ Kelola jenis tiket (jika berbayar)
        if ($validated['jenis_tiket'] === 'berbayar' && $request->has('kategori_tiket')) {
            $existingIds = [];

            foreach ($request->kategori_tiket as $kategori) {
                // Jika tiket sudah ada → update
                if (! empty($kategori['id'])) {
                    $jenisTiket = \App\Models\JenisTiket::where('id', $kategori['id'])
                        ->where('id_acara', $acara->id)
                        ->first();

                    if ($jenisTiket) {
                        $jenisTiket->update([
                            'nama_jenis' => $kategori['nama'],
                            'harga' => $kategori['harga'] ?? 0,
                            'kuota' => $kategori['kuota'] ?? 0,
                            'penjualan_mulai' => $kategori['penjualan_mulai'] ?? null,
                            'penjualan_selesai' => $kategori['penjualan_selesai'] ?? null,
                            'deskripsi' => $kategori['deskripsi'] ?? null,
                        ]);

                        $existingIds[] = $jenisTiket->id;
                    }
                } else {
                    // Jika tiket baru → buat baru
                    $new = \App\Models\JenisTiket::create([
                        'id_acara' => $acara->id,
                        'nama_jenis' => $kategori['nama'],
                        'harga' => $kategori['harga'] ?? 0,
                        'kuota' => $kategori['kuota'] ?? 0,
                        'penjualan_mulai' => $kategori['penjualan_mulai'] ?? null,
                        'penjualan_selesai' => $kategori['penjualan_selesai'] ?? null,
                        'deskripsi' => $kategori['deskripsi'] ?? null,
                    ]);

                    $existingIds[] = $new->id;
                }
            }

            // ✅ Hapus tiket yang tidak lagi dikirim dari form
            \App\Models\JenisTiket::where('id_acara', $acara->id)
                ->whereNotIn('id', $existingIds)
                ->delete();
        }

        // ✅ Redirect dengan pesan sukses
        return redirect()->route('pembuat.acara.index')->with('success', 'Acara berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
