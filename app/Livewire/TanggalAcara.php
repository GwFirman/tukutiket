<?php

namespace App\Livewire;

use Livewire\Component;

class TanggalAcara extends Component
{
    public $showModal = false;
    public $waktu_mulai;
    public $waktu_selesai;

    public function getLabelProperty()
    {
        if ($this->waktu_mulai && $this->waktu_selesai) {
            return $this->formatTanggal($this->waktu_mulai) . ' - ' . $this->formatTanggal($this->waktu_selesai);
        }
        return 'Pilih tanggal acara';
    }

    public function formatTanggal($tanggal)
    {
        return \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y');
    }

    public function bukaModal()
    {
        $this->showModal = true;
    }

    public function simpanTanggal()
    {
        $this->showModal = false;
        $this->dispatch('tanggal-terpilih', [
            'mulai' => $this->waktu_mulai,
            'selesai' => $this->waktu_selesai,
        ]);
    }

    public function render()
    {
        return view('livewire.tanggal-acara');
    }
}
