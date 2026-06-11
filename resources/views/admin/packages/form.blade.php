@extends('layouts.admin')

@section('title', (isset($package) ? 'Edit' : 'Tambah') . ' Paket — Al-Ahza Admin')
@section('page-title', isset($package) ? 'Edit Paket' : 'Tambah Paket')
@section('breadcrumb')
    <span class="topbar-breadcrumb-sep">›</span>
    <a href="{{ route('admin.packages.index') }}">Paket Perjalanan</a>
    <span class="topbar-breadcrumb-sep">›</span>
    <span class="topbar-breadcrumb-current">{{ isset($package) ? 'Edit' : 'Tambah' }}</span>
@endsection

@section('content')
<div style="max-width:860px;">
    <div class="page-header">
        <div class="page-header-left">
            <h1>{{ isset($package) ? 'Edit Paket' : 'Tambah Paket Baru' }}</h1>
            <p>{{ isset($package) ? 'Perbarui informasi paket perjalanan.' : 'Isi detail paket perjalanan yang akan ditampilkan di website.' }}</p>
        </div>
        <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ isset($package) ? route('admin.packages.update', $package) : route('admin.packages.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($package)) @method('PUT') @endif

        @if($errors->any())
        <div class="alert alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>
                <strong>Ada kesalahan:</strong>
                <ul style="margin:4px 0 0 16px;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <!-- Informasi Dasar -->
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <div class="card-header-title">Informasi Dasar</div>
            </div>
            <div class="card-body">
                <div class="form-grid form-grid-2">
                    <div class="form-group span-2">
                        <label>Nama Paket <span class="req">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $package->name ?? '') }}"
                               placeholder="contoh: Umroh Reguler Bintang 4" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori <span class="req">*</span></label>
                        <select name="category" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach(\App\Models\Package::categoryLabels() as $val => $label)
                            <option value="{{ $val }}" {{ old('category', $package->category ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Durasi <span class="req">*</span></label>
                        <input type="text" name="duration" value="{{ old('duration', $package->duration ?? '') }}"
                               placeholder="contoh: 9 Hari / 12 Hari" required>
                    </div>
                    <div class="form-group">
                        <label>Harga (Rp) <span class="req">*</span></label>
                        <input type="number" name="price_start" value="{{ old('price_start', $package->price_start ?? '') }}"
                               placeholder="25000000" min="0" required>
                        <div class="form-hint">Masukkan angka saja tanpa titik/koma. contoh: 25000000</div>
                    </div>
                    <div class="form-group">
                        <label>Destinasi Tambahan</label>
                        <input type="text" name="destination" value="{{ old('destination', $package->destination ?? '') }}"
                               placeholder="contoh: Turki, Dubai (opsional)">
                    </div>
                    <div class="form-group">
                        <label>Slug URL <span class="req">*</span></label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $package->slug ?? '') }}"
                               placeholder="umroh-reguler-bintang-4" required>
                        <div class="form-hint">URL paket: /paket/<strong id="slug-preview">{{ $package->slug ?? '...' }}</strong></div>
                    </div>
                    <div class="form-group span-2">
                        <label>Deskripsi</label>
                        <textarea name="description" rows="4" placeholder="Deskripsi lengkap tentang paket ini...">{{ old('description', $package->description ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fasilitas (Highlights) -->
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <div class="card-header-title">Fasilitas yang Termasuk</div>
                <button type="button" onclick="addHighlight()" class="btn btn-secondary btn-sm">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah
                </button>
            </div>
            <div class="card-body">
                <div id="highlights-container">
                    @php $highlights = old('highlights', $package->highlights ?? ['']); @endphp
                    @foreach($highlights as $i => $h)
                    <div class="highlight-row" style="display:flex;gap:8px;margin-bottom:8px;">
                        <input type="text" name="highlights[]" value="{{ $h }}"
                               placeholder="contoh: Pesawat PP langsung"
                               style="flex:1;">
                        <button type="button" onclick="removeHighlight(this)"
                                class="btn btn-danger btn-icon" style="flex-shrink:0;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                    @endforeach
                </div>
                <div class="form-hint" style="margin-top:8px;">Tambahkan fasilitas satu per baris. Tampil sebagai checklist di halaman paket.</div>
            </div>
        </div>

        <!-- Foto Brosur -->
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <div class="card-header-title">Foto / Brosur Paket</div>
            </div>
            <div class="card-body">
                @if(isset($package) && has_media($package->image_path))
                <div style="margin-bottom:16px;">
                    <div class="form-hint" style="margin-bottom:8px;">Foto saat ini:</div>
                    <div class="img-preview-wrap">
                        <img src="{{ media_url($package->image_path) }}" 
                            alt="{{ $package->name }}" 
                            style="max-height:200px;">
                    </div>
                    <div style="margin-top:8px;display:flex;align-items:center;gap:8px;">
                        <label class="toggle">
                            <input type="checkbox" name="remove_image" value="1" id="removeImg">
                            <span class="toggle-slider"></span>
                        </label>
                        <label for="removeImg" style="font-size:13px;color:var(--text-secondary);cursor:pointer;">Hapus foto ini</label>
                    </div>
                </div>
                @endif
                <div class="upload-zone" id="uploadZone">
                    <input type="file" name="image" accept="image/*" onchange="previewImage(this)">
                    <div class="upload-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                    <div class="upload-title">Klik atau drag foto di sini</div>
                    <div class="upload-sub">PNG, JPG, WebP • Maks 2MB • Rasio ideal 3:4 (portrait)</div>
                </div>
                <div id="newPreview" style="margin-top:12px;display:none;">
                    <div class="form-hint" style="margin-bottom:8px;">Preview foto baru:</div>
                    <div class="img-preview-wrap">
                        <img id="newPreviewImg" src="" alt="Preview" style="max-height:200px;">
                        <button type="button" class="img-preview-remove" onclick="clearPreview()">×</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div style="display:flex;gap:12px;justify-content:flex-end;">
            <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                {{ isset($package) ? 'Simpan Perubahan' : 'Tambah Paket' }}
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Auto-generate slug from name
const nameInput = document.querySelector('input[name="name"]');
const slugInput = document.getElementById('slug');
const slugPreview = document.getElementById('slug-preview');
@if(!isset($package))
nameInput.addEventListener('input', function() {
    const slug = this.value.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim();
    slugInput.value = slug;
    slugPreview.textContent = slug || '...';
});
@endif
slugInput.addEventListener('input', function() {
    slugPreview.textContent = this.value || '...';
});

// Highlights
function addHighlight() {
    const container = document.getElementById('highlights-container');
    const row = document.createElement('div');
    row.className = 'highlight-row';
    row.style.cssText = 'display:flex;gap:8px;margin-bottom:8px;';
    row.innerHTML = `
        <input type="text" name="highlights[]" placeholder="contoh: Hotel bintang 4" style="flex:1;">
        <button type="button" onclick="removeHighlight(this)" class="btn btn-danger btn-icon" style="flex-shrink:0;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>`;
    container.appendChild(row);
    row.querySelector('input').focus();
}
function removeHighlight(btn) {
    const rows = document.querySelectorAll('.highlight-row');
    if (rows.length > 1) btn.closest('.highlight-row').remove();
}

// Image preview
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('newPreviewImg').src = e.target.result;
            document.getElementById('newPreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function clearPreview() {
    document.querySelector('input[name="image"]').value = '';
    document.getElementById('newPreview').style.display = 'none';
}
</script>
@endpush