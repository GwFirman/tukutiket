<x-app-layout>
    <form action="{{ route('pembeli.checkout.store') }}" method="POST">
        @csrf
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
                    <div class="border-t border-gray-200 my-4"></div>
                    <div class=" text-gray-400 mt-4 font-medium text-lg">
                        <i data-lucide="ticket" class="inline"></i> Informasi tiket
                    </div>
                    <div class="grid grid-cols-1 gap-4 mt-6">
                        @foreach ($acara->jenisTiket as $tiket)
                            <div class="ticket-container mb-4">
                                <div
                                    class="border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all">
                                    <!-- Ticket Header -->
                                    <div class="bg-gradient-to-r from-indigo-50 to-gray-50 p-4 relative">
                                        <!-- Ticket stub design -->
                                        <div
                                            class="absolute top-0 left-0 h-full w-3 bg-indigo-500 flex items-center justify-center">
                                            <div class="h-12 w-3 bg-white opacity-50 rounded-full"></div>
                                        </div>

                                        <div class="flex justify-between items-center ml-5">
                                            <div>
                                                <div class="flex items-center">
                                                    <i data-lucide="ticket" class="h-5 w-5 text-indigo-500 mr-2"></i>
                                                    <h3 class="font-semibold text-lg text-gray-800">
                                                        {{ $tiket->nama_jenis }}
                                                    </h3>
                                                </div>
                                                <p class="flex text-gray-500 text-sm items-center mr-4">
                                                    Penjualan berakhir
                                                    {{ \Carbon\Carbon::parse($tiket->penjualan_selesai)->translatedFormat('d F Y') }}
                                                </p>
                                                <p class="text-indigo-600 font-bold">
                                                    Rp {{ number_format($tiket->harga, 0, ',', '.') }}
                                                </p>

                                                <!-- Tombol lihat detail -->
                                                <button type="button"
                                                    onclick="toggleTicketDetails('ticket-{{ $tiket->id }}')"
                                                    class="mt-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                                                    Lihat Detail
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div>
                                                <div x-data="ticketCounter({{ $tiket->id }}, '{{ $tiket->nama_jenis }}', {{ $tiket->harga }})"
                                                    class="flex items-center gap-3 bg-gray-100 rounded-full px-3 py-2 w-fit">
                                                    <!-- Tombol Minus -->
                                                    <button type="button" @click="decrementTicket()"
                                                        class="p-1 text-center bg-indigo-500 text-white rounded-full hover:bg-indigo-600 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
                                                        :disabled="count === 0">
                                                        <i data-lucide="minus" class="size-5"></i>
                                                    </button>

                                                    <!-- Nilai Jumlah -->
                                                    <span class="w-8 text-center font-semibold text-gray-700"
                                                        x-text="count"></span>

                                                    <!-- Tombol Plus -->
                                                    <button type="button" @click="incrementTicket()"
                                                        class="p-1 text-center bg-indigo-500 text-white rounded-full hover:bg-indigo-600 transition-colors">
                                                        <i data-lucide="plus" class="size-5"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Ticket Details (Hidden by default) -->
                                    <div id="ticket-{{ $tiket->id }}" class="hidden">
                                        <div class="border-t border-dashed border-gray-300 relative">
                                            <div
                                                class="absolute left-0 top-0 w-3 h-3 bg-white rounded-full -mt-1.5 -ml-1.5">
                                            </div>
                                            <div
                                                class="absolute right-0 top-0 w-3 h-3 bg-white rounded-full -mt-1.5 -mr-1.5">
                                            </div>
                                        </div>

                                        <div class="p-4 bg-white">
                                            <div class="grid grid-cols-2 gap-4 text-sm">
                                                <div class="p-2 bg-gray-50 rounded">
                                                    <p class="text-gray-500 text-xs">Penjualan Mulai</p>
                                                    <p class="font-medium flex items-center">
                                                        <i data-lucide="calendar"
                                                            class="h-3 w-3 mr-1 text-indigo-400"></i>
                                                        {{ \Carbon\Carbon::parse($tiket->penjualan_mulai)->format('d-m-Y') }}
                                                    </p>
                                                    <p class="text-gray-500 text-xs flex items-center">
                                                        <i data-lucide="clock" class="h-3 w-3 mr-1"></i>
                                                        {{ \Carbon\Carbon::parse($tiket->penjualan_mulai)->format('H:i') }}
                                                    </p>
                                                </div>

                                                <div class="p-2 bg-gray-50 rounded">
                                                    <p class="text-gray-500 text-xs">Penjualan Selesai</p>
                                                    <p class="font-medium flex items-center">
                                                        <i data-lucide="calendar"
                                                            class="h-3 w-3 mr-1 text-indigo-400"></i>
                                                        {{ \Carbon\Carbon::parse($tiket->penjualan_selesai)->format('d-m-Y') }}
                                                    </p>
                                                    <p class="text-gray-500 text-xs flex items-center">
                                                        <i data-lucide="clock" class="h-3 w-3 mr-1"></i>
                                                        {{ \Carbon\Carbon::parse($tiket->penjualan_selesai)->format('H:i') }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="mt-4 p-2 bg-gray-50 rounded">
                                                <p class="text-gray-500 text-xs mb-1">Deskripsi Tiket</p>
                                                <p class="text-sm">{{ $tiket->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                                            </div>

                                        </div>
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

                    <!-- Tempat menyimpan input tersembunyi -->
                    <div id="hiddenInputsContainer"></div>

                    <script>
                        const cart = {};

                        function ticketCounter(ticketId, ticketName, ticketPrice) {
                            return {
                                count: 0,
                                ticketId: ticketId,
                                ticketName: ticketName,
                                ticketPrice: ticketPrice,

                                incrementTicket() {
                                    this.count++;
                                    this.updateCart();
                                },

                                decrementTicket() {
                                    if (this.count > 0) {
                                        this.count--;
                                        this.updateCart();
                                    }
                                },

                                updateCart() {
                                    if (this.count > 0) {
                                        cart[this.ticketId] = {
                                            name: this.ticketName,
                                            price: this.ticketPrice,
                                            quantity: this.count,
                                            total: this.ticketPrice * this.count
                                        };
                                    } else {
                                        delete cart[this.ticketId];
                                    }
                                    this.renderCart();
                                    this.updateHiddenInputs();
                                },

                                updateHiddenInputs() {
                                    const container = document.getElementById('hiddenInputsContainer');

                                    // Hapus input lama
                                    container.innerHTML = '';

                                    for (const [ticketId, item] of Object.entries(cart)) {
                                        const fields = {
                                            [`tickets[${ticketId}][id]`]: ticketId,
                                            [`tickets[${ticketId}][quantity]`]: item.quantity,
                                            [`tickets[${ticketId}][price]`]: item.price,
                                            [`tickets[${ticketId}][total]`]: item.total
                                        };

                                        for (const [name, value] of Object.entries(fields)) {
                                            const input = document.createElement('input');
                                            input.type = 'hidden';
                                            input.name = name;
                                            input.value = value;
                                            input.className = 'ticket-hidden-input';
                                            container.appendChild(input);
                                        }
                                    }

                                    // Hitung total keseluruhan
                                    let grandTotal = Object.values(cart).reduce((sum, item) => sum + item.total, 0);

                                    // Hidden input untuk total keseluruhan
                                    const grandTotalInput = document.createElement('input');
                                    grandTotalInput.type = 'hidden';
                                    grandTotalInput.name = 'grand_total';
                                    grandTotalInput.value = grandTotal;
                                    container.appendChild(grandTotalInput);
                                },

                                renderCart() {
                                    const detailPesanan = document.getElementById('detail_pesanan');
                                    const totalPriceElement = document.getElementById('total_price');

                                    detailPesanan.innerHTML = '';

                                    if (Object.keys(cart).length === 0) {
                                        detailPesanan.innerHTML = `
                                        <div class="text-center text-gray-400 text-sm py-4" id="empty_cart">
                                            <i data-lucide="shopping-cart" class="size-8 mx-auto mb-2 opacity-50"></i>
                                            <p>Belum ada tiket dipilih</p>
                                        </div>`;
                                        totalPriceElement.textContent = 'Rp 0';
                                        lucide.createIcons();
                                        return;
                                    }

                                    let totalPrice = 0;
                                    for (const [ticketId, item] of Object.entries(cart)) {
                                        totalPrice += item.total;
                                        detailPesanan.innerHTML += `
                                        <div class="flex justify-between items-start pb-3 border-b border-gray-100">
                                            <div class="flex-1">
                                                <p class="font-medium text-md text-gray-700">${item.name}</p>
                                                <p class="text-sm text-gray-500">${item.quantity} x Rp ${item.price.toLocaleString('id-ID')}</p>
                                            </div>
                                            <p class="font-medium text-md text-gray-700">Rp ${item.total.toLocaleString('id-ID')}</p>
                                        </div>`;
                                    }

                                    totalPriceElement.textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
                                    lucide.createIcons();
                                }
                            };
                        }

                        function toggleTicketDetails(id) {
                            const element = document.getElementById(id);
                            element.classList.toggle('hidden');
                        }

                        document.addEventListener('DOMContentLoaded', function() {
                            const checkoutBtn = document.getElementById('checkoutBtn');
                            if (checkoutBtn) {
                                checkoutBtn.addEventListener('click', function() {
                                    if (Object.keys(cart).length === 0) {
                                        alert('Silakan pilih minimal satu tiket sebelum checkout!');
                                        return false;
                                    }
                                    // Jika kamu ingin mengirim data lewat AJAX, bisa lanjut di sini
                                    console.log(Object.values(cart));
                                });
                            }
                        });
                    </script>


                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg col-span-4 p-6">
                    <p class="text-gray-800 font-medium">Informasi Pembelian</p>
                    <div class="border-t border-gray-200 my-4"></div>

                    <div class="flex items-center gap-2">
                        <i data-lucide="user" class="size-5 text-indigo-400"></i>
                        <x-input-label :value="__('Nama Lengkap')" class="text-gray-300" />
                    </div>
                    <x-text-input
                        class="block mt-2 w-full border-2 rounded-lg p-2 outline-0 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        name="nama_peserta">
                    </x-text-input>


                    <div class="flex items-center gap-2 mt-4">
                        <i data-lucide="phone" class="size-5 text-indigo-400"></i>
                        <x-input-label :value="__('Nomor Telepon')" class="text-gray-300" />
                    </div>
                    <x-text-input
                        class="block mt-2 w-full border-2 rounded-lg p-2 outline-0 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        type="number" name="no_telp_peserta">
                    </x-text-input>


                    <div class="flex items-center gap-2 mt-4">
                        <i data-lucide="mail" class="size-5 text-indigo-400"></i>
                        <x-input-label :value="__('Email')" class="text-gray-300" />
                    </div>
                    <x-text-input id="email_peserta"
                        class="block mt-1 w-full border-2 rounded-lg p-2 outline-0 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        type="email" name="email_peserta" required />

                    <p class="text-gray-800 font-medium mt-4">Detail Pesanan</p>
                    <div class="border-t border-gray-200 my-4"></div>

                    <!-- Detail Pesanan Container -->
                    <div id="detail_pesanan" class="space-y-3">
                        <!-- Tiket yang dipilih akan muncul di sini -->
                        <div class="text-center text-gray-400 text-sm py-4" id="empty_cart">
                            <i data-lucide="shopping-cart" class="size-8 mx-auto mb-2 opacity-50"></i>
                            <p>Belum ada tiket dipilih</p>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="border-t border-gray-200 my-4"></div>
                    <div class="flex justify-between items-center mb-4">
                        <p class="font-bold text-lg text-gray-800">Total</p>
                        <p class="font-bold text-lg text-indigo-600" id="total_price">Rp 0</p>
                    </div>

                    <div class="flex items-center gap-2 mt-4">
                        <i data-lucide="credit-card" class="size-5 text-indigo-400"></i>
                        <x-input-label :value="__('Metode Pembayaran')" class="text-gray-300" />
                    </div>

                    <select name="metode_pembayaran"
                        class="mt-2 w-full text-gray-600 outline-gray-300 rounded-lg p-2 outline-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="" disabled selected>Pilih metode pembayaran</option>
                        <option value="credit_card">Kartu Kredit / Debit</option>
                        <option value="bank_transfer">Transfer Bank</option>
                        <option value="e_wallet">E-Wallet (OVO/GoPay/DANA)</option>
                        <option value="virtual_account">Virtual Account</option>
                        <option value="convenience_store">Gerai Retail (Alfamart/Indomaret)</option>
                    </select>
                    <button type="submit"
                        class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white block text-center font-medium py-2 px-4 rounded transition duration-300">Checkout</button>
                </div>
            </div>
        </div>

    </form>
    <!-- filepath: d:\Kulyeah\magang\Project\tukutiket\resources\views\pembeli\acara\checkout.blade.php -->
</x-app-layout>
