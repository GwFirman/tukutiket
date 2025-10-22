<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50">
        <!-- Top Navbar -->
        <nav class="bg-white/80 backdrop-blur-md shadow-md sticky top-0 z-50">
            <div class="container mx-auto px-6">
                <div class="flex justify-between items-center py-4">
                    <!-- Logo/Brand -->
                    <div class="flex items-center space-x-2">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-2 rounded-lg">
                            <i data-lucide="ticket" class="w-6 h-6 text-white"></i>
                        </div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            TukuTiket
                        </span>
                    </div>

                    <!-- Navigation Links & Auth Buttons -->
                    <div class="flex items-center space-x-6">
                        @auth
                            <!-- User Info -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-3 bg-indigo-50 hover:bg-indigo-100 px-4 py-2 rounded-lg transition-colors duration-200">
                                    <i data-lucide="user-circle" class="w-5 h-5 text-indigo-600"></i>
                                    <span class="text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</span>
                                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500"></i>
                                </button>
                                
                                <!-- Dropdown menu -->
                                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50" style="display: none;">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 flex items-center">
                                        <i data-lucide="user" class="w-4 h-4 mr-2 text-indigo-500"></i>
                                        Profile
                                    </a>
                                    
                                    @if(!Auth::user()->hasRole('pembuat_event'))
                                        <a href="{{ route('beranda') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 flex items-center">
                                            <i data-lucide="star" class="w-4 h-4 mr-2 text-amber-500"></i>
                                            Become Creator
                                        </a>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Logout Button -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center space-x-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold px-4 py-2 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg">
                                    <i data-lucide="log-out" class="w-4 h-4"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        @else
                            <!-- Login Button -->
                            <a href="{{ route('login') }}"
                                class="flex items-center space-x-2 text-indigo-600 hover:text-indigo-800 font-semibold px-4 py-2 rounded-lg transition-all duration-300">
                                <i data-lucide="log-in" class="w-4 h-4"></i>
                                <span>Login</span>
                            </a>
                            
                            <!-- Register Button -->
                            <a href="{{ route('register') }}"
                                class="flex items-center space-x-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-4 py-2 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg">
                                <i data-lucide="user-plus" class="w-4 h-4"></i>
                                <span>Register</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section with Animation -->
        <div class="container mx-auto px-6 py-20 relative overflow-hidden">
            <!-- Decorative Background Elements -->
            <div class="absolute top-0 left-0 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
            <div class="absolute top-0 right-0 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
            
            <div class="relative flex flex-col items-center lg:flex-row lg:justify-between">
                <div class="lg:w-1/2 text-center lg:text-left mb-12 lg:mb-0">
                    <div class="inline-flex items-center bg-indigo-100 text-indigo-800 px-4 py-2 rounded-full mb-6 animate-fade-in">
                        <i data-lucide="sparkles" class="w-4 h-4 mr-2"></i>
                        <span class="text-sm font-semibold">Indonesia's #1 Ticketing Platform</span>
                    </div>
                    <h1 class="text-6xl font-extrabold text-gray-900 mb-6 leading-tight animate-fade-in-up">
                        <span class="block">Welcome to</span>
                        <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                            TukuTiket
                        </span>
                    </h1>
                    <p class="text-xl text-gray-700 mb-8 leading-relaxed animate-fade-in-up animation-delay-200">
                        Your one-stop solution for booking event tickets quickly and securely. 
                        <span class="block mt-2 text-lg text-gray-600">🎉 Experience unforgettable moments!</span>
                    </p>
                </div>
                <div class="lg:w-1/2 flex justify-center items-center">
                    <div class="relative w-full max-w-md animate-fade-in-up animation-delay-600">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-3xl blur-2xl opacity-30 animate-pulse"></div>
                        <div class="relative bg-white/80 backdrop-blur-sm p-8 rounded-3xl shadow-2xl">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 p-6 rounded-2xl text-white">
                                    <i data-lucide="ticket" class="w-8 h-8 mb-2"></i>
                                    <p class="text-2xl font-bold">10K+</p>
                                    <p class="text-sm opacity-90">Tickets Sold</p>
                                </div>
                                <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-6 rounded-2xl text-white">
                                    <i data-lucide="calendar-days" class="w-8 h-8 mb-2"></i>
                                    <p class="text-2xl font-bold">500+</p>
                                    <p class="text-sm opacity-90">Events</p>
                                </div>
                                <div class="bg-gradient-to-br from-pink-500 to-pink-600 p-6 rounded-2xl text-white">
                                    <i data-lucide="users" class="w-8 h-8 mb-2"></i>
                                    <p class="text-2xl font-bold">5K+</p>
                                    <p class="text-sm opacity-90">Happy Users</p>
                                </div>
                                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 p-6 rounded-2xl text-white">
                                    <i data-lucide="star" class="w-8 h-8 mb-2"></i>
                                    <p class="text-2xl font-bold">4.9</p>
                                    <p class="text-sm opacity-90">Rating</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="bg-white/50 backdrop-blur-sm py-16">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
                    <div class="text-center p-6 rounded-2xl hover:bg-white transition-all duration-300 hover:shadow-lg">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl mb-4 shadow-lg">
                            <i data-lucide="zap" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Lightning Fast</h3>
                        <p class="text-gray-600">Book your tickets in seconds with our streamlined checkout process</p>
                    </div>
                    <div class="text-center p-6 rounded-2xl hover:bg-white transition-all duration-300 hover:shadow-lg">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl mb-4 shadow-lg">
                            <i data-lucide="shield-check" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">100% Secure</h3>
                        <p class="text-gray-600">Your payments and data are protected with bank-level security</p>
                    </div>
                    <div class="text-center p-6 rounded-2xl hover:bg-white transition-all duration-300 hover:shadow-lg">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-pink-500 to-yellow-500 rounded-2xl mb-4 shadow-lg">
                            <i data-lucide="headphones" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">24/7 Support</h3>
                        <p class="text-gray-600">Our dedicated team is always ready to help you anytime</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Events Section -->
        <div class="bg-gradient-to-b from-white to-indigo-50 py-20">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <div class="inline-flex items-center bg-indigo-100 text-indigo-800 px-4 py-2 rounded-full mb-4">
                        <i data-lucide="calendar-check" class="w-4 h-4 mr-2"></i>
                        <span class="text-sm font-semibold">Hot Events</span>
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-4">Upcoming Events</h2>
                    <p class="text-gray-600 text-lg max-w-2xl mx-auto">Discover and book tickets for amazing events happening near you</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Event cards will be looped here -->
                    @forelse($acaras ?? [] as $acara)
                        <div class="group bg-white rounded-2xl overflow-hidden shadow-lg transition-all duration-500 hover:shadow-2xl hover:-translate-y-2">
                            <div class="relative overflow-hidden">
                                @if ($acara->banner_acara && file_exists(storage_path('app/public/' . $acara->banner_acara)))
                                    <img src="{{ asset('storage/' . $acara->banner_acara) }}"
                                        alt="{{ $acara->nama_acara ?? 'Event' }}"
                                        class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <div class="w-full h-56 flex flex-col items-center justify-center bg-gradient-to-br from-indigo-100 to-purple-100">
                                        <i data-lucide="image-off" class="w-16 h-16 text-gray-400 mb-2"></i>
                                        <span class="text-gray-500 text-sm">No Banner Available</span>
                                    </div>
                                @endif
                                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full shadow-lg">
                                    <span class="text-xs font-bold text-indigo-600 flex items-center">
                                        <i data-lucide="trending-up" class="w-3 h-3 mr-1"></i>
                                        Hot
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                    {{ $acara->nama_acara ?? 'Event Name' }}
                                </h3>
                                <div class="space-y-3 mb-6">
                                    <div class="flex items-center text-gray-600">
                                        <div class="flex items-center justify-center w-8 h-8 bg-green-100 rounded-lg mr-3">
                                            <i data-lucide="calendar" class="w-4 h-4 text-green-600"></i>
                                        </div>
                                        <span class="text-sm">{{ $acara->waktu_mulai ?? 'Date TBD' }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <div class="flex items-center justify-center w-8 h-8 bg-amber-100 rounded-lg mr-3">
                                            <i data-lucide="map-pin" class="w-4 h-4 text-amber-600"></i>
                                        </div>
                                        <span class="text-sm line-clamp-1">{{ $acara->lokasi ?? 'Location' }}</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Starting from</p>
                                        <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                            {{ optional($acara->jenisTiket->first())->harga ?? 'Free' }}
                                        </span>
                                    </div>
                                    <a href="{{ route('pembeli.acara.show', $acara->slug ?? 1) }}"
                                        class="group/btn bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                        <span class="flex items-center">
                                            <span>Book Now</span>
                                            <i data-lucide="arrow-right" class="w-4 h-4 ml-2 transition-transform group-hover/btn:translate-x-1"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-16">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                                <i data-lucide="calendar-x" class="w-10 h-10 text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">No Events Available</h3>
                            <p class="text-gray-600">Check back soon for exciting events!</p>
                        </div>
                    @endforelse
                </div>

                {{-- <div class="text-center mt-12">
                    <a href="{{ route('acara.index') }}" class="inline-block bg-indigo-100 hover:bg-indigo-200 text-indigo-800 font-semibold py-3 px-6 rounded-lg transition duration-300">
                        View All Events
                    </a>
                </div> --}}
            </div>
        </div>

    </div>
</x-guest-layout>
