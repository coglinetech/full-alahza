@extends('layouts.admin')

@section('title', (isset($banner) ? 'Edit' : 'Tambah') . ' Banner Iklan — Al-Ahza Admin')
@section('page-title', isset($banner) ? 'Edit Banner Iklan' : 'Tambah Banner Iklan')
@section('breadcrumb')
    <span class="tb-crumb-sep">›</span>
    <a href="{{ route('admin.banners.index') }}">Banner Iklan</a>
    <span class="tb-crumb-sep">›</span>
    <span class="tb-crumb-cur">{{ isset($banner) ? 'Edit' : 'Tambah' }}</span>
@endsection

@section('content')
<div style="max-width:680px;">
    <div class="page-header">
        <div class="page-header-left">
            <h1>{{ isset($banner) ? 'Edit Banner Iklan' : 'Tambah Banner Iklan' }}</h1>
            <p>{{ isset($banner) ? 'Perbarui data banner iklan.' : 'Tambahkan banner iklan baru untuk ditampilkan di halaman utama.' }}</p>
        </div>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ isset($banner) ? route('admin.banners.update', $banner) : route('admin.banners.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($banner)) @method('PUT') @endif

        @if($errors->any())
        <div class="alert alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div><ul style="margin:0 0 0 16px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        </div>
        @endif

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><div class="card-header-title">Konten Banner</div></div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Judul Banner <span class="req">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $banner->title ?? '') }}"
                               placeholder="contoh: Promo Umroh Ramadhan" required>
                    </div>
                    <div class="form-group">
                        <label>Subtitle / Deskripsi</label>
                        <textarea name="subtitle" rows="3" placeholder="Teks pendukung banner...">{{ old('subtitle', $banner->subtitle ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><div class="card-header-title">Gambar Banner</div></div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Upload Gambar</label>
                        <div class="upload-zone" onclick="document.getElementById('bannerImageInput').click()">
                            <input type="file" name="image" id="bannerImageInput" accept="image/jpeg,image/png,image/webp"
                                   onchange="previewBannerImage(this)">
                            <div class="upload-icon">
                                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                            <div class="upload-title">Klik untuk upload gambar</div>
                            <div class="upload-sub">JPEG, PNG, atau WebP. Maks 5 MB. Ukuran ideal: 1920×600px</div>
                        </div>
                        <div id="bannerImagePreview" style="margin-top:10px;">
                            @if(isset($banner) && has_media($banner->image_path))
                            <div class="img-preview-wrap">
                                <img src="{{ media_url($banner->image_path) }}" alt="Preview">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><div class="card-header-title">Link & Pengaturan</div></div>
            <div class="card-body">
                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label>Link URL (opsional)</label>
                        <input type="url" name="link_url" value="{{ old('link_url', $banner->link_url ?? '') }}"
                               placeholder="https://example.com/promo">
                    </div>
                    <div class="form-group">
                        <label>Teks Tombol</label>
                        <input type="text" name="link_label" value="{{ old('link_label', $banner->link_label ?? '') }}"
                               placeholder="contoh: Lihat Promo">
                    </div>
                    <div class="form-group">
                        <label>Urutan Tampil</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order ?? 0) }}" min="0">
                    </div>
                    <div class="form-group">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <label class="toggle">
                                <input type="checkbox" name="is_active" value="1"
                                       {{ old('is_active', $banner->is_active ?? true) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            Tampilkan di website
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:12px;justify-content:flex-end;">
            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                {{ isset($banner) ? 'Simpan Perubahan' : 'Tambah Banner' }}
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewBannerImage(input) {
    const preview = document.getElementById('bannerImagePreview');
    preview.innerHTML = '';
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrap = document.createElement('div');
            wrap.className = 'img-preview-wrap';
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Preview';
            wrap.appendChild(img);
            preview.appendChild(wrap);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
