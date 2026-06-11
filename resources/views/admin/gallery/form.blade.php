@extends('layouts.admin')

@section('title', (isset($image) ? 'Edit' : 'Upload') . ' Foto Galeri — Al-Ahza Admin')
@section('page-title', isset($image) ? 'Edit Foto' : 'Upload Foto')
@section('breadcrumb')
    <span class="topbar-breadcrumb-sep">›</span>
    <a href="{{ route('admin.gallery.index') }}">Galeri</a>
    <span class="topbar-breadcrumb-sep">›</span>
    <span class="topbar-breadcrumb-current">{{ isset($image) ? 'Edit' : 'Upload' }}</span>
@endsection

@section('content')
<div style="max-width:620px;">
    <div class="page-header">
        <div class="page-header-left">
            <h1>{{ isset($image) ? 'Edit Foto Galeri' : 'Upload Foto Galeri' }}</h1>
            <p>{{ isset($image) ? 'Perbarui foto dan informasinya.' : 'Upload foto baru untuk ditampilkan di galeri website.' }}</p>
        </div>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ isset($image) ? route('admin.gallery.update', $image) : route('admin.gallery.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($image)) @method('PUT') @endif

        @if($errors->any())
        <div class="alert alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div><ul style="margin:0 0 0 16px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        </div>
        @endif

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><div class="card-header-title">Foto</div></div>
            <div class="card-body">
                @if(isset($image) && $image->image_path)
                <div style="margin-bottom:16px;">
                    <div class="form-hint" style="margin-bottom:8px;">Foto saat ini:</div>
                    <div class="img-preview-wrap">
                        <img src="{{ media_url($image->image_path) }}" alt="{{ $image->caption }}" style="max-height:200px;">
                    </div>
                </div>
                @endif

                <div class="upload-zone">
                    <input type="file" name="image" accept="image/*" onchange="previewImage(this)"
                           {{ !isset($image) ? 'required' : '' }}>
                    <div class="upload-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                    <div class="upload-title">{{ isset($image) ? 'Ganti foto (opsional)' : 'Klik atau drag foto di sini' }}</div>
                    <div class="upload-sub">PNG, JPG, WebP • Maks 10MB • Rasio 3:2 atau 1200x800</div>
                </div>

                <div id="newPreview" style="margin-top:12px;display:none;">
                    <div class="form-hint" style="margin-bottom:8px;">Preview:</div>
                    <div class="img-preview-wrap">
                        <img id="newPreviewImg" src="" style="max-height:160px;">
                        <button type="button" class="img-preview-remove" onclick="clearPreview()">×</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><div class="card-header-title">Informasi Foto</div></div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Caption / Keterangan</label>
                        <input type="text" name="caption" value="{{ old('caption', $image->caption ?? '') }}"
                               placeholder="contoh: Suasana Masjidil Haram saat pagi hari">
                        <div class="form-hint">Muncul saat foto di-hover di website.</div>
                    </div>
                    <div class="form-group">
                        <label>Urutan Tampil</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $image->sort_order ?? 0) }}"
                               min="0" placeholder="0">
                        <div class="form-hint">Angka lebih kecil tampil lebih awal.</div>
                    </div>
                    <div class="form-group">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <label class="toggle">
                                <input type="checkbox" name="is_active" value="1"
                                       {{ old('is_active', $image->is_active ?? true) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            Tampilkan di website
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:12px;justify-content:flex-end;">
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                {{ isset($image) ? 'Simpan Perubahan' : 'Upload Foto' }}
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
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