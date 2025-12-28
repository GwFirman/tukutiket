@php
    // 1. Inisialisasi variabel default
    $selectedId = null;
    $selectedName = '';

    // 2. Cek apakah ada input lama (jika submit gagal)
    if (old('id_kategori')) {
        $selectedId = old('id_kategori');
        // Cari nama kategori berdasarkan ID dari list $kategori untuk ditampilkan
        $oldKategori = $kategori->firstWhere('id', $selectedId);
        $selectedName = $oldKategori ? $oldKategori->nama_kategori : '';
    }
    // 3. Jika tidak ada old input, cek data dari database ($acara)
    elseif (isset($acara)) {
        // Mengambil item pertama dari relasi kategori sesuai request
        // Menggunakan property access ($acara->kategori) agar efisien (tidak query ulang jika sudah di-load)
        // Kita handle jika return-nya Collection atau Single Model
        $kategoriAcara =
            $acara->kategori instanceof \Illuminate\Support\Collection ? $acara->kategori->first() : $acara->kategori;

        if ($kategoriAcara) {
            $selectedId = $kategoriAcara->id;
            $selectedName = $kategoriAcara->nama_kategori;
        }
    }
@endphp

<div class="w-full mt-6 border rounded-2xl border-gray-100" x-data="{
    showCategoryModal: false,
    selectedCategory: @js($selectedId), // Render aman ke Javascript (null atau int)
    selectedCategoryName: @js($selectedName), // Render aman ke string

    // Fungsi Helper untuk memilih kategori
    selectCategory(id, name) {
        this.selectedCategory = id;
        this.selectedCategoryName = name;
        this.showCategoryModal = false;
    }
}">
    <div class="flex items-center gap-2 p-5">
        <i data-lucide="calendars" class="size-5 text-indigo-600"></i>
        <h3 class="text-lg font-semibold text-gray-900">Kategori acara <span class="text-red-400">*</span></h3>
    </div>

    <input type="hidden" name="id_kategori" x-model="selectedCategory" required>

    <div class="flex items-start gap-3 border-t border-gray-100 p-5">
        <div class="shrink-0 mt-0.5 text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
        </div>

        <div class="mr-4">
            <p class="text-gray-900 font-medium"
                x-text="selectedCategoryName ? selectedCategoryName : 'Belum ada kategori dipilih'">
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
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach ($kategori as $kat)
                        <button type="button" @click="selectCategory({{ $kat->id }}, '{{ $kat->nama_kategori }}')"
                            class="group relative flex items-center justify-center p-4 border-2 rounded-xl cursor-pointer transition-all hover:shadow-md"
                            :class="selectedCategory == {{ $kat->id }} ?
                                'border-indigo-500 bg-indigo-50' :
                                'border-gray-200 hover:border-indigo-300'">

                            <span class="text-sm font-medium text-center transition-colors"
                                :class="selectedCategory == {{ $kat->id }} ?
                                    'text-indigo-600' :
                                    'text-gray-700 group-hover:text-indigo-700'">
                                {{ $kat->nama_kategori }}
                            </span>

                            <div class="absolute top-3 right-3 w-4 h-4 rounded-full border-2 transition-all"
                                :class="selectedCategory == {{ $kat->id }} ?
                                    'opacity-100 border-indigo-500 bg-indigo-500' :
                                    'opacity-0 border-gray-300 bg-white'">
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
            </div>
        </div>
    </div>

    @error('id_kategori')
        <div class="flex items-center gap-2 text-red-600 text-sm mt-2 px-5 pb-5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ $message }}</span>
        </div>
    @enderror
</div>
