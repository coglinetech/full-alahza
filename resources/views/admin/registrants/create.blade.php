@extends('layouts.admin')

@section('title', 'Tambah Pendaftar - Admin')
@section('page-title', 'Tambah Pendaftar')

@section('content')

<div class="page-header">
    <div>
        <h1>Form Pendaftaran Umrah</h1>
        <p>Isi data jamaah dan lihat preview dokumen secara realtime.</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.registrants.index') }}" class="btn btn-ghost">Kembali</a>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

    <div>
        <form id="regForm" method="POST" action="{{ route('admin.registrants.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-grid">
                <div class="form-group span-2">
                    <span>PAKET UMRAH</span>
                    <div style="display:flex;gap:12px;margin-top:6px">
                        <label style="display:flex;align-items:center;gap:6px;font-weight:normal">
                            <input type="radio" name="package_option" value="Double" onchange="updatePreview()"> Double
                        </label>
                        <label style="display:flex;align-items:center;gap:6px;font-weight:normal">
                            <input type="radio" name="package_option" value="Triple" onchange="updatePreview()"> Triple
                        </label>
                        <label style="display:flex;align-items:center;gap:6px;font-weight:normal">
                            <input type="radio" name="package_option" value="Quad" onchange="updatePreview()"> Quad
                        </label>
                    </div>
                </div>

                <label class="form-group">
                    <span>Nama sesuai Paspor</span>
                    <input type="text" name="name" value="{{ old('name') }}" oninput="updatePreview()">
                </label>

                <label class="form-group">
                    <span>No Paspor</span>
                    <input type="text" name="passport_no" oninput="updatePreview()">
                </label>

                <label class="form-group">
                    <span>Tanggal Dikeluarkan Paspor</span>
                    <input type="date" name="passport_issued_date" onchange="updatePreview()">
                </label>

                <label class="form-group">
                    <span>Tempat Dikeluarkan Paspor</span>
                    <input type="text" name="passport_issued_place" oninput="updatePreview()">
                </label>

                <label class="form-group">
                    <span>Masa Berlaku Paspor (s/d)</span>
                    <input type="date" name="passport_expiry_date" onchange="updatePreview()">
                </label>

                <label class="form-group">
                    <span>Tempat Lahir</span>
                    <input type="text" name="birth_place" oninput="updatePreview()">
                </label>
                <label class="form-group">
                    <span>Tanggal Lahir</span>
                    <input type="date" name="birth_date" onchange="updatePreview()">
                </label>

                <label class="form-group">
                    <span>Jenis Kelamin</span>
                    <select name="gender" onchange="updatePreview()"><option value="">--</option><option>Pria</option><option>Wanita</option></select>
                </label>

                <label class="form-group span-2">
                    <span>Alamat Domisili</span>
                    <textarea name="address" oninput="updatePreview()"></textarea>
                </label>

                <label class="form-group">
                    <span>Pekerjaan</span>
                    <input type="text" name="job" oninput="updatePreview()">
                </label>
                <label class="form-group">
                    <span>No HP (Whatsapp)</span>
                    <input type="text" name="phone" oninput="updatePreview()">
                </label>

                <label class="form-group span-2">
                    <span>Kontak Darurat</span>
                    <div id="emergencyContactsContainer" style="border:1px solid #ddd;border-radius:4px;padding:12px;">
                        <div class="emergency-contact-item" style="display:grid;gap:8px;margin-bottom:12px">
                            <input type="text" placeholder="Nama / Hubungan / Nomor (pisahkan dengan /)" class="emergency-contact-input" oninput="updatePreview()" style="padding:8px;border:1px solid #ddd;border-radius:3px">
                            <button type="button" onclick="removeEmergencyContact(this)" class="btn btn-danger btn-sm" style="width:fit-content">Hapus</button>
                        </div>
                    </div>
                    <button type="button" onclick="addEmergencyContact()" class="btn btn-secondary btn-sm" style="margin-top:8px">+ Tambah Kontak Darurat</button>
                </label>

                <label class="form-group">
                    <span>Nama Mahram/Pendamping</span>
                    <input type="text" name="mahram_name" oninput="updatePreview()">
                </label>
                <label class="form-group">
                    <span>Hubungan Mahram</span>
                    <select name="mahram_relation" onchange="updatePreview()">
                        <option value="">-- Pilih --</option>
                        <option>Orangtua</option>
                        <option>Anak</option>
                        <option>Suami/Istri</option>
                        <option>Mertua</option>
                        <option>Saudara Kandung</option>
                    </select>
                </label>

                <label class="form-group">
                    <span>Pengalaman Umrah</span>
                    <select name="umrah_experience" onchange="updatePreview()">
                        <option value="">--</option>
                        <option>Ke-1</option>
                        <option>Ke-2</option>
                        <option>Ke-3</option>
                        <option>Ke-4</option>
                    </select>
                </label>

                <label class="form-group">
                    <span>Foto Jamaah (opsional)</span>
                    <input type="file" name="photo" accept="image/*" onchange="loadPhotoPreview(event)">
                </label>

                <div>
                    <button type="button" class="btn btn-secondary" onclick="submitPreview()">Buka Preview (tab baru)</button>
                    <button type="button" class="btn btn-ghost" onclick="printPreview()">Print / Download PDF</button>
                    <button type="submit" class="btn btn-primary">Simpan Pendaftar</button>
                </div>
            </div>
        </form>

        <form id="previewPostForm" method="POST" action="{{ route('admin.registrants.preview') }}" target="_blank" style="display:none;">
            @csrf
            <input type="hidden" name="package_option">
            <input type="hidden" name="name">
            <input type="hidden" name="passport_no">
            <input type="hidden" name="passport_issued_date">
            <input type="hidden" name="passport_issued_place">
            <input type="hidden" name="passport_expiry_date">
            <input type="hidden" name="birth_place">
            <input type="hidden" name="birth_date">
            <input type="hidden" name="gender">
            <input type="hidden" name="address">
            <input type="hidden" name="job">
            <input type="hidden" name="phone">
            <input type="hidden" name="emergency_contacts">
            <input type="hidden" name="mahram_name">
            <input type="hidden" name="mahram_relation">
            <input type="hidden" name="umrah_experience">
        </form>
    </div>

    <div>
        <div class="card">
            <div class="card-body" id="previewArea" style="min-height:400px;">
                @include('admin.registrants.preview', ['data' => []])
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
function getVal(name) {
    const el = document.querySelector('[name="'+name+'"]');
    return el ? el.value : '';
}

