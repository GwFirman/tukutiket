<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
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
        // dd($request);

        $pesanan = Pesanan::create([
            'id_pembeli' => Auth::id(),
            'kode_pesanan' => 'ORD-' . strtoupper(Str::random(8)),
            'total_harga' => $request->grand_total,
            'status_pembayaran' => 'pending'
        ]);

        foreach ($request->tickets as $ticket){
            DetailPesanan::create([
                'id_pesanan' => $pesanan->id,
                'id_jenis_tiket' => $ticket['id'],
                'jumlah' => $ticket['quantity'],
                'harga_per_tiket' => $ticket['price']
            ]);
        }

        return redirect()->route('beranda');
    }

    /**
     * Display the specified resource.
     */
    public function show(Acara  $checkout )
    {
        $checkout->load('jenisTiket');
        // dd($checkout);

        // dd($acara);
        return view('pembeli.acara.checkout',['acara' => $checkout]);   

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
