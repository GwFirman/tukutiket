<x-guest-layout :showNavbar="false">
    <div class="flex flex-col md:flex-row min-h-screen w-full md:justify-center md:items-center p-4 md:p-6 lg:p-8">
        <div class="flex flex-col md:flex-row w-full bg-white overflow-hidden md:rounded-lg md:shadow-lg md:max-w-5xl">

            <div class="hidden md:block md:w-1/2 overflow-hidden">
                <img src="{{ asset('images/EO.jpg') }}" alt="Ilustrasi pembuatan event" loading="lazy"
                    class="h-full w-full object-cover block" />
            </div>

            {{-- Form Registrasi Kreator --}}
            <div class="w-full md:w-1/2 px-6 sm:px-8 md:px-12 lg:px-16 py-8 md:py-12 flex flex-col justify-center">
                <div class="flex gap-3 sm:gap-4 mb-6">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-2 rounded-lg flex-shrink-0">
                        <i data-lucide="badge-check" class="w-6 h-6 sm:w-8 sm:h-8 text-white"></i>
                    </div>

                    <div class="">
                        <h1 class="text-base sm:text-lg text-gray-800 font-bold">Daftar Sebagai Kreator</h1>
                        <p class="text-xs sm:text-sm text-gray-600">
                            Buat profil kreator & mulai buat event!
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('kreator.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Logo Kreator (Versi Edit-Image Modern) --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">Logo Kreator</label>

                        <div class="flex items-center gap-4">

                            <div class="relative">
                                {{-- Preview Logo --}}
                                <img id="previewImage" src="https://placehold.net/shape.svg"
                                    class="h-20 w-20 sm:h-24 sm:w-24 md:h-28 md:w-28 rounded-full object-cover border-2 border-gray-200">

                                {{-- Tombol edit --}}
                                <button type="button" onclick="document.getElementById('logoInput').click()"
                                    class="absolute bottom-0 right-0 bg-white p-1.5 rounded-full border border-indigo-300 hover:bg-gray-100 shadow-md transition">
                                    <i data-lucide="camera" class="size-4 text-indigo-600"></i>
                                </button>
                            </div>

                        </div>

                        {{-- Input file hidden --}}
                        <input type="file" name="logo" id="logoInput" accept="image/*" class="hidden"
                            onchange="previewSelectedImage(event)">

                        @error('logo')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Nama Kreator --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1 text-sm sm:text-base">Nama Kreator</label>
                        <input type="text" name="nama_kreator" required
                            class="block w-full rounded-lg py-2 px-4 text-sm sm:text-base outline outline-gray-300 focus:outline-indigo-500 focus:outline-2"
                            placeholder="Masukkan nama kreator">
                        @error('nama_kreator')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">Deskripsi
                            Kreator</label>
                        <textarea name="deskripsi" rows="3"
                            class="w-full rounded-lg py-2 px-4 text-sm sm:text-base outline outline-gray-300 focus:outline-indigo-500 focus:outline-2 resize-none"
                            placeholder="Deskripsi singkat kreator..."></textarea>
                        @error('deskripsi')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>



                    {{-- Tombol Submit --}}
                    <div class="w-full mt-8">
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 sm:py-3 px-6 rounded-lg text-sm sm:text-base transition">
                            Buat Profil Kreator
                        </button>
                    </div>
                </form>

                <div class="text-center mt-6 pt-4 border-t border-gray-200">
                    <p class="text-xs sm:text-sm text-gray-600">
                        Batal?
                        <a href="{{ route('beranda') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                            Kembali ke Beranda
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </div>

    {{-- Script Preview --}}
    <script>
        function previewSelectedImage(event) {
            const file = event.target.files[0];
            if (!file) return;
            document.getElementById('previewImage').src = URL.createObjectURL(file);
        }
    </script>

</x-guest-layout>
