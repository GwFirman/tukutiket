<div class="mt-4 rounded-2xl border border-gray-200 bg-white">
    <div class="px-5 py-4 sm:px-6 sm:py-5">
        <div class="mb-2">
            <div class="flex items-center gap-2 mb-2">
                <i data-lucide="shield-alert" class="size-5 text-indigo-600"></i>
                <h3 class="text-lg font-semibold text-gray-900">Aturan pembelian tiket</h3>
            </div>
        </div>
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
                    @php($maksOld = old('maks_tiket_per_transaksi', isset($acara) ? $acara->maks_tiket_per_transaksi : 5))
                    <option value="5" {{ (string) $maksOld === '5' ? 'selected' : '' }}>5 tiket</option>
                    <option value="4" {{ (string) $maksOld === '4' ? 'selected' : '' }}>4 tiket</option>
                    <option value="3" {{ (string) $maksOld === '3' ? 'selected' : '' }}>3 tiket</option>
                    <option value="2" {{ (string) $maksOld === '2' ? 'selected' : '' }}>2 tiket</option>
                    <option value="1" {{ (string) $maksOld === '1' ? 'selected' : '' }}>1 tiket</option>
                </select>
            </div>
            <div class="flex items-center justify-between gap-4" x-data="{ switchToggle: @json((bool) old('satu_transaksi_per_akun', isset($acara) ? $acara->satu_transaksi_per_akun : false)) }">
                <div class="">
                    <label for="">1 Tiket per Akun</label>
                    <p class="text-sm text-gray-400">1 Akun hanya dapat membeli 1 tiket</p>
                </div>
                <div class="flex items-center">
                    <label for="switchToggle" class="flex cursor-pointer items-center">
                        <div class="relative">
                            <!-- selalu kirim 0 saat tidak dicentang -->
                            <input type="hidden" name="satu_transaksi_per_akun" value="0" />
                            <input type="checkbox" id="switchToggle" class="sr-only" name="satu_transaksi_per_akun"
                                value="1" x-model="switchToggle" />
                            <div :class="switchToggle ? 'bg-blue-500' : 'bg-gray-300'"
                                class="block h-6 w-11 rounded-full transition-colors duration-200 ease-in-out"></div>
                            <div :class="switchToggle ? 'translate-x-5' : 'translate-x-0'"
                                class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition-transform duration-200 ease-in-out">
                            </div>
                        </div>
                    </label>
                </div>
            </div>

        </div>
    </div>
</div>
