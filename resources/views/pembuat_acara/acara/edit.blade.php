<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('pembuat.acara.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf
                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-9v4a1 1 0 11-2 0v-4a1 1 0 112 0zm-1-5a1 1 0 00-1 1v.01a1 1 0 102 0V5a1 1 0 00-1-1z" clip-rule="evenodd"/>
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
                                <span class="text-gray-500 text-sm text-center">
                                    <strong>Seret dan letakkan gambar di sini</strong><br>
                                    atau klik untuk memilih file
                                </span>
                                <img id="previewImage" class="hidden w-full h-full object-cover rounded-lg"
                                    alt="Preview Banner">
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
                        <input type="text" name="nama_acara" id="nama_acara" required
                            class="mt-1 h-10 block w-full rounded-md border border-gray-100 shadow-sm focus:border-sky-500">
                    </div>
                    <div class="flex gap-5 mt-5">
                        <div class="w-full" x-data="{
                            showModal: false,
                            startDate: '',
                            endDate: '',
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
                            <input type="text" name="lokasi" id="lokasi" name="lokasi"
                                class=" shadow-theme-xs font-normal focus:border-blue-300 focus:ring-blue-500/10 h-11 w-full  border border-gray-300 rounded-lg bg-transparent px-4 py-2.5 text-lg text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden ">
                        </div>
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi_acara" id="deskripsi" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                    <div class="w-full">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 ">
                            Info Kontak
                        </label>
                        <input type="text" name="info_kontak" id="info_kontak" name="info_kontak"
                            class=" shadow-theme-xs font-normal focus:border-blue-300 focus:ring-blue-500/10 h-11 w-full  border border-gray-300 rounded-lg bg-transparent px-4 py-2.5 text-lg text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden ">
                    </div>
                    <div>
                        <div class="mt-5 w-full">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700">
                                Banner tiket
                            </label>
                            <input type="file" name="banner_tiket"
                                class="focus:border-ring-brand-300 shadow-theme-xs focus:file:ring-brand-300 h-11 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:pr-3 file:pl-3.5 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden " />
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-white mt-5 p-5">
                            <div class="px-5 py-4 sm:px-6 sm:py-5">
                                <h3 class="text-base font-medium text-gray-800">
                                    Jenis Tiket
                                </h3>
                            </div>
                            <div x-data="{
                                selected: 'gratis',
                                showModal: false,
                                editIndex: null,
                                kategoriList: [],
                                kategoriBaru: {
                                    nama: '',
                                    harga: '',
                                    kuota: '',
                                    penjualan_mulai: '',
                                    penjualan_selesai: '',
                                    deskripsi: ''
                                },
                                tambahKategori() {
                                    if (this.editIndex !== null) {
                                        // mode edit
                                        this.kategoriList[this.editIndex] = { ...this.kategoriBaru };
                                        this.editIndex = null;
                                    } else {
                                        // tambah baru
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
                                        nama: '',
                                        harga: '',
                                        kuota: '',
                                        penjualan_mulai: '',
                                        penjualan_selesai: '',
                                        deskripsi: ''
                                    };
                                }
                            }" class="flex flex-wrap items-center gap-8">
                                <!-- Pilihan Gratis -->
                                <div class="p-6 rounded-lg border transition-all duration-200"
                                    :class="selected === 'gratis' ? 'border-blue-500' : 'border-gray-100'">
                                    <label
                                        class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none">
                                        <input type="radio" name="jenis_tiket" value="gratis" class="sr-only"
                                            x-model="selected" />
                                        <div :class="selected === 'gratis' ? 'border-blue-500 bg-blue-500' :
                                            'bg-transparent border-gray-300'"
                                            class="hover:border-blue-500 mr-3 flex h-5 w-5 items-center justify-center rounded-full border-[1.25px] transition-all duration-200">
                                            <span class="h-2 w-2 rounded-full"
                                                :class="selected === 'gratis' ? 'bg-white' : 'bg-white'"></span>
                                        </div>
                                        Gratis
                                    </label>
                                </div>

                                <!-- Pilihan Berbayar -->
                                <div class="p-6 rounded-lg border transition-all duration-200"
                                    :class="selected === 'berbayar' ? 'border-blue-500' : 'border-gray-100'">
                                    <label
                                        class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none">
                                        <input type="radio" name="jenis_tiket" value="berbayar" class="sr-only"
                                            x-model="selected" />
                                        <div :class="selected === 'berbayar' ? 'border-blue-500 bg-blue-500' :
                                            'bg-transparent border-gray-300'"
                                            class="hover:border-blue-500 mr-3 flex h-5 w-5 items-center justify-center rounded-full border-[1.25px] transition-all duration-200">
                                            <span class="h-2 w-2 rounded-full"
                                                :class="selected === 'berbayar' ? 'bg-white' : 'bg-white'"></span>
                                        </div>
                                        Berbayar
                                    </label>
                                </div>

                                <!-- Daftar Kategori Tiket -->
                                <div class="w-full mt-2" x-show="selected === 'berbayar'">
                                    <template class="flex-col gap-4" x-for="(kategori, index) in kategoriList" :key="index">
                                        <div
                                            class="flex justify-between items-center border rounded-lg p-4 bg-gray-50">
                                            <div>
                                                <h4 class="font-medium text-gray-800" x-text="kategori.nama"></h4>
                                                <p class="text-gray-500 text-sm">Rp <span
                                                        x-text="kategori.harga"></span></p>
                                            </div>
                                            <div class="flex gap-2">
                                                <button type="button" @click="editKategori(index)"
                                                    class="text-blue-600 hover:underline text-sm">Edit</button>
                                                <button type="button" @click="hapusKategori(index)"
                                                    class="text-red-600 hover:underline text-sm">Hapus</button>
                                            </div>
                                            <!-- Hidden input agar dikirim ke server -->
                                            <template x-for="(value, key) in kategori" :key="key">
                                                <input type="hidden" :name="`kategori_tiket[${index}][${key}]`"
                                                    :value="value">
                                            </template>
                                        </div>
                                    </template>
                                </div>

                                <!-- Tombol Tambah Kategori -->
                                <div class="w-full mt-2" x-show="selected === 'berbayar'" x-transition>
                                    <button type="button" @click="showModal = true"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Tambah Kategori Tiket
                                    </button>
                                </div>

                                <!-- Modal Konfigurasi Kategori -->
                                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
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
                                            <div>
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
                                                <input type="number" x-model="kategoriBaru.kuota"
                                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
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
                                    <div class="border p-4 rounded-lg flex items-center gap-4" x-data="{ checkboxToggle: false }"
                                        :class="checkboxToggle ? 'border-blue-500' : 'border-gray-200'">
                                        <div class="w-64">
                                            <label for="radioLabelOne"
                                                class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none">
                                                <div class="relative">
                                                    <input type="checkbox" id="radioLabelOne" class="sr-only"
                                                        @change="checkboxToggle = !checkboxToggle" />
                                                    <div :class="checkboxToggle ? 'border-blue-500 bg-blue-500' :
                                                        'bg-transparent border-gray-300'"
                                                        class="hover:border-blue-500 mr-3 flex h-5 w-5 items-center justify-center rounded-full border-[1.25px]">
                                                        <span class="h-2 w-2 rounded-full"
                                                            :class="checkboxToggle ? 'bg-white' : 'bg-white'"></span>
                                                    </div>
                                                </div>
                                                Maks Pembelian per akun
                                            </label>
                                        </div>
                                        <input type="number" :disabled="!checkboxToggle"
                                            name="maks_pembelian_per_akun"
                                            class="
                                         shadow-theme-xs focus:border-blue-300 focus:ring-blue-500/10 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden " />
                                    </div>
                                    <div class="border p-4 rounded-lg flex items-center gap-4" x-data="{ ticketLimitToggle: false }"
                                        :class="ticketLimitToggle ? 'border-blue-500' : 'border-gray-200'">
                                        <div class="w-64">
                                            <label for="ticketLimitToggle"
                                                class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none">
                                                <div class="relative">
                                                    <input type="checkbox" id="ticketLimitToggle" class="sr-only"
                                                        @change="ticketLimitToggle = !ticketLimitToggle" />
                                                    <div :class="ticketLimitToggle ? 'border-blue-500 bg-blue-500' :
                                                        'bg-transparent border-gray-300'"
                                                        class="hover:border-blue-500 mr-3 flex h-5 w-5 items-center justify-center rounded-full border-[1.25px]">
                                                        <span class="h-2 w-2 rounded-full"
                                                            :class="ticketLimitToggle ? 'bg-white' : 'bg-white'"></span>
                                                    </div>
                                                </div>
                                                Maks tiket per transaksi
                                            </label>
                                        </div>
                                        <input type="number" :disabled="!ticketLimitToggle"
                                            name="maks_tiket_per_transaksi"
                                            :class="!ticketLimitToggle ? 'opacity-50 cursor-not-allowed' : ''"
                                            class="
                                         shadow-theme-xs focus:border-blue-300 focus:ring-blue-500/10 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden " />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between mt-4">
                            <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                Simpan
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
