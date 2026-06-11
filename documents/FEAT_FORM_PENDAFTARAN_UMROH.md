tambahkan menu baru untuk input data pendaftaran jamaah umroh dan generate dokumen form pendaftaran umroh.

Menu: Pendaftaran Jamaah

List Jamaah Umroh + Button Tambah Jamaah
- List data jamaah
- button untuk tambah jamaah
- button untuk generate formulir berupa preview pdf di website terus nanti bisa di download atau print

Detail Form Pendaftaran + View Dokumen
- input form pendaftara
- preview dokumen realtime.

Format Form Pendaftaran Umrah

Logo Al-Ahza - Foto Jamaah (foto itu inputnya opsional yaa)

FORM PENDAFTARAN UMRAH
A. PAKET PILIHAN
PAKET UMRAH: Double/Triple/Quad

B. DATA JAMAAH UMRAH
1. Nama sesuai Paspor
2. Data Paspor
- No Paspor:
- Tanggal dikeluarkan paspor:
- Tempat dikeluarkan Paspor:
- Masa Berlaku paspor:
Tahun ... s/d Tahun ...
3. Tempat & Tanggal Lahir:
4. Jenis Kelamin:
5. Alamat Domisili:
6. Pekerjaan:
7. No HP (Terhubung ke Whatsapp):
8. No Darurat:
- Nama/Hubungan (Nomor): 
- Nama/Hubungan (Nomor):
9. Nama Mahram/Pendamping:
10. HUbungan Mahram: Orangtua/Anak/Suami Istri/Mertua/Saudara Kandung
11. Pengalaman Umrah: Ke-1/Ke-2/Ke-3/Ke-4

C. DOKUMEN YANG PERLU DIPERSIAPKAN
(ini dokumen defaultnya)
1. KTP
2. KK
3. Paspor
4. Vaksin Polio & Meningitis


