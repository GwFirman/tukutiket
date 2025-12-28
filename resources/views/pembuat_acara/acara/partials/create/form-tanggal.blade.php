<div class="w-full" x-data="{
    showDateModal: false,
    startDate: '',
    endDate: '',
    today: new Date().toISOString().slice(0, 10),
    isPublished: {{ isset($acara) && $acara->status === 'published' ? 'true' : 'false' }},

    // Helper untuk format tanggal (Contoh: 17 Desember 2025)
    formatDate(dateStr) {
        if (!dateStr) return '';
        const options = { day: 'numeric', month: 'short', year: 'numeric' };
        return new Date(dateStr).toLocaleDateString('id-ID', options);
    },

    // Helper untuk menghitung durasi hari
    get duration() {
        if (this.startDate && this.endDate) {
            const start = new Date(this.startDate);
            const end = new Date(this.endDate);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            return diffDays + ' Hari';
        }
        return 'Tentukan durasi acara';
    },

    get isValidRange() {
        if (!this.startDate || !this.endDate) return false;
        return new Date(this.endDate) >= new Date(this.startDate);
    }
}" x-init="startDate = '{{ old('waktu_mulai') ? \Carbon\Carbon::parse(old('waktu_mulai'))->format('Y-m-d') : (isset($acara->waktu_mulai) ? \Carbon\Carbon::parse($acara->waktu_mulai)->format('Y-m-d') : '') }}';
endDate = '{{ old('waktu_selesai') ? \Carbon\Carbon::parse(old('waktu_selesai'))->format('Y-m-d') : (isset($acara->waktu_selesai) ? \Carbon\Carbon::parse($acara->waktu_selesai)->format('Y-m-d') : '') }}'">
    <label class="mb-2 text-sm font-medium text-gray-700">
        Tanggal Acara <span class="text-red-400">*</span>
        @if (isset($acara) && $acara->status === 'published')
            {{-- <span class="ml-2 inline px-2 py-1 text-xs font-semibold text-orange-700 bg-orange-100 rounded">
                Tidak bisa diubah
            </span> --}}
        @endif
    </label>

    <input type="hidden" name="waktu_mulai" x-model="startDate">
    <input type="hidden" name="waktu_selesai" x-model="endDate">

    <div class="flex items-start gap-3" :class="{ 'opacity-60 pointer-events-none': isPublished }">
        <div class="shrink-0 mt-0.5 text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>

        <div class="mr-4">
            <p class="text-gray-900 font-medium"
                x-text="startDate && endDate ? `${formatDate(startDate)} - ${formatDate(endDate)}` : 'Belum ada tanggal dipilih'">
            </p>
            <p class="text-gray-500 text-sm mt-0.5" x-text="duration">
            </p>
        </div>

        <button type="button" @click="showDateModal = true" :disabled="isPublished"
            :class="{ 'opacity-50 cursor-not-allowed': isPublished }"
            class="shrink-0 text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline disabled:hover:text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                <path d="m15 5 4 4" />
            </svg>
        </button>
    </div>

    <div x-show="showDateModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/80">

        <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4" @click.outside="showDateModal = false">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Pilih Tanggal Acara</h3>
                <button type="button" @click="showDateModal = false" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                        Mulai</label>
                    <input type="date" x-model="startDate" :min="today" :disabled="isPublished"
                        @change="if (endDate && new Date(endDate) < new Date(startDate)) endDate = ''"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-800 shadow-theme-xs focus:border-blue-500 focus:ring-blue-500/10 focus:ring-3 focus:outline-hidden appearance-none disabled:opacity-50 disabled:cursor-not-allowed" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                        Selesai</label>
                    <input type="date" x-model="endDate" :min="startDate || today" :disabled="isPublished"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-800 shadow-theme-xs focus:border-blue-500 focus:ring-blue-500/10 focus:ring-3 focus:outline-hidden appearance-none disabled:opacity-50 disabled:cursor-not-allowed" />
                    <p x-show="endDate && !isValidRange" class="mt-1 text-xs text-red-600">Tanggal selesai tidak boleh
                        sebelum tanggal mulai.</p>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" @click="showDateModal = false"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button type="button" @click="showDateModal = false" :disabled="!isValidRange || isPublished"
                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 disabled:bg-blue-300 disabled:cursor-not-allowed text-white rounded-lg text-sm font-medium">
                    Simpan Tanggal
                </button>
            </div>
        </div>
    </div>
</div>
