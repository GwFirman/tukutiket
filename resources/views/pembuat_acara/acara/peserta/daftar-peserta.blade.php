<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl p-6 mb-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold flex items-center gap-2">
                            <i data-lucide="users" class="size-6"></i>
                            Daftar Peserta
                        </h2>
                        <p class="text-indigo-100 mt-1">Kelola dan lihat semua peserta acara Anda</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        <span class="text-sm">Total Peserta</span>
                        <p class="text-2xl font-bold">{{ count($peserta) }}</p>
                    </div>
                </div>
            </div>

            <!-- Search & Filter -->
            <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <i data-lucide="search"
                            class="size-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="searchInput" placeholder="Cari nama peserta atau kode tiket..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <select id="filterStatus"
                        class="px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Status</option>
                        <option value="sudah_digunakan">Sudah Check-in</option>
                        <option value="belum_digunakan">Belum Check-in</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-indigo-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="user" class="size-4"></i>
                                        Peserta
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                                    <div class="flex items-center justify-center gap-2">
                                        <i data-lucide="ticket" class="size-4"></i>
                                        Jenis Tiket
                                    </div>
                                </th>
                                {{-- <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="hash" class="size-4"></i>
                                        Kode Tiket
                                    </div>
                                </th> --}}
                                <th
                                    class="px-6 py-4 text-end text-xs font-semibold text-indigo-700 uppercase tracking-wider ">
                                    <div class="flex items-center justify-end gap-2 ">
                                        <i data-lucide="check-circle" class="size-4"></i>
                                        <p>
                                            Status Check-in
                                        </p>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100" id="pesertaTableBody">
                            @forelse ($peserta as $item)
                                <tr class="hover:bg-indigo-50/50 transition-colors peserta-row"
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
                                                {{-- <p class="text-xs text-gray-500">{{ $item->email_peserta ?? '-' }}</p> --}}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <p class=" text-sm font-medium  text-indigo-700">
                                            {{ $item->jenis_tiket }}
                                        </p>
                                    </td>
                                    {{-- <td class="px-6 py-4 whitespace-nowrap">
                                        <code
                                            class="px-2 py-1 bg-gray-100 rounded text-sm font-mono text-indigo-600">{{ $item->kode_tiket }}</code>
                                    </td> --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        @if ($item->status_checkin == 'sudah_digunakan')
                                            <span
                                                class="inline-flex items-center  gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                <i data-lucide="check-circle" class="size-3"></i>
                                                <p> Sudah Check-in </p>
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center  gap-1 px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                                <i data-lucide="clock" class="size-3"></i>
                                                <p>
                                                    Belum Check-in
                                                </p>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
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
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <span>Menampilkan <span id="visibleCount">{{ count($peserta) }}</span> dari
                                {{ count($peserta) }} peserta</span>
                            <div class="flex items-center gap-4">
                                <span class="flex items-center gap-1">
                                    <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                    Sudah Check-in:
                                    {{ collect($peserta)->where('status_checkin', 'sudah_digunakan')->count() }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <span class="h-2 w-2 rounded-full bg-yellow-500"></span>
                                    Belum Check-in:
                                    {{ collect($peserta)->where('status_checkin', '!=', 'sudah_digunakan')->count() }}
                                </span>
                            </div>
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
                const statusFilter = filterStatus.value;
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
            filterStatus.addEventListener('change', filterTable);
        });
    </script>
</x-app-layout>
