<?php

namespace App\Http\Controllers;

use App\Models\Kreator;
use App\Models\Pembeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PembeliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

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
    public function show(Pembeli $pembeli)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembeli $pembeli)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembeli $pembeli)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembeli $pembeli)
    {
        //
    }

    public function assignRolePembuat()
    {
        $user = Auth::user();

        // Assign role

        // Generate slug unik
        $slug = Str::slug($user->name).'-'.Str::random(4);

        // Isi tabel kreator
        Kreator::create([
            'id_user' => $user->id,
            'nama_kreator' => $user->name,
            'slug' => $slug,
            'deskripsi' => null,
            'logo' => null,
        ]);

        $user->assignRole('kreator');

        return redirect()->route('pembuat.dashboard')
            ->with('success', 'Selamat! Anda sekarang menjadi Kreator Acara');
    }
}
