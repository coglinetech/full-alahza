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
<style>
    .receipt-preview * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .receipt-preview {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9pt;
        color: #111;
    }

    .receipt-preview .page {
        width: 100%;
        background: white;
        padding: 2mm;
    }

    .receipt-preview .receipt-frame {
        border: 2px solid #111;
        padding: 16px;
        width: 100%;
    }

    .receipt-preview .header {
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 8px;
    }

    .receipt-preview .header-logo img {
        width: 70px;
        object-fit: contain;
    }

    .receipt-preview .company-info {
        text-align: left;
        font-size: 9pt;
        line-height: 1;
    }

    .receipt-preview .company-name {
        font-size: 12pt;
        font-weight: bold;
        margin-bottom: 4px;
    }

    .receipt-preview .receipt-title {
        text-align: center;
        font-size: 11pt;
        font-weight: bold;
        margin: 2px 0 4px;
        background: #FFD700;
        color: #000;
        padding: 4px 0;
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }

    .receipt-preview .divider {
        border-top: 1.5px solid #111;
        margin-bottom: 12px;
    }

    .receipt-preview .info-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .receipt-preview .info-table td {
        vertical-align: top;
        padding: 4px 4px;
        font-size: 9pt;
        line-height: 1;
    }

    .receipt-preview .info-label {
        width: 28%;
        font-weight: bold;
    }

    .receipt-preview .info-sep {
        width: 3%;
        text-align: center;
    }

    .receipt-preview .info-value {
        width: 69%;
    }

    .receipt-preview .info-value-terbilang {
        width: 69%;
        font-weight: bold;
        font-style: italic;
    }

    .receipt-preview .signature-row {
        display: flex;
        justify-content: flex-end;
        margin-top: 16px;
    }

    .receipt-preview .signature-block {
        min-width: 260px;
        padding: 8px 0 0;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        text-align: right;
        font-size: 9pt;
    }

    .receipt-preview .signature-line {
        height: 1px;
        width: 100%;
        background: #111;
        margin: 24px 0 0;
    }

    .receipt-preview .signature-title {
        font-weight: bold;
        margin-bottom: 16px;
    }
</style>
<div class="receipt-preview">
    <div class="page">
        <div class="receipt-frame">
            <div class="header">
                <div class="header-logo">
                    <img src="{{ $logo }}" alt="Logo">
                </div>
                <div class="company-info">
                    <div class="company-name">PT. GUSTI GLOBAL JOURNEY</div>
                    <div style="margin-top:5px;">ASZ Building, Gusti Business District, Dusun Simpar RT. 064 RW. 028,
                    </div>
                    <div style="margin-top:5px;">Desa Panjalu, Kecamatan Panjalu, Kabupaten Ciamis</div>
                    <div style="margin-top:5px;">HP: 0811 2286 9911</div>
                </div>
            </div>

            <div class="receipt-title">KUITANSI PEMBAYARAN</div>
            <div class="divider"></div>
            <table class="info-table">
                {{-- <tr>
                    <td class="info-label">Nomor Kuitansi</td>
                    <td class="info-sep">:</td>
                    <td class="info-value">{{ $displayReceiptNumber }}</td>
                </tr> --}}
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
                    <div>Bagian Keuangan,</div>
                    <div style="margin-top:100px;">PT. GUSTI GLOBAL JOURNEY</div>
                </div>
            </div>
        </div>
    </div>
</div>
