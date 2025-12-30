<div class="mb-6 space-y-3 sm:space-y-0">
    <div class="flex justify-between items-center">
        {{-- Tombol Kembali --}}
        <a href="{{ route('pembuat.acara.index') }}"
            class="inline-flex items-center gap-2 text-gray-600 hover:text-indigo-600 transition">
            <i data-lucide="arrow-left" class="size-4"></i>
            Kembali ke Daftar
        </a>

        {{-- Area Tombol Action --}}
        <div class="flex items-center gap-2 lg:gap-3">

            @if ($acara->status === 'published')
                {{-- Tombol Archive --}}
                {{-- <button type="button" onclick="openArchiveModal()"
                    class="inline-flex items-center gap-2 px-3 lg:px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition font-medium text-sm">
                    <i data-lucide="archive" class="size-4"></i>
                    <span class="">Archive</span>
                </button> --}}
            @elseif ($acara->status === 'pending_verifikasi')
                {{-- Status Pending --}}
                <button type="button" disabled
                    class="inline-flex items-center gap-2 px-3 lg:px-4 py-2 bg-yellow-50 text-yellow-600 rounded-lg cursor-not-allowed font-medium text-sm opacity-75">
                    <i data-lucide="clock" class="size-4"></i>
                    <span class="">Menunggu Verifikasi</span>
                </button>
            @elseif ($acara->status === 'rejected')
                {{-- Status Pending --}}
                {{-- <button type="button" disabled
                    class="inline-flex items-center gap-2 px-3 lg:px-4 py-2 bg-yellow-50 text-yellow-600 rounded-lg cursor-not-allowed font-medium text-sm opacity-75">
                    <i data-lucide="clock" class="size-4"></i>
                    <span class="">Menunggu Verifikasi</span>
                </button> --}}
            @else
                {{-- Tombol Publish (Draft) --}}
                <form method="POST" action="{{ route('pembuat.acara.publish', $acara->id) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-3 lg:px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium text-sm">
                        <i data-lucide="upload" class="size-4"></i>
                        <span class="">Publish</span>
                    </button>
                </form>
            @endif

        </div>
    </div>
</div>

{{-- Modal Archive Confirmation --}}
<div id="archiveModal" class="fixed inset-0 bg-black/30 b z-50 hidden items-center justify-center p-4"
    style="display: none;">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full overflow-hidden">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-red-400 flex items-center justify-center">
                    <i data-lucide="alert-circle" class="size-5 text-white"></i>
                </div>
                <h2 class="text-lg font-bold text-white">Archive Acara</h2>
            </div>
        </div>

        {{-- Body --}}
        <div class="px-6 py-6">
            <p class="text-gray-700 mb-2">
                Apakah Anda yakin ingin <span class="font-semibold">mengarchive acara ini?</span>
            </p>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mt-4">
                <p class="text-sm text-red-800">
                    <span class="font-semibold">⚠️ Perhatian:</span> Acara yang diarchive akan tersembunyi dari daftar
                    acara aktif dan tidak akan ditampilkan kepada pembeli. Data dan tiket akan tetap tersimpan.
                </p>
            </div>
            <p class="text-sm text-gray-600 mt-4">
                <span class="font-semibold">Nama Acara:</span> {{ $acara->nama_acara }}
            </p>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex gap-3">
            <button type="button" onclick="closeArchiveModal()"
                class="flex-1 px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-100 transition text-sm">
                Batal
            </button>
            <form id="archiveForm" method="POST" action="{{ route('pembuat.acara.archive', $acara->id) }}"
                class="flex-1">
                @csrf
                @method('PATCH')
                <button type="submit"
                    class="w-full px-4 py-2.5 rounded-lg bg-red-600 text-white font-medium hover:bg-red-700 transition text-sm flex items-center justify-center gap-2">
                    <i data-lucide="archive" class="size-4"></i>
                    Ya, Archive
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openArchiveModal() {
        document.getElementById('archiveModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeArchiveModal() {
        document.getElementById('archiveModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('archiveModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeArchiveModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeArchiveModal();
        }
    });
</script>
