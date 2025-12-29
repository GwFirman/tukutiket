<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - {{ $tiket->kode_tiket }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-indigo-100 min-h-screen py-8 px-4 sm:px-6 lg:px-8 flex items-center justify-center">

    <div class="w-full max-w-5xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('pembeli.tiket-saya') }}"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors">
                <i data-lucide="arrow-left" class="size-5"></i>
                <span class="text-sm font-medium">Kembali ke Tiket Saya</span>
            </a>
        </div>

        <div class="bg-white rounded-2xl  overflow-hidden flex flex-col md:flex-row min-h-[500px]">

            <div
                class="md:w-[380px] bg-gradient-to-b from-gray-50 to-indigo-50 border-r-2 border-dashed border-gray-300 relative flex flex-col">

                <div class="hidden md:block absolute -right-3 top-0 w-6 h-3 bg-indigo-100 rounded-b-full z-10"></div>
                <div class="hidden md:block absolute -right-3 bottom-0 w-6 h-3 bg-indigo-100 rounded-t-full z-10"></div>

                <div class="md:hidden bg-indigo-600 p-4 text-center text-white">
                    <h1 class="text-xl font-bold">{{ $tiket->nama_acara }}</h1>
                </div>

                <div class="p-8 flex flex-col items-center justify-center flex-1 text-center space-y-6">

                    @if ($tiket->is_online)
                        <div class="p-6 bg-white rounded-2xl shadow-sm border border-green-100 w-full">
                            <i data-lucide="video" class="size-12 text-green-600 mx-auto mb-3"></i>
                            <h3 class="font-bold text-gray-900">Tiket Online</h3>
                            <p class="text-xs text-gray-500 mt-1">Gunakan link di detail untuk masuk</p>
                        </div>
                    @else
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            @php
                                $qr = base64_encode(
                                    QrCode::format('png')
                                        ->size(250) // Ukuran pas untuk kolom kiri
                                        ->margin(1)
                                        ->errorCorrection('H')
                                        ->generate($tiket->kode_tiket),
                                );
                            @endphp
                            <img src="data:image/png;base64, {{ $qr }}" alt="QR Code"
                                class="w-48 h-48 object-contain">
                        </div>
                    @endif

                    <div class="w-full">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Kode Tiket</p>
                        <div class="bg-white border-2 border-indigo-100 rounded-lg py-3 px-4">
                            <p class="text-2xl font-mono font-bold text-indigo-700 tracking-widest break-all">
                                {{ $tiket->kode_tiket }}
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-2 items-start text-xs text-yellow-700 bg-yellow-50 p-3 rounded-lg text-left">
                        <i data-lucide="shield-alert" class="size-4 shrink-0 mt-0.5"></i>
                        <p>Tunjukkan QR Code ini kepada petugas di pintu masuk.</p>
                    </div>
                </div>
            </div>

            <div class="flex-1 bg-white flex flex-col">

                <div class="hidden md:block p-8 pb-4 border-b border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <span
                                class="inline-block px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold mb-3">
                                {{ $tiket->jenis_tiket }}
                            </span>
                            <h1 class="text-3xl font-bold text-gray-900 leading-tight mb-2">{{ $tiket->nama_acara }}
                            </h1>
                            <div class="flex items-center gap-2 text-gray-500">
                                <i data-lucide="map-pin" class="size-4"></i>
                                <span class="text-sm">{{ $tiket->lokasi }}</span>
                            </div>
                        </div>
                        <div class="size-12 bg-gray-100 rounded-full flex items-center justify-center shrink-0">
                            <i data-lucide="ticket" class="size-6 text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-8">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="flex items-center gap-2 text-gray-400 mb-1">
                                <i data-lucide="clock" class="size-4"></i>
                                <span class="text-xs font-bold uppercase tracking-wider">Waktu Acara</span>
                            </div>
                            <p class="font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($tiket->waktu_mulai)->translatedFormat('d F Y') }}
                            </p>
                            <p class="text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($tiket->waktu_mulai)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($tiket->waktu_selesai)->format('H:i') }} WIB
                            </p>
                        </div>

                        @php
                            $start = $tiket->berlaku_mulai;
                            $end = $tiket->berlaku_sampai;
                        @endphp
                        @if ($start || $end)
                            <div>
                                <div class="flex items-center gap-2 text-orange-500 mb-1">
                                    <i data-lucide="calendar-check" class="size-4"></i>
                                    <span class="text-xs font-bold uppercase tracking-wider">Masa Berlaku Tiket</span>
                                </div>
                                <div class="text-sm">
                                    @if ($start)
                                        <p class="text-gray-600">Mulai: <span
                                                class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($start)->translatedFormat('d M Y') }}</span>
                                        </p>
                                    @endif
                                    @if ($end)
                                        <p class="text-gray-600">Sampai: <span
                                                class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($end)->translatedFormat('d M Y') }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="w-full h-px bg-gray-100"></div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Peserta</p>
                            <p class="font-semibold text-gray-900 truncate" title="{{ $tiket->nama_peserta }}">
                                {{ $tiket->nama_peserta }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Email</p>
                            <p class="text-sm text-gray-600 truncate" title="{{ $tiket->email_peserta }}">
                                {{ $tiket->email_peserta }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">No. Telepon</p>
                            <p class="text-sm text-gray-600">{{ $tiket->no_telp_peserta }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="mt-auto bg-gray-50 p-6 sm:px-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">

                    @if ($tiket->is_online && $tiket->lokasi)
                        <a href="{{ $tiket->lokasi }}" target="_blank"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                            <i data-lucide="external-link" class="size-4"></i>
                            Masuk Acara
                        </a>
                    @else
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i data-lucide="info" class="size-4 text-blue-500"></i>
                            <span>Pastikan baterai HP cukup saat scan.</span>
                        </div>
                    @endif

                    <a href="{{ route('pembeli.tiket.download', $tiket->id_tiket) }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                        <i data-lucide="download" class="size-4"></i>
                        Download PDF
                    </a>
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
