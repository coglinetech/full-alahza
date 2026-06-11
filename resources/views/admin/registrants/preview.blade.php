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
    $logo = !empty($settings['app_logo']) ? asset('storage/' . ltrim($settings['app_logo'], '/')) : asset('images/logo.png');

    $photoUrl = null;
    if (!empty($d['photo_path'])) {
        $photoUrl = asset('storage/' . ltrim($d['photo_path'], '/'));
    }

    $emergencies = [];
    if (!empty($d['emergency_contacts'])) {
        if (is_array($d['emergency_contacts'])) $emergencies = $d['emergency_contacts'];
        else $emergencies = preg_split('/\r?\n/', $d['emergency_contacts']);
    }
@endphp

<!doctype html>
<div>
    <style>
        @page { size: A4; margin: 10mm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; color:#111; }
        .page { width:210mm; min-height:297mm; background:#fff; padding:10mm; }
        .header { display:flex; gap:12px; align-items:center; padding-bottom:8px; margin-bottom:12px; }
        .header-logo img{width:60px;height:60px;object-fit:contain}
        .header-text .company-name{font-family:Arial,Helvetica,sans-serif;font-weight:700;font-size:12pt}
        .form-title{text-align:center;font-weight:700;margin:12px 0;text-decoration:underline;font-size:13pt}
        .section-title{font-weight:700;color:#000;background:#4a90e2;margin:12px 0 8px;padding:6px 8px;display:inline-block;min-width:200px}
        .info-table{width:100%;border-collapse:collapse;margin-bottom:8px}
        .info-table td{padding:4px 6px;vertical-align:top}
        .info-table .label{width:38%;font-weight:600}
        .info-table .separator{width:3%;text-align:center}
        .notes-list{list-style:none;padding-left:0}
        .notes-list li{padding:3px 0 3px 16px;position:relative}
        .notes-list li::before{content:'•';position:absolute;left:4px}
        .no-print{display:block}
        .nested-row{padding-left:24px;font-size:10.5pt}
        .checkbox-group{display:flex;gap:12px;margin-bottom:8px}
        .checkbox-item{display:flex;align-items:center;gap:6px}
        .checkbox-item input{width:14px;height:14px}
    </style>

    <div class="print-toolbar no-print" style="position:fixed;top:16px;right:16px;z-index:120">
        <a href="{{ route('admin.registrants.index') }}" class="btn-back" style="margin-right:8px;padding:8px 12px;background:#f1f5f9;border:1px solid #e2e8f0;text-decoration:none;color:#333">Kembali</a>
        <button onclick="window.print()" class="btn-print" style="padding:8px 12px;background:#ea580c;color:#fff;border:0">Cetak / Simpan PDF</button>
    </div>

    <div class="page">
        <div class="header">
            <div class="header-logo">
                <img src="{{ $logo }}" alt="logo">
            </div>
            @if($photoUrl)
                <div style="margin-left:auto">
                    <img src="{{ $photoUrl }}" alt="photo" style="height:80px;width:60px;object-fit:cover;border:1px solid #999;border-radius:2px">
                </div>
            @endif
        </div>

        <div class="form-title">FORM PENDAFTARAN UMRAH</div>

        <div class="section-title">A. PAKET PILIHAN</div>
        <div class="checkbox-group">
            <div class="checkbox-item">
                <input type="checkbox" {{ ($d['package_option'] ?? '') === 'Double' ? 'checked' : '' }}>
                <span>Double</span>
            </div>
            <div class="checkbox-item">
                <input type="checkbox" {{ ($d['package_option'] ?? '') === 'Triple' ? 'checked' : '' }}>
                <span>Triple</span>
            </div>
            <div class="checkbox-item">
                <input type="checkbox" {{ ($d['package_option'] ?? '') === 'Quad' ? 'checked' : '' }}>
                <span>Quad</span>
            </div>
        </div>

        <div class="section-title">B. DATA JAMAAH UMRAH</div>
        <table class="info-table">
            <tr><td class="label">1. Nama sesuai Paspor</td><td class="separator">:</td><td class="value">{{ $d['name'] ?? '-' }}</td></tr>
            <tr><td colspan="3" class="label" style="font-weight:600">2. Data Paspor:</td></tr>
            <tr><td colspan="3" class="nested-row">No Paspor: {{ $d['passport_no'] ?? '-' }}</td></tr>
            <tr><td colspan="3" class="nested-row">Tanggal dikeluarkan: {{ $d['passport_issued_date'] ?? '-' }}</td></tr>
            <tr><td colspan="3" class="nested-row">Tempat dikeluarkan: {{ $d['passport_issued_place'] ?? '-' }}</td></tr>
            <tr><td colspan="3" class="nested-row">Masa berlaku: {{ ($d['passport_expiry_date'] ?? '-') }} s/d {{ ($d['passport_expiry_date'] ?? '-') }}</td></tr>
            <tr><td class="label">3. Tempat & Tanggal Lahir</td><td class="separator">:</td><td class="value">{{ $d['birth_place'] ?? '-' }} / {{ $d['birth_date'] ?? '-' }}</td></tr>
            <tr><td class="label">4. Jenis Kelamin</td><td class="separator">:</td><td class="value">{{ $d['gender'] ?? '-' }}</td></tr>
            <tr><td class="label">5. Alamat Domisili</td><td class="separator">:</td><td class="value">{{ $d['address'] ?? '-' }}</td></tr>
            <tr><td class="label">6. Pekerjaan</td><td class="separator">:</td><td class="value">{{ $d['job'] ?? '-' }}</td></tr>
            <tr><td class="label">7. No HP (Whatsapp)</td><td class="separator">:</td><td class="value">{{ $d['phone'] ?? '-' }}</td></tr>
            <tr><td colspan="3" class="label" style="font-weight:600">8. No Darurat:</td></tr>
        </table>
        <table class="info-table">
            @if(!empty($emergencies))
                @foreach($emergencies as $idx => $e)
                <tr><td colspan="3" class="nested-row">{{ $idx + 1 }}. {{ $e }}</td></tr>
                @endforeach
            @else
                <tr><td colspan="3" class="nested-row">-</td></tr>
            @endif
        </table>
        <table class="info-table">
            <tr><td class="label">9. Nama Mahram/Pendamping</td><td class="separator">:</td><td class="value">{{ $d['mahram_name'] ?? '-' }}</td></tr>
            <tr><td class="label">10. Hubungan Mahram</td><td class="separator">:</td><td class="value">{{ $d['mahram_relation'] ?? '-' }}</td></tr>
            <tr><td class="label">11. Pengalaman Umrah</td><td class="separator">:</td><td class="value">{{ $d['umrah_experience'] ?? '-' }}</td></tr>
        </table>

        <div class="section-title">C. DOKUMEN YANG PERLU DIPERSIAPKAN</div>
        <ol class="notes-list">
            <li>KTP</li>
            <li>KK</li>
            <li>Paspor</li>
            <li>Vaksin Polio & Meningitis</li>
        </ol>
    </div>
</div>
