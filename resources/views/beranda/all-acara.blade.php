<x-guest-layout>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-5">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                            Semua Acara
                        </h1>
                    </div>
                    <a href="{{ route('beranda') }}" class="inline-flex items-center  text-gray-700 font-medium">
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar Filter -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl  p-6 sticky top-4">
                        <h2 class="text-lg font-bold text-gray-900 mb-6">Filter</h2>

                        <form action="{{ route('beranda.all-acara') }}" method="GET" class="space-y-6">
                            <!-- Search -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Acara</label>
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Nama acara..."
                                        class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <i data-lucide="search"
                                        class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                </div>
                            </div>

                            <!-- Location Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                                <div class="relative">
                                    <select name="lokasi"
                                        class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent appearance-none bg-white cursor-pointer">
                                        <option value="">Semua Lokasi</option>
                                        @foreach ($lokasis as $lokasi)
                                            <option value="{{ $lokasi }}"
                                                {{ request('lokasi') == $lokasi ? 'selected' : '' }}>
                                                {{ $lokasi }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i data-lucide="map-pin"
                                        class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></i>
                                    <i data-lucide="chevron-down"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></i>
                                </div>
                            </div>

                            <!-- Date Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                                <div class="relative">
                                    <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                                        class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <i data-lucide="calendar"
                                        class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></i>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="pt-4 flex gap-4 border-t border-gray-200 text-sm">
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-300 flex items-center justify-center gap-2">
                                    <i data-lucide="search" class="w-4 h-4"></i>
                                    Cari
                                </button>
                                <a href="{{ route('beranda.all-acara') }}"
                                    class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg transition-all duration-300 text-center">
                                    Reset Filter
                                </a>
                            </div>
                        </form>

                        <!-- Active Filters -->
                        @if (request('search') || request('tanggal') || request('lokasi'))
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <p class="text-xs font-medium text-gray-600 uppercase mb-3">Filter Aktif</p>
                                <div class="flex flex-wrap gap-2">
                                    @if (request('search'))
                                        <span
                                            class="inline-flex items-center gap-1 bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-medium">
                                            <span>{{ request('search') }}</span>
                                            <a href="{{ route('beranda.all-acara', array_merge(request()->query(), ['search' => null])) }}"
                                                class="hover:text-indigo-900">
                                                <i data-lucide="x" class="w-3 h-3"></i>
                                            </a>
                                        </span>
                                    @endif
                                    @if (request('lokasi'))
                                        <span
                                            class="inline-flex items-center gap-1 bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-medium">
                                            <span>{{ request('lokasi') }}</span>
                                            <a href="{{ route('beranda.all-acara', array_merge(request()->query(), ['lokasi' => null])) }}"
                                                class="hover:text-indigo-900">
                                                <i data-lucide="x" class="w-3 h-3"></i>
                                            </a>
                                        </span>
                                    @endif
                                    @if (request('tanggal'))
                                        <span
                                            class="inline-flex items-center gap-1 bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-medium">
                                            <span>{{ \Carbon\Carbon::parse(request('tanggal'))->format('d M Y') }}</span>
                                            <a href="{{ route('beranda.all-acara', array_merge(request()->query(), ['tanggal' => null])) }}"
                                                class="hover:text-indigo-900">
                                                <i data-lucide="x" class="w-3 h-3"></i>
                                            </a>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    @if ($acaras->count() > 0)
                        <!-- Event Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                            @foreach ($acaras as $acara)
                                <a href="{{ route('beranda.acara', $acara) }}"
                                    class="bg-white rounded-xl shadow-md hover:shadow-xl overflow-hidden transition-all duration-300 transform hover:-translate-y-2 group">
                                    <!-- Event Image -->
                                    <div class="relative h-48 overflow-hidden bg-gray-200">
                                        @if ($acara->gambar)
                                            <img src="{{ asset('storage/' . $acara->gambar) }}"
                                                alt="{{ $acara->nama }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        @else
                                            <div
                                                class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-400 to-purple-500">
                                                <i data-lucide="image" class="w-12 h-12 text-white/50"></i>
                                            </div>
                                        @endif
                                        <!-- Status Badge -->
                                        <div class="absolute top-4 right-4">
                                            <span
                                                class="inline-block bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                                Published
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Event Info -->
                                    <div class="p-4">
                                        <h3
                                            class="text-lg font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors line-clamp-2">
                                            {{ $acara->nama }}
                                        </h3>

                                        <div class="space-y-3 mb-4">
                                            <!-- Date & Time -->
                                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                                <i data-lucide="calendar" class="w-4 h-4 text-indigo-600"></i>
                                                <span>{{ \Carbon\Carbon::parse($acara->waktu_mulai)->format('d M Y') }}</span>
                                            </div>

                                            <!-- Time -->
                                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                                <i data-lucide="clock" class="w-4 h-4 text-indigo-600"></i>
                                                <span>{{ \Carbon\Carbon::parse($acara->waktu_mulai)->format('H:i') }}</span>
                                            </div>

                                            <!-- Location -->
                                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                                <i data-lucide="map-pin" class="w-4 h-4 text-indigo-600"></i>
                                                <span class="line-clamp-1">{{ $acara->lokasi }}</span>
                                            </div>
                                        </div>

                                        <!-- Ticket Info -->
                                        @if ($acara->jenisTiket->count() > 0)
                                            <div class="pt-4 border-t border-gray-200">
                                                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Harga
                                                    Mulai Dari</p>
                                                <p class="text-lg font-bold text-indigo-600">
                                                    Rp
                                                    {{ number_format($acara->jenisTiket->min('harga'), 0, ',', '.') }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-12">
                            {{ $acaras->withQueryString()->links('pagination::tailwind') }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="bg-white rounded-xl  p-12 text-center">
                            <div class="mb-4">
                                <i data-lucide="inbox" class="w-16 h-16 text-gray-400 mx-auto"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Acara Tidak Ditemukan</h3>
                            <p class="text-gray-600 mb-6">
                                Maaf, tidak ada acara yang sesuai dengan filter Anda. Coba ubah kriteria pencarian.
                            </p>
                            {{-- <a href="{{ route('beranda.all-acara') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-lg transition-all duration-300">
                                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                Reset Filter
                            </a> --}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lucide icons initialization
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</x-guest-layout>
