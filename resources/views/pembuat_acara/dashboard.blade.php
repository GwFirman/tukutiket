<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i data-lucide="home" class="size-5 text-indigo-600"></i>
            <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
            <p class="font-medium text-gray-700">Dashboard</p>
        </div>
    </x-slot>
    <div class="bg-transparent">
        <div class="px-6 lg:px-24 py-6">
            <!-- Dashboard Header -->
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-indigo-800">Dashboard Pembuat Acara</h1>
                    <p class="text-gray-600 mt-2 flex items-center gap-2">
                        <i data-lucide="sparkles" class="w-4 h-4 text-indigo-500"></i>
                        Kelola dan monitor acara Anda
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:block text-sm text-gray-500">Terakhir diperbarui: {{ now()->format('d M Y') }}
                    </div>
                    <a href="{{ route('pembuat.acara.create') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-transform transform hover:scale-105">
                        <i data-lucide="plus-circle" class="w-5 h-5 mr-2"></i>
                        Buat Acara Baru
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div
                    class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div
                    class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-lg flex items-center gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div
                    class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all border border-indigo-100 p-6 group relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-50 to-transparent rounded-full -mr-16 -mt-16 opacity-50">
                    </div>
                    <div class="relative flex justify-between items-start">
                        <div class="flex-1">
                            <p class="text-sm text-indigo-600 font-semibold mb-1">Total Acara</p>
                            <p class="text-4xl font-bold text-gray-900 mb-1">{{ $totalAcara }}</p>
                            <p class="text-xs text-gray-500"><i data-lucide="calendar"
                                    class="w-3 h-3 inline text-indigo-500"></i> Acara aktif</p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-indigo-500 to-purple-600 p-3 rounded-xl text-white shadow-lg">
                            <i data-lucide="calendar" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all border border-indigo-100 p-6 group relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-50 to-transparent rounded-full -mr-16 -mt-16 opacity-50">
                    </div>
                    <div class="relative flex justify-between items-start">
                        <div class="flex-1">
                            <p class="text-sm text-indigo-600 font-semibold mb-1">Tiket Terjual</p>
                            <p class="text-4xl font-bold text-gray-900 mb-1">{{ $totalTiketTerjual }}</p>
                            <p class="text-xs text-gray-500"><i data-lucide="ticket"
                                    class="w-3 h-3 inline text-indigo-500"></i> Total penjualan</p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-indigo-500 to-purple-600 p-3 rounded-xl text-white shadow-lg">
                            <i data-lucide="ticket" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all border border-indigo-100 p-6 group relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-50 to-transparent rounded-full -mr-16 -mt-16 opacity-50">
                    </div>
                    <div class="relative flex justify-between items-start">
                        <div class="flex-1">
                            <p class="text-sm text-indigo-600 font-semibold mb-1">Pendapatan</p>
                            <p class="text-3xl font-bold text-gray-900 mb-1">Rp
                                {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500"><i data-lucide="banknote"
                                    class="w-3 h-3 inline text-indigo-500"></i> Total pendapatan</p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-indigo-500 to-purple-600 p-3 rounded-xl text-white shadow-lg">
                            <i data-lucide="banknote" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all border border-indigo-100 p-6 group relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-50 to-transparent rounded-full -mr-16 -mt-16 opacity-50">
                    </div>
                    <div class="relative flex justify-between items-start">
                        <div class="flex-1">
                            <p class="text-sm text-indigo-600 font-semibold mb-1">Pengunjung</p>
                            <p class="text-4xl font-bold text-gray-900 mb-1">{{ $totalPeserta }}</p>
                            <p class="text-xs text-gray-500"><i data-lucide="users"
                                    class="w-3 h-3 inline text-indigo-500"></i> Total peserta</p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-indigo-500 to-purple-600 p-3 rounded-xl text-white shadow-lg">
                            <i data-lucide="users" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Info -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-md border border-indigo-100 p-7 hover:shadow-xl transition-all">
                    <h3 class="font-bold text-lg text-gray-900 mb-5 flex items-center gap-3">
                        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-2.5 rounded-xl shadow-sm">
                            <i data-lucide="zap" class="w-5 h-5 text-white"></i>
                        </div>
                        Aksi Cepat
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('pembuat.acara.create') }}"
                            class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all border border-gray-200 hover:border-indigo-200">
                            <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                                <i data-lucide="plus-circle" class="w-5 h-5 text-indigo-600"></i>
                            </div>
                            <span class="font-medium">Buat Acara Baru</span>
                        </a>
                        <a href="{{ route('pembuat.acara.index') }}"
                            class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all border border-gray-200 hover:border-indigo-200">
                            <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                                <i data-lucide="list" class="w-5 h-5 text-indigo-600"></i>
                            </div>
                            <span class="font-medium">Lihat Semua Acara</span>
                        </a>
                        <a href="{{ route('pembuat.profile') }}"
                            class="flex items-center px-4 py-3.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all border border-gray-200 hover:border-indigo-200">
                            <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                                <i data-lucide="user-cog" class="w-5 h-5 text-indigo-600"></i>
                            </div>
                            <span class="font-medium">Pengaturan Profil</span>
                        </a>
                    </div>
                </div>

                <!-- Statistics Overview -->
                <div
                    class="bg-white rounded-2xl shadow-md border border-indigo-100 p-7 hover:shadow-xl transition-all">
                    <h3 class="font-bold text-lg text-gray-900 mb-5 flex items-center gap-3">
                        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-2.5 rounded-xl shadow-sm">
                            <i data-lucide="bar-chart-3" class="w-5 h-5 text-white"></i>
                        </div>
                        Ringkasan Penjualan
                    </h3>
                    <div class="space-y-5">
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-sm text-gray-600 font-medium">Tiket Terjual</span>
                                <span class="text-sm font-bold text-indigo-600">{{ $totalTiketTerjual }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2.5 rounded-full transition-all duration-500 shadow-lg shadow-indigo-500/30"
                                    style="width: 65%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-sm text-gray-600 font-medium">Acara Aktif</span>
                                <span class="text-sm font-bold text-indigo-600">{{ $totalAcara }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2.5 rounded-full transition-all duration-500 shadow-lg shadow-indigo-500/30"
                                    style="width: 75%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-sm text-gray-600 font-medium">Tingkat Konversi</span>
                                <span class="text-sm font-bold text-indigo-600">42%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2.5 rounded-full transition-all duration-500 shadow-lg shadow-indigo-500/30"
                                    style="width: 42%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div
                    class="bg-white rounded-2xl shadow-md border border-indigo-100 p-7 hover:shadow-xl transition-all">
                    <h3 class="font-bold text-lg text-gray-900 mb-5 flex items-center gap-3">
                        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-2.5 rounded-xl shadow-sm">
                            <i data-lucide="activity" class="w-5 h-5 text-white"></i>
                        </div>
                        Aktivitas Terbaru
                    </h3>
                    <div class="space-y-4">
                        <div
                            class="flex items-start group cursor-pointer p-3 -mx-3 rounded-xl hover:bg-indigo-50 transition-colors">
                            <div
                                class="bg-gradient-to-br from-indigo-100 to-purple-100 p-2.5 rounded-xl mr-3 flex-shrink-0 group-hover:scale-110 transition-transform">
                                <i data-lucide="check-circle-2" class="w-4 h-4 text-indigo-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Tiket baru terjual</p>
                                <p class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                    <i data-lucide="clock" class="w-3 h-3"></i>
                                    5 menit lalu
                                </p>
                            </div>
                        </div>
                        <div
                            class="flex items-start group cursor-pointer p-3 -mx-3 rounded-xl hover:bg-indigo-50 transition-colors">
                            <div
                                class="bg-gradient-to-br from-indigo-100 to-purple-100 p-2.5 rounded-xl mr-3 flex-shrink-0 group-hover:scale-110 transition-transform">
                                <i data-lucide="user-plus" class="w-4 h-4 text-indigo-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Pendaftar baru</p>
                                <p class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                    <i data-lucide="clock" class="w-3 h-3"></i>
                                    15 menit lalu
                                </p>
                            </div>
                        </div>
                        <div
                            class="flex items-start group cursor-pointer p-3 -mx-3 rounded-xl hover:bg-indigo-50 transition-colors">
                            <div
                                class="bg-gradient-to-br from-indigo-100 to-purple-100 p-2.5 rounded-xl mr-3 flex-shrink-0 group-hover:scale-110 transition-transform">
                                <i data-lucide="credit-card" class="w-4 h-4 text-indigo-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Pembayaran diterima</p>
                                <p class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                    <i data-lucide="clock" class="w-3 h-3"></i>
                                    1 jam lalu
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
