<div>

    <div>
        <label for="nama_acara" class="block text-sm font-medium text-gray-700">Nama Acara</label>
        <input type="text" name="nama_acara" id="nama_acara" required
            class="mt-1 h-10 block w-full border-b-2 outline-0 border-gray-100 text-xl focus:border-sky-500">
    </div>
    <div class="flex gap-5 mt-5">
        <div class="w-full" x-data="{
            showModal: false,
            startDate: '',
            endDate: '',
            get label() {
                if (this.startDate && this.endDate) {
                    return `${this.formatDate(this.startDate)} - ${this.formatDate(this.endDate)}`;
                }
                return 'Pilih tanggal acara';
            },
            formatDate(dateStr) {
                const options = { day: '2-digit', month: 'long', year: 'numeric' };
                const date = new Date(dateStr);
                return date.toLocaleDateString('id-ID', options);
            }
        }">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 ">
                Tanggal Acara
            </label>
            <div class="flex items-center justify-between  h-11 px-4 rounded-lg cursor-pointer border border-gray-300"
                @click="showModal = true">
                <label class="block text-md text-gray-700  mr-2" x-text="label"></label>
                <span class="-1/2 text-blue-500 ">
                    <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M6.66659 1.5415C7.0808 1.5415 7.41658 1.87729 7.41658 2.2915V2.99984H12.5833V2.2915C12.5833 1.87729 12.919 1.5415 13.3333 1.5415C13.7475 1.5415 14.0833 1.87729 14.0833 2.2915V2.99984L15.4166 2.99984C16.5212 2.99984 17.4166 3.89527 17.4166 4.99984V7.49984V15.8332C17.4166 16.9377 16.5212 17.8332 15.4166 17.8332H4.58325C3.47868 17.8332 2.58325 16.9377 2.58325 15.8332V7.49984V4.99984C2.58325 3.89527 3.47868 2.99984 4.58325 2.99984L5.91659 2.99984V2.2915C5.91659 1.87729 6.25237 1.5415 6.66659 1.5415ZM6.66659 4.49984H4.58325C4.30711 4.49984 4.08325 4.7237 4.08325 4.99984V6.74984H15.9166V4.99984C15.9166 4.7237 15.6927 4.49984 15.4166 4.49984H13.3333H6.66659ZM15.9166 8.24984H4.08325V15.8332C4.08325 16.1093 4.30711 16.3332 4.58325 16.3332H15.4166C15.6927 16.3332 15.9166 16.1093 15.9166 15.8332V8.24984Z"
                            fill="" />
                    </svg>
                </span>
            </div>
            <!-- Modal -->
            <div x-show="showModal" x-cloak>
                <!-- Overlay -->
                <div class="fixed inset-0 z-40 bg-black/80"></div>
                <!-- Modal -->
                <div class="fixed inset-0 z-50 flex items-center justify-center">
                    <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 ">Pilih
                            Tanggal
                            Acara
                        </h3>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700  mb-1">Tanggal
                                Mulai</label>
                            <div class="relative">
                                <input type="date" x-model="startDate" placeholder="Select date" name="waktu_mulai"
                                    class="
                                                         shadow-theme-xs focus:border-blue-300 focus:ring-blue-500/10 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5  pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden " />
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700  mb-1">Tanggal
                                Akhir</label>
                            <div class="relative">
                                <input type="date" x-model="endDate" placeholder="Select date" name="waktu_selesai"
                                    class="
                                                         shadow-theme-xs focus:border-blue-300 focus:ring-blue-500/10 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5  pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden " />
                            </div>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" class="px-4 py-2 rounded bg-gray-200 text-gray-700 "
                                @click="showModal = false">Batal</button>
                            <button type="button" class="px-4 py-2 rounded bg-blue-500 text-white"
                                @click="showModal = false">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 ">
                Lokasi
            </label>
            <input type="text" name="lokasi" id="lokasi" name="lokasi"
                class=" shadow-theme-xs font-normal focus:border-blue-300 focus:ring-blue-500/10 h-11 w-full  border border-gray-300 rounded-lg bg-transparent px-4 py-2.5 text-lg text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden ">
        </div>
    </div>

    <div class="mt-4">
        <label for="deskripsi_acara" class="block text-sm font-medium text-gray-700">Deskripsi</label>
        <div>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />
            <input id="deskripsi_acara" name="deskripsi_acara" type="hidden">
            <trix-editor input ="deskripsi_acara"></trix-editor>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
        </div>
    </div>
</div>
