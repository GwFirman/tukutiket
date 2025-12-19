<div>
    <form method="POST" action="{{ route('pembuat.acara.store') }}" enctype="multipart/form-data" class="">
        @csrf
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-9v4a1 1 0 11-2 0v-4a1 1 0 112 0zm-1-5a1 1 0 00-1 1v.01a1 1 0 102 0V5a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">
                            Terdapat beberapa masalah dengan inputan Anda:
                        </p>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        {{-- Image --}}
        <livewire:pembuat.form.form-image />
        <livewire:pembuat.form.detail-acara />

        <div class="w-full mt-4">
            <label class="mb-1.5 block text-sm font-medium text-gray-700">
                No Telp Narahubung
            </label>
            <input type="text" name="no_telp_narahubung" id="no_telp_narahubung"
                class="shadow-theme-xs font-normal focus:border-blue-300 focus:ring-blue-500/10 h-11 w-full border border-gray-300 rounded-lg bg-transparent px-4 py-2.5 text-lg text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden">
        </div>
        {{-- TIket --}}
        <livewire:pembuat.form.detail-tiket />

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
        <div class="flex justify-between mt-4">
            <div class="flex gap-3 justify-end w-full">
                <button type="submit" name="status" value="draft"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                    Simpan Draft
                </button>
                <button type="submit" name="status" value="publish"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    Publish
                </button>
            </div>
        </div>
</div>
</form>
</div>
