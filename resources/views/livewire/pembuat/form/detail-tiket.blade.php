 <div>
     {{-- <div class="mt-5 w-full">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700">
                                Banner tiket
                            </label>
                            <input type="file" name="banner_tiket"
                                class="focus:border-ring-brand-300 shadow-theme-xs focus:file:ring-brand-300 h-11 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:pr-3 file:pl-3.5 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden " />
                        </div> --}}

     <div class="rounded-2xl border border-gray-200 bg-white mt-5 p-5">
         <div class="px-5 py-4 sm:px-6 sm:py-5">
             <h3 class="text-base font-medium text-gray-800">
                 Jenis Tiket
             </h3>
         </div>
         <div x-data="{
             adaGratis: false,
             adaBerbayar: false,
             showModal: false,
             editIndex: null,
             currentType: 'gratis', // 'gratis' atau 'berbayar'
             kategoriGratis: [],
             kategoriBerbayar: [],
             kategoriBaru: {
                 nama: '',
                 harga: '',
                 kuota: '',
                 penjualan_mulai: '',
                 penjualan_selesai: '',
                 deskripsi: ''
             },
             get kategoriList() {
                 return this.currentType === 'gratis' ? this.kategoriGratis : this.kategoriBerbayar;
             },
             tambahKategori() {
                 if (this.editIndex !== null) {
                     this.kategoriList[this.editIndex] = { ...this.kategoriBaru };
                     this.editIndex = null;
                 } else {
                     this.kategoriList.push({ ...this.kategoriBaru });
                 }
                 this.resetForm();
                 this.showModal = false;
             },
             editKategori(index) {
                 this.kategoriBaru = { ...this.kategoriList[index] };
                 this.editIndex = index;
                 this.showModal = true;
             },
             hapusKategori(index) {
                 this.kategoriList.splice(index, 1);
             },
             resetForm() {
                 this.kategoriBaru = {
                     nama: '',
                     harga: '',
                     kuota: '',
                     penjualan_mulai: '',
                     penjualan_selesai: '',
                     deskripsi: ''
                 };
             },
             openAddModal(type) {
                 this.currentType = type;
                 this.showModal = true;
             }
         }" class="flex flex-wrap items-center gap-2">
             <!-- Pilihan Tiket Type -->
             <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                 <!-- Pilihan Gratis -->
                 <div class="group relative overflow-hidden rounded-xl border-2 transition-all duration-300 cursor-pointer"
                     :class="adaGratis ?
                         'border-green-500 bg-gradient-to-br from-green-50 to-emerald-50 ' :
                         'border-gray-200 bg-white hover:border-green-300'"
                     @click="adaGratis = !adaGratis">
                     <div class="p-6">
                         <label class="flex items-center cursor-pointer">
                             <input type="checkbox" @change="adaGratis = !adaGratis" class="sr-only" />
                             <div class="relative">
                                 <div :class="adaGratis ?
                                     'border-green-500 bg-green-500 shadow-green-200' :
                                     'border-gray-300 bg-white'"
                                     class="flex h-6 w-6 items-center justify-center rounded-full border-2 transition-all duration-200 shadow-sm">
                                     <svg x-show="adaGratis" x-transition.opacity class="h-3.5 w-3.5 text-white"
                                         fill="currentColor" viewBox="0 0 20 20">
                                         <path fill-rule="evenodd"
                                             d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                             clip-rule="evenodd" />
                                     </svg>
                                 </div>
                             </div>
                             <div class="ml-4">
                                 <div class="flex items-center gap-2 mb-1">
                                     <span
                                         class="text-sm font-medium text-gray-600 uppercase tracking-wider">Tambah</span>
                                 </div>
                                 <h3 class="text-2xl font-bold text-gray-900 mb-1">Tiket Gratis</h3>
                                 <p class="text-sm text-gray-500">Tidak ada biaya untuk peserta</p>
                             </div>
                         </label>
                     </div>
                     <!-- Accent line -->
                     <div :class="adaGratis ? 'bg-green-500' : 'bg-gray-200'"
                         class="absolute bottom-0 left-0 h-1 w-full transition-all duration-300">
                     </div>
                 </div>

                 <!-- Pilihan Berbayar -->
                 <div class="group relative overflow-hidden rounded-xl border-2 transition-all duration-300 cursor-pointer"
                     :class="adaBerbayar ?
                         'border-blue-500 bg-gradient-to-br from-blue-50 to-indigo-50 shadow-lg' :
                         'border-gray-200 bg-white hover:border-blue-300 hover:shadow-md'"
                     @click="adaBerbayar = !adaBerbayar">
                     <div class="p-6">
                         <label class="flex items-center cursor-pointer">
                             <input type="checkbox" @change="adaBerbayar = !adaBerbayar" class="sr-only" />
                             <div class="relative">
                                 <div :class="adaBerbayar ?
                                     'border-blue-500 bg-blue-500 shadow-blue-200' :
                                     'border-gray-300 bg-white'"
                                     class="flex h-6 w-6 items-center justify-center rounded-full border-2 transition-all duration-200 shadow-sm">
                                     <svg x-show="adaBerbayar" x-transition.opacity class="h-3.5 w-3.5 text-white"
                                         fill="currentColor" viewBox="0 0 20 20">
                                         <path fill-rule="evenodd"
                                             d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                             clip-rule="evenodd" />
                                     </svg>
                                 </div>
                             </div>
                             <div class="ml-4">
                                 <div class="flex items-center gap-2 mb-1">
                                     <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                             d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                     </svg>
                                     <span
                                         class="text-sm font-medium text-gray-600 uppercase tracking-wider">Tambah</span>
                                 </div>
                                 <h3 class="text-2xl font-bold text-gray-900 mb-1">Tiket Berbayar
                                 </h3>
                                 <p class="text-sm text-gray-500">Tetapkan kategori dan harga tiket
                                 </p>
                             </div>
                         </label>
                     </div>
                     <!-- Accent line -->
                     <div :class="adaBerbayar ? 'bg-blue-500' : 'bg-gray-200'"
                         class="absolute bottom-0 left-0 h-1 w-full transition-all duration-300">
                     </div>
                 </div>
             </div>

             <!-- Daftar Kategori Tiket Gratis -->
             <div class="w-full mt-6" x-show="adaGratis" x-transition>
                 <div class="mb-4 flex items-center justify-between">
                     <div class="flex items-center gap-2">
                         <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                         </svg>
                         <h4 class="text-sm font-semibold text-gray-700 uppercase">Kategori Tiket
                             Gratis</h4>
                     </div>
                     <span class="text-xs text-gray-500" x-text="`${kategoriGratis.length} Kategori`"></span>
                 </div>

                 <div class="space-y-3">
                     <template x-for="(kategori, index) in kategoriGratis" :key="index">
                         <div
                             class="group relative bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-5 hover:shadow-lg transition-all duration-300 hover:border-green-400">
                             <!-- Ticket Icon -->
                             <div class="absolute top-4 left-4 opacity-10">
                                 <svg class="w-16 h-16 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                     <path
                                         d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z" />
                                 </svg>
                             </div>

                             <div class="relative flex items-start justify-between">
                                 <div class="flex-1">
                                     <!-- Ticket Name (No Price) -->
                                     <div class="flex items-center gap-3 mb-3">
                                         <div class="bg-green-600 p-2 rounded-lg">
                                             <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                     d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                             </svg>
                                         </div>
                                         <div>
                                             <h4 class="text-lg font-bold text-gray-900" x-text="kategori.nama"></h4>
                                             <p class="text-sm font-bold text-green-600">Gratis</p>
                                         </div>
                                     </div>

                                     <!-- Details Grid -->
                                     <div class="grid grid-cols-2 gap-3 mb-3">
                                         <div class="bg-white/70 rounded-lg p-3">
                                             <p class="text-xs text-gray-500 mb-1">Kuota Tiket</p>
                                             <p class="text-sm font-semibold text-gray-900 flex items-center gap-1">
                                                 <svg class="w-4 h-4 text-green-600" fill="currentColor"
                                                     viewBox="0 0 20 20">
                                                     <path
                                                         d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                                 </svg>
                                                 <span x-text="kategori.kuota + ' tiket'"></span>
                                             </p>
                                         </div>
                                         <div class="bg-white/70 rounded-lg p-3">
                                             <p class="text-xs text-gray-500 mb-1">Penjualan</p>
                                             <p class="text-xs font-medium text-gray-700">
                                                 <span
                                                     x-text="new Date(kategori.penjualan_mulai).toLocaleDateString('id-ID', {day: '2-digit', month: 'short'})"></span>
                                                 -
                                                 <span
                                                     x-text="new Date(kategori.penjualan_selesai).toLocaleDateString('id-ID', {day: '2-digit', month: 'short'})"></span>
                                             </p>
                                         </div>
                                     </div>

                                     <!-- Description -->
                                     <div class="bg-white/70 rounded-lg p-3" x-show="kategori.deskripsi">
                                         <p class="text-xs text-gray-500 mb-1">Deskripsi</p>
                                         <p class="text-sm text-gray-700 line-clamp-2" x-text="kategori.deskripsi">
                                         </p>
                                     </div>
                                 </div>

                                 <!-- Action Buttons -->
                                 <div class="flex flex-col gap-2 ml-4">
                                     <button type="button" @click="currentType = 'gratis'; editKategori(index)"
                                         class="flex items-center gap-1 px-3 py-2 bg-white border border-green-300 text-green-600 rounded-lg hover:bg-green-50 transition-colors text-sm font-medium shadow-sm">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                 d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                         </svg>
                                         Edit
                                     </button>
                                     <button type="button" @click="kategoriGratis.splice(index, 1)"
                                         class="flex items-center gap-1 px-3 py-2 bg-white border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors text-sm font-medium shadow-sm">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                 d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                         </svg>
                                         Hapus
                                     </button>
                                 </div>
                             </div>

                             <!-- Hidden inputs - dengan nama field kategori_tiket -->
                             <template x-for="(value, key) in kategori" :key="key">
                                 <input type="hidden" :name="`kategori_tiket[${index}][${key}]`"
                                     :value="value">
                             </template>
                         </div>
                     </template>
                 </div>

                 <!-- Empty State -->
                 <div x-show="kategoriGratis.length === 0"
                     class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                     <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                     </svg>
                     <p class="text-gray-500 font-medium">Belum ada kategori tiket gratis</p>
                     <p class="text-sm text-gray-400 mt-1">Klik tombol "Tambah Kategori Tiket" untuk
                         memulai</p>
                 </div>
             </div>

             <!-- Tombol Tambah Kategori Gratis -->
             <div class="w-full mt-2" x-show="adaGratis" x-transition>
                 <button type="button" @click="openAddModal('gratis')"
                     class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                         fill="currentColor">
                         <path fill-rule="evenodd"
                             d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                             clip-rule="evenodd" />
                     </svg>
                     Tambah Kategori Tiket Gratis
                 </button>
             </div>

             <!-- Daftar Kategori Tiket Berbayar -->
             <div class="w-full mt-6" x-show="adaBerbayar" x-transition>
                 <div class="mb-4 flex items-center justify-between">
                     <div class="flex items-center gap-2">
                         <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                         </svg>
                         <h4 class="text-sm font-semibold text-gray-700 uppercase">Kategori Tiket
                             Berbayar</h4>
                     </div>
                     <span class="text-xs text-gray-500" x-text="`${kategoriBerbayar.length} Kategori`"></span>
                 </div>

                 <div class="space-y-3">
                     <template x-for="(kategori, index) in kategoriBerbayar" :key="index">
                         <div
                             class="group relative bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-5 hover:shadow-lg transition-all duration-300 hover:border-blue-400">
                             <!-- Ticket Icon -->
                             <div class="absolute top-4 left-4 opacity-10">
                                 <svg class="w-16 h-16 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                     <path
                                         d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z" />
                                 </svg>
                             </div>

                             <div class="relative flex items-start justify-between">
                                 <div class="flex-1">
                                     <!-- Ticket Name & Price -->
                                     <div class="flex items-center gap-3 mb-3">
                                         <div class="bg-blue-600 p-2 rounded-lg">
                                             <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round"
                                                     stroke-width="2"
                                                     d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                             </svg>
                                         </div>
                                         <div>
                                             <h4 class="text-lg font-bold text-gray-900" x-text="kategori.nama"></h4>
                                             <p class="text-2xl font-bold text-blue-600">
                                                 Rp <span
                                                     x-text="parseInt(kategori.harga).toLocaleString('id-ID')"></span>
                                             </p>
                                         </div>
                                     </div>

                                     <!-- Details Grid -->
                                     <div class="grid grid-cols-2 gap-3 mb-3">
                                         <div class="bg-white/70 rounded-lg p-3">
                                             <p class="text-xs text-gray-500 mb-1">Kuota Tiket</p>
                                             <p class="text-sm font-semibold text-gray-900 flex items-center gap-1">
                                                 <svg class="w-4 h-4 text-blue-600" fill="currentColor"
                                                     viewBox="0 0 20 20">
                                                     <path
                                                         d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                                 </svg>
                                                 <span x-text="kategori.kuota + ' tiket'"></span>
                                             </p>
                                         </div>
                                         <div class="bg-white/70 rounded-lg p-3">
                                             <p class="text-xs text-gray-500 mb-1">Penjualan</p>
                                             <p class="text-xs font-medium text-gray-700">
                                                 <span
                                                     x-text="new Date(kategori.penjualan_mulai).toLocaleDateString('id-ID', {day: '2-digit', month: 'short'})"></span>
                                                 -
                                                 <span
                                                     x-text="new Date(kategori.penjualan_selesai).toLocaleDateString('id-ID', {day: '2-digit', month: 'short'})"></span>
                                             </p>
                                         </div>
                                     </div>

                                     <!-- Description -->
                                     <div class="bg-white/70 rounded-lg p-3" x-show="kategori.deskripsi">
                                         <p class="text-xs text-gray-500 mb-1">Deskripsi</p>
                                         <p class="text-sm text-gray-700 line-clamp-2" x-text="kategori.deskripsi">
                                         </p>
                                     </div>
                                 </div>

                                 <!-- Action Buttons -->
                                 <div class="flex flex-col gap-2 ml-4">
                                     <button type="button" @click="currentType = 'berbayar'; editKategori(index)"
                                         class="flex items-center gap-1 px-3 py-2 bg-white border border-blue-300 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors text-sm font-medium shadow-sm">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                 d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                         </svg>
                                         Edit
                                     </button>
                                     <button type="button" @click="kategoriBerbayar.splice(index, 1)"
                                         class="flex items-center gap-1 px-3 py-2 bg-white border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors text-sm font-medium shadow-sm">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                 d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                         </svg>
                                         Hapus
                                     </button>
                                 </div>
                             </div>

                             <!-- Hidden inputs - dengan nama field kategori_tiket -->
                             <template x-for="(value, key) in kategori" :key="key">
                                 <input type="hidden"
                                     :name="`kategori_tiket[${kategoriGratis.length + index}][${key}]`"
                                     :value="value">
                             </template>
                         </div>
                     </template>
                 </div>

                 <!-- Empty State -->
                 <div x-show="kategoriBerbayar.length === 0"
                     class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                     <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                     </svg>
                     <p class="text-gray-500 font-medium">Belum ada kategori tiket berbayar</p>
                     <p class="text-sm text-gray-400 mt-1">Klik tombol "Tambah Kategori Tiket" untuk
                         memulai</p>
                 </div>
             </div>

             <!-- Tombol Tambah Kategori Berbayar -->
             <div class="w-full mt-2" x-show="adaBerbayar" x-transition>
                 <button type="button" @click="openAddModal('berbayar')"
                     class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                         fill="currentColor">
                         <path fill-rule="evenodd"
                             d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                             clip-rule="evenodd" />
                     </svg>
                     Tambah Kategori Tiket Berbayar
                 </button>
             </div>

             <!-- Modal Konfigurasi Kategori -->
             <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 " x-show="showModal"
                 x-transition.opacity x-cloak @click.self="showModal = false">
                 <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4">
                     <div class="flex justify-between items-center mb-4">
                         <h3 class="text-xl font-semibold text-gray-900"
                             x-text="editIndex !== null ? 'Edit Kategori Tiket' : 'Tambah Kategori Tiket'">
                         </h3>
                         <button type="button" @click="showModal = false" class="text-gray-400 hover:text-gray-500">
                             <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                     d="M6 18L18 6M6 6l12 12" />
                             </svg>
                         </button>
                     </div>

                     <!-- Form -->
                     <div class="space-y-4">
                         <div>
                             <label class="block text-sm font-medium text-gray-700 mb-1">Nama
                                 Kategori</label>
                             <input type="text" x-model="kategoriBaru.nama"
                                 class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                         </div>

                         <!-- Price Field - Only for Paid Tickets -->
                         <div x-show="currentType === 'berbayar'">
                             <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                             <div class="relative">
                                 <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Rp</span>
                                 <input type="text" x-model="kategoriBaru.harga"
                                     class="w-full rounded-lg border border-gray-300 pl-10 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                             </div>
                         </div>

                         <div>
                             <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah
                                 Tiket</label>
                             <input type="number" x-model="kategoriBaru.kuota" min="1" max="999"
                                 placeholder="Masukkan jumlah (1-999)"
                                 class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                             <p class="text-xs text-gray-500 mt-1">Maksimal 999 tiket per kategori
                             </p>
                         </div>
                         <div>
                             <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                 Mulai Penjualan</label>
                             <input type="date" x-model="kategoriBaru.penjualan_mulai"
                                 class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                         </div>
                         <div>
                             <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                 Selesai Penjualan</label>
                             <input type="date" x-model="kategoriBaru.penjualan_selesai"
                                 class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                         </div>
                         <div>
                             <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                             <textarea x-model="kategoriBaru.deskripsi" rows="3"
                                 class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                         </div>
                     </div>

                     <!-- Tombol -->
                     <div class="mt-6 flex justify-end gap-3">
                         <button type="button" @click="showModal = false"
                             class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                             Batal
                         </button>
                         <button type="button" @click="tambahKategori()"
                             class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                             <span x-text="editIndex !== null ? 'Simpan Perubahan' : 'Tambah Kategori'"></span>
                         </button>
                     </div>
                 </div>
             </div>
         </div>
         <!-- Pilihan Tiket Type -->

         <!-- Daftar Kategori Tiket Gratis -->
         <div class="w-full mt-6" x-show="adaGratis" x-transition>
             <div class="mb-4 flex items-center justify-between">
                 <div class="flex items-center gap-2">
                     <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                     </svg>
                     <h4 class="text-sm font-semibold text-gray-700 uppercase">Kategori Tiket Gratis
                     </h4>
                 </div>
                 <span class="text-xs text-gray-500" x-text="`${kategoriGratis.length} Kategori`"></span>
             </div>

             <div class="space-y-3">
                 <template x-for="(kategori, index) in kategoriGratis" :key="index">
                     <div
                         class="group relative bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-5 hover:shadow-lg transition-all duration-300 hover:border-green-400">
                         <!-- Ticket Icon -->
                         <div class="absolute top-4 left-4 opacity-10">
                             <svg class="w-16 h-16 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                 <path
                                     d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z" />
                             </svg>
                         </div>

                         <div class="relative flex items-start justify-between">
                             <div class="flex-1">
                                 <!-- Ticket Name (No Price) -->
                                 <div class="flex items-center gap-3 mb-3">
                                     <div class="bg-green-600 p-2 rounded-lg">
                                         <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                 d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                         </svg>
                                     </div>
                                     <div>
                                         <h4 class="text-lg font-bold text-gray-900" x-text="kategori.nama">
                                         </h4>
                                         <p class="text-sm font-bold text-green-600">Gratis</p>
                                     </div>
                                 </div>

                                 <!-- Details Grid -->
                                 <div class="grid grid-cols-2 gap-3 mb-3">
                                     <div class="bg-white/70 rounded-lg p-3">
                                         <p class="text-xs text-gray-500 mb-1">Kuota Tiket</p>
                                         <p class="text-sm font-semibold text-gray-900 flex items-center gap-1">
                                             <svg class="w-4 h-4 text-green-600" fill="currentColor"
                                                 viewBox="0 0 20 20">
                                                 <path
                                                     d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                             </svg>
                                             <span x-text="kategori.kuota + ' tiket'"></span>
                                         </p>
                                     </div>
                                     <div class="bg-white/70 rounded-lg p-3">
                                         <p class="text-xs text-gray-500 mb-1">Penjualan</p>
                                         <p class="text-xs font-medium text-gray-700">
                                             <span
                                                 x-text="new Date(kategori.penjualan_mulai).toLocaleDateString('id-ID', {day: '2-digit', month: 'short'})"></span>
                                             -
                                             <span
                                                 x-text="new Date(kategori.penjualan_selesai).toLocaleDateString('id-ID', {day: '2-digit', month: 'short'})"></span>
                                         </p>
                                     </div>
                                 </div>

                                 <!-- Description -->
                                 <div class="bg-white/70 rounded-lg p-3" x-show="kategori.deskripsi">
                                     <p class="text-xs text-gray-500 mb-1">Deskripsi</p>
                                     <p class="text-sm text-gray-700 line-clamp-2" x-text="kategori.deskripsi">
                                     </p>
                                 </div>
                             </div>

                             <!-- Action Buttons -->
                             <div class="flex flex-col gap-2 ml-4">
                                 <button type="button" @click="currentType = 'gratis'; editKategori(index)"
                                     class="flex items-center gap-1 px-3 py-2 bg-white border border-green-300 text-green-600 rounded-lg hover:bg-green-50 transition-colors text-sm font-medium shadow-sm">
                                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                             d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                     </svg>
                                     Edit
                                 </button>
                                 <button type="button" @click="kategoriGratis.splice(index, 1)"
                                     class="flex items-center gap-1 px-3 py-2 bg-white border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors text-sm font-medium shadow-sm">
                                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                             d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                     </svg>
                                     Hapus
                                 </button>
                             </div>
                         </div>

                         <!-- Hidden inputs -->
                         <template x-for="(value, key) in kategori" :key="key">
                             <input type="hidden" :name="`kategori_gratis[${index}][${key}]`"
                                 :value="value">
                         </template>
                     </div>
                 </template>
             </div>

             <!-- Empty State -->
             <div x-show="kategoriGratis.length === 0"
                 class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                 <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                 </svg>
                 <p class="text-gray-500 font-medium">Belum ada kategori tiket gratis</p>
                 <p class="text-sm text-gray-400 mt-1">Klik tombol "Tambah Kategori Tiket" untuk
                     memulai</p>
             </div>
         </div>

         <!-- Tombol Tambah Kategori Gratis -->
         <div class="w-full mt-2" x-show="adaGratis" x-transition>
             <button type="button" @click="openAddModal('gratis')"
                 class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                     <path fill-rule="evenodd"
                         d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                         clip-rule="evenodd" />
                 </svg>
                 Tambah Kategori Tiket Gratis
             </button>
         </div>

         <!-- Daftar Kategori Tiket Berbayar -->
         <div class="w-full mt-6" x-show="adaBerbayar" x-transition>
             <div class="mb-4 flex items-center justify-between">
                 <div class="flex items-center gap-2">
                     <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                     </svg>
                     <h4 class="text-sm font-semibold text-gray-700 uppercase">Kategori Tiket
                         Berbayar</h4>
                 </div>
                 <span class="text-xs text-gray-500" x-text="`${kategoriBerbayar.length} Kategori`"></span>
             </div>

             <div class="space-y-3">
                 <template x-for="(kategori, index) in kategoriBerbayar" :key="index">
                     <div
                         class="group relative bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-5 hover:shadow-lg transition-all duration-300 hover:border-blue-400">
                         <!-- Ticket Icon -->
                         <div class="absolute top-4 left-4 opacity-10">
                             <svg class="w-16 h-16 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                 <path
                                     d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z" />
                             </svg>
                         </div>

                         <div class="relative flex items-start justify-between">
                             <div class="flex-1">
                                 <!-- Ticket Name & Price -->
                                 <div class="flex items-center gap-3 mb-3">
                                     <div class="bg-blue-600 p-2 rounded-lg">
                                         <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                 d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                         </svg>
                                     </div>
                                     <div>
                                         <h4 class="text-lg font-bold text-gray-900" x-text="kategori.nama">
                                         </h4>
                                         <p class="text-2xl font-bold text-blue-600">
                                             Rp <span x-text="parseInt(kategori.harga).toLocaleString('id-ID')"></span>
                                         </p>
                                     </div>
                                 </div>

                                 <!-- Details Grid -->
                                 <div class="grid grid-cols-2 gap-3 mb-3">
                                     <div class="bg-white/70 rounded-lg p-3">
                                         <p class="text-xs text-gray-500 mb-1">Kuota Tiket</p>
                                         <p class="text-sm font-semibold text-gray-900 flex items-center gap-1">
                                             <svg class="w-4 h-4 text-blue-600" fill="currentColor"
                                                 viewBox="0 0 20 20">
                                                 <path
                                                     d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                             </svg>
                                             <span x-text="kategori.kuota + ' tiket'"></span>
                                         </p>
                                     </div>
                                     <div class="bg-white/70 rounded-lg p-3">
                                         <p class="text-xs text-gray-500 mb-1">Penjualan</p>
                                         <p class="text-xs font-medium text-gray-700">
                                             <span
                                                 x-text="new Date(kategori.penjualan_mulai).toLocaleDateString('id-ID', {day: '2-digit', month: 'short'})"></span>
                                             -
                                             <span
                                                 x-text="new Date(kategori.penjualan_selesai).toLocaleDateString('id-ID', {day: '2-digit', month: 'short'})"></span>
                                         </p>
                                     </div>
                                 </div>

                                 <!-- Description -->
                                 <div class="bg-white/70 rounded-lg p-3" x-show="kategori.deskripsi">
                                     <p class="text-xs text-gray-500 mb-1">Deskripsi</p>
                                     <p class="text-sm text-gray-700 line-clamp-2" x-text="kategori.deskripsi">
                                     </p>
                                 </div>
                             </div>

                             <!-- Action Buttons -->
                             <div class="flex flex-col gap-2 ml-4">
                                 <button type="button" @click="currentType = 'berbayar'; editKategori(index)"
                                     class="flex items-center gap-1 px-3 py-2 bg-white border border-blue-300 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors text-sm font-medium shadow-sm">
                                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                             d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                     </svg>
                                     Edit
                                 </button>
                                 <button type="button" @click="kategoriBerbayar.splice(index, 1)"
                                     class="flex items-center gap-1 px-3 py-2 bg-white border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors text-sm font-medium shadow-sm">
                                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                             d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                     </svg>
                                     Hapus
                                 </button>
                             </div>
                         </div>

                         <!-- Hidden inputs - dengan nama field kategori_tiket -->
                         <template x-for="(value, key) in kategori" :key="key">
                             <input type="hidden" :name="`kategori_tiket[${kategoriGratis.length + index}][${key}]`"
                                 :value="value">
                         </template>
                     </div>
                 </template>
             </div>

             <!-- Empty State -->
             <div x-show="kategoriBerbayar.length === 0"
                 class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                 <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                 </svg>
                 <p class="text-gray-500 font-medium">Belum ada kategori tiket berbayar</p>
                 <p class="text-sm text-gray-400 mt-1">Klik tombol "Tambah Kategori Tiket" untuk
                     memulai</p>
             </div>
         </div>

         <!-- Tombol Tambah Kategori Berbayar -->
         <div class="w-full mt-2" x-show="adaBerbayar" x-transition>
             <button type="button" @click="openAddModal('berbayar')"
                 class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                     <path fill-rule="evenodd"
                         d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                         clip-rule="evenodd" />
                 </svg>
                 Tambah Kategori Tiket Berbayar
             </button>
         </div>

         <!-- Modal Konfigurasi Kategori -->
         <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 " x-show="showModal"
             x-transition.opacity x-cloak @click.self="showModal = false">
             <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4">
                 <div class="flex justify-between items-center mb-4">
                     <h3 class="text-xl font-semibold text-gray-900"
                         x-text="editIndex !== null ? 'Edit Kategori Tiket' : 'Tambah Kategori Tiket'">
                     </h3>
                     <button type="button" @click="showModal = false" class="text-gray-400 hover:text-gray-500">
                         <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M6 18L18 6M6 6l12 12" />
                         </svg>
                     </button>
                 </div>

                 <!-- Form -->
                 <div class="space-y-4">
                     <div>
                         <label class="block text-sm font-medium text-gray-700 mb-1">Nama
                             Kategori</label>
                         <input type="text" x-model="kategoriBaru.nama"
                             class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                     </div>

                     <!-- Price Field - Only for Paid Tickets -->
                     <div x-show="currentType === 'berbayar'">
                         <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                         <div class="relative">
                             <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Rp</span>
                             <input type="text" x-model="kategoriBaru.harga"
                                 class="w-full rounded-lg border border-gray-300 pl-10 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                         </div>
                     </div>

                     <div>
                         <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah
                             Tiket</label>
                         <input type="number" x-model="kategoriBaru.kuota" min="1" max="999"
                             placeholder="Masukkan jumlah (1-999)"
                             class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                     </div>
                     <div>
                         <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                             Mulai Penjualan</label>
                         <input type="date" x-model="kategoriBaru.penjualan_mulai"
                             class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                     </div>
                     <div>
                         <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                             Selesai Penjualan</label>
                         <input type="date" x-model="kategoriBaru.penjualan_selesai"
                             class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                     </div>
                     <div>
                         <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                         <textarea x-model="kategoriBaru.deskripsi" rows="3"
                             class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                     </div>
                 </div>

                 <!-- Tombol -->
                 <div class="mt-6 flex justify-end gap-3">
                     <button type="button" @click="showModal = false"
                         class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                         Batal
                     </button>
                     <button type="button" @click="tambahKategori()"
                         class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                         <span x-text="editIndex !== null ? 'Simpan Perubahan' : 'Tambah Kategori'"></span>
                     </button>
                 </div>
             </div>
         </div>
     </div>
 </div>
