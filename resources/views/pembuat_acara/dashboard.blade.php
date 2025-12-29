<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i data-lucide="home" class="size-5 text-indigo-600"></i>
            <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
            <p class="font-medium text-gray-700">Dashboard</p>
        </div>
    </x-slot>
    <div class="bg-transparent">
        <div class="px-6 lg:px-24 pb-6 lg:pt-6">
            <!-- Dashboard Header -->
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4">
                <div>
                    <p class="text-sm sm:text-base text-gray-600 flex items-center gap-2">
                        <span>Kelola dan monitor acara Anda</span>
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 w-full sm:w-auto">
                    <div class="hidden sm:block text-xs sm:text-sm text-gray-500">
                        Terakhir diperbarui: {{ now()->format('d M Y') }}
                    </div>
                    <a href="{{ route('pembuat.acara.create') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-5 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold rounded-lg text-sm hover:from-indigo-700 hover:to-indigo-800 transition-colors">
                        <i data-lucide="plus" class="w-4 h-4 sm:w-5 sm:h-5 mr-2"></i>
                        <span>Buat Acara Baru</span>
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div
                    class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div
                    class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-lg flex items-center gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 mb-6 sm:mb-8 p-6 rounded-lg "
                style="background-image: url('{{ asset('images/blue-gradient.jpg') }}'); background-size: cover; background-position: center;">
                <!-- Total Acara -->
                <div class="bg-white/50 backdrop-blur-3xl rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-600">Total Acara</p>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">{{ count($acaras) }}</p>
                        </div>
                        <div class="w-10 h-10 bg-indigo-50 rounded-md flex items-center justify-center">
                            <i data-lucide="calendar" class="w-5 h-5 text-indigo-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Published -->
                <div class="bg-white/50 backdrop-blur-3xl rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-600">Published</p>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">
                                {{ $acaras->where('status', 'published')->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-green-50 rounded-md flex items-center justify-center">
                            <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Draft -->
                <div class="bg-white/50 backdrop-blur-3xl rounded-lg p-4 sm:col-span-2 lg:col-span-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-600">Draft</p>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">
                                {{ $acaras->where('status', 'draft')->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-amber-50 rounded-md flex items-center justify-center">
                            <i data-lucide="clock" class="w-5 h-5 text-amber-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Acara Terbaru Card -->
                @if ($acaraTerbaru)
                    <div
                        class="bg-white col-span-2 rounded-xl transition-all border-2 border-indigo-100 group relative overflow-hidden">
                        <!-- Background Banner -->
                        @if ($acaraTerbaru->banner_acara)
                            <div class="absolute inset-0 z-0">
                                <img src="{{ Storage::url($acaraTerbaru->banner_acara) }}"
                                    alt="{{ $acaraTerbaru->nama_acara }}" class="w-full h-full object-cover">
                                <!-- Overlay Gradient -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-gray-900/80 via-gray-900/60 to-gray-900/40">
                                </div>
                            </div>
                        @else
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-600 z-0">
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="relative z-10 p-3 sm:p-4">
                            <div class="flex justify-between">
                                <div class="flex items-center gap-1.5 sm:gap-2 mb-2 sm:mb-3">
                                    <i data-lucide="calendar-check" class="size-4 sm:size-5 text-white"></i>
                                    <p class="text-xs sm:text-sm text-white font-semibold">Acara Terbaru</p>
                                </div>
                                <a href="{{ route('pembuat.acara.show', $acaraTerbaru->slug) }}"
                                    class="inline-flex items-center gap-1 px-3 sm:px-4 py-1.5 sm:py-2 bg-white/30 backdrop-blur-lg text-white rounded-lg text-xs sm:text-sm font-medium">
                                    Lihat Detail
                                    <i data-lucide="arrow-right" class="size-3.5 sm:size-4"></i>
                                </a>
                            </div>
                            <div class="flex flex-col gap-2 sm:gap-3">
                                <div class="flex-1 min-w-0">
                                    <h3
                                        class="text-lg sm:text-xl lg:text-2xl font-medium text-white mb-1.5 sm:mb-2 line-clamp-2">
                                        {{ $acaraTerbaru->nama_acara }}</h3>
                                    <div class="flex flex-col gap-1.5 sm:gap-2 text-[11px] sm:text-xs text-white/90">
                                        <div class="flex items-center gap-1.5 sm:gap-2">
                                            <i data-lucide="map-pin" class="size-3.5 sm:size-4 flex-shrink-0"></i>
                                            <span class="line-clamp-1">{{ $acaraTerbaru->lokasi }}</span>
                                        </div>
                                        <div class="flex items-center gap-1.5 sm:gap-2">
                                            <i data-lucide="calendar" class="size-3.5 sm:size-4 flex-shrink-0"></i>
                                            <span
                                                class="text-[11px] sm:text-xs">{{ \Carbon\Carbon::parse($acaraTerbaru->waktu_mulai)->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div
                        class="bg-white col-span-2 rounded-xl transition-all border-2 border-gray-200 border-dashed p-4 group relative overflow-hidden">
                        <div class="text-center ">
                            <div
                                class="w-12 h-12 mx-auto mb-2 bg-gray-100 rounded-full flex items-center justify-center">
                                <i data-lucide="calendar-x" class="size-6 text-gray-400"></i>
                            </div>
                            <p class="text-sm text-gray-600 font-medium mb-1">Belum ada acara terbaru</p>
                            {{-- <p class="text-xs text-gray-500">Buat acara pertama Anda sekarang</p> --}}
                            <a href="{{ route('pembuat.acara.create') }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5  text-indigo-500 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors text-xs font-medium">
                                <i data-lucide="plus" class="size-3.5"></i>
                                Buat acara pertama Anda sekarang
                            </a>
                        </div>
                    </div>
                @endif
                <div
                    class="bg-white rounded-lg transition-all border-2 border-indigo-100 p-4 sm:p-6 group relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 sm:w-32 sm:h-32 bg-gradient-to-br from-indigo-50 to-transparent rounded-full -mr-12 -mt-12 sm:-mr-16 sm:-mt-16 opacity-50">
                    </div>
                    <div class="relative flex justify-between items-start">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center mb-1 gap-1.5 sm:gap-2">
                                <p class="text-xs sm:text-sm text-indigo-600 font-semibold">Penjualan</p>
                            </div>
                            <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 mb-1 truncate">
                                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-500">Total Penjualan</p>
                            <div class="flex mt-1.5 sm:mt-2 items-center text-xs text-green-600 font-medium">
                                <i data-lucide="plus" class="w-3 h-3"></i>
                                <p class="ml-0.5">Rp {{ number_format($pendapatanTerbaru, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-lg transition-all border-2 border-indigo-100 group relative overflow-hidden">
                    <div class="px-4 sm:px-6 py-2 sm:py-3">
                        <div
                            class="absolute top-0 right-0 w-24 h-24 sm:w-32 sm:h-32 bg-gradient-to-br from-indigo-50 to-transparent rounded-full -mr-12 -mt-12 sm:-mr-16 sm:-mt-16 opacity-50">
                        </div>
                        <div class="relative flex justify-between items-start">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs sm:text-sm text-indigo-600 font-semibold mb-1">Total Acara</p>
                                <p class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-1">
                                    {{ $totalAcara }}</p>
                                <p class="text-xs text-gray-500">Acara aktif</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="border-t-2 mt-3 sm:mt-4 py-2 border-indigo-100 w-full hover:bg-indigo-50 transition-colors">
                        <a href="{{ route('pembuat.acara.index') }}"
                            class="w-full px-4 text-xs sm:text-sm text-indigo-600 font-semibold flex items-center justify-center gap-1">
                            <span>Lihat Detail</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </div>
</x-app-layout>
