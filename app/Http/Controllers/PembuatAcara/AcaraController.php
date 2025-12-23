<?php

namespace App\Http\Controllers\PembuatAcara;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\EventKategori;
use App\Models\kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AcaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        $acaras = Acara::where('id_pembuat', $userId)->get();

        $totalAcara = $acaras->count();

        return view('pembuat_acara.acara.index', compact('acaras', 'totalAcara'));
    }

    public function data(Request $request)
    {
        $userId = Auth::id();

        $query = Acara::query()
            ->where('id_pembuat', $userId)
            ->with('kreator')
            ->select('acara.*');

        // Optional filter status
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        // Custom search param to avoid conflict with DataTables default
        if ($search = $request->get('search_text')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_acara', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        return DataTables::eloquent($query)
            ->addColumn('banner', function ($acara) {
                if ($acara->banner_acara) {
                    return '<img src="'.e(Storage::url($acara->banner_acara)).'" class="h-12 w-12 rounded object-cover" />';
                }

                return '<div class="h-12 w-12 rounded bg-indigo-100 flex items-center justify-center"><i data-lucide="image" class="size-5 text-indigo-500"></i></div>';
            })
            ->addColumn('nama_lokasi', function ($acara) {
                return '<div class="text-sm font-semibold">'.e($acara->nama_acara).'</div>
                        <div class="text-xs text-gray-500">'.e(Str::limit($acara->lokasi, 30)).'</div>';
            })
            ->addColumn('waktu', function ($acara) {
                return '<div class="text-sm">
                            <div><span class="font-medium">Mulai:</span> '.e(\Carbon\Carbon::parse($acara->waktu_mulai)->format('d M Y')).'</div>
                            <div class="text-gray-500"><span class="font-medium">Selesai:</span> '.e(\Carbon\Carbon::parse($acara->waktu_selesai)->format('d M Y')).'</div>
                        </div>';
            })
            ->addColumn('aksi', function ($acara) {
                $show = route('pembuat.acara.show', $acara->slug);
                $edit = route('pembuat.acara.edit', $acara->slug);

                return '<div class="flex  gap-3">
                            <a href="'.$show.'" class="text-indigo-600 hover:text-indigo-800" title="Lihat"><i data-lucide="eye" class="size-5"></i></a>
                            <a href="'.$edit.'" class="text-yellow-600 hover:text-yellow-800" title="Edit"><i data-lucide="edit-3" class="size-5"></i></a>
                        </div>';
            })
            ->editColumn('status', function ($acara) {
                $map = [
                    'published' => 'bg-green-100 text-green-800',
                    'draft' => 'bg-yellow-100 text-yellow-800',
                    'archived' => 'bg-red-100 text-red-800',
                ];
                $cls = $map[$acara->status] ?? 'bg-gray-100 text-gray-800';

                return '<span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full '.$cls.'">'.e(ucfirst($acara->status)).'</span>';
            })
            ->rawColumns(['banner', 'nama_lokasi', 'waktu', 'aksi', 'status'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kreator = Auth::user()->kreator;
        $kategori = kategori::all();

        return view('pembuat_acara.acara.create', compact('kreator', 'kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $isDraft = $request->input('status') === 'draft';

        // Jika bukan draft → jalankan validasi penuh
        if (! $isDraft) {
            $request->validate([
                'banner_acara' => 'nullable|image|mimes:jpg,jpeg,png',
                'nama_acara' => 'required|string|max:255',
                'id_kreator' => 'required|string',
                'id_kategori' => 'required|exists:kategori,id',
                'waktu_mulai' => 'required|date',
                'waktu_selesai' => 'required|date',
                'lokasi' => 'required|string',
                'deskripsi_acara' => 'required|string',
                'satu_transaksi_per_akun' => 'boolean',
                'maks_tiket_per_transaksi' => 'required|integer|min:1',
                'info_narahubung' => 'nullable|string',
                'email_narahubung' => 'nullable|email',
                'is_online' => 'nullable|boolean',
                'venue' => 'nullable|string',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
            ]);
        }

        $acara = new Acara;
        // Wajib isi id_pembuat
        $acara->id_pembuat = Auth::id();

        // Isi field hanya jika tersedia (untuk draft boleh kosong)
        $acara->nama_acara = $request->input('nama_acara');
        $acara->id_kreator = $request->input('id_kreator');
        $acara->deskripsi = $request->input('deskripsi_acara');
        $acara->lokasi = $request->input('lokasi');
        $acara->waktu_mulai = $request->input('waktu_mulai');
        $acara->waktu_selesai = $request->input('waktu_selesai');
        $acara->no_telp_narahubung = $request->input('no_telp_narahubang');
        $acara->info_narahubung = $request->input('info_narahubung');
        $acara->email_narahubung = $request->input('email_narahubung');
        $acara->is_online = $request->input('is_online');
        $acara->venue = $request->input('venue');
        $acara->latitude = $request->input('latitude');
        $acara->longitude = $request->input('longitude');

        // Status mengikuti tombol
        $acara->status = $isDraft ? 'draft' : 'published';

        // Opsi transaksi (boleh kosong saat draft)
        $acara->satu_transaksi_per_akun = $request->boolean('satu_transaksi_per_akun');
        $acara->maks_tiket_per_transaksi = $request->input('maks_tiket_per_transaksi');

        // Banner (opsional)
        if ($request->hasFile('banner_acara')) {
            $path = $request->file('banner_acara')->store('banner_acara', 'public');
            $acara->banner_acara = $path;
        }

        $acara->save();

        // Relasi kategori hanya jika bukan draft dan kategori tersedia
        if (! $isDraft && $request->filled('id_kategori')) {
            EventKategori::create([
                'id_acara' => $acara->id,
                'id_kategori' => $request->id_kategori,
            ]);
        }

        // Jenis tiket: simpan jika dikirim; untuk draft semua field tiket boleh null
        if ($request->has('kategori_tiket') && is_array($request->kategori_tiket)) {
            foreach ($request->kategori_tiket as $kategori) {
                $jenisTiket = new \App\Models\JenisTiket;
                $jenisTiket->id_acara = $acara->id;
                $jenisTiket->nama_jenis = $kategori['nama'] ?? null;
                $jenisTiket->harga = $kategori['harga'] ?? 0;
                $jenisTiket->kuota = $kategori['kuota'] ?? 0;
                $jenisTiket->penjualan_mulai = $kategori['penjualan_mulai'] ?? null;
                $jenisTiket->penjualan_selesai = $kategori['penjualan_selesai'] ?? null;
                $jenisTiket->berlaku_mulai = $kategori['berlaku_mulai'] ?? null;
                $jenisTiket->berlaku_sampai = $kategori['berlaku_sampai'] ?? null;
                $jenisTiket->deskripsi = $kategori['deskripsi'] ?? null;
                $jenisTiket->save();
            }
        }

        return redirect()
            ->route('pembuat.acara.index')
            ->with('success', $isDraft ? 'Draft acara berhasil disimpan!' : 'Acara berhasil dipublish!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Acara $acara)
    {
        // Pastikan hanya pembuat acara yang dapat mengakses
        if ($acara->id_pembuat != Auth::id()) {
            abort(403, 'Acara tidak ditemukan');
        }

        // Muat relasi untuk tampilan
        $acara->load(['jenisTiket', 'kreator', 'kategori']);

        return view('pembuat_acara.acara.show', compact('acara'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Acara $acara)
    {
        // $acara->with('jenisTiket')->findOrFail($acara);
        $kreator = Auth::user()->kreator;

        // Muat relasi lengkap untuk form
        $acara->load(['jenisTiket', 'kreator', 'kategori']);
        $kategori = kategori::all();

        // dd($acara);
        $kategoriacara = $acara->kategori()->first();

        // dd($kategoriacara);

        return view('pembuat_acara.acara.edit', compact('acara', 'kreator', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $isDraft = $request->input('status') === 'draft';

        // Validasi kondisional seperti store
        if (! $isDraft) {
            $request->validate([
                'banner_acara' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'nama_acara' => 'required|string|max:255',
                'id_kategori' => 'required|exists:kategori,id',
                'waktu_mulai' => 'required|date',
                'waktu_selesai' => 'required|date|after_or_equal:waktu_mulai',
                'lokasi' => 'required|string',
                'deskripsi_acara' => 'required|string',
                'satu_transaksi_per_akun' => 'boolean',
                'maks_tiket_per_transaksi' => 'required|integer|min:1',
                'info_narahubung' => 'nullable|string',
                'email_narahubung' => 'nullable|email',
                'no_telp_narahubung' => 'nullable|string',
                'is_online' => 'nullable|boolean',
                'venue' => 'nullable|string',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
            ]);
        }

        $acara = Acara::findOrFail($id);

        if ($acara->id_pembuat !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki izin untuk mengubah acara ini.');
        }

        // Update field utama (boleh kosong untuk draft)
        $acara->fill([
            'nama_acara' => $request->nama_acara,
            'deskripsi' => $request->deskripsi_acara,
            'lokasi' => $request->lokasi,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'no_telp_narahubung' => $request->no_telp_narahubung,
            'info_narahubung' => $request->info_narahubung,
            'email_narahubung' => $request->email_narahubung,
            'is_online' => $request->input('is_online'),
            'venue' => $request->input('venue'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'status' => $isDraft ? 'draft' : 'published',
            'satu_transaksi_per_akun' => $request->boolean('satu_transaksi_per_akun'),
            'maks_tiket_per_transaksi' => $request->maks_tiket_per_transaksi,
        ]);

        // Banner handling seperti sebelumnya
        if ($request->hasFile('banner_acara')) {
            if ($acara->banner_acara && Storage::disk('public')->exists($acara->banner_acara)) {
                Storage::disk('public')->delete($acara->banner_acara);
            }
            $path = $request->file('banner_acara')->store('banner_acara', 'public');
            $acara->banner_acara = $path;
        }

        $acara->save();

        // Relasi kategori: Hanya jika bukan draft dan ada id_kategori
        if (! $isDraft && $request->filled('id_kategori')) {
            EventKategori::where('id_acara', $acara->id)->delete();
            EventKategori::create([
                'id_acara' => $acara->id,
                'id_kategori' => $request->id_kategori,
            ]);
        }

        // Jenis tiket: Tetap seperti sekarang (kelola existing)
        if ($request->has('kategori_tiket') && is_array($request->kategori_tiket)) {
            $existingIds = [];
            foreach ($request->kategori_tiket as $kategori) {
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
                            'berlaku_mulai' => $kategori['berlaku_mulai'] ?? null,
                            'berlaku_sampai' => $kategori['berlaku_sampai'] ?? null,
                            'deskripsi' => $kategori['deskripsi'] ?? null,
                        ]);
                        $existingIds[] = $jenisTiket->id;
                    }
                } else {
                    $new = \App\Models\JenisTiket::create([
                        'id_acara' => $acara->id,
                        'nama_jenis' => $kategori['nama'],
                        'harga' => $kategori['harga'] ?? 0,
                        'kuota' => $kategori['kuota'] ?? 0,
                        'penjualan_mulai' => $kategori['penjualan_mulai'] ?? null,
                        'penjualan_selesai' => $kategori['penjualan_selesai'] ?? null,
                        'berlaku_mulai' => $kategori['berlaku_mulai'] ?? null,
                        'berlaku_sampai' => $kategori['berlaku_sampai'] ?? null,
                        'deskripsi' => $kategori['deskripsi'] ?? null,
                    ]);
                    $existingIds[] = $new->id;
                }
            }
            \App\Models\JenisTiket::where('id_acara', $acara->id)
                ->whereNotIn('id', $existingIds)
                ->delete();
        } else {
            \App\Models\JenisTiket::where('id_acara', $acara->id)->delete();
        }

        return redirect()->route('pembuat.acara.index')->with('success', $isDraft ? 'Draft acara berhasil diperbarui!' : 'Acara berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $acara = Acara::findOrFail($id);

        // Pastikan hanya pembuat acara yang boleh menghapus
        if ($acara->id_pembuat !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki izin untuk menghapus acara ini.');
        }

        // Hapus banner acara jika ada
        if ($acara->banner_acara && Storage::disk('public')->exists($acara->banner_acara)) {
            Storage::disk('public')->delete($acara->banner_acara);
        }

        // Hapus jenis tiket terkait
        $acara->jenisTiket()->delete();

        // Hapus relasi kategori acara
        EventKategori::where('id_acara', $acara->id)->delete();

        // Hapus acara
        $acara->delete();

        return redirect()->route('pembuat.acara.index')->with('success', 'Acara berhasil dihapus!');
    }

    public function archive(string $id)
    {
        $acara = Acara::findOrFail($id);

        // Pastikan hanya pembuat acara yang boleh mengarsipkan
        if ($acara->id_pembuat !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki izin untuk mengarsipkan acara ini.');
        }

        // Update status menjadi archived
        $acara->update(['status' => 'archived']);

        return redirect()->back()->with('success', 'Acara berhasil diarsipkan!');
    }

    public function restore(string $id)
    {
        $acara = Acara::findOrFail($id);

        // Pastikan hanya pembuat acara yang boleh merestore
        if ($acara->id_pembuat !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki izin untuk merestore acara ini.');
        }

        // Update status menjadi draft (atau published tergantung kebutuhan)
        $acara->update(['status' => 'draft']);

        return redirect()->back()->with('success', 'Acara berhasil direstore!');
    }

    public function publish(string $id)
    {
        $acara = Acara::findOrFail($id);

        // Pastikan hanya pembuat acara yang boleh merestore
        if ($acara->id_pembuat !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki izin untuk merestore acara ini.');
        }

        // Update status menjadi draft (atau published tergantung kebutuhan)
        $acara->update(['status' => 'published']);

        return redirect()->back()->with('success', 'Acara berhasil direstore!');
    }

    public function daftarPeserta(Acara $acara)
    {
        // Ambil semua peserta berdasarkan acara tertentu
        $peserta = DB::table('tiket_peserta as tp')
            ->join('detail_pesanan as dp', 'tp.id_detail_pesanan', '=', 'dp.id')
            ->join('jenis_tiket as jt', 'dp.id_jenis_tiket', '=', 'jt.id')
            ->join('pesanan as p', 'dp.id_pesanan', '=', 'p.id')
            ->where('jt.id_acara', $acara->id)
            ->select(
                'tp.id',
                'tp.kode_tiket',
                'tp.nama_peserta',
                'tp.email_peserta',
                'tp.no_telp_peserta',
                'tp.status_checkin',
                'tp.waktu_checkin',
                'jt.nama_jenis as jenis_tiket',
                'p.kode_pesanan',
                'p.nama_pemesan',
                'p.email_pemesan'
            )
            ->get();

        return view('pembuat_acara.acara.peserta.daftar-peserta', [
            'acara' => $acara,
            'peserta' => $peserta,
        ]);
    }
}
