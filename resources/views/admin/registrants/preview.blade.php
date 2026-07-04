@php
    // Normalize data (array or model)
    $d = is_object($data) ? (array) $data : (array) $data;
    $settings = [];
    try {
        if (class_exists(\App\Models\SiteSetting::class)) {
            $s = \App\Models\SiteSetting::first();
            if ($s) {
                $settings['app_logo'] = $s->logo ?? null;
                $settings['app_name'] = $s->site_name ?? 'Al-Ahza';
                $settings['app_address'] = $s->address ?? null;
                $settings['app_phone'] = $s->phone ?? null;
            }
        }
    } catch (\Throwable $e) {
        // ignore
    }
    $logo = asset('images/logo_formulir.png');

    $photoUrl = null;
    // Priority: photo_data (base64) > photo_path (existing) > none
    if (!empty($d['photo_data']) && strpos($d['photo_data'], 'data:image') === 0) {
        $photoUrl = $d['photo_data'];
    } elseif (!empty($d['photo_path'])) {
        $photoUrl = asset('storage/' . ltrim($d['photo_path'], '/'));
    }

    $emergencies = [];
    if (!empty($d['emergency_contacts'])) {
        if (is_string($d['emergency_contacts'])) {
            $decoded = json_decode($d['emergency_contacts'], true);
            $emergencies = is_array($decoded) ? $decoded : [];
        } elseif (is_array($d['emergency_contacts'])) {
            $emergencies = $d['emergency_contacts'];
        }
    }

    // Function to format date to Indonesian
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

    $formatYear = function ($dateStr) {
        if (empty($dateStr)) {
            return '-';
        }
        try {
            return \Carbon\Carbon::parse($dateStr)->year;
        } catch (\Exception $e) {
            return '-';
        }
    };
@endphp

