<x-admin>
    <x-slot:header>
        <div class="flex items-center justify-between mx-2">
            <div class="flex items-center gap-2 mb-4">
                <i data-lucide="shield" class="size-5 text-gray-600"></i>
                <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
                <p class="font-medium">Moderasi Kreator</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm font-medium">
                    {{ $stats['pending'] ?? 0 }} Menunggu Review
                </span>
            </div>
        </div>
    </x-slot:header>

    <div class="p-6 space-y-6 max-w-7xl mx-auto">
        <!-- Flash Message -->
        @if (session('success'))
            <div
                class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Filter dan Search -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form method="GET" action="{{ route('admin.mod-kreator') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak
                            </option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari Kreator</label>
                        <div class="relative">
                            <i data-lucide="search"
                                class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Nama atau email kreator..."
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="flex-1 px-4 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition-colors inline-flex items-center justify-center gap-2">
                            <i data-lucide="filter" class="w-4 h-4"></i>
                            Filter
                        </button>
                        <a href="{{ route('admin.mod-kreator') }}"
                            class="px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium transition-colors">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Status Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-br from-amber-50 to-white rounded-xl  border border-amber-100 p-5 ">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-700 text-sm font-medium">Pending Review</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['pending'] ?? 0 }}</p>
                    </div>
                    <div class="bg-amber-100 p-3 rounded-xl">
                        <i data-lucide="clock" class="w-6 h-6 text-amber-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-emerald-50 to-white rounded-xl  border border-emerald-100 p-5 ">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-700 text-sm font-medium">Disetujui</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['approved'] ?? 0 }}</p>
                    </div>
                    <div class="bg-emerald-100 p-3 rounded-xl">
                        <i data-lucide="check-circle" class="w-6 h-6 text-emerald-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-rose-50 to-white rounded-xl  border border-rose-100 p-5 ">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-rose-700 text-sm font-medium">Ditolak</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['rejected'] ?? 0 }}</p>
                    </div>
                    <div class="bg-rose-100 p-3 rounded-xl">
                        <i data-lucide="x-circle" class="w-6 h-6 text-rose-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Verifikasi -->
        <div class="bg-white rounded-xl  border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-white">
                <h3 class="text-lg font-semibold text-gray-900">Daftar Verifikasi Kreator</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Kreator</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Dokumen</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Tanggal</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($verifikasiData as $verifikasi)
                            <tr class="hover:bg-indigo-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ strtoupper(substr($verifikasi->kreator->user->name ?? 'N', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">
                                                {{ $verifikasi->kreator->user->name ?? 'N/A' }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $verifikasi->kreator->user->email ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @if ($verifikasi->foto_ktp)
                                            <span
                                                class="px-2.5 py-1 text-xs bg-indigo-100 text-indigo-700 rounded-full font-medium">
                                                <i data-lucide="id-card" class="w-3 h-3 inline mr-1"></i>KTP
                                            </span>
                                        @endif
                                        @if ($verifikasi->foto_npwp)
                                            <span
                                                class="px-2.5 py-1 text-xs bg-purple-100 text-purple-700 rounded-full font-medium">
                                                <i data-lucide="file-text" class="w-3 h-3 inline mr-1"></i>NPWP
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($verifikasi->status === 'pending')
                                        <span
                                            class="px-3 py-1.5 inline-flex items-center gap-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Pending
                                        </span>
                                    @elseif($verifikasi->status === 'approved')
                                        <span
                                            class="px-3 py-1.5 inline-flex items-center gap-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                            <i data-lucide="check" class="w-3 h-3"></i>
                                            Disetujui
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1.5 inline-flex items-center gap-1 text-xs font-semibold rounded-full bg-rose-100 text-rose-800">
                                            <i data-lucide="x" class="w-3 h-3"></i>
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $verifikasi->created_at->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $verifikasi->created_at->format('H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($verifikasi->status === 'pending')
                                        <a href="{{ route('admin.mod-kreator.show', $verifikasi->id) }}"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 text-white text-xs rounded-lg hover:bg-indigo-700 font-medium transition-colors shadow-sm">
                                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                            Review
                                        </a>
                                    @else
                                        <a href="{{ route('admin.mod-kreator.show', $verifikasi->id) }}"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 text-gray-700 text-xs rounded-lg border border-gray-300 hover:bg-gray-50 font-medium transition-colors">
                                            <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                            Lihat
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="bg-indigo-100 p-4 rounded-full mb-4">
                                            <i data-lucide="inbox" class="w-8 h-8 text-indigo-600"></i>
                                        </div>
                                        <p class="text-gray-900 font-medium mb-1">Tidak ada data verifikasi</p>
                                        <p class="text-gray-500 text-sm">Belum ada kreator yang mengajukan verifikasi
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($verifikasiData->total() > 0)
                <div
                    class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-gray-600">
                        Menampilkan <span
                            class="font-semibold text-gray-900">{{ $verifikasiData->firstItem() }}</span>
                        sampai <span class="font-semibold text-gray-900">{{ $verifikasiData->lastItem() }}</span>
                        dari <span class="font-semibold text-gray-900">{{ $verifikasiData->total() }}</span> data
                    </p>
                    <div>
                        {{ $verifikasiData->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin>
