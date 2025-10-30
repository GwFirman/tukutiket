<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 mb-4">
            <i data-lucide="ticket " class="size-5 text-gray-600"></i>
            <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
            <p class="font-medium">Tiket Saya</p>
            <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
            <p class="font-medium">Menunggu Pembayaran</p>
        </div>
    </x-slot>
    <div class="">
        <div class="px-18">
            <div class="">
                <div class="p-6 text-gray-900">
                    @if ($pesanan->count() > 0)
                        @foreach ($pesanan as $p)
                            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                                <!-- Header Section -->
                                <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50">
                                    <div class="flex justify-between items-start">
                                        <div class="flex gap-4 items-center">
                                            <div class="relative">
                                                {{-- <img src="{{ $p->detailPesanan->first()->jenisTiket->acara->banner_acara ? asset('storage/' . $p->detailPesanan->first()->jenisTiket->acara->banner_acara) : asset('images/default-event.jpg') }}"
                                                alt="{{ $p->detailPesanan->first()->jenisTiket->acara->nama_acara }}"
                                                class="w-16 h-16 object-cover rounded-lg shadow-md"> --}}
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-800 mb-1">
                                                    @foreach ($p->detailPesanan as $detail)
                                                        {{ $detail->jenisTiket->acara->nama_acara }}
                                                    @break
                                                @endforeach
                                            </h3>

                                        </div>
                                    </div>
                                    <span
                                        class="px-4 py-2 text-sm font-semibold rounded-full {{ $p->status_pembayaran === 'PAID' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-orange-100 text-orange-700 border border-orange-200' }}">
                                        {{ $p->status_pembayaran === 'paid' ? '✓ Sudah Dibayar' : '⏳ Menunggu Pembayaran' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-6">
                                <div class="flex justify-between mb-2">
                                    <p class="font-medium text-lg text-gray-400">Total Pesanan</p>
                                    <p class="font-bold text-lg ">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</p>
                                </div>
                                <!-- Action Section -->
                                <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                    <a href=""
                                        class="text-blue-600 hover:text-blue-700 font-medium flex items-center gap-2 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        Lihat Detail
                                    </a>
                                    <div class="flex gap-3">
                                        <button
                                            class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-200 font-medium flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                                </path>
                                            </svg>
                                            Hubungi Kreator
                                        </button>
                                        @if ($p->status_pembayaran !== 'paid')
                                            <a href="{{ route('pembeli.pembayaran.show', $p->kode_pesanan) }}"
                                                class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 font-medium shadow-md hover:shadow-lg flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                </svg>
                                                Bayar Sekarang
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Empty State -->
                    <div class=" p-12 text-center">
                        <div class="max-w-md mx-auto">
                            <div
                                class="bg-gray-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Tiket</h3>
                            <p class="text-gray-500 mb-6">
                                Anda belum memiliki tiket apapun. Jelajahi acara menarik dan dapatkan tiket Anda
                                sekarang!
                            </p>
                            <a href="{{ route('beranda') }}"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Jelajahi Acara
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout>
