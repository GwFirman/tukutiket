<!DOCTYPE html>
<html>

<head>
    <title>Tiket Elektronik</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .ticket-box {
            border: 1px solid #ddd;
            padding: 20px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        .label {
            font-weight: bold;
            color: #555;
        }

        .status-paid {
            color: green;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>E-Ticket Event</h2>
        <p>Kode Pesanan: #{{ $pesanan->kode_pesanan }}</p>
    </div>

    <div class="ticket-box">
        <table class="info-table">
            <tr>
                <td class="label">Nama Acara</td>
                <td>{{ $pesanan->detailPesanan->first()->jenisTiket->acara->nama_acara }}</td>
            </tr>
            <tr>
                <td class="label">Total Harga</td>
                <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Status</td>
                <td class="status-paid">LUNAS</td>
            </tr>
        </table>

        <br>
        <div style="text-align: center;">
            <p>Tunjukkan tiket ini saat masuk.</p>
            {{-- Contoh jika ingin menampilkan QR Code (opsional) --}}
            {{-- <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(100)->generate($pesanan->kode_pesanan)) }} "> --}}
        </div>
    </div>
</body>

</html>
