<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 max-w-4xl mx-auto">
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
        <div class="max-w-4xl mx-auto px-6  lg:px-0">

            <!-- Header Card -->
            <div class="bg-white rounded-xl  overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-xl font-bold text-white">Verifikasi Pembayaran</h1>
                            <p class="text-blue-100 text-sm mt-1">Detail pesanan dan bukti pembayaran</p>
                        </div>
                        <div class="flex items-center gap-2">
                            @if ($pesanan->status_pembayaran == 'pending')
                                <span
                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                    <i data-lucide="clock" class="size-3"></i>
                                    Menunggu Verifikasi
                                </span>
                            @elseif ($pesanan->status_pembayaran == 'paid')
                                <span
                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                    <i data-lucide="check-circle" class="size-3"></i>
                                    Terverifikasi
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bukti Pembayaran -->
            @if ($pesanan->bukti_pembayaran)
                <div class="bg-white rounded-xl border border-gray-300 overflow-hidden mb-6">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-300">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i data-lucide="image" class="size-5 mr-2 text-gray-600"></i>
                            Bukti Pembayaran
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Metode Pembayaran</label>
                                <p class="text-lg font-semibold text-gray-900 capitalize">Transfer Bank
                                    {{ $pesanan->metode_pembayaran }}</p>

                                <div class="mt-4">
                                    <label class="text-sm font-medium text-gray-500">Tanggal Upload</label>
                                    <p class="text-gray-700">{{ $pesanan->updated_at->format('d F Y, H:i') }} WIB</p>
                                </div>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 block mb-2">Gambar Bukti</label>
                                <div class="border-2 border-gray-200 rounded-lg p-2">
                                    <img src="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}"
                                        alt="Bukti Pembayaran" class="w-full h-auto rounded-lg "
                                        onclick="openImageModal(this.src)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Detail Pesanan -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Informasi Pesanan -->
                <div class="bg-white rounded-xl overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <i data-lucide="file-text" class="size-5 mr-2 text-gray-600"></i>
                            Informasi Pesanan
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Kode Pesanan</label>
                            <p class="text-lg font-mono font-bold text-gray-900">{{ $pesanan->kode_pesanan }}</p>
                        </div>
                        <div class="border-t pt-4">
                            <label class="text-sm font-medium text-gray-500">Nama Pemesan</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $pesanan->nama_pemesan }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Email</label>
                            <p class="text-gray-700">{{ $pesanan->email_pemesan }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">No. Telepon</label>
                            <p class="text-gray-700">{{ $pesanan->no_telp_pemesan ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Tanggal Pesanan</label>
                            <p class="text-gray-700">{{ $pesanan->created_at->format('d F Y, H:i') }} WIB</p>
                        </div>
                    </div>
                </div>

                <!-- Detail Acara -->
                <div class="bg-white rounded-xl overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <i data-lucide="calendar" class="size-5 mr-2 text-gray-600"></i>
                            Detail Acara
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Nama Acara</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $namaAcara }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Lokasi</label>
                            <p class="text-gray-700">{{ $lokasi }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Tanggal Acara</label>
                            <p class="text-gray-700">{{ $waktuMulai }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Tiket -->
            <div class="bg-white rounded-xl overflow-hidden mb-6">
                <div class="bg-gray-50 px-6 py-4 border-b">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                        <i data-lucide="ticket" class="size-5 mr-2 text-gray-600"></i>
                        Detail Tiket
                    </h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Jenis Tiket</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">Jumlah</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">Harga</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($daftarTiket as $tiket)
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                            {{ $tiket['nama_tiket'] }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-gray-700">{{ $tiket['jumlah'] }}
                                        </td>
                                        <td class="px-4 py-3 text-right text-sm text-gray-700">Rp
                                            {{ number_format($tiket['harga'], 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right text-sm font-medium text-gray-900">Rp
                                            {{ number_format($tiket['subtotal'], 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-900">
                                        Total Pembayaran:</td>
                                    <td class="px-4 py-3 text-right text-lg font-bold text-blue-600">Rp
                                        {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            @if ($pesanan->status_pembayaran == 'pending')
                <div class="bg-white rounded-xl overflow-hidden">
                    <div class="p-6">
                        <!-- Form untuk Approve Pembayaran -->
                        <form
                            action="{{ route('pembuat.transaksi.acc.store', [$acara->slug, $pesanan->kode_pesanan]) }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="kode_pesanan" value="{{ $pesanan->kode_pesanan }}">
                            @foreach ($pesanan->detailPesanan as $detail)
                                <input type="hidden" name="id_detail_pesanan[]" value="{{ $detail->id }}">
                                <input type="hidden" name="nama_peserta[]" value="{{ $pesanan->nama_pemesan }}">
                                <input type="hidden" name="email_peserta[]" value="{{ $pesanan->email_pemesan }}">
                                <input type="hidden" name="no_telp_peserta[]"
                                    value="{{ $pesanan->no_telp_pemesan }}">
                            @endforeach

                            <div class="flex flex-col sm:flex-row gap-4">
                                <button type="submit"
                                    onclick="return confirm('Apakah Anda yakin ingin menyetujui pembayaran ini?\n\nTiket akan digenerate dan status pembayaran akan diubah menjadi PAID.')"
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                                    <i data-lucide="check-circle" class="size-5"></i>
                                    Setujui Pembayaran
                                </button>
                                <button type="button" onclick="rejectPembayaran()"
                                    class="flex-1 bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                                    <i data-lucide="x-circle" class="size-5"></i>
                                    Tolak Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center p-4">
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

            function rejectPembayaran() {
                if (confirm('Apakah Anda yakin ingin menolak pembayaran ini?')) {
                    // TODO: Implement reject logic
                    console.log('Reject pembayaran');
                }
            }

            // Close modal when clicking outside
            document.getElementById('imageModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeImageModal();
                }
            });
        </script>
    @endpush
</x-app-layout>
