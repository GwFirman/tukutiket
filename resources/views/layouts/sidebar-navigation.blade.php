<!-- Navigation Links -->
<nav
    class="mt-5 mb-4 px-2 flex-1 overflow-y-auto overflow-x-hidden scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 hover:scrollbar-thumb-gray-400">
    <x-nav-link :href="route('beranda')" :active="request()->routeIs('beranda')" class="group">
        <i data-lucide="compass" class="size-5 mr-2"></i>
        {{ __('Jelajahi Acara') }}
    </x-nav-link>

    @if (request()->routeIs('pembeli.*') || request()->routeIs('profile.*'))
        <!-- Menu khusus untuk pembeli -->
        <x-nav-link :href="route('pembeli.pesanan-saya')" :active="request()->routeIs('pembeli.pesanan-saya')" class="mt-1 group">
            <i data-lucide="shopping-cart" class="size-5 mr-2"></i>
            {{ __('Pesanan Saya') }}
        </x-nav-link>

        <x-nav-link :href="route('pembeli.tiket-saya')" :active="request()->routeIs('pembeli.tiket-saya')" class="mt-1 group">
            <i data-lucide="ticket" class="size-5 mr-2"></i>
            {{ __('Tiket Saya') }}
        </x-nav-link>

        <div class="border-t border-gray-200 dark:border-gray-200 my-3 mx-2"></div>
        <h3 class="mx-3 text-gray-500 font-medium">Lainnya</h3>

        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')" class="mt-1 group">
            <i data-lucide="circle-user-round" class="size-5 mr-2"></i>
            {{ __('Profile') }}
        </x-nav-link>


        @if (auth()->user()->hasRole('kreator'))
            <x-nav-link :href="route('pembuat.dashboard')" class="mt-1 group">
                <i data-lucide="ticket" class="size-5 mr-2"></i>
                {{ __('Mode kreator') }}
            </x-nav-link>
        @endif
    @else
        @php
            // Cek status verifikasi kreator
            $kreator = auth()->user()->kreator;
            $verifikasi = $kreator ? $kreator->verifikasi : null;
            $isVerified = $verifikasi && $verifikasi->status === 'approved';
        @endphp

        {{-- Banner Peringatan jika belum terverifikasi --}}
        @if (!$isVerified)
            <div class="mx-2 mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-start gap-2">
                    <i data-lucide="alert-triangle" class="size-5 text-yellow-600 flex-shrink-0 mt-0.5"></i>
                    <div>
                        <p class="text-xs text-yellow-800 font-medium">Akun Belum Terverifikasi</p>
                        <p class="text-xs text-yellow-600 mt-1">Lengkapi verifikasi untuk mengakses semua fitur.</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="border-t border-gray-200 dark:border-gray-200 my-3 mx-2"></div>
        <h3 class="mx-3 text-gray-500 font-medium">Acara</h3>

        <!-- Menu default/pembuat -->
        @if ($isVerified)
            <x-nav-link :href="route('pembuat.dashboard')" :active="request()->routeIs('pembuat.dashboard')" class="group">
                <i data-lucide="home" class="size-5 mr-2"></i>
                {{ __('Dashboard') }}
            </x-nav-link>

            <x-nav-link :href="route('pembuat.acara.index')" :active="request()->routeIs('pembuat.acara.*')" class="mt-1 group">
                <i data-lucide="calendar" class="size-5 mr-2"></i>
                {{ __('Events') }}
            </x-nav-link>
        @else
            {{-- Menu Disabled --}}
            <div class="flex items-center px-3 py-2 text-gray-400 cursor-not-allowed opacity-50"
                title="Verifikasi akun untuk mengakses">
                <i data-lucide="home" class="size-5 mr-2"></i>
                <span>{{ __('Dashboard') }}</span>
                <i data-lucide="lock" class="size-3 ml-auto"></i>
            </div>

            <div class="flex items-center px-3 py-2 text-gray-400 cursor-not-allowed opacity-50 mt-1"
                title="Verifikasi akun untuk mengakses">
                <i data-lucide="calendar" class="size-5 mr-2"></i>
                <span>{{ __('Events') }}</span>
                <i data-lucide="lock" class="size-3 ml-auto"></i>
            </div>
        @endif

        @if (request()->is('kreator/acara/*') && !request()->routeIs('pembuat.acara.create') && $isVerified)
            <div class="ml-4 mt-1 space-y-1">
                @php
                    // Ambil parameter 'acara' dari route saat ini
                    $routeAcara = request()->route('acara');

                    // Cek apakah parameter berupa Model atau ID
                    if (is_object($routeAcara)) {
                        // Jika Route Model Binding aktif, $routeAcara adalah instance Model Acara
                        $acaraId = $routeAcara->id;
                        $acaraNama = $routeAcara->nama_acara;
                        $acaraSlug = $routeAcara->slug;
                    } else {
                        // Jika tidak, $routeAcara adalah ID (integer/string)
                        $acaraId = $routeAcara;
                        $acaraNama = null;
                        $acaraSlug = null;
                    }
                @endphp

                @if ($acaraId)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        @if ($acaraSlug)
                            <x-nav-link :href="route('pembuat.acara.show', $acaraSlug)" :active="request()->routeIs('pembuat.acara.show')" class="mt-1 group">
                                <i data-lucide="eye" class="size-4 mr-2"></i>
                                {{ $acaraNama }}
                            </x-nav-link>
                        @endif

                        <x-nav-link :href="route('pembuat.acara.edit', $acaraSlug)" :active="request()->routeIs('pembuat.acara.edit')" class="mt-1 group">
                            <i data-lucide="edit" class="size-4 mr-2"></i>
                            {{ __('Edit Acara') }}
                        </x-nav-link>

                    </div>
                @endif

                <x-nav-link :href="route('pembuat.acara.laporan-penjualan', $acaraSlug)" :active="request()->routeIs('pembuat.acara.laporan-penjualan')" class="group pl-4">
                    <i data-lucide="chart-no-axes-combined" class="size-4 mr-2"></i>
                    {{ __('Laporan Penjualan') }}
                </x-nav-link>

                <x-nav-link :href="route('pembuat.acara.daftar-peserta', $acaraSlug)" :active="request()->routeIs('pembuat.acara.daftar-peserta')" class="group pl-4">
                    <i data-lucide="ticket-check" class="size-4 mr-2"></i>
                    {{ __('Daftar Peserta') }}
                </x-nav-link>

                <x-nav-link :href="route('pembuat.checkin.index', $acaraSlug)" :active="request()->routeIs('pembuat.checkin.index')" class="group pl-4">
                    <i data-lucide="user-round-check" class="size-4 mr-2"></i>
                    {{ __('Check in peserta') }}
                </x-nav-link>

                <x-nav-link :href="route('pembuat.checkout.index', $acaraSlug)" :active="request()->routeIs('pembuat.checkout.index')" class="group pl-4">
                    <i data-lucide="user-round-minus" class="size-4 mr-2"></i>
                    {{ __('Check out peserta') }}
                </x-nav-link>

                <x-nav-link :href="route('dashboard', request()->route('acara'))" class="group pl-4">
                    <i data-lucide="chart-no-axes-combined" class="size-4 mr-2"></i>
                    {{ __('Transaksi') }}
                </x-nav-link>
            </div>
        @endif

        <div class="border-t border-gray-200 dark:border-gray-200 my-3 mx-2"></div>
        <h3 class="mx-3 text-gray-500 font-medium">Lainnya</h3>

        <!-- Menu Lainnya -->
        <x-nav-link :href="route('pembuat.profile')" :active="request()->routeIs('pembuat.profile')" class="mt-1 group">
            <i data-lucide="user" class="size-5 mr-2"></i>
            {{ __('Profile Kreator') }}
        </x-nav-link>


        {{-- Verifikasi Data selalu aktif --}}
        <x-nav-link :href="route('pembuat.verifikasi-data.index')" :active="request()->routeIs('pembuat.verifikasi-data.index')" class="group">
            <i data-lucide="shield-check" class="size-5 mr-2"></i>
            {{ __('Verifikasi Data') }}
            @if (!$isVerified)
                <span class="ml-auto px-2 py-0.5 text-xs bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
            @else
                <span class="ml-auto px-2 py-0.5 text-xs bg-green-100 text-green-700 rounded-full">✓</span>
            @endif
        </x-nav-link>

        <x-nav-link :href="route('pembeli.tiket-saya')" :active="request()->routeIs('pembeli.tiket-saya')" class=" group">
            <i data-lucide="ticket" class="size-5 mr-2"></i>
            {{ __('Mode Pembeli') }}
        </x-nav-link>
    @endif

    <div class="border-t border-gray-200 dark:border-gray-200 my-3 mx-2"></div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <x-nav-link :href="route('logout')" class="mt-1 group"
            onclick="event.preventDefault();
                                                this.closest('form').submit();">
            <i data-lucide="log-out" class="size-5 mr-2"></i>Logout
        </x-nav-link>
    </form>
</nav>

<!-- User Profile Footer -->
<div class="mt-auto border-2 m-2 rounded-md border-gray-200  dark:border-indigo-100 bg-gray-50 ">
    <div class="p-4">
        <div class="flex items-center gap-3">
            <!-- Avatar -->
            <div class="flex-shrink-0">
                @if (auth()->user()->avatar ?? false)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}"
                        class="size-10 rounded-full object-cover border-2 border-gray-200">
                @else
                    <div
                        class="size-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm border-2 border-gray-200">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                @endif
            </div>

            <!-- User Info -->
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                    {{ auth()->user()->email }}
                </p>
            </div>

            <!-- Settings Icon -->
            <a href="{{ route('profile.edit') }}"
                class="flex-shrink-0 p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <i data-lucide="settings" class="size-5"></i>
            </a>
        </div>
    </div>
</div>