{{-- Lokasi: resources/views/sales/customers/formulir.blade.php --}}
{{-- Formulir Berlangganan — print-ready PDF preview --}}

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Berlangganan — {{ $customer->name }}</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #1a1a1a;
            line-height: 1.10;
            background: #f0f0f0;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 20px auto;
            background: #fff;
            padding: 10mm;
            box-shadow: 0 2px 20px rgba(0, 0, 0, .15);
            text-align: justify;
        }

        /* Print: hide toolbar, remove shadow, fit page, remove browser header/footer */
        @media print {
            @page {
                margin: 0;
            }

            body {
                background: #fff;
            }

            .page {
                margin: 0;
                padding: 10mm;
                box-shadow: none;
                width: 100%;
                min-height: auto;
            }

            .no-print {
                display: none !important;
            }
        }

        /* ─── Header ─── */
        .header {
            display: flex;
            align-items: center;
            gap: 14px;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }

        .header-logo {
            flex-shrink: 0;
        }

        .header-logo img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }

        .header-text {
            flex: 1;
        }

        .header-text .company-name {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            font-weight: 700;
            color: #000;
        }

        .header-text .company-address {
            font-size: 11pt;
            color: #000;
            margin-top: 2px;
        }

        .header-text .company-phone {
            font-size: 11pt;
            color: #000;
            margin-top: 2px;
        }

        /* ─── Title ─── */
        .form-title {
            text-align: center;
            font-size: 12pt;
            font-weight: 700;
            color: #1a1a1a;
            margin: 16px 0 12px;
            text-decoration: underline;
        }

        /* ─── Section Title ─── */
        .section-title {
            font-size: 11pt;
            font-weight: 700;
            color: #ea580c;
            margin: 14px 0 8px;
            padding-bottom: 3px;
            border-bottom: 1px solid #ea580c;
        }

        /* ─── Info Table ─── */
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 6px;
            vertical-align: top;
        }

        .info-table .label {
            width: 38%;
            color: #000;
            font-weight: 500;
        }

        .info-table .separator {
            width: 3%;
            text-align: center;
            color: #000;
        }

        .info-table .value {
            color: #000;
            font-weight: 400;
        }

        /* ─── Notes ─── */
        .notes-list {
            list-style: none;
            padding-left: 0;
        }

        .notes-list li {
            padding: 3px 0 3px 16px;
            position: relative;
            font-size: 11pt;
            color: #000;
            line-height: 1;
        }

        .notes-list li::before {
            content: '•';
            position: absolute;
            left: 4px;
            color: #000;
            font-weight: bold;
        }

        /* Keep structural elements left-aligned for readability */
        .header,
        .header-text,
        .section-title,
        .info-table td,
        .sig-table td {
            text-align: left;
        }

        /* Ensure title remains centered */
        .form-title {
            text-align: center;
        }

        /* ─── Agreement ─── */
        .agreement {
            font-size: 11pt;
            color: #000;
            line-height: 1;
            margin: 16px 0 20px;
            text-align: justify;
        }

        /* ─── Signatures ─── */
        .sig-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #000;
        }

        .sig-table td {
            width: 50%;
            text-align: left;
            padding: 2px 12px;
            vertical-align: top;
            border: 1px solid #000;
        }

        .sig-role {
            font-size: 11pt;
            font-weight: 600;
            height: 100px;
            vertical-align: top;
        }

        .sig-name {
            font-size: 11pt;
            font-weight: 500;
            color: #000;
        }

        .sig-date {
            font-size: 11pt;
            color: #000;
        }

        /* ─── Print Button ─── */
        .print-toolbar {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 100;
            display: flex;
            gap: 8px;
        }

        .print-toolbar button,
        .print-toolbar a {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 11pt;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all .2s;
        }

        .btn-print {
            background: #ea580c;
            color: #fff;
        }

        .btn-print:hover {
            background: #c2410c;
        }

        .btn-back {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .btn-back:hover {
            background: #e2e8f0;
        }

        .app_name {
            text-transform: uppercase;
        }
    </style>
</head>

<body>

    {{-- Print Toolbar --}}
    <div class="print-toolbar no-print">
        <a href="{{ route('sales.customers.show', $customer) }}" class="btn-back">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
        <button onclick="window.print()" class="btn-print">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak / Simpan PDF
        </button>
    </div>

    <div class="page">

        {{-- ── Kop Surat ── --}}
        <div class="header">
            {{-- Logo --}}
            @if (!empty($settings['app_logo']))
                <div class="header-logo">
                    <img src="{{ asset('storage/' . $settings['app_logo']) }}" alt="Logo">
                </div>
            @endif

            {{-- Text --}}
            <div class="header-text">
                <p class="company-name">{{ $settings['isp_name'] }}</p>
                @if ($settings['isp_address'])
                    <p class="company-address">{{ $settings['isp_address'] }}</p>
                @endif
                <p class="company-phone">
                    HP / WA : CS 24 Jam : {{ $settings['isp_phone'] ?: '-' }}
                    &nbsp;|&nbsp; Sales 1 : 081318986900
                    &nbsp;|&nbsp; Sales 2 : 081212676300
                </p>
            </div>
        </div>

        {{-- ── Judul ── --}}
        <div class="form-title">FORMULIR BERLANGGANAN</div>

        {{-- ── Informasi Pelanggan ── --}}
        <div class="section-title">Informasi Pelanggan</div>
        <table class="info-table">
            <tr>
                <td class="label">Status Pelanggan</td>
                <td class="separator">:</td>
                <td class="value">{{ $customer->customerStatusLabel() }}</td>
            </tr>
            <tr>
                <td class="label">Metode Pembayaran</td>
                <td class="separator">:</td>
                <td class="value">{{ $customer->paymentMethodLabel() }}</td>
            </tr>
            @if ($customer->payment_channel)
                <tr>
                    <td class="label">Channel Pembayaran</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $customer->payment_channel }}</td>
                </tr>
            @endif
            @if ($customer->payment_number)
                <tr>
                    <td class="label">Nomor Pembayaran</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $customer->payment_number }}</td>
                </tr>
            @endif
            <tr>
                <td class="label">Nama Pelanggan</td>
                <td class="separator">:</td>
                <td class="value">{{ $customer->name }}</td>
            </tr>
            <tr>
                <td class="label">Penanggung Jawab</td>
                <td class="separator">:</td>
                <td class="value">{{ $customer->penanggung_jawab ?: $customer->name }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td class="separator">:</td>
                <td class="value">{{ $customer->genderLabel() }}</td>
            </tr>
            <tr>
                <td class="label">Nomor Identitas (KTP/SIM)</td>
                <td class="separator">:</td>
                <td class="value">{{ $customer->ktp_number ?: '___________________________' }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td class="separator">:</td>
                <td class="value">{{ $customer->address ?: '-' }}
                    @if ($customer->district || $customer->village)
                        {{ $customer->village ? $customer->village : '' }}{{ $customer->village && $customer->district ? '-' : '' }}{{ $customer->district ? $customer->district : '' }}
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Koordinat</td>
                <td class="separator">:</td>
                <td class="value">
                    @if ($customer->latitude && $customer->longitude)
                        {{ $customer->latitude }}, {{ $customer->longitude }}
                    @else
                        ___________________________
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Nomor telepon/HP</td>
                <td class="separator">:</td>
                <td class="value">{{ $customer->phone ?: '___________________________' }}</td>
            </tr>
            <tr>
                <td class="label">Alat</td>
                <td class="separator">:</td>
                <td class="value">{{ $customer->device ?: '___________________________' }}</td>
            </tr>
            <tr>
                <td class="label">Kabel UTP / FO</td>
                <td class="separator">:</td>
                <td class="value">
                    @if ($customer->cable_length)
                        {{ number_format($customer->cable_length, 0) }} meter
                    @else
                        _________ meter
                    @endif
                </td>
            </tr>
        </table>

        {{-- ── Layanan ── --}}
        <div class="section-title">Layanan</div>
        <table class="info-table">
            <tr>
                <td class="label">Paket Layanan Internet</td>
                <td class="separator">:</td>
                <td class="value">
                    {{ $customer->service_package }}
                    @if ($customer->package?->speed_up)
                        ({{ $customer->package->speed_up }} Mbps)
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Biaya / bulan</td>
                <td class="separator">:</td>
                <td class="value">Rp. {{ number_format($customer->monthly_fee, 0, ',', '.') }}
                </td>
            </tr>
        </table>

        {{-- ── Catatan / Note ── --}}
        <div class="section-title">Catatan / Note</div>
        <ul class="notes-list">
            <li>Semua perangkat (Radio, Wifi, Kabel) status dipinjamkan selama berlangganan.</li>
            <li>Minimal Berlangganan 6 bulan.</li>
            <li>Kerusakan dan penggantian perangkat menjadi tanggung jawab Kami.</li>
            <li>Kerusakan / kehilangan perangkat disebabkan kelalaian pelanggan menjadi tanggung jawab pelanggan
                (penggantian dikenakan biaya).</li>
            <li>Pembayaran biaya berlangganan setiap tanggal <strong>{{ $customer->due_day }}</strong> setiap bulannya.
                Bila melewati jatuh tempo pembayaran, sistem akan mematikan sementara koneksi internet dengan konfirmasi
                terlebih dahulu.</li>
            <li>Pembayaran biaya berlangganan setiap bulannya dapat dilakukan secara online atau via cash ke kantor.
            </li>
        </ul>

        {{-- ── Pernyataan ── --}}
        <div class="agreement">
            Dengan ini Kami menyatakan bahwa informasi yang diberikan adalah benar adanya.
            Kami setuju dan bersedia untuk terikat dengan perjanjian berlangganan serta syarat
            dan ketentuan yang ditetapkan oleh pihak <strong class="app_name">{{ $settings['app_name'] }}</strong>.
        </div>

        {{-- ── Tanda Tangan ── --}}
        <table class="sig-table">
            <tr>
                <td class="sig-role">Pelanggan,</td>
                <td class="sig-role">Petugas,</td>
            </tr>
            <tr>
                <td class="sig-name">Nama Jelas : {{ $customer->name }}</td>
                <td class="sig-name">Nama Jelas : {{ $teknisiName }}</td>
            </tr>
            <tr>
                <td class="sig-date">Tanggal : </td>
                <td class="sig-date">Tanggal : </td>
            </tr>
        </table>

    </div>

</body>

</html>
