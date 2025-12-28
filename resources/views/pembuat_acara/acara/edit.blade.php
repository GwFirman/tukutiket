<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 mx-auto max-w-4xl">
            <i data-lucide="calendar" class="size-5 text-gray-600"></i>
            <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
            <p class="font-medium">Edit Acara</p>
        </div>
    </x-slot>

    <div class="mb-6 lg:mt-6 px-6 lg:p-0">

        <div class="mx-auto max-w-4xl">
            @if ($acara->status == 'published')
                <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4   rounded-r" role="alert">
                    <div class="flex items-center">
                        <div class="py-1">
                            {{-- Opsi: Tambahkan ikon agar lebih informatif --}}
                            <svg class="fill-current h-6 w-6 text-orange-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path
                                    d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">Status: Published</p>
                            <p class="text-sm">Acara ini sudah dipublikasikan. Anda hanya dapat mengubah beberapa.</p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="mt-4">
                <form method="POST" action="{{ route('pembuat.acara.update', $acara->id) }}"
                    enctype="multipart/form-data" class="">
                    @csrf
                    @method('PUT')
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
                    <div class="border border-gray-300 rounded-lg">

                        @include('pembuat_acara.acara.partials.create.form-banner')

                        @include('pembuat_acara.acara.partials.create.form-acara')

                        @include('pembuat_acara.acara.partials.create.profile-kreator')

                        <div class="lg:flex gap-5 mt-5 px-5 pb-5 space-y-4">

                            @include('pembuat_acara.acara.partials.create.form-jam')

                            @include('pembuat_acara.acara.partials.create.form-tanggal')

                            @include('pembuat_acara.acara.partials.create.form-lokasi')

                        </div>
                    </div>


                    <div class="mt-6">
                        <div class="border-b border-gray-200">
                            <div class="flex gap-4" role="tablist">
                                <button type="button" data-tab="detail-acara"
                                    class="tab-button active px-4 py-2 border-b-2 border-green-600 text-green-600 font-medium transition"
                                    role="tab" aria-selected="true">
                                    Detail Acara
                                </button>
                                <button type="button" data-tab="konfigurasi-tiket"
                                    class="tab-button px-4 py-2 border-b-2 border-transparent text-gray-600 hover:text-gray-800 transition"
                                    role="tab" aria-selected="false">
                                    Konfigurasi Tiket
                                </button>
                            </div>
                        </div>

                        <div id="detail-acara" class="tab-content mt-6">
                            @include('pembuat_acara.acara.partials.create.form-kategori')
                            @include('pembuat_acara.acara.partials.create.form-deskripsi')
                            @include('pembuat_acara.acara.partials.create.form-kontak')
                        </div>

                        <div id="konfigurasi-tiket" class="tab-content mt-6 hidden">
                            @include('pembuat_acara.acara.partials.create.form-tiket')
                            @include('pembuat_acara.acara.partials.create.form-aturan')
                        </div>
                    </div>

                    <script>
                        document.querySelectorAll('.tab-button').forEach(button => {
                            button.addEventListener('click', () => {
                                const tabName = button.getAttribute('data-tab');
                                document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
                                document.querySelectorAll('.tab-button').forEach(btn => {
                                    btn.classList.remove('border-green-600', 'text-green-600');
                                    btn.classList.add('border-transparent', 'text-gray-600');
                                });
                                document.getElementById(tabName).classList.remove('hidden');
                                button.classList.add('border-green-600', 'text-green-600');
                                button.classList.remove('border-transparent', 'text-gray-600');
                            });
                        });
                    </script>
                    <div class="flex justify-between mt-4 px-5">
                        <div class="flex gap-3 justify-end w-full">
                            @if ($acara->status !== 'published')
                                <button type="submit" name="status" value="draft"
                                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                                    Simpan Draft
                                </button>
                                <button type="submit" name="status" value="published"
                                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                    Edit
                                </button>
                            @else
                                <button type="submit" name="status" value="published"
                                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition w-64">
                                    Edit
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
</x-app-layout>
