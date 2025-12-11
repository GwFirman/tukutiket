<x-guest-layout>
    <div class="flex h-screen w-screen sm:justify-center items-center p-10">
        <div class="flex h-full bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="w-full h-full sm:rounded-lg">
                <div class="text-center h-full">
                    <img src="{{ asset('images/login.png') }}" alt="Register Illustration" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="px-28 py-8 w-256">
                <div class="flex flex-col gap-4 items-center mb-6">
                    <div class="flex items-center space-x-2">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-2 rounded-lg">
                            <i data-lucide="ticket" class="w-10 h-10 text-white"></i>
                        </div>
                    </div>
                    <div class="text-center">
                        <h1 class="text-2xl text-gray-800 font-bold">{{ __('Buat Akun') }}</h1>
                        <p class="mt-2 text-sm text-gray-600">Daftar ke <span class="font-medium text-gray-700">tukutiket</span> dan mulai jual ticket event-mu sekarang.</p>
                    </div>
                </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-700 font-semibold" />
                    <x-text-input id="name"
                        class="block mt-1 w-full border-2 rounded-lg py-2 pl-4 ring-0 focus:outline-indigo-500"
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
                    <x-text-input id="email"
                        class="block mt-1 w-full border-2 rounded-lg py-2 pl-4 outline-0 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
                    <x-text-input id="password"
                        class="block mt-1 w-full border-2 rounded-lg py-2 pl-4 outline-0 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')"
                        class="text-gray-700 font-semibold" />
                    <x-text-input id="password_confirmation"
                        class="block mt-1 w-full border-2 rounded-lg py-2 pl-4 outline-0 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="w-full mt-10">
                    <button type="submit" class="w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                        Daftar
                    </button>
                </div>

                <div class="text-center mt-6 pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
