@extends('layouts.admin')

@section('title', 'Banner Iklan — Al-Ahza Admin')
@section('page-title', 'Banner Iklan')
@section('breadcrumb')
    <span class="tb-crumb-sep">›</span>
    <span class="tb-crumb-cur">Banner Iklan</span>
@endsection

@push('styles')
<style>
.banner-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 18px;
}
.banner-card {
    background: white;
    border-radius: 14px;
    border: 1px solid rgba(92,61,46,0.08);
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    overflow: hidden;
    transition: all 0.2s;
    display: flex;
    flex-direction: column;
}
.banner-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}
.banner-card.inactive { opacity: 0.55; }
.banner-preview {
    width: 100%;
    aspect-ratio: 2/1;
    overflow: hidden;
    background: var(--line-soft);
    position: relative;
}
.banner-preview img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
}
.banner-preview-placeholder {
    width: 100%; height: 100%;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 8px; color: var(--text-3);
}
.banner-preview-placeholder svg { width: 28px; height: 28px; stroke: currentColor; fill: none; }
.banner-num {
    position: absolute;
    top: 10px; left: 10px;
    background: rgba(0,0,0,0.45);
    color: white;
    font-size: 11px; font-weight: 700;
    width: 24px; height: 24px;
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
}
.banner-body {
    padding: 16px;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.banner-title {
    font-weight: 700;
    font-size: 14px;
    color: var(--text-1);
    margin-bottom: 4px;
    line-height: 1.3;
}
.banner-sub {
    font-size: 12px;
    color: var(--text-3);
    margin-bottom: 10px;
    line-height: 1.5;
}
.banner-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
    flex-wrap: wrap;
}
.banner-link {
    font-size: 11.5px;
    color: var(--gold);
    text-decoration: none;
    display: flex; align-items: center; gap: 4px;
}
.banner-link:hover { text-decoration: underline; }
.banner-actions {
    display: flex;
    gap: 6px;
    margin-top: auto;
    padding-top: 12px;
    border-top: 1px solid rgba(92,61,46,0.06);
}
.banner-actions .btn { flex: 1; justify-content: center; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Banner Iklan</h1>
        <p>Kelola banner iklan yang muncul di halaman utama website.</p>
    </div>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Banner
    </a>
</div>

@if($banners->count() > 0)
<div class="banner-grid">
    @foreach($banners as $i => $banner)
    <div class="banner-card {{ !$banner->is_active ? 'inactive' : '' }}">
        <div class="banner-preview">
            <div class="banner-num">{{ $banners->firstItem() + $i }}</div>
            @if(has_media($banner->image_path))
                <img src="{{ media_url($banner->image_path) }}" alt="{{ $banner->title }}">
            @else
                <div class="banner-preview-placeholder">
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    <span style="font-size:11px;color:var(--text-3);">Belum ada gambar</span>
                </div>
            @endif
        </div>
        <div class="banner-body">
            <div class="banner-title">{{ $banner->title }}</div>
            @if($banner->subtitle)
            <div class="banner-sub">{{ Str::limit($banner->subtitle, 80) }}</div>
            @endif
            <div class="banner-meta">
                <span class="badge badge-gray">Urutan: {{ $banner->sort_order }}</span>
                @if($banner->link_url)
                <a href="{{ $banner->link_url }}" target="_blank" class="banner-link">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/></svg>
                    {{ $banner->link_label ?? 'Link' }}
                </a>
                @endif
            </div>
            <div class="banner-actions">
                <form action="{{ route('admin.banners.toggle', $banner) }}" method="POST">
                    @csrf @method('PATCH')
                    <label class="toggle" title="{{ $banner->is_active ? 'Sembunyikan' : 'Tampilkan' }}" style="margin-bottom:0;">
                        <input type="checkbox" {{ $banner->is_active ? 'checked' : '' }} onchange="this.form.submit()">
                        <span class="toggle-slider"></span>
                    </label>
                </form>
                <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-secondary btn-sm" title="Edit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit
                </a>
                <button onclick="confirmDelete('{{ route('admin.banners.destroy', $banner) }}', '{{ $banner->title }}')" class="btn btn-danger btn-sm" title="Hapus">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                    Hapus
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($banners->hasPages())
<div style="margin-top:24px;display:flex;justify-content:flex-end;">
    {{ $banners->links() }}
</div>
@endif

@else
<div class="card">
    <div class="empty-state">
        <div class="empty-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        </div>
        <h3>Belum Ada Banner</h3>
        <p>Tambahkan banner iklan untuk ditampilkan di halaman utama website.</p>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">Tambah Banner Pertama</a>
    </div>
</div>
@endif

@endsection
