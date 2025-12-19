<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 mb-4 max-w-5xl mx-auto">
            <i data-lucide="calendar" class="size-5 text-gray-600"></i>
            <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
            <p class="font-medium">Buat Acara</p>
        </div>
    </x-slot>

    <div class="mb-6">
        <div class="mx-auto max-w-5xl">
            <div class="">
                <form method="POST" action="{{ route('pembuat.acara.store') }}" enctype="multipart/form-data"
                    class="">
                    @csrf
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
                            class="mt-1 h-10 block w-full border-b-2 outline-0 border-gray-100 text-xl focus:border-sky-500">
                    </div>
                    <div class="flex gap-5 mt-5">
                        <div class="w-full mb-6">
                            <label class="mb-4 block text-sm font-medium text-gray-700">
                                Diselenggarakan oleh
                            </label>

                            <div class="flex items-center gap-3 ">
                                <!-- Foto Kreator -->
                                @if ($kreator && $kreator->logo)
                                    <img src="{{ Storage::url($kreator->logo) }}" alt="{{ $kreator->nama_kreator }}"
                                        class="h-20 w-20 rounded-full object-cover border border-gray-300 shadow-sm">
                                @else
                                    <div
                                        class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                                        <i data-lucide="user" class="size-6"></i>
                                    </div>
                                @endif

                                <!-- Nama Kreator -->
                                <div>
                                    <p class="font-semibold text-gray-900 text-md">
                                        {{ $kreator->nama_kreator ?? 'Belum Ada Profil Kreator' }}
                                    </p>
                                    <input type="hidden" name="id_kreator" id="id_kreator" value={{ $kreator->id }}>
                                    <p class="text-xs text-gray-500">
                                        Profil kreator akan tampil di halaman event Anda.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="w-full" x-data="{
                            showDateModal: false,
                            startDate: '',
                            endDate: '',
                        
                            // Helper untuk format tanggal (Contoh: 17 Desember 2025)
                            formatDate(dateStr) {
                                if (!dateStr) return '';
                                const options = { day: 'numeric', month: 'short', year: 'numeric' };
                                return new Date(dateStr).toLocaleDateString('id-ID', options);
                            },
                        
                            // Helper untuk menghitung durasi hari
                            get duration() {
                                if (this.startDate && this.endDate) {
                                    const start = new Date(this.startDate);
                                    const end = new Date(this.endDate);
                                    const diffTime = Math.abs(end - start);
                                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                                    return diffDays + ' Hari';
                                }
                                return 'Tentukan durasi acara';
                            }
                        }">
                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Tanggal Acara
                            </label>

                            <input type="hidden" name="waktu_mulai" x-model="startDate">
                            <input type="hidden" name="waktu_selesai" x-model="endDate">

                            <div class="flex items-start gap-3">
                                <div class="shrink-0 mt-0.5 text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>

                                <div class="mr-4">
                                    <p class="text-gray-900 font-medium"
                                        x-text="startDate && endDate ? `${formatDate(startDate)} - ${formatDate(endDate)}` : 'Belum ada tanggal dipilih'">
                                    </p>
                                    <p class="text-gray-500 text-sm mt-0.5" x-text="duration">
                                    </p>
                                </div>

                                <button type="button" @click="showDateModal = true"
                                    class="shrink-0 text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                        <path d="m15 5 4 4" />
                                    </svg>
                                </button>
                            </div>

                            <div x-show="showDateModal" x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/80">

                                <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4"
                                    @click.outside="showDateModal = false">
                                    <div class="flex justify-between items-center mb-6">
                                        <h3 class="text-lg font-semibold text-gray-900">Pilih Tanggal Acara</h3>
                                        <button type="button" @click="showDateModal = false"
                                            class="text-gray-400 hover:text-gray-500">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                                Mulai</label>
                                            <input type="date" x-model="startDate"
                                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-800 shadow-theme-xs focus:border-blue-500 focus:ring-blue-500/10 focus:ring-3 focus:outline-hidden appearance-none" />
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                                Selesai</label>
                                            <input type="date" x-model="endDate"
                                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-800 shadow-theme-xs focus:border-blue-500 focus:ring-blue-500/10 focus:ring-3 focus:outline-hidden appearance-none" />
                                        </div>
                                    </div>

                                    <div class="flex justify-end gap-3 mt-6">
                                        <button type="button" @click="showDateModal = false"
                                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                                            Batal
                                        </button>
                                        <button type="button" @click="showDateModal = false"
                                            class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium">
                                            Simpan Tanggal
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full" x-data="{
                            showLocationModal: false,
                            eventType: 'offline',
                        
                            // State Data
                            tempAddress: '',
                            tempCoordinates: '',
                            tempLink: '',
                        
                            // Data Final
                            finalLocation: '',
                            finalEventType: 'offline',
                        
                            // Leaflet Instances (Disimpan di sini agar bisa diakses 'this')
                            mapInstance: null,
                            markerInstance: null,
                            geocodeTimeout: null,
                        
                            init() {
                                // 1. Pantau Modal: Saat dibuka, jika belum ada map, inisialisasi. Jika sudah, refresh ukuran.
                                this.$watch('showLocationModal', value => {
                                    if (value && this.eventType === 'offline') {
                                        this.$nextTick(() => {
                                            if (!this.mapInstance) {
                                                this.initMap();
                                            } else {
                                                this.mapInstance.invalidateSize();
                                            }
                                        });
                                    }
                                });
                        
                                // 2. Pantau Tipe Event: Jika ganti ke offline, refresh map
                                this.$watch('eventType', value => {
                                    if (value === 'offline') {
                                        this.$nextTick(() => {
                                            if (!this.mapInstance) {
                                                this.initMap();
                                            } else {
                                                this.mapInstance.invalidateSize();
                                            }
                                        });
                                    }
                                });
                            },
                        
                            initMap() {
                                const defaultLat = -6.200000;
                                const defaultLng = 106.816666;
                        
                                // Inisialisasi Map
                                this.mapInstance = L.map('map').setView([defaultLat, defaultLng], 13);
                        
                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; OpenStreetMap'
                                }).addTo(this.mapInstance);
                        
                                // Inisialisasi Marker
                                this.markerInstance = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(this.mapInstance);
                        
                                // Set koordinat awal
                                this.updateCoordinates(defaultLat, defaultLng);
                        
                                // EVENT LISTENER: SAAT MARKER DIGESER (DRAGEND)
                                // Menggunakan arrow function '() =>' agar 'this' tetap mengacu ke Alpine component
                                this.markerInstance.on('dragend', (e) => {
                                    const position = e.target.getLatLng();
                                    this.updateCoordinates(position.lat, position.lng);
                                });
                        
                                // EVENT LISTENER: SAAT PETA DIKLIK
                                this.mapInstance.on('click', (e) => {
                                    this.markerInstance.setLatLng(e.latlng);
                                    this.updateCoordinates(e.latlng.lat, e.latlng.lng);
                                });
                            },
                        
                            updateCoordinates(lat, lng) {
                                // Update Input Hidden (DOM)
                                document.getElementById('latitude').value = lat;
                                document.getElementById('longitude').value = lng;
                        
                                // Update State Alpine (Reactive)
                                this.tempCoordinates = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                                this.tempAddress = 'Mencari alamat...'; // Indikator loading
                        
                                // Debounce untuk API Call agar tidak spam
                                clearTimeout(this.geocodeTimeout);
                                this.geocodeTimeout = setTimeout(() => {
                                    this.reverseGeocode(lat, lng);
                                }, 500);
                            },
                        
                            async reverseGeocode(lat, lng) {
                                try {
                                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`, {
                                        headers: { 'Accept-Language': 'id' }
                                    });
                        
                                    if (!response.ok) throw new Error('Geocoding failed');
                                    const data = await response.json();
                        
                                    // Update State Alpine dengan hasil alamat
                                    this.tempAddress = data.display_name;
                        
                                } catch (error) {
                                    console.error('Gagal mengambil alamat:', error);
                                    // Jika gagal, gunakan koordinat sebagai fallback
                                    this.tempAddress = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                                }
                            },
                        
                            saveLocation() {
                                this.finalEventType = this.eventType;
                        
                                if (this.eventType === 'offline') {
                                    // Prioritaskan alamat, jika kosong pakai koordinat
                                    this.finalLocation = this.tempAddress || this.tempCoordinates;
                                    document.getElementById('lokasi').value = this.finalLocation;
                                } else {
                                    this.finalLocation = this.tempLink;
                                    document.getElementById('lokasi').value = this.tempLink;
                                }
                        
                                this.showLocationModal = false;
                            }
                        }">

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Lokasi Acara
                            </label>

                            <input type="hidden" name="tipe_event" x-model="finalEventType">
                            <input type="hidden" name="lokasi" id="lokasi">
                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">

                            <div class="flex items-start gap-3">
                                <div class="shrink-0 mt-0.5 text-gray-500">
                                    <svg x-show="finalEventType === 'offline'" xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <svg x-show="finalEventType === 'online'" xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                    </svg>
                                </div>

                                <div class="mr-4">
                                    <p class="text-gray-900 font-medium"
                                        x-text="finalLocation || 'Belum ada lokasi dipilih'"></p>
                                    <p class="text-gray-500 text-sm mt-0.5"
                                        x-text="finalEventType === 'offline' ? 'Lokasi Fisik' : (finalEventType === 'online' ? 'Event Online' : 'Silakan atur lokasi')">
                                    </p>
                                </div>

                                <button type="button" @click="showLocationModal = true"
                                    class="shrink-0 text-blue-600 hover:text-blue-800 transition-colors p-1"
                                    title="Ubah Lokasi">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                        <path d="m15 5 4 4" />
                                    </svg>
                                </button>
                            </div>

                            <div x-show="showLocationModal" x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/80">
                                <div
                                    class="bg-white rounded-xl shadow-xl p-6 w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">

                                    <div class="flex justify-between items-center mb-6">
                                        <h3 class="text-xl font-semibold text-gray-900">Atur Lokasi Acara</h3>
                                        <button type="button" @click="showLocationModal = false"
                                            class="text-gray-400 hover:text-gray-500">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="flex p-1 bg-gray-100 rounded-lg mb-6 w-full">
                                        <button type="button" @click="eventType = 'offline'"
                                            :class="eventType === 'offline' ? 'bg-white text-blue-600 shadow-sm' :
                                                'text-gray-500 hover:text-gray-700'"
                                            class="flex-1 px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 flex justify-center items-center gap-2">
                                            Offline
                                        </button>
                                        <button type="button" @click="eventType = 'online'"
                                            :class="eventType === 'online' ? 'bg-white text-blue-600 shadow-sm' :
                                                'text-gray-500 hover:text-gray-700'"
                                            class="flex-1 px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 flex justify-center items-center gap-2">
                                            Online
                                        </button>
                                    </div>

                                    <div x-show="eventType === 'offline'">
                                        <div id="map"
                                            class="w-full h-80 rounded-lg border border-gray-300 mb-4 z-10"></div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Detail
                                                Alamat</label>
                                            <textarea x-model="tempAddress" readonly rows="2"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-sm resize-none text-gray-600"></textarea>
                                        </div>
                                    </div>

                                    <div x-show="eventType === 'online'">
                                        <div class="mb-6">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Link
                                                Streaming</label>
                                            <input type="url" x-model="tempLink" placeholder="https://..."
                                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>

                                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                                        <button type="button" @click="showLocationModal = false"
                                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</button>
                                        <button type="button" @click="saveLocation()"
                                            class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="deskripsi_acara" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <div>
                            <link rel="stylesheet"
                                href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />
                            <input id="deskripsi_acara" name="deskripsi_acara" type="hidden">
                            <trix-editor input ="deskripsi_acara"></trix-editor>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
                        </div>
                    </div>
                    <div class="w-full mt-4">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 ">
                            No Telp Narahubung
                        </label>
                        <input type="text" name="no_telp_narahubung" id="no_telp_narahubung"
                            class=" shadow-theme-xs font-normal focus:border-blue-300 focus:ring-blue-500/10 h-11 w-full  border border-gray-300 rounded-lg bg-transparent px-4 py-2.5 text-lg text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden ">
                    </div>
                    <div>
                        {{-- <div class="mt-5 w-full">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700">
                                Banner tiket
                            </label>
                            <input type="file" name="banner_tiket"
                                class="focus:border-ring-brand-300 shadow-theme-xs focus:file:ring-brand-300 h-11 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:pr-3 file:pl-3.5 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden " />
                        </div> --}}

                        <div class="rounded-2xl border border-gray-200 bg-white mt-5 p-5">
                            <div class="py-4  sm:py-5">
                                <h3 class="text-base font-medium text-gray-800">
                                    Jenis Tiket
                                </h3>
                            </div>
                            <div x-data="{
                                adaGratis: false,
                                adaBerbayar: false,
                                showModal: false,
                                editIndex: null,
                                currentType: 'gratis', // 'gratis' atau 'berbayar'
                                kategoriGratis: [],
                                kategoriBerbayar: [],
                                kategoriBaru: {
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
                                <!-- filepath: d:\Kulyeah\magang\Project\tukutiket\resources\views\pembuat_acara\acara\create.blade.php -->
                                <!-- ...existing code... -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                                    <!-- Pilihan Gratis -->
                                    <label
                                        class="relative flex items-center gap-4 p-4 border-2 rounded-lg cursor-pointer transition-all"
                                        :class="adaGratis ? 'border-green-500 bg-green-50' :
                                            'border-gray-200 bg-white hover:border-green-300'"
                                        @click="adaGratis = !adaGratis">
                                        <input type="checkbox" @change="adaGratis = !adaGratis" class="sr-only" />

                                        <!-- Checkbox Custom -->
                                        <div class="flex-shrink-0">
                                            <div :class="adaGratis ? 'border-green-500 bg-green-500' : 'border-gray-300 bg-white'"
                                                class="flex h-5 w-5 items-center justify-center rounded border-2 transition-all">
                                                <svg x-show="adaGratis" class="h-3 w-3 text-white"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Content -->
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900">Tiket Gratis</h3>
                                            <p class="text-sm text-gray-500">Tidak ada biaya untuk peserta</p>
                                        </div>

                                        <!-- Icon -->
                                        <div class="flex-shrink-0">
                                            <div
                                                class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                <i data-lucide="gift" class="size-5 text-green-600"></i>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Pilihan Berbayar -->
                                    <label
                                        class="relative flex items-center gap-4 p-4 border-2 rounded-lg cursor-pointer transition-all"
                                        :class="adaBerbayar ? 'border-indigo-500 bg-indigo-50' :
                                            'border-gray-200 bg-white hover:border-indigo-300'"
                                        @click="adaBerbayar = !adaBerbayar">
                                        <input type="checkbox" @change="adaBerbayar = !adaBerbayar"
                                            class="sr-only" />

                                        <!-- Checkbox Custom -->
                                        <div class="flex-shrink-0">
                                            <div :class="adaBerbayar ? 'border-indigo-500 bg-indigo-500' : 'border-gray-300 bg-white'"
                                                class="flex h-5 w-5 items-center justify-center rounded border-2 transition-all">
                                                <svg x-show="adaBerbayar" class="h-3 w-3 text-white"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Content -->
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900">Tiket Berbayar</h3>
                                            <p class="text-sm text-gray-500">Tetapkan harga tiket</p>
                                        </div>

                                        <!-- Icon -->
                                        <div class="flex-shrink-0">
                                            <div
                                                class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                <i data-lucide="ticket" class="size-5 text-indigo-600"></i>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <!-- ...existing code... -->

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
                                                <!-- Ticket Icon -->
                                                <div class="absolute top-4 left-4 opacity-10">
                                                    <svg class="w-16 h-16 text-green-600" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z" />
                                                    </svg>
                                                </div>

                                                <div class="relative flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <!-- Ticket Name (No Price) -->
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

                                                        <!-- Details Grid -->
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

                                                        <!-- Description -->
                                                        <div class="bg-white/70 rounded-lg p-3"
                                                            x-show="kategori.deskripsi">
                                                            <p class="text-xs text-gray-500 mb-1">Deskripsi</p>
                                                            <p class="text-sm text-gray-700 line-clamp-2"
                                                                x-text="kategori.deskripsi"></p>
                                                        </div>
                                                    </div>

                                                    <!-- Action Buttons -->
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

                                                <!-- Hidden inputs - dengan nama field kategori_tiket -->
                                                <template x-for="(value, key) in kategori" :key="key">
                                                    <input type="hidden" :name="`kategori_tiket[${index}][${key}]`"
                                                        :value="value">
                                                </template>
                                            </div>
                                        </template>
                                    </div>

                                    <!-- Empty State -->
                                    <div x-show="kategoriGratis.length === 0"
                                        class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                                        <i data-lucide="inbox" class="size-12 mx-auto text-gray-400 mb-3"></i>
                                        <p class="text-gray-500 font-medium">Belum ada kategori tiket gratis</p>
                                        <p class="text-sm text-gray-400 mt-1">Klik tombol di bawah untuk menambahkan
                                        </p>
                                    </div>
                                </div>

                                <!-- Tombol Tambah Kategori Gratis -->
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
                                                <!-- Ticket Icon -->
                                                <div class="absolute top-4 left-4 opacity-10">
                                                    <svg class="w-16 h-16 text-blue-600" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z" />
                                                    </svg>
                                                </div>

                                                <div class="relative flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <!-- Ticket Name & Price -->
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

                                                        <!-- Details Grid -->
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

                                                        <!-- Description -->
                                                        <div class="bg-white/70 rounded-lg p-3"
                                                            x-show="kategori.deskripsi">
                                                            <p class="text-xs text-gray-500 mb-1">Deskripsi</p>
                                                            <p class="text-sm text-gray-700 line-clamp-2"
                                                                x-text="kategori.deskripsi"></p>
                                                        </div>
                                                    </div>

                                                    <!-- Action Buttons -->
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

                                                <!-- Hidden inputs - dengan nama field kategori_tiket -->
                                                <template x-for="(value, key) in kategori" :key="key">
                                                    <input type="hidden"
                                                        :name="`kategori_tiket[${kategoriGratis.length + index}][${key}]`"
                                                        :value="value">
                                                </template>
                                            </div>
                                        </template>
                                    </div>

                                    <!-- Empty State -->
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

                                <!-- Tombol Tambah Kategori Berbayar -->
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

                                            <!-- Price Field - Only for Paid Tickets -->
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
                            <!-- Pilihan Tiket Type -->

                            <!-- Daftar Kategori Tiket Gratis -->
                            <div class="w-full mt-6" x-show="adaGratis" x-transition>
                                <div class="mb-4 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <h4 class="text-sm font-semibold text-gray-700 uppercase">Kategori Tiket Gratis
                                        </h4>
                                    </div>
                                    <span class="text-xs text-gray-500"
                                        x-text="`${kategoriGratis.length} Kategori`"></span>
                                </div>

                                <div class="space-y-3">
                                    <template x-for="(kategori, index) in kategoriGratis" :key="index">
                                        <div
                                            class="group relative bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-5 hover:shadow-lg transition-all duration-300 hover:border-green-400">
                                            <!-- Ticket Icon -->
                                            <div class="absolute top-4 left-4 opacity-10">
                                                <svg class="w-16 h-16 text-green-600" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z" />
                                                </svg>
                                            </div>

                                            <div class="relative flex items-start justify-between">
                                                <div class="flex-1">
                                                    <!-- Ticket Name (No Price) -->
                                                    <div class="flex items-center gap-3 mb-3">
                                                        <div class="bg-green-600 p-2 rounded-lg">
                                                            <svg class="w-5 h-5 text-white" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h4 class="text-lg font-bold text-gray-900"
                                                                x-text="kategori.nama"></h4>
                                                            <p class="text-sm font-bold text-green-600">Gratis</p>
                                                        </div>
                                                    </div>

                                                    <!-- Details Grid -->
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

                                                    <!-- Description -->
                                                    <div class="bg-white/70 rounded-lg p-3"
                                                        x-show="kategori.deskripsi">
                                                        <p class="text-xs text-gray-500 mb-1">Deskripsi</p>
                                                        <p class="text-sm text-gray-700 line-clamp-2"
                                                            x-text="kategori.deskripsi"></p>
                                                    </div>
                                                </div>

                                                <!-- Action Buttons -->
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
                                                    <button type="button" @click="kategoriGratis.splice(index, 1)"
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

                                            <!-- Hidden inputs -->
                                            <template x-for="(value, key) in kategori" :key="key">
                                                <input type="hidden" :name="`kategori_gratis[${index}][${key}]`"
                                                    :value="value">
                                            </template>
                                        </div>
                                    </template>
                                </div>

                                <!-- Empty State -->
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

                            <!-- Tombol Tambah Kategori Gratis -->
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
                                    <template x-for="(kategori, index) in kategoriBerbayar" :key="index">
                                        <div
                                            class="group relative bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-5 hover:shadow-lg transition-all duration-300 hover:border-blue-400">
                                            <!-- Ticket Icon -->
                                            <div class="absolute top-4 left-4 opacity-10">
                                                <svg class="w-16 h-16 text-blue-600" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z" />
                                                </svg>
                                            </div>

                                            <div class="relative flex items-start justify-between">
                                                <div class="flex-1">
                                                    <!-- Ticket Name & Price -->
                                                    <div class="flex items-center gap-3 mb-3">
                                                        <div class="bg-blue-600 p-2 rounded-lg">
                                                            <svg class="w-5 h-5 text-white" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
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

                                                    <!-- Details Grid -->
                                                    <div class="grid grid-cols-2 gap-3 mb-3">
                                                        <div class="bg-white/70 rounded-lg p-3">
                                                            <p class="text-xs text-gray-500 mb-1">Kuota Tiket</p>
                                                            <p
                                                                class="text-sm font-semibold text-gray-900 flex items-center gap-1">
                                                                <svg class="w-4 h-4 text-blue-600" fill="currentColor"
                                                                    viewBox="0 0 20 20">
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

                                                    <!-- Description -->
                                                    <div class="bg-white/70 rounded-lg p-3"
                                                        x-show="kategori.deskripsi">
                                                        <p class="text-xs text-gray-500 mb-1">Deskripsi</p>
                                                        <p class="text-sm text-gray-700 line-clamp-2"
                                                            x-text="kategori.deskripsi"></p>
                                                    </div>
                                                </div>

                                                <!-- Action Buttons -->
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
                                                    <button type="button" @click="kategoriBerbayar.splice(index, 1)"
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

                                            <!-- Hidden inputs - dengan nama field kategori_tiket -->
                                            <template x-for="(value, key) in kategori" :key="key">
                                                <input type="hidden"
                                                    :name="`kategori_tiket[${kategoriGratis.length + index}][${key}]`"
                                                    :value="value">
                                            </template>
                                        </div>
                                    </template>
                                </div>

                                <!-- Empty State -->
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

                            <!-- Tombol Tambah Kategori Berbayar -->
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
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

                                        <!-- Price Field - Only for Paid Tickets -->
                                        <div x-show="currentType === 'berbayar'">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
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
                                        <option value="5">5 tiket</option>
                                        <option value="4">4 tiket</option>
                                        <option value="3">3 tiket</option>
                                        <option value="2">2 tiket</option>
                                        <option value="1">1 tiket</option>
                                    </select>
                                </div>
                                <div class="flex items-center justify-between gap-4" x-data="{ switchToggle: false }">
                                    <div class="">
                                        <label for="">1 Tiket per Akun</label>
                                        <p class="text-sm text-gray-400">1 Akun hanya dapat membeli 1 tiket</p>
                                    </div>
                                    <div class="flex items-center">
                                        <label for="switchToggle" class="flex cursor-pointer items-center">
                                            <div class="relative">
                                                <input type="checkbox" id="switchToggle" class="sr-only"
                                                    name="satu_tiket_per_akun"
                                                    @change="switchToggle = !switchToggle" />
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
                    <div class="flex justify-between mt-4">
                        <div class="flex gap-3 justify-end w-full">
                            <button type="submit" name="status" value="draft"
                                class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                                Simpan Draft
                            </button>
                            <button type="submit" name="status" value="publish"
                                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                Publish
                            </button>
                        </div>
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
    {{-- </div> --}}
</x-app-layout>
