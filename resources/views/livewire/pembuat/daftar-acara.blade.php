<div>
    <!-- Search kecil di atas tabel -->
    <div class="mb-4 flex items-center gap-2">
        <div class="relative w-full sm:w-64">
            <input type="text" wire:model.defer="search" placeholder="Cari acara atau lokasi"
                class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
            <i data-lucide="search" class="size-4 text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2"></i>
        </div>
        <button type="button" wire:click="searchAcara"
            class="px-3 py-2 text-xs sm:text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
            Cari
        </button>
        @if ($search)
            <button type="button" wire:click="resetFilters"
                class="px-3 py-2 text-xs sm:text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg">
                Reset
            </button>
        @endif
    </div>

    <!-- Tabs Filter Status -->
    <div class="flex gap-4 border-b border-gray-200 mb-6">
        <button wire:click="setStatus('')"
            class="pb-2 px-3 border-b-2 text-sm font-medium
            {{ $status === '' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            Semua
        </button>

        <button wire:click="setStatus('published')"
            class="pb-2 px-3 border-b-2 text-sm font-medium
            {{ $status === 'published' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            Published
        </button>

        <button wire:click="setStatus('draft')"
            class="pb-2 px-3 border-b-2 text-sm font-medium
            {{ $status === 'draft' ? 'border-yellow-600 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            Draft
        </button>

        <button wire:click="setStatus('archived')"
            class="pb-2 px-3 border-b-2 text-sm font-medium
            {{ $status === 'archived' ? 'border-red-600 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            Archived
        </button>
    </div>


    <!-- Table -->
    @if ($acaras->count())
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Nama Acara
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Waktu
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Status
                            </th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($acaras->sortByDesc('waktu_mulai') as $acara)
                            <tr class="hover:bg-gray-50 transition-colors">

                                {{-- 1. Kolom Nama Acara --}}
                                <td class="pl-6 pr-10 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        {{-- Gambar --}}
                                        @if ($acara->banner_acara)
                                            <img src="{{ Storage::url($acara->banner_acara) }}"
                                                class="h-16 w-16 rounded-lg object-cover shadow-md" />
                                        @else
                                            <div
                                                class="h-16 w-16 rounded-lg bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-md">
                                                <i data-lucide="image" class="text-white size-6"></i>
                                            </div>
                                        @endif

                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">
                                                {{ $acara->nama_acara }}
                                            </div>
                                            <div class="flex items-center gap-1 mt-1 text-xs text-gray-500">
                                                <i data-lucide="map-pin" class="size-3 flex-shrink-0"></i>
                                                <span class="truncate max-w-xs">{{ $acara->lokasi }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- 2. Kolom Waktu --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm space-y-1">
                                        <div class="flex items-center text-gray-900">
                                            <span class="font-medium mr-2 text-xs text-gray-400 w-12">Mulai:</span>
                                            <span>{{ \Carbon\Carbon::parse($acara->waktu_mulai)->format('d M Y') }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-500">
                                            <span class="font-medium mr-2 text-xs text-gray-400 w-12">Selesai:</span>
                                            <span>{{ \Carbon\Carbon::parse($acara->waktu_selesai)->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- 3. Kolom Status (NORMAL - Sesuai Database) --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full 
                                    @if ($acara->status === 'published') bg-green-100 text-green-800
                                    @elseif($acara->status === 'draft') bg-yellow-100 text-yellow-800
                                    @elseif($acara->status === 'archived') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($acara->status) }}
                                    </span>
                                </td>

                                {{-- 4. Kolom Aksi --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex justify-center space-x-3">
                                        <a href="{{ route('pembuat.acara.show', $acara->slug) }}"
                                            class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
                                            <i data-lucide="eye" class="size-5"></i>
                                        </a>
                                        <a href="{{ route('pembuat.acara.edit', $acara->slug) }}"
                                            class="text-yellow-600 hover:text-yellow-800" title="Edit Acara">
                                            <i data-lucide="edit-3" class="size-5"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Acara</h3>
            <p class="text-gray-500 mb-6">Mulai buat acara pertama Anda sekarang!</p>
            <a href="{{ route('pembuat.acara.create') }}"
                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg shadow-lg">
                <i data-lucide="plus" class="mr-2"></i> Buat Acara Pertama
            </a>
        </div>
    @endif
</div>
