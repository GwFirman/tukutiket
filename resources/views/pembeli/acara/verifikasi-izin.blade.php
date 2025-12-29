<x-app-layout>
    {{-- LOGIC PHP: Tentukan apakah form upload harus dikunci --}}
    @php
        // Form dikunci HANYA jika ada dokumen yang statusnya 'pending' atau 'approved'.
        // Jika status 'rejected' atau belum ada file, form terbuka.
        $isLocked = $verifikasi && $verifikasi->whereIn('status_verifikasi', ['pending', 'approved'])->count() > 0;

        // Cek apakah ada status rejected (untuk menampilkan pesan khusus)
        $hasRejected = $verifikasi && $verifikasi->where('status_verifikasi', 'rejected')->count() > 0;
    @endphp
    <x-slot:header>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i data-lucide="file-check" class="size-5 text-gray-600"></i>
                <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
                <p class="font-medium">Verifikasi Acara</p>
                <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
                <p class="font-medium text-gray-600">{{ $acara->nama_acara }}</p>
            </div>
        </div>
    </x-slot:header>
    <div class="min-h-screen bg-gray-50 py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <div class="flex items-center gap-4 mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Upload Surat Izin Acara</h1>
                        <p class="text-gray-600 mt-1">{{ $acara->nama_acara }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    @if ($verifikasi && $verifikasi->count() > 0)
                        <div class="bg-white rounded-lg border border-gray-200 p-6 sm:p-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <i data-lucide="file-text" class="size-6 text-indigo-600"></i>
                                Riwayat Dokumen
                            </h2>

                            <div class="space-y-4">
                                @foreach ($verifikasi as $doc)
                                    <div class="border border-gray-200 rounded-lg p-4 overflow-auto">
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex items-start gap-3 flex-1">
                                                <div
                                                    class="h-10 w-10 rounded-lg bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                                    @if (str_ends_with($doc->file_path, '.pdf'))
                                                        <i data-lucide="file-pdf" class="size-5 text-red-600"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="lucide lucide-file-text-icon lucide-file-text">
                                                                <path
                                                                    d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                                                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                                                <path d="M10 9H8" />
                                                                <path d="M16 13H8" />
                                                                <path d="M16 17H8" />
                                                            </svg></i>
                                                    @else
                                                        <i data-lucide="image" class="size-5 text-indigo-600">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="lucide lucide-file-image-icon lucide-file-image">
                                                                <path
                                                                    d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                                                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                                                <circle cx="10" cy="12" r="2" />
                                                                <path
                                                                    d="m20 17-1.296-1.296a2.41 2.41 0 0 0-3.408 0L9 22" />
                                                            </svg>
                                                        </i>
                                                    @endif
                                                </div>

                                                <div class="flex-1 min-w-0">
                                                    <p class="font-semibold text-gray-900 truncate">
                                                        {{ $doc->nama_dokumen }}</p>
                                                    <div class="flex items-center gap-2 mt-1 text-xs text-gray-500">
                                                        <span>{{ ucfirst(str_replace('_', ' ', $doc->jenis_dokumen)) }}</span>
                                                        <span>•</span>
                                                        <span>{{ \Carbon\Carbon::parse($doc->created_at)->locale('id')->translatedFormat('d M Y H:i') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2 ml-3">
                                                @if ($doc->status_verifikasi === 'pending')
                                                    <span
                                                        class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                                        <i data-lucide="clock" class="size-3"></i> Pending
                                                    </span>
                                                @elseif ($doc->status_verifikasi === 'approved')
                                                    <span
                                                        class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                        <i data-lucide="check-circle" class="size-3"></i> Approved
                                                    </span>
                                                @elseif ($doc->status_verifikasi === 'rejected')
                                                    <span
                                                        class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                                        <i data-lucide="x-circle" class="size-3"></i> Rejected
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        @if ($doc->catatan_admin)
                                            <div
                                                class="bg-gray-50 border border-gray-200 rounded p-3 text-sm text-gray-700 mb-3">
                                                <p class="font-medium text-gray-900 mb-1">Catatan Admin:</p>
                                                <p class="text-red-600">{{ $doc->catatan_admin }}</p>
                                            </div>
                                        @endif

                                        <div class="flex items-center gap-2">
                                            <button type="button"
                                                onclick="previewDocument('{{ Storage::url($doc->file_path) }}', '{{ $doc->nama_dokumen }}')"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition-colors">
                                                <i data-lucide="eye" class="size-3"></i> Preview
                                            </button>

                                            {{-- Tombol hapus hanya jika pending atau rejected --}}
                                            @if ($doc->status_verifikasi === 'pending' || $doc->status_verifikasi === 'rejected')
                                                <form action="{{ route('pembuat.verifikasi.destroy', $doc->id) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Hapus dokumen ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium bg-red-100 text-red-600 rounded hover:bg-red-200 transition-colors">
                                                        <i data-lucide="trash-2" class="size-3"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex gap-4">
                            <i data-lucide="info" class="size-6 text-blue-600 flex-shrink-0 mt-0.5"></i>
                            <div>
                                <h3 class="font-semibold text-blue-900 mb-2">Informasi Penting</h3>
                                <ul class="text-sm text-blue-800 space-y-1">
                                    <li>• Surat izin acara diperlukan untuk verifikasi keabsahan acara</li>
                                    <li>• Pilih beberapa dokumen sekaligus (maksimal 5 file)</li>
                                    <li>• File harus dalam format PDF atau gambar (JPG, PNG)</li>
                                    <li>• Ukuran maksimal file: 10 MB</li>
                                    <li>• Tim admin akan melakukan review dalam 1-3 hari kerja</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 sm:p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i data-lucide="upload-cloud" class="size-6 text-indigo-600"></i>
                            Upload Dokumen Verifikasi
                        </h2>

                        {{-- TAMPILKAN ALERT BERDASARKAN STATUS --}}
                        @if ($isLocked)
                            {{-- State: Locked (Pending/Approved) --}}
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                                <div class="flex items-center gap-3">
                                    <i data-lucide="check-circle" class="size-5 text-green-600"></i>
                                    <div>
                                        <p class="text-sm font-medium text-green-900">Dokumen sedang diproses /
                                            disetujui</p>
                                        <p class="text-xs text-green-700">Anda tidak dapat mengunggah dokumen baru saat
                                            ini.</p>
                                    </div>
                                </div>
                            </div>
                        @elseif($hasRejected && !$isLocked)
                            {{-- State: Unlocked but Rejected (Warning) --}}
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                                <div class="flex items-center gap-3">
                                    <i data-lucide="alert-circle" class="size-5 text-red-600"></i>
                                    <div>
                                        <p class="text-sm font-medium text-red-900">Dokumen Ditolak</p>
                                        <p class="text-xs text-red-700">Silakan unggah dokumen perbaikan yang sesuai.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- FORM UPLOAD --}}
                        <form id="uploadForm" method="POST"
                            action="{{ route('pembuat.verifikasi.store', $acara->slug) }}"
                            enctype="multipart/form-data"
                            class="space-y-6 @if ($isLocked) opacity-50 pointer-events-none @endif">
                            @csrf

                            {{-- <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-start gap-3">
                                    <i data-lucide="info" class="size-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
                                    <div>
                                        <p class="text-sm font-medium text-blue-900 mb-1">Upload Bulk Dokumen</p>
                                        <ul class="text-xs text-blue-800 space-y-0.5">
                                            <li>• Pilih beberapa dokumen sekaligus (maksimal 5 file)</li>
                                            <li>• Setiap file maksimal 10 MB</li>
                                            <li>• Format: PDF, JPG, JPEG, PNG</li>
                                        </ul>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="space-y-4">
                                <label class="block text-sm font-medium text-gray-700">
                                    Pilih Dokumen <span class="text-red-500">*</span>
                                    <span class="text-xs text-gray-500">(Maksimal 5 file)</span>
                                </label>

                                <div id="dropZone"
                                    class="relative border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-indigo-400 hover:bg-indigo-50 transition-colors cursor-pointer bg-gray-50">
                                    <input type="file" id="fileInput" name="files[]" multiple
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        @if ($isLocked) disabled @endif>

                                    <div class="flex flex-col items-center justify-center">
                                        <i data-lucide="files" class="size-12 text-gray-400 mb-3"></i>
                                        <p class="text-base font-semibold text-gray-700 mb-1">Drag dan drop beberapa
                                            file
                                            di sini</p>
                                        <p class="text-sm text-gray-500">atau klik untuk memilih file</p>
                                        <p class="text-xs text-gray-400 mt-2">PDF, JPG, PNG (Max 10MB per file)</p>
                                    </div>
                                </div>

                                <div id="filesPreview" class="space-y-2"></div>

                                @error('files')
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-sm text-red-700">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @error('files.*')
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-sm text-red-700">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            @if ($isLocked)
                                <button type="button" disabled
                                    class="w-full px-6 py-3 bg-gray-400 text-white font-semibold rounded-lg cursor-not-allowed flex items-center justify-center gap-2">
                                    <i data-lucide="lock" class="size-4"></i>
                                    Menunggu Verifikasi
                                </button>
                            @else
                                <button type="submit" id="submitBtn"
                                    class="w-full px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i data-lucide="upload" class="size-4"></i>
                                    <span id="submitText">Upload Dokumen</span>
                                </button>
                            @endif
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 sticky top-24 space-y-6">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-3">Penyelenggara</p>
                            <div class="flex items-center gap-3">
                                @if ($acara->kreator && $acara->kreator->logo)
                                    <img src="{{ Storage::url($acara->kreator->logo) }}"
                                        alt="{{ $acara->kreator->nama_kreator }}"
                                        class="h-10 w-10 rounded-full object-cover border-2 border-indigo-100">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <i data-lucide="user" class="size-5 text-indigo-600"></i>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-medium text-gray-900 truncate">
                                        {{ $acara->kreator->nama_kreator ?? '-' }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $acara->kreator->user->email ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="border-t border-gray-200"></div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-3">Tanggal Acara</p>
                            <div class="space-y-2">
                                <div class="flex items-start gap-2 text-sm">
                                    <i data-lucide="calendar" class="size-4 text-indigo-600 flex-shrink-0 mt-0.5"></i>
                                    <span class="text-gray-700 leading-tight">
                                        {{ \Carbon\Carbon::parse($acara->waktu_mulai)->locale('id')->translatedFormat('d F Y') }}

                                        {{-- Cek apakah acara lebih dari 1 hari --}}
                                        @if ($acara->waktu_mulai != $acara->waktu_selesai)
                                            <span class="mx-1 text-gray-400">-</span>
                                            {{ \Carbon\Carbon::parse($acara->waktu_selesai)->locale('id')->translatedFormat('d F Y') }}
                                        @endif
                                    </span>
                                </div>

                                <div class="flex items-center gap-2 text-sm">
                                    <i data-lucide="clock" class="size-4 text-indigo-600 flex-shrink-0"></i>
                                    <span class="text-gray-700">
                                        {{ \Carbon\Carbon::parse($acara->jam_mulai)->format('H:i') }}
                                        <span class="mx-1 text-gray-400">-</span>
                                        {{ \Carbon\Carbon::parse($acara->jam_selesai)->format('H:i') }} WIB
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="border-t border-gray-200"></div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-3">Status Acara</p>
                            <span
                                class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                <i data-lucide="clock" class="size-3"></i> Menunggu Verifikasi
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="previewModal" class="fixed inset-0 bg-black/30 hidden z-50 w-full">
        <div class="w-4xl mx-auto">
            <div class="flex items-center justify-center min-h-screen p-4 mx-auto w-full">
                <div class="bg-white rounded-lg w-full max-h-[90vh] overflow-hidden">
                    <div class="flex items-center justify-between p-4 border-b">
                        <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">Preview Dokumen</h3>
                        <button onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-600">
                            <i data-lucide="x" class="size-6"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <div id="previewContent" class="w-full h-[70vh]"></div>
                    </div>
                    <div class="flex items-center justify-end gap-3 p-4 border-t bg-gray-50">
                        <a id="downloadBtn" href="#" target="_blank"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                            <i data-lucide="download" class="size-4"></i> Download
                        </a>
                        <button onclick="closePreviewModal()"
                            class="px-4 py-2 text-sm font-medium bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT TETAP SAMA --}}
    <script>
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const filesPreview = document.getElementById('filesPreview');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');

        // Drag and drop events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            if (dropZone) dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        if (dropZone) {
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => {
                    dropZone.classList.add('border-indigo-400', 'bg-indigo-50');
                });
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => {
                    dropZone.classList.remove('border-indigo-400', 'bg-indigo-50');
                });
            });

            dropZone.addEventListener('drop', (e) => {
                if (fileInput.disabled) return; // Prevent drop if disabled
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                handleFileSelect({
                    target: {
                        files: files
                    }
                });
            });
        }

        if (fileInput) fileInput.addEventListener('change', handleFileSelect);

        function handleFileSelect(e) {
            const files = e.target.files;
            filesPreview.innerHTML = '';

            if (files.length > 5) {
                alert('Maksimal 5 file yang dapat dipilih');
                fileInput.value = '';
                return;
            }

            Array.from(files).forEach((file, index) => {
                if (file.size > 10 * 1024 * 1024) {
                    alert(`File "${file.name}" terlalu besar. Maksimal 10MB per file.`);
                    fileInput.value = '';
                    filesPreview.innerHTML = '';
                    return;
                }
                const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    alert(`File "${file.name}" tidak didukung. Format yang didukung: PDF, JPG, PNG.`);
                    fileInput.value = '';
                    filesPreview.innerHTML = '';
                    return;
                }

                const div = document.createElement('div');
                div.className = 'bg-green-50 border border-green-200 rounded-lg p-4 flex items-center gap-3';
                div.innerHTML = `
                    <i data-lucide="check-circle" class="size-6 text-green-600 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-check-icon lucide-file-check"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="m9 15 2 2 4-4"/></svg></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-green-900 truncate">${file.name}</p>
                        <p class="text-xs text-green-700">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                    </div>
                    <button type="button" onclick="removeFile(this, ${index})" class="text-green-600 hover:text-green-700">
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                `;
                filesPreview.appendChild(div);
            });

            if (files.length > 0 && submitBtn) {
                submitBtn.disabled = false;
                submitText.textContent = `Upload ${files.length} Dokumen`;
            } else if (submitBtn) {
                submitBtn.disabled = true;
                submitText.textContent = 'Upload Dokumen';
            }
        }

        function removeFile(button, index) {
            const filesPreview = document.getElementById('filesPreview');
            filesPreview.removeChild(button.closest('div'));

            const dt = new DataTransfer();
            const files = Array.from(fileInput.files);
            files.splice(index, 1);
            files.forEach(file => dt.items.add(file));
            fileInput.files = dt.files;

            if (fileInput.files.length > 0 && submitBtn) {
                submitBtn.disabled = false;
                submitText.textContent = `Upload ${fileInput.files.length} Dokumen`;
            } else if (submitBtn) {
                submitBtn.disabled = true;
                submitText.textContent = 'Upload Dokumen';
            }
        }

        const form = document.getElementById('uploadForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (fileInput.files.length === 0) {
                    e.preventDefault();
                    alert('Pilih minimal satu file untuk diunggah');
                    return;
                }
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitText.textContent = 'Mengunggah...';
                }
            });
        }

        function previewDocument(fileUrl, fileName) {
            const modal = document.getElementById('previewModal');
            const modalTitle = document.getElementById('modalTitle');
            const previewContent = document.getElementById('previewContent');
            const downloadBtn = document.getElementById('downloadBtn');

            modalTitle.textContent = `Preview: ${fileName}`;
            downloadBtn.href = fileUrl;
            previewContent.innerHTML =
                '<div class="flex items-center justify-center h-full"><div class="text-gray-500">Loading...</div></div>';

            if (fileUrl.toLowerCase().endsWith('.pdf')) {
                previewContent.innerHTML = `
                    <iframe src="${fileUrl}" class="w-full h-full border-0" allowfullscreen>
                        <p>Browser Anda tidak mendukung preview PDF. <a href="${fileUrl}" target="_blank" class="text-blue-600 underline">Download file</a></p>
                    </iframe>`;
            } else {
                previewContent.innerHTML = `
                    <div class="flex items-center justify-center h-full">
                        <img src="${fileUrl}" alt="${fileName}" class="max-w-full max-h-full object-contain" onerror="this.parentElement.innerHTML='<div class=\'text-red-500 text-center\'>Gagal memuat gambar</div>'">
                    </div>`;
            }
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closePreviewModal() {
            const modal = document.getElementById('previewModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        document.getElementById('previewModal').addEventListener('click', function(e) {
            if (e.target === this) closePreviewModal();
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closePreviewModal();
        });
    </script>
</x-app-layout>
