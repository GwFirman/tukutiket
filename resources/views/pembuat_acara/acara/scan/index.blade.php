<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i data-lucide="scan-line" class="size-5 text-gray-600"></i>
            <span class="font-semibold text-gray-800">
                Scan Tiket - {{ $acara->nama_acara }}
            </span>
        </div>
    </x-slot>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <div class="max-w-7xl mx-auto p-6">

        <!-- Info Acara -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-6 mb-6 text-white shadow-lg">
            <h2 class="text-2xl font-bold mb-2">{{ $acara->nama_acara }}</h2>
            <div class="flex flex-wrap gap-4 text-sm">
                <div class="flex items-center gap-2">
                    <i data-lucide="map-pin" class="size-4"></i>
                    <span>{{ $acara->lokasi }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i data-lucide="calendar" class="size-4"></i>
                    <span>{{ \Carbon\Carbon::parse($acara->waktu_mulai)->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Scanner -->
            <div class="rounded-xl shadow-lg p-4 bg-white h-fit">
                <h3 class="text-lg font-semibold mb-3 flex items-center gap-2">
                    <i data-lucide="camera" class="size-5 text-indigo-600"></i>
                    Scanner QR Code
                </h3>
                <div id="reader" class="rounded-md"></div>
            </div>

            <!-- Hasil Scan -->
            <div id="scan-result" class="p-5 bg-white border-2 rounded-xl shadow-lg hidden transition-all h-fit">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <i data-lucide="clipboard-check" class="size-5 text-indigo-600"></i>
                    Hasil Scan
                </h3>

                <!-- Status Message -->
                <div id="scan-status" class="p-3 rounded-lg mb-4 text-center font-semibold"></div>

                <!-- Detail Tiket -->
                <div id="scan-details" class="space-y-3 hidden">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-semibold text-gray-500 mb-2">Informasi Peserta</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nama Peserta</span>
                                <span id="detail-nama-peserta" class="font-medium">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email</span>
                                <span id="detail-email" class="font-medium">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">No. Telp</span>
                                <span id="detail-telp" class="font-medium">-</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-semibold text-gray-500 mb-2">Informasi Tiket</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kode Tiket</span>
                                <span id="detail-kode" class="font-mono font-medium text-indigo-600">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jenis Tiket</span>
                                <span id="detail-jenis" class="font-medium">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Harga</span>
                                <span id="detail-harga" class="font-medium">-</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-semibold text-gray-500 mb-2">Informasi Pemesan</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kode Pesanan</span>
                                <span id="detail-kode-pesanan" class="font-mono font-medium">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nama Pemesan</span>
                                <span id="detail-pemesan" class="font-medium">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email Pemesan</span>
                                <span id="detail-email-pemesan" class="font-medium">-</span>
                            </div>
                        </div>
                    </div>

                    <div id="checkin-time" class="text-center text-sm text-gray-500 pt-2 hidden">
                        <i data-lucide="clock" class="size-4 inline"></i>
                        Check-in: <span id="detail-waktu"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let scanner;
        let isProcessing = false;

        function formatRupiah(angka) {
            return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
        }

        function onScanSuccess(decodedText) {
            if (isProcessing) return;
            isProcessing = true;

            const box = document.getElementById("scan-result");
            const statusBox = document.getElementById("scan-status");
            const detailsBox = document.getElementById("scan-details");
            const checkinTime = document.getElementById("checkin-time");

            box.classList.remove("hidden", "border-red-500", "border-green-500", "border-yellow-500");
            box.classList.add("border-blue-500");
            statusBox.className = "p-3 rounded-lg mb-4 text-center font-semibold bg-blue-100 text-blue-700";
            statusBox.innerHTML = "🔍 Memverifikasi kode: <span class='font-mono'>" + decodedText + "</span>";
            detailsBox.classList.add("hidden");
            checkinTime.classList.add("hidden");

            fetch("{{ route('pembuat.scan.check', $acara->slug) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        kode_tiket: decodedText
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "valid") {
                        // Update tampilan
                        box.classList.remove("border-blue-500");
                        box.classList.add("border-green-500");
                        statusBox.className =
                            "p-3 rounded-lg mb-4 text-center font-semibold bg-green-100 text-green-700";
                        statusBox.innerHTML = "✅ " + data.message;

                        // Tampilkan detail
                        detailsBox.classList.remove("hidden");
                        document.getElementById("detail-nama-peserta").textContent = data.nama_peserta || '-';
                        document.getElementById("detail-email").textContent = data.email_peserta || '-';
                        document.getElementById("detail-telp").textContent = data.no_telp_peserta || '-';
                        document.getElementById("detail-kode").textContent = data.kode_tiket || decodedText;
                        document.getElementById("detail-jenis").textContent = data.jenis_tiket || '-';
                        document.getElementById("detail-harga").textContent = data.harga_tiket ? formatRupiah(data
                            .harga_tiket) : 'Gratis';
                        document.getElementById("detail-kode-pesanan").textContent = data.kode_pesanan || '-';
                        document.getElementById("detail-pemesan").textContent = data.nama_pemesan || '-';
                        document.getElementById("detail-email-pemesan").textContent = data.email_pemesan || '-';

                        // Tampilkan waktu check-in
                        checkinTime.classList.remove("hidden");
                        document.getElementById("detail-waktu").textContent = new Date().toLocaleString('id-ID');

                        // Tunggu 3 detik sebelum bisa scan lagi
                        setTimeout(() => {
                            isProcessing = false;
                            statusBox.innerHTML += " <span class='text-sm'>(Siap scan berikutnya)</span>";
                        }, 3000);

                    } else {
                        // Update tampilan error
                        box.classList.remove("border-blue-500");
                        box.classList.add("border-red-500");
                        statusBox.className = "p-3 rounded-lg mb-4 text-center font-semibold bg-red-100 text-red-700";
                        statusBox.innerHTML = data.message;
                        detailsBox.classList.add("hidden");

                        isProcessing = false;
                    }
                })
                .catch(error => {
                    box.classList.remove("border-blue-500");
                    box.classList.add("border-red-500");
                    statusBox.className = "p-3 rounded-lg mb-4 text-center font-semibold bg-red-100 text-red-700";
                    statusBox.innerHTML = "❌ Terjadi kesalahan jaringan. Coba lagi.";
                    detailsBox.classList.add("hidden");

                    isProcessing = false;
                });
        }

        function onScanFailure(error) {}

        scanner = new Html5QrcodeScanner("reader", {
            fps: 10,
            qrbox: 300
        });
        scanner.render(onScanSuccess, onScanFailure);
    </script>
</x-app-layout>
