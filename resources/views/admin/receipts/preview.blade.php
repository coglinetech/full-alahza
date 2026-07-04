@php
    $d = $data instanceof \Illuminate\Database\Eloquent\Model ? $data->toArray() : (array) $data;
    $title = 'Kuitansi_' . ($d['payer_name'] ?? 'GustiGlobal');
@endphp
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
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
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9pt;
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
            width: 70px;
            object-fit: contain;
        }

        .company-info {
            text-align: left;
            font-size: 9pt;
            line-height: 1;
        }

        .company-name {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .receipt-title {
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

        .divider {
            border-top: 1.5px solid #111;
            margin-bottom: 12px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .info-table td {
            vertical-align: top;
            padding: 4px 4px;
            font-size: 9pt;
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

        .signature-row {
            display: flex;
            justify-content: flex-end;
            margin-top: 16px;
        }

        .signature-block {
            min-width: 260px;
            padding: 8px 0 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
            text-align: right;
            font-size: 9pt;
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
    @include('admin.receipts.preview-content', ['data' => $data])
</body>

</html>
