<div class="rounded-xl border border-gray-200 bg-white mt-5 p-4 sm:p-6">
    <div class="mb-6">
        <div class="flex items-center gap-2 mb-2">
            <i data-lucide="ticket" class="size-5 text-indigo-600"></i>
            <h3 class="text-lg font-semibold text-gray-900">Jenis Tiket</h3>
        </div>
        <p class="text-sm text-gray-600">Kelola kategori tiket untuk acara Anda</p>
    </div>

    <div x-data="{
        showModal: false,
        editIndex: null,
        currentType: 'gratis',
        // Data gabungan semua kategori tiket (gratis/berbayar)
        allKategori: {{ \Illuminate\Support\Js::from(
            $acara->jenisTiket->map(function ($tiket) {
                    return [
                        'id' => $tiket->id,
                        'nama' => $tiket->nama_jenis,
                        'harga' => (int) ($tiket->harga ?? 0),
                        'kuota' => (int) ($tiket->kuota ?? 0),
                        'penjualan_mulai' => $tiket->penjualan_mulai
                            ? \Carbon\Carbon::parse($tiket->penjualan_mulai)->format('Y-m-d')
                            : '',
                        'penjualan_selesai' => $tiket->penjualan_selesai
                            ? \Carbon\Carbon::parse($tiket->penjualan_selesai)->format('Y-m-d')
                            : '',
                        'berlaku_mulai' => $tiket->berlaku_mulai
                            ? \Carbon\Carbon::parse($tiket->berlaku_mulai)->format('Y-m-d')
                            : '',
                        'berlaku_sampai' => $tiket->berlaku_sampai
                            ? \Carbon\Carbon::parse($tiket->berlaku_sampai)->format('Y-m-d')
                            : '',
                        'deskripsi' => $tiket->deskripsi ?? '',
                        'tipe' => ($tiket->harga ?? 0) > 0 ? 'berbayar' : 'gratis',
                    ];
                })->values(),
        ) }},
    
        kategoriBaru: {
            nama: '',
            harga: 0,
            kuota: '',
            penjualan_mulai: '',
            penjualan_selesai: '',
            berlaku_mulai: '',
            berlaku_sampai: '',
            deskripsi: '',
            tipe: 'gratis'
        },
        tambahKategori() {
            this.kategoriBaru.tipe = this.currentType;
            if (this.currentType === 'gratis') this.kategoriBaru.harga = 0;
    
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
            this.kategoriBaru = JSON.parse(JSON.stringify(this.allKategori[index]));
            this.currentType = this.kategoriBaru.tipe;
            this.editIndex = index;
            this.showModal = true;
        },
        hapusKategori(index) {
            this.allKategori.splice(index, 1);
        },
        resetForm() {
            this.kategoriBaru = {
                nama: '',
                harga: '',
                kuota: '',
                penjualan_mulai: '',
                penjualan_selesai: '',
                berlaku_mulai: '',
                berlaku_sampai: '',
                deskripsi: '',
                tipe: this.currentType
            };
        },
        openAddModal(type) {
            this.currentType = type;
            this.editIndex = null;
            this.resetForm();
            this.showModal = true;
        }
    }" class="space-y-6">
        @if ($errors->has('kategori_tiket'))
            <div class="p-3 bg-red-50 text-red-600 text-sm rounded-lg">{{ $errors->first('kategori_tiket') }}</div>
        @endif

        <div class="space-y-3" x-show="allKategori.length > 0">
            <template x-for="(kategori, index) in allKategori" :key="index">
                <div class="group border rounded-xl p-4 transition-all hover:shadow-md hover:border-indigo-300"
                    :class="kategori.tipe === 'gratis' ? 'border-green-200 bg-green-50/30' :
                        'border-indigo-200 bg-indigo-50/30'">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3 sm:gap-4 flex-1 min-w-0">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg flex items-center justify-center flex-shrink-0"
                                :class="kategori.tipe === 'gratis' ? 'bg-green-100 text-green-600' :
                                    'bg-indigo-100 text-indigo-600'">
                                <i data-lucide="ticket" class="size-5 sm:size-6"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1 flex-wrap">
                                    <h4 class="font-semibold text-gray-900 text-sm sm:text-base truncate"
                                        x-text="kategori.nama"></h4>
                                    <span x-show="kategori.tipe === 'gratis'"
                                        class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-medium rounded-full flex-shrink-0">Gratis</span>
                                </div>
                                <div
                                    class="flex items-center gap-2 sm:gap-3 text-xs sm:text-sm text-gray-500 flex-wrap">
                                    <span x-show="kategori.tipe === 'berbayar'" class="font-semibold text-indigo-600">Rp
                                        <span
                                            x-text="parseInt(kategori.harga || 0).toLocaleString('id-ID')"></span></span>
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="users" class="size-3.5"></i>
                                        <span x-text="kategori.kuota"></span>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="calendar" class="size-3.5"></i>
                                        <span
                                            x-text="new Date(kategori.penjualan_mulai).toLocaleDateString('id-ID', {day: '2-digit', month: 'short'})"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 flex-shrink-0">
                            <button type="button" @click="editKategori(index)"
                                class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-100 rounded-lg transition-colors">
                                <i data-lucide="edit-3" class="size-4"></i>
                            </button>
                            <button type="button" @click="hapusKategori(index)"
                                class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-100 rounded-lg transition-colors">
                                <i data-lucide="trash-2" class="size-4"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Hidden inputs -->
                    <template x-if="kategori.id">
                        <input type="hidden" :name="`kategori_tiket[${index}][id]`" :value="kategori.id">
                    </template>
                    <input type="hidden" :name="`kategori_tiket[${index}][nama]`" :value="kategori.nama">
                    <input type="hidden" :name="`kategori_tiket[${index}][harga]`" :value="kategori.harga">
                    <input type="hidden" :name="`kategori_tiket[${index}][kuota]`" :value="kategori.kuota">
                    <input type="hidden" :name="`kategori_tiket[${index}][penjualan_mulai]`"
                        :value="kategori.penjualan_mulai">
                    <input type="hidden" :name="`kategori_tiket[${index}][penjualan_selesai]`"
                        :value="kategori.penjualan_selesai">
                    <input type="hidden" :name="`kategori_tiket[${index}][berlaku_mulai]`"
                        :value="kategori.berlaku_mulai">
                    <input type="hidden" :name="`kategori_tiket[${index}][berlaku_sampai]`"
                        :value="kategori.berlaku_sampai">
                    <input type="hidden" :name="`kategori_tiket[${index}][deskripsi]`" :value="kategori.deskripsi">
                    <input type="hidden" :name="`kategori_tiket[${index}][tipe]`" :value="kategori.tipe">
                </div>
            </template>
        </div>

        <!-- Marker: minimal 1 tiket -->
        <input type="hidden" name="has_tickets" x-ref="hasTickets" :value="allKategori.length > 0 ? 1 : ''"
            x-effect="$refs.hasTickets.dispatchEvent(new Event('input', { bubbles: true }))" />

        <!-- Empty State -->
        <div x-show="allKategori.length === 0"
            class="text-center py-12 sm:py-16 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
            <div
                class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                <i data-lucide="ticket" class="size-8 sm:size-10 text-gray-400"></i>
            </div>
            <p class="text-gray-600 font-medium text-sm sm:text-base">Belum ada tiket</p>
            <p class="text-xs sm:text-sm text-gray-400 mt-1">Tambahkan minimal 1 tiket untuk dapat mem-publish acara</p>
        </div>

        <!-- Tombol Tambah -->
        <div class="grid grid-cols-2 gap-3 pt-2">
            <button type="button" @click="openAddModal('gratis')"
                class="flex justify-center items-center gap-2 px-4 py-3 bg-green-50 hover:bg-green-100 text-green-700 border border-green-200 rounded-xl transition-all font-medium text-sm">
                <i data-lucide="plus" class="size-4"></i>
                <span>Tiket Gratis</span>
            </button>
            <button type="button" @click="openAddModal('berbayar')"
                class="flex justify-center items-center gap-2 px-4 py-3 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-xl transition-all font-medium text-sm">
                <i data-lucide="plus" class="size-4"></i>
                <span>Tiket Berbayar</span>
            </button>
        </div>

        <!-- Modal -->
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
            x-show="showModal" x-transition x-cloak style="display: none;">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md" @click.outside="showModal = false">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                            :class="currentType === 'gratis' ? 'bg-green-100 text-green-600' : 'bg-indigo-100 text-indigo-600'">
                            <i data-lucide="ticket" class="size-5"></i>
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

                <!-- Form Body -->
                <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Tiket</label>
                        <input type="text" x-model="kategoriBaru.nama"
                            placeholder="contoh: VIP, Regular, Early Bird"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm">
                    </div>

                    <div x-show="currentType === 'berbayar'">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 font-medium">Rp</span>
                            <input type="number" x-model="kategoriBaru.harga" placeholder="0"
                                class="w-full pl-12 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kuota Tiket</label>
                        <input type="number" x-model="kategoriBaru.kuota" min="1" placeholder="100"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mulai Jual</label>
                            <input type="date" x-model="kategoriBaru.penjualan_mulai"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Selesai Jual</label>
                            <input type="date" x-model="kategoriBaru.penjualan_selesai"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm">
                        </div>
                    </div>

                    <!-- Berlaku periode tiket -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Berlaku Mulai</label>
                            <input type="date" x-model="kategoriBaru.berlaku_mulai"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Berlaku Sampai</label>
                            <input type="date" x-model="kategoriBaru.berlaku_sampai"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi <span
                                class="text-gray-400 font-normal">(opsional)</span></label>
                        <textarea x-model="kategoriBaru.deskripsi" rows="3" placeholder="Deskripsi singkat tiket..."
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm resize-none"></textarea>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex gap-3 p-6 border-t border-gray-100">
                    <button type="button" @click="showModal = false"
                        class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">Batal</button>
                    <button type="button" @click="tambahKategori()"
                        class="flex-1 px-4 py-2.5 rounded-lg text-sm font-medium text-white transition-colors"
                        :class="currentType === 'gratis' ? 'bg-green-600 hover:bg-green-700' :
                            'bg-indigo-600 hover:bg-indigo-700'">
                        <span x-text="editIndex !== null ? 'Simpan' : 'Tambah'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
