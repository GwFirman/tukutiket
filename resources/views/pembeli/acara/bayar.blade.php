<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
            </svg>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('pembeli.tiket-saya') }}" class="font-semibold text-gray-800">Tiket Saya</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="font-semibold text-blue-600">Menunggu Pembayaran</span>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-24">
            <!-- Alert Warning -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700 font-medium">
                            Selesaikan pembayaran sebelum waktu habis!
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content - Payment Instructions -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Countdown Timer Card -->
                    <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
                        <div class="text-center">
                            <p class="text-sm font-medium mb-2">Selesaikan Pembayaran Dalam</p>
                            <div class="flex justify-center items-center space-x-2" x-data="countdown()"
                                x-init="startCountdown()">
                                <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-3">
                                    <div class="text-3xl font-bold" x-text="hours">00</div>
                                    <div class="text-xs">Jam</div>
                                </div>
                                <div class="text-2xl">:</div>
                                <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-3">
                                    <div class="text-3xl font-bold" x-text="minutes">00</div>
                                    <div class="text-xs">Menit</div>
                                </div>
                                <div class="text-2xl">:</div>
                                <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-3">
                                    <div class="text-3xl font-bold" x-text="seconds">00</div>
                                    <div class="text-xs">Detik</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Card -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Metode Pembayaran
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-sm text-gray-500">Metode</p>
                                    <p class="text-lg font-bold text-gray-900">Transfer Bank BCA</p>
                                </div>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg"
                                    alt="BCA" class="h-8">
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <p class="text-xs text-gray-500 mb-2">Nomor Virtual Account</p>
                                <div
                                    class="flex items-center justify-between bg-white rounded-lg p-3 border-2 border-blue-200">
                                    <span class="text-xl font-mono font-bold text-gray-900">8277 1234 5678 9012</span>
                                    <button onclick="copyVA()"
                                        class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        Salin
                                    </button>
                                </div>
                            </div>
                            <div class="bg-blue-50 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-2">Total Pembayaran</p>
                                <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b">
                            <h3 class="text-lg font-bold text-gray-900">Cara Pembayaran</h3>
                        </div>
                        <div class="p-6">
                            <!-- Tabs -->
                            <div class="border-b border-gray-200 mb-6" x-data="{ activeTab: 'atm' }">
                                <nav class="flex space-x-4">
                                    <button @click="activeTab = 'atm'"
                                        :class="activeTab === 'atm' ? 'border-blue-600 text-blue-600' :
                                            'border-transparent text-gray-500 hover:text-gray-700'"
                                        class="py-2 px-4 border-b-2 font-medium text-sm">
                                        ATM
                                    </button>
                                    <button @click="activeTab = 'mobile'"
                                        :class="activeTab === 'mobile' ? 'border-blue-600 text-blue-600' :
                                            'border-transparent text-gray-500 hover:text-gray-700'"
                                        class="py-2 px-4 border-b-2 font-medium text-sm">
                                        Mobile Banking
                                    </button>
                                    <button @click="activeTab = 'internet'"
                                        :class="activeTab === 'internet' ? 'border-blue-600 text-blue-600' :
                                            'border-transparent text-gray-500 hover:text-gray-700'"
                                        class="py-2 px-4 border-b-2 font-medium text-sm">
                                        Internet Banking
                                    </button>
                                </nav>

                                <!-- ATM Instructions -->
                                <div x-show="activeTab === 'atm'" class="mt-6 space-y-4">
                                    <div class="flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                            1</div>
                                        <p class="ml-3 text-gray-700">Masukkan kartu ATM dan PIN Anda</p>
                                    </div>
                                    <div class="flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                            2</div>
                                        <p class="ml-3 text-gray-700">Pilih menu <strong>Transaksi Lainnya</strong></p>
                                    </div>
                                    <div class="flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                            3</div>
                                        <p class="ml-3 text-gray-700">Pilih <strong>Transfer</strong> → <strong>Ke Rek
                                                BCA Virtual Account</strong></p>
                                    </div>
                                    <div class="flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                            4</div>
                                        <p class="ml-3 text-gray-700">Masukkan nomor Virtual Account: <strong
                                                class="font-mono">8277 1234 5678 9012</strong></p>
                                    </div>
                                    <div class="flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                            5</div>
                                        <p class="ml-3 text-gray-700">Pastikan detail pembayaran benar, lalu konfirmasi
                                        </p>
                                    </div>
                                    <div class="flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                            6</div>
                                        <p class="ml-3 text-gray-700">Simpan bukti pembayaran Anda</p>
                                    </div>
                                </div>

                                <!-- Mobile Banking Instructions -->
                                <div x-show="activeTab === 'mobile'" class="mt-6 space-y-4">
                                    <div class="flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                            1</div>
                                        <p class="ml-3 text-gray-700">Buka aplikasi BCA Mobile</p>
                                    </div>
                                    <div class="flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                            2</div>
                                        <p class="ml-3 text-gray-700">Pilih menu <strong>m-Transfer</strong></p>
                                    </div>
                                    <div class="flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                            3</div>
                                        <p class="ml-3 text-gray-700">Pilih <strong>BCA Virtual Account</strong></p>
                                    </div>
                                    <div class="flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                            4</div>
                                        <p class="ml-3 text-gray-700">Masukkan nomor Virtual Account: <strong
                                                class="font-mono">8277 1234 5678 9012</strong></p>
                                    </div>
                                    <div class="flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                            5</div>
                                        <p class="ml-3 text-gray-700">Masukkan PIN Anda dan konfirmasi pembayaran</p>
                                    </div>
                                </div>

                                <!-- Internet Banking Instructions -->
                                <div x-show="activeTab === 'internet'" class="mt-6 space-y-4">
                                    <div class="flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                            1</div>
                                        <p class="ml-3 text-gray-700">Login ke KlikBCA</p>
                                    </div>
                                    <div class="flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                            2</div>
                                        <p class="ml-3 text-gray-700">Pilih <strong>Transfer Dana</strong></p>
                                    </div>
                                    <div class="flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                            3</div>
                                        <p class="ml-3 text-gray-700">Pilih <strong>Transfer ke BCA Virtual
                                                Account</strong></p>
                                    </div>
                                    <div class="flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                            4</div>
                                        <p class="ml-3 text-gray-700">Masukkan nomor Virtual Account: <strong
                                                class="font-mono">8277 1234 5678 9012</strong></p>
                                    </div>
                                    <div class="flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                            5</div>
                                        <p class="ml-3 text-gray-700">Klik <strong>Lanjutkan</strong> dan konfirmasi
                                            dengan KeyBCA Appli</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden sticky top-6">
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
                                    <p class="font-semibold text-gray-900">
                                        {{ $namaAcara }}
                                    </p>
                                    <p class="text-xs text-gray-600 mt-1">
                                        {{ $lokasi }}r</p>
                                    <p class="text-xs text-gray-600">
                                        {{ $waktuMulai }}</p>
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
                                        <span class="font-medium text-gray-900">Rp {{ number_format($tiket['harga'], 0, ',', '.') }}</span>
                                    </div>
                                    @endforeach
                                    
                                </div>
                            </div>

                            <div class="border-t border-gray-200"></div>

                            <!-- Price Breakdown -->
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="text-gray-900">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
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
                                <span class="text-xl font-bold text-blue-600">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
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
                            <form action="{{ route('pembeli.pembayaran.store') }}" method="POST" id="paymentForm">
                                @csrf                            
                                <input type="hidden" name="kode_pesanan" value="{{ $pesanan->kode_pesanan }}">
                                @foreach ($pesanan->detailPesanan as $detail)
                                    <input type="hidden" name="id_detail_pesanan[]" value="{{ $detail->id }}">
                                    <input type="hidden" name="nama_peserta[]" value="{{ $pesanan->nama_pemesan }}">
                                    <input type="hidden" name="email_peserta[]" value="{{ $pesanan->email_pemesan }}">
                                @endforeach
                                
                                <button type="submit"
                                    class="w-full bg-blue-100 hover:bg-blue-700 hover:text-white text-blue-700 font-medium py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                                    Bayar
                                </button>
                            </form>
                            @if ($errors->any())
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
                                            <div class="mt-2 text-sm text-red-700">
                                                <ul class="list-disc pl-5 space-y-1">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function countdown() {
                return {
                    hours: '00',
                    minutes: '00',
                    seconds: '00',
                    endTime: new Date().getTime() + (24 * 60 * 60 * 1000), // 24 hours from now

                    startCountdown() {
                        setInterval(() => {
                            const now = new Date().getTime();
                            const distance = this.endTime - now;

                            if (distance < 0) {
                                this.hours = '00';
                                this.minutes = '00';
                                this.seconds = '00';
                                return;
                            }

                            this.hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)))
                                .padStart(2, '0');
                            this.minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2,
                                '0');
                            this.seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
                        }, 1000);
                    }
                }
            }

            function copyVA() {
                const vaNumber = '8277123456789012';
                navigator.clipboard.writeText(vaNumber).then(() => {
                    alert('Nomor Virtual Account berhasil disalin!');
                });
            }
        </script>
    @endpush
</x-app-layout>
