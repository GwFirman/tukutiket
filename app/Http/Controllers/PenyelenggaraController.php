<?php

namespace App\Http\Controllers;

use App\Models\Penyelenggara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenyelenggaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penyelenggara = Auth::user()->penyelenggara;

        return view('pembuat_acara.penyelenggara.index', compact('penyelenggara'));
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
    public function show(Penyelenggara $penyelenggara)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penyelenggara $penyelenggara)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penyelenggara $penyelenggara)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penyelenggara $penyelenggara)
    {
        //
    }
}
