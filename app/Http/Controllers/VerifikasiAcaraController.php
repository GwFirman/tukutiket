<?php

namespace App\Http\Controllers;

use App\Models\Acara;
use App\Models\VerifikasiAcara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VerifikasiAcaraController extends Controller
{
    /**
     * Display the event verification form.
     */
    public function show(Acara $acara)
    {
        // Ensure the event belongs to the authenticated user (kreator)
        if ($acara->id_kreator != Auth::user()->kreator->id) {
            abort(403, 'Unauthorized');
        }

        // Load existing verifications
        $verifikasi = VerifikasiAcara::where('id_acara', $acara->id)->get();

        return view('pembeli.acara.verifikasi-izin', compact('acara', 'verifikasi'));
    }

    /**
     * Store the verification documents (bulk upload).
     */
    public function store(Request $request, Acara $acara)
    {
        // Ensure the event belongs to the authenticated user (kreator)
        if ($acara->id_kreator != Auth::user()->kreator->id) {
            abort(403, 'Unauthorized');
        }

        // Check if already has pending documents
        $existingDocs = VerifikasiAcara::where('id_acara', $acara->id)
            ->whereIn('status_verifikasi', ['pending', 'approved'])
            ->count();

        if ($existingDocs > 0) {
            return redirect()->back()
                ->with('error', 'Dokumen sudah pernah diunggah. Anda tidak dapat mengunggah dokumen tambahan.');
        }

        // Validate the request
        $validated = $request->validate([
            'files' => 'required|array|min:1|max:5',
            'files.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ], [
            'files.required' => 'Minimal satu file harus diunggah',
            'files.array' => 'Files harus berupa array',
            'files.min' => 'Minimal satu file harus diunggah',
            'files.max' => 'Maksimal 5 file yang dapat diunggah',
            'files.*.required' => 'File tidak boleh kosong',
            'files.*.file' => 'File harus berupa file yang valid',
            'files.*.mimes' => 'File harus dalam format PDF, JPG, JPEG, atau PNG',
            'files.*.max' => 'Ukuran file tidak boleh lebih dari 10 MB',
        ]);

        try {
            // Hapus dokumen lama jika status rejected
            if ($acara->status === 'rejected') {
                $oldDocs = VerifikasiAcara::where('id_acara', $acara->id)->get();
                foreach ($oldDocs as $oldDoc) {
                    if ($oldDoc->file_path && Storage::disk('public')->exists($oldDoc->file_path)) {
                        Storage::disk('public')->delete($oldDoc->file_path);
                    }
                    $oldDoc->delete();
                }
            }

            $uploadedFiles = [];

            // Process each file
            foreach ($request->file('files') as $index => $file) {
                // Generate unique filename
                $filename = time().'_'.$acara->id.'_'.($index + 1).'.'.$file->getClientOriginalExtension();
                $filePath = $file->storeAs('verifikasi-acara', $filename, 'public');

                // Determine document type based on filename or content
                $originalName = strtolower($file->getClientOriginalName());
                $jenisDokumen = 'lainnya'; // default

                if (str_contains($originalName, 'surat') && str_contains($originalName, 'izin')) {
                    $jenisDokumen = 'surat_izin';
                } elseif (str_contains($originalName, 'bpjs')) {
                    $jenisDokumen = 'bpjs';
                } elseif (str_contains($originalName, 'pajak') || str_contains($originalName, 'npwp')) {
                    $jenisDokumen = 'pajak';
                }

                // Create verification record
                VerifikasiAcara::create([
                    'id_acara' => $acara->id,
                    'jenis_dokumen' => $jenisDokumen,
                    'nama_dokumen' => $file->getClientOriginalName(),
                    'file_path' => $filePath,
                    'status_verifikasi' => 'pending',
                ]);

                $uploadedFiles[] = $file->getClientOriginalName();
            }

            // Update event status to pending_verifikasi
            $acara->update([
                'status' => 'pending_verifikasi',
            ]);

            $fileCount = count($uploadedFiles);

            return redirect()->route('pembuat.verifikasi.show', $acara->slug)
                ->with('success', "{$fileCount} dokumen berhasil diunggah: ".implode(', ', $uploadedFiles).'. Tim admin akan melakukan review dalam 1-3 hari kerja.');
        } catch (\Exception $e) {
            Log::error('Verifikasi Acara Bulk Upload Error: '.$e->getMessage());

            return redirect()->back()
                ->with('error', 'Gagal mengunggah dokumen. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Delete the verification document.
     */
    public function destroy(VerifikasiAcara $verifikasi)
    {
        // Validasi authorization
        $acara = $verifikasi->acara;
        if ($acara->id_kreator != Auth::user()->kreator->id) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus dokumen ini.');
        }

        // Cek status
        if (! in_array($verifikasi->status_verifikasi, ['pending', 'rejected'])) {
            return back()->with('error', 'Dokumen yang sudah approved tidak bisa dihapus.');
        }

        try {
            // Hapus file
            if ($verifikasi->file_path && Storage::disk('public')->exists($verifikasi->file_path)) {
                Storage::disk('public')->delete($verifikasi->file_path);
            }

            // Hapus dari database
            $verifikasi->delete();

            return back()->with('success', 'Dokumen berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Verifikasi Acara Delete Error: '.$e->getMessage());

            return back()->with('error', 'Gagal menghapus dokumen. Silakan coba lagi.');
        }
    }
}
