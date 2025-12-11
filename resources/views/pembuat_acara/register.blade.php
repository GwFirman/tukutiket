<x-guest-layout :showNavbar="false">
    <div class="flex h-screen w-screen sm:justify-center items-center p-20">
        <div class="flex h-full bg-white shadow-md overflow-hidden sm:rounded-lg">

            {{-- Bagian gambar kiri --}}
            <div class="w-full h-full sm:rounded-lg">
                <div class="text-center h-full">
                    <img src="{{ asset('images/login.png') }}" alt="Kreator Illustration"
                        class="w-full h-full object-cover">
                </div>
            </div>

            {{-- Form Registrasi Kreator --}}
            <div class="px-28 py-8 w-256">
                <div class="flex gap-4 mb-6">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-2 rounded-lg">
                        <i data-lucide="badge-check" class="w-8 h-8 text-white"></i>
                    </div>

                    <div class="">
                        <h1 class="text-lg text-gray-800 font-bold">Daftar Sebagai Kreator</h1>
                        <p class="text-sm text-gray-600">
                            Buat profil kreator & mulai buat event!
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('kreator.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Logo Kreator (Versi Edit-Image Modern) --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Logo Kreator</label>

                        <div class="flex items-center gap-4">

                            <div class="relative">
                                {{-- Preview Logo --}}
                                <img id="previewImage" src="https://placehold.net/shape.svg"
                                    class="h-28 w-28 rounded-full object-cover shadow ">

                                {{-- Tombol edit --}}
                                <button type="button" onclick="document.getElementById('logoInput').click()"
                                    class="absolute bottom-1 right-1 bg-white p-1 rounded-full shadow hover:bg-gray-100 border">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5h-5a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.586-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
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
                        <label class="block text-gray-700 font-semibold mb-1">Nama Kreator</label>
                        <input type="text" name="nama_kreator" required
                            class="block w-full rounded-lg py-2 px-4 outline outline-gray-300 focus:outline-indigo-500"
                            placeholder="Masukkan nama kreator">
                        @error('nama_kreator')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Deskripsi Kreator</label>
                        <textarea name="deskripsi" rows="3"
                            class="w-full rounded-lg py-2 px-4  outline outline-gray-300 focus:outline-indigo-500"
                            placeholder="Deskripsi singkat kreator..."></textarea>
                        @error('deskripsi')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>



                    {{-- Tombol Submit --}}
                    <div class="w-full mt-8">
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg">
                            Buat Profil Kreator
                        </button>
                    </div>
                </form>

                <div class="text-center mt-6 pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
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
