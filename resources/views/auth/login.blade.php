<x-guest-layout>
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-r from-blue-100 to-purple-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">{{ __('Welcome Back!') }}</h1>
                <p class="mt-2 text-sm text-gray-600">{{ __('Sign in to your account to continue') }}</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
                    <x-text-input id="email"
                        class="block mt-1 w-full border-2 rounded-lg p-2 ring-0 focus:outline-indigo-500"
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
                    <x-text-input id="password"
                        class="block mt-1 w-full border-2 rounded-lg p-2 outline-0 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 hover:text-indigo-800 font-medium"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>

                @if (Route::has('register'))
                    <div class="text-center mt-6 pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600">
                            {{ __("Don't have an account?") }}
                            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                {{ __('Sign up') }}
                            </a>
                        </p>
                    </div>
                @endif
            </form>
        </div>
    </div>
</x-guest-layout>
