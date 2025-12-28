<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 mx-auto max-w-5xl">
            <i data-lucide="calendar" class="size-5 text-gray-600"></i>
            <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
            <p class="text-gray-400 ">Daftar peserta <span
                    class="font-medium text-gray-600">{{ $acara->nama_acara }}</span></p>
        </div>
    </x-slot>
    <div class="max-w-5xl mx-auto pb-6 md:py-10">
        <div class="mx-auto px-6 lg:px-0">
            <!-- Header -->
            <div class="relative rounded-xl px-6 py-12 mb-6 text-white overflow-hidden">
                {{-- Background banner_acara --}}
                @if (!empty($acara->banner_acara))
                    <div class="absolute inset-0">
                        <img src="{{ \Illuminate\Support\Str::startsWith($acara->banner_acara, ['http://', 'https://']) ? $acara->banner_acara : asset('storage/' . $acara->banner_acara) }}"
                            alt="Banner Acara" class="w-full h-full object-cover">
                    </div>
                @endif
                {{-- Overlay gradient agar teks tetap terbaca --}}
                <div class="absolute inset-0 bg-gradient-to-r from-gray-600/80 to-gray-50/10"></div>

                <div class="relative flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2 text-indigo-200 text-sm mb-1">
                            <i data-lucide="users" class="size-4"></i>
                            Daftar Peserta
                        </div>
                        <h1 class="text-2xl font-bold">{{ $acara->nama_acara }}</h1>
                        @if ($acara->is_online)
                            <div class="flex items-center gap-2 text-indigo-200 text-sm mt-2">
                                <i data-lucide="video" class="size-4"></i>
                                Acara Online
                            </div>
                        @endif
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        <span class="text-sm">Total Peserta</span>
                        <p class="text-2xl font-bold">{{ count($peserta) }}</p>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <!-- Search & Filter di atas tabel -->
                <div class="px-4 md:px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1 relative">
                            <i data-lucide="search"
                                class="size-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="searchInput" placeholder="Cari nama peserta atau kode tiket..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        @if (!$acara->is_online)
                            <select id="filterStatus"
                                class="px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 md:w-48">
                                <option value="">Semua Status</option>
                                <option value="sudah_digunakan">Sudah Check-in</option>
                                <option value="belum_digunakan">Belum Check-in</option>
                            </select>
                        @endif
                    </div>
                </div>
                <!-- Mobile Card View -->
                <div class="block md:hidden">
                    @forelse ($peserta as $item)
                        <div class="p-4 border-b border-gray-100 peserta-row"
                            data-nama="{{ strtolower($item->nama_peserta) }}"
                            data-kode="{{ strtolower($item->kode_tiket) }}" data-status="{{ $item->status_checkin }}">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-3 flex-1">
                                    <div
                                        class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-semibold flex-shrink-0">
                                        {{ strtoupper(substr($item->nama_peserta, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $item->nama_peserta }}
                                        </p>
                                        <p class="text-xs text-indigo-600 font-medium mt-1">{{ $item->jenis_tiket }}</p>
                                    </div>
                                </div>
                                @if (!$acara->is_online)
                                    <div class="flex-shrink-0 ml-3">
                                        @if ($item->status_checkin == 'sudah_digunakan')
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                <i data-lucide="check-circle" class="size-3"></i>
                                                Check-in
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                                <i data-lucide="clock" class="size-3"></i>
                                                Pending
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <div class="flex flex-col items-center">
                                <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center mb-4">
                                    <i data-lucide="users" class="size-8 text-indigo-400"></i>
                                </div>
                                <p class="text-gray-500 font-medium">Belum ada peserta</p>
                                <p class="text-sm text-gray-400 mt-1">Peserta akan muncul setelah ada pembelian tiket
                                </p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="user" class="size-4"></i>
                                        Peserta
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">
                                    <div class="flex items-center justify-center gap-2">
                                        <i data-lucide="ticket" class="size-4"></i>
                                        Jenis Tiket
                                    </div>
                                </th>
                                @if (!$acara->is_online)
                                    <th class="px-6 py-3 text-right text-sm font-medium text-gray-700">
                                        <div class="flex items-center justify-end gap-2">
                                            <i data-lucide="check-circle" class="size-4"></i>
                                            Status Check-in
                                        </div>
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="pesertaTableBody">
                            @forelse ($peserta as $item)
                                <tr class="hover:bg-gray-50 transition-colors peserta-row"
                                    data-nama="{{ strtolower($item->nama_peserta) }}"
                                    data-kode="{{ strtolower($item->kode_tiket) }}"
                                    data-status="{{ $item->status_checkin }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-semibold">
                                                {{ strtoupper(substr($item->nama_peserta, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $item->nama_peserta }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <p class="text-sm font-medium text-indigo-700">{{ $item->jenis_tiket }}</p>
                                    </td>
                                    @if (!$acara->is_online)
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            @if ($item->status_checkin == 'sudah_digunakan')
                                                <span
                                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                    <i data-lucide="check-circle" class="size-3"></i>
                                                    Sudah Check-in
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                                    <i data-lucide="clock" class="size-3"></i>
                                                    Belum Check-in
                                                </span>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $acara->is_online ? 2 : 3 }}" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center mb-4">
                                                <i data-lucide="users" class="size-8 text-indigo-400"></i>
                                            </div>
                                            <p class="text-gray-500 font-medium">Belum ada peserta</p>
                                            <p class="text-sm text-gray-400 mt-1">Peserta akan muncul setelah ada
                                                pembelian tiket</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Info -->
                @if (count($peserta) > 0)
                    <div class="bg-gray-50 px-4 md:px-6 py-4 border-t border-gray-100">
                        <div
                            class="flex flex-col md:flex-row md:items-center justify-between text-sm text-gray-600 gap-3">
                            <span>Menampilkan <span id="visibleCount">{{ count($peserta) }}</span> dari
                                {{ count($peserta) }} peserta</span>
                            @if (!$acara->is_online)
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4">
                                    <span class="flex items-center gap-2">
                                        <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                        <span class="text-xs sm:text-sm">Sudah Check-in:
                                            {{ collect($peserta)->where('status_checkin', 'sudah_digunakan')->count() }}</span>
                                    </span>
                                    <span class="flex items-center gap-2">
                                        <span class="h-2 w-2 rounded-full bg-yellow-500"></span>
                                        <span class="text-xs sm:text-sm">Belum Check-in:
                                            {{ collect($peserta)->where('status_checkin', '!=', 'sudah_digunakan')->count() }}</span>
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const filterStatus = document.getElementById('filterStatus');
            const rows = document.querySelectorAll('.peserta-row');
            const visibleCount = document.getElementById('visibleCount');

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusFilter = filterStatus ? filterStatus.value : '';
                let count = 0;

                rows.forEach(row => {
                    const nama = row.dataset.nama;
                    const kode = row.dataset.kode;
                    const status = row.dataset.status;

                    const matchSearch = nama.includes(searchTerm) || kode.includes(searchTerm);
                    const matchStatus = !statusFilter || status === statusFilter;

                    if (matchSearch && matchStatus) {
                        row.style.display = '';
                        count++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (visibleCount) {
                    visibleCount.textContent = count;
                }
            }

            searchInput.addEventListener('input', filterTable);
            if (filterStatus) {
                filterStatus.addEventListener('change', filterTable);
            }
        });
    </script>
</x-app-layout>
