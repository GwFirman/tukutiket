<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>E-Ticket - {{ $tiket->kode_tiket }}</title>
    <style>
        /* Reset & Base */
        @page {
            margin: 0px;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 40px;
            color: #333;
        }

        /* Container Tiket */
        .ticket-wrapper {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }

        /* Header Style (Banner Biru) */
        .header {
            background-color: #1d4ed8;
            /* Biru profesional */
            color: white;
            padding: 30px;
            /* Trik border agar terlihat 3D/Premium tanpa gradient */
            border-bottom: 5px solid #1e40af;
        }

        .event-name {
            font-size: 24px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }

        .event-subtitle {
            font-size: 12px;
            opacity: 0.9;
            margin-top: 5px;
            font-weight: 500;
        }

        /* Layout menggunakan Table (Wajib untuk DomPDF) */
        .layout-table {
            width: 100%;
            border-collapse: collapse;
        }

        .col-left {
            width: 70%;
            padding: 30px;
            vertical-align: top;
        }

        .col-right {
            width: 30%;
            padding: 30px;
            background-color: #f8fafc;
            border-left: 2px dashed #cbd5e1;
            /* Efek sobekan */
            text-align: center;
            vertical-align: middle;
            position: relative;
        }

        /* Typography untuk Info */
        .label {
            font-size: 10px;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
            font-weight: 600;
        }

        .value {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .value-large {
            font-size: 16px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 20px;
        }

        /* Badge Status / Jenis Tiket */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            background-color: #dbeafe;
            color: #1e40af;
            border-radius: 50px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* QR Code Area */
        .qr-container img {
            width: 140px;
            height: 140px;
            border: 4px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .qr-help {
            font-size: 10px;
            color: #64748b;
            margin-top: 10px;
            line-height: 1.4;
        }

        /* Dekorasi Lingkaran "Sobekan" (Opsional - kadang DomPDF susah render ini sempurna) */
        .circle-top,
        .circle-bottom {
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: #f3f4f6;
            /* Samakan dengan warna body */
            border-radius: 50%;
            left: -11px;
            /* Posisi di tengah garis putus2 */
            z-index: 10;
        }

        .circle-top {
            top: -10px;
        }

        .circle-bottom {
            bottom: -10px;
        }

        /* Footer Kecil */
        .footer-note {
            padding: 15px 30px;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            font-size: 10px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="ticket-wrapper">
        <div class="header">
            <h1 class="event-name">{{ $tiket->nama_acara }}</h1>
            <div class="event-subtitle">{{ $tiket->lokasi }}</div>
        </div>

        <table class="layout-table">
            <tr>
                <td class="col-left">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%; padding-bottom: 10px;">
                                <div class="label">JADWAL ACARA</div>
                                <div class="value-large">
                                    {{ \Carbon\Carbon::parse($tiket->waktu_mulai)->format('d M Y') }}<br>
                                    <span style="font-weight: normal; font-size: 12px;">
                                        {{ \Carbon\Carbon::parse($tiket->waktu_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($tiket->waktu_selesai)->format('H:i') }} WIB
                                    </span>
                                </div>
                            </td>
                            <td style="width: 50%; padding-bottom: 10px;">
                                <div class="label">PEMEGANG TIKET</div>
                                <div class="value-large">{{ $tiket->nama_peserta }}</div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="label">INFO KONTAK</div>
                                <div class="value">
                                    {{ $tiket->email_peserta }}<br>
                                    <span style="color: #64748b; font-size: 12px;">{{ $tiket->no_telp_peserta }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="label">JENIS TIKET</div>
                                <div class="value">
                                    <span class="badge">{{ $tiket->jenis_tiket }}</span>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="label">KODE ORDER</div>
                                <div class="value" style="font-family: monospace; letter-spacing: 1px;">
                                    #{{ $tiket->kode_pesanan }}
                                </div>
                            </td>
                            <td>
                                <div class="label">HARGA TIKET</div>
                                <div class="value">Rp {{ number_format($tiket->harga_tiket, 0, ',', '.') }}</div>
                            </td>
                        </tr>
                    </table>
                </td>

                <td class="col-right">
                    <div class="circle-top"></div>
                    <div class="circle-bottom"></div>

                    <div class="qr-container">
                        @php
                            // Generate QR Code base64
                            $qr = base64_encode(
                                QrCode::format('png')->size(300)->errorCorrection('H')->generate($tiket->kode_tiket),
                            );
                        @endphp
                        <img src="data:image/png;base64, {{ $qr }}" alt="QR Code">
                    </div>

                    <div style="margin-top: 15px;">
                        <div class="label">KODE TIKET</div>
                        <div style="font-size: 16px; font-weight: bold; letter-spacing: 2px; font-family: monospace;">
                            {{ $tiket->kode_tiket }}
                        </div>
                    </div>

                    <p class="qr-help">
                        Scan QR Code ini di pintu masuk.<br>
                        Jangan bagikan ke orang lain.
                    </p>
                </td>
            </tr>
        </table>

        <div class="footer-note">
            Tiket ini sah dan diterbitkan secara elektronik. Simpan bukti tiket ini untuk ditunjukkan kepada petugas
            saat masuk ke lokasi acara.
        </div>
    </div>

</body>

</html>
