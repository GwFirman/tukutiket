<x-app-layout>
    <div class="max-w-6xl mx-auto pb-6 md:py-10 px-6">

        {{-- Header --}}
        <div class="relative rounded-xl px-6 py-12 mb-8 text-white overflow-hidden">
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
                        <i data-lucide="credit-card" class="size-4"></i>
                        Laporan Transaksi
                    </div>
                    <h1 class="text-2xl font-bold">{{ $acara->nama_acara }}</h1>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                    <span class="text-sm">Total Transaksi</span>
                    <p class="text-2xl font-bold">{{ $ringkasan->total_transaksi }}</p>
                </div>
            </div>
        </div>

        {{-- Ringkasan Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-5 border border-indigo-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Transaksi</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $ringkasan->total_transaksi }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center">
                        <i data-lucide="receipt" class="size-6 text-indigo-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-5 border border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-gray-800">
                            Rp {{ number_format($ringkasan->total_pendapatan, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                        <i data-lucide="wallet" class="size-6 text-green-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-5 border border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Pending</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $ringkasan->transaksi_pending }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-yellow-100 flex items-center justify-center">
                        <i data-lucide="clock" class="size-6 text-yellow-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-5 border border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Berhasil</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $ringkasan->transaksi_completed }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <i data-lucide="check-circle" class="size-6 text-purple-600"></i>
                    </div>
                </div>
            </div>
        </div>



        {{-- Daftar Transaksi --}}
        <div class="bg-white shadow-sm rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Transaksi</h2>
            </div>
            <!-- Search & Filter -->
            <div class="m-4">
                <div class="flex gap-4 justify-between">
                    <div class="flex">
                        <div class="relative">
                            <i data-lucide="search"
                                class="size-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="searchInput" placeholder="Cari "
                                class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <button type="button"
                            class="ml-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <i data-lucide="search" class="size-4"></i>
                        </button>
                    </div>
                    <select id="filterStatus"
                        class="px-4 py-2 Q Wborder border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="paid">Berhasil</option>
                        <option value="failed">Gagal</option>
                        <option value="expired">Kadaluarsa</option>
                    </select>
                </div>
            </div>
            <!-- Mobile Card View -->
            <div class="block md:hidden">
                @forelse ($pesanan as $item)
                    <div class="p-4 border-b border-gray-100 transaksi-row"
                        data-kode="{{ strtolower($item->kode_pesanan) }}"
                        data-nama="{{ strtolower($item->nama_pemesan) }}" data-status="{{ $item->status_pembayaran }}">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3 flex-1">
                                <div
                                    class="h-10 w-10 rounded-lg bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-semibold flex-shrink-0">
                                    {{ strtoupper(substr($item->nama_pemesan, 0, 1)) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $item->nama_pemesan }}</p>
                                    <p class="text-xs text-gray-600 font-mono mt-1">{{ $item->kode_pesanan }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $item->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end flex-shrink-0 ml-3">
                                <p class="text-sm font-bold text-green-600 mb-1">Rp
                                    {{ number_format($item->total_harga, 0, ',', '.') }}</p>
                                @if ($item->status_pembayaran == 'paid')
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        <i data-lucide="check-circle" class="size-3"></i>
                                        Berhasil
                                    </span>
                                @elseif ($item->status_pembayaran == 'pending')
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                        <i data-lucide="clock" class="size-3"></i>
                                        Pending
                                    </span>
                                @elseif ($item->status_pembayaran == 'failed')
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        <i data-lucide="x-circle" class="size-3"></i>
                                        Gagal
                                    </span>
                                @elseif ($item->status_pembayaran == 'expired')
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                        <i data-lucide="clock" class="size-3"></i>
                                        Kadaluarsa
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                        <i data-lucide="help-circle" class="size-3"></i>
                                        {{ ucfirst($item->status_pembayaran) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="flex flex-col items-center">
                            <div class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                <i data-lucide="credit-card" class="size-8 text-gray-400"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Belum ada transaksi</p>
                            <p class="text-sm text-gray-400 mt-1">Transaksi akan muncul setelah ada pembelian tiket</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Kode Pesanan</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Pemesan</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Total</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Tanggal</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Status</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($pesanan as $item)
                            <tr class="hover:bg-gray-50 transition-colors transaksi-row"
                                data-kode="{{ strtolower($item->kode_pesanan) }}"
                                data-nama="{{ strtolower($item->nama_pemesan) }}"
                                data-status="{{ $item->status_pembayaran }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <code
                                        class="px-2 py-1 bg-gray-100 rounded text-sm font-mono text-indigo-600">{{ $item->kode_pesanan }}</code>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($item->nama_pemesan, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $item->nama_pemesan }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->email_pemesan }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <p class="text-sm font-bold text-green-600">Rp
                                        {{ number_format($item->total_harga, 0, ',', '.') }}</p>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-500">
                                    {{ $item->created_at->format('d M Y') }}<br>
                                    <span class="text-xs">{{ $item->created_at->format('H:i') }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($item->status_pembayaran == 'paid')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            <i data-lucide="check-circle" class="size-3"></i>
                                            Berhasil
                                        </span>
                                    @elseif ($item->status_pembayaran == 'pending')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                            <i data-lucide="clock" class="size-3"></i>
                                            Pending
                                        </span>
                                    @elseif ($item->status_pembayaran == 'failed')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                            <i data-lucide="x-circle" class="size-3"></i>
                                            Gagal
                                        </span>
                                    @elseif ($item->status_pembayaran == 'expired')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                            <i data-lucide="clock" class="size-3"></i>
                                            Kadaluarsa
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                            <i data-lucide="help-circle" class="size-3"></i>
                                            {{ ucfirst($item->status_pembayaran) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if ($item->status_pembayaran == 'pending')
                                            <a href="{{ route('pembuat.transaksi.acc', [$acara->slug, $item->kode_pesanan]) }}"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-colors">
                                                <i data-lucide="eye" class="size-3"></i>
                                                Verifikasi
                                            </a>
                                        @elseif ($item->status_pembayaran == 'paid')
                                            <a href="{{ route('pembuat.transaksi.acc', [$acara->slug, $item->kode_pesanan]) }}"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-lg transition-colors">
                                                <i data-lucide="eye" class="size-3"></i>
                                                Detail
                                            </a>
                                        @else
                                            <a href="{{ route('pembuat.transaksi.acc', [$acara->slug, $item->kode_pesanan]) }}"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-lg transition-colors">
                                                <i data-lucide="eye" class="size-3"></i>
                                                Lihat
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                            <i data-lucide="credit-card" class="size-8 text-gray-400"></i>
                                        </div>
                                        <p class="text-gray-500 font-medium">Belum ada transaksi</p>
                                        <p class="text-sm text-gray-400 mt-1">Transaksi akan muncul setelah ada
                                            pembelian tiket</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Info -->
            @if (count($pesanan) > 0)
                <div class="bg-gray-50 px-4 md:px-6 py-4 border-t border-gray-100">
                    <div class="flex flex-col md:flex-row md:items-center justify-between text-sm text-gray-600 gap-3">
                        <span>Menampilkan <span id="visibleCount">{{ count($pesanan) }}</span> dari
                            {{ count($pesanan) }} transaksi</span>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4">
                            <span class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                <span class="text-xs sm:text-sm">Berhasil:
                                    {{ $pesanan->where('status_pembayaran', 'paid')->count() }}</span>
                            </span>
                            <span class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-yellow-500"></span>
                                <span class="text-xs sm:text-sm">Pending:
                                    {{ $pesanan->where('status_pembayaran', 'pending')->count() }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const filterStatus = document.getElementById('filterStatus');
            const rows = document.querySelectorAll('.transaksi-row');
            const visibleCount = document.getElementById('visibleCount');

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusFilter = filterStatus.value;
                let count = 0;

                rows.forEach(row => {
                    const kode = row.dataset.kode;
                    const nama = row.dataset.nama;
                    const status = row.dataset.status;

                    const matchSearch = kode.includes(searchTerm) || nama.includes(searchTerm);
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
