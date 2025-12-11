<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i data-lucide="user" class="size-5 text-gray-600"></i>
            <span class="font-semibold">Profil Kreator</span>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 py-8">

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                    <i data-lucide="check-circle" class="size-5 text-green-600"></i>
                </div>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif


        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <form action="{{ route('pembuat.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf


                <!-- Script Preview -->
                <script>
                    function previewSelectedImage(event) {
                        const file = event.target.files[0];
                        if (!file) return;

                        // Update preview
                        const preview = document.getElementById('previewImage');
                        preview.src = URL.createObjectURL(file);
                    }
                </script>

                <!-- Info Section -->
                <div class="p-6 space-y-6">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i data-lucide="info" class="size-5 text-indigo-600"></i>
                        Informasi Kreator
                    </h3>
                    <div class="">
                        <!-- Logo Section -->
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-center gap-6">
                                <!-- Preview Foto -->
                                <div class="relative group">
                                    <img id="previewImage"
                                        src="{{ $kreator->logo ? Storage::url($kreator->logo) : 'https://ui-avatars.com/api/?name=' . urlencode($kreator->nama_kreator) . '&background=6366f1&color=fff&size=128' }}"
                                        class="h-32 w-32 rounded-2xl object-cover border-4 border-indigo-100 shadow-lg transition-transform group-hover:scale-105" />

                                    <!-- Overlay on hover -->
                                    <div class="absolute inset-0 bg-black/40 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer"
                                        onclick="document.getElementById('logoInput').click()">
                                        <div class="text-white text-center">
                                            <i data-lucide="camera" class="size-6 mx-auto mb-1"></i>
                                            <span class="text-xs">Ubah</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Input File Hidden -->
                            <input type="file" name="logo" id="logoInput" accept="image/*" class="hidden"
                                onchange="previewSelectedImage(event)">
                        </div>
                    </div>
                    <!-- Nama Kreator -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kreator</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="user" class="size-5 text-gray-400"></i>
                            </div>
                            <input type="text" name="nama_kreator"
                                value="{{ old('nama_kreator', $kreator->nama_kreator) }}"
                                placeholder="Masukkan nama kreator"
                                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <div class="relative">
                            <textarea name="deskripsi" rows="4" placeholder="Ceritakan tentang kreator Anda..."
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none">{{ old('deskripsi', $kreator->deskripsi) }}</textarea>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Deskripsi akan ditampilkan di halaman profil publik Anda
                        </p>
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Slug URL</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="link" class="size-5 text-gray-400"></i>
                            </div>
                            <input type="text" name="slug" value="{{ old('slug', $kreator->slug) }}"
                                placeholder="slug-kreator-anda"
                                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        </div>
                        <p class="text-xs text-gray-400 mt-1">URL: {{ url('/kreator') }}/<span
                                class="text-indigo-600 font-medium">{{ $kreator->slug }}</span></p>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                    <p class="text-sm text-gray-500 flex items-center gap-2">
                        <i data-lucide="info" class="size-4"></i>
                        Perubahan akan langsung terlihat di profil publik Anda
                    </p>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-500/25 font-medium">
                        <i data-lucide="save" class="size-4"></i>
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
