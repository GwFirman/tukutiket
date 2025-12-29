<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i data-lucide="ticket" class="size-5 text-gray-600"></i>
            <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
            <p class="font-medium">Tiket Saya</p>
        </div>
    </x-slot>

    {{-- 
        LOGIKA HITUNG JUMLAH (PHP)
        Kita hitung di server agar datanya 100% akurat dan tidak nge-bug di frontend 
    --}}
    @php
        // Menghitung jumlah tiket berdasarkan status
        $countBelum = $tiketList->where('status_checkin', 'belum_digunakan')->count();
        $countSudah = $tiketList->where('status_checkin', 'sudah_digunakan')->count();
    @endphp

    <div class="px-6 lg:px-24" x-data="{
        activeTab: 'belum_digunakan',
        {{-- Default tab yang aktif --}}
        countBelum: {{ $countBelum }},
        countSudah: {{ $countSudah }}
    }">

        {{-- ================= TABS NAVIGATION ================= --}}
        <div class="flex gap-4 mb-6 overflow-x-auto">
            {{-- Tab Semua --}}
            <button @click="activeTab = 'all'"
                :class="activeTab === 'all'
                    ?
                    'border-blue-600 text-blue-600' :
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="py-4 px-1 border-b-2 font-medium text-xs md:text-sm transition-colors duration-200 whitespace-nowrap">
                Semua
            </button>

            {{-- Tab Belum Digunakan (Ada Badge Counter Kecil) --}}
            <button @click="activeTab = 'belum_digunakan'"
                :class="activeTab === 'belum_digunakan'
                    ?
                    'border-blue-600 text-blue-600' :
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="py-4 px-1 border-b-2 font-medium text-xs md:text-sm transition-colors duration-200 flex items-center gap-2 whitespace-nowrap">
                Belum Digunakan
                <span x-show="countBelum > 0" x-text="countBelum"
                    class="px-2 py-0.5 rounded-full bg-blue-50 text-xs text-blue-600 font-bold"></span>
            </button>

            {{-- Tab Sudah Digunakan --}}
            <button @click="activeTab = 'sudah_digunakan'"
                :class="activeTab === 'sudah_digunakan'
                    ?
                    'border-blue-600 text-blue-600' :
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="py-4 px-1 border-b-2 font-medium text-xs md:text-sm transition-colors duration-200 whitespace-nowrap">
                Sudah Digunakan
            </button>
        </div>

        {{-- ================= KONDISI: JIKA USER PUNYA TIKET ================= --}}
        @if ($tiketList->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($tiketList as $tiket)
                    @php
                        // 1. Inisialisasi Data
                        $acara = $tiket->detailPesanan->jenisTiket->acara;
                        $jenisTiket = $tiket->detailPesanan->jenisTiket;
                        $waktuAcara = \Carbon\Carbon::parse($acara->waktu_mulai);

                        // 2. Setup Waktu Sekarang & Masa Berlaku
                        $now = \Carbon\Carbon::now();

                        // Parse tanggal mulai (default null jika tidak ada)
                        $berlakuMulai = $jenisTiket->berlaku_mulai
                            ? \Carbon\Carbon::parse($jenisTiket->berlaku_mulai)->startOfDay()
                            : null;

                        // Parse tanggal selesai (PENTING: gunakan endOfDay agar valid sampai jam 23:59 di hari H)
                        $berlakuSampai = $jenisTiket->berlaku_sampai
                            ? \Carbon\Carbon::parse($jenisTiket->berlaku_sampai)->endOfDay()
                            : null;

                        // 3. LOGIKA PENENTUAN STATUS UI
                        // Kita buat variabel baru $uiState untuk menentukan tampilan (bukan mengubah data DB)
                        $statusCheckin = $tiket->status_checkin; // 'belum_digunakan' / 'sudah_digunakan'

                        if ($statusCheckin === 'sudah_digunakan') {
                            $uiState = 'used';
                            $badgeColor = 'bg-gray-600 text-white';
                            $badgeLabel = 'Sudah Digunakan';
                        } elseif ($berlakuSampai && $now->greaterThan($berlakuSampai)) {
                            // Jika sekarang > batas akhir = EXPIRED
                            $uiState = 'expired';
                            $badgeColor = 'bg-red-500 text-white';
                            $badgeLabel = 'Kedaluwarsa';
                        } elseif ($berlakuMulai && $now->lessThan($berlakuMulai)) {
                            // Jika sekarang < batas awal = UPCOMING
                            $uiState = 'upcoming';
                            $badgeColor = 'bg-orange-500 text-white';
                            $badgeLabel = 'Belum Berlaku';
                        } else {
                            // Normal (Active)
                            $uiState = 'active';
                            $badgeColor = 'bg-green-500 text-white';
                            $badgeLabel = 'Siap Digunakan';
                        }
                    @endphp

                    {{-- CARD ITEM --}}
                    {{-- x-show: Filter tab tetap menggunakan status DB asli agar tidak hilang dari list --}}
                    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden flex flex-col h-full duration-300 shadow-sm hover:shadow-md"
                        x-show="activeTab === 'all' || activeTab === '{{ $statusCheckin }}'"
                        x-transition.opacity.duration.300ms>

                        {{-- HEADER GAMBAR --}}
                        <div class="h-48 relative shrink-0">
                            @if ($acara->banner_acara)
                                <img src="{{ asset('storage/' . $acara->banner_acara) }}" alt="{{ $acara->nama_acara }}"
                                    class="w-full h-full object-cover {{ $uiState === 'expired' ? 'grayscale opacity-70' : '' }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                    <i data-lucide="image" class="size-10 text-gray-400"></i>
                                </div>
                            @endif

                            {{-- Overlay Gradient untuk teks agar terbaca (opsional) --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

                            {{-- Badge Status --}}
                            <div class="absolute top-4 right-4">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold shadow-sm {{ $badgeColor }}">
                                    {{ $badgeLabel }}
                                </span>
                            </div>
                        </div>

                        {{-- BODY CARD --}}
                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2"
                                title="{{ $acara->nama_acara }}">
                                {{ $acara->nama_acara }}
                            </h3>

                            <div class="space-y-3 mb-6 flex-1">
                                {{-- Jenis Tiket --}}
                                <div class="flex items-center text-sm text-gray-600">
                                    <i data-lucide="ticket" class="size-4 mr-2 text-blue-600 shrink-0"></i>
                                    <span class="truncate font-medium">{{ $jenisTiket->nama_jenis }}</span>
                                </div>

                                {{-- Nama Peserta --}}
                                <div class="flex items-center text-sm text-gray-600">
                                    <i data-lucide="user" class="size-4 mr-2 text-blue-600 shrink-0"></i>
                                    <span class="truncate">{{ $tiket->nama_peserta }}</span>
                                </div>

                                {{-- Tanggal Acara / Masa Berlaku --}}
                                <div class="flex items-start text-sm text-gray-600">
                                    <i data-lucide="calendar-days"
                                        class="size-4 mr-2 text-blue-600 shrink-0 mt-0.5"></i>
                                    <div class="flex flex-col">
                                        {{-- Tampilkan Tanggal Acara --}}
                                        <span class="font-medium text-gray-800">
                                            {{ $waktuAcara->translatedFormat('d M Y') }}
                                        </span>

                                        {{-- Info Tambahan Masa Berlaku (Jika ada range khusus) --}}
                                        @if ($uiState === 'expired')
                                            <span class="text-xs text-red-500 mt-0.5">
                                                Berlaku s/d {{ $berlakuSampai->translatedFormat('d M Y') }}
                                            </span>
                                        @elseif($uiState === 'upcoming')
                                            <span class="text-xs text-orange-500 mt-0.5">
                                                Berlaku mulai {{ $berlakuMulai->translatedFormat('d M Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Lokasi / Tipe Acara --}}
                                <div class="flex items-center text-sm text-gray-600">
                                    @if ($acara->is_online)
                                        {{-- Jika Online --}}
                                        <i data-lucide="video" class="size-4 mr-2 text-blue-600 shrink-0"></i>
                                        <span class="truncate">Acara Online</span>
                                    @else
                                        {{-- Jika Offline --}}
                                        <i data-lucide="map-pin" class="size-4 mr-2 text-blue-600 shrink-0"></i>
                                        <span class="truncate">{{ $acara->lokasi }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- FOOTER ACTION --}}
                            <div class="flex gap-2 mt-auto">
                                @php
                                    // 1. Ambil Tanggal Hari Ini (Jam di-reset jadi 00:00:00)
                                    $hariIni = \Carbon\Carbon::now()->startOfDay();

                                    // 2. Ambil Tanggal Acara (Jam di-reset jadi 00:00:00)
                                    $tanggalAcara = \Carbon\Carbon::parse($acara->waktu_mulai)->startOfDay();

                                    // 3. LOGIKA SEDERHANA:
                                    // Cek apakah Hari Ini "Kurang Dari" Tanggal Acara.
                                    // Jika Hari Ini == Tanggal Acara, hasilnya FALSE (Berarti tombol AKTIF).
                                    $isBelumHarinya = $hariIni->lessThan($tanggalAcara);

                                    // Setup Disable Status
                                    // Tombol Utama mati jika: Expired ATAU Belum Harinya
                                    $isMainDisabled = $uiState === 'expired' || $isBelumHarinya;

                                    // Tombol Download mati jika: Belum Harinya
                                    $isDownloadDisabled = $isBelumHarinya;
                                @endphp

                                {{-- Tombol Detail / Gunakan --}}
                                <a href="{{ $isMainDisabled ? '#' : route('pembeli.tiket.preview', $tiket->id) }}"
                                    class="flex-1 text-center py-2.5 rounded-lg transition font-medium text-sm flex items-center justify-center gap-2 
        {{ $isMainDisabled
            ? 'bg-gray-100 text-gray-400 cursor-not-allowed border border-gray-200'
            : 'bg-blue-600 text-white hover:bg-blue-700' }}"
                                    @if ($isMainDisabled) onclick="return false;" @endif>

                                    @if ($uiState === 'expired')
                                        Tiket Hangus
                                    @elseif ($isBelumHarinya)
                                        <i data-lucide="lock" class="size-4"></i>
                                        Belum Mulai
                                    @elseif($uiState === 'used')
                                        Lihat Detail
                                    @else
                                        Lihat Tiket
                                    @endif
                                </a>

                                {{-- Tombol Download --}}
                                <a href="{{ $isDownloadDisabled ? '#' : route('pembeli.tiket.download', $tiket->id) }}"
                                    class="px-4 rounded-lg transition inline-flex items-center justify-center border 
        {{ $isDownloadDisabled
            ? 'bg-gray-100 text-gray-400 cursor-not-allowed border-gray-200'
            : 'bg-gray-50 text-gray-700 hover:bg-gray-200 border-gray-200' }}"
                                    @if ($isDownloadDisabled) onclick="return false;" @endif
                                    title="{{ $isDownloadDisabled ? 'Tiket dapat diunduh pada hari acara' : 'Download PDF' }}">

                                    <i data-lucide="{{ $isDownloadDisabled ? 'lock' : 'download' }}"
                                        class="size-5"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ================= EMPTY STATE PER TAB ================= --}}
            {{-- 
                    Logic ini sekarang AMAN dari Bug. 
                    Hanya muncul jika Active Tab sesuai DAN Jumlah Hitungan PHP adalah 0.
                --}}
            <div x-show="(activeTab === 'belum_digunakan' && countBelum === 0) || (activeTab === 'sudah_digunakan' && countSudah === 0)"
                class="text-center py-16" style="display: none;" {{-- Mencegah flicker saat halaman loading --}} x-transition.opacity>

                <div class="inline-block p-4 rounded-full bg-gray-50 mb-4">
                    <i data-lucide="inbox" class="size-10 text-gray-300"></i>
                </div>
                <p class="text-gray-500 font-medium">Tidak ada tiket pada kategori ini.</p>
            </div>

    </div>

    {{-- KONDISI: JIKA USER TIDAK PUNYA TIKET SAMA SEKALI (EMPTY DB) --}}
@else
    <div class="py-12 text-center mt-10 border border-gray-300 rounded-2xl">
        <div class="max-w-md mx-auto">
            <div class="bg-gray-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="ticket" class="size-12 text-gray-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Tiket</h3>
            <p class="text-gray-500 mb-6">
                Anda belum memiliki tiket apapun. Jelajahi acara menarik dan dapatkan tiket Anda sekarang!
            </p>
            <a href="{{ route('beranda') }}"
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg  transition-all duration-300 transform hover:scale-105">
                <i data-lucide="search" class="size-5 mr-2"></i>
                Jelajahi Acara
            </a>
        </div>
    </div>
    @endif
</x-app-layout>
