<x-admin>
    <x-slot:header>
        <div class="flex items-center justify-between ">
            <div class="flex items-center gap-2">
                <i data-lucide="shield" class="size-5 text-gray-600"></i>
                <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
                <p class="font-medium">Moderasi Kreator</p>
            </div>

        </div>
    </x-slot:header>

    <div class="max-w-6xl mx-auto px-6 lg:px-10 py-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Moderasi Kreator</h1>
            <p class="text-sm text-gray-600 mt-1">Kelola pengajuan menjadi kreator</p>
        </div>
        <!-- Flash Message -->
        @if (session('success'))
            <div
                class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2 mb-4">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap- mb-42">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
                {{ session('error') }}
            </div>
        @endif



        <!-- Status Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-8 rounded-lg"
            style="background-image: url('{{ asset('images/gradient2.jpg') }}'); background-size: cover; background-position: center;">
            <!-- Optional overlay for readability -->
            <div class="col-span-1 md:col-span-3 -m-8 p-8 rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-indigo-800/30 backdrop-blur-md rounded-lg p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white text-sm font-medium">Pending Review</p>
                                <p class="text-3xl font-bold text-indigo-50 mt-1">{{ $stats['pending'] ?? 0 }}</p>
                            </div>
                            <div class="bg-indigo-100 p-3 rounded-xl">
                                <i data-lucide="clock" class="w-6 h-6 text-indigo-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-indigo-800/30 backdrop-blur-md rounded-lg p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white text-sm font-medium">Disetujui</p>
                                <p class="text-3xl font-bold text-indigo-50 mt-1">{{ $stats['approved'] ?? 0 }}</p>
                            </div>
                            <div class="bg-indigo-100 p-3 rounded-xl">
                                <i data-lucide="check-circle" class="w-6 h-6 text-indigo-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-indigo-800/30 backdrop-blur-md rounded-lg p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white text-sm font-medium">Ditolak</p>
                                <p class="text-3xl font-bold text-indigo-50 mt-1">{{ $stats['rejected'] ?? 0 }}</p>
                            </div>
                            <div class="bg-indigo-100 p-3 rounded-xl">
                                <i data-lucide="x-circle" class="w-6 h-6 text-indigo-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Verifikasi -->
        <div class="bg-white rounded-xl  border border-gray-200 overflow-hidden mt-6">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-white">
                <h3 class="text-lg font-semibold text-gray-900">Daftar Verifikasi Kreator</h3>
            </div>
            <!-- Filter dan Search Compact -->

            <div class="px-6 py-3 border-b border-gray-200 bg-gray-50">
                <form method="GET" action="{{ route('admin.mod-kreator') }}"
                    class="flex flex-col sm:flex-row items-center gap-3">
                    <div class="w-full sm:w-48">
                        <select name="status"
                            class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak
                            </option>
                        </select>
                    </div>
                    <div class="w-full sm:flex-1">
                        <div class="relative">
                            <i data-lucide="search"
                                class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari kreator..."
                                class="w-full pl-9 pr-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button type="submit"
                            class="flex-1 sm:flex-none px-3 py-1.5 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition-colors inline-flex items-center justify-center gap-1">
                            <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                            Filter
                        </button>
                        <a href="{{ route('admin.mod-kreator') }}"
                            class="flex-1 sm:flex-none px-3 py-1.5 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium transition-colors text-center">
                            Reset
                        </a>
                    </div>
                </form>
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
                                            class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-50 hover:text-indigo-500 transition-colors">
                                            <i data-lucide="eye" class="size-4 mr-1"></i>
                                            Review
                                        </a>
                                    @else
                                        <a href="{{ route('admin.mod-kreator.show', $verifikasi->id) }}"
                                            class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                            <i data-lucide="eye" class="size-4 mr-1"></i>
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
