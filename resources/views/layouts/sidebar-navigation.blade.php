<!-- Navigation Links -->
<nav class="mt-5 px-2">
    <x-nav-link :href="route('beranda')" :active="request()->routeIs('beranda')" class="group">
        <i data-lucide="compass" class="size-5 mr-2"></i>
        {{ __('Jelajahi Acara') }}
    </x-nav-link>

    @if (request()->routeIs('pembeli.*') || request()->routeIs('profile.*'))
        <!-- Menu khusus untuk pembeli -->
        <x-nav-link :href="route('pembeli.tiket-saya')" :active="request()->routeIs('pembeli.tiket-saya')" class="mt-1 group">
            <i data-lucide="ticket" class="size-5 mr-2"></i>
            {{ __('Tiket Saya') }}
        </x-nav-link>

        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')" class="mt-1 group">
            <i data-lucide="circle-user-round" class="size-5 mr-2"></i>
            {{ __('Profile') }}
        </x-nav-link>
    @else
        <!-- Menu default/pembuat -->
        <x-nav-link :href="route('pembuat.dashboard')" :active="request()->routeIs('dashboard')" class="group">
            <i data-lucide="home" class="size-5 mr-2"></i>
            {{ __('Dashboard') }}
        </x-nav-link>

        <x-nav-link :href="route('pembuat.acara.index')" :active="request()->routeIs('pembuat.acara.*')" class="mt-1 group">
            <i data-lucide="calendar" class="size-5 mr-2"></i>
            {{ __('Events') }}
        </x-nav-link>
    @endif


</nav>
