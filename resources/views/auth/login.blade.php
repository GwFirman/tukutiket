<x-guest-layout :showNavbar="false">
    <div class="flex min-h-screen w-full justify-center items-center p-4 sm:p-6 lg:p-20">
        <div class="flex flex-col lg:flex-row w-full max-w-6xl bg-white shadow-md overflow-hidden rounded-lg">
            <!-- Image Section - Hidden on mobile, shown on lg -->
            <div class="hidden lg:block lg:w-1/2 h-64 lg:h-auto">
                <div class="h-full">
                    <img src="{{ asset('images/login.png') }}" alt="Login Illustration" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Form Section -->
            <div class="w-full lg:w-1/2 px-6 py-8 sm:px-12 sm:py-10 lg:px-16 xl:px-28">
                <div class="flex flex-col gap-4 items-center mb-6 sm:mb-8">
                    <div class="flex items-center space-x-2">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-2 rounded-lg">
                            <i data-lucide="ticket" class="w-8 h-8 sm:w-10 sm:h-10 text-white"></i>
                        </div>
                    </div>
                    <div class="text-center">
                        <h1 class="text-xl sm:text-2xl text-gray-800 font-bold">{{ __('Selamat datang') }}</h1>
                        <p class="mt-2 text-xs sm:text-sm text-gray-600 px-4 sm:px-0">
                            Masuk ke akun <span class="font-medium text-gray-700">tukutiket</span> dan lanjutkan
                            petualangan event-mu bareng kami.
                        </p>
                    </div>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')"
                            class="text-gray-700 font-semibold text-sm sm:text-base" />
                        <x-text-input id="email"
                            class="block mt-1 w-full border-2 rounded-lg py-2 sm:py-2.5 pl-3 sm:pl-4 text-sm sm:text-base ring-0 focus:outline-indigo-500"
                            type="email" name="email" :value="old('email')" required autofocus
                            autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')"
                            class="text-gray-700 font-semibold text-sm sm:text-base" />
                        <x-text-input id="password"
                            class="block mt-1 w-full border-2 rounded-lg py-2 sm:py-2.5 pl-3 sm:pl-4 text-sm sm:text-base outline-0 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div
                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-0 mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                name="remember">
                            <span class="ms-2 text-xs sm:text-sm text-gray-600">{{ __('Ingat Aku') }}</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-xs sm:text-sm text-indigo-600 hover:text-indigo-800 font-medium"
                                href="{{ route('password.request') }}">
                                {{ __('Lupa Password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="w-full mt-6 sm:mt-10">
                        <button type="submit"
                            class="w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 sm:py-3 px-6 rounded-lg transition duration-300 text-sm sm:text-base">
                            Log in
                        </button>
                    </div>

                    @if (Route::has('register'))
                        <div class="text-center mt-4 sm:mt-6 pt-4 border-t border-gray-200">
                            <p class="text-xs sm:text-sm text-gray-600">
                                {{ __('Belum punya akun?') }}
                                <a href="{{ route('register') }}"
                                    class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    {{ __('Daftar') }}
                                </a>
                            </p>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
