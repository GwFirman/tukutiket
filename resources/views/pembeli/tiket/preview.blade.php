<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - {{ $tiket->kode_tiket }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen py-8 px-4 sm:px-6 lg:px-8">

    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('pembeli.tiket-saya') }}"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                <span class="text-sm font-medium">Kembali ke Tiket Saya</span>
            </a>
        </div>

        <!-- Ticket Container -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

            <!-- Header dengan Gradient -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 sm:p-8 text-white relative overflow-hidden">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full -ml-24 -mb-24"></div>

                <div class="relative z-10 text-center">
                    <div class="flex items-center justify-center gap-2 mb-4">
                        <i data-lucide="ticket" class="w-6 h-6"></i>
                        <span class="text-sm font-semibold uppercase tracking-wider opacity-90">E-Ticket</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2">{{ $tiket->nama_acara }}</h1>
                    <div class="flex items-start lg:items-center justify-center gap-2 text-indigo-100">
                        <i data-lucide="map-pin" class="w-12 h-12  lg:w-4 lg:h-4 "></i>
                        <p class="text-sm sm:text-base">{{ $tiket->lokasi }}</p>
                    </div>
                </div>
            </div>

            <!-- QR Code Section - Featured -->
            <div
                class="bg-gradient-to-br from-gray-50 to-indigo-50 p-8 sm:p-12 border-b-2 border-dashed border-gray-300">
                <div class="max-w-md mx-auto text-center space-y-6">
                    @if ($tiket->is_online)
                        <!-- Online Event Link -->
                        <div class="space-y-4">
                            <div
                                class="inline-block p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg border-2 border-green-200">
                                <i data-lucide="video" class="w-16 h-16 text-green-600 mx-auto mb-3"></i>
                                <p class="text-sm font-semibold text-green-700 mb-2">Acara Online</p>
                                <p class="text-xs text-green-600">Klik link di bawah untuk bergabung</p>
                            </div>

                            <!-- Online Event Link Button -->
                            @if ($tiket->lokasi)
                                <a href="{{ $tiket->lokasi }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center justify-center gap-2 w-full px-6 py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl">
                                    <i data-lucide="external-link" class="w-5 h-5"></i>
                                    <span>Buka Link Acara</span>
                                </a>
                                <p class="text-xs text-gray-600 break-all">{{ $tiket->lokasi }}</p>
                            @else
                                <div class="bg-yellow-50 border-2 border-yellow-300 rounded-xl p-4">
                                    <p class="text-sm font-semibold text-yellow-900">Link akan diberikan kemudian</p>
                                    <p class="text-xs text-yellow-800 mt-1">Organisator akan mengirim link acara sebelum
                                        acara dimulai</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- QR Code for Offline Event -->
                        <div class="inline-block p-6 bg-white rounded-lg">
                            @php
                                $qr = base64_encode(
                                    QrCode::format('png')
                                        ->size(400)
                                        ->errorCorrection('H')
                                        ->generate($tiket->kode_tiket),
                                );
                            @endphp
                            <img src="data:image/png;base64, {{ $qr }}" alt="QR Code"
                                class="w-48 h-48 sm:w-64 sm:h-64 lg:w-72 lg:h-72">
                        </div>

                        <!-- Ticket Code -->
                        <div class="bg-white rounded-2xl p-4 border-2 border-indigo-200">
                            <div class="flex items-center justify-center gap-2 text-indigo-600 mb-3">
                                <i data-lucide="scan" class="w-5 h-5"></i>
                                <span class="text-xs font-semibold uppercase tracking-wide">Kode Tiket</span>
                            </div>
                            <p class="text-xl sm:text-3xl font-mono font-bold text-gray-900 tracking-widest break-all">
                                {{ $tiket->kode_tiket }}
                            </p>
                        </div>

                        <!-- Important Notice -->
                        <div class="bg-yellow-50 border-2 border-yellow-300 rounded-xl p-5 ">
                            <div class="flex items-start gap-3">
                                <i data-lucide="shield-alert" class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5"></i>
                                <div class="text-left">
                                    <p class="text-sm font-semibold text-yellow-900 mb-1">Penting!</p>
                                    <p class="text-xs text-yellow-800 leading-relaxed">
                                        Tunjukkan QR Code ini di pintu masuk. Jangan bagikan ke orang lain untuk
                                        keamanan
                                        tiket Anda.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ticket Details Section -->
            <div class="">

                <!-- Ticket Details Section -->
                <div class="p-6 sm:p-8 space-y-6">

                    <!-- Date & Time -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-5 border border-blue-100">
                            <div class="flex items-center gap-2 text-blue-600 mb-3">
                                <i data-lucide="calendar" class="w-5 h-5"></i>
                                <span class="text-xs font-semibold uppercase tracking-wide">Jadwal Acara</span>
                            </div>
                            <div class="text-gray-900">
                                <p class="text-xl font-bold mb-1">
                                    {{ \Carbon\Carbon::parse($tiket->waktu_mulai)->format('d M Y') }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($tiket->waktu_mulai)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($tiket->waktu_selesai)->format('H:i') }} WIB
                                </p>
                            </div>
                        </div>

                        <div
                            class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-5 border border-purple-100">
                            <div class="flex items-center gap-2 text-purple-600 mb-3">
                                <i data-lucide="user" class="w-5 h-5"></i>
                                <span class="text-xs font-semibold uppercase tracking-wide">Pemegang Tiket</span>
                            </div>
                            <p class="text-xl font-bold text-gray-900">{{ $tiket->nama_peserta }}</p>
                        </div>
                    </div>

                    <!-- Contact Info & Ticket Type -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <div class="flex items-center gap-2 text-gray-500 mb-2">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                                <span class="text-xs font-semibold uppercase tracking-wide">Info Kontak</span>
                            </div>
                            <p class="text-sm font-medium text-gray-900 mb-1">{{ $tiket->email_peserta }}</p>
                            <p class="text-sm text-gray-600">{{ $tiket->no_telp_peserta }}</p>
                        </div>

                        <div>
                            <div class="flex items-center gap-2 text-gray-500 mb-2">
                                <i data-lucide="tag" class="w-4 h-4"></i>
                                <span class="text-xs font-semibold uppercase tracking-wide">Jenis Tiket</span>
                            </div>
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-gradient-to-r from-blue-100 to-indigo-100 text-indigo-700 border border-indigo-200">
                                {{ $tiket->jenis_tiket }}
                            </span>
                        </div>
                    </div>

                    <!-- Order Code & Price -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-6 border-t border-gray-200">
                        <div>
                            <div class="flex items-center gap-2 text-gray-500 mb-2">
                                <i data-lucide="hash" class="w-4 h-4"></i>
                                <span class="text-xs font-semibold uppercase tracking-wide">Kode Order</span>
                            </div>
                            <p class="text-sm font-mono font-bold text-gray-900 tracking-wider">
                                #{{ $tiket->kode_pesanan }}</p>
                        </div>

                        <div>
                            <div class="flex items-center gap-2 text-gray-500 mb-2">
                                <i data-lucide="credit-card" class="w-4 h-4"></i>
                                <span class="text-xs font-semibold uppercase tracking-wide">Harga Tiket</span>
                            </div>
                            <p class="text-lg font-bold text-gray-900">Rp
                                {{ number_format($tiket->harga_tiket, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 sm:px-8">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-xs text-gray-500 text-center sm:text-left leading-relaxed">
                            Tiket ini sah dan diterbitkan secara elektronik. Simpan bukti tiket ini untuk ditunjukkan
                            kepada
                            petugas.
                        </p>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <a href=""
                                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shadow-md">
                                <i data-lucide="download" class="w-4 h-4"></i>
                                Download PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Info Card -->
            <div class="mt-6 bg-white rounded-xl shadow-md p-6">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                        <i data-lucide="shield-check" class="w-5 h-5 text-indigo-600"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Tips Keamanan Tiket</h3>
                        <ul class="space-y-1 text-sm text-gray-600">
                            <li class="flex items-start gap-2">
                                <span class="text-indigo-600 mt-1">•</span>
                                <span>Jangan membagikan QR code atau kode tiket ke siapapun</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-indigo-600 mt-1">•</span>
                                <span>Simpan screenshot atau PDF tiket di perangkat Anda</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-indigo-600 mt-1">•</span>
                                <span>Datang lebih awal untuk menghindari antrian panjang</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://unpkg.com/lucide@latest"></script>
        <script>
            lucide.createIcons();
        </script>
</body>

</html>
