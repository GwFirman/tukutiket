    <div class="rounded-2xl border border-gray-200 bg-white mt-5 p-5">
        <div class="rounded-2xl border border-gray-200 bg-white mt-5 p-5">
            <h3 class="text-base font-medium text-gray-800 mb-3">Jenis Tiket</h3>

            <div class="flex items-center gap-8">
                <label class="flex items-center gap-2">
                    <input type="radio" name="jenis_tiket" wire:model="selected" value="gratis" class="text-blue-600">
                    <span>Gratis</span>
                </label>

                <label class="flex items-center gap-2">
                    <input type="radio" name="jenis_tiket" wire:model="selected" value="berbayar"
                        class="text-blue-600">
                    <span>Berbayar</span>
                </label>
            </div>

            <p class="mt-3 text-sm text-gray-600">Dipilih: {{ $selected }}</p>
        </div>



        <!-- Daftar Kategori -->
        @if ($selected === 'berbayar')
            <div class="w-full mt-4 space-y-3">
                @forelse ($kategoriList as $index => $kategori)
                    <div class="flex justify-between items-center border rounded-lg p-4 bg-gray-50">
                        <div>
                            <h4 class="font-medium text-gray-800">{{ $kategori['nama'] }}</h4>
                            <p class="text-gray-500 text-sm">Rp
                                {{ number_format($kategori['harga'] ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex gap-2">
                            <button wire:click="openModal({{ $index }})" type="button"
                                class="text-blue-600 hover:underline text-sm">Edit</button>
                            <button wire:click="hapusKategori({{ $index }})" type="button"
                                class="text-red-600 hover:underline text-sm">Hapus</button>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Belum ada kategori tiket.</p>
                @endforelse

                <!-- Tombol Tambah -->
                <button wire:click="openModal" type="button"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Tambah Kategori Tiket
                </button>
            </div>
        @endif

        <!-- Modal -->
        @if ($showModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-900">
                            {{ $editIndex !== null ? 'Edit Kategori Tiket' : 'Tambah Kategori Tiket' }}
                        </h3>
                        <button wire:click="closeModal" type="button" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Form -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                            <input type="text" wire:model.defer="kategoriBaru.nama"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('kategoriBaru.nama')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                            <input type="number" wire:model.defer="kategoriBaru.harga"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Tiket</label>
                            <input type="number" wire:model.defer="kategoriBaru.kuota"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai Penjualan</label>
                            <input type="date" wire:model.defer="kategoriBaru.penjualan_mulai"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai
                                Penjualan</label>
                            <input type="date" wire:model.defer="kategoriBaru.penjualan_selesai"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea wire:model.defer="kategoriBaru.deskripsi" rows="3"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="mt-6 flex justify-end gap-3">
                        <button wire:click="closeModal" type="button"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button wire:click="tambahKategori" type="button"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                            {{ $editIndex !== null ? 'Simpan Perubahan' : 'Tambah Kategori' }}
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
