<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i data-lucide="calendar" class="w-5 h-5 text-gray-600"></i>
            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
            <span class="font-semibold text-gray-800">Daftar Acara</span>
        </div>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto px-6 lg:px-24 pb-6 lg:pt-6">
            @role('kreator')
                <!-- Dashboard Header -->
                <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4">
                    <div>
                        <p class="text-sm sm:text-base text-gray-600 flex items-center gap-2">
                            <span>Daftar Acara </span>
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 w-full sm:w-auto">
                        <div class="hidden sm:block text-xs sm:text-sm text-gray-500">
                            Terakhir diperbarui: {{ now()->format('d M Y') }}
                        </div>
                        <a href="{{ route('pembuat.acara.create') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-5 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold rounded-lg text-sm hover:from-indigo-700 hover:to-indigo-800 transition-colors">
                            <i data-lucide="plus" class="w-4 h-4 sm:w-5 sm:h-5 mr-2"></i>
                            <span>Buat Acara Baru</span>
                        </a>
                    </div>
                </div>



                <!-- Search and Filter Section -->
                @livewire('pembuat.daftar-acara')

                {{-- @include('pembuat_acara.acara.partials.index.daftar-acara') --}}
            @endrole
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</x-app-layout>
