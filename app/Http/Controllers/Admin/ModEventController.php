<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class ModEventController extends Controller
{
    /**
     * Display a listing of events reported for takedown.
     */
    public function index()
    {
        $events = Acara::with('kreator')
            ->where('status', '=', 'published') // Hanya tampilkan event yang published
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.mod-event.index', [
            'events' => $events,
        ]);
    }

    /**
     * Display the specified event for moderation.
     */
    public function show(Acara $acara)
    {
        $acara->load('kreator', 'jenisTiket');

        return view('admin.mod-event.show', [
            'acara' => $acara,
        ]);
    }

    /**
     * Takedown the event (set to archived).
     */
    public function takedown(Acara $acara)
    {
        $acara->update(['status' => 'archived']);

        return Redirect::route('admin.mod-event.index')
            ->with('success', "Event '{$acara->nama_acara}' berhasil di-takedown!");
    }

    /**
     * Reject the takedown request.
     */
    public function reject(Request $request, Acara $acara)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $acara->update([
            'takedown_rejected_at' => now(),
            'takedown_rejection_reason' => $validated['reason'],
        ]);

        return Redirect::route('admin.mod-event.index')
            ->with('success', "Permintaan takedown untuk event '{$acara->nama_acara}' ditolak!");
    }

    /**
     * Display a listing of events that need verification or have been verified.
     */
    public function indexVerifikasi()
    {
        $acaraAll = Acara::whereIn('status', ['pending_verifikasi', 'published', 'rejected'])
            ->with(['kreator.user', 'verifikasiAcara'])
            ->get();

        $acaraPending = $acaraAll->where('status', 'pending_verifikasi');
        $approvedToday = $acaraAll->where('status', 'published')
            ->where('updated_at', '>=', today());
        $rejectedToday = $acaraAll->where('status', 'rejected')
            ->where('updated_at', '>=', today());
        $totalDocuments = $acaraAll->sum(function ($acara) {
            return $acara->verifikasiAcara->count();
        });

        $acaraPending = Acara::whereIn('status', ['pending_verifikasi', 'published', 'rejected'])
            ->with(['kreator.user', 'verifikasiAcara'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('admin.mod-izin.index', compact('acaraPending', 'approvedToday', 'rejectedToday', 'totalDocuments'));
    }

    /**
     * Approve an event and publish it.
     */
    public function approve(Acara $acara)
    {
        try {
            // Update event status to published
            $acara->update([
                'status' => 'published',
            ]);

            // Update all verification documents to approved
            $acara->verifikasiAcara()->update([
                'status_verifikasi' => 'approved',
                'diverifikasi_oleh' => Auth::id(),
                'diverifikasi_pada' => now(),
            ]);

            return redirect()->back()
                ->with('success', 'Acara berhasil disetujui dan dipublish.');
        } catch (\Exception $e) {
            Log::error('Event Approval Error: '.$e->getMessage());

            return redirect()->back()
                ->with('error', 'Gagal menyetujui acara. Silakan coba lagi.');
        }
    }

    /**
     * Reject an event with reason (for verification).
     */
    public function rejectVerification(Request $request, Acara $acara)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:500',
        ], [
            'catatan_admin.required' => 'Alasan penolakan harus diisi',
            'catatan_admin.max' => 'Alasan penolakan maksimal 500 karakter',
        ]);

        try {
            // Update event status to rejected
            $acara->update([
                'status' => 'rejected',
            ]);

            // Update all verification documents to rejected with notes
            $acara->verifikasiAcara()->update([
                'status_verifikasi' => 'rejected',
                'catatan_admin' => $request->catatan_admin,
                'diverifikasi_oleh' => Auth::id(),
                'diverifikasi_pada' => now(),
            ]);

            return redirect()->back()
                ->with('success', 'Acara berhasil ditolak.');
        } catch (\Exception $e) {
            Log::error('Event Rejection Error: '.$e->getMessage());

            return redirect()->back()
                ->with('error', 'Gagal menolak acara. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified event for verification.
     */
    public function showVerifikasi(Acara $acara)
    {
        $acara->load('kreator.user', 'jenisTiket', 'verifikasiAcara');

        return view('admin.mod-izin.show', [
            'acara' => $acara,
        ]);

    }
}
