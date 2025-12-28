<div class="w-full" x-data="{
    showTimeModal: false,
    startTime: '',
    endTime: '',
    isPublished: {{ isset($acara) && $acara->status === 'published' ? 'true' : 'false' }},

    // Helper format tampilan jam
    formatDisplayTime(timeStr) {
        if (!timeStr) return '';
        return timeStr + ' WIB';
    },

    // Helper menghitung durasi waktu
    get duration() {
        if (this.startTime && this.endTime) {
            // Kita buat dummy date agar bisa dihitung selisihnya
            let start = new Date('1970-01-01T' + this.startTime + 'Z');
            let end = new Date('1970-01-01T' + this.endTime + 'Z');

            // Hitung selisih dalam milidetik
            let diffMs = end - start;

            if (diffMs <= 0) return 'Waktu selesai harus lebih akhir';

            let diffMins = Math.floor(diffMs / 60000);
            let hours = Math.floor(diffMins / 60);
            let minutes = diffMins % 60;

            let result = '';
            if (hours > 0) result += hours + ' Jam ';
            if (minutes > 0) result += minutes + ' Menit';

            return result.trim() || 'Kurang dari 1 menit';
        }
        return 'Tentukan durasi waktu';
    },

    // Validasi range waktu
    get isValidTimeRange() {
        if (!this.startTime || !this.endTime) return false;
        return this.endTime > this.startTime;
    }
}" x-init="startTime = '{{ old('jam_mulai') ? \Carbon\Carbon::parse(old('jam_mulai'))->format('H:i') : (isset($acara->jam_mulai) ? \Carbon\Carbon::parse($acara->jam_mulai)->format('H:i') : '') }}';
endTime = '{{ old('jam_selesai') ? \Carbon\Carbon::parse(old('jam_selesai'))->format('H:i') : (isset($acara->jam_selesai) ? \Carbon\Carbon::parse($acara->jam_selesai)->format('H:i') : '') }}'">

    <label class="mb-2 text-sm font-medium text-gray-700">
        Waktu Acara <span class="text-red-400">*</span>
        @if (isset($acara) && $acara->status === 'published')
            {{-- <span class="ml-2 inline px-2 py-1 text-xs font-semibold text-orange-700 bg-orange-100 rounded">
                Tidak bisa diubah
            </span> --}}
        @endif
    </label>

    <input type="hidden" name="jam_mulai" x-model="startTime">
    <input type="hidden" name="jam_selesai" x-model="endTime">

    <div class="flex items-start gap-3" :class="{ 'opacity-60 pointer-events-none': isPublished }">
        <div class="shrink-0 mt-0.5 text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <div class="mr-4">
            <p class="text-gray-900 font-medium"
                x-text="startTime && endTime ? `${formatDisplayTime(startTime)} - ${formatDisplayTime(endTime)}` : 'Belum ada waktu dipilih'">
            </p>
            <p class="text-gray-500 text-sm mt-0.5" x-text="duration"></p>
        </div>

        <button type="button" @click="showTimeModal = true" :disabled="isPublished"
            :class="{ 'opacity-50 cursor-not-allowed': isPublished }"
            class="shrink-0 text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline disabled:hover:text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                <path d="m15 5 4 4" />
            </svg>
        </button>
    </div>

    <div x-show="showTimeModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/80">

        <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4" @click.outside="showTimeModal = false">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Pilih Waktu Acara</h3>
                <button type="button" @click="showTimeModal = false" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                        <input type="time" x-model="startTime" :disabled="isPublished"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-800 shadow-theme-xs focus:border-blue-500 focus:ring-blue-500/10 focus:ring-3 focus:outline-hidden appearance-none disabled:opacity-50 disabled:cursor-not-allowed" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                        <input type="time" x-model="endTime" :disabled="isPublished"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-800 shadow-theme-xs focus:border-blue-500 focus:ring-blue-500/10 focus:ring-3 focus:outline-hidden appearance-none disabled:opacity-50 disabled:cursor-not-allowed" />
                    </div>
                </div>

                <p x-show="endTime && !isValidTimeRange"
                    class="text-xs text-red-600 bg-red-50 p-2 rounded border border-red-100 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Jam selesai harus setelah jam mulai.
                </p>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" @click="showTimeModal = false"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button type="button" @click="showTimeModal = false" :disabled="!isValidTimeRange || isPublished"
                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 disabled:bg-blue-300 disabled:cursor-not-allowed text-white rounded-lg text-sm font-medium">
                    Simpan Waktu
                </button>
            </div>
        </div>
    </div>
</div>
