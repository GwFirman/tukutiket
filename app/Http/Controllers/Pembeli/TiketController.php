<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\TiketPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TiketController extends Controller
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

        return view('pembeli.tiket.index', compact('tiketList'));
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
