<div>
    <div class="mb-4">
        <label for="banner_acara" class="block text-sm font-medium text-gray-700 mb-2">Banner
            Acara</label>
        <!-- Dropzone -->
        <div id="bannerPreview"
            class="flex items-center justify-center w-full h-64 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 cursor-pointer hover:bg-gray-100 transition">
            <span class="text-gray-500 text-sm text-center">
                <strong>Seret dan letakkan gambar di sini</strong><br>
                atau klik untuk memilih file
            </span>
            <img id="previewImage" class="hidden w-full h-full object-cover rounded-lg" alt="Preview Banner">
        </div>

        <!-- Input tersembunyi -->
        <input type="file" name="banner_acara" id="banner_acara" accept="image/*" class="hidden" />
    </div>

    <script>
        const dropzone = document.getElementById('bannerPreview');
        const input = document.getElementById('banner_acara');
        const previewImg = document.getElementById('previewImage');

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
                    dropzone.querySelector('span').classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        }
    </script>

</div>
