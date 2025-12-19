<?php

namespace App\Livewire;

use Livewire\Component;

class BuatAcara extends Component
{
    public $currentStep = 2;

    public $banner_acara;

    public $nama_acara;

    public $lokasi;

    public $no_telp_narahubung;

    public $waktu_mulai = '';

    public $waktu_selesai = '';

    public $deskripsi_acara;

    public $jenis_tiket;

    public $kategori_tiket = [];

    public $banner_tiket;

    public $selected = 'gratis'; // jenis tiket (gratis/berbayar)

    public $kategoriList = []; // daftar kategori tiket

    public $showModal = false;

    public $editIndex = null;

    public $kategoriBaru = [
        'nama' => '',
        'harga' => '',
        'kuota' => '',
        'penjualan_mulai' => '',
        'penjualan_selesai' => '',
        'deskripsi' => '',
    ];

    protected $listeners = ['tanggal-terpilih' => 'setTanggal'];

    // protected $rules = [
    //     'nama_acara' => 'required|min:3',
    //     'lokasi' => 'required'

    // ];
    public function setTanggal($data)
    {
        $this->waktu_mulai = $data['mulai'];
        $this->waktu_selesai = $data['selesai'];
    }

    public function firstStepSubmit()
    {

        $this->validate([
            'nama_acara' => 'required|min:3',
            'lokasi' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'deskripsi_acara' => 'required',
        ]);

        $this->currentStep = 2;
    }

    public function previousStep()
    {
        $this->currentStep = 1;
    }

    public function submit() {}

    public function updatedSelected()
    {
        if ($this->selected === 'gratis') {
            $this->kategoriList = [];
        }
    }

    public function openModal($index = null)
    {
        if ($index !== null) {
            $this->editIndex = $index;
            $this->kategoriBaru = $this->kategoriList[$index];
        } else {
            $this->resetKategori();
            $this->editIndex = null;
        }
        $this->showModal = true;
    }

    public function simpanTiket($data)
    {
        $this->jenis_tiket = $data['selected'] ?? 'gratis';
        $this->kategori_tiket = $data['kategoriList'] ?? [];

        // Debugging sementara
        logger('Data tiket dari Alpine:', $data);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetKategori();
    }

    public function tambahKategori()
    {
        $this->validate([
            'kategoriBaru.nama' => 'required|string|max:100',
            'kategoriBaru.harga' => 'nullable|numeric|min:0',
            'kategoriBaru.kuota' => 'required|integer|min:1',
            'kategoriBaru.penjualan_mulai' => 'required|date',
            'kategoriBaru.penjualan_selesai' => 'required|date|after_or_equal:kategoriBaru.penjualan_mulai',
            'kategoriBaru.deskripsi' => 'nullable|string|max:500',
        ]);

        if ($this->editIndex !== null) {
            $this->kategoriList[$this->editIndex] = $this->kategoriBaru;
        } else {
            $this->kategoriList[] = $this->kategoriBaru;
        }

        $this->closeModal();
    }

    public function hapusKategori($index)
    {
        unset($this->kategoriList[$index]);
        $this->kategoriList = array_values($this->kategoriList); // reset index array
    }

    public function resetKategori()
    {
        $this->kategoriBaru = [
            'nama' => '',
            'harga' => '',
            'kuota' => '',
            'penjualan_mulai' => '',
            'penjualan_selesai' => '',
            'deskripsi' => '',
        ];
    }

    public function render()
    {
        return view('livewire.buat-acara');
    }
}
