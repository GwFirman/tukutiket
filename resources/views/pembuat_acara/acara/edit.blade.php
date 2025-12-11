<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('pembuat.acara.update', $acara->id) }}" enctype="multipart/form-data"
                    class="p-6 space-y-6">
                    @csrf
                    @method('PUT')
                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-9v4a1 1 0 11-2 0v-4a1 1 0 112 0zm-1-5a1 1 0 00-1 1v.01a1 1 0 102 0V5a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">
                                        Terdapat beberapa masalah dengan inputan Anda:
                                    </p>
                                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div>
                        <div class="mb-4">
                            <label for="banner_acara" class="block text-sm font-medium text-gray-700 mb-2">Banner
                                Acara</label>
                            <!-- Dropzone -->
                            <div id="bannerPreview"
                                class="flex items-center justify-center w-full h-64 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 cursor-pointer hover:bg-gray-100 transition">
                                @if ($acara->banner_acara)
                                    <img id="previewImage" src="{{ asset('storage/' . $acara->banner_acara) }}"
                                        class="w-full h-full object-cover rounded-lg" alt="Preview Banner">
                                @else
                                    <span class="text-gray-500 text-sm text-center">
                                        <strong>Seret dan letakkan gambar di sini</strong><br>
                                        atau klik untuk memilih file
                                    </span>
                                    <img id="previewImage" class="hidden w-full h-full object-cover rounded-lg"
                                        alt="Preview Banner">
                                @endif
                            </div>

                            <!-- Input tersembunyi -->
                            <input type="file" name="banner_acara" id="banner_acara" accept="image/*"
                                class="hidden" />
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

                    <div>
                        <label for="nama_acara" class="block text-sm font-medium text-gray-700">Nama Acara</label>
                        <input type="text" name="nama_acara" id="nama_acara"
                            value="{{ old('nama_acara', $acara->nama_acara) }}" required
                            class="mt-1 h-10 block w-full rounded-md border border-gray-100 shadow-sm focus:border-sky-500">
                    </div>
                    <div class="flex gap-5 mt-5">
                        <div class="w-full" x-data="{
                            showModal: false,
                            startDate: '{{ old('waktu_mulai', $acara->waktu_mulai ? \Carbon\Carbon::parse($acara->waktu_mulai)->format('Y-m-d') : '') }}',
                            endDate: '{{ old('waktu_selesai', $acara->waktu_selesai ? \Carbon\Carbon::parse($acara->waktu_selesai)->format('Y-m-d') : '') }}',
                            get label() {
                                if (this.startDate && this.endDate) {
                                    return `${this.formatDate(this.startDate)} - ${this.formatDate(this.endDate)}`;
                                }
                                return 'Pilih tanggal acara';
                            },
                            formatDate(dateStr) {
                                const options = { day: '2-digit', month: 'long', year: 'numeric' };
                                const date = new Date(dateStr);
                                return date.toLocaleDateString('id-ID', options);
                            }
                        }">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 ">
                                Tanggal Acara
                            </label>
                            <div class="flex items-center h-11 pl-4 rounded-lg cursor-pointer border border-gray-300"
                                @click="showModal = true">
                                <label class="block text-md text-gray-700  mr-2" x-text="label"></label>
                                <span class="-1/2 text-blue-500 ">
                                    <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M6.66659 1.5415C7.0808 1.5415 7.41658 1.87729 7.41658 2.2915V2.99984H12.5833V2.2915C12.5833 1.87729 12.919 1.5415 13.3333 1.5415C13.7475 1.5415 14.0833 1.87729 14.0833 2.2915V2.99984L15.4166 2.99984C16.5212 2.99984 17.4166 3.89527 17.4166 4.99984V7.49984V15.8332C17.4166 16.9377 16.5212 17.8332 15.4166 17.8332H4.58325C3.47868 17.8332 2.58325 16.9377 2.58325 15.8332V7.49984V4.99984C2.58325 3.89527 3.47868 2.99984 4.58325 2.99984L5.91659 2.99984V2.2915C5.91659 1.87729 6.25237 1.5415 6.66659 1.5415ZM6.66659 4.49984H4.58325C4.30711 4.49984 4.08325 4.7237 4.08325 4.99984V6.74984H15.9166V4.99984C15.9166 4.7237 15.6927 4.49984 15.4166 4.49984H13.3333H6.66659ZM15.9166 8.24984H4.08325V15.8332C4.08325 16.1093 4.30711 16.3332 4.58325 16.3332H15.4166C15.6927 16.3332 15.9166 16.1093 15.9166 15.8332V8.24984Z"
                                            fill="" />
                                    </svg>
                                </span>
                            </div>
                            <!-- Modal -->
                            <div x-show="showModal" x-cloak>
                                <!-- Overlay -->
                                <div class="fixed inset-0 z-40 bg-black/80"></div>
                                <!-- Modal -->
                                <div class="fixed inset-0 z-50 flex items-center justify-center">
                                    <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
                                        <h3 class="text-lg font-semibold mb-4 text-gray-800 ">Pilih
                                            Tanggal
                                            Acara
                                        </h3>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700  mb-1">Tanggal
                                                Mulai</label>
                                            <div class="relative">
                                                <input type="date" x-model="startDate" placeholder="Select date"
                                                    name="waktu_mulai"
                                                    class="
                                                     shadow-theme-xs focus:border-blue-300 focus:ring-blue-500/10 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5  pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden " />
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700  mb-1">Tanggal
                                                Akhir</label>
                                            <div class="relative">
                                                <input type="date" x-model="endDate" placeholder="Select date"
                                                    name="waktu_selesai"
                                                    class="
                                                     shadow-theme-xs focus:border-blue-300 focus:ring-blue-500/10 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5  pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden " />
                                            </div>
                                        </div>
                                        <div class="flex justify-end gap-2">
                                            <button type="button" class="px-4 py-2 rounded bg-gray-200 text-gray-700 "
                                                @click="showModal = false">Batal</button>
                                            <button type="button" class="px-4 py-2 rounded bg-blue-500 text-white"
                                                @click="showModal = false">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 ">
                                Lokasi
                            </label>
                            <input type="text" name="lokasi" id="lokasi"
                                value="{{ old('lokasi', $acara->lokasi) }}"
                                class=" shadow-theme-xs font-normal focus:border-blue-300 focus:ring-blue-500/10 h-11 w-full  border border-gray-300 rounded-lg bg-transparent px-4 py-2.5 text-lg text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden ">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="deskripsi_acara" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <div>
                            <link rel="stylesheet"
                                href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />
                            <input id="deskripsi_acara" name="deskripsi_acara" type="hidden"
                                value="{{ old('deskripsi_acara', $acara->deskripsi) }}">
                            <trix-editor input="deskripsi_acara"></trix-editor>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
                        </div>
                    </div>
                    {{-- <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi_acara" id="deskripsi" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('deskripsi_acara', $acara->deskripsi) }}</textarea>
                    </div> --}}
                    <div class="w-full">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 ">
                            Info Kontak
                        </label>
                        <input type="text" name="info_kontak" id="info_kontak"
                            value="{{ old('info_kontak', $acara->info_kontak) }}"
                            class=" shadow-theme-xs font-normal focus:border-blue-300 focus:ring-blue-500/10 h-11 w-full  border border-gray-300 rounded-lg bg-transparent px-4 py-2.5 text-lg text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden ">
                    </div>
                    <div>
                        <div class="rounded-2xl border border-gray-200 bg-white mt-5 p-5">
                            <div class="px-5 py-4 sm:px-6 sm:py-5">
                                <h3 class="text-base font-medium text-gray-800">
                                    Jenis Tiket
                                </h3>
                            </div>
                            <div x-data="{
                                adaGratis: {{ $acara->jenisTiket->where('harga', 0)->count() > 0 ? 'true' : 'false' }},
                                adaBerbayar: {{ $acara->jenisTiket->where('harga', '>', 0)->count() > 0 ? 'true' : 'false' }},
                                showModal: false,
                                editIndex: null,
                                currentType: 'gratis',
                                kategoriGratis: {{ json_encode(
                                    $acara->jenisTiket->where('harga', 0)->map(function ($tiket) {
                                            return [
                                                'id' => $tiket->id,
                                                'nama' => $tiket->nama_jenis,
                                                'harga' => $tiket->harga,
                                                'kuota' => $tiket->kuota,
                                                'penjualan_mulai' => \Carbon\Carbon::parse($tiket->penjualan_mulai)->format('Y-m-d'),
                                                'penjualan_selesai' => \Carbon\Carbon::parse($tiket->penjualan_selesai)->format('Y-m-d'),
                                                'deskripsi' => $tiket->deskripsi ?? '',
                                            ];
                                        })->values(),
                                ) }},
                                kategoriBerbayar: {{ json_encode(
                                    $acara->jenisTiket->where('harga', '>', 0)->map(function ($tiket) {
                                            return [
                                                'id' => $tiket->id,
                                                'nama' => $tiket->nama_jenis,
                                                'harga' => $tiket->harga,
                                                'kuota' => $tiket->kuota,
                                                'penjualan_mulai' => \Carbon\Carbon::parse($tiket->penjualan_mulai)->format('Y-m-d'),
                                                'penjualan_selesai' => \Carbon\Carbon::parse($tiket->penjualan_selesai)->format('Y-m-d'),
                                                'deskripsi' => $tiket->deskripsi ?? '',
                                            ];
                                        })->values(),
                                ) }},
                                kategoriBaru: {
                                    id: null,
                                    nama: '',
                                    harga: '',
                                    kuota: '',
                                    penjualan_mulai: '',
                                    penjualan_selesai: '',
                                    deskripsi: ''
                                },
                                get kategoriList() {
                                    return this.currentType === 'gratis' ? this.kategoriGratis : this.kategoriBerbayar;
                                },
                                tambahKategori() {
                                    if (this.editIndex !== null) {
                                        this.kategoriList[this.editIndex] = { ...this.kategoriBaru };
                                        this.editIndex = null;
                                    } else {
                                        this.kategoriList.push({ ...this.kategoriBaru });
                                    }
                                    this.resetForm();
                                    this.showModal = false;
                                },
                                editKategori(index) {
                                    this.kategoriBaru = { ...this.kategoriList[index] };
                                    this.editIndex = index;
                                    this.showModal = true;
                                },
                                hapusKategori(index) {
                                    this.kategoriList.splice(index, 1);
                                },
                                resetForm() {
                                    this.kategoriBaru = {
                                        id: null,
                                        nama: '',
                                        harga: '',
                                        kuota: '',
                                        penjualan_mulai: '',
                                        penjualan_selesai: '',
                                        deskripsi: ''
                                    };
                                },
                                openAddModal(type) {
                                    this.currentType = type;
                                    this.showModal = true;
                                }
                            }" class="flex flex-wrap items-center gap-2">
                                <!-- Pilihan Tiket Type -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                                    <!-- Pilihan Gratis -->
                                    <div class="group relative overflow-hidden rounded-xl border-2 transition-all duration-300 cursor-pointer"
                                        :class="adaGratis ?
                                            'border-green-500 bg-gradient-to-br from-green-50 to-emerald-50 ' :
                                            'border-gray-200 bg-white hover:border-green-300'"
                                        @click="adaGratis = !adaGratis">
                                        <div class="p-6">
                                            <label class="flex items-center cursor-pointer">
                                                <input type="checkbox" @change="adaGratis = !adaGratis"
                                                    class="sr-only" />
                                                <div class="relative">
                                                    <div :class="adaGratis ?
                                                        'border-green-500 bg-green-500 shadow-green-200' :
                                                        'border-gray-300 bg-white'"
                                                        class="flex h-6 w-6 items-center justify-center rounded-full border-2 transition-all duration-200 shadow-sm">
                                                        <svg x-show="adaGratis" x-transition.opacity
                                                            class="h-3.5 w-3.5 text-white" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span
                                                            class="text-sm font-medium text-gray-600 uppercase tracking-wider">Tambah</span>
                                                    </div>
                                                    <h3 class="text-2xl font-bold text-gray-900 mb-1">Tiket Gratis</h3>
                                                    <p class="text-sm text-gray-500">Tidak ada biaya untuk peserta</p>
                                                </div>
                                            </label>
                                        </div>
                                        <!-- Accent line -->
                                        <div :class="adaGratis ? 'bg-green-500' : 'bg-gray-200'"
                                            class="absolute bottom-0 left-0 h-1 w-full transition-all duration-300">
                                        </div>
                                    </div>

                                    <!-- Pilihan Berbayar -->
                                    <div class="group relative overflow-hidden rounded-xl border-2 transition-all duration-300 cursor-pointer"
                                        :class="adaBerbayar ?
                                            'border-blue-500 bg-gradient-to-br from-blue-50 to-indigo-50 shadow-lg' :
                                            'border-gray-200 bg-white hover:border-blue-300 hover:shadow-md'"
                                        @click="adaBerbayar = !adaBerbayar">
                                        <div class="p-6">
                                            <label class="flex items-center cursor-pointer">
                                                <input type="checkbox" @change="adaBerbayar = !adaBerbayar"
                                                    class="sr-only" />
                                                <div class="relative">
                                                    <div :class="adaBerbayar ?
                                                        'border-blue-500 bg-blue-500 shadow-blue-200' :
                                                        'border-gray-300 bg-white'"
                                                        class="flex h-6 w-6 items-center justify-center rounded-full border-2 transition-all duration-200 shadow-sm">
                                                        <svg x-show="adaBerbayar" x-transition.opacity
                                                            class="h-3.5 w-3.5 text-white" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <svg class="h-5 w-5 text-blue-500" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                        </svg>
                                                        <span
                                                            class="text-sm font-medium text-gray-600 uppercase tracking-wider">Tambah</span>
                                                    </div>
                                                    <h3 class="text-2xl font-bold text-gray-900 mb-1">Tiket Berbayar
                                                    </h3>
                                                    <p class="text-sm text-gray-500">Tetapkan kategori dan harga tiket
                                                    </p>
                                                </div>
                                            </label>
                                        </div>
                                        <!-- Accent line -->
                                        <div :class="adaBerbayar ? 'bg-blue-500' : 'bg-gray-200'"
                                            class="absolute bottom-0 left-0 h-1 w-full transition-all duration-300">
                                        </div>
                                    </div>
                                </div>

                                <!-- Daftar Kategori Tiket Gratis -->
                                <div class="w-full mt-6" x-show="adaGratis" x-transition>
                                    <div class="mb-4 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                            <h4 class="text-sm font-semibold text-gray-700 uppercase">Kategori Tiket
                                                Gratis</h4>
                                        </div>
                                        <span class="text-xs text-gray-500"
                                            x-text="`${kategoriGratis.length} Kategori`"></span>
                                    </div>

                                    <div class="space-y-3">
                                        <template x-for="(kategori, index) in kategoriGratis" :key="index">
                                            <div
                                                class="group relative bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-5 hover:shadow-lg transition-all duration-300 hover:border-green-400">
                                                <div class="absolute top-4 left-4 opacity-10">
                                                    <svg class="w-16 h-16 text-green-600" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z" />
                                                    </svg>
                                                </div>

                                                <div class="relative flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <div class="flex items-center gap-3 mb-3">
                                                            <div class="bg-green-600 p-2 rounded-lg">
                                                                <svg class="w-5 h-5 text-white" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <h4 class="text-lg font-bold text-gray-900"
                                                                    x-text="kategori.nama"></h4>
                                                                <p class="text-sm font-bold text-green-600">Gratis</p>
                                                            </div>
                                                        </div>

                                                        <div class="grid grid-cols-2 gap-3 mb-3">
                                                            <div class="bg-white/70 rounded-lg p-3">
                                                                <p class="text-xs text-gray-500 mb-1">Kuota Tiket</p>
                                                                <p
                                                                    class="text-sm font-semibold text-gray-900 flex items-center gap-1">
                                                                    <svg class="w-4 h-4 text-green-600"
                                                                        fill="currentColor" viewBox="0 0 20 20">
                                                                        <path
                                                                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                                                    </svg>
                                                                    <span x-text="kategori.kuota + ' tiket'"></span>
                                                                </p>
                                                            </div>
                                                            <div class="bg-white/70 rounded-lg p-3">
                                                                <p class="text-xs text-gray-500 mb-1">Penjualan</p>
                                                                <p class="text-xs font-medium text-gray-700">
                                                                    <span
                                                                        x-text="new Date(kategori.penjualan_mulai).toLocaleDateString('id-ID', {day: '2-digit', month: 'short'})"></span>
                                                                    -
                                                                    <span
                                                                        x-text="new Date(kategori.penjualan_selesai).toLocaleDateString('id-ID', {day: '2-digit', month: 'short'})"></span>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="bg-white/70 rounded-lg p-3"
                                                            x-show="kategori.deskripsi">
                                                            <p class="text-xs text-gray-500 mb-1">Deskripsi</p>
                                                            <p class="text-sm text-gray-700 line-clamp-2"
                                                                x-text="kategori.deskripsi"></p>
                                                        </div>
                                                    </div>

                                                    <div class="flex flex-col gap-2 ml-4">
                                                        <button type="button"
                                                            @click="currentType = 'gratis'; editKategori(index)"
                                                            class="flex items-center gap-1 px-3 py-2 bg-white border border-green-300 text-green-600 rounded-lg hover:bg-green-50 transition-colors text-sm font-medium shadow-sm">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                            Edit
                                                        </button>
                                                        <button type="button"
                                                            @click="kategoriGratis.splice(index, 1)"
                                                            class="flex items-center gap-1 px-3 py-2 bg-white border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors text-sm font-medium shadow-sm">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </div>

                                                <template x-for="(value, key) in kategori" :key="key">
                                                    <input type="hidden" :name="`kategori_tiket[${index}][${key}]`"
                                                        :value="value">
                                                </template>
                                            </div>
                                        </template>
                                    </div>

                                    <div x-show="kategoriGratis.length === 0"
                                        class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                        </svg>
                                        <p class="text-gray-500 font-medium">Belum ada kategori tiket gratis</p>
                                        <p class="text-sm text-gray-400 mt-1">Klik tombol "Tambah Kategori Tiket" untuk
                                            memulai</p>
                                    </div>
                                </div>

                                <div class="w-full mt-2" x-show="adaGratis" x-transition>
                                    <button type="button" @click="openAddModal('gratis')"
                                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Tambah Kategori Tiket Gratis
                                    </button>
                                </div>

                                <!-- Daftar Kategori Tiket Berbayar -->
                                <div class="w-full mt-6" x-show="adaBerbayar" x-transition>
                                    <div class="mb-4 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                            <h4 class="text-sm font-semibold text-gray-700 uppercase">Kategori Tiket
                                                Berbayar</h4>
                                        </div>
                                        <span class="text-xs text-gray-500"
                                            x-text="`${kategoriBerbayar.length} Kategori`"></span>
                                    </div>

                                    <div class="space-y-3">
                                        <template x-for="(kategori, index) in kategoriBerbayar"
                                            :key="index">
                                            <div
                                                class="group relative bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-5 hover:shadow-lg transition-all duration-300 hover:border-blue-400">
                                                <div class="absolute top-4 left-4 opacity-10">
                                                    <svg class="w-16 h-16 text-blue-600" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z" />
                                                    </svg>
                                                </div>

                                                <div class="relative flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <div class="flex items-center gap-3 mb-3">
                                                            <div class="bg-blue-600 p-2 rounded-lg">
                                                                <svg class="w-5 h-5 text-white" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <h4 class="text-lg font-bold text-gray-900"
                                                                    x-text="kategori.nama"></h4>
                                                                <p class="text-2xl font-bold text-blue-600">
                                                                    Rp <span
                                                                        x-text="parseInt(kategori.harga).toLocaleString('id-ID')"></span>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="grid grid-cols-2 gap-3 mb-3">
                                                            <div class="bg-white/70 rounded-lg p-3">
                                                                <p class="text-xs text-gray-500 mb-1">Kuota Tiket</p>
                                                                <p
                                                                    class="text-sm font-semibold text-gray-900 flex items-center gap-1">
                                                                    <svg class="w-4 h-4 text-blue-600"
                                                                        fill="currentColor" viewBox="0 0 20 20">
                                                                        <path
                                                                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                                                    </svg>
                                                                    <span x-text="kategori.kuota + ' tiket'"></span>
                                                                </p>
                                                            </div>
                                                            <div class="bg-white/70 rounded-lg p-3">
                                                                <p class="text-xs text-gray-500 mb-1">Penjualan</p>
                                                                <p class="text-xs font-medium text-gray-700">
                                                                    <span
                                                                        x-text="new Date(kategori.penjualan_mulai).toLocaleDateString('id-ID', {day: '2-digit', month: 'short'})"></span>
                                                                    -
                                                                    <span
                                                                        x-text="new Date(kategori.penjualan_selesai).toLocaleDateString('id-ID', {day: '2-digit', month: 'short'})"></span>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="bg-white/70 rounded-lg p-3"
                                                            x-show="kategori.deskripsi">
                                                            <p class="text-xs text-gray-500 mb-1">Deskripsi</p>
                                                            <p class="text-sm text-gray-700 line-clamp-2"
                                                                x-text="kategori.deskripsi"></p>
                                                        </div>
                                                    </div>

                                                    <div class="flex flex-col gap-2 ml-4">
                                                        <button type="button"
                                                            @click="currentType = 'berbayar'; editKategori(index)"
                                                            class="flex items-center gap-1 px-3 py-2 bg-white border border-blue-300 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors text-sm font-medium shadow-sm">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                            Edit
                                                        </button>
                                                        <button type="button"
                                                            @click="kategoriBerbayar.splice(index, 1)"
                                                            class="flex items-center gap-1 px-3 py-2 bg-white border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors text-sm font-medium shadow-sm">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </div>

                                                <template x-for="(value, key) in kategori" :key="key">
                                                    <input type="hidden"
                                                        :name="`kategori_tiket[${kategoriGratis.length + index}][${key}]`"
                                                        :value="value">
                                                </template>
                                            </div>
                                        </template>
                                    </div>

                                    <div x-show="kategoriBerbayar.length === 0"
                                        class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                        </svg>
                                        <p class="text-gray-500 font-medium">Belum ada kategori tiket berbayar</p>
                                        <p class="text-sm text-gray-400 mt-1">Klik tombol "Tambah Kategori Tiket" untuk
                                            memulai</p>
                                    </div>
                                </div>

                                <div class="w-full mt-2" x-show="adaBerbayar" x-transition>
                                    <button type="button" @click="openAddModal('berbayar')"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Tambah Kategori Tiket Berbayar
                                    </button>
                                </div>

                                <!-- Modal Konfigurasi Kategori -->
                                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 "
                                    x-show="showModal" x-transition.opacity x-cloak @click.self="showModal = false">
                                    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4">
                                        <div class="flex justify-between items-center mb-4">
                                            <h3 class="text-xl font-semibold text-gray-900"
                                                x-text="editIndex !== null ? 'Edit Kategori Tiket' : 'Tambah Kategori Tiket'">
                                            </h3>
                                            <button type="button" @click="showModal = false"
                                                class="text-gray-400 hover:text-gray-500">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Form -->
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama
                                                    Kategori</label>
                                                <input type="text" x-model="kategoriBaru.nama"
                                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                                            </div>

                                            <div x-show="currentType === 'berbayar'">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                                                <div class="relative">
                                                    <span
                                                        class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Rp</span>
                                                    <input type="text" x-model="kategoriBaru.harga"
                                                        class="w-full rounded-lg border border-gray-300 pl-10 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah
                                                    Tiket</label>
                                                <input type="number" x-model="kategoriBaru.kuota" min="1"
                                                    max="999" placeholder="Masukkan jumlah (1-999)"
                                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                                                <p class="text-xs text-gray-500 mt-1">Maksimal 999 tiket per kategori
                                                </p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                                    Mulai Penjualan</label>
                                                <input type="date" x-model="kategoriBaru.penjualan_mulai"
                                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                                    Selesai Penjualan</label>
                                                <input type="date" x-model="kategoriBaru.penjualan_selesai"
                                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                                <textarea x-model="kategoriBaru.deskripsi" rows="3"
                                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                            </div>
                                        </div>

                                        <!-- Tombol -->
                                        <div class="mt-6 flex justify-end gap-3">
                                            <button type="button" @click="showModal = false"
                                                class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                                                Batal
                                            </button>
                                            <button type="button" @click="tambahKategori()"
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                                                <span
                                                    x-text="editIndex !== null ? 'Simpan Perubahan' : 'Tambah Kategori'"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 rounded-2xl border border-gray-200 bg-white">
                            <div class="px-5 py-4 sm:px-6 sm:py-5">
                                <h3 class="text-base font-medium text-gray-800">
                                    Tambah Aturan
                                </h3>
                            </div>
                            <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6">
                                <!-- Elements -->
                                <div class="flex flex-col w-full justify-center gap-8">
                                    <div class="flex gap-4 items-center justify-between">
                                        <div class="">
                                            <label for="">Maks Tiket per transaksi</label>
                                            <p class="text-sm text-gray-400">Jumlah maksimal tiket yang dapat dibeli
                                                dalam 1 transaksi</p>
                                        </div>
                                        <select name="maks_tiket_per_transaksi"
                                            class="shadow-theme-xs w-24 focus:border-blue-300 focus:ring-blue-500/10 h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden">
                                            <option value="5"
                                                {{ $acara->maks_tiket_per_transaksi == 5 ? 'selected' : '' }}>5 tiket
                                            </option>
                                            <option value="4"
                                                {{ $acara->maks_tiket_per_transaksi == 4 ? 'selected' : '' }}>4 tiket
                                            </option>
                                            <option value="3"
                                                {{ $acara->maks_tiket_per_transaksi == 3 ? 'selected' : '' }}>3 tiket
                                            </option>
                                            <option value="2"
                                                {{ $acara->maks_tiket_per_transaksi == 2 ? 'selected' : '' }}>2 tiket
                                            </option>
                                            <option value="1"
                                                {{ $acara->maks_tiket_per_transaksi == 1 ? 'selected' : '' }}>1 tiket
                                            </option>
                                        </select>
                                    </div>
                                    <div class="flex items-center justify-between gap-4" x-data="{ switchToggle: {{ $acara->maks_pembelian_per_akun ? 'true' : 'false' }} }">
                                        <div class="">
                                            <label for="">1 Tiket per Akun</label>
                                            <p class="text-sm text-gray-400">1 Akun hanya dapat membeli 1 tiket</p>
                                        </div>
                                        <div class="flex items-center">
                                            <label for="switchToggle" class="flex cursor-pointer items-center">
                                                <div class="relative">
                                                    <input type="checkbox" id="switchToggle" class="sr-only"
                                                        name="satu_tiket_per_akun"
                                                        @change="switchToggle = !switchToggle"
                                                        {{ $acara->maks_pembelian_per_akun ? 'checked' : '' }} />
                                                    <div :class="switchToggle ? 'bg-blue-500' : 'bg-gray-300'"
                                                        class="block h-6 w-11 rounded-full transition-colors duration-200 ease-in-out">
                                                    </div>
                                                    <div :class="switchToggle ? 'translate-x-5' : 'translate-x-0'"
                                                        class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition-transform duration-200 ease-in-out">
                                                    </div>
                                                </div>
                                            </label>
                                            <input type="hidden" name="maks_pembelian_per_akun"
                                                :value="switchToggle ? 1 : 0" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 w-full mt-4">
                            <button type="submit" name="status" value="draft"
                                class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                                Simpan Draft
                            </button>
                            <button type="submit" name="status" value="published"
                                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                Simpan & Publish
                            </button>
                        </div>
                    </div>
                    {{-- <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Simpan
                        </button>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
