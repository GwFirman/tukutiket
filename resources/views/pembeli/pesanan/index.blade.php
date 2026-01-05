<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i data-lucide="shopping-bag" class="size-5 text-gray-600"></i>
            <i data-lucide="chevron-right" class="size-4 text-gray-400"></i>
            <p class="font-semibold text-gray-800">Pesanan Saya</p>
        </div>
    </x-slot>

    {{-- Inisialisasi Alpine Data untuk Tabs --}}
    <div class="py-0 md:py-6" x-data="{ activeTab: 'all' }">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ================= TABS NAVIGATION ================= --}}
            <div class="flex gap-4 border-b border-gray-200 mb-6 overflow-x-auto">
                @php
                    $tabs = [
                        'all' => 'Semua',
                        'pending' => 'Menunggu Konfirmasi Pembayaran',
                        'unpaid' => 'Belum Dibayar',
                        'paid' => 'Lunas',
                        'failed' => 'Gagal',
                        'expired' => 'Kedaluwarsa',
                        'rejected' => 'Ditolak',
                    ];
                @endphp

                @foreach ($tabs as $key => $label)
                    <button @click="activeTab = '{{ $key }}'"
                        :class="activeTab === '{{ $key }}'
                            ?
                            'border-indigo-600 text-indigo-600' :
                            'border-transparent text-gray-500 hover:text-gray-700'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <div class="space-y-4 sm:space-y-6">
                @if ($pesanan->count() > 0)
                    <div x-data="{ hasItems: true }">
                        @foreach ($pesanan as $p)
                            @php
                                $status = strtolower($p->status_pembayaran);

                                $badgeClass = match ($status) {
                                    'paid' => 'bg-green-50 text-green-700 border-green-200',
                                    'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                    'unpaid' => 'bg-orange-50 text-orange-700 border-orange-200',
                                    'failed' => 'bg-red-50 text-red-700 border-red-200',
                                    'expired' => 'bg-gray-50 text-gray-700 border-gray-200',
                                    'rejected' => 'bg-red-50 text-red-700 border-red-200',
                                    default => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                };

                                $statusText = match ($status) {
                                    'paid' => 'Lunas',
                                    'pending' => 'Menunggu Konfirmasi Pembayaran',
                                    'unpaid' => 'Belum Dibayar',
                                    'failed' => 'Gagal',
                                    'expired' => 'Kedaluwarsa',
                                    'rejected' => 'Ditolak',
                                    default => ucfirst($status),
                                };

                                $statusIcon = match ($status) {
                                    'paid' => 'check-circle',
                                    'pending' => 'clock',
                                    'unpaid' => 'alert-circle',
                                    'failed' => 'x-circle',
                                    'expired' => 'alert-circle',
                                    'rejected' => 'ban',
                                    default => 'info',
                                };
                            @endphp

                            {{-- Order Card --}}
                            <div class="order-card bg-white rounded-xl border border-gray-200 overflow-hidden mb-4"
                                x-show="activeTab === 'all' || activeTab === '{{ $status }}'"
                                x-transition.opacity.duration.300ms>

                                <!-- Header Section -->
                                <div class="p-4 sm:p-6 bg-gray-50 border-b border-gray-200">
                                    <div
                                        class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3 sm:gap-4">
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-1 truncate">
                                                @foreach ($p->detailPesanan as $detail)
                                                    {{ $detail->jenisTiket->acara->nama_acara }}
                                                @break
                                            @endforeach
                                        </h3>
                                        <p class="text-xs sm:text-sm text-gray-500">
                                            Order ID: <span class="font-medium">#{{ $p->kode_pesanan }}</span>
                                        </p>
                                    </div>

                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs sm:text-sm font-medium rounded-lg border {{ $badgeClass }}">
                                        <i data-lucide="{{ $statusIcon }}" class="size-3.5 sm:size-4"></i>
                                        {{ $statusText }}
                                    </span>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-4 sm:p-6">
                                <!-- Total -->
                                <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-100">
                                    <p class="text-sm sm:text-base text-gray-600">Total Pesanan</p>
                                    <p class="text-lg sm:text-xl font-bold text-gray-900">
                                        Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- Actions -->
                                <div class="flex flex-col sm:flex-row sm:justify-between gap-3 sm:gap-4">
                                    <!-- Quick Links -->
                                    <div class="flex flex-wrap gap-3 sm:gap-4">
                                        <a href="{{ route('pembeli.pesanan-saya.show', $p->kode_pesanan) }}"
                                            class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-700 font-medium transition-colors">
                                            <i data-lucide="eye" class="size-4"></i>
                                            <span>Lihat Detail</span>
                                        </a>
                                    </div>

                                    <!-- Main Actions -->
                                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">


                                        @if ($status === 'unpaid')
                                            <a href="{{ route('pembeli.pembayaran.show', $p->kode_pesanan) }}"
                                                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-sm font-medium">
                                                <i data-lucide="credit-card" class="size-4"></i>
                                                <span>Bayar Sekarang</span>
                                            </a>
                                        @elseif ($status === 'pending')
                                            <a href="{{ route('pembeli.pembayaran.show', $p->kode_pesanan) }}"
                                                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors text-sm font-medium">
                                                <i data-lucide="eye" class="size-4"></i>
                                                <span>Lihat Pembayaran</span>
                                            </a>
                                        @elseif ($status === 'rejected')
                                            <a href="{{ route('pembeli.pembayaran.show', $p->kode_pesanan) }}"
                                                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                                                <i data-lucide="eye" class="size-4"></i>
                                                <span>Ulangi Pembayaran</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Empty State untuk Filter --}}
                    <div x-show="!hasItems" x-cloak class="text-center py-12">
                        <div
                            class="bg-gray-50 w-16 h-16 sm:w-20 sm:h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="inbox" class="size-6 sm:size-8 text-gray-400"></i>
                        </div>
                        <p class="text-sm sm:text-base text-gray-500 font-medium">Tidak ada pesanan dengan status
                            ini.</p>
                    </div>
                </div>
            @else
                <!-- Global Empty State -->
                <div class="bg-white rounded-xl border border-gray-200 p-8 sm:p-12 text-center">
                    <div class="max-w-md mx-auto">
                        <div
                            class="bg-gray-50 w-20 h-20 sm:w-24 sm:h-24 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                            <i data-lucide="shopping-bag" class="size-10 sm:size-12 text-gray-400"></i>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Belum Ada Pesanan</h3>
                        <p class="text-sm sm:text-base text-gray-600 mb-6">
                            Anda belum memiliki pesanan apapun. Jelajahi acara menarik dan dapatkan tiket Anda
                            sekarang!
                        </p>
                        <a href="{{ route('beranda') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors">
                            <i data-lucide="search" class="size-5"></i>
                            <span>Jelajahi Acara</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
</x-app-layout>
