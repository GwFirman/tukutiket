<?php

namespace App\Livewire\Pembuat;

use App\Models\Acara;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DaftarAcara extends Component
{
    public $search = '';

    public $status = ''; // '' = semua status

    // Mengubah status ketika tab diklik
    public function setStatus($value)
    {
        $this->status = $value;
    }

    // Trigger re-render
    public function searchAcara() {}

    // Reset pencarian + status
    public function resetFilters()
    {
        $this->search = '';
        $this->status = '';
    }

    public function render()
    {
        $acaras = Acara::where('id_pembuat', Auth::id())
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama_acara', 'like', '%'.$this->search.'%')
                        ->orWhere('lokasi', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.pembuat.daftar-acara', [
            'acaras' => $acaras,
        ]);
    }
}
