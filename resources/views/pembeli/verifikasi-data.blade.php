<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i data-lucide="shield-check" class="size-6 text-indigo-600"></i>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Verifikasi Identitas Kreator') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-8 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i data-lucide="check-circle" class="h-5 w-5 text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 font-medium">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Error Message --}}
            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i data-lucide="alert-circle" class="h-5 w-5 text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 font-medium">
                                {{ session('error') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Info Banner --}}
            <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4 mb-8 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i data-lucide="lock" class="h-5 w-5 text-indigo-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-indigo-700">
                            Data Anda dilindungi enkripsi. Dokumen hanya digunakan untuk proses verifikasi dan tidak
                            akan disebarluaskan.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Check if already submitted --}}
            @if (isset($verifikasi) && $verifikasi)
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                    <div class="p-8">
                        <div class="text-center">
                            @if ($verifikasi->status == 'pending')
                                <div
                                    class="w-20 h-20 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="clock" class="size-10"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Verifikasi Sedang Diproses</h3>
                                <p class="text-gray-600">Dokumen Anda sedang dalam proses review oleh admin. Mohon
                                    tunggu 1-3 hari kerja.</p>
                            @elseif ($verifikasi->status == 'approved')
                                <div
                                    class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="check-circle" class="size-10"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Verifikasi Berhasil</h3>
                                <p class="text-gray-600">Akun kreator Anda sudah terverifikasi.</p>
                            @elseif ($verifikasi->status == 'rejected')
                                <div
                                    class="w-20 h-20 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="x-circle" class="size-10"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Verifikasi Ditolak</h3>
                                <p class="text-gray-600 mb-4">
                                    {{ $verifikasi->catatan_admin ?? 'Silakan upload ulang dokumen yang valid.' }}</p>
                                <a href="{{ route('pembuat.verifikasi-data.create') }}"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
                                    <i data-lucide="refresh-cw" class="size-5"></i>
                                    Upload Ulang
                                </a>
                            @endif
                        </div>

                        {{-- Preview dokumen yang sudah diupload --}}
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <h4 class="text-sm font-bold text-gray-700 mb-4">Dokumen yang Diupload:</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <p class="text-xs text-gray-500 mb-2">Foto KTP</p>
                                    <img src="{{ asset('storage/' . $verifikasi->foto_ktp) }}" alt="KTP"
                                        class="w-full h-40 object-contain rounded-lg bg-white">
                                </div>
                                @if ($verifikasi->foto_npwp)
                                    <div class="bg-gray-50 rounded-xl p-4">
                                        <p class="text-xs text-gray-500 mb-2">Foto NPWP</p>
                                        <img src="{{ asset('storage/' . $verifikasi->foto_npwp) }}" alt="NPWP"
                                            class="w-full h-40 object-contain rounded-lg bg-white">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Form Upload --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-8 py-6">
                        <h3 class="text-lg font-bold text-white">Upload Dokumen Verifikasi</h3>
                        <p class="text-indigo-100 text-sm mt-1">Lengkapi dokumen berikut untuk verifikasi akun kreator
                            Anda</p>
                    </div>

                    <div class="p-8">
                        <form method="POST" action="{{ route('pembuat.verifikasi-data.store') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                                {{-- Upload KTP --}}
                                <div x-data="imageUploader()">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        <span class="flex items-center gap-2">
                                            <i data-lucide="credit-card" class="size-4 text-indigo-600"></i>
                                            Foto KTP <span class="text-red-500">*</span>
                                        </span>
                                    </label>

                                    <input type="file" name="foto_ktp" accept="image/png, image/jpeg, image/jpg"
                                        class="hidden" x-ref="fileInput" @change="fileChosen" required>

                                    <div class="relative w-full h-64 rounded-xl border-2 border-dashed transition-all duration-300 group cursor-pointer"
                                        :class="imageUrl ? 'border-indigo-500 bg-indigo-50' :
                                            'border-gray-300 hover:border-indigo-400 hover:bg-gray-50'"
                                        @click="$refs.fileInput.click()">

                                        <div x-show="!imageUrl"
                                            class="absolute inset-0 flex flex-col items-center justify-center text-center p-6">
                                            <div
                                                class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                                <i data-lucide="credit-card" class="size-8"></i>
                                            </div>
                                            <p class="text-sm font-medium text-gray-900">Klik untuk upload KTP</p>
                                            <p class="text-xs text-gray-500 mt-1">PNG, JPG atau JPEG (Max. 2MB)</p>
                                        </div>

                                        <div x-show="imageUrl" class="absolute inset-0 p-2" style="display: none;">
                                            <img :src="imageUrl"
                                                class="w-full h-full object-contain rounded-lg shadow-sm bg-white">
                                            <button type="button" @click.stop="removeImage"
                                                class="absolute top-4 right-4 bg-red-500 text-white p-2 rounded-full hover:bg-red-600 shadow-md transition-colors">
                                                <i data-lucide="trash-2" class="size-4"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('foto_ktp')
                                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                            <i data-lucide="alert-circle" class="size-3"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Upload NPWP --}}
                                <div x-data="imageUploader()">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        <span class="flex items-center gap-2">
                                            <i data-lucide="file-text" class="size-4 text-purple-600"></i>
                                            Foto NPWP <span class="text-gray-400 font-normal">(Opsional)</span>
                                        </span>
                                    </label>

                                    <input type="file" name="foto_npwp" accept="image/png, image/jpeg, image/jpg"
                                        class="hidden" x-ref="fileInput" @change="fileChosen">

                                    <div class="relative w-full h-64 rounded-xl border-2 border-dashed transition-all duration-300 group cursor-pointer"
                                        :class="imageUrl ? 'border-purple-500 bg-purple-50' :
                                            'border-gray-300 hover:border-purple-400 hover:bg-gray-50'"
                                        @click="$refs.fileInput.click()">

                                        <div x-show="!imageUrl"
                                            class="absolute inset-0 flex flex-col items-center justify-center text-center p-6">
                                            <div
                                                class="w-16 h-16 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                                <i data-lucide="file-text" class="size-8"></i>
                                            </div>
                                            <p class="text-sm font-medium text-gray-900">Klik untuk upload NPWP</p>
                                            <p class="text-xs text-gray-500 mt-1">PNG, JPG atau JPEG (Max. 2MB)</p>
                                        </div>

                                        <div x-show="imageUrl" class="absolute inset-0 p-2" style="display: none;">
                                            <img :src="imageUrl"
                                                class="w-full h-full object-contain rounded-lg shadow-sm bg-white">
                                            <button type="button" @click.stop="removeImage"
                                                class="absolute top-4 right-4 bg-red-500 text-white p-2 rounded-full hover:bg-red-600 shadow-md transition-colors">
                                                <i data-lucide="trash-2" class="size-4"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('foto_npwp')
                                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                            <i data-lucide="alert-circle" class="size-3"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                            </div>

                            {{-- Submit Buttons --}}
                            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                                <a href="{{ route('pembuat.dashboard') }}"
                                    class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl transition-all duration-200 font-medium flex items-center gap-2">
                                    <i data-lucide="upload-cloud" class="size-5"></i>
                                    Kirim Dokumen
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function imageUploader() {
            return {
                imageUrl: null,

                fileChosen(event) {
                    this.fileToDataUrl(event, src => this.imageUrl = src)
                },

                fileToDataUrl(event, callback) {
                    if (!event.target.files.length) return

                    let file = event.target.files[0],
                        reader = new FileReader()

                    reader.readAsDataURL(file)
                    reader.onload = e => callback(e.target.result)
                },

                removeImage() {
                    this.imageUrl = null;
                    this.$refs.fileInput.value = '';
                }
            }
        }
    </script>
</x-app-layout>
