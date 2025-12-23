<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
            </svg>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('pembeli.tiket-saya') }}" class="font-semibold text-gray-800">Tiket Saya</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="font-semibold text-blue-600">Konfirmasi Pembayaran</span>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-24">
            <!-- Alert Info -->
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700 font-medium">
                            Silakan lakukan transfer ke salah satu rekening di bawah ini, lalu upload bukti pembayaran
                            Anda.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content - Payment Methods and Upload -->
                <div class="lg:col-span-2 space-y-6">
                    @if ($pesanan->status_pembayaran === 'pending' && $pesanan->bukti_pembayaran)
                        <!-- Payment Status Pending -->
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4">
                                <h3 class="text-lg font-bold text-white flex items-center">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Menunggu Verifikasi Pembayaran
                                </h3>
                                <p class="text-sm text-yellow-100 mt-1">Bukti pembayaran Anda sedang dalam proses
                                    verifikasi</p>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <div>
                                        <p class="text-sm text-gray-500">Status Pembayaran</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Menunggu Verifikasi
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Bank Tujuan</p>
                                        <p class="font-medium text-gray-900 capitalize">
                                            {{ $pesanan->metode_pembayaran }}</p>
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                    <p class="text-sm font-medium text-gray-700 mb-3">Bukti Pembayaran:</p>
                                    <div class="flex justify-center">
                                        <img src="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}"
                                            alt="Bukti Pembayaran"
                                            class="max-w-full max-h-96 rounded-lg shadow-md border">
                                    </div>
                                </div>

                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <div class="flex">
                                        <svg class="h-5 w-5 text-blue-400 mt-0.5" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-blue-800">Sedang Diverifikasi</h4>
                                            <p class="text-sm text-blue-700 mt-1">
                                                Bukti pembayaran Anda telah diterima dan sedang dalam proses verifikasi
                                                oleh tim kami.
                                                Proses ini biasanya memakan waktu 1-24 jam kerja. Kami akan mengirimkan
                                                notifikasi
                                                setelah pembayaran berhasil diverifikasi.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Upload Payment Proof -->
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            <div class="bg-gray-50 px-6 py-4 border-b">
                                <h3 class="text-lg font-bold text-gray-900">Upload Bukti Pembayaran</h3>
                                <p class="text-sm text-gray-600 mt-1">Upload screenshot atau foto bukti transfer Anda
                                </p>
                            </div>
                            <div class="p-6">
                                <form action="{{ route('pembeli.pembayaran.bayar') }}" method="POST"
                                    enctype="multipart/form-data" class="space-y-6">
                                    @csrf
                                    <input type="hidden" name="kode_pesanan" value="{{ $pesanan->kode_pesanan }}">
                                    <input type="hidden" name="bank_tujuan" id="bank_tujuan">

                                    <!-- Dropzone dengan aspect ratio custom (lebih pendek dari 16:9) -->
                                    <div id="buktiPreview"
                                        class="flex items-center justify-center w-full h-64 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 cursor-pointer hover:bg-gray-100 transition overflow-hidden">
                                        <span class="text-gray-500 text-sm text-center" id="dropzoneText">
                                            <svg class="w-10 h-10 mb-3 text-gray-400 mx-auto" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <strong>Seret dan letakkan gambar di sini</strong><br>
                                            atau klik untuk memilih file<br>
                                            <p class="text-xs text-gray-500 mt-2">PNG, JPG, JPEG (MAX. 5MB)</p>
                                        </span>
                                        <img id="previewImage" src=""
                                            class="hidden w-full h-full object-cover rounded-lg"
                                            alt="Preview Bukti Pembayaran">
                                    </div>

                                    <!-- Input tersembunyi -->
                                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran"
                                        accept="image/*" class="hidden" required />

                                    @error('bukti_pembayaran')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                    <!-- Remove File Button -->
                                    <div id="removeFileBtn" class="text-center hidden">
                                        <button type="button" onclick="removeFile()"
                                            class="text-red-600 hover:text-red-800 text-sm font-medium">
                                            Hapus File
                                        </button>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Konfirmasi Pembayaran
                                    </button>
                                </form>

                                @if ($errors->any())
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mt-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-red-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
                                                <div class="mt-2 text-sm text-red-700">
                                                    <ul class="list-disc pl-5 space-y-1">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <script>
                                const dropzone = document.getElementById('buktiPreview');
                                const input = document.getElementById('bukti_pembayaran');
                                const previewImg = document.getElementById('previewImage');
                                const dropzoneText = document.getElementById('dropzoneText');
                                const removeBtn = document.getElementById('removeFileBtn');

                                // Klik area dropzone untuk membuka file dialog
                                dropzone.addEventListener('click', () => input.click());

                                // Saat file dipilih
                                input.addEventListener('change', handleFiles);

                                // Saat drag file ke area
                                dropzone.addEventListener('dragover', (e) => {
                                    e.preventDefault();
                                    dropzone.classList.add('bg-gray-200');
                                    dropzone.classList.remove('border-gray-300');
                                    dropzone.classList.add('border-blue-400');
                                });

                                // Saat keluar dari area
                                dropzone.addEventListener('dragleave', () => {
                                    dropzone.classList.remove('bg-gray-200');
                                    dropzone.classList.add('border-gray-300');
                                    dropzone.classList.remove('border-blue-400');
                                });

                                // Saat file dijatuhkan
                                dropzone.addEventListener('drop', (e) => {
                                    e.preventDefault();
                                    dropzone.classList.remove('bg-gray-200');
                                    dropzone.classList.add('border-gray-300');
                                    dropzone.classList.remove('border-blue-400');

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
                                        // Validate file size (5MB)
                                        if (file.size > 5 * 1024 * 1024) {
                                            alert('File terlalu besar. Maksimal ukuran file adalah 5MB.');
                                            removeFile();
                                            return;
                                        }

                                        const reader = new FileReader();
                                        reader.onload = (e) => {
                                            previewImg.src = e.target.result;
                                            previewImg.classList.remove('hidden');
                                            dropzoneText.classList.add('hidden');
                                            removeBtn.classList.remove('hidden');
                                            dropzone.classList.add('border-green-500', 'bg-green-50');
                                            dropzone.classList.remove('border-gray-300');
                                        };
                                        reader.readAsDataURL(file);
                                    } else {
                                        alert('File harus berupa gambar.');
                                        removeFile();
                                    }
                                }

                                // Fungsi untuk hapus file
                                function removeFile() {
                                    previewImg.src = '';
                                    previewImg.classList.add('hidden');
                                    dropzoneText.classList.remove('hidden');
                                    removeBtn.classList.add('hidden');
                                    dropzone.classList.remove('border-green-500', 'bg-green-50');
                                    dropzone.classList.add('border-gray-300');
                                    input.value = '';
                                }
                            </script>
                        </div>
                    @endif


                    <!-- Bank Account Options -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                            <h2 class="text-lg font-bold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Rekening Tujuan Transfer
                            </h2>
                        </div>
                        <div class="p-6 space-y-3" x-data="{ selectedBank: '' }" x-init="// Share selectedBank with the form above
                        $watch('selectedBank', value => {
                            document.querySelector('input[name=bank_tujuan]').value = value;
                        })">
                            <!-- BCA Option -->
                            <div class="border rounded-lg p-3 cursor-pointer hover:border-blue-300 transition-colors"
                                :class="selectedBank === 'bca' ? 'border-blue-500 bg-blue-50' : 'border-gray-200'"
                                @click="selectedBank = 'bca'">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg"
                                            alt="BCA" class="h-6">
                                        <div>
                                            <p class="font-medium text-gray-900 text-sm">Bank Central Asia</p>
                                            <p class="text-xs text-gray-600">No. Rekening: <span
                                                    class="font-mono font-medium">1234567890</span></p>
                                            <p class="text-xs text-gray-600">A.n: PT TukuTiket Indonesia</p>
                                        </div>
                                    </div>
                                    <input type="radio" name="bank" value="bca" x-model="selectedBank"
                                        class="text-blue-600 h-4 w-4">
                                </div>
                            </div>

                            <!-- Mandiri Option -->
                            <div class="border rounded-lg p-3 cursor-pointer hover:border-blue-300 transition-colors"
                                :class="selectedBank === 'mandiri' ? 'border-blue-500 bg-blue-50' : 'border-gray-200'"
                                @click="selectedBank = 'mandiri'">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg"
                                            alt="Mandiri" class="h-6">
                                        <div>
                                            <p class="font-medium text-gray-900 text-sm">Bank Mandiri</p>
                                            <p class="text-xs text-gray-600">No. Rekening: <span
                                                    class="font-mono font-medium">1122334455</span></p>
                                            <p class="text-xs text-gray-600">A.n: PT TukuTiket Indonesia</p>
                                        </div>
                                    </div>
                                    <input type="radio" name="bank" value="mandiri" x-model="selectedBank"
                                        class="text-blue-600 h-4 w-4">
                                </div>
                            </div>

                            <!-- BRI Option -->
                            <div class="border rounded-lg p-3 cursor-pointer hover:border-blue-300 transition-colors"
                                :class="selectedBank === 'bri' ? 'border-blue-500 bg-blue-50' : 'border-gray-200'"
                                @click="selectedBank = 'bri'">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2e/BRI_2020.svg"
                                            alt="BRI" class="h-6">
                                        <div>
                                            <p class="font-medium text-gray-900 text-sm">Bank BRI</p>
                                            <p class="text-xs text-gray-600">No. Rekening: <span
                                                    class="font-mono font-medium">5566778899</span></p>
                                            <p class="text-xs text-gray-600">A.n: PT TukuTiket Indonesia</p>
                                        </div>
                                    </div>
                                    <input type="radio" name="bank" value="bri" x-model="selectedBank"
                                        class="text-blue-600 h-4 w-4">
                                </div>
                            </div>

                            <!-- Transfer Amount Info -->
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mt-3">
                                <div class="flex items-start">
                                    <svg class="h-4 w-4 text-yellow-400 mt-0.5" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div class="ml-2">
                                        <p class="text-sm font-medium text-yellow-800">Jumlah transfer:
                                            <span class="font-bold">Rp
                                                {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                                        </p>
                                        <p class="text-xs text-yellow-700 mt-1">Pastikan nominal transfer sesuai dengan
                                            jumlah di atas.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden sticky top-6">
                        <div class="bg-gray-50 px-6 py-4 border-b">
                            <h3 class="text-lg font-bold text-gray-900">Ringkasan Pesanan</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Order ID -->
                            <div>
                                <p class="text-xs text-gray-500">Kode Pesanan</p>
                                <p class="text-sm font-mono font-bold text-gray-900">{{ $pesanan->kode_pesanan }}</p>
                            </div>

                            <div class="border-t border-gray-200"></div>

                            <!-- Event Details -->
                            <div>
                                <p class="text-xs text-gray-500 mb-2">Detail Acara</p>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="font-semibold text-gray-900">{{ $namaAcara }}</p>
                                    <p class="text-xs text-gray-600 mt-1">{{ $lokasi }}</p>
                                    <p class="text-xs text-gray-600">{{ $waktuMulai }}</p>
                                </div>
                            </div>

                            <div class="border-t border-gray-200"></div>

                            <!-- Ticket Details -->
                            <div>
                                <p class="text-xs text-gray-500 mb-2">Detail Tiket</p>
                                <div class="space-y-2">
                                    @foreach ($daftarTiket as $tiket)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">{{ $tiket['nama_tiket'] }}</span>
                                            <span class="font-medium text-gray-900">Rp
                                                {{ number_format($tiket['harga'], 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="border-t border-gray-200"></div>

                            <!-- Price Breakdown -->
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="text-gray-900">Rp
                                        {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Biaya Layanan</span>
                                    <span class="text-gray-900">Rp 0</span>
                                </div>
                            </div>

                            <div class="border-t-2 border-gray-300"></div>

                            <!-- Total -->
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-semibold text-gray-900">Total Pembayaran</span>
                                <span class="text-xl font-bold text-blue-600">Rp
                                    {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                            </div>

                            <!-- Help Button -->
                            <button
                                class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Butuh Bantuan?
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function fileUpload() {
                return {
                    filePreview: null,

                    previewFile(event) {
                        const file = event.target.files[0];
                        if (file) {
                            // Validate file size (5MB)
                            if (file.size > 5 * 1024 * 1024) {
                                alert('File terlalu besar. Maksimal ukuran file adalah 5MB.');
                                this.removeFile();
                                return;
                            }

                            // Validate file type
                            if (!file.type.startsWith('image/')) {
                                alert('File harus berupa gambar.');
                                this.removeFile();
                                return;
                            }

                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.filePreview = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    },

                    removeFile() {
                        this.filePreview = null;
                        document.getElementById('bukti_pembayaran').value = '';
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
