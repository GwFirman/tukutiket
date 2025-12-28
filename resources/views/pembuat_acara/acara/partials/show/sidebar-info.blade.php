<div class="col-span-12 lg:col-span-4 space-y-6">

    <!-- Info Card -->
    <div class="bg-white rounded-lg  border border-gray-100 overflow-hidden top-4">


        <div class="p-6 space-y-5">

            <div class="mb-4">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                    <i data-lucide="calendar-days" class="size-4 text-indigo-500"></i>
                    Tanggal Pelaksanaan
                </h4>
                <div class="flex items-center gap-3 border-2 border-indigo-100 rounded-xl p-3 bg-indigo-50/50">
                    <div class="">
                        <i data-lucide="calendar" class="size-5 text-indigo-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">
                            {{ \Carbon\Carbon::parse($acara->waktu_mulai)->format('d M Y') }}
                            @if ($acara->waktu_mulai != $acara->waktu_selesai)
                                <span class="text-gray-400 mx-1">-</span>
                                {{ \Carbon\Carbon::parse($acara->waktu_selesai)->format('d M Y') }}
                            @endif
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            @if ($acara->waktu_mulai != $acara->waktu_selesai)
                                {{ \Carbon\Carbon::parse($acara->waktu_mulai)->diffInDays(\Carbon\Carbon::parse($acara->waktu_selesai)) + 1 }}
                                Hari Acara
                            @else
                                1 Hari Acara
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                    <i data-lucide="clock" class="size-4 text-indigo-500"></i>
                    Waktu Pelaksanaan
                </h4>
                <div class="flex items-center gap-3 border-2 border-indigo-100 rounded-xl p-3 bg-indigo-50/50">
                    <div class="">
                        <i data-lucide="watch" class="size-5 text-indigo-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">
                            {{ \Carbon\Carbon::parse($acara->jam_mulai)->format('H:i') }}
                            <span class="text-gray-400 mx-1">-</span>
                            {{ \Carbon\Carbon::parse($acara->jam_selesai)->format('H:i') }}
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5">Waktu Indonesia Barat (WIB)</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-indigo-100"></div>

            <!-- Lokasi -->
            <div>
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <i data-lucide="map-pin" class="size-4 text-indigo-500"></i>
                    Lokasi & Venue
                </h4>
                <div class="space-y-2">
                    @if ($acara->is_online)
                        <div class="bg-green-50 rounded-lg p-3 border border-green-200">
                            <p class="text-xs text-green-600 mb-2 font-semibold">Acara Online</p>

                            <a href="{{ $acara->lokasi }}" target="_blank" rel="noopener noreferrer"
                                class="block text-sm font-medium text-green-700 hover:text-green-800 hover:bg-green-100 p-2 rounded transition-colors break-all">
                                {{ $acara->lokasi }}
                                <i data-lucide="external-link" class="size-3 inline ml-1"></i>
                            </a>

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
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
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
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
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
