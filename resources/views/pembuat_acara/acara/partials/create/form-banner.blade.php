<div>
    <div class="mb-4">
        <!-- Dropzone dengan aspect ratio custom (lebih pendek dari 16:9) -->
        <div id="bannerPreview"
            class="relative flex items-center justify-center w-full h-64 border-b border-gray-300 rounded-t-lg bg-gray-50 cursor-pointer hover:bg-gray-100 transition overflow-hidden group">
            <span class="text-gray-500 text-sm text-center" id="dropzoneText">
                <strong>Seret dan letakkan gambar di sini</strong><br>
                atau klik untuk memilih file<br>
                <!-- Info ukuran -->
                <p class="text-xs text-gray-500 mb-2">Ukuran yang disarankan: 1920x720 px untuk hasil terbaik</p>
            </span>
            <img id="previewImage"
                src="{{ isset($acara) && $acara->banner_acara ? asset('storage/' . $acara->banner_acara) : '' }}"
                class="{{ isset($acara) && $acara->banner_acara ? '' : 'hidden' }} w-full h-full object-cover rounded-t-lg"
                alt="Preview Banner {{ isset($acara) ? ' - ' . ($acara->nama_acara ?? '') : '' }}">

            <!-- Action Buttons (kanan bawah) -->
            <div id="actionButtons" class="absolute bottom-3 right-3 flex gap-2">
                <button type="button" id="editBtn"
                    class="bg-blue-500/80 hover:bg-blue-600 text-white p-2 rounded-lg transition-colors shadow-lg backdrop-blur-sm"
                    title="Edit gambar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                    </svg>
                </button>
                <button type="button" id="deleteBtn"
                    class="bg-red-500/80 hover:bg-red-600 text-white p-2 rounded-lg transition-colors shadow-lg backdrop-blur-sm"
                    title="Hapus gambar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </button>
            </div>
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
        const actionButtons = document.getElementById('actionButtons');
        const editBtn = document.getElementById('editBtn');
        const deleteBtn = document.getElementById('deleteBtn');

        // Cek jika sudah ada gambar preview saat halaman load
        if (previewImg.getAttribute('src')) {
            previewImg.classList.remove('hidden');
            dropzoneText.classList.add('hidden');
        } else {
            actionButtons.classList.add('hidden');
        }

        // Klik area dropzone untuk membuka file dialog
        dropzone.addEventListener('click', (e) => {
            // Jangan trigger file dialog jika klik tombol edit/delete
            if (e.target.closest('#editBtn') || e.target.closest('#deleteBtn')) return;
            input.click();
        });

        // Edit button - buka file dialog
        editBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            input.click();
        });

        // Delete button - hapus gambar
        deleteBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            previewImg.src = '';
            previewImg.classList.add('hidden');
            dropzoneText.classList.remove('hidden');
            actionButtons.classList.add('hidden');
            input.value = ''; // Clear file input
        });

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
                    actionButtons.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }
    </script>

</div>
