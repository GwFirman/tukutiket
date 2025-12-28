<x-app-layout>
    <x-slot name="header">
        <div class="flex max-w-4xl mx-auto items-center gap-2">
            <i data-lucide="user" class="size-5 text-gray-600"></i>
            <i data-lucide="chevron-right" class="size-4 text-gray-400"></i>
            <span class="font-semibold text-gray-800">{{ __('Profile') }}</span>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-4xl mx-auto px-6 lg:px-0">

            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Profil Saya</h1>
                <p class="text-sm text-gray-600 mt-1">Kelola informasi profil dan akun Anda</p>
            </div>

            <!-- Profile Information Card -->
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-6">
                <div class="p-6 sm:p-8 border-b border-gray-200">
                    <div class="flex items-center gap-3 mb-2">
                        <i data-lucide="info" class="size-5 text-indigo-600"></i>
                        <h2 class="text-lg font-semibold text-gray-900">
                            {{ __('Profile Information') }}
                        </h2>
                    </div>
                    <p class="text-sm text-gray-600">
                        {{ __("Update your account's profile information and email address.") }}
                    </p>
                </div>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="p-6 sm:p-8">
                    @csrf
                    @method('patch')

                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Name') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="user" class="size-5 text-gray-400"></i>
                                </div>
                                <input id="name" name="name" type="text"
                                    value="{{ old('name', $user->name) }}"
                                    class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm"
                                    required autofocus autocomplete="name" />
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Email') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="mail" class="size-5 text-gray-400"></i>
                                </div>
                                <input id="email" name="email" type="email"
                                    value="{{ old('email', $user->email) }}"
                                    class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm"
                                    required autocomplete="username" />
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <div class="flex items-start gap-2">
                                        <i data-lucide="alert-circle"
                                            class="size-5 text-yellow-600 flex-shrink-0 mt-0.5"></i>
                                        <div class="flex-1">
                                            <p class="text-sm text-yellow-800">
                                                {{ __('Your email address is unverified.') }}
                                            </p>
                                            <button form="send-verification"
                                                class="mt-2 text-sm text-indigo-600 hover:text-indigo-700 font-medium underline">
                                                {{ __('Click here to re-send the verification email.') }}
                                            </button>

                                            @if (session('status') === 'verification-link-sent')
                                                <p class="mt-2 text-sm text-green-600 font-medium">
                                                    {{ __('A new verification link has been sent to your email address.') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Nomor HP -->
                        <div>
                            <label for="nomor_hp" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Nomor HP') }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="phone" class="size-5 text-gray-400"></i>
                                </div>
                                <input id="nomor_hp" name="nomor_hp" type="tel"
                                    value="{{ old('nomor_hp', $user->nomor_hp) }}"
                                    class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm"
                                    autocomplete="tel" placeholder="08xxxx-xxxx-xxxx" />
                            </div>
                            @error('nomor_hp')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Alamat') }}
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-0 pl-3 pointer-events-none">
                                    <i data-lucide="map-pin" class="size-5 text-gray-400"></i>
                                </div>
                                <textarea id="alamat" name="alamat"
                                    class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm"
                                    rows="3" autocomplete="street-address" placeholder="Masukkan alamat lengkap Anda">{{ old('alamat', $user->alamat) }}</textarea>
                            </div>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Actions -->
                    <div
                        class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium text-sm">
                                <i data-lucide="save" class="size-4"></i>
                                {{ __('Save') }}
                            </button>

                            @if (session('status') === 'profile-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                    class="flex items-center gap-2 text-sm text-green-600 font-medium">
                                    <i data-lucide="check-circle" class="size-4"></i>
                                    {{ __('Saved.') }}
                                </p>
                            @endif
                        </div>

                        <p class="text-xs text-gray-500 flex items-center gap-1">
                            <i data-lucide="info" class="size-3"></i>
                            Perubahan akan langsung tersimpan
                        </p>
                    </div>
                </form>
            </div>

            {{-- Uncomment jika diperlukan
            <!-- Update Password Card -->
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-6">
                <div class="p-6 sm:p-8">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Card -->
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="p-6 sm:p-8">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            --}}
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</x-app-layout>
