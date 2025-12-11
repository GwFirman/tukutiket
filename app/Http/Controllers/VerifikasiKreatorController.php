<?php

namespace App\Http\Controllers;

use App\Models\VerifikasiKreator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VerifikasiKreatorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kreator = $user->kreator;

        // Cek apakah user sudah punya data kreator
        if (! $kreator) {
            return redirect()->route('pembuat.dashboard')
                ->with('error', 'Data kreator tidak ditemukan. Silakan lengkapi profil kreator terlebih dahulu.');
        }

        // Ambil data verifikasi jika sudah ada
        $verifikasi = VerifikasiKreator::where('id_kreator', $kreator->id)->first();

        return view('pembeli.verifikasi-data', compact('verifikasi'));
    }

    public function create()
    {
        $user = Auth::user();
        $kreator = $user->kreator;

        if (! $kreator) {
            return redirect()->route('pembuat.dashboard')
                ->with('error', 'Data kreator tidak ditemukan.');
        }

        return view('pembeli.verifikasi-data', ['verifikasi' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto_ktp' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'foto_npwp' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ], [
            'foto_ktp.required' => 'Foto KTP wajib diupload.',
            'foto_ktp.image' => 'File harus berupa gambar.',
            'foto_ktp.mimes' => 'Format gambar harus PNG, JPG, atau JPEG.',
            'foto_ktp.max' => 'Ukuran file maksimal 2MB.',
            'foto_npwp.image' => 'File harus berupa gambar.',
            'foto_npwp.mimes' => 'Format gambar harus PNG, JPG, atau JPEG.',
            'foto_npwp.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $user = Auth::user();
        $kreator = $user->kreator;

        // Cek apakah user sudah punya data kreator
        if (! $kreator) {
            return redirect()->back()
                ->with('error', 'Data kreator tidak ditemukan. Silakan lengkapi profil kreator terlebih dahulu.');
        }

        // Cek apakah sudah pernah submit verifikasi
        $existingVerifikasi = VerifikasiKreator::where('id_kreator', $kreator->id)->first();
        if ($existingVerifikasi && $existingVerifikasi->status == 'pending') {
            return redirect()->back()
                ->with('error', 'Anda sudah mengajukan verifikasi. Mohon tunggu proses review.');
        }

        // Jika status rejected, hapus data lama dan buat baru
        if ($existingVerifikasi && $existingVerifikasi->status == 'rejected') {
            // Hapus file lama jika ada
            if ($existingVerifikasi->foto_ktp) {
                Storage::disk('public')->delete($existingVerifikasi->foto_ktp);
            }
            if ($existingVerifikasi->foto_npwp) {
                Storage::disk('public')->delete($existingVerifikasi->foto_npwp);
            }
            $existingVerifikasi->delete();
        }

        // Upload file KTP
        $ktp = $request->file('foto_ktp')->store('verifikasi/ktp', 'public');

        // Upload file NPWP jika ada
        $npwp = null;
        if ($request->hasFile('foto_npwp')) {
            $npwp = $request->file('foto_npwp')->store('verifikasi/npwp', 'public');
        }

        // Simpan data verifikasi
        VerifikasiKreator::create([
            'id_kreator' => $kreator->id,
            'foto_ktp' => $ktp,
            'foto_npwp' => $npwp,
            'status' => 'pending',
        ]);

        return redirect()->route('pembuat.verifikasi-data.index')
            ->with('success', 'Dokumen verifikasi berhasil dikirim! Mohon tunggu 1-3 hari kerja untuk proses review.');
    }
}
