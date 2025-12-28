<x-guest-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Back Button -->
            <a href="{{ route('beranda') }}"
                class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-medium transition-colors mb-8">
                <i data-lucide="arrow-left" class="size-4"></i>
                Kembali ke Beranda
            </a>

            <!-- Main Layout: Profile (Left) + Events (Right) -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Profile Section (Sidebar) -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6 sticky top-24">
                        <div class="flex flex-col items-center text-center">
                            <!-- Logo -->
                            @if ($kreator->logo)
                                <img src="{{ Storage::url($kreator->logo) }}" alt="{{ $kreator->nama_kreator }}"
                                    class="h-32 w-32 rounded-full object-cover border-4 border-indigo-200 shadow-lg mb-4">
                            @else
                                <div
                                    class="h-32 w-32 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center border-4 border-indigo-200 shadow-lg mb-4">
                                    <i data-lucide="user" class="size-16 text-white"></i>
                                </div>
                            @endif

                            <!-- Nama & Email -->
                            <h1 class="text-2xl font-bold text-gray-900">{{ $kreator->nama_kreator }}</h1>
                            <p class="text-sm text-gray-500 mt-1">{{ $kreator->user->email }}</p>

                            <!-- Statistik -->
                            <div class="w-full mt-6 space-y-3">
                                <div class="bg-indigo-50 rounded-lg p-4 border border-indigo-200">
                                    <p class="text-xs text-indigo-600 font-medium uppercase mb-1">Total Acara</p>
                                    <p class="text-2xl font-bold text-indigo-900">{{ $acaras->count() }}</p>
                                </div>
                            </div>

                            <!-- Divider -->
                            <div class="w-full h-px bg-gray-200 my-6"></div>

                            <!-- Deskripsi -->
                            @if ($kreator->deskripsi)
                                <div class="w-full text-left">
                                    <h3
                                        class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-2 flex items-center gap-2">
                                        <i data-lucide="info" class="size-4 text-indigo-600"></i>
                                        Tentang
                                    </h3>
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ $kreator->deskripsi }}</p>
                                </div>
                            @endif

                            <!-- Kontak -->
                            @if ($kreator->kontak)
                                <div class="w-full text-left mt-4">
                                    <h3
                                        class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-2 flex items-center gap-2">
                                        <i data-lucide="phone" class="size-4 text-indigo-600"></i>
                                        Kontak
                                    </h3>
                                    <a href="tel:{{ $kreator->kontak }}"
                                        class="text-sm text-indigo-600 hover:text-indigo-700 font-medium break-all">
                                        {{ $kreator->kontak }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Events Section (Main) -->
                <div class="lg:col-span-3">
                    <!-- Header -->
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                            <i data-lucide="calendar" class="size-8 text-indigo-600"></i>
                            Acara yang Diselenggarakan
                        </h2>
                        <p class="text-gray-600 mt-2">{{ $acaras->count() }} acara yang sedang published</p>
                    </div>

                    @if ($acaras->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ($acaras as $acara)
                                <div
                                    class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden border border-gray-100">
                                    <!-- Banner -->
                                    <div class="h-48 bg-gray-200 overflow-hidden">
                                        @if ($acara->banner_acara)
                                            <img src="{{ asset('storage/' . $acara->banner_acara) }}"
                                                alt="{{ $acara->nama_acara }}"
                                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div
                                                class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-300 to-gray-400">
                                                <i data-lucide="image" class="size-16 text-gray-500"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="p-4">
                                        <!-- Status Badge -->
                                        <div class="flex justify-between items-start mb-2">
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                <i data-lucide="check-circle" class="size-3"></i>
                                                Published
                                            </span>
                                        </div>

                                        <!-- Title -->
                                        <h3
                                            class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 hover:text-indigo-600 transition-colors">
                                            {{ $acara->nama_acara }}
                                        </h3>

                                        <!-- Info -->
                                        <div class="space-y-2 mb-4 text-sm text-gray-600">
                                            <!-- Waktu -->
                                            <div class="flex items-center gap-2">
                                                <i data-lucide="calendar-clock"
                                                    class="size-4 text-indigo-600 flex-shrink-0"></i>
                                                <span>{{ \Carbon\Carbon::parse($acara->waktu_mulai)->locale('id')->translatedFormat('d M Y') }}</span>
                                            </div>

                                            <!-- Lokasi -->
                                            <div class="flex items-center gap-2">
                                                <i data-lucide="map-pin"
                                                    class="size-4 text-indigo-600 flex-shrink-0"></i>
                                                <span class="truncate">
                                                    @if ($acara->is_online)
                                                        Acara Online
                                                    @else
                                                        {{ $acara->lokasi }}
                                                    @endif
                                                </span>
                                            </div>

                                            <!-- Tiket -->
                                            <div class="flex items-center gap-2">
                                                <i data-lucide="ticket"
                                                    class="size-4 text-indigo-600 flex-shrink-0"></i>
                                                <span>
                                                    @if ($acara->jenisTiket->where('harga', 0)->count() > 0)
                                                        Gratis
                                                    @else
                                                        Mulai dari Rp
                                                        {{ number_format($acara->jenisTiket->min('harga'), 0, ',', '.') }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Deskripsi singkat -->
                                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                            {{ strip_tags($acara->deskripsi) }}
                                        </p>

                                        <!-- CTA Button -->
                                        <a href="{{ route('beranda.acara', $acara->slug) }}"
                                            class="w-full inline-block bg-indigo-600 hover:bg-indigo-700 text-white text-center font-semibold py-2.5 px-4 rounded-lg transition-colors">
                                            Lihat Detail & Beli
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="py-16 text-center bg-white rounded-lg border border-gray-100">
                            <div class="inline-block p-4 rounded-full bg-gray-100 mb-4">
                                <i data-lucide="calendar" class="size-12 text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Acara</h3>
                            <p class="text-gray-600">Kreator ini belum menerbitkan acara apapun saat ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
