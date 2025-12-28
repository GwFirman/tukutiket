<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 max-w-5xl mx-auto">
            <a href="{{ route('pembuat.acara.index') }}" class="text-gray-500 hover:text-indigo-600 transition">
                <i data-lucide="home" class="size-5"></i>
            </a>
            <i data-lucide="chevron-right" class="size-4 text-gray-400"></i>
            <a href="{{ route('pembuat.acara.index') }}" class="text-gray-500 hover:text-indigo-600 transition">Acara</a>
            <i data-lucide="chevron-right" class="size-4 text-gray-400"></i>
            <span class="font-medium text-gray-800">{{ Str::limit($acara->nama_acara, 30) }}</span>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-6 lg:mt-4 lg:px-0 pb-6">
        <!-- Action Buttons -->
        @include('pembuat_acara.acara.partials.show.action')
        @if ($acara->status == 'pending_verifikasi')
            <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
                <p class="font-bold">Peringatan</p>
                <p>Acara memerlukan dokumen izin sebelum dapat dipublikasikan.</p>
            </div>
        @endif

        <div class="grid grid-cols-12 gap-6 mt-4">
            <!-- Banner + Tiket -->
            @include('pembuat_acara.acara.partials.show.detail-acara')

            <!-- Sidebar kanan -->
            @include('pembuat_acara.acara.partials.show.sidebar-info')

        </div>
    </div>

    <script>
        function toggleTicketDetails(ticketId) {
            const element = document.getElementById(ticketId);
            const chevronIcon = event.currentTarget.querySelector('.chevron-icon');

            if (element.classList.contains('hidden')) {
                element.classList.remove('hidden');
                chevronIcon.style.transform = 'rotate(180deg)';
            } else {
                element.classList.add('hidden');
                chevronIcon.style.transform = 'rotate(0deg)';
            }
        }
    </script>
</x-app-layout>
