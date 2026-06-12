@php
    $d = $data instanceof \Illuminate\Database\Eloquent\Model ? $data->toArray() : (array) $data;
    $logo = asset('images/logo_formulir.png');

    $displayReceiptNumber = $d['receipt_number'] ?? '-';
    if ($displayReceiptNumber !== '-') {
        if (preg_match('/^\[Nomor\s*0*([0-9]+)\]$/', $displayReceiptNumber, $matches)) {
            $displayReceiptNumber = sprintf('%03d', (int) $matches[1]);
        } elseif (preg_match('/^[0-9]+$/', $displayReceiptNumber)) {
            $displayReceiptNumber = sprintf('%03d', (int) $displayReceiptNumber);
        }
    }

    $formatDateID = function ($dateStr) {
        if (empty($dateStr)) {
            return '-';
        }
        try {
            $date = \Carbon\Carbon::parse($dateStr);
            $months = [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember',
            ];
            return $date->day . ' ' . $months[$date->month - 1] . ' ' . $date->year;
        } catch (\Exception $e) {
            return $dateStr;
        }
    };

    $formatDateWithDay = function ($dateStr) {
        if (empty($dateStr)) {
            return '-';
        }
        try {
            $date = \Carbon\Carbon::parse($dateStr);
            $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $months = [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember',
            ];
            return $days[$date->dayOfWeek] . ', ' . $date->day . ' ' . $months[$date->month - 1] . ' ' . $date->year;
        } catch (\Exception $e) {
            return $dateStr;
        }
    };

    $numberToWords = function ($number) use (&$numberToWords) {
        $number = (int) $number;
        $words = [
            0 => 'nol',
            1 => 'satu',
            2 => 'dua',
            3 => 'tiga',
            4 => 'empat',
            5 => 'lima',
            6 => 'enam',
            7 => 'tujuh',
            8 => 'delapan',
            9 => 'sembilan',
            10 => 'sepuluh',
            11 => 'sebelas',
        ];

        if ($number < 12) {
            return $words[$number];
        }

        if ($number < 20) {
            return $numberToWords($number - 10) . ' belas';
        }

        if ($number < 100) {
            return $numberToWords(floor($number / 10)) .
                ' puluh' .
                ($number % 10 ? ' ' . $numberToWords($number % 10) : '');
        }

        if ($number < 200) {
            return 'seratus' . ($number - 100 ? ' ' . $numberToWords($number - 100) : '');
        }

        if ($number < 1000) {
            return $numberToWords(floor($number / 100)) .
                ' ratus' .
                ($number % 100 ? ' ' . $numberToWords($number % 100) : '');
        }

        if ($number < 2000) {
            return 'seribu' . ($number - 1000 ? ' ' . $numberToWords($number - 1000) : '');
        }

        if ($number < 1000000) {
            return $numberToWords(floor($number / 1000)) .
                ' ribu' .
                ($number % 1000 ? ' ' . $numberToWords($number % 1000) : '');
        }

        if ($number < 1000000000) {
            return $numberToWords(floor($number / 1000000)) .
                ' juta' .
                ($number % 1000000 ? ' ' . $numberToWords($number % 1000000) : '');
        }

        if ($number < 1000000000000) {
            return $numberToWords(floor($number / 1000000000)) .
                ' miliar' .
                ($number % 1000000000 ? ' ' . $numberToWords($number % 1000000000) : '');
        }

        return $numberToWords(floor($number / 1000000000000)) .
            ' triliun' .
            ($number % 1000000000000 ? ' ' . $numberToWords($number % 1000000000000) : '');
    };

    $rawAmount = preg_replace('/[^0-9]/', '', $d['amount_text'] ?? '');
    $amountValue = $rawAmount === '' ? 0 : (int) $rawAmount;
    $terbilang = $amountValue > 0 ? ucfirst(trim($numberToWords($amountValue))) . ' Rupiah' : '-';
@endphp
<html lang="id">

