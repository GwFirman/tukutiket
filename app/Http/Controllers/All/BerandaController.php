<?php

namespace App\Http\Controllers\All;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $acaras = Acara::with('jenisTiket')->where('status', 'published')->get();

        // dd($acaras);
        return view('beranda', compact('acaras'));
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
    public function show(Acara $acara)
    {
        $acara->load('jenisTiket');

        // dd($acara);

        $alreadyBought = $acara->satu_transaksi_per_akun && Pesanan::where('id_pembeli', Auth::id())
            ->whereHas('detailPesanan.jenisTiket', fn ($q) => $q->where('id_acara', $acara->id)
            )
            ->whereIn('status_pembayaran', ['paid', 'pending'])
            ->exists();

        return view('pembeli.acara.show', compact('acara', 'alreadyBought'));
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
