<div class="bg-gradient-to-b from-white to-indigo-50 ">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 md:mb-16">
            <div
                class="inline-flex items-center bg-indigo-100 text-indigo-800 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full mb-3 sm:mb-4">
                <i data-lucide="calendar-check" class="w-3 h-3 sm:w-4 sm:h-4 mr-1.5 sm:mr-2"></i>
                <span class="text-xs sm:text-sm font-semibold">Hot event </span>
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
                    class="group bg-white shadow-2xs rounded-lg overflow-hidden  block">
                    <div class="relative overflow-hidden">
                        @if ($acara->banner_acara && file_exists(storage_path('app/public/' . $acara->banner_acara)))
                            <img src="{{ asset('storage/' . $acara->banner_acara) }}"
                                alt="{{ $acara->nama_acara ?? 'Event' }}"
                                class="w-full h-40 sm:h-48 md:h-56 object-cover ">
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
                        <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-900 mb-2 sm:mb-3 line-clamp-2 ">
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
                                    class="text-xl sm:text-2xl font-bold bg-indigo-600  bg-clip-text text-transparent">
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
            <a href="{{ route('acara.index') }}"
                class="inline-block bg-indigo-100 hover:bg-indigo-200 text-indigo-800 font-semibold py-3 px-6 rounded-lg transition duration-300">
                View All Events
            </a>
        </div> --}}
    </div>
</div>
