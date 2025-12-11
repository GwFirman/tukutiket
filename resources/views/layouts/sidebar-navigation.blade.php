<!-- Navigation Links -->
<nav class="mt-5 px-2">
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

        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')" class="mt-1 group">
            <i data-lucide="Settings" class="size-5 mr-2"></i>
            {{ __('Pengaturan') }}
        </x-nav-link>

        @if (auth()->user()->hasRole('kreator'))
            <x-nav-link :href="route('pembuat.dashboard')" class="mt-1 group">
                <i data-lucide="ticket" class="size-5 mr-2"></i>
                {{ __('Mode kreator') }}
            </x-nav-link>
        @endif
    @else
        <div class="border-t border-gray-200 dark:border-gray-200 my-3 mx-2"></div>
        <h3 class="mx-3 text-gray-500 font-medium">Acara</h3>
        <!-- Menu default/pembuat -->
        <x-nav-link :href="route('pembuat.dashboard')" :active="request()->routeIs('pembuat.dashboard')" class="group">
            <i data-lucide="home" class="size-5 mr-2"></i>
            {{ __('Dashboard') }}
        </x-nav-link>

        <x-nav-link :href="route('pembuat.acara.index')" :active="request()->routeIs('pembuat.acara.*')" class="mt-1 group">
            <i data-lucide="calendar" class="size-5 mr-2"></i>
            {{ __('Events') }}
        </x-nav-link>

        @if (request()->is('kreator/acara/*') && !request()->routeIs('pembuat.acara.create'))
            <div class="ml-4 mt-1 space-y-1">
                {{-- <x-nav-link :href="route('dashboard', request()->route('acara'))" class="group pl-4">
                <i data-lucide="eye" class="size-4 mr-2"></i>
                {{ __('Detail Acara') }}
            </x-nav-link> --}}

                @php
                    // Ambil parameter 'acara' dari route saat ini
                    $routeAcara = request()->route('acara');
                    // dd($routeAcara);

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

                        <x-nav-link :href="route('pembuat.acara.edit', $acaraId)" :active="request()->routeIs('pembuat.acara.edit')" class="mt-1 group">
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

                <x-nav-link :href="route('pembuat.scan.index', $acaraSlug)" class="group pl-4">
                    <i data-lucide="user-round-check" class="size-4 mr-2"></i>
                    {{ __('Check in peserta') }}
                </x-nav-link>

                <x-nav-link :href="route('dashboard', request()->route('acara'))" class="group pl-4">
                    <i data-lucide="chart-no-axes-combined" class="size-4 mr-2"></i>
                    {{ __('Transaksi') }}
                </x-nav-link>


            </div>
        @endif

        <div class="border-t border-gray-200 dark:border-gray-200 my-3 mx-2"></div>
        <h3 class="mx-3 text-gray-500 font-medium">Lainnya</h3>
        <!-- Menu default/pembuat -->

        <x-nav-link :href="route('pembuat.profile')" :active="request()->routeIs('pembuat.profile')" class="mt-1 group">
            <i data-lucide="user" class="size-5 mr-2"></i>
            {{ __('Profile Kreator') }}
        </x-nav-link>

        <x-nav-link :href="route('pembuat.dashboard')" :active="request()->routeIs('dashboard')" class="group">
            <i data-lucide="settings" class="size-5 mr-2"></i>
            {{ __('Pengaturan') }}
        </x-nav-link>


        <x-nav-link :href="route('pembuat.verifikasi-data.index')" :active="request()->routeIs('pembuat.verifikasi-data.index')" class="group">
            <i data-lucide="shield-check" class="size-5 mr-2"></i>
            {{ __('Verifikasi Data') }}
        </x-nav-link>

        <x-nav-link :href="route('pembeli.tiket-saya')" :active="request()->routeIs('pembeli.tiket-saya')" class="mt-1 group">
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
