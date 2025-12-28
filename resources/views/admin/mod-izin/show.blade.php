<x-admin>
    <x-slot:header>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i data-lucide="file-check" class="size-5 text-gray-600"></i>
                <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
                <p class="font-medium">Verifikasi Acara</p>
                <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
                <p class="font-medium text-gray-600">{{ $acara->nama_acara }}</p>
            </div>
        </div>
    </x-slot:header>

    <div class="p-6 space-y-6 max-w-6xl mx-auto">
        <!-- Header Info -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $acara->nama_acara }}</h1>
                <p class="mt-2 text-gray-600">Periksa detail acara dan dokumen sebelum verifikasi</p>
            </div>
            <a href="{{ route('admin.mod-izin.index') }}"
                class="inline-flex items-center px-4 py-2 border border-indigo-300 rounded-lg text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition-colors">
                <i data-lucide="arrow-left" class="size-4 mr-2"></i>
                Kembali
            </a>
        </div>

        <!-- Event Details -->
        <div class="bg-white rounded-xl border border-indigo-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-indigo-200 bg-gradient-to-r from-indigo-50 to-white">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i data-lucide="info" class="w-5 h-5 text-indigo-600"></i>
                    Informasi Acara
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-indigo-50 rounded-lg p-4 border border-indigo-100">
                        <h3 class="text-xs font-bold text-indigo-600 uppercase tracking-widest mb-2">Nama Acara</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $acara->nama_acara }}</p>
                    </div>
                    <div class="bg-indigo-50 rounded-lg p-4 border border-indigo-100">
                        <h3 class="text-xs font-bold text-indigo-600 uppercase tracking-widest mb-2">Kreator</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $acara->kreator->nama_kreator ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $acara->kreator->user->email ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-indigo-50 rounded-lg p-4 border border-indigo-100">
                        <h3 class="text-xs font-bold text-indigo-600 uppercase tracking-widest mb-2">Tanggal & Waktu
                        </h3>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($acara->waktu_mulai)->locale('id')->translatedFormat('d M Y') }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ \Carbon\Carbon::parse($acara->waktu_mulai)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($acara->waktu_selesai)->format('H:i') }} WIB
                        </p>
                    </div>
                    <div class="bg-indigo-50 rounded-lg p-4 border border-indigo-100">
                        <h3 class="text-xs font-bold text-indigo-600 uppercase tracking-widest mb-2">Lokasi</h3>
                        <div class="flex items-center gap-2 text-lg font-semibold text-gray-900">
                            @if ($acara->is_online)
                                <i data-lucide="globe" class="size-5 text-indigo-600"></i>
                                <span>Online</span>
                            @else
                                <i data-lucide="map-pin" class="size-5 text-indigo-600"></i>
                                <span>{{ $acara->lokasi }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="md:col-span-2 bg-indigo-50 rounded-lg p-4 border border-indigo-100">
                        <h3 class="text-xs font-bold text-indigo-600 uppercase tracking-widest mb-2">Deskripsi</h3>
                        <p class="text-gray-900 text-sm leading-relaxed">{!! Str::limit(strip_tags($acara->deskripsi), 200) !!}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tickets -->
        <div class="bg-white rounded-xl border border-indigo-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-indigo-200 bg-gradient-to-r from-indigo-50 to-white">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i data-lucide="ticket" class="w-5 h-5 text-indigo-600"></i>
                    Jenis Tiket
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-indigo-50 border-b border-indigo-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">
                                Nama Tiket</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">
                                Harga</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-bold text-indigo-700 uppercase tracking-wider">
                                Kuota</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-bold text-indigo-700 uppercase tracking-wider">
                                Tersedia</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-indigo-100">
                        @foreach ($acara->jenisTiket as $tiket)
                            <tr class="hover:bg-indigo-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $tiket->nama_jenis }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-indigo-600">Rp
                                    {{ number_format($tiket->harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm text-center font-medium text-gray-900">{{ $tiket->kuota }}
                                </td>
                                <td class="px-6 py-4 text-sm text-center">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">
                                        {{ $tiket->kuota - $tiket->terjual }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Verification Documents -->
        <div class="bg-white rounded-xl border border-indigo-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-indigo-200 bg-gradient-to-r from-indigo-50 to-white">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i data-lucide="file-check" class="w-5 h-5 text-indigo-600"></i>
                    Dokumen Verifikasi
                </h2>
            </div>
            @if ($acara->verifikasiAcara->count() > 0)
                <div class="divide-y divide-indigo-100">
                    @foreach ($acara->verifikasiAcara as $verifikasi)
                        <div class="px-6 py-4 hover:bg-indigo-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4 flex-1">
                                    <div
                                        class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="file-text" class="size-5 text-indigo-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $verifikasi->nama_dokumen }}
                                        </p>
                                        <p class="text-xs text-gray-600 mt-1">{{ $verifikasi->jenis_dokumen }} • Upload
                                            {{ $verifikasi->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    <a href="{{ asset('storage/' . $verifikasi->file_path) }}" target="_blank"
                                        class="inline-flex items-center px-3 py-1 border border-indigo-300 rounded-lg text-xs font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition-colors">
                                        <i data-lucide="eye" class="size-3 mr-1"></i>
                                        Lihat
                                    </a>
                                    <a href="{{ asset('storage/' . $verifikasi->file_path) }}" download
                                        class="inline-flex items-center px-3 py-1 border border-indigo-300 rounded-lg text-xs font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition-colors">
                                        <i data-lucide="download" class="size-3 mr-1"></i>
                                        Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="file-x" class="size-8 text-indigo-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Tidak ada dokumen verifikasi</h3>
                    <p class="text-gray-600 text-sm">Acara ini belum mengupload dokumen verifikasi.</p>
                </div>
            @endif
        </div>

        <!-- Actions -->
        @if ($acara->status === 'pending_verifikasi')
            <div class="bg-white rounded-xl border border-indigo-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-indigo-200 bg-gradient-to-r from-indigo-50 to-white">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i data-lucide="clipboard-check" class="w-5 h-5 text-indigo-600"></i>
                        Aksi Verifikasi
                    </h2>
                </div>
                <div class="p-6 flex justify-end gap-4">
                    <button onclick="rejectEvent({{ $acara->id_acara }})"
                        class="inline-flex items-center px-6 py-3 border border-rose-300 rounded-lg text-sm font-medium text-rose-700 bg-rose-50 hover:bg-rose-100 transition-colors">
                        <i data-lucide="x-circle" class="size-4 mr-2"></i>
                        Tolak Acara
                    </button>
                    <button onclick="approveEvent({{ $acara->id_acara }})"
                        class="inline-flex items-center px-6 py-3 border border-emerald-300 rounded-lg text-sm font-medium text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition-colors">
                        <i data-lucide="check-circle" class="size-4 mr-2"></i>
                        Setujui Acara
                    </button>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl border border-indigo-200 overflow-hidden">
                <div class="px-6 py-12 text-center">
                    <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center mx-auto mb-4">
                        @if ($acara->status === 'published')
                            <i data-lucide="check-circle" class="size-8 text-emerald-600"></i>
                        @else
                            <i data-lucide="x-circle" class="size-8 text-rose-600"></i>
                        @endif
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">
                        @if ($acara->status === 'published')
                            Acara Sudah Disetujui
                        @else
                            Acara Sudah Ditolak
                        @endif
                    </h3>
                    <p class="text-gray-600 text-sm">Verifikasi acara ini sudah selesai dan tidak dapat diubah lagi.
                    </p>
                </div>
            </div>
        @endif
    </div>

    <!-- Approve Modal -->
    <div id="approveModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-md w-full border border-indigo-200">
            <div class="px-6 py-4 border-b border-indigo-200 bg-gradient-to-r from-indigo-50 to-white">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i data-lucide="check-circle" class="size-5 text-emerald-600"></i>
                    Setujui Acara
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <p class="text-gray-600">Apakah Anda yakin ingin menyetujui acara ini? Acara akan dipublish dan dapat
                    diakses publik.</p>
                <form id="approveForm" method="POST" action="{{ route('admin.mod-event.approve', $acara->slug) }}"
                    class="space-y-4">
                    @csrf
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeApproveModal()"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                            Setujui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-md w-full border border-indigo-200">
            <div class="px-6 py-4 border-b border-indigo-200 bg-gradient-to-r from-indigo-50 to-white">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i data-lucide="x-circle" class="size-5 text-rose-600"></i>
                    Tolak Acara
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <p class="text-gray-600">Berikan alasan penolakan. Pesan ini akan dikirim ke kreator.</p>
                <form id="rejectForm" method="POST"
                    action="{{ route('admin.mod-event.reject-verification', $acara->slug) }}" class="space-y-4">
                    @csrf
                    <textarea name="catatan_admin" rows="4"
                        class="w-full border border-indigo-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Alasan penolakan..." required></textarea>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeRejectModal()"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700 transition-colors">
                            Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        function approveEvent(acaraId) {
            document.getElementById('approveModal').classList.remove('hidden');
        }

        function rejectEvent(acaraId) {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeApproveModal() {
            document.getElementById('approveModal').classList.add('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        document.getElementById('approveModal').addEventListener('click', function(e) {
            if (e.target === this) closeApproveModal();
        });

        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) closeRejectModal();
        });
    </script>
</x-admin>
