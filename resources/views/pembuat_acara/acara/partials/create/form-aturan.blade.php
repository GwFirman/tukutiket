<div class="mt-4 rounded-2xl border border-gray-200 bg-white">
    <div class="px-5 py-4 sm:px-6 sm:py-5">
        <h3 class="text-base font-medium text-gray-800">
            Tambah Aturan
        </h3>
    </div>
    <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6">
        <!-- Elements -->
        <div class="flex flex-col w-full justify-center gap-8">
            <div class="flex gap-4 items-center justify-between">
                <div class="">
                    <label for="">Maks Tiket per transaksi</label>
                    <p class="text-sm text-gray-400">Jumlah maksimal tiket yang dapat dibeli
                        dalam 1 transaksi</p>
                </div>
                <select name="maks_tiket_per_transaksi"
                    class="shadow-theme-xs w-24 focus:border-blue-300 focus:ring-blue-500/10 h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden">
                    <option value="5">5 tiket</option>
                    <option value="4">4 tiket</option>
                    <option value="3">3 tiket</option>
                    <option value="2">2 tiket</option>
                    <option value="1">1 tiket</option>
                </select>
            </div>
            <div class="flex items-center justify-between gap-4" x-data="{ switchToggle: false }">
                <div class="">
                    <label for="">1 Tiket per Akun</label>
                    <p class="text-sm text-gray-400">1 Akun hanya dapat membeli 1 tiket</p>
                </div>
                <div class="flex items-center">
                    <label for="switchToggle" class="flex cursor-pointer items-center">
                        <div class="relative">
                            <input type="checkbox" id="switchToggle" class="sr-only" name="satu_tiket_per_akun"
                                @change="switchToggle = !switchToggle" />
                            <div :class="switchToggle ? 'bg-blue-500' : 'bg-gray-300'"
                                class="block h-6 w-11 rounded-full transition-colors duration-200 ease-in-out">
                            </div>
                            <div :class="switchToggle ? 'translate-x-5' : 'translate-x-0'"
                                class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition-transform duration-200 ease-in-out">
                            </div>
                        </div>
                    </label>
                    <input type="hidden" name="maks_pembelian_per_akun" :value="switchToggle ? 1 : 0" />
                </div>
            </div>

        </div>
    </div>
</div>
