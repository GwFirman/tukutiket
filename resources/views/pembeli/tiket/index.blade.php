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

    {{-- 
        ALPINE JS DATA
        Kita kirim hasil hitungan PHP ke variable Alpine (countBelum & countSudah)
    --}}
    <div class="px-6 lg:px-24" x-data="{
        activeTab: 'belum_digunakan',
        {{-- Default tab yang aktif --}}
        countBelum: {{ $countBelum }},
        countSudah: {{ $countSudah }}
    }">

        {{-- KONDISI: JIKA USER PUNYA TIKET --}}
        @if ($tiketList->count() > 0)

            {{-- ================= TABS NAVIGATION ================= --}}
            <div class="flex gap-4 mb-8 overflow-x-auto">
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

            {{-- ================= LIST TIKET ================= --}}
            <div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($tiketList as $tiket)
                        @php
                            // 1. Ambil Data Penting
                            $statusDB = $tiket->status_checkin; // 'belum_digunakan' atau 'sudah_digunakan'
                            $acara = $tiket->detailPesanan->jenisTiket->acara;
                            $waktuAcara = \Carbon\Carbon::parse($acara->waktu_mulai);

                            // 2. Cek Kedaluwarsa (Expired)
                            // Expired jika: Waktu sudah lewat DAN statusnya masih 'belum_digunakan'
                            $isExpired = $waktuAcara->isPast() && $statusDB === 'belum_digunakan';

                            // 3. Tentukan Tampilan Badge
                            if ($statusDB === 'sudah_digunakan') {
                                $badgeClass = 'bg-gray-600 text-white';
                                $badgeText = 'Sudah Digunakan';
                            } elseif ($isExpired) {
                                $badgeClass = 'bg-red-500 text-white';
                                $badgeText = 'Kedaluwarsa';
                            } else {
                                $badgeClass = 'bg-green-500 text-white';
                                $badgeText = 'Belum Digunakan';
                            }
                        @endphp

                        {{-- CARD ITEM --}}
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden flex flex-col h-full hover:shadow-xl transition-shadow duration-300"
                            x-show="activeTab === 'all' || activeTab === '{{ $statusDB }}'"
                            x-transition.opacity.duration.300ms>

                            <div class="h-48 bg-gradient-to-br from-blue-500 to-purple-600 relative shrink-0">
                                @if ($acara->banner_acara)
                                    <img src="{{ asset('storage/' . $acara->banner_acara) }}"
                                        alt="{{ $acara->nama_acara }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                        <i data-lucide="image" class="size-10 text-gray-400"></i>
                                    </div>
                                @endif

                                <div class="absolute top-4 right-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold shadow-sm {{ $badgeClass }}">
                                        {{ $badgeText }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-6 flex flex-col flex-1">
                                <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2"
                                    title="{{ $acara->nama_acara }}">
                                    {{ $acara->nama_acara }}
                                </h3>

                                <div class="space-y-3 mb-6 flex-1">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i data-lucide="ticket" class="size-4 mr-2 text-blue-600 shrink-0"></i>
                                        <span
                                            class="truncate font-medium">{{ $tiket->detailPesanan->jenisTiket->nama_jenis }}</span>
                                    </div>

                                    <div class="flex items-center text-sm text-gray-600">
                                        <i data-lucide="user" class="size-4 mr-2 text-blue-600 shrink-0"></i>
                                        <span class="truncate">{{ $tiket->nama_peserta }}</span>
                                    </div>

                                    <div class="flex items-center text-sm text-gray-600">
                                        <i data-lucide="calendar" class="size-4 mr-2 text-blue-600 shrink-0"></i>
                                        <span class="{{ $isExpired ? 'text-red-600 font-medium' : '' }}">
                                            {{ $waktuAcara->format('d M Y, H:i') }}
                                        </span>
                                    </div>

                                    <div class="flex items-center text-sm text-gray-600">
                                        <i data-lucide="map-pin" class="size-4 mr-2 text-blue-600 shrink-0"></i>
                                        <span class="truncate">{{ $acara->lokasi }}</span>
                                    </div>
                                </div>

                                <div class="flex gap-2 mt-auto">
                                    <a href="{{ route('pembeli.tiket.preview', $tiket->id) }}"
                                        class="flex-1 bg-blue-600 text-white text-center py-2.5 rounded-lg hover:bg-blue-700 transition font-medium text-sm flex items-center justify-center gap-2 shadow-sm">
                                        Lihat Detail
                                    </a>

                                    <a href="{{ route('pembeli.tiket.download', $tiket->id) }}"
                                        class="px-4 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition inline-flex items-center justify-center border border-gray-200"
                                        title="Download PDF">
                                        <i data-lucide="download" class="size-5"></i>
                                    </a>

                                    {{-- <a href="{{ route('pembeli.tiket.preview', $tiket->id) }}"
                                        class="px-4 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition inline-flex items-center justify-center border border-gray-200"
                                        title="Priview">
                                        <i data-lucide="eye" class="size-5"></i>
                                    </a> --}}
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
            <div class="py-12 text-center mt-10">
                <div class="max-w-md mx-auto">
                    <div class="bg-gray-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="ticket" class="size-12 text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Tiket</h3>
                    <p class="text-gray-500 mb-6">
                        Anda belum memiliki tiket apapun. Jelajahi acara menarik dan dapatkan tiket Anda sekarang!
                    </p>
                    <a href="{{ route('beranda') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <i data-lucide="search" class="size-5 mr-2"></i>
                        Jelajahi Acara
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
