<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Dashboard Header -->
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-800">Dashboard Pembuat Acara</h1>
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                    + Buat Acara Baru
                </button>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between">
                        <div>
                            <h2 class="text-gray-500 text-sm">Total Acara</h2>
                            <p class="text-3xl font-bold">12</p>
                        </div>
                        <div class="bg-indigo-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between">
                        <div>
                            <h2 class="text-gray-500 text-sm">Tiket Terjual</h2>
                            <p class="text-3xl font-bold">384</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between">
                        <div>
                            <h2 class="text-gray-500 text-sm">Pendapatan</h2>
                            <p class="text-3xl font-bold">Rp 12.5jt</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between">
                        <div>
                            <h2 class="text-gray-500 text-sm">Pengunjung</h2>
                            <p class="text-3xl font-bold">1,254</p>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Events Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-lg font-semibold mb-4">Acara Terbaru</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Acara</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiket Terjual</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Konser Musik Jazz</td>
                                    <td class="px-6 py-4 whitespace-nowrap">24 Mei 2024</td>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span></td>
                                    <td class="px-6 py-4 whitespace-nowrap">128/200</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Workshop Design</td>
                                    <td class="px-6 py-4 whitespace-nowrap">12 Juni 2024</td>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Akan Datang</span></td>
                                    <td class="px-6 py-4 whitespace-nowrap">45/100</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Seminar Teknologi</td>
                                    <td class="px-6 py-4 whitespace-nowrap">3 April 2024</td>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Selesai</span></td>
                                    <td class="px-6 py-4 whitespace-nowrap">200/200</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Lihat Laporan</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg mb-4">Menu Cepat</h3>
                        <div class="space-y-3">
                            <a href="#" class="flex items-center text-gray-700 hover:text-indigo-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Buat Acara Baru
                            </a>
                            <a href="#" class="flex items-center text-gray-700 hover:text-indigo-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                Laporan Keuangan
                            </a>
                            <a href="#" class="flex items-center text-gray-700 hover:text-indigo-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                Kelola Pengguna
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg mb-4">Penjualan per Bulan</h3>
                        <div class="h-48 flex items-end space-x-2">
                            <div class="bg-indigo-500 w-6 rounded-t" style="height: 30%"></div>
                            <div class="bg-indigo-500 w-6 rounded-t" style="height: 45%"></div>
                            <div class="bg-indigo-500 w-6 rounded-t" style="height: 70%"></div>
                            <div class="bg-indigo-500 w-6 rounded-t" style="height: 90%"></div>
                            <div class="bg-indigo-500 w-6 rounded-t" style="height: 60%"></div>
                            <div class="bg-indigo-500 w-6 rounded-t" style="height: 75%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg mb-4">Notifikasi Terbaru</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <span class="h-8 w-8 rounded-full bg-green-200 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">5 tiket baru terjual untuk "Workshop Design"</p>
                                    <p class="text-xs text-gray-500">20 menit yang lalu</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <span class="h-8 w-8 rounded-full bg-yellow-200 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Pembayaran untuk "Seminar Teknologi" berhasil</p>
                                    <p class="text-xs text-gray-500">1 jam yang lalu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
