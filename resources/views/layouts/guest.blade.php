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
</head>

<body class="font-sans text-gray-900 antialiased bg-indigo-500">
    {{-- <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"> --}}
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50">
        <!-- Top Navbar -->
        <nav class="bg-white/80 backdrop-blur-md shadow-md sticky top-4 z-50 mx-20 rounded-full px-4">
            <div class="container mx-auto px-2">
                <div class="flex justify-between items-center py-4">
                    <!-- Logo/Brand -->
                    <div class="flex items-center space-x-2">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-2 rounded-lg">
                            <i data-lucide="ticket" class="w-6 h-6 text-white"></i>
                        </div>
                        <span
                            class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            TukuTiket
                        </span>
                    </div>

                    <!-- Navigation Links & Auth Buttons -->
                    <div class="flex items-center">
                        @auth
                            <!-- User Info -->
                            <div class="relative">
                                <button onclick="toggleDropdown()" id="dropdownButton"
                                    class="flex items-center space-x-3 bg-indigo-50 hover:bg-indigo-100 px-4 py-2 rounded-lg transition-colors duration-200">
                                    <i data-lucide="user-circle" class="w-5 h-5 text-indigo-600"></i>
                                    <span class="text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</span>
                                    <i data-lucide="chevron-down"
                                        class="w-4 h-4 text-gray-500 transition-transform duration-200"
                                        id="chevronIcon"></i>
                                </button>

                                <!-- Dropdown menu -->
                                <div id="dropdownMenu"
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50 opacity-0 scale-95 transform transition-all duration-200 pointer-events-none">
                                    <a href="{{ route('profile.edit') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 flex items-center">
                                        <i data-lucide="user" class="w-4 h-4 mr-2 text-indigo-500"></i>
                                        Profile
                                    </a>

                                    <a href="{{ route('pembeli.tiket-saya') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 flex items-center">
                                        <i data-lucide="calendar" class="w-4 h-4 mr-2 text-purple-500"></i>
                                        Tiket Saya
                                    </a>

                                    @if (!Auth::user()->hasRole('kreator'))
                                        <a href="{{ route('kreator.register') }}"
                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 flex items-center">
                                            <i data-lucide="star" class="w-4 h-4 mr-2 text-amber-500"></i>
                                            jadi Kreator Acara
                                        </a>
                                    @endif
                                    @if (Auth::user()->hasRole('kreator'))
                                        <a href="{{ route('pembuat.dashboard') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 flex items-center">
                                            <i data-lucide="calendar" class="w-4 h-4 mr-2 text-amber-500"></i>
                                            Dashboard Kreator
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Logout Button -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="ml-4 flex items-center space-x-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold px-4 py-2 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg">
                                    <i data-lucide="log-out" class="w-4 h-4"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        @else
                            <!-- Login Button -->
                            <a href="{{ route('login') }}"
                                class="flex items-center rounded-full space-x-2 text-indigo-600 hover:text-indigo-800 font-semibold px-4 py-2 transition-all duration-300">
                                <i data-lucide="log-in" class="w-4 h-4"></i>
                                <span>Login</span>
                            </a>

                            <!-- Register Button -->
                            <a href="{{ route('register') }}"
                                class="flex items-center rounded-full space-x-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-4 py-2 transition-all duration-300 shadow-md hover:shadow-lg">
                                <i data-lucide="user-plus" class="w-4 h-4"></i>
                                <span>Register</span>
                            </a>
                        @endauth
                    </div>

                    <script>
                        let isDropdownOpen = false;

                        function toggleDropdown() {
                            const dropdown = document.getElementById('dropdownMenu');
                            const chevron = document.getElementById('chevronIcon');

                            isDropdownOpen = !isDropdownOpen;

                            if (isDropdownOpen) {
                                dropdown.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
                                dropdown.classList.add('opacity-100', 'scale-100');
                                chevron.style.transform = 'rotate(180deg)';
                            } else {
                                dropdown.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
                                dropdown.classList.remove('opacity-100', 'scale-100');
                                chevron.style.transform = 'rotate(0deg)';
                            }
                        }

                        // Close dropdown when clicking outside
                        document.addEventListener('click', function(event) {
                            const dropdown = document.getElementById('dropdownMenu');
                            const button = document.getElementById('dropdownButton');

                            if (!dropdown.contains(event.target) && !button.contains(event.target)) {
                                if (isDropdownOpen) {
                                    toggleDropdown();
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </nav>

        {{ $slot }}

    </div>
    {{-- </div> --}}
    {{-- </div> --}}
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
