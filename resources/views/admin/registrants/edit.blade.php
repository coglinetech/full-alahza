@extends('layouts.admin')

@section('title', 'Edit Pendaftar - Admin')
@section('page-title', 'Edit Pendaftar')

@section('content')

    <div class="page-header">
        <div>
            <h1>Edit Data Pendaftaran Umrah</h1>
            <p>Update data jamaah dan lihat preview dokumen secara realtime.</p>
        </div>
        <div class="page-header-actions">
            <button type="button" class="btn btn-primary" onclick="printPDF()">Cetak PDF</button>
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
            <form id="regForm" method="POST" action="{{ route('admin.registrants.update', $registrant) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-grid" style="display:grid;grid-template-columns:1fr;gap:12px;">
                    <label class="form-group">
                        <span>Paket Umrah</span>
                        <select name="package_option" onchange="updatePreview()">
                            <option value="">-- Pilih Paket --</option>
                            <option value="Double" {{ $registrant->package_option === 'Double' ? 'selected' : '' }}>Double
                            </option>
                            <option value="Triple" {{ $registrant->package_option === 'Triple' ? 'selected' : '' }}>Triple
                            </option>
                            <option value="Quad" {{ $registrant->package_option === 'Quad' ? 'selected' : '' }}>Quad
                            </option>
                        </select>
                    </label>

                    <label class="form-group">
                        <span>Nama sesuai Paspor</span>
                        <input type="text" name="name" value="{{ $registrant->name }}" oninput="updatePreview()">
                    </label>

                    <label class="form-group">
                        <span>No Paspor</span>
                        <input type="text" name="passport_no" value="{{ $registrant->passport_no }}"
                            oninput="updatePreview()">
                    </label>

                    <label class="form-group">
                        <span>Tanggal Dikeluarkan Paspor</span>
                        <input type="date" name="passport_issued_date"
                            value="{{ $registrant->passport_issued_date?->format('Y-m-d') }}" onchange="updatePreview()">
                    </label>

                    <label class="form-group">
                        <span>Tempat Dikeluarkan Paspor</span>
                        <input type="text" name="passport_issued_place" value="{{ $registrant->passport_issued_place }}"
                            oninput="updatePreview()">
                    </label>

                    <label class="form-group">
                        <span>Tanggal Mulai Berlaku Paspor</span>
                        <input type="date" name="passport_start_date"
                            value="{{ $registrant->passport_start_date?->format('Y-m-d') }}" onchange="updatePreview()">
                    </label>

                    <label class="form-group">
                        <span>Tanggal Selesai Berlaku Paspor</span>
                        <input type="date" name="passport_expiry_date"
                            value="{{ $registrant->passport_expiry_date?->format('Y-m-d') }}" onchange="updatePreview()">
                    </label>

                    <label class="form-group">
                        <span>Tempat Lahir</span>
                        <input type="text" name="birth_place" value="{{ $registrant->birth_place }}"
                            oninput="updatePreview()">
                    </label>
                    <label class="form-group">
                        <span>Tanggal Lahir</span>
                        <input type="date" name="birth_date" value="{{ $registrant->birth_date?->format('Y-m-d') }}"
                            onchange="updatePreview()">
                    </label>

                    <label class="form-group">
                        <span>Jenis Kelamin</span>
                        <select name="gender" onchange="updatePreview()">
                            <option value="">--</option>
                            <option {{ $registrant->gender === 'Pria' ? 'selected' : '' }}>Pria</option>
                            <option {{ $registrant->gender === 'Wanita' ? 'selected' : '' }}>Wanita</option>
                        </select>
                    </label>

                    <label class="form-group">
                        <span>Alamat Domisili</span>
                        <textarea name="address" oninput="updatePreview()">{{ $registrant->address }}</textarea>
                    </label>

                    <label class="form-group">
                        <span>Pekerjaan</span>
                        <input type="text" name="job" value="{{ $registrant->job }}" oninput="updatePreview()">
                    </label>
                    <label class="form-group">
                        <span>No HP (Whatsapp)</span>
                        <input type="text" name="phone" value="{{ $registrant->phone }}" oninput="updatePreview()">
                    </label>

                    <label class="form-group" style="grid-column:1;">
                        <span>Kontak Darurat</span>
                        <div id="emergencyContactsContainer"
                            style="border:1px solid #ddd;border-radius:4px;padding:12px;display:grid;gap:16px;">
                            @if ($registrant->emergency_contacts && count($registrant->emergency_contacts) > 0)
                                @if (
                                    $registrant->emergency_contacts &&
                                        is_array($registrant->emergency_contacts) &&
                                        count($registrant->emergency_contacts) > 0)
                                    @foreach ($registrant->emergency_contacts as $ec)
                                        <div class="emergency-contact-item"
                                            style="display:grid;gap:8px;grid-template-columns:1fr 1fr 1fr auto;align-items:end;">
                                            <label style="display:grid;gap:4px;">
                                                <span style="font-size:11px;font-weight:600">Nama</span>
                                                <input type="text" placeholder="Nama" class="emergency-name"
                                                    value="{{ $ec['name'] ?? '' }}" oninput="updatePreview()"
                                                    style="padding:8px;border:1px solid #ddd;border-radius:3px;font-size:13px;">
                                            </label>
                                            <label style="display:grid;gap:4px;">
                                                <span style="font-size:11px;font-weight:600">Hubungan</span>
                                                <select class="emergency-relation" onchange="updatePreview()"
                                                    style="padding:8px;border:1px solid #ddd;border-radius:3px;font-size:13px;">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Orangtua"
                                                        {{ ($ec['relation'] ?? '') === 'Orangtua' ? 'selected' : '' }}>
                                                        Orangtua
                                                    </option>
                                                    <option value="Anak"
                                                        {{ ($ec['relation'] ?? '') === 'Anak' ? 'selected' : '' }}>Anak
                                                    </option>
                                                    <option value="Suami/Istri"
                                                        {{ ($ec['relation'] ?? '') === 'Suami/Istri' ? 'selected' : '' }}>
                                                        Suami/Istri</option>
                                                    <option value="Mertua"
                                                        {{ ($ec['relation'] ?? '') === 'Mertua' ? 'selected' : '' }}>Mertua
                                                    </option>
                                                    <option value="Saudara Kandung"
                                                        {{ ($ec['relation'] ?? '') === 'Saudara Kandung' ? 'selected' : '' }}>
                                                        Saudara Kandung</option>
                                                    <option value="Teman"
                                                        {{ ($ec['relation'] ?? '') === 'Teman' ? 'selected' : '' }}>Teman
                                                    </option>
                                                </select>
                                            </label>
                                            <label style="display:grid;gap:4px;">
                                                <span style="font-size:11px;font-weight:600">Nomor HP</span>
                                                <input type="text" placeholder="Nomor HP" class="emergency-phone"
                                                    value="{{ $ec['phone'] ?? '' }}" oninput="updatePreview()"
                                                    style="padding:8px;border:1px solid #ddd;border-radius:3px;font-size:13px;">
                                            </label>
                                            <button type="button" onclick="removeEmergencyContact(this)"
                                                class="btn btn-danger btn-sm"
                                                style="width:fit-content;margin-bottom:0;">Hapus</button>
                                        </div>
                                    @endforeach
                                @endif
                            @else
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
                                    <button type="button" onclick="removeEmergencyContact(this)"
                                        class="btn btn-danger btn-sm"
                                        style="width:fit-content;margin-bottom:0;">Hapus</button>
                                </div>
                            @endif
                        </div>
                        <button type="button" onclick="addEmergencyContact()" class="btn btn-secondary btn-sm"
                            style="margin-top:8px;">+ Tambah Kontak</button>
                    </label>

                    <label class="form-group">
                        <span>Nama Mahram/Pendamping</span>
                        <input type="text" name="mahram_name" value="{{ $registrant->mahram_name }}"
                            oninput="updatePreview()">
                    </label>
                    <label class="form-group">
                        <span>Hubungan Mahram</span>
                        <select name="mahram_relation" onchange="updatePreview()">
                            <option value="">-- Pilih --</option>
                            <option {{ $registrant->mahram_relation === 'Orangtua' ? 'selected' : '' }}>Orangtua</option>
                            <option {{ $registrant->mahram_relation === 'Anak' ? 'selected' : '' }}>Anak</option>
                            <option {{ $registrant->mahram_relation === 'Suami/Istri' ? 'selected' : '' }}>Suami/Istri
                            </option>
                            <option {{ $registrant->mahram_relation === 'Mertua' ? 'selected' : '' }}>Mertua</option>
                            <option {{ $registrant->mahram_relation === 'Saudara Kandung' ? 'selected' : '' }}>Saudara
                                Kandung</option>
                        </select>
                    </label>

                    <label class="form-group">
                        <span>Pengalaman Umrah</span>
                        <select name="umrah_experience" onchange="updatePreview()">
                            <option value="">--</option>
                            <option {{ $registrant->umrah_experience === 'Ke-1' ? 'selected' : '' }}>Ke-1</option>
                            <option {{ $registrant->umrah_experience === 'Ke-2' ? 'selected' : '' }}>Ke-2</option>
                            <option {{ $registrant->umrah_experience === 'Ke-3' ? 'selected' : '' }}>Ke-3</option>
                            <option {{ $registrant->umrah_experience === 'Ke-4' ? 'selected' : '' }}>Ke-4</option>
                        </select>
                    </label>

                    <label class="form-group">
                        <span>Foto Jamaah (opsional)</span>
                        @if ($registrant->photo_path)
                            <div style="margin-bottom:8px;font-size:12px;color:#666;">
                                Foto saat ini: <a href="{{ asset('storage/' . $registrant->photo_path) }}"
                                    target="_blank">Lihat</a>
                            </div>
                        @endif
                        <input type="file" name="photo" accept="image/*" onchange="loadPhotoPreview(event)">
                    </label>

                    <div>
                        <button type="submit" class="btn btn-primary">Update Pendaftar</button>
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
                    @include('admin.registrants.preview', ['data' => $registrant])
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            function getVal(name) {
                const el = document.querySelector('[name="' + name + '"]');
                return el ? el.value : '';
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
                    passport_issued_date: getVal('passport_issued_date'),
                    passport_issued_place: getVal('passport_issued_place'),
                    passport_start_date: getVal('passport_start_date'),
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
                    umrah_experience: getVal('umrah_experience'),
                    photo_path: '{{ $registrant->photo_path }}'
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
                    const input = form.querySelector('[name="' + n + '"]');
                    input.value = document.querySelector('[name="' + n + '"]').value || '';
                });
                const emergInput = form.querySelector('[name="emergency_contacts"]');
                emergInput.value = JSON.stringify(getEmergencyContacts());
                form.submit();
            }

            function printPreview() {
                submitPreview();
            }

            function loadPhotoPreview(e) {
                const file = e.target.files[0];
                if (!file) return;
                // Read file as base64 for preview
                const reader = new FileReader();
                reader.onload = function(event) {
                    updatePreviewWithPhoto(event.target.result);
                };
                reader.readAsDataURL(file);
            }

            function updatePreviewWithPhoto(photoData) {
                const data = {
                    package_option: getVal('package_option'),
                    name: getVal('name'),
                    passport_no: getVal('passport_no'),
                    passport_issued_date: getVal('passport_issued_date'),
                    passport_issued_place: getVal('passport_issued_place'),
                    passport_start_date: getVal('passport_start_date'),
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
                    umrah_experience: getVal('umrah_experience'),
                    photo_path: '{{ $registrant->photo_path }}',
                    photo_data: photoData
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

            // Add form submit handler to populate emergency_contacts
            document.getElementById('regForm').addEventListener('submit', function(e) {
                const emergencyContactsData = getEmergencyContacts();
                document.getElementById('emergency_contacts_input').value = JSON.stringify(emergencyContactsData);
            });

            function printPDF() {
                // Create iframe untuk print
                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                document.body.appendChild(iframe);

                // Fetch preview untuk registrant ini
                const previewUrl = '{{ route('admin.registrants.show', $registrant) }}';
                const originalTitle = document.title;
                const name = '{{ $registrant->name ?? 'Jamaah' }}';
                const safeFileName = `Jamaah_AlAhza_${name}`;

                fetch(previewUrl)
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

            // init
            updatePreview();
        </script>
    @endpush

@endsection
