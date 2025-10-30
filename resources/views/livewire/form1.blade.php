<div class="max-w-4xl mx-auto p-6 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    {{-- Progress Bar --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-10 h-10 {{ $currentStep >= 1 ? 'bg-gradient-to-r from-indigo-500 to-indigo-600' : 'bg-gray-300' }} text-white rounded-full flex items-center justify-center font-bold shadow-lg">1</div>
                <span class="ml-3 text-gray-700 font-medium">Informasi Dasar</span>
            </div>
            <div class="flex-1 mx-4 h-2 bg-gray-300 rounded-full">
                <div class="h-2 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-full transition-all duration-500" style="width: {{ $currentStep == 1 ? '50%' : '100%' }}"></div>
            </div>
            <div class="flex items-center">
                <div class="w-10 h-10 {{ $currentStep == 2 ? 'bg-gradient-to-r from-indigo-500 to-indigo-600' : 'bg-gray-300' }} text-white rounded-full flex items-center justify-center font-bold shadow-lg">2</div>
                <span class="ml-3 text-gray-700 font-medium">Informasi Kontak</span>
            </div>
        </div>
    </div>

    {{-- Menampilkan pesan sukses setelah submit --}}
    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg shadow-md animate-pulse">
            {{ session('success') }}
        </div>
    @endif

    {{-- 
      Gunakan wire:submit.prevent untuk menangani submit form 
      hanya pada tombol "Submit" (bukan "Next") 
    --}}
    <form wire:submit.prevent="submitForm" class="bg-white rounded-xl shadow-2xl p-8 transform transition-all duration-300 hover:shadow-3xl">

        {{-- =================================== --}}
        {{-- LANGKAH 1: Informasi Dasar --}}
        {{-- =================================== --}}
        
        {{-- Tampilkan blok ini HANYA jika $currentStep adalah 1 --}}
        @if ($currentStep == 1)
            <div id="step-1" class="space-y-6 animate-fade-in">
                <h5 class="text-3xl font-bold text-gray-800 border-b-4 border-indigo-500 pb-3 flex items-center">
                    <svg class="w-8 h-8 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Langkah 1: Informasi Dasar
                </h5>
                
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-semibold text-gray-700">Nama</label>
                    <input type="text" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition-all duration-200 shadow-sm" wire:model="name" id="name" placeholder="Masukkan nama lengkap">
                    @error('name') <span class="text-red-500 text-sm font-medium">{{ $message }}</span> @enderror
                </div>
                
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                    <input type="email" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition-all duration-200 shadow-sm" wire:model="email" id="email" placeholder="Masukkan alamat email">
                    @error('email') <span class="text-red-500 text-sm font-medium">{{ $message }}</span> @enderror
                </div>
            </div>
        @endif

        {{-- =================================== --}}
        {{-- LANGKAH 2: Informasi Kontak --}}
        {{-- =================================== --}}
        
        {{-- Tampilkan blok ini HANYA jika $currentStep adalah 2 --}}
        @if ($currentStep == 2)
            <div id="step-2" class="space-y-6 animate-fade-in">
                <h5 class="text-3xl font-bold text-gray-800 border-b-4 border-indigo-500 pb-3 flex items-center">
                    <svg class="w-8 h-8 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    Langkah 2: Informasi Kontak
                </h5>

                <div class="space-y-2">
                    <label for="address" class="block text-sm font-semibold text-gray-700">Alamat</label>
                    <textarea class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition-all duration-200 shadow-sm resize-none" wire:model="address" id="address" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                    @error('address') <span class="text-red-500 text-sm font-medium">{{ $message }}</span> @enderror
                </div>
                
                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-semibold text-gray-700">Nomor Telepon</label>
                    <input type="text" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition-all duration-200 shadow-sm" wire:model="phone" id="phone" placeholder="Masukkan nomor telepon">
                    @error('phone') <span class="text-red-500 text-sm font-medium">{{ $message }}</span> @enderror
                </div>
            </div>
        @endif


        {{-- =================================== --}}
        {{-- Tombol Navigasi --}}
        {{-- =================================== --}}
        <div class="flex justify-between items-center mt-10">
            
            {{-- Tombol "Back" hanya muncul di langkah 2 --}}
            @if ($currentStep == 2)
                <button type="button" class="px-8 py-4 bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-xl hover:from-gray-500 hover:to-gray-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-semibold" wire:click="previousStep">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali
                </button>
            @else
                {{-- Placeholder agar tombol "Next" tetap di kanan --}}
                <span></span> 
            @endif

            {{-- Tombol "Next" hanya muncul di langkah 1 --}}
            @if ($currentStep == 1)
                <button type="button" class="px-8 py-4 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-xl hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-semibold" wire:click="firstStepSubmit">
                    Lanjut
                    <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            @endif

            {{-- Tombol "Submit" hanya muncul di langkah 2 --}}
            @if ($currentStep == 2)
                <button type="submit" class="px-8 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-semibold">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Submit
                </button>
            @endif
        </div>

    </form>
</div>