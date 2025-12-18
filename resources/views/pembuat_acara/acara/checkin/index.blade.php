<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i data-lucide="log-in" class="size-5 text-indigo-600"></i>
            <span class="font-semibold text-gray-800">
                Check-in Tiket - {{ $acara->nama_acara }}
            </span>
        </div>
    </x-slot>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <div class="max-w-7xl mx-auto p-6">

        <!-- Info Acara -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-6 mb-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-2xl font-bold">{{ $acara->nama_acara }}</h2>
                <div class="bg-white/20 px-3 py-1 rounded-full backdrop-blur-sm">
                    <i data-lucide="log-in" class="w-4 h-4 inline mr-1"></i>
                    <span class="text-sm font-semibold">Check-in Mode</span>
                </div>
            </div>
            <div class="flex flex-wrap gap-4 text-sm">
                <div class="flex items-center gap-2 bg-white/10 px-3 py-1.5 rounded-lg backdrop-blur-sm">
                    <i data-lucide="map-pin" class="size-4"></i>
                    <span>{{ $acara->lokasi }}</span>
                </div>
                <div class="flex items-center gap-2 bg-white/10 px-3 py-1.5 rounded-lg backdrop-blur-sm">
                    <i data-lucide="calendar" class="size-4"></i>
                    <span>{{ \Carbon\Carbon::parse($acara->waktu_mulai)->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Scanner -->
            <div class="rounded-2xl  p-6 bg-white h-fit border border-gray-100">
                <h3 class="text-lg font-semibold flex items-center gap-2 mb-4">
                    <div class="bg-indigo-100 p-2 rounded-lg">
                        <i data-lucide="camera" class="size-5 text-indigo-600"></i>
                    </div>
                    Scanner QR Code
                </h3>
                <div id="reader" class="rounded-xl overflow-hidden border-2 border-gray-200"></div>
                <div class="mt-4 text-center text-sm text-gray-500">
                    <i data-lucide="qr-code" class="w-4 h-4 inline mr-1"></i>
                    Arahkan kamera ke QR Code tiket
                </div>
            </div>

            <!-- Hasil Scan -->
            <div id="scan-result" class="p-6 bg-white border-2 rounded-2xl  hidden transition-all h-fit">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <div class="bg-indigo-100 p-2 rounded-lg">
                        <i data-lucide="clipboard-check" class="size-5 text-indigo-600"></i>
                    </div>
                    Hasil Scan
                </h3>

                <!-- Status Message -->
                <div id="scan-status" class="p-4 rounded-xl mb-4 text-center font-semibold"></div>

                <!-- Detail Tiket -->
                <div id="scan-details" class="space-y-3 hidden">
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 border border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i data-lucide="user" class="w-4 h-4 text-indigo-600"></i>
                            Informasi Peserta
                        </h4>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">Nama Peserta</span>
                                <span id="detail-nama-peserta" class="font-semibold text-gray-900">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">Email</span>
                                <span id="detail-email" class="font-medium text-gray-700 text-sm">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">No. Telp</span>
                                <span id="detail-telp" class="font-medium text-gray-700 text-sm">-</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-indigo-50 to-white rounded-xl p-4 border border-indigo-100">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i data-lucide="ticket" class="w-4 h-4 text-indigo-600"></i>
                            Informasi Tiket
                        </h4>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">Kode Tiket</span>
                                <span id="detail-kode" class="font-mono font-semibold text-indigo-600 text-sm">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">Jenis Tiket</span>
                                <span id="detail-jenis" class="font-semibold text-gray-900">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">Harga</span>
                                <span id="detail-harga" class="font-semibold text-gray-900">-</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-white rounded-xl p-4 border border-purple-100">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i data-lucide="shopping-bag" class="w-4 h-4 text-purple-600"></i>
                            Informasi Pemesan
                        </h4>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">Kode Pesanan</span>
                                <span id="detail-kode-pesanan"
                                    class="font-mono font-medium text-gray-700 text-sm">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">Nama Pemesan</span>
                                <span id="detail-pemesan" class="font-medium text-gray-700 text-sm">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">Email Pemesan</span>
                                <span id="detail-email-pemesan" class="font-medium text-gray-700 text-sm">-</span>
                            </div>
                        </div>
                    </div>

                    <div id="checkin-time"
                        class="text-center text-sm bg-green-50 text-green-700 py-3 px-4 rounded-xl border border-green-200 hidden">
                        <i data-lucide="clock" class="size-4 inline mr-1"></i>
                        Check-in: <span id="detail-waktu" class="font-semibold"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let scanner;
        let isProcessing = false;

        // Sound effects (simple beep sounds)
        const successSound = new Audio(
            'data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBjWH0fPTgjMGHm7A7+OZURAMP'
        );
        const errorSound = new Audio('data:audio/wav;base64,UklGRhIAAABXQVZFZm10IBAAAAABAAEARKwAAIhYAQACABAAZGF0YW4AAAD/');

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

            // Reset and show loading
            box.classList.remove("hidden", "border-red-500", "border-green-500", "border-yellow-500", "border-blue-500");
            box.classList.add("border-blue-500");
            statusBox.className = "p-4 rounded-xl mb-4 text-center font-semibold bg-blue-100 text-blue-700 animate-pulse";
            statusBox.innerHTML =
                '<i data-lucide="loader" class="w-5 h-5 inline mr-2 animate-spin"></i>Memverifikasi tiket...';
            detailsBox.classList.add("hidden");
            checkinTime.classList.add("hidden");
            lucide.createIcons();

            fetch("{{ route('pembuat.scan.checkin', $acara->slug) }}", {
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
                    if (data.status === "valid" && data.tipe === "IN") {
                        // Success Check-in
                        successSound.play().catch(() => {});

                        box.classList.remove("border-blue-500");
                        box.classList.add("border-green-500", "animate-pulse");
                        statusBox.className =
                            "p-4 rounded-xl mb-4 text-center font-semibold bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 border-2 border-green-300";
                        statusBox.innerHTML =
                            '<div class="flex items-center justify-center gap-2"><i data-lucide="check-circle" class="w-6 h-6"></i><span class="text-lg">' +
                            data.message + '</span></div>';

                        // Show details with delay
                        setTimeout(() => {
                            detailsBox.classList.remove("hidden");
                            detailsBox.classList.add("animate-fadeIn");

                            document.getElementById("detail-nama-peserta").textContent = data.nama_peserta ||
                                '-';
                            document.getElementById("detail-email").textContent = data.email_peserta || '-';
                            document.getElementById("detail-telp").textContent = data.no_telp_peserta || '-';
                            document.getElementById("detail-kode").textContent = data.kode_tiket || decodedText;
                            document.getElementById("detail-jenis").textContent = data.jenis_tiket || '-';
                            document.getElementById("detail-harga").textContent = data.harga_tiket ?
                                formatRupiah(data.harga_tiket) : 'Gratis';
                            document.getElementById("detail-kode-pesanan").textContent = data.kode_pesanan ||
                                '-';
                            document.getElementById("detail-pemesan").textContent = data.nama_pemesan || '-';
                            document.getElementById("detail-email-pemesan").textContent = data.email_pemesan ||
                                '-';

                            checkinTime.classList.remove("hidden");
                            document.getElementById("detail-waktu").textContent = new Date().toLocaleString(
                                'id-ID');

                            lucide.createIcons();
                        }, 300);

                        setTimeout(() => {
                            box.classList.remove("animate-pulse");
                            isProcessing = false;
                        }, 3000);

                    } else {
                        // Error
                        errorSound.play().catch(() => {});

                        box.classList.remove("border-blue-500");
                        box.classList.add("border-red-500");
                        statusBox.className =
                            "p-4 rounded-xl mb-4 text-center font-semibold bg-gradient-to-r from-red-100 to-rose-100 text-red-700 border-2 border-red-300";
                        statusBox.innerHTML =
                            '<div class="flex items-center justify-center gap-2"><i data-lucide="alert-circle" class="w-6 h-6"></i><span>' +
                            data.message + '</span></div>';
                        detailsBox.classList.add("hidden");

                        lucide.createIcons();

                        setTimeout(() => {
                            isProcessing = false;
                        }, 2000);
                    }
                })
                .catch(error => {
                    errorSound.play().catch(() => {});

                    box.classList.remove("border-blue-500");
                    box.classList.add("border-red-500");
                    statusBox.className = "p-4 rounded-xl mb-4 text-center font-semibold bg-red-100 text-red-700";
                    statusBox.innerHTML =
                        '<i data-lucide="wifi-off" class="w-5 h-5 inline mr-2"></i>Kesalahan jaringan. Coba lagi.';
                    detailsBox.classList.add("hidden");

                    lucide.createIcons();
                    isProcessing = false;
                });
        }

        function onScanFailure(error) {
            // Silent fail
        }

        // Initialize scanner
        scanner = new Html5QrcodeScanner("reader", {
            fps: 10,
            qrbox: {
                width: 300,
                height: 300
            },
            rememberLastUsedCamera: true
        });
        scanner.render(onScanSuccess, onScanFailure);
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</x-app-layout>
