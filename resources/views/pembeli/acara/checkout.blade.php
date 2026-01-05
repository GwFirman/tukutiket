<x-guest-layout>
    <form action="{{ route('pembeli.checkout.store') }}" method="POST">
        @csrf
        <!-- Hidden input untuk acara_id -->
        <input type="hidden" name="acara_id" value="{{ $acara->id }}">

        <div class="max-w-7xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-r-lg p-4 md:max-w-7xl mx-auto">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-0.5">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-red-800 mb-2">
                                Terdapat beberapa kesalahan, silakan perbaiki:
                            </h3>
                            <ul class="space-y-1 text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-start gap-2">
                                        <span
                                            class="inline-block w-1.5 h-1.5 bg-red-500 rounded-full mt-1.5 flex-shrink-0"></span>
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            <div class="md:flex gap-2">
                <div class="bg-white  sm:rounded-lg col-span-8 flex-1">
                    @include('pembeli.acara.partials.chekcout.detail-acara')

                    <div class="border-t border-gray-200 my-4"></div>
                    @include('pembeli.acara.partials.chekcout.tiket-acara')

                </div>

                {{-- sidebar --}}
                <div class="bg-white overflow-hidden  sm:rounded-lg col-span-4 p-6">
                    <!-- Header dengan counter tiket -->
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-gray-800 font-medium">Informasi Pemesan</p>
                        <span id="ticket_count"
                            class="text-xs px-2 py-1 rounded-full bg-indigo-100 text-indigo-600">0/{{ $maksTiket ?? ($acara->maks_tiket_per_transaksi ?? 5) }}
                            tiket</span>
                    </div>
                    <div class="border-t border-gray-200 mb-4"></div>


                    <!-- Info pemesan -->
                    @include('pembeli.acara.partials.chekcout.info-pemesan')

                    <!-- Data Peserta Dinamis -->
                    @include('pembeli.acara.partials.chekcout.data-peserta')


                    <!-- Detail Pesanan -->
                    <p class="text-gray-800 font-medium mt-6">Detail Pesanan</p>
                    <div class="border-t border-gray-200 my-4"></div>

                    <!-- Detail Pesanan Container -->
                    @include('pembeli.acara.partials.chekcout.detail-pesanan')


                    <!-- Metode Pembayaran -->
                    @include('pembeli.acara.partials.chekcout.metode-bayar')

                    <button type="submit"
                        class="mt-4 w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white block text-center font-medium py-3 px-4 rounded-xl transition duration-300 shadow-lg shadow-indigo-500/25">
                        <i data-lucide="shopping-bag" class="size-4 inline mr-2"></i>
                        Checkout Sekarang
                    </button>
                </div>
            </div>
        </div>

    </form>
    <!-- filepath: d:\Kulyeah\magang\Project\tukutiket\resources\views\pembeli\acara\checkout.blade.php -->
</x-guest-layout>
