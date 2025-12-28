<x-app-layout>
    <form action="{{ route('pembeli.checkout.store') }}" method="POST">
        @csrf
        <!-- Hidden input untuk acara_id -->
        <input type="hidden" name="acara_id" value="{{ $acara->id }}">

        <div class="px-6 pb-6 sm:px-6 lg:px-24 py-0 md:py-12 ">
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
</x-app-layout>
