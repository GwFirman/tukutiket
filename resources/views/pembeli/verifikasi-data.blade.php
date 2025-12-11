<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i data-lucide="shield-check" class="size-6 text-blue-600"></i>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Verifikasi Identitas') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i data-lucide="lock" class="h-5 w-5 text-blue-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Data Anda dilindungi enkripsi. Dokumen hanya digunakan untuk proses verifikasi dan tidak
                            akan disebarluaskan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8">

                    <form method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            <div x-data="imageUploader()">
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Foto KTP <span class="text-red-500">*</span>
                                </label>

                                <input type="file" name="ktp_image" accept="image/png, image/jpeg, image/jpg"
                                    class="hidden" x-ref="fileInput" @change="fileChosen">

                                <div class="relative w-full h-64 rounded-xl border-2 border-dashed transition-all duration-300 group"
                                    :class="imageUrl ? 'border-blue-500 bg-blue-50' :
                                        'border-gray-300 hover:border-blue-400 hover:bg-gray-50'"
                                    @click="$refs.fileInput.click()">

                                    <div x-show="!imageUrl"
                                        class="absolute inset-0 flex flex-col items-center justify-center text-center p-6">
                                        <div
                                            class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
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
                                @error('ktp_image')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div x-data="imageUploader()">
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Foto NPWP <span class="text-gray-400 font-normal">(Opsional)</span>
                                </label>

                                <input type="file" name="npwp_image" accept="image/png, image/jpeg, image/jpg"
                                    class="hidden" x-ref="fileInput" @change="fileChosen">

                                <div class="relative w-full h-64 rounded-xl border-2 border-dashed transition-all duration-300 group"
                                    :class="imageUrl ? 'border-blue-500 bg-blue-50' :
                                        'border-gray-300 hover:border-blue-400 hover:bg-gray-50'"
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
                                @error('npwp_image')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                            <a href="{{ url()->previous() }}"
                                class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-lg hover:shadow-xl transition-all duration-200 font-medium flex items-center gap-2">
                                <i data-lucide="upload-cloud" class="size-5"></i>
                                Kirim Dokumen
                            </button>
                        </div>

                    </form>
                </div>
            </div>
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
                    // Reset input file agar bisa upload file yg sama jika user berubah pikiran
                    this.$refs.fileInput.value = '';
                }
            }
        }
    </script>
</x-app-layout>
