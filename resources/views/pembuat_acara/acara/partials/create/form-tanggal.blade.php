<div class="w-full" x-data="{
    showDateModal: false,
    startDate: '',
    endDate: '',

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
    }
}">
    <label class="mb-2 block text-sm font-medium text-gray-700">
        Tanggal Acara
    </label>

    <input type="hidden" name="waktu_mulai" x-model="startDate">
    <input type="hidden" name="waktu_selesai" x-model="endDate">

    <div class="flex items-start gap-3">
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

        <button type="button" @click="showDateModal = true"
            class="shrink-0 text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">
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
                    <input type="date" x-model="startDate"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-800 shadow-theme-xs focus:border-blue-500 focus:ring-blue-500/10 focus:ring-3 focus:outline-hidden appearance-none" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                        Selesai</label>
                    <input type="date" x-model="endDate"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-800 shadow-theme-xs focus:border-blue-500 focus:ring-blue-500/10 focus:ring-3 focus:outline-hidden appearance-none" />
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" @click="showDateModal = false"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button type="button" @click="showDateModal = false"
                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium">
                    Simpan Tanggal
                </button>
            </div>
        </div>
    </div>
</div>
