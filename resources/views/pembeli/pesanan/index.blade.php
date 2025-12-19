<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i data-lucide="ticket" class="size-5 text-gray-600"></i>
            <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
            <p class="font-medium">Pesanan Saya</p>
        </div>
    </x-slot>

    {{-- Inisialisasi Alpine Data untuk Tabs --}}
    <div class="" x-data="{ activeTab: 'all' }">
        <div class="px-6 lg:px-24">

            {{-- ================= TABS NAVIGATION ================= --}}
            <div class="flex flex-wrap gap-4 border-b border-gray-200 mb-6 overflow-x-auto">
                @php
                    $tabs = [
                        'all' => 'Semua',
                        'pending' => 'Menunggu',
                        'paid' => 'Lunas',
                        'failed' => 'Gagal',
                        'expired' => 'Kedaluwarsa',
                    ];
                @endphp

                @foreach ($tabs as $key => $label)
                    <button @click="activeTab = '{{ $key }}'"
                        :class="activeTab === '{{ $key }}'
                            ?
                            'border-blue-600 text-blue-600' :
                            'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <div class="">
                <div class="pb-6 text-gray-900">
                    @if ($pesanan->count() > 0)

                        {{-- Wrapper untuk mengecek apakah ada item yang tampil (untuk empty state filter) --}}
                        <div x-data="{ hasItems: true }"
                            x-effect="
                            // Sedikit magic script untuk mengecek apakah ada kartu yang visible setelah filter
                            setTimeout(() => {
                                const visible = $el.querySelectorAll('.order-card[style*=\'display: block\']').length > 0 || 
                                              $el.querySelectorAll('.order-card:not([style*=\'display: none\'])').length > 0;
                                hasItems = visible;
                            }, 50)
                        ">

                            @foreach ($pesanan as $p)
                                @php
                                    // Normalisasi status agar lowercase (pending, paid, failed, expired)
                                    $status = strtolower($p->status_pembayaran);

                                    // Tentukan warna badge & teks berdasarkan status
                                    $badgeClass = match ($status) {
                                        'paid' => 'bg-green-100 text-green-700 border-green-200',
                                        'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                        'failed' => 'bg-red-100 text-red-700 border-red-200',
                                        'expired' => 'bg-gray-100 text-gray-700 border-gray-200',
                                        default => 'bg-blue-100 text-blue-700 border-blue-200',
                                    };

                                    $statusText = match ($status) {
                                        'paid' => '✓ Lunas',
                                        'pending' => '⏳ Menunggu Pembayaran',
                                        'failed' => '✕ Gagal',
                                        'expired' => '⚠ Kedaluwarsa',
                                        default => ucfirst($status),
                                    };
                                @endphp

                                {{-- Logic x-show untuk filter --}}
                                <div class="order-card bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6"
                                    x-show="activeTab === 'all' || activeTab === '{{ $status }}'"
                                    x-transition.opacity.duration.300ms>

                                    <!-- Header Section -->
                                    <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50">
                                        <div class="flex justify-between items-start flex-wrap gap-4">
                                            <div class="flex gap-4 items-center">
                                                <div class="relative">
                                                    {{-- Uncomment gambar jika sudah siap --}}
                                                    {{-- <img src="..." class="w-16 h-16 object-cover rounded-lg shadow-md"> --}}
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-800 mb-1">
                                                        @foreach ($p->detailPesanan as $detail)
                                                            {{ $detail->jenisTiket->acara->nama_acara }}
                                                        @break

                                                        {{-- Ambil nama acara pertama saja --}}
                                                    @endforeach
                                                </h3>
                                                <p class="text-sm text-gray-500">
                                                    Order ID: #{{ $p->kode_pesanan }}
                                                </p>
                                            </div>
                                        </div>

                                        <span
                                            class="px-4 py-2 text-sm font-semibold rounded-full border {{ $badgeClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Content Section -->
                                <div class="p-6">
                                    <div class="flex justify-between mb-2">
                                        <p class="font-medium text-lg text-gray-400">Total Pesanan</p>
                                        <p class="font-bold text-lg">
                                            Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <!-- Action Section -->
                                    <div
                                        class="flex justify-between items-center pt-4 border-t border-gray-100 flex-wrap gap-4">
                                        <div class="flex gap-2">

                                            <a href="#"
                                                class="text-blue-600 hover:text-blue-700 font-medium flex items-center gap-2 transition-colors">
                                                <i data-lucide="eye" class="size-4"></i>
                                                Lihat Detail
                                            </a>
                                            <a href="{{ route('pembeli.tiket.download', $p->kode_pesanan) }}"
                                                class="text-gray-600 hover:text-red-600 flex items-center gap-2">
                                                <i data-lucide="file-down" class="size-4"></i>
                                                Download PDF
                                            </a>
                                        </div>

                                        <div class="flex gap-3">
                                            <button
                                                class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-200 font-medium flex items-center gap-2">
                                                <i data-lucide="message-circle" class="size-4"></i>
                                                Hubungi Kreator
                                            </button>

                                            {{-- Tombol Bayar hanya muncul jika Pending --}}
                                            @if ($status === 'pending')
                                                <a href="{{ route('pembeli.pembayaran.show', $p->kode_pesanan) }}"
                                                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 font-medium shadow-md hover:shadow-lg flex items-center gap-2">
                                                    <i data-lucide="credit-card" class="size-4"></i>
                                                    Bayar Sekarang
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Empty State untuk Filter Tertentu (misal: tidak ada tiket failed) --}}
                        <div x-show="(activeTab === 'pending' && $el.closest('[x-data]').querySelectorAll('[x-show=\'activeTab === \\\'pending\\\'\']').length === 0) || 
                                         (activeTab === 'paid' && $el.closest('[x-data]').querySelectorAll('[x-show=\'activeTab === \\\'paid\\\'\']').length === 0) ||
                                         (activeTab === 'failed' && $el.closest('[x-data]').querySelectorAll('[x-show=\'activeTab === \\\'failed\\\'\']').length === 0) ||
                                         (activeTab === 'expired' && $el.closest('[x-data]').querySelectorAll('[x-show=\'activeTab === \\\'expired\\\'\']').length === 0)"
                            class="text-center py-12 hidden" :class="{ 'block': true, 'hidden': false }">
                            <div
                                class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i data-lucide="inbox" class="size-8 text-gray-400"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Tidak ada tiket dengan status ini.</p>
                        </div>

                    </div> <!-- End wrapper hasItems -->
                @else
                    <!-- Global Empty State (Jika DB Kosong sama sekali) -->
                    <div class="p-12 text-center">
                        <div class="max-w-md mx-auto">
                            <div
                                class="bg-gray-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i data-lucide="ticket" class="size-12 text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Tiket</h3>
                            <p class="text-gray-500 mb-6">
                                Anda belum memiliki tiket apapun. Jelajahi acara menarik dan dapatkan tiket Anda
                                sekarang!
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
        </div>
    </div>
</div>
</x-app-layout>
