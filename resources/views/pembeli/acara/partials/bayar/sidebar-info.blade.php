<!-- Sidebar - Order Summary -->
<div class="lg:col-span-1">
    <div class="bg-white rounded-xl overflow-hidden sticky top-6">
        <div class="bg-gray-50 px-6 py-4 border-b">
            <h3 class="text-lg font-bold text-gray-900">Ringkasan Pesanan</h3>
        </div>
        <div class="p-6 space-y-4">
            <!-- Order ID -->
            <div>
                <p class="text-xs text-gray-500">Kode Pesanan</p>
                <p class="text-sm font-mono font-bold text-gray-900">{{ $pesanan->kode_pesanan }}</p>
            </div>

            <div class="border-t border-gray-200"></div>

            <!-- Event Details -->
            <div>
                <p class="text-xs text-gray-500 mb-2">Detail Acara</p>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="font-semibold text-gray-900">{{ $namaAcara }}</p>

                    {{-- Logika Lokasi --}}
                    @if ($isOnline)
                        {{-- Jika Online: Tampilkan teks khusus (opsional: warna biru biar beda) --}}
                        <p class="text-xs text-blue-600 font-medium mt-1">
                            Acara Online
                        </p>
                    @else
                        {{-- Jika Offline: Tampilkan lokasi asli --}}
                        <p class="text-xs text-gray-600 mt-1">
                            {{ $lokasi }}
                        </p>
                    @endif

                    <p class="text-xs text-gray-600 mt-0.5">{{ $waktuMulai }}</p>
                </div>
            </div>

            <div class="border-t border-gray-200"></div>

            <!-- Ticket Details -->
            <div>
                <p class="text-xs text-gray-500 mb-2">Detail Tiket</p>
                <div class="space-y-2">
                    @foreach ($daftarTiket as $tiket)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ $tiket['nama_tiket'] }}</span>
                            <span class="font-medium text-gray-900">Rp
                                {{ number_format($tiket['harga'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="border-t border-gray-200"></div>

            <!-- Price Breakdown -->
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="text-gray-900">Rp
                        {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Biaya Layanan</span>
                    <span class="text-gray-900">Rp 0</span>
                </div>
            </div>

            <div class="border-t-2 border-gray-300"></div>

            <!-- Total -->
            <div class="flex justify-between items-center">
                <span class="text-sm font-semibold text-gray-900">Total Pembayaran</span>
                <span class="text-xl font-bold text-blue-600">Rp
                    {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
            </div>

            <!-- Help Button -->
            <button
                class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Butuh Bantuan?
            </button>
        </div>
    </div>
</div>
