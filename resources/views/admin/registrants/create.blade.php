@extends('layouts.admin')

@section('title', 'Tambah Pendaftar - Admin')
@section('page-title', 'Tambah Pendaftar')

@section('content')
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
@endpush

    <div class="page-header">
        <div>
            <h1>Form Pendaftaran Umrah</h1>
            <p>Isi data jamaah dan lihat preview dokumen secara realtime.</p>
        </div>
        <div class="page-header-actions">
            <button type="button" class="btn btn-primary" onclick="printPDF()" id="printPdfBtn" disabled>Cetak PDF</button>
            <a href="{{ route('admin.registrants.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">

        <div>
            <form id="regForm" method="POST" action="{{ route('admin.registrants.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="form-grid" style="display:grid;grid-template-columns:1fr;gap:12px;">
                    <label class="form-group">
                        <span>Paket Umrah</span>
                        <select name="package_option" onchange="updatePreview()">
                            <option value="">-- Pilih Paket --</option>
                            <option value="Double">Double</option>
                            <option value="Triple">Triple</option>
                            <option value="Quad">Quad</option>
                        </select>
                    </label>

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
                        <input type="text" name="passport_issued_date" placeholder="DD/MM/YYYY"
                            class="flatpickr-date" onchange="updatePreview()">
                    </label>

                    <label class="form-group">
                        <span>Tempat Dikeluarkan Paspor</span>
                        <input type="text" name="passport_issued_place" oninput="updatePreview()">
                    </label>

                    <label class="form-group">
                        <span>Tanggal Mulai Berlaku Paspor</span>
                        <input type="text" name="passport_start_date" placeholder="DD/MM/YYYY"
                            class="flatpickr-date" onchange="updatePreview();">
                    </label>

                    <label class="form-group">
                        <span>Tanggal Selesai Berlaku Paspor</span>
                        <input type="text" name="passport_expiry_date" placeholder="DD/MM/YYYY"
                            class="flatpickr-date" onchange="updatePreview();">
                    </label>

                    <label class="form-group">
                        <span>Tempat Lahir</span>
                        <input type="text" name="birth_place" oninput="updatePreview()">
                    </label>
                    <label class="form-group">
                        <span>Tanggal Lahir</span>
                        <input type="text" name="birth_date" placeholder="DD/MM/YYYY"
                            class="flatpickr-date" onchange="updatePreview();">
                    </label>

                    <label class="form-group">
                        <span>Jenis Kelamin</span>
                        <select name="gender" onchange="updatePreview()">
                            <option value="">--</option>
                            <option>Pria</option>
                            <option>Wanita</option>
                        </select>
                    </label>

                    <label class="form-group">
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

                    <label class="form-group" style="grid-column:1;">
                        <span>Kontak Darurat</span>
                        <div id="emergencyContactsContainer"
                            style="border:1px solid #ddd;border-radius:4px;padding:12px;display:grid;gap:16px;">
                            <div class="emergency-contact-item"
                                style="display:grid;gap:8px;grid-template-columns:1fr 1fr 1fr auto;align-items:end;">
                                <label style="display:grid;gap:4px;">
                                    <span style="font-size:11px;font-weight:600">Nama</span>
                                    <input type="text" placeholder="Nama" class="emergency-name"
                                        oninput="updatePreview()"
                                        style="padding:8px;border:1px solid #ddd;border-radius:3px;font-size:13px;">
                                </label>
                                <label style="display:grid;gap:4px;">
                                    <span style="font-size:11px;font-weight:600">Hubungan</span>
                                    <select class="emergency-relation" onchange="updatePreview()"
                                        style="padding:8px;border:1px solid #ddd;border-radius:3px;font-size:13px;">
                                        <option value="">-- Pilih --</option>
                                        <option>Orangtua</option>
                                        <option>Anak</option>
                                        <option>Suami/Istri</option>
                                        <option>Mertua</option>
                                        <option>Saudara Kandung</option>
                                        <option>Teman</option>
                                    </select>
                                </label>
                                <label style="display:grid;gap:4px;">
                                    <span style="font-size:11px;font-weight:600">Nomor HP</span>
                                    <input type="text" placeholder="Nomor HP" class="emergency-phone"
                                        oninput="updatePreview()"
                                        style="padding:8px;border:1px solid #ddd;border-radius:3px;font-size:13px;">
                                </label>
                                <button type="button" onclick="removeEmergencyContact(this)" class="btn btn-danger btn-sm"
                                    style="width:fit-content;margin-bottom:0;">Hapus</button>
                            </div>
                        </div>
                        <button type="button" onclick="addEmergencyContact()" class="btn btn-secondary btn-sm"
                            style="margin-top:8px;">+ Tambah Kontak</button>
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
                        <div style="display:flex;gap:8px;align-items:center;">
                            <span>Ke-</span>
                            <input type="number" name="umrah_experience" value="{{ old('umrah_experience') }}" min="1" oninput="updatePreview()" style="width:100px;">
                        </div>
                    </label>

                    <label class="form-group">
                        <span>Foto Jamaah (opsional)</span>
                        <input type="file" name="photo" accept=".png,.jpg,.jpeg,image/png,image/jpeg" onchange="loadPhotoPreview(event)">
                        <small style="color:#666;display:block;margin-top:4px;">Format: PNG, JPG, JPEG. Maks: 5 MB.</small>
                    </label>

                    <div>
                        <button type="submit" class="btn btn-primary">Simpan Pendaftar</button>
                    </div>
                </div>
                <input type="hidden" name="emergency_contacts" id="emergency_contacts_input">
            </form>

            <form id="previewPostForm" method="POST" action="{{ route('admin.registrants.preview') }}" target="_blank"
                style="display:none;">
                @csrf
                <input type="hidden" name="package_option">
                <input type="hidden" name="name">
                <input type="hidden" name="passport_no">
                <input type="hidden" name="passport_issued_date">
                <input type="hidden" name="passport_issued_place">
                <input type="hidden" name="passport_start_date">
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
            let currentPhotoData = null;

            function getVal(name) {
                const el = document.querySelector('[name="' + name + '"]');
                return el ? el.value : '';
            }

            const DATE_FIELDS = ['passport_issued_date', 'passport_start_date', 'passport_expiry_date', 'birth_date'];

            function dateToBackend(d) {
                if (!d) return '';
                const p = d.split('/');
                return p.length === 3 ? p[2] + '-' + p[1] + '-' + p[0] : d;
            }

            function dateToDisplay(iso) {
                if (!iso) return '';
                const p = iso.split('-');
                return p.length === 3 ? p[2] + '/' + p[1] + '/' + p[0] : iso;
            }

            function convertFormDates() {
                DATE_FIELDS.forEach(function(name) {
                    const el = document.querySelector('[name="' + name + '"]');
                    if (el) el.value = dateToBackend(el.value);
                });
            }

            function restoreDisplayDates() {
                DATE_FIELDS.forEach(function(name) {
                    const el = document.querySelector('[name="' + name + '"]');
                    if (el && el.value && el.value.indexOf('-') > 0) {
                        el.value = dateToDisplay(el.value);
                    }
                });
            }

            function getEmergencyContacts() {
                const items = document.querySelectorAll('.emergency-contact-item');
                const contacts = [];
                items.forEach(item => {
                    const name = item.querySelector('.emergency-name')?.value.trim() || '';
                    const relation = item.querySelector('.emergency-relation')?.value.trim() || '';
                    const phone = item.querySelector('.emergency-phone')?.value.trim() || '';

                    if (name || relation || phone) {
                        contacts.push({
                            name: name,
                            relation: relation,
                            phone: phone
                        });
                    }
                });
                return contacts;
            }

            function addEmergencyContact() {
                const container = document.getElementById('emergencyContactsContainer');
                const item = document.createElement('div');
                item.className = 'emergency-contact-item';
                item.style.cssText = 'display:grid;gap:8px;grid-template-columns:1fr 1fr 1fr auto;align-items:end;';
                item.innerHTML = `
                    <label style="display:grid;gap:4px;">
                        <span style="font-size:11px;font-weight:600">Nama</span>
                        <input type="text" placeholder="Nama" class="emergency-name" oninput="updatePreview()" style="padding:8px;border:1px solid #ddd;border-radius:3px;font-size:13px;">
                    </label>
                    <label style="display:grid;gap:4px;">
                        <span style="font-size:11px;font-weight:600">Hubungan</span>
                        <select class="emergency-relation" onchange="updatePreview()" style="padding:8px;border:1px solid #ddd;border-radius:3px;font-size:13px;">
                            <option value="">-- Pilih --</option>
                            <option>Orangtua</option>
                            <option>Anak</option>
                            <option>Suami/Istri</option>
                            <option>Mertua</option>
                            <option>Saudara Kandung</option>
                            <option>Teman</option>
                        </select>
                    </label>
                    <label style="display:grid;gap:4px;">
                        <span style="font-size:11px;font-weight:600">Nomor HP</span>
                        <input type="text" placeholder="Nomor HP" class="emergency-phone" oninput="updatePreview()" style="padding:8px;border:1px solid #ddd;border-radius:3px;font-size:13px;">
                    </label>
                    <button type="button" onclick="removeEmergencyContact(this)" class="btn btn-danger btn-sm" style="width:fit-content;margin-bottom:0;">Hapus</button>
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
                    passport_issued_date: dateToBackend(getVal('passport_issued_date')),
                    passport_issued_place: getVal('passport_issued_place'),
                    passport_start_date: dateToBackend(getVal('passport_start_date')),
                    passport_expiry_date: dateToBackend(getVal('passport_expiry_date')),
                    birth_place: getVal('birth_place'),
                    birth_date: dateToBackend(getVal('birth_date')),
                    gender: getVal('gender'),
                    address: getVal('address'),
                    job: getVal('job'),
                    phone: getVal('phone'),
                    emergency_contacts: getEmergencyContacts(),
                    mahram_name: getVal('mahram_name'),
                    mahram_relation: getVal('mahram_relation'),
                    umrah_experience: getVal('umrah_experience'),
                    photo_data: currentPhotoData
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
                }).catch(e => console.error('Preview error:', e));
            }

            function submitPreview() {
                const form = document.getElementById('previewPostForm');
                const names = ['package_option', 'name', 'passport_no', 'passport_issued_date', 'passport_issued_place',
                    'passport_start_date', 'passport_expiry_date', 'birth_place', 'birth_date', 'gender', 'address', 'job',
                    'phone', 'mahram_name',
                    'mahram_relation', 'umrah_experience'
                ];
                names.forEach(n => {
                    let v = document.querySelector('[name="' + n + '"]').value || '';
                    if (DATE_FIELDS.includes(n)) v = dateToBackend(v);
                    form.querySelector('[name="' + n + '"]').value = v;
                });
                const emergInput = form.querySelector('[name="emergency_contacts"]');
                emergInput.value = JSON.stringify(getEmergencyContacts());
                form.submit();
            }

            function printPreview() {
                submitPreview();
            }

            function openPDFPreview() {
                // Deprecated - use printPDF instead
            }

            function printPDF() {
                const data = {
                    package_option: getVal('package_option'),
                    name: getVal('name'),
                    passport_no: getVal('passport_no'),
                    passport_issued_date: dateToBackend(getVal('passport_issued_date')),
                    passport_issued_place: getVal('passport_issued_place'),
                    passport_start_date: dateToBackend(getVal('passport_start_date')),
                    passport_expiry_date: dateToBackend(getVal('passport_expiry_date')),
                    birth_place: getVal('birth_place'),
                    birth_date: dateToBackend(getVal('birth_date')),
                    gender: getVal('gender'),
                    address: getVal('address'),
                    job: getVal('job'),
                    phone: getVal('phone'),
                    emergency_contacts: getEmergencyContacts(),
                    mahram_name: getVal('mahram_name'),
                    mahram_relation: getVal('mahram_relation'),
                    umrah_experience: getVal('umrah_experience'),
                    photo_data: currentPhotoData
                };

                doPrintPDF(data);
            }

            function doPrintPDF(data) {
                // Create iframe untuk print
                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                document.body.appendChild(iframe);

                // Save original title
                const originalTitle = document.title;
                const name = data.name || 'Jamaah';
                const safeFileName = `Jamaah_AlAhza_${name}`;

                // Fetch preview dengan data form
                fetch('{{ route('admin.registrants.preview') }}', {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.text())
                    .then(html => {
                        // Write HTML ke iframe
                        iframe.contentDocument.write(html);
                        iframe.contentDocument.close();

                        // Set document title untuk PDF filename
                        document.title = safeFileName;
                        iframe.contentDocument.title = safeFileName;

                        // Wait untuk CSS fully rendered sebelum print
                        setTimeout(() => {
                            iframe.contentWindow.print();
                            // Remove iframe dan restore title setelah print dialog ditutup
                            iframe.contentWindow.onafterprint = function() {
                                try {
                                    document.body.removeChild(iframe);
                                    document.title = originalTitle;
                                } catch (e) {}
                            };
                        }, 1500);
                    })
                    .catch(error => {
                        console.error('Error loading preview:', error);
                        document.title = originalTitle;
                        try {
                            document.body.removeChild(iframe);
                        } catch (e) {}
                    });
            }

            function openPrintPDFPreview() {
                printPDF();
            }

            function loadPhotoPreview(e) {
                const file = e.target.files[0];
                if (!file) return;
                const maxSize = 5 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('Ukuran foto maksimal 5 MB.');
                    e.target.value = '';
                    return;
                }
                const allowedTypes = ['image/png', 'image/jpeg'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format foto harus PNG, JPG, atau JPEG.');
                    e.target.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(event) {
                    currentPhotoData = event.target.result;
                    updatePreview();
                };
                reader.readAsDataURL(file);
            }

            // Add form submit handler to populate emergency_contacts and convert dates
            document.getElementById('regForm').addEventListener('submit', function(e) {
                const emergencyContactsData = getEmergencyContacts();
                document.getElementById('emergency_contacts_input').value = JSON.stringify(emergencyContactsData);
                convertFormDates();
            });

            // Enable Cetak PDF button
            function enablePrintButton() {
                const btn = document.getElementById('printPdfBtn');
                if (btn) {
                    btn.disabled = false;
                }
            }

            // Enable button on any form input
            document.getElementById('regForm').addEventListener('input', enablePrintButton);
            document.getElementById('regForm').addEventListener('change', enablePrintButton);

            // Init flatpickr
            document.querySelectorAll('.flatpickr-date').forEach(function(el) {
                flatpickr(el, {
                    locale: 'id',
                    dateFormat: 'd/m/Y',
                    allowInput: true,
                    onChange: function() { el.dispatchEvent(new Event('change')); }
                });
            });

            // init
            updatePreview();
        </script>
    @endpush

@endsection
