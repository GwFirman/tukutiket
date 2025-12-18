<div>
    <div class="rounded-2xl border border-gray-200 bg-white mt-5 p-6">
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Jenis Tiket</h3>
            <p class="text-sm text-gray-500 mt-1">Tentukan kategori tiket untuk acara Anda</p>
        </div>

        <div x-data="{
            showModal: false,
            editIndex: null,
            currentType: 'gratis',
            allKategori: [],
            kategoriBaru: {
                nama: '',
                harga: '',
                kuota: '',
                penjualan_mulai: '',
                penjualan_selesai: '',
                deskripsi: '',
                tipe: 'gratis'
            },
            tambahKategori() {
                this.kategoriBaru.tipe = this.currentType;
                if (this.editIndex !== null) {
                    this.allKategori[this.editIndex] = { ...this.kategoriBaru };
                    this.editIndex = null;
                } else {
                    this.allKategori.push({ ...this.kategoriBaru });
                }
                this.resetForm();
                this.showModal = false;
            },
            editKategori(index) {
                this.kategoriBaru = { ...this.allKategori[index] };
                this.currentType = this.kategoriBaru.tipe;
                this.editIndex = index;
                this.showModal = true;
            },
            resetForm() {
                this.kategoriBaru = {
                    nama: '',
                    harga: '',
                    kuota: '',
                    penjualan_mulai: '',
                    penjualan_selesai: '',
                    deskripsi: '',
                    tipe: 'gratis'
                };
            },
            openAddModal(type) {
                this.currentType = type;
                this.resetForm();
                this.showModal = true;
            }
        }" class="space-y-6">

            <!-- Daftar Semua Kategori Tiket -->
            <div class="space-y-3" x-show="allKategori.length > 0">
                <template x-for="(kategori, index) in allKategori" :key="index">
                    <div class="group border rounded-xl p-4 transition-all hover:shadow-md"
                        :class="kategori.tipe === 'gratis' ? 'border-green-200 bg-green-50/30 hover:border-green-400' :
                            'border-indigo-200 bg-indigo-50/30 hover:border-indigo-400'">
                        <div class="flex items-center justify-between">
                            <!-- Left: Ticket Info -->
                            <div class="flex items-center gap-4">

                                <!-- Icon -->
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                                    :class="kategori.tipe === 'gratis' ? 'bg-green-100' : 'bg-indigo-100'">
                                    <i class="size-6"
                                        :class="kategori.tipe === 'gratis' ? 'text-green-600' : 'text-indigo-600'"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-ticket-icon lucide-ticket">
                                            <path
                                                d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z" />
                                            <path d="M13 5v2" />
                                            <path d="M13 17v2" />
                                            <path d="M13 11v2" />
                                        </svg></i>
                                </div>

                                <!-- Info -->
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h4 class="font-semibold text-gray-900" x-text="kategori.nama"></h4>
                                        <span x-show="kategori.tipe === 'gratis'"
                                            class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-medium rounded-full">Gratis</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-sm text-gray-500">
                                        <span x-show="kategori.tipe === 'berbayar'"
                                            class="font-semibold text-indigo-600">
                                            Rp <span x-text="parseInt(kategori.harga).toLocaleString('id-ID')"></span>
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="size-3.5"><svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                    height="14" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="lucide lucide-users-icon lucide-users">
                                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                                    <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                                    <circle cx="9" cy="7" r="4" />
                                                </svg></i>
                                            <span x-text="kategori.kuota"></span>
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i data-lucide="calendar" class="size-3.5"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-calendar-icon lucide-calendar">
                                                    <path d="M8 2v4" />
                                                    <path d="M16 2v4" />
                                                    <rect width="18" height="18" x="3" y="4" rx="2" />
                                                    <path d="M3 10h18" />
                                                </svg></i>
                                            <span
                                                x-text="new Date(kategori.penjualan_mulai).toLocaleDateString('id-ID', {day: '2-digit', month: 'short'}) + ' - ' + new Date(kategori.penjualan_selesai).toLocaleDateString('id-ID', {day: '2-digit', month: 'short'})"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Actions -->
                            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button type="button" @click="editKategori(index)"
                                    class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-100 rounded-lg transition-colors">
                                    <i data-lucide="pencil" class="size-4"></i>
                                </button>
                                <button type="button" @click="allKategori.splice(index, 1)"
                                    class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-100 rounded-lg transition-colors">
                                    <i data-lucide="trash-2" class="size-4"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Description (if exists) -->
                        <p x-show="kategori.deskripsi" class="mt-2 ml-16 text-sm text-gray-500 line-clamp-1"
                            x-text="kategori.deskripsi"></p>

                        <!-- Hidden inputs -->
                        <template x-for="(value, key) in kategori" :key="key">
                            <input type="hidden" :name="`kategori_tiket[${index}][${key}]`" :value="value">
                        </template>
                    </div>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="allKategori.length === 0"
                class="text-center py-16 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <i data-lucide="ticket" class="size-8 text-gray-400"></i>
                </div>
                <p class="text-gray-600 font-medium">Belum ada tiket</p>
                <p class="text-sm text-gray-400 mt-1">Tambahkan tiket untuk acara Anda</p>
            </div>

            <!-- Tombol Tambah -->
            <div class="grid grid-cols-2 gap-3 pt-2">
                <button type="button" @click="openAddModal('gratis')"
                    class="flex items-center justify-center gap-2 px-4 py-3 bg-green-50 hover:bg-green-100 text-green-700 border border-green-200 rounded-xl transition-all group">
                    <i data-lucide="plus" class="size-4 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Tiket Gratis</span>
                </button>
                <button type="button" @click="openAddModal('berbayar')"
                    class="flex items-center justify-center gap-2 px-4 py-3 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-xl transition-all group">
                    <i data-lucide="plus" class="size-4 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Tiket Berbayar</span>
                </button>
            </div>

            <!-- Modal -->
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
                x-show="showModal" x-transition.opacity x-cloak @click.self="showModal = false">
                <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md mx-4" x-show="showModal"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                :class="currentType === 'gratis' ? 'bg-green-100' : 'bg-indigo-100'">
                                <i data-lucide="ticket" class="size-5"
                                    :class="currentType === 'gratis' ? 'text-green-600' : 'text-indigo-600'"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900"
                                    x-text="editIndex !== null ? 'Edit Tiket' : 'Tambah Tiket'"></h3>
                                <p class="text-sm text-gray-500"
                                    x-text="currentType === 'gratis' ? 'Tiket Gratis' : 'Tiket Berbayar'"></p>
                            </div>
                        </div>
                        <button type="button" @click="showModal = false"
                            class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                            <i data-lucide="x" class="size-5"></i>
                        </button>
                    </div>

                    <!-- Form -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Tiket</label>
                            <input type="text" x-model="kategoriBaru.nama"
                                placeholder="contoh: VIP, Regular, Early Bird"
                                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div x-show="currentType === 'berbayar'" x-transition>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Harga</label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 font-medium">Rp</span>
                                <input type="number" x-model="kategoriBaru.harga" placeholder="0"
                                    class="w-full rounded-xl border border-gray-300 pl-12 pr-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah Tiket</label>
                            <input type="number" x-model="kategoriBaru.kuota" min="1" placeholder="100"
                                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Mulai Jual</label>
                                <input type="date" x-model="kategoriBaru.penjualan_mulai"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Selesai Jual</label>
                                <input type="date" x-model="kategoriBaru.penjualan_selesai"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi <span
                                    class="text-gray-400 font-normal">(opsional)</span></label>
                            <textarea x-model="kategoriBaru.deskripsi" rows="2" placeholder="Deskripsi singkat tiket..."
                                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500 resize-none"></textarea>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mt-6 flex gap-3">
                        <button type="button" @click="showModal = false"
                            class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="button" @click="tambahKategori()"
                            class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium text-white transition-colors"
                            :class="currentType === 'gratis' ? 'bg-green-600 hover:bg-green-700' :
                                'bg-indigo-600 hover:bg-indigo-700'">
                            <span x-text="editIndex !== null ? 'Simpan' : 'Tambah'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
