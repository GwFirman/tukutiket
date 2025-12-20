<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i data-lucide="user" class="size-5 text-gray-600"></i>
            <i data-lucide="chevron-right" class="size-4 text-gray-400"></i>
            <span class="font-semibold">Profil Kreator</span>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-start gap-3">
                <i data-lucide="check-circle" class="size-5 text-green-600 flex-shrink-0 mt-0.5"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Profil Kreator</h1>
            <p class="text-sm text-gray-600 mt-1">Kelola informasi profil kreator Anda</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <form action="{{ route('pembuat.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Logo Section -->
                <div class="p-6 sm:p-8 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <i data-lucide="image" class="size-5 text-indigo-600"></i>
                        Logo Kreator
                    </h3>

                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                        <!-- Preview Foto -->
                        <div class="relative group">
                            <img id="previewImage"
                                src="{{ $kreator->logo ? Storage::url($kreator->logo) : 'https://ui-avatars.com/api/?name=' . urlencode($kreator->nama_kreator) . '&background=6366f1&color=fff&size=128' }}"
                                class="h-28 w-28 sm:h-32 sm:w-32 rounded-xl object-cover border-2 border-gray-200" />

                            <!-- Overlay on hover -->
                            <div class="absolute inset-0 bg-black/50 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer"
                                onclick="document.getElementById('logoInput').click()">
                                <div class="text-white text-center">
                                    <i data-lucide="camera" class="size-6 mx-auto mb-1"></i>
                                    <span class="text-xs font-medium">Ubah Logo</span>
                                </div>
                            </div>
                        </div>

                        <!-- Info & Button -->
                        <div class="flex-1">
                            <p class="text-sm text-gray-600 mb-3">
                                Upload logo kreator Anda. Rekomendasi ukuran 400x400px (Max 2MB)
                            </p>
                            <button type="button" onclick="document.getElementById('logoInput').click()"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-colors text-sm font-medium">
                                <i data-lucide="upload" class="size-4"></i>
                                Pilih File
                            </button>
                        </div>
                    </div>

                    <!-- Input File Hidden -->
                    <input type="file" name="logo" id="logoInput" accept="image/*" class="hidden"
                        onchange="previewSelectedImage(event)">
                </div>

                <!-- Info Section -->
                <div class="p-6 sm:p-8 space-y-6">
                    <h3 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="info" class="size-5 text-indigo-600"></i>
                        Informasi Kreator
                    </h3>

                    <!-- Nama Kreator -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Kreator <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="user" class="size-5 text-gray-400"></i>
                            </div>
                            <input type="text" name="nama_kreator"
                                value="{{ old('nama_kreator', $kreator->nama_kreator) }}"
                                placeholder="Masukkan nama kreator"
                                class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm"
                                required>
                        </div>
                        @error('nama_kreator')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" rows="4" placeholder="Ceritakan tentang kreator Anda..."
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none text-sm">{{ old('deskripsi', $kreator->deskripsi) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            Deskripsi akan ditampilkan di halaman profil publik Anda
                        </p>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Slug URL</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="link" class="size-5 text-gray-400"></i>
                            </div>
                            <input type="text" name="slug" value="{{ old('slug', $kreator->slug) }}"
                                placeholder="slug-kreator-anda"
                                class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            URL: <span class="text-gray-700">{{ url('/kreator') }}/</span><span
                                class="text-indigo-600 font-medium">{{ $kreator->slug }}</span>
                        </p>
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Footer Actions -->
                <div
                    class="px-6 py-4 sm:px-8 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <p class="text-xs sm:text-sm text-gray-600 flex items-center gap-2">
                        <i data-lucide="info" class="size-4 flex-shrink-0"></i>
                        Perubahan akan langsung terlihat di profil publik Anda
                    </p>
                    <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium text-sm">
                        <i data-lucide="save" class="size-4"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

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

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</x-app-layout>
