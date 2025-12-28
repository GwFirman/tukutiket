<div class="w-full" x-data="{
    showLocationModal: false,
    eventType: 'offline',
    isPublished: {{ isset($acara) && $acara->status === 'published' ? 'true' : 'false' }},

    // State Data
    tempAddress: '',
    tempCoordinates: '',
    tempLink: '',
    tempVenue: '',

    // Data Final
    finalLocation: '',
    finalEventType: 'offline',

    // Koordinat awal (penting untuk edit mode)
    initialLat: null,
    initialLng: null,

    // Leaflet Instances
    mapInstance: null,
    markerInstance: null,
    geocodeTimeout: null,

    init() {
        // 1. Muat data awal dari Server (Blade) ke Variable Alpine
        this.loadInitialData();

        // 2. Pantau Modal: Saat dibuka, init map atau refresh size
        this.$watch('showLocationModal', value => {
            if (value && this.eventType === 'offline') {
                this.$nextTick(() => {
                    if (!this.mapInstance) {
                        this.initMap();
                    } else {
                        this.mapInstance.invalidateSize();
                        // Paksa map ke posisi marker terakhir saat modal dibuka kembali
                        if (this.initialLat && this.initialLng) {
                            this.mapInstance.setView([this.initialLat, this.initialLng], 15);
                        }
                    }
                });
            }
        });

        // 3. Pantau Tipe Event
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

    loadInitialData() {
        // Ambil data dari old input atau database ($acara)
        const presetLokasi = '{{ old('lokasi', isset($acara) ? $acara->lokasi : '') }}';
        let initialType = '{{ old('tipe_event') }}';

        // Logika penentuan tipe event
        if (!initialType) {
            // Jika lokasi URL -> online, jika teks biasa -> offline, default offline
            if (presetLokasi) {
                initialType = presetLokasi.startsWith('http') ? 'online' : 'offline';
            } else if ('{{ isset($acara) ? $acara->is_online : '' }}' == '1') {
                initialType = 'online';
            } else {
                initialType = 'offline';
            }
        }

        this.finalEventType = initialType;
        this.eventType = this.finalEventType;
        this.finalLocation = presetLokasi;

        // Set input values berdasarkan tipe
        if (this.finalEventType === 'online') {
            this.tempLink = presetLokasi;
        } else {
            this.tempAddress = presetLokasi;
        }

        // --- PENTING: Ambil Koordinat ---
        const oldLat = '{{ old('latitude', isset($acara) ? $acara->latitude : '') }}';
        const oldLng = '{{ old('longitude', isset($acara) ? $acara->longitude : '') }}';
        const venue = '{{ old('venue', isset($acara) ? $acara->venue : '') }}';

        this.tempVenue = venue;

        if (oldLat && oldLng) {
            this.initialLat = parseFloat(oldLat);
            this.initialLng = parseFloat(oldLng);
            this.tempCoordinates = `${this.initialLat.toFixed(6)}, ${this.initialLng.toFixed(6)}`;

            // Jika alamat masih kosong tapi koordinat ada, pancing reverse geocode
            if (!this.tempAddress || this.tempAddress === '') {
                this.reverseGeocode(this.initialLat, this.initialLng);
            }
        }
    },

    initMap() {
        // Koordinat Default (Jakarta) jika tidak ada data
        const defaultLat = -6.200000;
        const defaultLng = 106.816666;

        // Gunakan initialLat/Lng jika ada, jika tidak gunakan default
        const lat = this.initialLat ?? defaultLat;
        const lng = this.initialLng ?? defaultLng;
        const zoomLevel = this.initialLat ? 16 : 13; // Zoom lebih dekat jika sudah ada lokasi

        // Cegah re-inisialisasi jika map sudah ada
        if (this.mapInstance) return;

        // Render Map
        this.mapInstance = L.map('map').setView([lat, lng], zoomLevel);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(this.mapInstance);

        // Render Marker
        this.markerInstance = L.marker([lat, lng], { draggable: true }).addTo(this.mapInstance);

        // Update input hidden saat init (agar sinkron)
        if (this.initialLat) {
            this.updateCoordinates(lat, lng, false); // false = jangan panggil API address lagi kalau cuma init
        }

        // Listener: Drag Marker
        this.markerInstance.on('dragend', (e) => {
            const position = e.target.getLatLng();
            this.updateCoordinates(position.lat, position.lng);
        });

        // Listener: Klik Map
        this.mapInstance.on('click', (e) => {
            this.markerInstance.setLatLng(e.latlng);
            this.updateCoordinates(e.latlng.lat, e.latlng.lng);
        });
    },

    updateCoordinates(lat, lng, fetchAddress = true) {
        // Update State
        this.initialLat = lat;
        this.initialLng = lng;
        this.tempCoordinates = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;

        // Update DOM Input Hidden
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        if (fetchAddress) {
            this.tempAddress = 'Mencari alamat...';
            clearTimeout(this.geocodeTimeout);
            this.geocodeTimeout = setTimeout(() => {
                this.reverseGeocode(lat, lng);
            }, 500);
        }
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
            this.tempAddress = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        }
    },

    saveLocation() {
        this.finalEventType = this.eventType;

        if (this.eventType === 'offline') {
            // Prioritaskan alamat text, fallback ke koordinat
            this.finalLocation = this.tempAddress || this.tempCoordinates;
            document.getElementById('lokasi').value = this.finalLocation;
            document.getElementById('venue').value = this.tempVenue;
        } else {
            this.finalLocation = this.tempLink;
            document.getElementById('lokasi').value = this.tempLink;
            document.getElementById('venue').value = '';
        }

        document.getElementById('is_online').value = this.finalEventType === 'online' ? '1' : '0';
        this.showLocationModal = false;

        // Notify global script so it can re-check form validity (enables Publish)
        const lokasiEl = document.getElementById('lokasi');
        if (lokasiEl) {
            lokasiEl.dispatchEvent(new Event('input', { bubbles: true }));
        }
        window.dispatchEvent(new Event('location-updated'));
    }
}">

    <label class="mb-2 block text-sm font-medium text-gray-700">
        Lokasi Acara <span class="text-red-400">*</span>
        {{-- @if (isset($acara) && $acara->status === 'published')
            <span class="ml-2 inline-block px-2 py-1 text-xs font-semibold text-orange-700 bg-orange-100 rounded">
                Tidak bisa diubah (Acara Published)
            </span>
        @endif --}}
    </label>

    <input type="hidden" name="tipe_event" x-model="finalEventType">
    <input type="hidden" name="lokasi" id="lokasi" value="{{ old('lokasi', isset($acara) ? $acara->lokasi : '') }}">
    <input type="hidden" id="latitude" name="latitude"
        value="{{ old('latitude', isset($acara) ? $acara->latitude : '') }}">
    <input type="hidden" id="longitude" name="longitude"
        value="{{ old('longitude', isset($acara) ? $acara->longitude : '') }}">
    <input type="hidden" id="is_online" name="is_online"
        value="{{ old('is_online', isset($acara) ? ($acara->is_online ? '1' : '0') : '0') }}">
    <input type="hidden" id="venue" name="venue" value="{{ old('venue', isset($acara) ? $acara->venue : '') }}">



    <div class="flex items-start gap-3" :class="{ 'opacity-60 pointer-events-none': isPublished }">
        <div class="shrink-0 mt-0.5 text-gray-500">
            <svg x-show="finalEventType === 'offline'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                    clip-rule="evenodd" />
            </svg>
            <svg x-show="finalEventType === 'online'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                viewBox="0 0 20 20" fill="currentColor">
                <path
                    d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
            </svg>
        </div>

        <div class="min-w-0">
            <div class="space-y-1">
                <!-- Lokasi/Link -->
                <p class="text-gray-900 font-medium text-sm leading-relaxed line-clamp-1"
                    x-text="finalLocation && finalLocation.length > 50 ? finalLocation.substring(0, 50) + '...' : (finalLocation || 'Belum ada lokasi dipilih')">
                </p>

                <!-- Badge Tipe Event -->
                <div class="flex items-center gap-2 mb-2">
                    <span x-show="finalEventType === 'offline'"
                        class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd" />
                        </svg>
                        Lokasi Offline
                    </span>
                    <span x-show="finalEventType === 'online'"
                        class="inline-flex items-center gap-1 px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                        </svg>
                        Event Online
                    </span>
                    <span x-show="!finalEventType || finalEventType === ''"
                        class="inline-flex items-center gap-1 px-2 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd" />
                        </svg>
                        Belum Diatur
                    </span>
                </div>

                <!-- Venue untuk Offline Event -->
                <div x-show="finalEventType === 'offline' && tempVenue"
                    class="flex items-center justify-center gap-2 p-2 bg-gray-50 rounded-lg border border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        class="text-indigo-500" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-building2-icon lucide-building-2">
                        <path d="M10 12h4" />
                        <path d="M10 8h4" />
                        <path d="M14 21v-3a2 2 0 0 0-4 0v3" />
                        <path d="M6 10H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2" />
                        <path d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16" />
                    </svg>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs text-gray-500 font-medium">Venue</p>
                        <p class="text-sm text-gray-700 font-medium" x-text="tempVenue"></p>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" @click="showLocationModal = true" :disabled="isPublished"
            :class="{ 'opacity-50 cursor-not-allowed': isPublished }"
            class="shrink-0 text-blue-600 hover:text-blue-800 transition-colors p-1 disabled:hover:text-blue-600"
            title="Ubah Lokasi">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                <path d="m15 5 4 4" />
            </svg>
        </button>
    </div>

    <!-- Modal -->
    <div x-show="showLocationModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/80">
        <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto" @click.stop>

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-900">Atur Lokasi Acara</h3>
                <button type="button" @click="showLocationModal = false" class="text-gray-400 hover:text-gray-500"
                    :disabled="isPublished">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex p-1 bg-gray-100 rounded-lg mb-6 w-full"
                :class="{ 'opacity-50 pointer-events-none': isPublished }">
                <button type="button" @click="eventType = 'offline'" :disabled="isPublished"
                    :class="eventType === 'offline' ? 'bg-white text-blue-600 shadow-sm' :
                        'text-gray-500 hover:text-gray-700'"
                    class="flex-1 px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 flex justify-center items-center gap-2 disabled:cursor-not-allowed">
                    Offline
                </button>
                <button type="button" @click="eventType = 'online'" :disabled="isPublished"
                    :class="eventType === 'online' ? 'bg-white text-blue-600 shadow-sm' :
                        'text-gray-500 hover:text-gray-700'"
                    class="flex-1 px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 flex justify-center items-center gap-2 disabled:cursor-not-allowed">
                    Online
                </button>
            </div>

            <div x-show="eventType === 'offline'">
                <div id="map" class="w-full h-80 rounded-lg border border-gray-300 mb-4 z-10">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Detail Alamat</label>
                    <textarea x-model="tempAddress" readonly rows="2" :disabled="isPublished"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-sm resize-none text-gray-600 disabled:opacity-50"></textarea>
                </div>
                <!-- Input Venue Manual di Modal -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Venue</label>
                    <input type="text" x-model="tempVenue" :disabled="isPublished"
                        placeholder="Masukkan nama venue (mis: Gedung Serbaguna)"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                </div>
            </div>

            <div x-show="eventType === 'online'">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Peraturan Event Online</label>
                    <ul class="space-y-2 mb-6 text-sm text-gray-600">
                        <li class="flex items-start gap-2">
                            <span class="text-blue-500 font-bold mt-0.5">1.</span>
                            <span>Pastikan link streaming aktif dan dapat diakses</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-blue-500 font-bold mt-0.5">2.</span>
                            <span>Gunakan platform streaming yang terpercaya (Zoom, Google Meet, YouTube Live,
                                dll)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-blue-500 font-bold mt-0.5">3.</span>
                            <span>Verifikasi link sebelum menyimpan untuk memastikan aksesibilitas</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-blue-500 font-bold mt-0.5">4.</span>
                            <span>Link harus valid dan terbuka untuk peserta pada waktu acara</span>
                        </li>
                    </ul>

                    <label class="block text-sm font-medium text-gray-700 mb-1">Link Streaming</label>
                    <input type="url" x-model="tempLink" :disabled="isPublished" placeholder="https://..."
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" @click="showLocationModal = false"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</button>
                <button type="button" @click="saveLocation()" :disabled="isPublished"
                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 disabled:bg-blue-300 disabled:cursor-not-allowed text-white rounded-lg text-sm font-medium">Simpan</button>
            </div>
        </div>
    </div>
</div>
