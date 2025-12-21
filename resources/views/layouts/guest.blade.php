@props(['showNavbar' => true])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Alpine.js cloak style -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</head>

<body class="font-sans text-gray-900 antialiased ">
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50">
        @if ($showNavbar)
            <!-- Top Navbar -->
            <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-3 sm:py-4">
                        <!-- Logo/Brand -->
                        <a href="{{ route('beranda') }}" class="flex items-center space-x-2">
                            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-1.5 sm:p-2 rounded-lg">
                                <i data-lucide="ticket" class="w-5 h-5 sm:w-6 sm:h-6 text-white"></i>
                            </div>
                            <span
                                class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                TukuTiket
                            </span>
                        </a>

                        <!-- Mobile Menu Button -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                            <i data-lucide="menu" class="w-6 h-6" x-show="!mobileMenuOpen"></i>
                            <i data-lucide="x" class="w-6 h-6" x-show="mobileMenuOpen" x-cloak></i>
                        </button>

                        <!-- Desktop Navigation Links & Auth Buttons -->
                        <div class="hidden md:flex items-center gap-3">
                            @auth
                                <!-- User Dropdown -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false"
                                        class="flex items-center gap-2 bg-indigo-50 hover:bg-indigo-100 pl-3 pr-4 py-2 rounded-full transition-all duration-200 border border-indigo-100 hover:border-indigo-200">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center">
                                            <span
                                                class="text-white font-semibold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                        </div>
                                        <span
                                            class="text-sm font-medium text-gray-700 max-w-24 truncate">{{ Auth::user()->name }}</span>
                                        <i data-lucide="chevron-down"
                                            class="w-4 h-4 text-gray-400 transition-transform duration-200"
                                            :class="open ? 'rotate-180' : ''"></i>
                                    </button>

                                    <!-- Dropdown menu -->
                                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                        class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 overflow-hidden"
                                        x-cloak>

                                        <!-- User Info Header -->
                                        <div
                                            class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                                            <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}
                                            </p>
                                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                        </div>

                                        <!-- Menu Items -->
                                        <div class="py-2">
                                            <a href="{{ route('profile.edit') }}"
                                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 transition-colors group">
                                                <div
                                                    class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                                                    <i data-lucide="user" class="w-4 h-4 text-indigo-600"></i>
                                                </div>
                                                <div>
                                                    <p class="font-medium">Profile</p>
                                                    <p class="text-xs text-gray-400">Kelola akun Anda</p>
                                                </div>
                                            </a>

                                            <a href="{{ route('pembeli.tiket-saya') }}"
                                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 transition-colors group">
                                                <div
                                                    class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                                                    <i data-lucide="ticket" class="w-4 h-4 text-purple-600"></i>
                                                </div>
                                                <div>
                                                    <p class="font-medium">Tiket Saya</p>
                                                    <p class="text-xs text-gray-400">Lihat tiket yang dibeli</p>
                                                </div>
                                            </a>

                                            @if (!Auth::user()->hasRole('kreator'))
                                                <a href="{{ route('kreator.register') }}"
                                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-amber-50 transition-colors group">
                                                    <div
                                                        class="w-8 h-8 rounded-lg bg-gradient-to-r from-amber-100 to-orange-100 flex items-center justify-center group-hover:from-amber-200 group-hover:to-orange-200 transition-colors">
                                                        <i data-lucide="star" class="w-4 h-4 text-amber-600"></i>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium">Jadi Kreator</p>
                                                        <p class="text-xs text-gray-400">Buat & kelola acara</p>
                                                    </div>
                                                </a>
                                            @endif

                                            @if (Auth::user()->hasRole('kreator'))
                                                <a href="{{ route('pembuat.dashboard') }}"
                                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 transition-colors group">
                                                    <div
                                                        class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                                                        <i data-lucide="layout-dashboard"
                                                            class="w-4 h-4 text-emerald-600"></i>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium">Dashboard Kreator</p>
                                                        <p class="text-xs text-gray-400">Kelola acara Anda</p>
                                                    </div>
                                                </a>
                                            @endif
                                        </div>

                                        <!-- Logout -->
                                        <div class="border-t border-gray-100 pt-2 px-2">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full flex items-center gap-3 px-3 py-2.5 text-sm text-red-600 hover:bg-red-50 rounded-xl transition-colors group">
                                                    <div
                                                        class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center group-hover:bg-red-200 transition-colors">
                                                        <i data-lucide="log-out" class="w-4 h-4 text-red-600"></i>
                                                    </div>
                                                    <span class="font-medium">Keluar</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Login Button -->
                                <a href="{{ route('login') }}"
                                    class="flex items-center gap-2 text-gray-600 hover:text-indigo-600 font-medium px-4 py-2 rounded-full hover:bg-indigo-50 transition-all duration-300">
                                    <i data-lucide="log-in" class="w-4 h-4"></i>
                                    <span>Masuk</span>
                                </a>

                                <!-- Register Button -->
                                <a href="{{ route('register') }}"
                                    class="flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium px-5 py-2.5 rounded-full transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                                    <span>Daftar</span>
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Mobile Menu -->
                    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-4"
                        class="md:hidden border-t border-gray-100 py-4" x-cloak>
                        @auth
                            <!-- User Info -->
                            <div
                                class="flex items-center gap-3 px-2 py-3 mb-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl">
                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center">
                                    <span class="text-white font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                </div>
                            </div>

                            <!-- Mobile Menu Items -->
                            <div class="space-y-1">
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-3 px-3 py-3 text-sm text-gray-700 hover:bg-indigo-50 rounded-xl transition-colors">
                                    <div class="w-9 h-9 rounded-lg bg-indigo-100 flex items-center justify-center">
                                        <i data-lucide="user" class="w-4 h-4 text-indigo-600"></i>
                                    </div>
                                    <span class="font-medium">Profile</span>
                                </a>

                                <a href="{{ route('pembeli.tiket-saya') }}"
                                    class="flex items-center gap-3 px-3 py-3 text-sm text-gray-700 hover:bg-purple-50 rounded-xl transition-colors">
                                    <div class="w-9 h-9 rounded-lg bg-purple-100 flex items-center justify-center">
                                        <i data-lucide="ticket" class="w-4 h-4 text-purple-600"></i>
                                    </div>
                                    <span class="font-medium">Tiket Saya</span>
                                </a>

                                @if (!Auth::user()->hasRole('kreator'))
                                    <a href="{{ route('kreator.register') }}"
                                        class="flex items-center gap-3 px-3 py-3 text-sm text-gray-700 hover:bg-amber-50 rounded-xl transition-colors">
                                        <div
                                            class="w-9 h-9 rounded-lg bg-gradient-to-r from-amber-100 to-orange-100 flex items-center justify-center">
                                            <i data-lucide="star" class="w-4 h-4 text-amber-600"></i>
                                        </div>
                                        <span class="font-medium">Jadi Kreator</span>
                                    </a>
                                @endif

                                @if (Auth::user()->hasRole('kreator'))
                                    <a href="{{ route('pembuat.dashboard') }}"
                                        class="flex items-center gap-3 px-3 py-3 text-sm text-gray-700 hover:bg-emerald-50 rounded-xl transition-colors">
                                        <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center">
                                            <i data-lucide="layout-dashboard" class="w-4 h-4 text-emerald-600"></i>
                                        </div>
                                        <span class="font-medium">Dashboard Kreator</span>
                                    </a>
                                @endif

                                <!-- Logout -->
                                <form method="POST" action="{{ route('logout') }}"
                                    class="pt-2 border-t border-gray-100 mt-2">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-3 py-3 text-sm text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                                        <div class="w-9 h-9 rounded-lg bg-red-100 flex items-center justify-center">
                                            <i data-lucide="log-out" class="w-4 h-4 text-red-600"></i>
                                        </div>
                                        <span class="font-medium">Keluar</span>
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Guest Mobile Menu -->
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('login') }}"
                                    class="flex items-center justify-center gap-2 text-gray-700 font-medium px-4 py-3 rounded-xl border border-gray-200 hover:bg-gray-50 transition-all">
                                    <i data-lucide="log-in" class="w-4 h-4"></i>
                                    <span>Masuk</span>
                                </a>

                                <a href="{{ route('register') }}"
                                    class="flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium px-4 py-3 rounded-xl transition-all shadow-md">
                                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                                    <span>Daftar</span>
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </nav>
        @endif

        {{ $slot }}

    </div>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>

</body>

</html>