function getEmergencyContacts() {
    const items = document.querySelectorAll('.emergency-contact-input');
    const contacts = [];
    items.forEach(item => {
        const val = item.value.trim();
        if (val) contacts.push(val);
    });
    return contacts;
}

function addEmergencyContact() {
    const container = document.getElementById('emergencyContactsContainer');
    const item = document.createElement('div');
    item.className = 'emergency-contact-item';
    item.style.cssText = 'display:grid;gap:8px;margin-bottom:12px';
    item.innerHTML = `
        <input type="text" placeholder="Nama / Hubungan / Nomor (pisahkan dengan /)" class="emergency-contact-input" oninput="updatePreview()" style="padding:8px;border:1px solid #ddd;border-radius:3px">
        <button type="button" onclick="removeEmergencyContact(this)" class="btn btn-danger btn-sm" style="width:fit-content">Hapus</button>
    `;
    container.appendChild(item);
}

function removeEmergencyContact(btn) {
    btn.parentElement.remove();
    updatePreview();
}

function updatePreview() {
    const data = {
        package_option: getVal('package_option'),
        name: getVal('name'),
        passport_no: getVal('passport_no'),
        passport_issued_date: getVal('passport_issued_date'),
        passport_issued_place: getVal('passport_issued_place'),
        passport_expiry_date: getVal('passport_expiry_date'),
        birth_place: getVal('birth_place'),
        birth_date: getVal('birth_date'),
        gender: getVal('gender'),
        address: getVal('address'),
        job: getVal('job'),
        phone: getVal('phone'),
        emergency_contacts: getEmergencyContacts(),
        mahram_name: getVal('mahram_name'),
        mahram_relation: getVal('mahram_relation'),
        umrah_experience: getVal('umrah_experience')
    };

    fetch('{{ route('admin.registrants.preview') }}', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(r => r.text()).then(html => {
        document.getElementById('previewArea').innerHTML = html;
    });
}

function submitPreview() {
    const form = document.getElementById('previewPostForm');
    const names = ['package_option','name','passport_no','passport_issued_date','passport_issued_place','passport_expiry_date','birth_place','birth_date','gender','address','job','phone','mahram_name','mahram_relation','umrah_experience'];
    names.forEach(n => {
        const input = form.querySelector('[name="'+n+'"]');
        input.value = document.querySelector('[name="'+n+'"]').value || '';
    });
    const emergInput = form.querySelector('[name="emergency_contacts"]');
    emergInput.value = JSON.stringify(getEmergencyContacts());
    form.submit();
}

function printPreview() {
    const w = window.open();
    w.document.write(document.getElementById('previewArea').innerHTML);
    w.document.close();
    w.focus();
    w.print();
}

function loadPhotoPreview(e){
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev){
        const img = document.createElement('img'); img.src = ev.target.result; img.style.maxWidth='120px'; img.style.maxHeight='140px';
        const area = document.getElementById('previewArea');
        const holder = area.querySelector('.photo-holder');
        if (holder) holder.innerHTML = ''; else {
            const h = document.createElement('div'); h.className='photo-holder'; area.prepend(h);
        }
        area.querySelector('.photo-holder').appendChild(img);
    }
    reader.readAsDataURL(file);
}

// init
updatePreview();
</script>
@endpush

@endsection
