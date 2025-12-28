<x-app-layout>
    <x-slot name="header">
        <div class="max-w-5xl mx-auto flex items-center gap-2">
            <i data-lucide="shopping-cart" class="size-5 text-gray-600"></i>
            <i data-lucide="chevron-right" class="size-4 text-gray-400"></i>
            <a href="{{ route('pembeli.pesanan-saya') }}" class="text-gray-600 hover:text-gray-900">Pesanan Saya</a>
            <i data-lucide="chevron-right" class="size-4 text-gray-400"></i>
            <span class="font-semibold text-gray-800">Detail Pesanan</span>
        </div>
    </x-slot>

    <div class="mb-5 sm:py-8">
        <div class="max-w-5xl mx-auto px-6 lg:px-0">

            <!-- Header -->
            <div class="mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Detail Pesanan</h1>
                        <p class="text-sm text-gray-600 mt-1">Kode: <span
                                class="font-mono font-semibold">{{ $pesanan->kode_pesanan }}</span></p>
                    </div>

                    <!-- Status Badge -->
                    <div>
                        @php
                            $status = strtolower($pesanan->status_pembayaran);
                            $badgeConfig = [
                                'paid' => [
                                    'class' => 'bg-green-100 text-green-800',
                                    'icon' => 'check-circle',
                                    'label' => 'Lunas',
                                ],
                                'pending' => [
                                    'class' => 'bg-yellow-100 text-yellow-800',
                                    'icon' => 'clock',
                                    'label' => 'Menunggu Konfirmasi Admin',
                                ],
                                'unpaid' => [
                                    'class' => 'bg-orange-100 text-orange-800',
                                    'icon' => 'alert-circle',
                                    'label' => 'Belum Dibayar',
                                ],
                                'failed' => [
                                    'class' => 'bg-red-100 text-red-800',
                                    'icon' => 'x-circle',
                                    'label' => 'Gagal',
                                ],
                                'expired' => [
                                    'class' => 'bg-gray-100 text-gray-800',
                                    'icon' => 'alert-circle',
                                    'label' => 'Kedaluwarsa',
                                ],
                                'rejected' => [
                                    'class' => 'bg-red-100 text-red-800',
                                    'icon' => 'ban',
                                    'label' => 'Ditolak',
                                ],
                            ];
                            $config = $badgeConfig[$status] ?? $badgeConfig['pending'];
                        @endphp
                        <span
                            class="inline-flex items-center gap-2 px-4 py-2 {{ $config['class'] }} rounded-lg font-semibold text-sm">
                            <i data-lucide="{{ $config['icon'] }}" class="size-5"></i>
                            {{ $config['label'] }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Section - Detail Items -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Detail Pesanan Card -->
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="p-4 sm:p-6 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i data-lucide="ticket" class="size-5 text-indigo-600"></i>
                                Detail Tiket
                            </h2>
                        </div>

                        <div class="p-4 sm:p-6 space-y-4">
                            @foreach ($pesanan->detailPesanan as $detail)
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <!-- Event Info -->
                                    <div
                                        class="bg-gradient-to-r from-indigo-50 to-purple-50 p-4 border-b border-gray-200">
                                        <div class="flex items-start gap-4">
                                            @if ($detail->jenisTiket->acara->banner_acara)
                                                <img src="{{ Storage::url($detail->jenisTiket->acara->banner_acara) }}"
                                                    alt="{{ $detail->jenisTiket->acara->nama_acara }}"
                                                    class="w-16 h-16 sm:w-20 sm:h-20 rounded-lg object-cover flex-shrink-0">
                                            @else
                                                <div
                                                    class="w-16 h-16 sm:w-20 sm:h-20 rounded-lg bg-indigo-200 flex items-center justify-center flex-shrink-0">
                                                    <i data-lucide="calendar" class="size-8 text-indigo-600"></i>
                                                </div>
                                            @endif

                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-2">
                                                    {{ $detail->jenisTiket->acara->nama_acara }}
                                                </h3>
                                                <div class="flex flex-col gap-1 text-xs sm:text-sm text-gray-600">
                                                    <div class="flex items-center gap-2">
                                                        <i data-lucide="calendar" class="size-4"></i>
                                                        <span>{{ \Carbon\Carbon::parse($detail->jenisTiket->acara->waktu_mulai)->format('d M Y') }}
                                                            WIB</span>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <i data-lucide="map-pin" class="size-4"></i>
                                                        <span class="truncate">
                                                            @if ($detail->jenisTiket->acara->is_online)
                                                                Acara Online
                                                            @else
                                                                {{ $detail->jenisTiket->acara->lokasi }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Ticket Type & Quantity -->
                                    <div class="p-4 space-y-3">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">
                                                    {{ $detail->jenisTiket->nama_jenis }}</p>
                                                <p class="text-xs text-gray-600">{{ $detail->jumlah }} tiket × Rp
                                                    {{ number_format($detail->harga_per_tiket, 0, ',', '.') }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-lg font-bold text-indigo-600">
                                                    Rp
                                                    {{ number_format($detail->jumlah * $detail->harga_per_tiket, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Nama Peserta -->
                                        @if ($detail->nama_peserta)
                                            <div class="pt-3 border-t border-gray-200">
                                                <p class="text-xs font-medium text-gray-700 mb-2">Nama Peserta:</p>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach (explode('; ', $detail->nama_peserta) as $nama)
                                                        <span
                                                            class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs">
                                                            <i data-lucide="user" class="size-3"></i>
                                                            {{ $nama }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Section - Summary -->
                <div class="lg:col-span-1 space-y-6">

                    <!-- Info Pemesan Card -->
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="p-4 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                                <i data-lucide="user" class="size-5 text-indigo-600"></i>
                                Info Pemesan
                            </h2>
                        </div>
                        <div class="p-4 space-y-3 text-sm">
                            <div>
                                <p class="text-xs text-gray-600 mb-1">Nama</p>
                                <p class="font-medium text-gray-900">{{ $pesanan->nama_pemesan }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 mb-1">Email</p>
                                <p class="font-medium text-gray-900 break-all">{{ $pesanan->email_pemesan }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 mb-1">No. Telepon</p>
                                <p class="font-medium text-gray-900">{{ $pesanan->no_telp_peserta }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Ringkasan Pembayaran Card -->
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="p-4 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                                <i data-lucide="credit-card" class="size-5 text-indigo-600"></i>
                                Ringkasan Pembayaran
                            </h2>
                        </div>
                        <div class="p-4 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium text-gray-900">Rp
                                    {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-base font-semibold text-gray-900">Total</span>
                                    <span class="text-xl font-bold text-indigo-600">Rp
                                        {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            @if ($pesanan->metode_pembayaran)
                                <div class="pt-3 border-t border-gray-200">
                                    <p class="text-xs text-gray-600 mb-1">Metode Pembayaran</p>
                                    <p class="font-medium text-gray-900">{{ ucfirst($pesanan->metode_pembayaran) }}</p>
                                </div>
                            @endif

                            <div class="pt-3 border-t border-gray-200">
                                <p class="text-xs text-gray-600 mb-1">Tanggal Pemesanan</p>
                                <p class="font-medium text-gray-900">{{ $pesanan->created_at->format('d M Y, H:i') }}
                                    WIB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @if ($pesanan->status_pembayaran === 'paid')
                        <a href="{{ route('pembeli.tiket-saya') }}"
                            class="block w-full text-center px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                            <i data-lucide="ticket" class="size-4 inline mr-2"></i>
                            Lihat Tiket Saya
                        </a>
                    @elseif($pesanan->status_pembayaran === 'pending')
                        <button disabled
                            class="block w-full text-center px-4 py-3 bg-yellow-300 text-yellow-700 rounded-lg font-medium cursor-not-allowed">
                            <i data-lucide="hourglass" class="size-4 inline mr-2"></i>
                            Menunggu Konfirmasi Admin
                        </button>
                    @elseif($pesanan->status_pembayaran === 'unpaid')
                        <a href="{{ route('pembeli.pembayaran.show', $pesanan->kode_pesanan) }}"
                            class="block w-full text-center px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                            <i data-lucide="credit-card" class="size-4 inline mr-2"></i>
                            Lanjutkan Pembayaran
                        </a>
                    @elseif($pesanan->status_pembayaran === 'failed')
                        <a href="{{ route('pembeli.pembayaran.show', $pesanan->kode_pesanan) }}"
                            class="block w-full text-center px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                            <i data-lucide="rotate-ccw" class="size-4 inline mr-2"></i>
                            Coba Pembayaran Ulang
                        </a>
                    @elseif($pesanan->status_pembayaran === 'expired')
                        <button disabled
                            class="block w-full text-center px-4 py-3 bg-gray-300 text-gray-600 rounded-lg font-medium cursor-not-allowed">
                            <i data-lucide="alert-circle" class="size-4 inline mr-2"></i>
                            Pesanan Kedaluwarsa
                        </button>
                    @elseif($pesanan->status_pembayaran === 'rejected')
                        <button disabled
                            class="block w-full text-center px-4 py-3 bg-red-300 text-red-700 rounded-lg font-medium cursor-not-allowed">
                            <i data-lucide="ban" class="size-4 inline mr-2"></i>
                            Pesanan Ditolak
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</x-app-layout>
