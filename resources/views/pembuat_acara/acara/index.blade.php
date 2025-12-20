<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i data-lucide="calendar" class="w-5 h-5 text-gray-600"></i>
            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
            <span class="font-semibold text-gray-800">Daftar Acara</span>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-24">
            @role('kreator')
                <!-- Header Section -->
                <div class="mb-6 sm:mb-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Dashboard Acara</h1>
                            <p class="text-sm text-gray-600 mt-1">Kelola dan pantau semua acara Anda</p>
                        </div>
                        <a href="{{ route('pembuat.acara.create') }}"
                            class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200">
                            <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                            Buat Acara Baru
                        </a>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
                    <!-- Total Acara -->
                    <div
                        class="bg-white border border-gray-200 rounded-xl p-5 sm:p-6 hover:border-indigo-300 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600">Total Acara</p>
                                <p class="text-3xl sm:text-4xl font-bold text-gray-900 mt-2">{{ count($acaras) }}</p>
                            </div>
                            <div class="flex-shrink-0 w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center">
                                <i data-lucide="calendar" class="w-6 h-6 text-indigo-600"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Published -->
                    <div
                        class="bg-white border border-gray-200 rounded-xl p-5 sm:p-6 hover:border-green-300 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600">Published</p>
                                <p class="text-3xl sm:text-4xl font-bold text-gray-900 mt-2">
                                    {{ $acaras->where('status', 'published')->count() }}</p>
                            </div>
                            <div class="flex-shrink-0 w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Draft -->
                    <div
                        class="bg-white border border-gray-200 rounded-xl p-5 sm:p-6 hover:border-amber-300 transition-colors duration-200 sm:col-span-2 lg:col-span-1">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600">Draft</p>
                                <p class="text-3xl sm:text-4xl font-bold text-gray-900 mt-2">
                                    {{ $acaras->where('status', 'draft')->count() }}</p>
                            </div>
                            <div class="flex-shrink-0 w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center">
                                <i data-lucide="clock" class="w-6 h-6 text-amber-600"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter Section -->
                @livewire('pembuat.daftar-acara')
            @endrole
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</x-app-layout>
