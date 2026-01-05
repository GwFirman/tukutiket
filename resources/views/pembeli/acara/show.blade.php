<x-guest-layout>
    <div class="relative min-h-screen ">
        <!-- Background Banner -->
        <div class="absolute inset-0 z-0">
            @if ($acara->banner_acara)
                <img src="{{ asset('storage/' . $acara->banner_acara) }}" alt="Banner Acara"
                    class="w-full h-64 sm:h-80 lg:h-96 object-cover">
                <div class="absolute inset-0 backdrop-blur-sm h-64 sm:h-80 lg:h-96"></div>
            @else
                <div class="w-full h-64 sm:h-80 lg:h-96 bg-gray-400"></div>
            @endif
            <!-- Gradient overlay -->
            <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-black/40 to-white h-64 sm:h-80 lg:h-96">
            </div>
        </div>

        <!-- Content -->
        <div class="relative z-10">
            <!-- Mobile header -->
            {{-- <div class="sticky top-0 z-20 px-4 py-4 bg-white sm:px-6 border-b lg:hidden">
                <button @click="sidebarOpen = true"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div> --}}

            <!-- Main content -->
            <main class="max-w-7xl mx-auto">

                <div class="py-6 sm:py-8 lg:py-12 px-4 sm:px-6 ">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-6">
                        <!-- Main Content Card -->
                        <div class="lg:col-span-8">
                            <div class="bg-white shadow-lg sm:rounded-lg p-4 sm:p-6">
                                <!-- Banner -->
                                <div
                                    class="h-48 sm:h-56 lg:h-64 w-full border-2 border-gray-200 border-dashed rounded-lg flex items-center justify-center overflow-hidden bg-gray-50">
                                    @if ($acara->banner_acara)
                                        <img src="{{ asset('storage/' . $acara->banner_acara) }}" alt="Banner Acara"
                                            class="h-full w-full object-cover rounded-lg">
                                    @else
                                        <span class="text-gray-400 text-sm">Belum ada banner acara</span>
                                    @endif
                                </div>

                                <!-- Judul -->
                                <div class="text-gray-900 mt-4 font-semibold text-xl sm:text-2xl lg:text-3xl">
                                    {{ $acara->nama_acara }}
                                </div>

                                @if ($alreadyBought ?? false)
                                    <div
                                        class="my-3 rounded-md bg-yellow-50 border-l-4 border-yellow-400 p-3 text-yellow-700 text-sm">
                                        Kamu sudah membeli tiket untuk acara ini.
                                    </div>
                                @endif


                                <!-- Deskripsi -->
                                <div class="text-gray-600 mt-4 text-sm sm:text-base">
                                    {!! $acara->deskripsi !!}
                                </div>

                                <div class="border-t border-gray-200 my-6"></div>

                                <!-- Informasi Tiket Header -->
                                <div class="text-gray-600 mt-4 font-medium text-lg sm:text-xl">
                                    <i data-lucide="ticket" class="inline mr-2"></i> Informasi Tiket
                                </div>

                                <!-- Tiket List -->
                                <div class="grid grid-cols-1 gap-4 mt-6">
                                    @foreach ($acara->jenisTiket as $tiket)
                                        <div class="ticket-container">
                                            <div class="rounded-lg overflow-hidden transition-all">
                                                <!-- Ticket Header -->
                                                <div
                                                    class="bg-gradient-to-r from-indigo-50 to-gray-50 p-3 sm:p-4 relative">
                                                    <!-- Ticket stub design -->
                                                    <div
                                                        class="absolute top-0 left-0 h-full w-3 bg-indigo-500 flex items-center justify-center">
                                                        <div class="h-8 w-4 rounded-tr-md rounded-br-md bg-white"></div>
                                                    </div>

                                                    <div
                                                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center ml-5 gap-2">
                                                        <div class="w-full">
                                                            <!-- Header Info -->
                                                            <div
                                                                class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                                                                <div class="flex items-center gap-2">
                                                                    <i data-lucide="ticket"
                                                                        class="h-4 w-4 sm:h-5 sm:w-5 text-indigo-500"></i>
                                                                    <h3
                                                                        class="font-semibold text-base sm:text-lg text-gray-800">
                                                                        {{ $tiket->nama_jenis }}
                                                                    </h3>
                                                                </div>
                                                                <p
                                                                    class="text-gray-500 text-xs sm:text-sm whitespace-nowrap">
                                                                    Berakhir
                                                                    {{ \Carbon\Carbon::parse($tiket->penjualan_selesai)->translatedFormat('d F Y') }}
                                                                </p>
                                                            </div>

                                                            <!-- Price & Quota -->
                                                            <div
                                                                class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mt-3">
                                                                <p class="text-indigo-600 font-bold text-lg sm:text-xl">
                                                                    @if ($tiket->harga == 0)
                                                                        Gratis
                                                                    @else
                                                                        Rp
                                                                        {{ number_format($tiket->harga, 0, ',', '.') }}
                                                                    @endif
                                                                </p>
                                                                <p
                                                                    class="text-indigo-600 py-1 px-3 sm:px-4 font-medium border-2 border-blue-500 rounded-full text-xs sm:text-sm bg-blue-50">
                                                                    Kuota: {{ $tiket->kuota }}
                                                                </p>
                                                            </div>

                                                            <!-- Detail Button -->
                                                            <button type="button"
                                                                onclick="toggleTicketDetails('ticket-{{ $tiket->id }}')"
                                                                class="mt-3 text-xs sm:text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                                                                Lihat Detail
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-3 w-3 sm:h-4 sm:w-4 ml-1" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M19 9l-7 7-7-7" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Ticket Details (Hidden by default) -->
                                                <div id="ticket-{{ $tiket->id }}" class="hidden">
                                                    <div class="border-t border-dashed border-gray-300 relative">
                                                        <div
                                                            class="absolute left-0 top-0 w-3 h-3 bg-white rounded-full -mt-1.5 -ml-1.5">
                                                        </div>
                                                        <div
                                                            class="absolute right-0 top-0 w-3 h-3 bg-white rounded-full -mt-1.5 -mr-1.5">
                                                        </div>
                                                    </div>

                                                    <div class="p-3 sm:p-4 bg-white">
                                                        <div
                                                            class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 text-base">
                                                            <div class="p-2 bg-gray-50 rounded">
                                                                <p class="text-gray-500 text-xs">Penjualan Mulai</p>
                                                                <p class="font-medium flex items-center text-base">
                                                                    <i data-lucide="calendar"
                                                                        class="h-3 w-3 mr-1 text-indigo-400"></i>
                                                                    {{ \Carbon\Carbon::parse($tiket->penjualan_mulai)->locale('id')->translatedFormat('d F Y') }}
                                                                    {{-- {{ \Carbon\Carbon::parse($tiket->penjualan_mulai)->format('d M Y') }} --}}
                                                                </p>
                                                            </div>

                                                            <div class="p-2 bg-gray-50 rounded">
                                                                <p class="text-gray-500 text-xs">Penjualan Selesai</p>
                                                                <p class="font-medium flex items-center text-base">
                                                                    <i data-lucide="calendar"
                                                                        class="h-3 w-3 mr-1 text-indigo-400"></i>
                                                                    {{-- {{ \Carbon\Carbon::parse($tiket->penjualan_selesai)->format('d-m-Y') }}
                                                                     --}}
                                                                    {{ \Carbon\Carbon::parse($tiket->penjualan_selesai)->locale('id')->translatedFormat('d F Y') }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="mt-3 p-2 bg-gray-50 rounded">
                                                            <p class="text-gray-500 text-xs mb-1">Deskripsi Tiket</p>
                                                            <p class="text-base">
                                                                {{ $tiket->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar Info -->
                        <div class="lg:col-span-4">
                            <div
                                class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-4 sm:p-6 lg:sticky lg:top-24 lg:self-start">
                                <!-- Kreator Info -->
                                <div class="flex items-center gap-3">
                                    {{-- Logo --}}
                                    @if ($acara->kreator && $acara->kreator->logo)
                                        <img src="{{ Storage::url($acara->kreator->logo) }}"
                                            alt="{{ $acara->kreator->nama_kreator }}"
                                            class="h-12 w-12 sm:h-14 sm:w-14 rounded-full object-cover border-2 border-indigo-100 shadow-md">
                                    @else
                                        <div
                                            class="h-12 w-12 sm:h-14 sm:w-14 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-white shadow-md">
                                            <i data-lucide="user" class="size-6 sm:size-7"></i>
                                        </div>
                                    @endif

                                    {{-- Nama Kreator --}}
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-gray-500 uppercase tracking-wide">Penyelenggara</p>
                                        <h3 class="font-semibold text-gray-900 text-sm sm:text-base truncate">
                                            {{ $acara->kreator->nama_kreator ?? 'Penyelenggara Tidak Ditemukan' }}
                                        </h3>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 my-5"></div>

                                <!-- Waktu Pelaksanaan -->
                                <div class="space-y-3">
                                    <p class="text-gray-900 font-semibold text-sm sm:text-base flex items-center gap-2">
                                        <i data-lucide="calendar-clock" class="size-4 sm:size-5 text-indigo-600"></i>
                                        Waktu Pelaksanaan
                                    </p>
                                    <div class="ml-6 space-y-2 text-xs sm:text-sm text-gray-600">
                                        <div class="flex items-start gap-2">
                                            <span class="text-indigo-600 font-medium">Mulai:</span>
                                            <span>{{ \Carbon\Carbon::parse($acara->waktu_mulai)->translatedFormat('d F Y') }}</span>
                                        </div>
                                        <div class="flex items-start gap-2">
                                            <span class="text-indigo-600 font-medium">Selesai:</span>
                                            <span>{{ \Carbon\Carbon::parse($acara->waktu_selesai)->translatedFormat('d F Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 my-5"></div>

                                <!-- Lokasi -->
                                <div class="space-y-3">
                                    <p class="text-gray-900 font-semibold text-sm sm:text-base flex items-center gap-2">
                                        <i data-lucide="map-pin" class="size-4 sm:size-5 text-indigo-600"></i>
                                        Lokasi
                                    </p>
                                    @if ($acara->is_online)
                                        <div class="ml-6 bg-green-50 border border-green-200 rounded-lg p-3">
                                            <div class="flex items-center gap-2 mb-2">
                                                <i data-lucide="globe" class="size-4 text-green-600"></i>
                                                <span class="text-sm font-semibold text-green-700">Acara Online</span>
                                            </div>
                                            @if ($acara->link_acara)
                                                <p class="text-xs sm:text-sm text-gray-600">
                                                    Link akan dibagikan melalui email sebelum acara dimulai
                                                </p>
                                                <a href="{{ $acara->link_acara }}" target="_blank"
                                                    class="text-xs sm:text-sm text-green-600 hover:text-green-700 font-medium mt-2 flex items-center gap-1">
                                                    {{ $acara->link_acara }}
                                                    <i data-lucide="external-link" class="size-3"></i>
                                                </a>
                                            @else
                                                <p class="text-xs sm:text-sm text-gray-600">
                                                    Link akan diberikan sebelum acara dimulai
                                                </p>
                                            @endif
                                        </div>
                                    @else
                                        <p class="ml-6 text-gray-600 text-xs sm:text-base leading-relaxed">
                                            {{ $acara->lokasi }}
                                        </p>
                                    @endif
                                </div>

                                <div class="border-t border-gray-200 my-5"></div>

                                <!-- Informasi Kontak -->
                                <div class="space-y-3">
                                    <p
                                        class="text-gray-900 font-semibold text-sm sm:text-base flex items-center gap-2">
                                        <i data-lucide="phone" class="size-4 sm:size-5 text-indigo-600"></i>
                                        Informasi Kontak
                                    </p>
                                    <p class="ml-6 text-gray-600 text-xs sm:text-base leading-relaxed">
                                        {{ $acara->no_telp_narahubung }}
                                    </p>
                                </div>

                                <div class="border-t border-gray-200 my-5"></div>

                                <!-- CTA Button -->
                                @if ($alreadyBought ?? false)
                                    <button type="button" disabled aria-disabled="true"
                                        class="w-full text-white font-semibold py-3 px-4 rounded-xl transition duration-200 text-sm sm:text-base shadow-md flex items-center justify-center bg-gray-400 opacity-70 cursor-not-allowed">
                                        <i data-lucide="shopping-cart" class="inline mr-2 size-4"></i>
                                        Beli Tiket Sekarang
                                    </button>
                                @else
                                    <a href="{{ route('pembeli.checkout.show', $acara->slug ?? 1) }}"
                                        class="bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 w-full text-white font-semibold py-3 px-4 rounded-xl transition duration-200 text-sm sm:text-base shadow-md hover:shadow-lg flex items-center justify-center">
                                        <i data-lucide="shopping-cart" class="inline mr-2 size-4"></i>
                                        <p>Beli Tiket Sekarang</p>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function toggleTicketDetails(ticketId) {
            const element = document.getElementById(ticketId);
            if (element.classList.contains('hidden')) {
                element.classList.remove('hidden');
            } else {
                element.classList.add('hidden');
            }
        }
    </script>
</x-guest-layout>
