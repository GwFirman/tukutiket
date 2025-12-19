<x-admin>
    <x-slot:header>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 ">
                <i data-lucide="shield" class="size-5 text-gray-600"></i>
                <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
                <p class="font-medium">Moderasi Kreator</p>
                <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
                <p class="font-medium">Detail Verifikasi</p>
            </div>
            <div>
                @if ($verifikasi->status === 'pending')
                    <span
                        class="px-4 py-2 inline-flex items-center gap-2 text-sm font-semibold rounded-full bg-amber-100 text-amber-800">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        Menunggu Review
                    </span>
                @elseif($verifikasi->status === 'approved')
                    <span
                        class="px-4 py-2 inline-flex items-center gap-2 text-sm font-semibold rounded-full bg-emerald-100 text-emerald-800">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        Disetujui
                    </span>
                @else
                    <span
                        class="px-4 py-2 inline-flex items-center gap-2 text-sm font-semibold rounded-full bg-rose-100 text-rose-800">
                        <i data-lucide="x-circle" class="w-4 h-4"></i>
                        Ditolak
                    </span>
                @endif
            </div>
        </div>
    </x-slot:header>

    <div class="p-6 space-y-6 max-w-7xl mx-auto">
        <!-- Flash Message -->
        @if (session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Info Kreator -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Profile Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-8 text-center">
                        <div
                            class="w-20 h-20 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-2xl font-bold mx-auto mb-3">
                            {{ strtoupper(substr($verifikasi->kreator->user->name ?? 'N', 0, 1)) }}
                        </div>
                        <h3 class="text-white font-bold text-lg">{{ $verifikasi->kreator->user->name ?? 'N/A' }}</h3>
                        <p class="text-indigo-100 text-sm">{{ $verifikasi->kreator->user->email ?? 'N/A' }}</p>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-indigo-100 p-2 rounded-lg">
                                <i data-lucide="user" class="w-4 h-4 text-indigo-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Nama Kreator</p>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $verifikasi->kreator->nama_kreator ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="bg-indigo-100 p-2 rounded-lg">
                                <i data-lucide="phone" class="w-4 h-4 text-indigo-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Nomor Telepon</p>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $verifikasi->kreator->no_telepon ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="bg-indigo-100 p-2 rounded-lg">
                                <i data-lucide="calendar" class="w-4 h-4 text-indigo-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Tanggal Submit</p>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $verifikasi->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Catatan Admin (jika sudah di-review) -->
                @if ($verifikasi->status !== 'pending')
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center gap-2">
                            <div class="bg-indigo-100 p-2 rounded-lg">
                                <i data-lucide="message-square" class="w-4 h-4 text-indigo-600"></i>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900">Catatan Admin</h3>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <p class="text-gray-700 text-sm leading-relaxed">
                                {{ $verifikasi->catatan_admin ?? 'Tidak ada catatan' }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Dokumen & Action -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Dokumen -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-white">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i data-lucide="file-check" class="w-5 h-5 text-indigo-600"></i>
                            Dokumen Verifikasi
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Foto KTP -->
                            <div class="group h-full">
                                <div class=" rounded-xl p-4 bg-indigo-50 transition-colors h-full flex flex-col">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                            <span
                                                class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded-md text-xs font-bold">KTP</span>
                                            Kartu Tanda Penduduk
                                        </h4>
                                        @if ($verifikasi->foto_ktp)
                                            <span
                                                class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full text-xs font-medium">
                                                <i data-lucide="check" class="w-3 h-3 inline"></i> Ada
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex-1 flex flex-col">
                                        @if ($verifikasi->foto_ktp)
                                            <div
                                                class="relative mb-3 rounded-lg overflow-hidden bg-gray-100 flex-1 min-h-[200px]">
                                                <img src="{{ asset('storage/' . $verifikasi->foto_ktp) }}"
                                                    alt="Foto KTP"
                                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 absolute inset-0">
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4">
                                                    <a href="{{ asset('storage/' . $verifikasi->foto_ktp) }}"
                                                        target="_blank"
                                                        class="px-4 py-2 bg-white text-gray-900 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors inline-flex items-center gap-2">
                                                        <i data-lucide="maximize-2" class="w-4 h-4"></i>
                                                        Lihat Penuh
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <div
                                                class="bg-gray-50 rounded-lg text-center border-2 border-dashed border-gray-200 flex-1 min-h-[200px] flex flex-col items-center justify-center">
                                                <div class="bg-gray-100 p-3 rounded-full w-fit mx-auto mb-3">
                                                    <i data-lucide="file-x" class="w-6 h-6 text-gray-400"></i>
                                                </div>
                                                <p class="text-gray-500 text-sm">Dokumen tidak tersedia</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Foto NPWP -->
                            <div class="group h-full">
                                <div class="rounded-xl p-4 bg-indigo-50 transition-colors h-full flex flex-col">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                            <span
                                                class="bg-purple-100 text-purple-700 px-2 py-1 rounded-md text-xs font-bold">NPWP</span>
                                            Nomor Pokok Wajib Pajak
                                        </h4>
                                        @if ($verifikasi->foto_npwp)
                                            <span
                                                class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full text-xs font-medium">
                                                <i data-lucide="check" class="w-3 h-3 inline"></i> Ada
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex-1 flex flex-col">
                                        @if ($verifikasi->foto_npwp)
                                            <div
                                                class="relative mb-3 rounded-lg overflow-hidden bg-gray-100 flex-1 min-h-[200px]">
                                                <img src="{{ asset('storage/' . $verifikasi->foto_npwp) }}"
                                                    alt="Foto NPWP"
                                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 absolute inset-0">
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4">
                                                    <a href="{{ asset('storage/' . $verifikasi->foto_npwp) }}"
                                                        target="_blank"
                                                        class="px-4 py-2 bg-white text-gray-900 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors inline-flex items-center gap-2">
                                                        <i data-lucide="maximize-2" class="w-4 h-4"></i>
                                                        Lihat Penuh
                                                    </a>
                                                </div>
                                            </div>
                                            <a href="{{ asset('storage/' . $verifikasi->foto_npwp) }}" download
                                                class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-medium text-sm transition-colors">
                                                <i data-lucide="download" class="w-4 h-4"></i>
                                                Download NPWP
                                            </a>
                                        @else
                                            <div
                                                class="bg-gray-50 rounded-lg text-center border-2 border-dashed border-gray-200 flex-1 min-h-[200px] flex flex-col items-center justify-center">
                                                <div class="bg-gray-100 p-3 rounded-full w-fit mx-auto mb-3">
                                                    <i data-lucide="file-x" class="w-6 h-6 text-gray-400"></i>
                                                </div>
                                                <p class="text-gray-500 text-sm">Dokumen tidak tersedia</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                @if ($verifikasi->status === 'pending')
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-white">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <i data-lucide="clipboard-check" class="w-5 h-5 text-indigo-600"></i>
                                Aksi Review
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Form Setujui -->
                                <form action="{{ route('admin.mod-kreator.approve', $verifikasi->id) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full px-6 py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl hover:from-emerald-600 hover:to-emerald-700 font-medium inline-flex items-center justify-center gap-3 transition-all shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40">
                                        <div class="bg-white/20 p-2 rounded-lg">
                                            <i data-lucide="check-circle" class="w-5 h-5"></i>
                                        </div>
                                        <div class="text-left">
                                            <span class="block font-semibold">Setujui Verifikasi</span>
                                            <span class="block text-xs text-emerald-100">Kreator akan dapat membuat
                                                event</span>
                                        </div>
                                    </button>
                                </form>

                                <!-- Tombol Tolak -->
                                <div x-data="{ showRejectForm: false }">
                                    <button @click="showRejectForm = true" x-show="!showRejectForm"
                                        class="w-full px-6 py-4 bg-gradient-to-r from-rose-500 to-rose-600 text-white rounded-xl hover:from-rose-600 hover:to-rose-700 font-medium inline-flex items-center justify-center gap-3 transition-all shadow-lg shadow-rose-500/25 hover:shadow-rose-500/40">
                                        <div class="bg-white/20 p-2 rounded-lg">
                                            <i data-lucide="x-circle" class="w-5 h-5"></i>
                                        </div>
                                        <div class="text-left">
                                            <span class="block font-semibold">Tolak Verifikasi</span>
                                            <span class="block text-xs text-rose-100">Kreator harus upload ulang
                                                dokumen</span>
                                        </div>
                                    </button>

                                    <!-- Form Tolak Expanded -->
                                    <form action="{{ route('admin.mod-kreator.reject', $verifikasi->id) }}"
                                        method="POST" x-show="showRejectForm" x-transition
                                        class="bg-rose-50 p-5 rounded-xl border border-rose-200 space-y-4">
                                        @csrf
                                        <div class="flex items-center justify-between">
                                            <label class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                                <i data-lucide="message-circle" class="w-4 h-4 text-rose-600"></i>
                                                Alasan Penolakan
                                            </label>
                                            <button type="button" @click="showRejectForm = false"
                                                class="text-gray-400 hover:text-gray-600 transition-colors">
                                                <i data-lucide="x" class="w-5 h-5"></i>
                                            </button>
                                        </div>
                                        <textarea name="catatan_admin" placeholder="Jelaskan alasan penolakan secara detail..."
                                            class="w-full px-4 py-3 border border-rose-200 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500 bg-white resize-none"
                                            rows="4">{{ old('catatan_admin') }}</textarea>
                                        @error('catatan_admin')
                                            <p class="text-rose-600 text-sm flex items-center gap-1">
                                                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                        <div class="flex gap-3">
                                            <button type="submit"
                                                class="flex-1 px-4 py-2.5 bg-rose-600 text-white rounded-lg hover:bg-rose-700 font-medium text-sm transition-colors inline-flex items-center justify-center gap-2">
                                                <i data-lucide="send" class="w-4 h-4"></i>
                                                Kirim Penolakan
                                            </button>
                                            <button type="button" @click="showRejectForm = false"
                                                class="px-4 py-2.5 bg-white text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm border border-gray-200 transition-colors">
                                                Batal
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div
                        class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-xl p-6 text-center">
                        <div class="bg-white p-3 rounded-full w-fit mx-auto mb-3 shadow-sm">
                            @if ($verifikasi->status === 'approved')
                                <i data-lucide="badge-check" class="w-8 h-8 text-emerald-600"></i>
                            @else
                                <i data-lucide="badge-x" class="w-8 h-8 text-rose-600"></i>
                            @endif
                        </div>
                        <p class="text-gray-700 font-medium">Verifikasi ini sudah di-review</p>
                        <p class="text-gray-500 text-sm mt-1">Status tidak dapat diubah lagi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin>
