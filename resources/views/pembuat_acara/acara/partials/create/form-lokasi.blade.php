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

        // 3. Muat nilai lama (old) jika ada
        this.$nextTick(() => {
            // tipe event
            this.finalEventType = '{{ old('tipe_event', 'offline') }}';
            this.eventType = this.finalEventType;

            // lokasi (bisa berupa alamat atau link)
            const oldLokasi = '{{ old('lokasi', '') }}';
            if (oldLokasi) {
                this.finalLocation = oldLokasi;
                this.tempAddress = oldLokasi;
                document.getElementById('lokasi').value = oldLokasi;
            }

            // koordinat
            const oldLat = '{{ old('latitude', '') }}';
            const oldLng = '{{ old('longitude', '') }}';
            if (oldLat && oldLng) {
                document.getElementById('latitude').value = oldLat;
                document.getElementById('longitude').value = oldLng;
                this.tempCoordinates = oldLat + ', ' + oldLng;
                // set finalLocation ke koordinat jika belum ada alamat
                if (!this.finalLocation) this.finalLocation = this.tempCoordinates;
            }
        });
    },

    initMap() {
        const defaultLat = -6.200000;
        const defaultLng = 106.816666;

        // Jika ada koordinat lama (misal dari old()), gunakan itu sebagai awal
        const latVal = document.getElementById('latitude') ? document.getElementById('latitude').value : '';
        const lngVal = document.getElementById('longitude') ? document.getElementById('longitude').value : '';
        const lat = latVal ? parseFloat(latVal) : defaultLat;
        const lng = lngVal ? parseFloat(lngVal) : defaultLng;

        // Inisialisasi Map (gunakan koordinat awal yang terdeteksi)
        this.mapInstance = L.map('map').setView([lat, lng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(this.mapInstance);

        // Inisialisasi Marker
        this.markerInstance = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(this.mapInstance);

        // Set koordinat awal (sesuaikan jika ada koordinat lama)
        this.updateCoordinates(lat, lng);

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

        <div class="mr-4">
            <p class="text-gray-900 font-medium" x-text="finalLocation || 'Belum ada lokasi dipilih'"></p>
            <p class="text-gray-500 text-sm mt-0.5"
                x-text="finalEventType === 'offline' ? 'Lokasi Offline' : (finalEventType === 'online' ? 'Event Online' : 'Silakan atur lokasi')">
            </p>
        </div>

        <button type="button" @click="showLocationModal = true"
            class="shrink-0 text-blue-600 hover:text-blue-800 transition-colors p-1" title="Ubah Lokasi">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                <path d="m15 5 4 4" />
            </svg>
        </button>
    </div>

    <div x-show="showLocationModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/80">
        <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-900">Atur Lokasi Acara</h3>
                <button type="button" @click="showLocationModal = false" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                <div id="map" class="w-full h-80 rounded-lg border border-gray-300 mb-4 z-10">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Detail
                        Alamat</label>
                    <textarea x-model="tempAddress" readonly rows="2"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-sm resize-none text-gray-600"></textarea>
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
