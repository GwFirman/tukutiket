<div class="col-span-12 lg:col-span-8 space-y-6">
    @php
        // Cek apakah acara sudah selesai
        $isFinished = \Carbon\Carbon::parse($acara->waktu_selesai)->isPast();
    @endphp

    <div
        class="relative h-72 w-full rounded-lg flex items-center justify-center overflow-hidden bg-gradient-to-br from-indigo-100 to-purple-100">
        @if ($acara->banner_acara)
            {{-- Tambahkan class grayscale jika selesai --}}
            <img src="{{ asset('storage/' . $acara->banner_acara) }}"
                class="h-full w-full object-cover {{ $isFinished ? 'grayscale' : '' }}">

            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent">
            </div>

            <div class="absolute top-4 right-4">
                @if ($acara->status == 'draft')
                    <span
                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-yellow-500 text-white">
                        <i data-lucide="file-edit" class="size-3"></i>
                        Draft
                    </span>

                    {{-- LOGIKA BARU: Cek Selesai Dulu --}}
                @elseif($acara->status == 'published' && $isFinished)
                    <span
                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-slate-600 text-white border border-slate-400">
                        <i data-lucide="flag" class="size-3"></i>
                        Telah Selesai
                    </span>
                @elseif($acara->status == 'published')
                    <span
                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-green-500 text-white">
                        <i data-lucide="check-circle" class="size-3"></i>
                        Published
                    </span>
                @elseif($acara->status == 'archived')
                    <span
                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-500 text-white">
                        <i data-lucide="archive" class="size-3"></i>
                        Archived
                    </span>
                @endif
            </div>

            <div class="absolute bottom-4 left-4 right-4">
                <h1 class="text-2xl font-bold text-white drop-shadow-md">{{ $acara->nama_acara }}</h1>
            </div>
        @else
            <div class="text-center">
                <div class="h-16 w-16 mx-auto rounded-full bg-indigo-200 flex items-center justify-center mb-3">
                    <i data-lucide="image" class="size-8 text-indigo-400"></i>
                </div>
                <span class="text-gray-500">Belum ada banner acara</span>
            </div>
        @endif
    </div>

    @if ($acara->deskripsi)
        <div>
            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                <i data-lucide="file-text" class="size-4 text-indigo-500"></i>
                Deskripsi
            </h4>
            <div class="text-gray-600 text-sm prose prose-sm max-w-none">{!! $acara->deskripsi !!}</div>
        </div>
        <div class="border-t border-gray-100"></div>
    @endif


    <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
        <div class="bg-indigo-50 px-4 sm:px-6 py-3 border-b border-indigo-100">
            <h2 class="text-base sm:text-lg font-semibold text-indigo-900 flex items-center gap-2">
                <i data-lucide="ticket" class="size-5"></i>
                Informasi Tiket
            </h2>
        </div>

        <div class="p-4 sm:p-6 space-y-4">
            @forelse ($acara->jenisTiket as $tiket)
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:border-indigo-300 transition cursor-pointer"
                    onclick="toggleTicketDetails('ticket-{{ $tiket->id }}')">

                    {{-- Header Tiket --}}
                    <div class="p-3 sm:p-4 flex justify-between items-center bg-white">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <div
                                class="h-10 w-10 sm:h-12 sm:w-12 rounded-md bg-indigo-100 flex items-center justify-center">
                                <i data-lucide="ticket" class="size-5 sm:size-6 text-indigo-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $tiket->nama_jenis }}</h3>
                                <p class="text-indigo-600 font-bold text-sm">
                                    @if ($tiket->harga == 0)
                                        Gratis
                                    @else
                                        Rp {{ number_format($tiket->harga, 0, ',', '.') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">
                                Kuota: {{ $tiket->kuota }}
                            </span>
                            <i data-lucide="chevron-down"
                                class="size-5 text-gray-400 chevron-icon transition-transform"></i>
                        </div>
                    </div>

                    {{-- Detail Tiket Accordion --}}
                    <div id="ticket-{{ $tiket->id }}" class="hidden border-t border-gray-100 bg-gray-50 p-3 sm:p-4">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 text-sm">
                            <div class="bg-white rounded-lg p-3">
                                <p class="text-gray-500 text-xs mb-1">Penjualan Mulai</p>
                                <p class="font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($tiket->penjualan_mulai)->format('d M Y') }}
                                </p>
                                <p class="text-indigo-600 text-xs">
                                    {{ \Carbon\Carbon::parse($tiket->penjualan_mulai)->format('H:i') }} WIB
                                </p>
                            </div>
                            <div class="bg-white rounded-lg p-3">
                                <p class="text-gray-500 text-xs mb-1">Penjualan Selesai</p>
                                <p class="font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($tiket->penjualan_selesai)->format('d M Y') }}
                                </p>
                                <p class="text-indigo-600 text-xs">
                                    {{ \Carbon\Carbon::parse($tiket->penjualan_selesai)->format('H:i') }} WIB
                                </p>
                            </div>
                            <div class="bg-white rounded-lg p-3">
                                <p class="text-gray-500 text-xs mb-1">Berlaku Mulai</p>
                                <p class="font-medium text-gray-900">
                                    {{ optional($tiket->berlaku_mulai ? \Carbon\Carbon::parse($tiket->berlaku_mulai) : null)?->format('d M Y') ?? '-' }}
                                </p>
                            </div>
                            <div class="bg-white rounded-lg p-3">
                                <p class="text-gray-500 text-xs mb-1">Berlaku Sampai</p>
                                <p class="font-medium text-gray-900">
                                    {{ optional($tiket->berlaku_sampai ? \Carbon\Carbon::parse($tiket->berlaku_sampai) : null)?->format('d M Y') ?? '-' }}
                                </p>
                            </div>
                            <div class="bg-white rounded-lg p-3">
                                <p class="text-gray-500 text-xs mb-1">Kuota Tiket</p>
                                <p class="font-medium text-gray-900">{{ $tiket->kuota }} tiket</p>
                            </div>

                            {{-- LOGIKA STATUS TIKET JUGA DIUPDATE --}}
                            <div class="bg-white rounded-lg p-3">
                                <p class="text-gray-500 text-xs mb-1">Status</p>
                                @if ($isFinished)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700">
                                        Berakhir
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-700">
                                        Aktif
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if ($tiket->deskripsi)
                            <div class="mt-3 sm:mt-4 bg-white rounded-lg p-3">
                                <p class="text-gray-500 text-xs mb-1">Deskripsi</p>
                                <p class="text-gray-700 text-sm">{{ $tiket->deskripsi }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <div class="h-16 w-16 mx-auto rounded-full bg-indigo-100 flex items-center justify-center mb-3">
                        <i data-lucide="ticket" class="size-8 text-indigo-400"></i>
                    </div>
                    <p class="text-gray-500">Belum ada jenis tiket</p>
                    <a href="{{ route('pembuat.acara.edit', $acara->id) }}"
                        class="text-indigo-600 hover:underline text-sm mt-1 inline-block">
                        Tambah jenis tiket
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
