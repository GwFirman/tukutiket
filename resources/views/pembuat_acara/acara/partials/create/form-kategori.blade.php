<div class="w-full mt-6" x-data="{
    showCategoryModal: false,
    selectedCategory: null,
    selectedCategoryName: '',

    init() {
        // Muat nilai lama (old) jika ada
        const oldCategoryId = '{{ old('id_kategori', '') }}';
        if (oldCategoryId) {
            this.selectedCategory = parseInt(oldCategoryId);
            // Cari nama kategori berdasarkan ID
            @foreach ($kategori as $kat)
                if (this.selectedCategory === {{ $kat->id }}) {
                    this.selectedCategoryName = '{{ $kat->nama_kategori }}';
                } @endforeach
        }
    },

    selectCategory(id, name) {
        this.selectedCategory = id;
        this.selectedCategoryName = name;
        this.showCategoryModal = false;
    }
}">
    <label class="mb-2 block text-sm font-medium text-gray-700">
        Kategori Acara
    </label>

    <input type="hidden" name="id_kategori" x-model="selectedCategory" required>

    <div class="flex items-start gap-3">
        <div class="shrink-0 mt-0.5 text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
        </div>

        <div class="mr-4">
            <p class="text-gray-900 font-medium" x-text="selectedCategoryName || 'Belum ada kategori dipilih'">
            </p>
            <p class="text-gray-500 text-sm mt-0.5">
                Tentukan kategori acara Anda
            </p>
        </div>

        <button type="button" @click="showCategoryModal = true"
            class="shrink-0 text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                <path d="m15 5 4 4" />
            </svg>
        </button>
    </div>

    <div x-show="showCategoryModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/80">
        <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-lg mx-4" @click.outside="showCategoryModal = false">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Pilih Kategori Acara</h3>
                <button type="button" @click="showCategoryModal = false" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-4 max-h-96 overflow-y-auto">
                <!-- Grid Kategori -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach ($kategori as $kat)
                        <button type="button" @click="selectCategory({{ $kat->id }}, '{{ $kat->nama_kategori }}')"
                            class="group relative flex items-center justify-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition-all hover:border-indigo-300 hover:shadow-md"
                            :class="selectedCategory == {{ $kat->id }} ? 'border-indigo-500 bg-indigo-50' : ''">

                            <!-- Label -->
                            <span
                                class="text-sm font-medium text-gray-700 text-center group-hover:text-indigo-700 transition-colors"
                                :class="selectedCategory == {{ $kat->id }} ? 'text-indigo-600' : ''">
                                {{ $kat->nama_kategori }}
                            </span>

                            <!-- Selected Indicator -->
                            <div class="absolute top-3 right-3 w-4 h-4 rounded-full border-2 border-gray-300 bg-white transition-all"
                                :class="selectedCategory == {{ $kat->id }} ?
                                    'opacity-100 border-indigo-500 bg-indigo-500' : 'opacity-0'">
                                <div
                                    class="w-2 h-2 bg-white rounded-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" @click="showCategoryModal = false"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button type="button" @click="showCategoryModal = false"
                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium"
                    :disabled="!selectedCategory">
                    Pilih Kategori
                </button>
            </div>
        </div>
    </div>

    @error('id_kategori')
        <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ $message }}</span>
        </div>
    @enderror
</div>

<style>
    /* Custom styling for better UX */
    input[type="radio"]:checked+.peer-checked\:bg-indigo-500 {
        background-color: rgb(99 102 241);
    }

    input[type="radio"]:checked+.peer-checked\:border-indigo-500 {
        border-color: rgb(99 102 241);
    }

    input[type="radio"]:checked+.peer-checked\:text-indigo-600 {
        color: rgb(79 70 229);
    }

    input[type="radio"]:checked+.peer-checked\:text-white {
        color: white;
    }

    /* Animation untuk check icon */
    .peer:checked~.peer-checked\:scale-75 {
        transform: scale(0.75);
    }
</style>
