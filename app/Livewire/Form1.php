<?php

namespace App\Livewire;

use Livewire\Component;

class Form1 extends Component
{
    // Properti untuk melacak langkah saat ini
    public $currentStep = 1;

    // Properti untuk data form
    public $name, $email, $address, $phone;

    // Aturan validasi untuk semua field
    protected $rules = [
        'name' => 'required|string|min:3',
        'email' => 'required|email|unique:users', // Pastikan unik di tabel users
        'address' => 'required|string',
        'phone' => 'required|numeric',
    ];

    /**
     * Pindah ke langkah 2 setelah memvalidasi langkah 1
     */
    public function firstStepSubmit()
    {
        // Validasi hanya field dari langkah 1
        $this->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
        ]);

        // Jika valid, pindah ke langkah 2
        $this->currentStep = 2;
    }

    /**
     * Kembali ke langkah 1
     */
    public function previousStep()
    {
        $this->currentStep = 1;
    }

    /**
     * Submit form (Langkah Terakhir)
     */
    public function submitForm()
    {
        // Validasi field dari langkah 2
        $this->validate([
            'address' => 'required|string',
            'phone' => 'required|numeric',
        ]);

        // (Opsional) Validasi semua field lagi sebelum submit
        // $this->validate(); 
        
        // Logika untuk menyimpan data ke database
        // Contoh:
        // User::create([
        //     'name' => $this->name,
        //     'email' => $this->email,
        //     'address' => $this->address,
        //     'phone' => $this->phone,
        // ]);

        // Beri pesan sukses
        session()->flash('success', 'Registrasi berhasil!');

        // Reset form dan kembali ke langkah 1
        $this->reset();
        $this->currentStep = 1;
    }
    public function render()
    {
        return view('livewire.form1');
    }
}
