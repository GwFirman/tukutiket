<x-guest-layout>
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
                        class="animate-fade-in-up animation-delay-300 px-2 sm:px-0">
                        <div class="bg-white rounded-xl sm:rounded-2xl shadow-xl p-2 sm:p-3 flex flex-col gap-2">
                            <!-- Search Input -->
                            <div class="flex-1 relative">
                                <div class="absolute inset-y-0 left-3 sm:left-4 flex items-center pointer-events-none">
                                    <i data-lucide="search" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400"></i>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari acara, konser, workshop..."
                                    class="w-full pl-10 sm:pl-12 pr-4 py-3 sm:py-4 rounded-lg sm:rounded-xl border-0 focus:ring-2 focus:ring-indigo-500 text-gray-700 placeholder-gray-400 text-sm sm:text-base">
                            </div>

                            <!-- Filters Row -->
                            <div class="flex flex-col sm:flex-row gap-2">
                                <!-- Location Filter -->
                                <div class="relative flex-1">
                                    <div
                                        class="absolute inset-y-0 left-3 sm:left-4 flex items-center pointer-events-none">
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
                                    class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 sm:py-4 px-6 sm:px-8 rounded-lg sm:rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 text-sm sm:text-base">
                                    <i data-lucide="search" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                                    <span>Cari</span>
                                </button>
                            </div>
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
    </div>

    <!-- Events Section -->
    <div class="bg-gradient-to-b from-white to-indigo-50 py-12 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10 md:mb-16">
                <div
                    class="inline-flex items-center bg-indigo-100 text-indigo-800 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full mb-3 sm:mb-4">
                    <i data-lucide="calendar-check" class="w-3 h-3 sm:w-4 sm:h-4 mr-1.5 sm:mr-2"></i>
                    <span class="text-xs sm:text-sm font-semibold">Hot event</span>
                </div>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 mb-3 sm:mb-4">Acara Mendatang
                </h2>
                <p class="text-gray-600 text-sm sm:text-base md:text-lg max-w-2xl mx-auto px-4">
                    Temukan dan pesan tiket untuk acara-acara menakjubkan di sekitar Anda
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                <!-- Event cards will be looped here -->
                @forelse($acaras ?? [] as $acara)
                    <a href="{{ route('beranda.acara', $acara->slug) }}"
                        class="group bg-white rounded-xl sm:rounded-2xl overflow-hidden transition-all duration-500 hover:shadow-md hover:-translate-y-2 block">
                        <div class="relative overflow-hidden">
                            @if ($acara->banner_acara && file_exists(storage_path('app/public/' . $acara->banner_acara)))
                                <img src="{{ asset('storage/' . $acara->banner_acara) }}"
                                    alt="{{ $acara->nama_acara ?? 'Event' }}"
                                    class="w-full h-40 sm:h-48 md:h-56 object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div
                                    class="w-full h-40 sm:h-48 md:h-56 flex flex-col items-center justify-center bg-gradient-to-br from-indigo-100 to-purple-100">
                                    <i data-lucide="image-off" class="w-12 h-12 sm:w-16 sm:h-16 text-gray-400 mb-2"></i>
                                    <span class="text-gray-500 text-xs sm:text-sm">No Banner Available</span>
                                </div>
                            @endif
                            <div
                                class="absolute top-3 right-3 sm:top-4 sm:right-4 bg-white/90 backdrop-blur-sm px-2 py-0.5 sm:px-3 sm:py-1 rounded-full shadow-lg">
                                <span class="text-xs font-bold text-indigo-600 flex items-center">
                                    <i data-lucide="trending-up" class="w-2.5 h-2.5 sm:w-3 sm:h-3 mr-1"></i>
                                    Hot
                                </span>
                            </div>
                        </div>
                        <div class="p-4 sm:p-5 md:p-6">
                            <h3
                                class="text-base sm:text-lg md:text-xl font-bold text-gray-900 mb-2 sm:mb-3 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                {{ $acara->nama_acara ?? 'Event Name' }}
                            </h3>
                            <div class="space-y-2 sm:space-y-3 mb-4 sm:mb-6">
                                <div class="flex items-center text-gray-600">
                                    <div class="flex items-center text-gray-600">
                                        <span class="text-lg">
                                            {{ $acara->waktu_mulai ? \Carbon\Carbon::parse($acara->waktu_mulai)->locale('id')->format('d F Y') : 'Tanggal TBD' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 mt-2">
                                @if ($acara->kreator && $acara->kreator->logo)
                                    <img src="{{ Storage::url($acara->kreator->logo) }}"
                                        class="h-8 w-8 sm:h-10 sm:w-10 rounded-full object-cover border border-gray-300 shadow-sm">
                                @else
                                    <div
                                        class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                        <i data-lucide="user" class="w-4 h-4 sm:w-6 sm:h-6"></i>
                                    </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-semibold text-gray-900 text-sm sm:text-base truncate">
                                        {{ $acara->kreator->nama_kreator ?? 'Penyelenggara Tidak Ditemukan' }}
                                    </h3>
                                </div>
                            </div>
                            <div
                                class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 pt-3 sm:pt-4 border-t border-gray-100 mt-3 sm:mt-4">
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5 sm:mb-1">Mulai dari</p>
                                    @php
                                        $harga = optional($acara->jenisTiket->first())->harga ?? 0;
                                    @endphp
                                    <span
                                        class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                        @if ($harga == 0)
                                            Gratis
                                        @else
                                            Rp {{ number_format($harga, 0, ',', '.') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-10 sm:py-16">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-full mb-3 sm:mb-4">
                            <i data-lucide="calendar-x" class="w-8 h-8 sm:w-10 sm:h-10 text-gray-400"></i>
                        </div>
                        <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-2">No Events Available</h3>
                        <p class="text-sm sm:text-base text-gray-600">Check back soon for exciting events!</p>
                    </div>
                @endforelse
            </div>

            {{-- <div class="text-center mt-12">
                    <a href="{{ route('acara.index') }}" class="inline-block bg-indigo-100 hover:bg-indigo-200 text-indigo-800 font-semibold py-3 px-6 rounded-lg transition duration-300">
                        View All Events
                    </a>
                </div> --}}
        </div>
    </div>
</x-guest-layout>
