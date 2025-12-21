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


    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

    <!-- Flat pickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</head>

<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        <!-- Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-600/50 z-40 lg:hidden" style="display: none;">
        </div>

        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-100  transform transition-transform duration-300 h-screen flex flex-col lg:translate-x-0"
            :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }">
            <!-- Logo -->
            <div class="flex items-center justify-start h-16 px-4 border-b gap-4 border-gray-300">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-2 rounded-lg">
                    <i data-lucide="ticket" class="w-6 h-6 text-white"></i>
                </div>
                <div class="text-xl font-bold text-gray-800">
                    Tukutiket
                </div>
                {{-- <button @click="sidebarOpen = false" class="p-2 rounded-md lg:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button> --}}
            </div>
            <!-- Navigation -->
            @include('layouts.sidebar-navigation')
        </div>

        <!-- Content -->
        <div class="lg:pl-64">
            <!-- Mobile header -->
            <div class="sticky top-0 z-20 px-4 py-4 bg-white sm:px-6 lg:hidden flex items-center gap-4">
                <button @click="sidebarOpen = true"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                @isset($header)
                    <header class="bg-white lg:hidden block">
                        <div class="mx-auto lg:pt-5 lg:px-24">
                            {{ $header }}
                        </div>
                    </header>
                @endisset
            </div>

            <!-- Main content -->
            <main class="">
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white hidden sm:block">
                        <div class="mx-auto pt-5 px-24">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <div class="h-full">
                    {{ $slot }}
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
