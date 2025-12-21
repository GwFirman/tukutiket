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
                    <a href="{{ route('pembuat.acara.edit', $acara->id) }}"
                        class="inline-flex items-center gap-2 px-3 lg:px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition font-medium text-sm">
                        <i data-lucide="edit-3" class="size-4"></i>
                        <span class="hidden md:inline">Edit</span>
                    </a>
                    <a href="{{ route('pembuat.acara.daftar-peserta', $acara->id) }}"
                        class="inline-flex items-center gap-2 px-3 lg:px-4 py-2 bg-purple-50 text-purple-600 rounded-lg hover:bg-purple-100 transition font-medium text-sm">
                        <i data-lucide="users" class="size-4"></i>
                        <span class="hidden md:inline">Peserta</span>
                    </a>
                    <a href="{{ route('pembuat.scan.index', $acara->slug) }}"
                        class="inline-flex items-center gap-2 px-3 lg:px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium text-sm">
                        <i data-lucide="scan-line" class="size-4"></i>
                        <span class="hidden md:inline">Scan</span>
                    </a>
                </div>
            </div>

            <!-- Mobile Grid Layout -->
            <div class="grid grid-cols-3 gap-2 sm:hidden">
                <a href="{{ route('pembuat.acara.edit', $acara->id) }}"
                    class="flex flex-col items-center gap-1.5 p-3 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition">
                    <i data-lucide="edit-3" class="size-5"></i>
                    <span class="text-xs font-medium">Edit</span>
                </a>
                <a href="{{ route('pembuat.acara.daftar-peserta', $acara->id) }}"
                    class="flex flex-col items-center gap-1.5 p-3 bg-purple-50 text-purple-600 rounded-lg hover:bg-purple-100 transition">
                    <i data-lucide="users" class="size-5"></i>
                    <span class="text-xs font-medium">Peserta</span>
                </a>
                <a href="{{ route('pembuat.scan.index', $acara->slug) }}"
                    class="flex flex-col items-center gap-1.5 p-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    <i data-lucide="scan-line" class="size-5"></i>
                    <span class="text-xs font-medium">Scan</span>
                </a>
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
                <div class="bg-white rounded-lg  border border-gray-100 overflow-hidden">
                    <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-100">
                        <h2 class="text-lg font-semibold text-indigo-900 flex items-center gap-2">
                            <i data-lucide="ticket" class="size-5"></i>
                            Informasi Tiket
                        </h2>
                    </div>

                    <div class="p-6 space-y-4">
                        @forelse ($acara->jenisTiket as $tiket)
                            <div class="border border-gray-200 rounded-xl overflow-hidden hover:border-indigo-300 transition cursor-pointer group"
                                onclick="toggleTicketDetails('ticket-{{ $tiket->id }}')">
                                <div
                                    class="p-4 flex justify-between items-center bg-white group-hover:bg-indigo-50/50 transition">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="h-12 w-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center">
                                            <i data-lucide="ticket" class="size-6 text-white"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $tiket->nama_jenis }}</h3>
                                            <p class="text-indigo-600 font-bold">
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
                                            class="px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">
                                            Kuota: {{ $tiket->kuota }}
                                        </span>
                                        <i data-lucide="chevron-down"
                                            class="size-5 text-gray-400 chevron-icon transition-transform"></i>
                                    </div>
                                </div>

                                <div id="ticket-{{ $tiket->id }}"
                                    class="hidden border-t border-gray-100 bg-gray-50 p-4">
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
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
                                        <div class="mt-4 bg-white rounded-lg p-3">
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
                <div class="bg-white rounded-lg  border border-gray-100 overflow-hidden sticky top-4">


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
                                class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                                <i data-lucide="map-pin" class="size-4 text-indigo-500"></i>
                                Lokasi
                            </h4>
                            <p class="text-gray-700">{{ $acara->lokasi }}</p>
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
