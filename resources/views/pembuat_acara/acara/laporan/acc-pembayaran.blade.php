<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 max-w-6xl mx-auto">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('pembuat.transaksi.index', $acara->slug) }}"
                class="font-semibold text-gray-800">Transaksi</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="font-semibold text-blue-600">Verifikasi Pembayaran</span>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-6 lg:px-10">
            <!-- Header Card -->
            <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3 flex justify-between mb-4"
                role="alert">
                <div>
                    <p class="font-bold">Verifikasi Pembayaran</p>
                    <p class="text-sm">Periksa bukti pembayaran dan kelola status transaksi</p>
                </div>
                <div class="flex items-center gap-2">
                    @if ($pesanan->status_pembayaran == 'pending')
                        <span
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                            <i data-lucide="clock" class="size-4"></i>
                            Menunggu Verifikasi
                        </span>
                    @elseif ($pesanan->status_pembayaran == 'paid')
                        <span
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                            <i data-lucide="check-circle" class="size-4"></i>
                            Terverifikasi
                        </span>
                    @elseif ($pesanan->status_pembayaran == 'rejected')
                        <span
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold bg-red-100 text-red-800 border border-red-200">
                            <i data-lucide="ban" class="size-4"></i>
                            Ditolak
                        </span>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- Left column (lebih besar) -->
                <div class="md:col-span-7">
                    <div class="">

                        <!-- Bukti Pembayaran -->
                        @if ($pesanan->bukti_pembayaran)
                            <div class="bg-white rounded-xl border border-gray-300 overflow-hidden mb-6 ">
                                <div
                                    class="bg-gradient-to-r from-indigo-50 to-blue-50 px-6 py-4 border-b border-gray-200">
                                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                        <i data-lucide="image" class="size-5 mr-3 text-indigo-600"></i>
                                        Bukti Pembayaran
                                    </h3>
                                </div>
                                <div class="p-6">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div>
                                            <label class="text-sm font-semibold text-gray-600 block mb-1">Metode
                                                Pembayaran</label>
                                            <p class="text-lg font-bold text-gray-900 capitalize">Transfer
                                                {{ $pesanan->metode_pembayaran }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-semibold text-gray-600 block mb-1">Tanggal
                                                Upload</label>
                                            <p class="text-gray-700">{{ $pesanan->updated_at->format('d M Y') }}</p>
                                            <p class="text-xs text-gray-500">{{ $pesanan->updated_at->format('H:i') }}
                                                WIB</p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-semibold text-gray-600 block mb-1">Total
                                                Transfer</label>
                                            <p class="text-lg font-bold text-green-600">Rp
                                                {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-6 border-t pt-6">
                                        <label class="text-sm font-semibold text-gray-600 block mb-3">Gambar Bukti
                                            Pembayaran</label>
                                        <div
                                            class="border-2 border-gray-200 rounded-lg overflow-hidden bg-gray-50 hover:border-indigo-400 transition">
                                            <img src="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}"
                                                alt="Bukti Pembayaran" class="w-full h-auto cursor-pointer"
                                                onclick="openImageModal(this.src)">
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2 text-center">Klik gambar untuk memperbesar
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Detail Tiket -->
                        <div class="bg-white rounded-xl overflow-hidden mb-6 border border-gray-300">
                            <div class="bg-gray-50 px-6 py-4 border-b border-gray-300">
                                <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                    <i data-lucide="ticket" class="size-5 mr-2 text-gray-600"></i>
                                    Detail Tiket
                                </h3>
                            </div>
                            <div class="">
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Jenis
                                                    Tiket
                                                </th>
                                                <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">
                                                    Jumlah</th>
                                                <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">Harga
                                                </th>
                                                <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">
                                                    Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach ($daftarTiket as $tiket)
                                                <tr>
                                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                                        {{ $tiket['nama_tiket'] }}</td>
                                                    <td class="px-4 py-3 text-center text-sm text-gray-700">
                                                        {{ $tiket['jumlah'] }}
                                                    </td>
                                                    <td class="px-4 py-3 text-right text-sm text-gray-700">Rp
                                                        {{ number_format($tiket['harga'], 0, ',', '.') }}</td>
                                                    <td class="px-4 py-3 text-right text-sm font-medium text-gray-900">
                                                        Rp
                                                        {{ number_format($tiket['subtotal'], 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-gray-50">
                                            <tr>
                                                <td colspan="3"
                                                    class="px-4 py-3 text-right text-sm font-medium text-gray-900">
                                                    Total Pembayaran:</td>
                                                <td
                                                    class="px-4 py-3 text-right text-sm lg:text-lg font-bold text-blue-600">
                                                    Rp
                                                    {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right column (sidebar) -->
                <aside class="md:col-span-5 space-y-4" x-data="{ showRejectModal: false, showReasonModal: false }">
                    <div class="bg-white rounded-xl p-5 border border-gray-100 ">
                        {{-- Judul Acara Besar --}}
                        <h3 class="font-bold text-gray-900 text-lg mb-3 leading-snug">{{ $namaAcara }}</h3>

                        {{-- Detail dengan Ikon (Tanpa Label Teks) --}}
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-start gap-2.5">
                                @if ($isOnline)
                                    {{-- Tampilan Online (Ikon Video + Teks Biru) --}}
                                    <i data-lucide="video" class="size-4 text-indigo-500 mt-0.5 shrink-0"></i>
                                    <span class="leading-relaxed font-medium text-indigo-600">Acara Online</span>
                                @else
                                    {{-- Tampilan Offline (Ikon Map + Alamat Asli) --}}
                                    <i data-lucide="map-pin" class="size-4 text-indigo-500 mt-0.5 shrink-0"></i>
                                    <span class="leading-relaxed">{{ $lokasi }}</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2.5">
                                <i data-lucide="calendar" class="size-4 text-indigo-500 shrink-0"></i>
                                <span>{{ $waktuMulai }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl overflow-hidden border border-gray-100 ">
                        <div class="bg-gray-50/50 px-5 py-3 border-b border-gray-100">
                            <h3 class="font-semibold text-gray-900 flex items-center text-sm uppercase tracking-wider">
                                <i data-lucide="file-text" class="size-4 mr-2 text-gray-500"></i>
                                Data Pemesan
                            </h3>
                        </div>

                        <div class="p-5 space-y-4">
                            {{-- Kode Pesanan (Highlight) --}}
                            <div class="flex justify-between items-center pb-4 border-b border-gray-50">
                                <span class="text-sm text-gray-500">Kode Booking</span>
                                <span
                                    class="font-mono font-bold text-indigo-600 tracking-wide">{{ $pesanan->kode_pesanan }}</span>
                            </div>

                            {{-- List Info Compact --}}
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Nama</span>
                                    <span
                                        class="font-medium text-gray-900 text-right">{{ $pesanan->nama_pemesan }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Email</span>
                                    <span
                                        class="font-medium text-gray-900 text-right">{{ $pesanan->email_pemesan }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Telepon</span>
                                    <span
                                        class="font-medium text-gray-900 text-right">{{ $pesanan->no_telp_pemesan ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Tanggal</span>
                                    <span
                                        class="font-medium text-gray-900 text-right">{{ $pesanan->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 space-y-4">

                        {{-- KONDISI 1: STATUS PENDING (ACTION BUTTONS) --}}
                        @if ($pesanan->status_pembayaran == 'pending')
                            <div class="bg-white rounded-xl p-4 border border-gray-100 ">
                                <h3 class="font-semibold text-gray-900 text-sm mb-3 flex items-center">
                                    <i data-lucide="shield-check" class="size-4 mr-2 text-indigo-500"></i>
                                    Verifikasi Pembayaran
                                </h3>

                                {{-- Form Approve (Langsung Submit) --}}
                                <form
                                    action="{{ route('pembuat.transaksi.acc.store', [$acara->slug, $pesanan->kode_pesanan]) }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="kode_pesanan" value="{{ $pesanan->kode_pesanan }}">
                                    @foreach ($pesanan->detailPesanan as $detail)
                                        <input type="hidden" name="id_detail_pesanan[]"
                                            value="{{ $detail->id }}">
                                        <input type="hidden" name="nama_peserta[]"
                                            value="{{ $pesanan->nama_pemesan }}">
                                        <input type="hidden" name="email_peserta[]"
                                            value="{{ $pesanan->email_pemesan }}">
                                        <input type="hidden" name="no_telp_peserta[]"
                                            value="{{ $pesanan->no_telp_pemesan }}">
                                    @endforeach

                                    <div class="grid grid-cols-2 gap-2">
                                        {{-- Tombol Tolak (Buka Modal) --}}
                                        <button type="button" @click="showRejectModal = true"
                                            class="flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-colors border border-red-100">
                                            <i data-lucide="x-circle" class="size-3.5"></i>
                                            Tolak
                                        </button>

                                        {{-- Tombol Setuju --}}
                                        <button type="submit"
                                            onclick="return confirm('Setujui pembayaran ini? Tiket akan otomatis dibuat.')"
                                            class="flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors ">
                                            <i data-lucide="check-circle" class="size-3.5"></i>
                                            Setujui
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {{-- KONDISI 2: STATUS REJECTED (INFO COMPACT) --}}
                        @elseif ($pesanan->status_pembayaran == 'rejected')
                            <div class="bg-red-50 rounded-xl p-4 border border-red-100">
                                <div class="flex items-start gap-3">
                                    <i data-lucide="alert-circle" class="size-5 text-red-600 mt-0.5"></i>
                                    <div>
                                        <h3 class="font-semibold text-red-900 text-sm">Pembayaran Ditolak</h3>
                                        <p class="text-xs text-red-700 mt-1 mb-2">
                                            Ditolak pada {{ $pesanan->updated_at->format('d/m/y H:i') }}
                                        </p>
                                        @if ($pesanan->catatan_admin)
                                            <button type="button" @click="showReasonModal = true"
                                                class="text-xs font-medium text-red-800 underline hover:text-red-900">
                                                Lihat Alasan Penolakan
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif


                        {{-- MODAL 1: FORM TOLAK PEMBAYARAN --}}
                        <div x-show="showRejectModal" x-transition
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
                            style="display: none;">
                            <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden" @click.stop>
                                <div
                                    class="bg-red-50 px-6 py-4 border-b border-red-100 flex justify-between items-center">
                                    <h3 class="font-bold text-red-900 flex items-center gap-2">
                                        <i data-lucide="thumbs-down" class="size-5"></i>
                                        Tolak Pembayaran
                                    </h3>
                                    <button type="button" @click="showRejectModal = false"
                                        class="text-red-400 hover:text-red-600">
                                        <i data-lucide="x" class="size-5"></i>
                                    </button>
                                </div>

                                <form
                                    action="{{ route('pembuat.transaksi.acc.reject', [$acara->slug, $pesanan->kode_pesanan]) }}"
                                    method="POST" class="p-6">
                                    @csrf
                                    <p class="text-sm text-gray-600 mb-4">
                                        Berikan alasan penolakan agar pelanggan dapat memperbaiki pembayaran mereka.
                                    </p>
                                    <div class="mb-5">
                                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase">Catatan
                                            Admin <span class="text-red-500">*</span></label>
                                        <textarea name="catatan_admin" rows="4" required
                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 resize-none"
                                            placeholder="Contoh: Bukti transfer buram, nominal tidak sesuai..."></textarea>
                                    </div>
                                    <div class="flex justify-end gap-3">
                                        <button type="button" @click="showRejectModal = false"
                                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                            Batal
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 ">
                                            Kirim Penolakan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        {{-- MODAL 2: LIHAT ALASAN PENOLAKAN --}}
                        @if ($pesanan->status_pembayaran == 'rejected' && $pesanan->catatan_admin)
                            <div x-show="showReasonModal" x-transition
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
                                style="display: none;">
                                <div class="bg-white rounded-xl shadow-xl w-full max-w-sm overflow-hidden" @click.stop>
                                    <div
                                        class="px-5 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                                        <h3 class="font-bold text-gray-900 text-sm">Catatan Admin</h3>
                                        <button type="button" @click="showReasonModal = false"
                                            class="text-gray-400 hover:text-gray-600">
                                            <i data-lucide="x" class="size-4"></i>
                                        </button>
                                    </div>
                                    <div class="p-5">
                                        <div
                                            class="bg-red-50 text-red-800 text-sm p-3 rounded-lg border border-red-100 whitespace-pre-wrap leading-relaxed">
                                            {{ $pesanan->catatan_admin }}
                                        </div>
                                        <button type="button" @click="showReasonModal = false"
                                            class="w-full mt-4 px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </aside>
            </div>



            <!-- Image Modal -->
            <div id="imageModal"
                class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center p-4">
                <div class="relative max-w-4xl max-h-full">
                    <img id="modalImage" src="" alt="Bukti Pembayaran"
                        class="max-w-full max-h-full object-contain rounded-lg">
                    <button onclick="closeImageModal()"
                        class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75">
                        <i data-lucide="x" class="size-6"></i>
                    </button>
                </div>
            </div>

            @push('scripts')
                <script>
                    function openImageModal(src) {
                        document.getElementById('modalImage').src = src;
                        document.getElementById('imageModal').classList.remove('hidden');
                        document.getElementById('imageModal').classList.add('flex');
                    }

                    function closeImageModal() {
                        document.getElementById('imageModal').classList.add('hidden');
                        document.getElementById('imageModal').classList.remove('flex');
                    }

                    // Close modal when clicking outside
                    document.getElementById('imageModal').addEventListener('click', function(e) {
                        if (e.target === this) {
                            closeImageModal();
                        }
                    });

                    // Initialize Lucide icons
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                </script>
            @endpush
        </div>
    </div>
</x-app-layout>
