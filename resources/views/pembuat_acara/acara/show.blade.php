<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 max-w-5xl mx-auto">
            <a href="{{ route('pembuat.acara.index') }}" class="text-gray-500 hover:text-indigo-600 transition">
                <i data-lucide="home" class="size-5"></i>
            </a>
            <i data-lucide="chevron-right" class="size-4 text-gray-400"></i>
            <a href="{{ route('pembuat.acara.index') }}" class="text-gray-500 hover:text-indigo-600 transition">Acara</a>
            <i data-lucide="chevron-right" class="size-4 text-gray-400"></i>
            <span class="font-medium text-gray-800">{{ Str::limit($acara->nama_acara, 30) }}</span>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-6 lg:mt-4 lg:px-0 pb-6">
        <!-- Action Buttons -->
        <div class="mb-6 space-y-3 sm:space-y-0">
            <!-- Back Button - Always visible -->
            <div class="flex items-center justify-between sm:hidden">
                <a href="{{ route('pembuat.acara.index') }}"
                    class="inline-flex items-center gap-2 text-gray-600 hover:text-indigo-600 transition text-sm">
                    <i data-lucide="arrow-left" class="size-4"></i>
                    <span>Kembali</span>
                </a>
            </div>

            <!-- Desktop Layout -->
            <div class="hidden sm:flex sm:items-center sm:justify-between">
                <a href="{{ route('pembuat.acara.index') }}"
                    class="inline-flex items-center gap-2 text-gray-600 hover:text-indigo-600 transition">
                    <i data-lucide="arrow-left" class="size-4"></i>
                    Kembali ke Daftar
                </a>
                <div class="flex items-center gap-2 lg:gap-3">
                    @if ($acara->status === 'published')
                        <form method="POST" action="{{ route('pembuat.acara.archive', $acara->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-3 lg:px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition font-medium text-sm">
                                <i data-lucide="archive" class="size-4"></i>
                                <span class="hidden md:inline">Archive</span>
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('pembuat.acara.publish', $acara->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-3 lg:px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium text-sm">
                                <i data-lucide="upload" class="size-4"></i>
                                <span class="hidden md:inline">Publish</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Mobile Grid Layout -->
            <div class="grid grid-cols-2 gap-2 sm:hidden">
                @if ($acara->status === 'published')
                    <form method="POST" action="{{ route('pembuat.acara.archive', $acara->id) }}" class="flex">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="flex flex-col items-center gap-1.5 p-3 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition w-full">
                            <i data-lucide="archive" class="size-5"></i>
                            <span class="text-xs font-medium">Archive</span>
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('pembuat.acara.publish', $acara->id) }}" class="flex">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="flex flex-col items-center gap-1.5 p-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition w-full">
                            <i data-lucide="check-circle" class="size-5"></i>
                            <span class="text-xs font-medium">Publish</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6">
            <!-- Banner + Tiket -->
            <div class="col-span-12 lg:col-span-8 space-y-6">

                <!-- Banner -->
                <div
                    class="relative h-72 w-full rounded-lg flex items-center justify-center overflow-hidden bg-gradient-to-br from-indigo-100 to-purple-100 ">
                    @if ($acara->banner_acara)
                        <img src="{{ asset('storage/' . $acara->banner_acara) }}" class="h-full w-full object-cover">
                        <!-- Overlay Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent">
                        </div>
                        <!-- Status Badge -->
                        <div class="absolute top-4 right-4">
                            @if ($acara->status == 'draft')
                                <span
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-yellow-500 text-white ">
                                    <i data-lucide="file-edit" class="size-3"></i>
                                    Draft
                                </span>
                            @elseif($acara->status == 'published')
                                <span
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-green-500 text-white ">
                                    <i data-lucide="check-circle" class="size-3"></i>
                                    Published
                                </span>
                            @elseif($acara->status == 'archived')
                                <span
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-500 text-white ">
                                    <i data-lucide="archive" class="size-3"></i>
                                    Archived
                                </span>
                            @endif
                        </div>
                        <!-- Event Name on Banner -->
                        <div class="absolute bottom-4 left-4 right-4">
                            <h1 class="text-2xl font-bold text-white drop-">{{ $acara->nama_acara }}</h1>
                        </div>
                    @else
                        <div class="text-center">
                            <div
                                class="h-16 w-16 mx-auto rounded-full bg-indigo-200 flex items-center justify-center mb-3">
                                <i data-lucide="image" class="size-8 text-indigo-400"></i>
                            </div>
                            <span class="text-gray-500">Belum ada banner acara</span>
                        </div>
                    @endif
                </div>

                <!-- Deskripsi -->
                @if ($acara->deskripsi)
                    <div>
                        <h4
                            class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                            <i data-lucide="file-text" class="size-4 text-indigo-500"></i>
                            Deskripsi
                        </h4>
                        <div class="text-gray-600 text-sm prose prose-sm max-w-none">{!! $acara->deskripsi !!}
                        </div>
                    </div>
                    <div class="border-t border-gray-100"></div>
                @endif


                <!-- Informasi Tiket -->
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
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">
                                            Kuota: {{ $tiket->kuota }}
                                        </span>
                                        <i data-lucide="chevron-down"
                                            class="size-5 text-gray-400 chevron-icon transition-transform"></i>
                                    </div>
                                </div>

                                <div id="ticket-{{ $tiket->id }}"
                                    class="hidden border-t border-gray-100 bg-gray-50 p-3 sm:p-4">
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
                                                {{ \Carbon\Carbon::parse($tiket->penjualan_selesai)->format('H:i') }}
                                                WIB</p>
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
                                        <div class="bg-white rounded-lg p-3">
                                            <p class="text-gray-500 text-xs mb-1">Status</p>
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-700">
                                                Aktif
                                            </span>
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
                                <div
                                    class="h-16 w-16 mx-auto rounded-full bg-indigo-100 flex items-center justify-center mb-3">
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

            <!-- Sidebar kanan -->
            <div class="col-span-12 lg:col-span-4 space-y-6">

                <!-- Info Card -->
                <div class="bg-white rounded-lg  border border-gray-100 overflow-hidden top-4">


                    <div class="p-6 space-y-5">

                        <!-- Waktu Pelaksanaan -->
                        <div>
                            <h4
                                class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                                <i data-lucide="clock" class="size-4 text-indigo-500"></i>
                                Waktu Pelaksanaan
                            </h4>
                            <div class="space-y-2.5">
                                <div
                                    class="flex items-center gap-2.5 border-2 border-indigo-200 rounded-lg p-2 bg-indigo-50">
                                    <i data-lucide="calendar-days" class="size-5 text-indigo-400"></i>
                                    <div>
                                        <p class="text-xs text-gray-500">Mulai</p>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($acara->waktu_mulai)->format('d M Y, H:i') }} WIB
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center gap-2.5 border-2 border-indigo-200 rounded-lg p-2 bg-indigo-50">
                                    <i data-lucide="calendar-check" class="size-5 text-indigo-400"></i>
                                    <div>
                                        <p class="text-xs text-gray-500">Selesai</p>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($acara->waktu_selesai)->format('d M Y, H:i') }}
                                            WIB
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-indigo-100"></div>

                        <!-- Lokasi -->
                        <div>
                            <h4
                                class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                                <i data-lucide="map-pin" class="size-4 text-indigo-500"></i>
                                Lokasi & Venue
                            </h4>
                            <div class="space-y-2">
                                @if ($acara->is_online)
                                    <div class="bg-green-50 rounded-lg p-3 border border-green-200">
                                        <p class="text-xs text-green-600 mb-1">Acara Online</p>
                                        @if ($acara->link_acara)
                                            <a href="{{ $acara->link_acara }}" target="_blank"
                                                class="text-sm font-medium text-green-700 hover:text-green-800 underline flex items-center gap-1">
                                                {{ $acara->link_acara }}
                                                <i data-lucide="external-link" class="size-3"></i>
                                            </a>
                                        @else
                                            <p class="text-sm text-green-700">Link akan diberikan kemudian</p>
                                        @endif
                                    </div>
                                @else
                                    @if ($acara->venue)
                                        <div class="bg-gray-50 rounded-lg p-3">
                                            <p class="text-xs text-gray-500 mb-1">Venue</p>
                                            <p class="text-sm font-medium text-gray-700">{{ $acara->venue }}</p>
                                        </div>
                                    @endif
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-xs text-gray-500 mb-1">Alamat</p>
                                        <p class="text-sm text-gray-700">{{ $acara->lokasi }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        <!-- Informasi Kontak -->
                        <div>
                            <h4
                                class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                                <i data-lucide="user" class="size-4 text-indigo-500"></i>
                                Informasi Narahubung
                            </h4>
                            <div class="space-y-2">
                                @if ($acara->info_narahubung)
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-xs text-gray-500 mb-1">Nama</p>
                                        <p class="text-sm text-gray-700">{{ $acara->info_narahubung }}</p>
                                    </div>
                                @endif
                                @if ($acara->no_telp_narahubung)
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-xs text-gray-500 mb-1">Telepon</p>
                                        <p class="text-sm text-gray-700">{{ $acara->no_telp_narahubung }}</p>
                                    </div>
                                @endif
                                @if ($acara->email_narahubung)
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-xs text-gray-500 mb-1">Email</p>
                                        <p class="text-sm text-gray-700">{{ $acara->email_narahubung }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        <!-- Aturan -->
                        <div>
                            <h4
                                class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                                <i data-lucide="settings" class="size-4 text-indigo-500"></i>
                                Aturan Pembelian
                            </h4>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center bg-gray-50 rounded-lg p-3">
                                    <span class="text-sm text-gray-600">Maks per Akun</span>
                                    <span
                                        class="font-semibold text-indigo-600">{{ $acara->maks_pembelian_per_akun ?? 'Tidak terbatas' }}</span>
                                </div>
                                <div class="flex justify-between items-center bg-gray-50 rounded-lg p-3">
                                    <span class="text-sm text-gray-600">Maks per Transaksi</span>
                                    <span class="font-semibold text-indigo-600">{{ $acara->maks_tiket_per_transaksi }}
                                        tiket</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function toggleTicketDetails(ticketId) {
            const element = document.getElementById(ticketId);
            const chevronIcon = event.currentTarget.querySelector('.chevron-icon');

            if (element.classList.contains('hidden')) {
                element.classList.remove('hidden');
                chevronIcon.style.transform = 'rotate(180deg)';
            } else {
                element.classList.add('hidden');
                chevronIcon.style.transform = 'rotate(0deg)';
            }
        }
    </script>
</x-app-layout>
