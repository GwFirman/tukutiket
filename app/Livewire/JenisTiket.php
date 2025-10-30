<?php

namespace App\Livewire;

use Livewire\Component;

class JenisTiket extends Component
{
    public $selected = ''; // jenis tiket (gratis/berbayar)
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
        return view('livewire.jenis-tiket');
    }
}
