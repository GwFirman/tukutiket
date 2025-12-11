<?php

namespace App\Http\Controllers\PembuatAcara;

use App\Http\Controllers\Controller;
use App\Models\Kreator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KreatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kreator = Kreator::where('id_user', Auth::id())->first();

        return view('pembuat_acara.profile', compact('kreator'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ensure the user is authenticated and has the 'kreator' role
        if (Auth::check() && Auth::user()->hasRole('kreator')) {
            return redirect()->route('pembuat.dashboard');
        }

        return view('pembuat_acara.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kreator' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        // Cek apakah user sudah punya kreator (prevent bug)
        if ($user->kreator) {
            return redirect()->route('pembuat.dashboard')
                ->with('error', 'Anda sudah memiliki profil kreator.');
        }

        // Upload logo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('kreator/logo', 'public');
        }

        // ========== BUAT SLUG DENGAN RANDOM STRING HANYA SAAT PERTAMA DAFTAR ==========
        $baseSlug = Str::slug($request->nama_kreator);
        $randomString = Str::upper(Str::random(4)); // contoh: AJ29, F8KD

        $finalSlug = $baseSlug.'-'.$randomString;

        // Buat kreator
        $kreator = Kreator::create([
            'id_user' => $user->id,
            'nama_kreator' => $request->nama_kreator,
            'deskripsi' => $request->deskripsi,
            'slug' => $finalSlug,   // ← slug baru yang sudah ada random string
            'logo' => $logoPath,
        ]);

        // Assign role kreator
        $user->assignRole('kreator');

        return redirect()->route('pembuat.dashboard')
            ->with('success', 'Profil kreator berhasil dibuat!');
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
    public function update(Request $request)
    {
        $request->validate([
            'nama_kreator' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $kreator = Kreator::where('id_user', Auth::id())->firstOrFail();

        $kreator->nama_kreator = $request->nama_kreator;
        $kreator->deskripsi = $request->deskripsi;

        // upload logo jika ada
        if ($request->hasFile('logo')) {
            if ($kreator->logo) {
                Storage::delete($kreator->logo);
            }

            $kreator->logo = $request->file('logo')->store('kreator/logo', 'public');
        }

        // slug update otomatis
        $kreator->slug = $request->slug;

        $kreator->save();

        return back()->with('success', 'Profil kreator berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
