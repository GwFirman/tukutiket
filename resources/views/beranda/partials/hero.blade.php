<!-- Hero Section with Background Image -->
<div class="relative w-full py-12 md:py-20 overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/concert.jpg') }}" alt="Concert Background" class="w-full h-full object-cover">
        <!-- Overlay Gradient -->
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-900/90 via-purple-900/80 to-indigo-900/70"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center lg:flex-row lg:justify-between">
            <div class="w-full text-center lg:text-left mb-8 lg:mb-0">
                <div
                    class="inline-flex items-center bg-white/20 backdrop-blur-sm text-white px-3 py-1.5 sm:px-4 sm:py-2 rounded-full mb-4 sm:mb-6 animate-fade-in">
                    <i data-lucide="sparkles" class="w-3 h-3 sm:w-4 sm:h-4 mr-1.5 sm:mr-2"></i>
                    <span class="text-xs sm:text-sm font-semibold">Indonesia's #1 Ticketing Platform</span>
                </div>
                <h1
                    class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 sm:mb-6 leading-tight animate-fade-in-up">
                    <span class="block">Temukan & Beli Tiket Acara dengan Mudah di</span>
                    <span
                        class="bg-gradient-to-b from-white-400 via-indigo-200 to-purple-300 bg-clip-text text-transparent">
                        TukuTiket
                    </span>
                </h1>
                <p
                    class="text-base sm:text-lg md:text-xl text-gray-200 mb-6 sm:mb-8 leading-relaxed animate-fade-in-up animation-delay-200 px-4 sm:px-0">
                    Dari konser seru sampai event edukatif — semua ada di satu tempat!
                </p>

                <!-- Search Bar with Filters -->
                <form action="{{ route('beranda') }}" method="GET"
                    class="animate-fade-in-up animation-delay-300 px-2 sm:px-0" x-data="{ filterOpen: false }">
                    <div class="bg-white rounded-xl sm:rounded-2xl shadow-xl p-2 flex gap-2">
                        <!-- Search Input -->
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-3 sm:left-4 flex items-center pointer-events-none">
                                <i data-lucide="search" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari acara, konser, workshop..."
                                class="w-full pl-10 sm:pl-12 pr-4 py-3 sm:py-4 rounded-lg sm:rounded-xl border-0 focus:ring-2 focus:ring-indigo-500 text-gray-700 placeholder-gray-400 text-sm sm:text-base">
                        </div>

                        <!-- Mobile Filter Button -->
                        <button type="button" @click="filterOpen = !filterOpen"
                            class="sm:hidden bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold py-3 px-4 rounded-lg transition-all duration-300 flex items-center justify-center gap-2">
                            <i data-lucide="sliders-horizontal" class="w-5 h-5"></i>
                        </button>

                        <!-- Desktop Filters -->
                        <div class="hidden sm:flex gap-2">
                            <!-- Location Filter -->
                            <div class="relative flex-1">
                                <div class="absolute inset-y-0 left-3 sm:left-4 flex items-center pointer-events-none">
                                    <i data-lucide="map-pin" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400"></i>
                                </div>
                                <select name="lokasi"
                                    class="w-full pl-10 sm:pl-12 pr-8 sm:pr-10 py-3 sm:py-4 rounded-lg sm:rounded-xl border-0 bg-gray-50 focus:ring-2 focus:ring-indigo-500 text-gray-700 appearance-none cursor-pointer text-sm sm:text-base">
                                    <option value="">Semua Lokasi</option>
                                    @foreach ($lokasis ?? [] as $lokasi)
                                        <option value="{{ $lokasi }}"
                                            {{ request('lokasi') == $lokasi ? 'selected' : '' }}>
                                            {{ $lokasi }}
                                        </option>
                                    @endforeach
                                </select>
                                <div
                                    class="absolute inset-y-0 right-2 sm:right-3 flex items-center pointer-events-none">
                                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                                </div>
                            </div>

                            <!-- Date Filter -->
                            <div class="relative flex-1 sm:max-w-[200px]">
                                <div
                                    class="absolute inset-y-0 left-3 sm:left-4 flex items-center pointer-events-none z-10">
                                    <i data-lucide="calendar" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400"></i>
                                </div>
                                <input type="text" name="tanggal" id="tanggal-filter"
                                    value="{{ request('tanggal') }}" placeholder="Pilih Tanggal"
                                    class="w-full pl-10 sm:pl-12 pr-4 py-3 sm:py-4 rounded-lg sm:rounded-xl border-0 bg-gray-50 focus:ring-2 focus:ring-indigo-500 text-gray-700 placeholder-gray-400 cursor-pointer text-sm sm:text-base"
                                    readonly>
                            </div>

                            <!-- Search Button -->
                            <button type="submit"
                                class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-2 sm:py-2 px-6 sm:px-8 rounded-lg sm:rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 text-sm sm:text-base">
                                <i data-lucide="search" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile Filter Panel -->
                    <div x-show="filterOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="sm:hidden mt-3 bg-white rounded-xl shadow-lg p-4 space-y-3" style="display: none;">
                        <!-- Location Filter Mobile -->
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                    <i data-lucide="map-pin" class="w-4 h-4 text-gray-400"></i>
                                </div>
                                <select name="lokasi"
                                    class="w-full pl-10 pr-8 py-3 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-indigo-500 text-gray-700 appearance-none cursor-pointer text-sm">
                                    <option value="">Semua Lokasi</option>
                                    @foreach ($lokasis ?? [] as $lokasi)
                                        <option value="{{ $lokasi }}"
                                            {{ request('lokasi') == $lokasi ? 'selected' : '' }}>
                                            {{ $lokasi }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Date Filter Mobile -->
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none z-10">
                                    <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
                                </div>
                                <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                                    placeholder="Pilih Tanggal"
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-indigo-500 text-gray-700 placeholder-gray-400 text-sm">
                            </div>
                        </div>

                        <!-- Apply Button -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                            <i data-lucide="search" class="w-4 h-4"></i>
                            Terapkan Filter
                        </button>
                    </div>

                    <!-- Quick Filter Tags -->
                    <div class="flex flex-wrap gap-2 mt-3 sm:mt-4 justify-center px-2 sm:px-0">
                        <a href="{{ route('beranda', ['search' => 'konser']) }}"
                            class="px-2.5 py-1 sm:px-3 sm:py-1.5 bg-white/80 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-full text-xs sm:text-sm transition-colors flex items-center gap-1 sm:gap-1.5">
                            <i data-lucide="music" class="w-3 h-3 sm:w-4 sm:h-4"></i>
                            Konser
                        </a>
                        <a href="{{ route('beranda', ['search' => 'workshop']) }}"
                            class="px-2.5 py-1 sm:px-3 sm:py-1.5 bg-white/80 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-full text-xs sm:text-sm transition-colors flex items-center gap-1 sm:gap-1.5">
                            <i data-lucide="briefcase" class="w-3 h-3 sm:w-4 sm:h-4"></i>
                            Workshop
                        </a>
                        <a href="{{ route('beranda', ['search' => 'seminar']) }}"
                            class="px-2.5 py-1 sm:px-3 sm:py-1.5 bg-white/80 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-full text-xs sm:text-sm transition-colors flex items-center gap-1 sm:gap-1.5">
                            <i data-lucide="mic" class="w-3 h-3 sm:w-4 sm:h-4"></i>
                            Seminar
                        </a>
                        <a href="{{ route('beranda', ['search' => 'festival']) }}"
                            class="px-2.5 py-1 sm:px-3 sm:py-1.5 bg-white/80 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-full text-xs sm:text-sm transition-colors flex items-center gap-1 sm:gap-1.5">
                            <i data-lucide="party-popper" class="w-3 h-3 sm:w-4 sm:h-4"></i>
                            Festival
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Flatpickr untuk filter tanggal di beranda
            const tanggalFilter = document.getElementById('tanggal-filter');
            if (tanggalFilter) {
                flatpickr(tanggalFilter, {
                    enableTime: false,
                    dateFormat: "Y-m-d",
                    altInput: true,
                    altFormat: "d M Y",
                    allowInput: false,
                    disableMobile: true,
                    locale: {
                        firstDayOfWeek: 1,
                        weekdays: {
                            shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                            longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
                        },
                        months: {
                            shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep',
                                'Okt', 'Nov', 'Des'
                            ],
                            longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                                'Agustus', 'September', 'Oktober', 'November', 'Desember'
                            ]
                        }
                    }
                });
            }

            // Flatpickr default untuk class .datepicker
            flatpickr(".datepicker", {
                enableTime: false,
                dateFormat: "Y-m-d",
            });
        });
    </script>
</div>
