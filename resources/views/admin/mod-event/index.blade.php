<x-admin>
    <x-slot name="header">
        <div class="flex max-w-7xl mx-auto items-center gap-2">
            <i data-lucide="alert-triangle" class="size-5 text-gray-600"></i>
            <i data-lucide="chevron-right" class="size-4 text-gray-400"></i>
            <span class="font-semibold text-gray-800">Moderasi Event </span>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-6xl mx-auto px-6 lg:px-10">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Moderasi Event</h1>
                <p class="text-sm text-gray-600 mt-1">Kelola dan hapus event yang melanggar kebijakan</p>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 p-8 rounded-lg"
                style="background-image: url('{{ asset('images/gradient2.jpg') }}'); background-size: cover; background-position: center;">
                <!-- Optional overlay for readability -->
                <div class="col-span-1 md:col-span-3 -m-8 p-8 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-indigo-800/30 backdrop-blur-md  rounded-lg  p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-100 font-medium mb-1">Total Event Published</p>
                                    <p class="text-2xl font-bold text-gray-50">{{ $events->total() }}</p>
                                </div>
                                <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i data-lucide="check" class="size-6 text-blue-600"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-indigo-800/30 backdrop-blur-md  rounded-lg  p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-100 font-medium mb-1">Event melanggar</p>
                                    <p class="text-2xl font-bold text-gray-50">12</p>
                                </div>
                                <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <i data-lucide="triangle-alert" class="size-6 text-indigo-600"></i>
                                </div>
                            </div>
                        </div>

                        {{--  --}}
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                    <i data-lucide="check" class="size-5 text-green-600 flex-shrink-0 mt-0.5"></i>
                    <div>
                        <p class="text-sm text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Events Table -->
            <div class="bg-white rounded-lg  border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        Daftar Event Published
                    </h2>
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
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Event</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Kreator</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Status</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Tanggal Dibuat</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($events as $event)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-start gap-3">
                                            @if ($event->banner_acara)
                                                <img src="{{ asset('storage/' . $event->banner_acara) }}"
                                                    alt="{{ $event->nama_acara }}"
                                                    class="h-12 w-12 rounded-lg object-cover">
                                            @else
                                                <div
                                                    class="h-12 w-12 rounded-lg bg-gray-200 flex items-center justify-center">
                                                    <i data-lucide="image" class="size-6 text-gray-400"></i>
                                                </div>
                                            @endif
                                            <div class="min-w-0">
                                                <p class="font-medium text-gray-900 text-sm truncate">
                                                    {{ $event->nama_acara }}</p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    {{ Str::limit(strip_tags($event->deskripsi), 50) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            @if ($event->kreator && $event->kreator->logo)
                                                <img src="{{ Storage::url($event->kreator->logo) }}"
                                                    alt="{{ $event->kreator->nama_kreator }}"
                                                    class="h-8 w-8 rounded-full object-cover">
                                            @else
                                                <div
                                                    class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                                    <i data-lucide="user" class="size-4 text-indigo-600"></i>
                                                </div>
                                            @endif
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $event->kreator->nama_kreator ?? '-' }}</p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $event->kreator->user->email ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            <i data-lucide="check" class="size-3"></i>
                                            Publish
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($event->created_at)->locale('id')->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.mod-event.show', $event->slug) }}"
                                                class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                                <i data-lucide="eye" class="size-4 mr-1"></i>
                                                Review
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                                <i data-lucide="calendar" class="size-8 text-gray-400"></i>
                                            </div>
                                            <p class="text-gray-500 font-medium">Tidak ada event untuk ditinjau
                                            </p>
                                            <p class="text-sm text-gray-400 mt-1">Semua event terbatas atau tidak ada
                                                event yang aktif</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($events->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $events->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin>
