<x-guest-layout :showNavbar="false">
    <div class="flex min-h-screen w-full justify-center items-center p-4 sm:p-6 lg:p-10">
        <div
            class="flex flex-col lg:flex-row w-full max-w-6xl lg:max-w-5xl bg-white shadow-md overflow-hidden rounded-lg">
            <!-- Image Section - Hidden on mobile, shown on lg -->
            <div class="hidden lg:block lg:w-1/2 h-64 lg:h-auto">
                <div class="h-full">
                    <img src="{{ asset('images/login.png') }}" alt="Register Illustration"
                        class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Form Section -->
            <div class="w-full lg:w-1/2 px-6 py-8 sm:px-12 sm:py-10 lg:px-12 lg:py-8 xl:px-20">
                <div class="flex flex-col gap-4 items-center mb-6 sm:mb-8">
                    <div class="flex items-center space-x-2">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-2 rounded-lg">
                            <i data-lucide="ticket" class="w-8 h-8 sm:w-10 sm:h-10 text-white"></i>
                        </div>
                    </div>
                    <div class="text-center">
                        <h1 class="text-xl sm:text-2xl text-gray-800 font-bold">{{ __('Buat Akun') }}</h1>
                        <p class="mt-2 text-xs sm:text-sm text-gray-600 px-4 sm:px-0">
                            Daftar ke <span class="font-medium text-gray-700">tukutiket</span> dan mulai jual ticket
                            event-mu sekarang.
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')"
                            class="text-gray-700 font-semibold text-sm sm:text-base" />
                        <x-text-input id="name"
                            class="block mt-1 w-full border-2 rounded-lg py-2 sm:py-2.5 lg:py-2 pl-3 sm:pl-4 lg:pl-3 text-sm sm:text-base ring-0 focus:outline-indigo-500"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4 lg:mt-3">
                        <x-input-label for="email" :value="__('Email')"
                            class="text-gray-700 font-semibold text-sm sm:text-base" />
                        <x-text-input id="email"
                            class="block mt-1 w-full border-2 rounded-lg py-2 sm:py-2.5 lg:py-2 pl-3 sm:pl-4 lg:pl-3 text-sm sm:text-base outline-0 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4 lg:mt-3">
                        <x-input-label for="password" :value="__('Password')"
                            class="text-gray-700 font-semibold text-sm sm:text-base" />
                        <x-text-input id="password"
                            class="block mt-1 w-full border-2 rounded-lg py-2 sm:py-2.5 lg:py-2 pl-3 sm:pl-4 lg:pl-3 text-sm sm:text-base outline-0 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4 lg:mt-3">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')"
                            class="text-gray-700 font-semibold text-sm sm:text-base" />
                        <x-text-input id="password_confirmation"
                            class="block mt-1 w-full border-2 rounded-lg py-2 sm:py-2.5 lg:py-2 pl-3 sm:pl-4 lg:pl-3 text-sm sm:text-base outline-0 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="w-full mt-6 sm:mt-10 lg:mt-8">
                        <button type="submit"
                            class="w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 sm:py-3 lg:py-2.5 px-6 rounded-lg transition duration-300 text-sm sm:text-base">
                            Daftar
                        </button>
                    </div>

                    <div class="text-center mt-4 sm:mt-6 lg:mt-3 pt-4 border-t border-gray-200">
                        <p class="text-xs sm:text-sm text-gray-600">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                Masuk di sini
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
