<div>
    {{-- Menampilkan pesan sukses setelah submit --}}
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- 
      Gunakan wire:submit.prevent untuk menangani submit form 
      hanya pada tombol "Submit" (bukan "Next") 
    --}}
    <form wire:submit.prevent="submitForm">

        {{-- =================================== --}}
        {{-- LANGKAH 1: Informasi Dasar --}}
        {{-- =================================== --}}
        
        {{-- Tampilkan blok ini HANYA jika $currentStep adalah 1 --}}
        @if ($currentStep == 1)
            <div id="step-1">
                <h5 class="card-title">Langkah 1: Informasi Dasar</h5>
                <hr>
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" wire:model="name" id="name">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" wire:model="email" id="email">
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        @endif

        {{-- =================================== --}}
        {{-- LANGKAH 2: Informasi Kontak --}}
        {{-- =================================== --}}
        
        {{-- Tampilkan blok ini HANYA jika $currentStep adalah 2 --}}
        @if ($currentStep == 2)
            <div id="step-2">
                <h5 class="card-title">Langkah 2: Informasi Kontak</h5>
                <hr>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control" wire:model="address" id="address" rows="3"></textarea>
                    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-3">
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" wire:model="phone" id="phone">
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        @endif


        {{-- =================================== --}}
        {{-- Tombol Navigasi --}}
        {{-- =================================== --}}
        <div class="d-flex justify-content-between mt-4">
            
            {{-- Tombol "Back" hanya muncul di langkah 2 --}}
            @if ($currentStep == 2)
                <button type="button" class="btn btn-secondary" wire:click="previousStep">
                    Kembali
                </button>
            @else
                {{-- Placeholder agar tombol "Next" tetap di kanan --}}
                <span></span> 
            @endif

            {{-- Tombol "Next" hanya muncul di langkah 1 --}}
            @if ($currentStep == 1)
                <button type="button" class="btn btn-primary" wire:click="firstStepSubmit">
                    Lanjut
                </button>
            @endif

            {{-- Tombol "Submit" hanya muncul di langkah 2 --}}
            @if ($currentStep == 2)
                <button type="submit" class="btn btn-success">
                    Submit
                </button>
            @endif
        </div>

    </form>
</div>