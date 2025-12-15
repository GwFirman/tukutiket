<!-- Navigation Links -->
<nav class="mt-5 px-2">
    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="group">
        <i data-lucide="home" class="size-5 mr-2"></i>
        {{ __('Dashboard') }}
    </x-nav-link>

    <div class="border-t border-gray-200 dark:border-gray-200 my-3 mx-2"></div>
    <h3 class="mx-3 text-gray-500 font-medium">Moderasi</h3>

    <!-- Moderasi Event -->
    <x-nav-link :href="route('admin.mod-kreator')" :active="request()->routeIs('admin.moderasi.event.*')" class="mt-1 group">
        <i data-lucide="calendar" class="size-5 mr-2"></i>
        {{ __('Moderasi Event') }}
    </x-nav-link>

    <!-- Moderasi Kreator -->
    <x-nav-link :href="route('admin.mod-kreator')" :active="request()->routeIs('admin.moderasi.kreator.*')" class="mt-1 group">
        <i data-lucide="users" class="size-5 mr-2"></i>
        {{ __('Moderasi Kreator') }}
    </x-nav-link>

    {{-- <div class="border-t border-gray-200 dark:border-gray-200 my-3 mx-2"></div>
    <h3 class="mx-3 text-gray-500 font-medium">Laporan</h3>

    <!-- Laporan Transaksi -->
    <x-nav-link :href="route('admin.laporan.transaksi')" :active="request()->routeIs('admin.laporan.transaksi')" class="mt-1 group">
        <i data-lucide="chart-no-axes-combined" class="size-5 mr-2"></i>
        {{ __('Laporan Transaksi') }}
    </x-nav-link>

    <!-- Laporan Pengguna -->
    <x-nav-link :href="route('admin.laporan.pengguna')" :active="request()->routeIs('admin.laporan.pengguna')" class="mt-1 group">
        <i data-lucide="users-round" class="size-5 mr-2"></i>
        {{ __('Laporan Pengguna') }}
    </x-nav-link>

    <div class="border-t border-gray-200 dark:border-gray-200 my-3 mx-2"></div>
    <h3 class="mx-3 text-gray-500 font-medium">Pengaturan</h3>

    <!-- Pengaturan Sistem -->
    <x-nav-link :href="route('admin.settings')" :active="request()->routeIs('admin.settings')" class="mt-1 group">
        <i data-lucide="settings" class="size-5 mr-2"></i>
        {{ __('Pengaturan Sistem') }}
    </x-nav-link> --}}

    <div class="border-t border-gray-200 dark:border-gray-200 my-3 mx-2"></div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <x-nav-link :href="route('logout')" class="mt-1 group"
            onclick="event.preventDefault();
                                                this.closest('form').submit();">
            <i data-lucide="log-out" class="size-5 mr-2"></i>{{ __('Logout') }}
        </x-nav-link>
    </form>

</nav>
