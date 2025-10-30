<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tukutiket') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: true }" class="min-h-screen">
        <!-- Sidebar -->

        <!-- Content -->
        <div class="lg:pl-64">
            <!-- Mobile header -->
            <div class="sticky top-0 z-20 px-4 py-4 bg-white sm:px-6 border-b lg:hidden">
                <button @click="sidebarOpen = true"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Main content -->
            <main class="">
                <!-- Page Heading -->


                <!-- Page Content -->
                <div class="py-12 px-12">
                    <div class="grid grid-cols-12 gap-2">
                        <div class="bg-white shadow-sm sm:rounded-lg col-span-8 p-4">
                            <div
                                class="h-64 w-full border-2 border-gray-200 border-dashed rounded-lg flex items-center justify-center overflow-hidden bg-gray-50">
                                @if ($acara->banner_acara)
                                    <img src="{{ asset('storage/' . $acara->banner_acara) }}" alt="Banner Acara"
                                        class="h-full w-full object-cover rounded-lg">
                                @else
                                    <span class="text-gray-400 text-sm">Belum ada banner acara</span>
                                @endif
                            </div>

                            <div class=" text-gray-900 mt-4 text-2xl">
                                {{ $acara->nama_acara }}
                            </div>

                            <div class="text-gray-600 mt-2">
                                {!! $acara->deskripsi !!}
                            </div>
                            <div class="border-t border-gray-200 my-4"></div>
                            <div class=" text-gray-400 mt-4 font-medium text-lg">
                                <i data-lucide="ticket" class="inline"></i> Informasi tiket
                            </div>
                            <div class="grid grid-cols-1 gap-4 mt-6">
                                @foreach ($acara->jenisTiket as $tiket)
                                    <div class="ticket-container mb-4">
                                        <div
                                            class=" rounded-lg overflow-hidden transition-all">
                                            <!-- Ticket Header -->
                                            <div class="bg-gradient-to-r from-indigo-50 to-gray-50 p-4 relative">
                                                <!-- Ticket stub design -->
                                                <div
                                                    class="absolute top-0 left-0 h-full w-3 bg-indigo-500 flex items-center justify-center">
                                                    <div class="h-8 w-4 rounded-tr-md rounded-br-md bg-white "></div>
                                                </div>

                                                <div class="flex justify-between items-center ml-5">
                                                    <div class="w-full">
                                                        <div class="flex items-center justify-between">
                                                            <div class="flex items-center">
                                                                <i data-lucide="ticket"
                                                                    class="h-5 w-5 text-indigo-500 mr-2"></i>
                                                                <h3 class="font-semibold text-lg text-gray-800">
                                                                    {{ $tiket->nama_jenis }}
                                                                </h3>
                                                            </div>
                                                            <p class="flex text-gray-500 text-sm items-center">
                                                                Penjualan berakhir
                                                                {{ \Carbon\Carbon::parse($tiket->penjualan_selesai)->translatedFormat('d F Y') }}
                                                            </p>
                                                        </div>
                                                        <div class="flex justify-between mt-2">
                                                            <p class="text-indigo-600 font-bold text-xl">
                                                                Rp {{ number_format($tiket->harga, 0, ',', '.') }}
                                                            </p>
                                                            <p
                                                                class="text-indigo-600 py-1 px-4 font-medium border-2 border-blue-500 rounded-full text-sm bg-blue-200">
                                                                Kuota tiket : {{ $tiket->kuota }}
                                                            </p>
                                                        </div>

                                                        <!-- Tombol lihat detail -->
                                                        <button type="button"
                                                            onclick="toggleTicketDetails('ticket-{{ $tiket->id }}')"
                                                            class="mt-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                                                            Lihat Detail
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
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

                                                <div class="p-4 bg-white">
                                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                                        <div class="p-2 bg-gray-50 rounded">
                                                            <p class="text-gray-500 text-xs">Penjualan Mulai</p>
                                                            <p class="font-medium flex items-center">
                                                                <i data-lucide="calendar"
                                                                    class="h-3 w-3 mr-1 text-indigo-400"></i>
                                                                {{ \Carbon\Carbon::parse($tiket->penjualan_mulai)->format('d-m-Y') }}
                                                            </p>
                                                        </div>

                                                        <div class="p-2 bg-gray-50 rounded">
                                                            <p class="text-gray-500 text-xs">Penjualan Selesai</p>
                                                            <p class="font-medium flex items-center">
                                                                <i data-lucide="calendar"
                                                                    class="h-3 w-3 mr-1 text-indigo-400"></i>
                                                                {{ \Carbon\Carbon::parse($tiket->penjualan_selesai)->format('d-m-Y') }}
                                                            </p>
                                                           
                                                        </div>
                                                    </div>

                                                    <div class="mt-4 p-2 bg-gray-50 rounded">
                                                        <p class="text-gray-500 text-xs mb-1">Deskripsi Tiket</p>
                                                        <p class="text-sm">
                                                            {{ $tiket->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <script>
                                function toggleTicketDetails(ticketId) {
                                    const element = document.getElementById(ticketId);
                                    const chevronIcon = event.currentTarget.querySelector('.chevron-icon');

                                    if (element.classList.contains('hidden')) {
                                        element.classList.remove('hidden');
                                        chevronIcon.innerHTML =
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />';
                                    } else {
                                        element.classList.add('hidden');
                                        chevronIcon.innerHTML =
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />';
                                    }
                                }
                            </script>

                        </div>
                        <div
                            class="bg-white overflow-hidden shadow-sm sm:rounded-lg col-span-4 p-6 sticky top-6 self-start">
                            <p class="text-gray-800 font-medium">Waktu Pelaksanaan</p>
                            <div class="flex gap-2 mt-2">
                                <div class="bg-gray-100 rounded-md border border-gray-400 p-2">
                                    <p>{{ \Carbon\Carbon::parse($acara->penjualan_mulai)->format('d-m-Y') }} <span
                                            class="text-gray-500">{{ \Carbon\Carbon::parse($acara->waktu_mulai)->format('H:i') }}</span>
                                    </p>
                                </div>
                                <div class="bg-gray-100 rounded-md border border-gray-400 p-2">
                                    <p>{{ \Carbon\Carbon::parse($acara->penjualan_selesai)->format('d-m-Y') }} <span
                                            class="text-gray-500">{{ \Carbon\Carbon::parse($acara->waktu_selesai)->format('H:i') }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="border-t border-gray-200 my-4"></div>
                            <p class="text-gray-800 font-medium"> lokasi</p>
                            <div class="text-gray-600 mt-2">
                                {{ $acara->lokasi }}
                            </div>
                            <div class="border-t border-gray-200 my-4"></div>
                            <p class="text-gray-800 font-medium">Informasi Kontak</p>
                            <div class="text-gray-600 mt-2">
                                {{ $acara->info_kontak }}
                            </div>
                            <div class="border-t border-gray-200 my-4"></div>
                            <a href="{{ route('pembeli.checkout.show', $acara->slug ?? 1) }}"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded transition duration-300">
                                Beli Tiket
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    @livewireScripts
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
