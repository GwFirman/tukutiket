<x-admin>
    <x-slot name="header">
        <div class="flex max-w-7xl mx-auto items-center gap-2">
            <i data-lucide="shield-check" class="size-5 text-gray-600"></i>
            <i data-lucide="chevron-right" class="size-4 text-gray-400"></i>
            <span class="font-semibold text-gray-800">Verifikasi Izin acara </span>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-6xl mx-auto px-6 lg:px-10">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Verifikasi Acara</h1>
                        <p class="mt-2 text-gray-600">Kelola verifikasi dokumen acara yang diajukan oleh kreator</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg px-4 py-2">
                            <div class="flex items-center space-x-2">
                                <i data-lucide="clock" class="size-5 text-yellow-600"></i>
                                <span class="text-sm font-medium text-yellow-800">{{ $acaraPending->total() }} Acara
                                    Menunggu</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-8 rounded-lg mb-8"
                style="background-image: url('{{ asset('images/gradient2.jpg') }}'); background-size: cover; background-position: center;">
                <!-- Optional overlay for readability -->
                <div class="col-span-1 md:col-span-4 -m-8 p-8 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-indigo-800/30 backdrop-blur-md rounded-lg p-5">
                            <div class="flex items-center">
                                <div class="p-2 bg-indigo-100 rounded-lg">
                                    <i data-lucide="clock" class="size-6 text-indigo-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-white">Menunggu Verifikasi</p>
                                    <p class="text-2xl font-bold text-white">{{ $acaraPending->total() }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-indigo-800/30 backdrop-blur-md rounded-lg p-5">
                            <div class="flex items-center">
                                <div class="p-2 bg-indigo-100 rounded-lg">
                                    <i data-lucide="check-circle" class="size-6 text-indigo-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-white">Disetujui Hari Ini</p>
                                    <p class="text-2xl font-bold text-white">{{ $approvedToday->count() }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-indigo-800/30 backdrop-blur-md rounded-lg p-5">
                            <div class="flex items-center">
                                <div class="p-2 bg-indigo-100 rounded-lg">
                                    <i data-lucide="x-circle" class="size-6 text-indigo-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-red-100">Ditolak Hari Ini</p>
                                    <p class="text-2xl font-bold text-red-50">{{ $rejectedToday->count() }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-indigo-800/30 backdrop-blur-md rounded-lg p-5">
                            <div class="flex items-center">
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <i data-lucide="file-text" class="size-6 text-blue-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-blue-100">Total Dokumen</p>
                                    <p class="text-2xl font-bold text-blue-50">
                                        {{ $totalDocuments }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Events List -->
            <div class="bg-white rounded-lg  border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Acara Verifikasi</h2>
                </div>
                <div class="px-6 py-3 border-b border-gray-200 bg-gray-50">
                    <form method="GET" action="{{ route('admin.mod-kreator') }}"
                        class="flex flex-col sm:flex-row items-center gap-3">
                        <div class="w-full sm:w-48">
                            <select name="status"
                                class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                    Disetujui
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
                @if ($acaraPending->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acara
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kreator
                                    </th>

                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($acaraPending as $acara)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if ($acara->banner_acara)
                                                        <img class="h-10 w-10 rounded-lg object-cover"
                                                            src="{{ asset('storage/' . $acara->banner_acara) }}"
                                                            alt="{{ $acara->nama_acara }}">
                                                    @else
                                                        <div
                                                            class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                                            <i data-lucide="calendar"
                                                                class="size-5 text-gray-400"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $acara->nama_acara }}</div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ Str::limit(strip_tags($acara->deskripsi), 50) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $acara->kreator->nama_kreator ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $acara->kreator->user->email ?? 'N/A' }}</div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($acara->status === 'pending_verifikasi')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i data-lucide="clock" class="size-3 mr-1"></i>
                                                    Pending
                                                </span>
                                            @elseif ($acara->status === 'published')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i data-lucide="check" class="size-3 mr-1"></i>
                                                    Disetujui
                                                </span>
                                            @elseif ($acara->status === 'rejected')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i data-lucide="x-circle" class="size-3 mr-1"></i>
                                                    Ditolak
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <i data-lucide="help-circle" class="size-3 mr-1"></i>
                                                    {{ ucfirst(str_replace('_', ' ', $acara->status)) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                <a href="{{ route('admin.mod-izin.show', $acara->slug) }}"
                                                    class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                                    <i data-lucide="eye" class="size-4 mr-1"></i>
                                                    Detail
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $acaraPending->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="px-6 py-12 text-center">
                        <i data-lucide="file-check" class="size-12 text-gray-400 mx-auto mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada acara verifikasi</h3>
                        <p class="text-gray-600">Belum ada acara yang mengajukan verifikasi.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Approve Modal -->
    <div id="approveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Setujui Acara</h3>
                    <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menyetujui acara ini? Acara akan dipublish
                        dan dapat diakses publik.</p>
                    <form id="approveForm" method="POST">
                        @csrf
                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="closeApproveModal()"
                                class="px-4 py-2 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Setujui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tolak Acara</h3>
                    <p class="text-gray-600 mb-4">Berikan alasan penolakan:</p>
                    <form id="rejectForm" method="POST">
                        @csrf
                        <textarea name="catatan_admin" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 mb-4"
                            placeholder="Alasan penolakan..." required></textarea>
                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="closeRejectModal()"
                                class="px-4 py-2 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function approveEvent(acaraId) {
            const form = document.getElementById('approveForm');
            form.action = `/admin/mod-event/${acaraId}/approve`;
            document.getElementById('approveModal').classList.remove('hidden');
        }

        function rejectEvent(acaraId) {
            const form = document.getElementById('rejectForm');
            form.action = `/admin/mod-event/${acaraId}/reject-verification`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeApproveModal() {
            document.getElementById('approveModal').classList.add('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        document.getElementById('approveModal').addEventListener('click', function(e) {
            if (e.target === this) closeApproveModal();
        });

        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) closeRejectModal();
        });
    </script>
</x-admin>