<head>
    <title>Kuitansi_{{ $d['payer_name'] ?? 'GustiGlobal' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4;
            margin: 10mm;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
            background: #f5f5f5;
            font-family: 'Times New Roman', Times, serif;
            color: #111;
        }

        body {
            padding: 0;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            background: white;
            margin: 6mm auto;
            padding: 2mm;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.08);
        }

        .receipt-frame {
            border: 2px solid #111;
            padding: 20px;
            width: 100%;
        }

        .header {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 10px;
        }

        .header-logo img {
            width: 80px;
            object-fit: contain;
        }

        .company-info {
            text-align: left;
            font-size: 10pt;
            line-height: 1;
        }

        .company-name {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .receipt-title {
            text-align: center;
            font-size: 18pt;
            font-weight: bold;
            margin: 16px 0 6px;
        }

        .divider {
            border-top: 1.8px solid #111;
            margin-bottom: 18px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .info-table td {
            vertical-align: top;
            padding: 6px 4px;
            font-size: 11pt;
            line-height: 1;
        }

        .info-label {
            width: 28%;
            font-weight: bold;
        }

        .info-sep {
            width: 3%;
            text-align: center;
        }

        .info-value {
            width: 69%;
        }

        .info-value-terbilang {
            width: 69%;
            font-weight: bold;
            font-style: italic;
        }

        .align-right {
            text-align: right;
        }

        .footer {
            width: 100%;
            margin-top: 34px;
            display: flex;
            justify-content: flex-end;
            font-size: 11pt;
            line-height: 1.6;
        }

        .signature-row {
            display: flex;
            justify-content: flex-end;
            margin-top: 16px;
        }

        .signature-block {
            min-width: 260px;
            padding: 12px 0 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
            text-align: right;
            font-size: 11pt;
        }

        .signature-line {
            height: 1px;
            width: 100%;
            background: #111;
            margin: 24px 0 0;
        }

        .signature-title {
            font-weight: bold;
            margin-bottom: 16px;
        }

        @media print {

            html,
            body {
                background: transparent;
                margin: 0;
            }

            .page {
                box-shadow: none;
                margin: 0;
                padding: 0mm;
            }

            .header,
            .footer {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="receipt-frame">
            <div class="header">
                <div class="header-logo">
                    <img src="{{ $logo }}" alt="Logo">
                </div>
                <div class="company-info">
                    <div class="company-name">PT. GUSTI GLOBAL JOURNEY</div>
                    <div>ASZ Building, Gusti Business District, Dusun Simpar RT. 064 RW. 028,</div>
                    <div>Desa Panjalu,
                        Kecamatan
                        Panjalu, Kabupaten Ciamis</div>
                    <div style="margin-top:8px; font-weight:600;">HP: 0811 2286 9911</div>
                </div>
            </div>

            <div class="receipt-title">KUITANSI PEMBAYARAN</div>
            <div class="divider"></div>
            <table class="info-table">
                <tr>
                    <td class="info-label">Nomor Kuitansi</td>
                    <td class="info-sep">:</td>
                    <td class="info-value">{{ $displayReceiptNumber }}</td>
                </tr>
                <tr>
                    <td class="info-label">Tanda Terima Dari</td>
                    <td class="info-sep">:</td>
                    <td class="info-value">{{ $d['payer_name'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Uang Sejumlah</td>
                    <td class="info-sep">:</td>
                    <td class="info-value">{{ $d['amount_text'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Untuk Pembayaran</td>
                    <td class="info-sep">:</td>
                    <td class="info-value">{{ $d['description'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Harga Paket</td>
                    <td class="info-sep">:</td>
                    <td class="info-value">{{ $d['package_price'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Uang Terbilang</td>
                    <td class="info-sep">:</td>
                    <td class="info-value-terbilang">{{ $terbilang }}</td>
                </tr>
            </table>

            <div class="signature-row">
                <div class="signature-block">
                    <div>{{ $formatDateWithDay($d['receipt_date'] ?? null) }}</div>
                    <div style="margin-top:12px;">Bagian Keuangan,</div>
                    <div style="margin-top:48px;">PT. GUSTI GLOBAL JOURNEY</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
