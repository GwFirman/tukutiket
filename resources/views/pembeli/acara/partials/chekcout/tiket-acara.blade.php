<div class="px-5">

    <div class=" text-gray-400 mt-4 font-medium text-lg">
        <i data-lucide="ticket" class="inline"></i> Informasi tiket
    </div>
    <div class="grid grid-cols-1 gap-4 mt-6">
        @foreach ($acara->jenisTiket as $tiket)
            <div class="ticket-container mb-4">
                <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all">
                    <!-- Ticket Header -->
                    <div class="bg-gradient-to-r from-indigo-50 to-gray-50 p-4 relative">
                        <!-- Ticket stub design -->
                        <div class="absolute top-0 left-0 h-full w-3 bg-indigo-500 flex items-center justify-center">
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

                                <p class="text-indigo-600 font-bold">
                                    @if ($tiket->harga == 0)
                                        Gratis
                                    @else
                                        Rp {{ number_format($tiket->harga, 0, ',', '.') }}
                                    @endif
                                </p>

                            </div>

                            <div>
                                <div x-data="ticketCounter({{ $tiket->id }}, '{{ $tiket->nama_jenis }}', {{ $tiket->harga }}, {{ $maksTiket ?? ($acara->maks_tiket_per_transaksi ?? 5) }})"
                                    class="flex items-center gap-2 sm:gap-3 bg-gray-100 rounded-full px-2 py-1 sm:px-3 sm:py-2 w-fit">
                                    <!-- Tombol Minus -->
                                    <button type="button" @click="decrementTicket()"
                                        class="p-0.5 sm:p-1 text-center bg-indigo-500 text-white rounded-full hover:bg-indigo-600 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
                                        :disabled="count === 0">
                                        <i data-lucide="minus" class="size-4 sm:size-5"></i>
                                    </button>

                                    <!-- Nilai Jumlah -->
                                    <span
                                        class="w-6 sm:w-8 text-center font-semibold text-gray-700 text-sm sm:text-base"
                                        x-text="count"></span>

                                    <!-- Tombol Plus -->
                                    <button type="button" @click="incrementTicket()"
                                        class="p-0.5 sm:p-1 text-center bg-indigo-500 text-white rounded-full hover:bg-indigo-600 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
                                        :disabled="!canAddMore()">
                                        <i data-lucide="plus" class="size-4 sm:size-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col-reverse md:flex-row  justify-between w-full ml-5 mt-2">
                            <!-- Tombol lihat detail -->
                            <button type="button" onclick="toggleTicketDetails('ticket-{{ $tiket->id }}')"
                                class="mt-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                                Lihat Detail
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <p class="flex text-gray-500 text-sm items-center mr-4">
                                Penjualan berakhir
                                {{ \Carbon\Carbon::parse($tiket->penjualan_selesai)->translatedFormat('d M Y') }}
                            </p>
                        </div>
                    </div>
                    <!-- Ticket Details (Hidden by default) -->
                    <div id="ticket-{{ $tiket->id }}" class="hidden">
                        <div class="border-t border-dashed border-gray-300 relative">
                            <div class="absolute left-0 top-0 w-3 h-3 bg-white rounded-full -mt-1.5 -ml-1.5">
                            </div>
                            <div class="absolute right-0 top-0 w-3 h-3 bg-white rounded-full -mt-1.5 -mr-1.5">
                            </div>
                        </div>

                        <div class="p-4 bg-white">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div class="p-2 bg-gray-50 rounded">
                                    <p class="text-gray-500 text-xs">Penjualan Mulai</p>
                                    <p class="font-medium flex items-center">
                                        <i data-lucide="calendar" class="h-3 w-3 mr-1 text-indigo-400"></i>
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
                                        <i data-lucide="calendar" class="h-3 w-3 mr-1 text-indigo-400"></i>
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
        const MAX_TICKETS = @json($maksTiket ?? ($acara->maks_tiket_per_transaksi ?? 5));
        let savedPesertaData = {}; // Menyimpan data peserta yang sudah diisi

        function getTotalTickets() {
            return Object.values(cart).reduce((sum, item) => sum + item.quantity, 0);
        }

        // Fungsi untuk menyimpan data form sebelum re-render
        function savePesertaData() {
            const container = document.getElementById('peserta_forms_container');
            const inputs = container.querySelectorAll('input');

            inputs.forEach(input => {
                if (input.name && input.value) {
                    savedPesertaData[input.name] = input.value;
                }
            });
        }

        // Fungsi untuk mengembalikan data form setelah re-render
        function restorePesertaData() {
            for (const [name, value] of Object.entries(savedPesertaData)) {
                const input = document.querySelector(`input[name="${name}"]`);
                if (input) {
                    input.value = value;
                }
            }
        }

        function ticketCounter(ticketId, ticketName, ticketPrice, maxPerTransaction) {
            return {
                count: 0,
                ticketId: ticketId,
                ticketName: ticketName,
                ticketPrice: ticketPrice,
                maxPerTransaction: maxPerTransaction,

                canAddMore() {
                    return getTotalTickets() < MAX_TICKETS;
                },

                incrementTicket() {
                    if (this.canAddMore()) {
                        this.count++;
                        this.updateCart();
                    }
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

                    // Simpan data sebelum render, lalu kembalikan setelah render
                    savePesertaData();
                    this.renderPesertaForms();
                    restorePesertaData();
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

                renderPesertaForms() {
                    const container = document.getElementById('peserta_forms_container');
                    const totalTickets = getTotalTickets();

                    if (totalTickets === 0) {
                        container.innerHTML = `
                                                <div class="text-center text-gray-400 text-sm py-6">
                                                    <i data-lucide="users" class="size-8 mx-auto mb-2 opacity-50"></i>
                                                    <p>Pilih tiket untuk mengisi data peserta</p>
                                                </div>`;
                        lucide.createIcons();
                        return;
                    }

                    let html = '';
                    let pesertaIndex = 0;

                    for (const [ticketId, item] of Object.entries(cart)) {
                        for (let i = 0; i < item.quantity; i++) {
                            pesertaIndex++;
                            html += `
                                                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                                        <div class="flex items-center justify-between mb-3">
                                                            <div class="flex items-center gap-2">
                                                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                                                    <span class="text-indigo-600 font-semibold text-sm">${pesertaIndex}</span>
                                                                </div>
                                                                <div>
                                                                    <p class="font-medium text-gray-800">Peserta ${pesertaIndex}</p>
                                                                    <p class="text-xs text-indigo-600">${item.name}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="space-y-3">
                                                            <div>
                                                                <label class="text-xs text-gray-500 mb-1 block">Nama Lengkap *</label>
                                                                <input type="text" 
                                                                    name="peserta[${ticketId}][${i}][nama]" 
                                                                    required
                                                                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                                    placeholder="Masukkan nama lengkap">
                                                            </div>
                                                            <div class="grid grid-cols-2 gap-3">
                                                                <div>
                                                                    <label class="text-xs text-gray-500 mb-1 block">Email</label>
                                                                    <input type="email" 
                                                                        name="peserta[${ticketId}][${i}][email]"
                                                                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                                        placeholder="email@example.com">
                                                                </div>
                                                                <div>
                                                                    <label class="text-xs text-gray-500 mb-1 block">No. Telepon</label>
                                                                    <input type="tel" 
                                                                        name="peserta[${ticketId}][${i}][telp]"
                                                                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                                        placeholder="08xxxxxxxxxx">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>`;
                        }
                    }

                    container.innerHTML = html;
                    lucide.createIcons();
                },

                renderCart() {
                    const detailPesanan = document.getElementById('detail_pesanan');
                    const totalPriceElement = document.getElementById('total_price');
                    const ticketCountElement = document.getElementById('ticket_count');

                    detailPesanan.innerHTML = '';
                    const totalTickets = getTotalTickets();

                    // Update ticket count badge
                    if (ticketCountElement) {
                        ticketCountElement.textContent = `${totalTickets}/${MAX_TICKETS} tiket`;
                        ticketCountElement.className = totalTickets >= MAX_TICKETS ?
                            'text-xs px-2 py-1 rounded-full bg-red-100 text-red-600' :
                            'text-xs px-2 py-1 rounded-full bg-indigo-100 text-indigo-600';
                    }

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
