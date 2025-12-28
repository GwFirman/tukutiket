<x-admin>
    <x-slot:header>
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Dashboard Admin</h2>
                <p class="text-gray-600 text-sm mt-1">Selamat datang di panel administrasi</p>
            </div>
        </div>
    </x-slot:header>

    <div class="p-6 space-y-6 max-w-6xl mx-auto px-0 lg:px-10">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-12 rounded-lg "
            style="background-image: url('{{ asset('images/blue-gradient.jpg') }}'); background-size: cover; background-position: center;">
            <!-- Optional overlay for readability -->
            <div class="col-span-1 md:col-span-2 lg:col-span-4 -m-12 p-12 rounded-lg ">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Total Event -->
                    <div class="bg-white/50 backdrop-blur-lg  rounded-lg p-6">

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Event</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalEvents }}</p>
                            </div>
                            <div class="bg-indigo-100 p-3 rounded-lg">
                                <i data-lucide="calendar" class="w-6 h-6 text-indigo-600"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Kreator -->
                    <div class="bg-white/50 backdrop-blur-lg rounded-lg  p-6  ">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Kreator</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalKreators }}</p>
                            </div>
                            <div class="bg-indigo-100 p-3 rounded-lg">
                                <i data-lucide="users" class="w-6 h-6 text-indigo-600"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Pengguna -->
                    <div class="bg-white/50 backdrop-blur-lg rounded-lg  p-6 ">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Pengguna</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalPembeli }}</p>
                            </div>
                            <div class="bg-indigo-100 p-3 rounded-lg">
                                <i data-lucide="users-round" class="w-6 h-6 text-indigo-600"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Transaksi -->
                    <div class="bg-white/50 backdrop-blur-lg rounded-lg  p-6 ">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Transaksi</p>
                                <p class="text-lg font-bold text-gray-900 mt-2">{{ $totalTransaksi }}</p>
                            </div>
                            <div class="bg-indigo-100 p-3 rounded-lg">
                                <i data-lucide="chart-no-axes-combined" class="w-6 h-6 text-indigo-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Pending Moderasi Event -->
            <div class="bg-white rounded-lg ">
                <img src="{{ asset('images/concert3.jpg') }}" alt="Total Event"
                    class="w-full h-32 object-cover rounded-t-lg ">
                <div class="p-6  rounded-b-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Event Pending</h3>
                        <span
                            class="bg-indigo-100 text-indigo-800 text-xs font-bold px-2 py-1 shrink-0 rounded-full ">5</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">Event yang menunggu moderasi</p>
                    <a href="#"
                        class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium">
                        Lihat Semua
                        <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Pending Verifikasi Kreator -->
            <div class="bg-white rounded-lg ">
                <img src="{{ asset('images/EO.jpg') }}" alt="Total Event"
                    class="w-full h-32 object-cover rounded-t-lg ">
                <div class="p-6  rounded-b-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Verifikasi kreator</h3>
                        <span
                            class="bg-indigo-100 text-indigo-800 text-xs font-bold px-2 py-1 shrink-0 rounded-full ">5</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">Kreator yang menunggu verifikasi data</p>
                    <a href="#"
                        class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium">
                        Lihat Semua
                        <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg  p-6 ">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Aktivitas Terbaru</h3>
                <div class="space-y-3">
                    <div class="flex items-start text-sm">
                        <div class="bg-green-100 p-2 rounded-full mr-3">
                            <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-900 font-medium">Event disetujui</p>
                            <p class="text-gray-500 text-xs">5 menit yang lalu</p>
                        </div>
                    </div>
                    <div class="flex items-start text-sm">
                        <div class="bg-blue-100 p-2 rounded-full mr-3">
                            <i data-lucide="user-plus" class="w-4 h-4 text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-900 font-medium">Kreator baru terdaftar</p>
                            <p class="text-gray-500 text-xs">1 jam yang lalu</p>
                        </div>
                    </div>
                    <div class="flex items-start text-sm">
                        <div class="bg-purple-100 p-2 rounded-full mr-3">
                            <i data-lucide="credit-card" class="w-4 h-4 text-purple-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-900 font-medium">Transaksi besar masuk</p>
                            <p class="text-gray-500 text-xs">2 jam yang lalu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin>
