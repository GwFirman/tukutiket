<?php

namespace App\Http\Controllers\PembuatAcara;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AcaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        $acaras = Acara::where('id_pembuat', $userId)->get();

        return view('pembuat_acara.acara.index',compact('acaras'));
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
            'banner_acara' => "nullable|image|mimes:jpg,jpeg,png",
            'nama_acara' =>'required|string|max:255',
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
                $jenisTiket = new \App\Models\JenisTiket();
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
        return view('pembuat_acara.acara.show',compact('acara'));        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $acara = Acara::findOrFail($id);
        return view('pembuat_acara.acara.edit',compact('acara'));
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
