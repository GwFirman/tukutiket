<x-admin>
    <x-slot name="header">
        <div class="flex max-w-7xl mx-auto items-center gap-2">
            <i data-lucide="calendar-check" class="size-5 text-gray-600"></i>
            <i data-lucide="chevron-right" class="size-4 text-gray-400"></i>
            <a href="{{ route('admin.mod-event.index') }}" class="text-gray-600 hover:text-gray-900">Moderasi Event</a>
            <i data-lucide="chevron-right" class="size-4 text-gray-400"></i>
            <span class="font-semibold text-gray-800">{{ Str::limit($acara->nama_acara, 30) }}</span>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">
            <!-- Back Button -->
            <a href="{{ route('admin.mod-event.index') }}"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-indigo-600 transition mb-6">
                <i data-lucide="arrow-left" class="size-4"></i>
                Kembali
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Banner -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="h-64 bg-gray-200 flex items-center justify-center overflow-hidden">
                            @if ($acara->banner_acara)
                                <img src="{{ asset('storage/' . $acara->banner_acara) }}" alt="{{ $acara->nama_acara }}"
                                    class="w-full h-full object-cover">
                            @else
                                <i data-lucide="image" class="size-16 text-gray-400"></i>
                            @endif
                        </div>
                    </div>

                    <!-- Event Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $acara->nama_acara }}</h2>

                        <div class="space-y-4">
                            <!-- Deskripsi -->
                            <div>
                                <h3 class="text-sm font-semibold text-gray-700 mb-2">Deskripsi</h3>
                                <div class="text-gray-600 text-sm prose prose-sm max-w-none">{!! $acara->deskripsi !!}
                                </div>
                            </div>

                            <div class="border-t border-gray-200"></div>

                            <!-- Waktu -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 mb-1">Waktu Mulai</p>
                                    <p class="text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($acara->waktu_mulai)->locale('id')->translatedFormat('d F Y') }}
                                        WIB
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 mb-1">Waktu Selesai</p>
                                    <p class="text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($acara->waktu_selesai)->locale('id')->translatedFormat('d F Y') }}
                                        WIB</p>
                                </div>
                            </div>

                            <!-- Lokasi -->
                            <div>
                                <p class="text-sm font-semibold text-gray-700 mb-1">Lokasi / Venue</p>
                                <p class="text-sm text-gray-600">
                                    @if ($acara->is_online)
                                        Acara Online
                                        @if ($acara->link_acara)
                                            - {{ $acara->link_acara }}
                                        @endif
                                    @else
                                        {{ $acara->lokasi }}
                                        @if ($acara->venue)
                                            ({{ $acara->venue }})
                                        @endif
                                    @endif
                                </p>
                            </div>

                            <!-- Kontak -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 mb-1">PIC Acara</p>
                                    <p class="text-sm text-gray-600">{{ $acara->info_narahubung ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 mb-1">Nomor Telepon</p>
                                    <p class="text-sm text-gray-600">{{ $acara->no_telp_narahubung ?? '-' }}</p>
                                </div>
                            </div>

                            @if ($acara->email_narahubung)
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 mb-1">Email</p>
                                    <p class="text-sm text-gray-600">{{ $acara->email_narahubung }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Jenis Tiket -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i data-lucide="ticket" class="size-5"></i>
                            Jenis Tiket
                        </h3>

                        <div class="space-y-4">
                            @forelse ($acara->jenisTiket as $tiket)
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-indigo-300 transition">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $tiket->nama_jenis }}</h4>
                                            <p class="text-indigo-600 font-bold">
                                                @if ($tiket->harga == 0)
                                                    Gratis
                                                @else
                                                    Rp {{ number_format($tiket->harga, 0, ',', '.') }}
                                                @endif
                                            </p>
                                        </div>
                                        <span
                                            class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-medium">
                                            Kuota: {{ $tiket->kuota }}
                                        </span>
                                    </div>

                                    @if ($tiket->deskripsi)
                                        <p class="text-sm text-gray-600 mb-3">{{ $tiket->deskripsi }}</p>
                                    @endif

                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                        <div>
                                            <span class="font-medium">Penjualan Mulai:</span><br>
                                            {{ \Carbon\Carbon::parse($tiket->penjualan_mulai)->locale('id')->translatedFormat('d F Y') }}
                                        </div>
                                        <div>
                                            <span class="font-medium">Penjualan Selesai:</span><br>
                                            {{ \Carbon\Carbon::parse($tiket->penjualan_selesai)->locale('id')->translatedFormat('d F Y') }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm">Belum ada jenis tiket</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Kreator Info -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i data-lucide="user" class="size-5"></i>
                            Kreator
                        </h3>

                        <div class="flex items-center gap-3 mb-4">
                            @if ($acara->kreator && $acara->kreator->logo)
                                <img src="{{ Storage::url($acara->kreator->logo) }}"
                                    alt="{{ $acara->kreator->nama_kreator }}"
                                    class="h-12 w-12 rounded-full object-cover">
                            @else
                                <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <i data-lucide="user" class="size-6 text-indigo-600"></i>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-gray-900">{{ $acara->kreator->nama_kreator ?? '-' }}</p>
                                <p class="text-xs text-gray-500">{{ $acara->kreator->user->email ?? '-' }}</p>
                            </div>
                        </div>

                        @if ($acara->kreator && $acara->kreator->deskripsi)
                            <p class="text-sm text-gray-600 mb-4">{{ $acara->kreator->deskripsi }}</p>
                        @endif
                    </div>

                    <!-- Status -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i data-lucide="info" class="size-5"></i>
                            Status
                        </h3>

                        @if ($acara->status == 'published')
                            <span
                                class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 mb-4">
                                <i data-lucide="check-circle" class="size-3"></i>
                                Published
                            </span>
                        @elseif ($acara->status == 'archived')
                            <span
                                class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 mb-4">
                                <i data-lucide="archive" class="size-3"></i>
                                Archived
                            </span>
                        @endif

                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-xs text-gray-500 mb-1">Dibuat pada:</p>
                            <p class="text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($acara->created_at)->locale('id')->translatedFormat('d F Y, H:i') }}
                                WIB</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-3">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i data-lucide="alert-triangle" class="size-5"></i>
                            Aksi Takedown
                        </h3>

                        <!-- Takedown Button -->
                        <form method="POST" action="{{ route('admin.mod-event.takedown', $acara->slug) }}">
                            @csrf
                            <button type="submit"
                                onclick="return confirm('Takedown event ini? Event akan diarsipkan dan tidak lagi terlihat!')"
                                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors text-sm">
                                <i data-lucide="alert-triangle" class="size-4"></i>
                                Takedown Event
                            </button>
                        </form>

                        <!-- Cancel/Keep Button -->
                        <button type="button" onclick="openKeepReasonModal()"
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors text-sm">
                            <i data-lucide="check-circle" class="size-4"></i>
                            Biarkan Event (Tidak Ada Masalah)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4"
        style="display: none;">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <i data-lucide="check-circle" class="size-5"></i>
                    Biarkan Event
                </h2>
            </div>

            <!-- Body -->
            <form method="POST" action="{{ route('admin.mod-event.reject', $acara->id) }}" class="p-6">
                @csrf
                <div class="mb-4">
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan (Opsional) <span class="text-gray-400">*</span>
                    </label>
                    <textarea id="reason" name="reason" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                        placeholder="Tuliskan catatan jika diperlukan..."></textarea>
                </div>

                <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-6">
                    <p class="text-sm text-green-800">
                        <span class="font-semibold">✓ Info:</span> Event ini tidak ada masalah dan akan tetap
                        dipublikasikan.
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button type="button" onclick="closeRejectModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition text-sm">
                        Lanjutkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal() {
            openKeepReasonModal();
        }

        function openKeepReasonModal() {
            document.getElementById('rejectModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeRejectModal();
            }
        });
    </script>
</x-admin>
