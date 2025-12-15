<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VerifikasiKreator;

class ModKretorController extends Controller
{
    public function index()
    {
        // Ambil data verifikasi kreator dengan relasi kreator dan user
        $verifikasiData = VerifikasiKreator::with(['kreator.user'])
            ->paginate(10);

        // Hitung statistik
        $stats = [
            'pending' => VerifikasiKreator::where('status', 'pending')->count(),
            'approved' => VerifikasiKreator::where('status', 'approved')->count(),
            'rejected' => VerifikasiKreator::where('status', 'rejected')->count(),
        ];

        return view('admin.mod-kreator.index', compact('verifikasiData', 'stats'));
    }

    public function show($id)
    {
        // Ambil data verifikasi kreator berdasarkan ID
        $verifikasi = VerifikasiKreator::with(['kreator.user'])->findOrFail($id);

        return view('admin.mod-kreator.show', compact('verifikasi'));
    }

    public function approve($id)
    {
        $verifikasi = VerifikasiKreator::findOrFail($id);

        // Cek apakah status pending
        if ($verifikasi->status !== 'pending') {
            return redirect()->back()->with('error', 'Verifikasi ini sudah di-review sebelumnya.');
        }

        // Update status menjadi approved
        $verifikasi->update([
            'status' => 'approved',
        ]);

        return redirect()->route('admin.mod-kreator')
            ->with('success', 'Verifikasi kreator berhasil disetujui!');
    }

    public function reject($id)
    {
        $request = request();
        
        // Validasi catatan
        $request->validate([
            'catatan_admin' => 'required|string|min:10|max:500',
        ], [
            'catatan_admin.required' => 'Catatan penolakan harus diisi.',
            'catatan_admin.min' => 'Catatan minimal 10 karakter.',
            'catatan_admin.max' => 'Catatan maksimal 500 karakter.',
        ]);

        $verifikasi = VerifikasiKreator::findOrFail($id);

        // Cek apakah status pending
        if ($verifikasi->status !== 'pending') {
            return redirect()->back()->with('error', 'Verifikasi ini sudah di-review sebelumnya.');
        }

        // Update status menjadi rejected dan simpan catatan
        $verifikasi->update([
            'status' => 'rejected',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->route('admin.mod-kreator')
            ->with('success', 'Verifikasi kreator berhasil ditolak!');
    }}