<title>Jamaah_AlAhza_{{ $d['name'] ?? 'Jamaah' }}</title>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    @page {
        size: A4;
        margin: 7mm;
    }

    html,
    body {
        width: 100%;
        height: 100%;
    }

    body {
        font-family: 'Times New Roman', Times, serif;
        font-size: 12pt;
        color: #111;
        background: #f5f5f5;
    }

    .page {
        width: 210mm;
        min-height: 297mm;
        background: #fff;
        padding: 10mm;
        margin: 5px auto;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .header {
        display: flex;
        gap: 15px;
        align-items: flex-start;
        justify-content: space-between;
        padding-bottom: 8px;
        margin-bottom: 10px;
        border-bottom: 2px solid #ddd;
    }

    .header-left {
        flex: 0 0 auto;
    }

    .header-right {
        flex: 0 0 auto;
    }

    .header-logo img {
        width: 150px;
        height: 150px;
        object-fit: contain;
    }

    .header-text .company-name {
        font-family: Arial, Helvetica, sans-serif;
        font-weight: 700;
        font-size: 12pt;
    }

    .form-title {
        text-align: center;
        font-weight: 700;
        margin: 8px 0 6px;
        text-decoration: underline;
        font-size: 14pt;
        letter-spacing: 0.5px;
    }

    .section-title {
        font-weight: 700;
        color: #000;
        background: #87CEEB;
        margin: 8px 0 4px;
        padding: 2px 8px;
        display: block;
        width: 100%;
        font-size: 12.5pt;
        border-radius: 2px;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 3px;
        table-layout: fixed;
    }

    .info-table td {
        padding: 2px 4px;
        vertical-align: top;
        font-size: 11pt;
        line-height: 1.3;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .info-table .label {
        width: 38%;
        font-weight: 500;
    }

    .info-table .separator {
        width: 2%;
        text-align: center;
        white-space: nowrap;
        padding: 4px 2px;
    }

    .notes-list {
        list-style: decimal inside;
        padding-left: 8px;
        margin: 4px 0;
        font-weight: bold;
    }

    .notes-list li {
        padding: 1px 0;
        font-size: 11pt;
    }

    .no-print {
        display: block;
    }

    .nested-row {
        padding-left: 24px;
        font-size: 10.5pt;
    }

    .package-section {
        margin-bottom: 4px;
        font-size: 11.5pt;
    }

    .package-label {
        font-weight: 600;
        display: inline-block;
        margin-right: 12px;
    }

    .package-boxes {
        display: none;
    }

    .package-value {
        font-weight: 500;
        display: inline-block;
    }

    .package-box {
        padding: 6px 12px;
        border: 1.5px solid #666;
        border-radius: 3px;
        font-weight: 600;
        text-align: center;
        min-width: 70px;
        background: #fff;
    }

    .package-box.selected {
        background: #87CEEB;
        color: #000;
        border-color: #0066cc;
    }

    .package-box.unselected {
        background: #fff;
        color: #666;
    }

    @media print {

        html,
        body {
            background: transparent;
            margin: 0;
            padding: 0;
        }

        .page {
            width: 100%;
            height: auto;
            min-height: 100%;
            margin: 0;
            padding: 7mm;
            box-shadow: none;
            page-break-after: always;
            background: white;
        }

        .no-print {
            display: none !important;
        }

        /* Ensure all colors and styles are preserved for print */
        * {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .section-title {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .package-box.selected {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
</style>
</head>

<body>

    <div class="page">
        <div class="header">
            <div class="header-left">
                <div class="header-logo">
                    <img src="{{ $logo }}" alt="logo">
                </div>
            </div>
            @if ($photoUrl)
                <div class="header-right">
                    <img src="{{ $photoUrl }}" alt="photo"
                        style="height:180px;width:155px;object-fit:cover;border:1px solid #999;border-radius:2px">
                </div>
            @endif
        </div>

        <div class="form-title">FORM PENDAFTARAN UMRAH</div>

        <div class="section-title">A. PAKET PILIHAN</div>
        <div class="package-section">
            <span class="package-label">PAKET UMRAH:</span>
            <span class="package-value">{{ $d['package_option'] ?? '-' }}</span>
        </div>

        <div class="section-title">B. DATA JAMAAH UMRAH</div>
        <table class="info-table">
            <tr>
                <td class="label"><strong>1. Nama sesuai Paspor</strong></td>
                <td class="separator">:</td>
                <td class="value">{{ $d['name'] ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="3" class="label" style="font-weight:600"><strong>2. Data Paspor</strong></td>
            </tr>
            <tr>
                <td style="padding-left:24px">No Paspor</td>
                <td class="separator">:</td>
                <td>{{ $d['passport_no'] ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding-left:24px">Tanggal dikeluarkan</td>
                <td class="separator">:</td>
                <td>{{ $formatDateID($d['passport_issued_date'] ?? null) }}</td>
            </tr>
            <tr>
                <td style="padding-left:24px">Tempat dikeluarkan</td>
                <td class="separator">:</td>
                <td>{{ $d['passport_issued_place'] ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding-left:24px">Masa berlaku</td>
                <td class="separator">:</td>
                <td>Tahun {{ $formatYear($d['passport_start_date'] ?? null) }} s/d tahun
                    {{ $formatYear($d['passport_expiry_date'] ?? null) }}</td>
            </tr>
            <tr>
                <td class="label"><strong>3. Tempat & Tanggal Lahir</strong> </td>
                <td class="separator">:</td>
                <td class="value">{{ $d['birth_place'] ?? '-' }}, {{ $formatDateID($d['birth_date'] ?? null) }}</td>
            </tr>
            <tr>
                <td class="label"><strong>4. Jenis Kelamin</strong></td>
                <td class="separator">:</td>
                <td class="value">{{ $d['gender'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label"><strong>5. Alamat Domisili</strong></td>
                <td class="separator">:</td>
                <td class="value">{{ $d['address'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label"><strong>6. Pekerjaan</strong> </td>
                <td class="separator">:</td>
                <td class="value">{{ $d['job'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label"><strong>7. No HP (Whatsapp)</strong></td>
                <td class="separator">:</td>
                <td class="value">{{ $d['phone'] ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="3" class="label" style="font-weight:600"><strong>8. No Darurat</strong> </td>
            </tr>
        </table>
        <table class="info-table">
            @if (!empty($emergencies))
                @foreach ($emergencies as $idx => $e)
                    <tr>
                        <td class="label" style="padding-left:24px">Kontak Darurat {{ $idx + 1 }}</td>
                        <td class="separator">:</td>
                        <td class="value">
                            @if (is_array($e))
                                {{ $e['name'] ?? '-' }} ({{ $e['phone'] ?? '-' }}) / {{ $e['relation'] ?? '-' }}
                            @else
                                {{ $e }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" class="nested-row">-</td>
                </tr>
            @endif
        </table>
        <table class="info-table">
            <tr>
                <td class="label"><strong>9. Nama Mahram/Pendamping</strong></td>
                <td class="separator">:</td>
                <td class="value">{{ $d['mahram_name'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label"><strong>10. Hubungan Mahram</strong></td>
                <td class="separator">:</td>
                <td class="value">{{ $d['mahram_relation'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label"><strong>11. Pengalaman Umrah</strong></td>
                <td class="separator">:</td>
                <td class="value">{{ $d['umrah_experience'] ?? '-' }}</td>
                <td class="value">{{ !empty($d['umrah_experience']) ? (is_numeric($d['umrah_experience']) ? 'Ke-' . $d['umrah_experience'] : $d['umrah_experience']) : '-' }}</td>
            </tr>
        </table>

        <div class="section-title">C. DOKUMEN YANG PERLU DIPERSIAPKAN</div>
        <ol class="notes-list">
            <li>KTP</li>
            <li>KK</li>
            <li>Paspor</li>
            <li>Vaksin Polio & Meningitis</li>
        </ol>
    </div>
</body>

</html>
