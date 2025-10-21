<x-app-layout>
    <div class="py-12 px-12">
        <div class="grid grid-cols-12 gap-2">
            <div class="bg-white shadow-sm sm:rounded-lg col-span-8 p-4">
                <div
                    class="h-64 w-full border-2 border-gray-200 border-dashed rounded-lg flex items-center justify-center overflow-hidden bg-gray-50">
                    @if ($acara->banner_acara)
                        <img src="{{ asset('storage/' . $acara->banner_acara) }}" alt="Banner Acara"
                            class="h-full w-full object-cover rounded-lg">
                    @else
                        <span class="text-gray-400 text-sm">Belum ada banner acara</span>
                    @endif
                </div>

                <div class=" text-gray-900 mt-4 text-2xl">
                    {{ $acara->nama_acara }}
                </div>

                 <div class="text-gray-600 mt-2">
                    {{ $acara->deskripsi }}
                </div>
                <div class="border-t border-gray-200 my-4"></div>
                <div class=" text-gray-400 mt-4 font-medium text-lg">
                    <i data-lucide="ticket" class="inline"></i> Informasi tiket
                </div>
                <div class="grid grid-cols-1 gap-4 mt-2">
                    @foreach ($acara->jenisTiket as $tiket)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer transition"
                            onclick="toggleTicketDetails('ticket-{{ $tiket->id }}')">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="font-semibold text-lg">{{ $tiket->nama_jenis }}</h3>
                                    <p class="text-gray-500">Rp {{ number_format($tiket->harga, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 chevron-icon" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>

                            <div id="ticket-{{ $tiket->id }}" class="hidden mt-4 pt-4 border-t border-gray-200">
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div>
                                        <p class="text-gray-600">Tanggal Mulai:</p>
                                        <p>{{ \Carbon\Carbon::parse($tiket->penjualan_mulai)->format('d-m-Y') }}
                                            <span
                                                class="text-gray-500">{{ \Carbon\Carbon::parse($tiket->penjualan_mulai)->format('H:i') }}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Tanggal Selesai:</p>
                                        <p>{{ \Carbon\Carbon::parse($tiket->penjualan_selesai)->format('d-m-Y') }}
                                            <span
                                                class="text-gray-500">{{ \Carbon\Carbon::parse($tiket->penjualan_selesai)->format('H:i') }}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Jumlah Tiket:</p>
                                        <p>{{ $tiket->jumlah_tiket }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Status:</p>
                                        <p>{{ $tiket->status }}</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-gray-600">Deskripsi:</p>
                                    <p>{{ $tiket->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('pembuat.acara.edit', $tiket->id) }}"
                                        class="text-blue-500 hover:underline">Edit Tiket</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <script>
                    function toggleTicketDetails(ticketId) {
                        const element = document.getElementById(ticketId);
                        const chevronIcon = event.currentTarget.querySelector('.chevron-icon');

                        if (element.classList.contains('hidden')) {
                            element.classList.remove('hidden');
                            chevronIcon.innerHTML =
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />';
                        } else {
                            element.classList.add('hidden');
                            chevronIcon.innerHTML =
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />';
                        }
                    }
                </script>

            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg col-span-4 p-6">

                <p class="text-gray-800 font-medium">Waktu Pelaksanaan</p>
                <div class="flex gap-2 mt-2">
                    <div class="bg-gray-100 rounded-md border border-gray-400 p-2">
                        <p>{{ \Carbon\Carbon::parse($acara->penjualan_mulai)->format('d-m-Y') }} <span
                                class="text-gray-500">{{ \Carbon\Carbon::parse($acara->waktu_mulai)->format('H:i') }}</span>
                        </p>
                    </div>
                    <div class="bg-gray-100 rounded-md border border-gray-400 p-2">
                        <p>{{ \Carbon\Carbon::parse($acara->penjualan_selesai)->format('d-m-Y') }} <span
                                class="text-gray-500">{{ \Carbon\Carbon::parse($acara->waktu_selesai)->format('H:i') }}</span>
                        </p>
                    </div>
                </div>
                <div class="border-t border-gray-200 my-4"></div>
                <p class="text-gray-800 font-medium"> lokasi</p>
                <div class="text-gray-600 mt-2">
                    {{ $acara->lokasi }}
                </div>
                <div class="border-t border-gray-200 my-4"></div>
                <p class="text-gray-800 font-medium">Informasi Kontak</p>
                <div class="text-gray-600 mt-2">
                    {{ $acara->info_kontak }}
                </div>
                <div class="border-t border-gray-200 my-4"></div>
                <a href="{{ route('pembeli.checkout.show', $acara->slug ?? 1) }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded transition duration-300">
                    Beli Tiket
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
