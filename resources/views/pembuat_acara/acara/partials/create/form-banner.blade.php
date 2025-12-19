<div>
    <div class="mb-4">
        <label for="banner_acara" class="block text-sm font-medium text-gray-700 mb-2">Banner
            Acara</label>
        <!-- Dropzone -->
        <div id="bannerPreview"
            class="flex items-center justify-center w-full h-64 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 cursor-pointer hover:bg-gray-100 transition">
            <span class="text-gray-500 text-sm text-center" id="dropzoneText">
                <strong>Seret dan letakkan gambar di sini</strong><br>
                atau klik untuk memilih file
            </span>
            <img id="previewImage"
                src="{{ old('banner_acara') ?? (isset($acara) && $acara->banner_acara ? asset('storage/' . $acara->banner_acara) : '') }}"
                class="{{ old('banner_acara') || (isset($acara) && $acara->banner_acara) ? '' : 'hidden' }} w-full h-full object-cover rounded-lg"
                alt="Preview Banner">
        </div>

        <!-- Input tersembunyi -->
        <input type="file" name="banner_acara" id="banner_acara" accept="image/*" class="hidden" />

        @error('banner_acara')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <script>
        const dropzone = document.getElementById('bannerPreview');
        const input = document.getElementById('banner_acara');
        const previewImg = document.getElementById('previewImage');
        const dropzoneText = document.getElementById('dropzoneText');

        // Cek jika sudah ada gambar preview saat halaman load
        if (previewImg.src && !previewImg.classList.contains('hidden')) {
            dropzoneText.classList.add('hidden');
        }

        // Klik area dropzone untuk membuka file dialog
        dropzone.addEventListener('click', () => input.click());

        // Saat file dipilih
        input.addEventListener('change', handleFiles);

        // Saat drag file ke area
        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('bg-gray-200');
        });

        // Saat keluar dari area
        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('bg-gray-200');
        });

        // Saat file dijatuhkan
        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('bg-gray-200');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                input.files = files; // sinkron ke input
                handleFiles();
            }
        });

        // Fungsi untuk preview gambar
        function handleFiles() {
            const file = input.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                    dropzoneText.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        }
    </script>

</div>
