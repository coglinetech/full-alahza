@extends('layouts.admin')

@section('title', 'Paket Perjalanan — Al-Ahza Admin')
@section('page-title', 'Paket Perjalanan')
@section('breadcrumb')
    <span class="topbar-breadcrumb-sep">›</span>
    <span class="topbar-breadcrumb-current">Paket Perjalanan</span>
@endsection

@push('styles')
<style>
.packages-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
}
.pkg-admin-card {
    background: white;
    border-radius: 14px;
    border: 1px solid rgba(92,61,46,0.08);
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    overflow: hidden;
    transition: all 0.2s;
    display: flex;
    flex-direction: column;
}
.pkg-admin-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 28px rgba(0,0,0,0.09);
}
.pkg-admin-img {
    width: 100%;
    aspect-ratio: 3/4;
    overflow: hidden;
    background: var(--off-white);
    position: relative;
    flex-shrink: 0;
}
.pkg-admin-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s;
}
.pkg-admin-card:hover .pkg-admin-img img { transform: scale(1.03); }
.pkg-admin-img-placeholder {
    width: 100%; height: 100%;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 8px; color: rgba(92,61,46,0.15);
}
.pkg-admin-img-placeholder span {
    font-size: 11px;
    color: rgba(92,61,46,0.25);
}
.pkg-admin-num {
    position: absolute;
    top: 10px; left: 10px;
    background: rgba(0,0,0,0.45);
    color: white;
    font-size: 11px; font-weight: 700;
    width: 24px; height: 24px;
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
}
.pkg-admin-body {
    padding: 16px;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.pkg-admin-name {
    font-weight: 700;
    font-size: 14px;
    color: var(--brown);
    margin-bottom: 6px;
    line-height: 1.3;
}
.pkg-admin-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
    gap: 8px;
    flex-wrap: wrap;
}
.pkg-admin-price {
    font-weight: 700;
    font-size: 14px;
    color: var(--gold-dark);
}
.pkg-admin-duration {
    font-size: 11px;
    color: var(--text-secondary);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 4px;
}
.pkg-admin-duration svg { width: 12px; height: 12px; flex-shrink: 0; }
.pkg-admin-actions {
    display: flex;
    gap: 6px;
    margin-top: auto;
    padding-top: 12px;
    border-top: 1px solid rgba(92,61,46,0.06);
}
.pkg-admin-actions .btn { flex: 1; justify-content: center; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Paket Perjalanan</h1>
        <p>Kelola semua paket umroh yang ditampilkan di website.</p>
    </div>
    <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Paket
    </a>
</div>

@if($packages->count() > 0)
<div class="packages-grid">
    @foreach($packages as $i => $package)
    @php
        $catLabels = [
            'umroh_reguler' => ['label'=>'Umroh Reguler','class'=>'badge-gold'],
            'umroh_plus'    => ['label'=>'Umroh Plus','class'=>'badge-green'],
        ];
        $cat = $catLabels[$package->category] ?? ['label'=>$package->category,'class'=>'badge-gray'];
    @endphp
    <div class="pkg-admin-card">
        <div class="pkg-admin-img">
            <div class="pkg-admin-num">{{ $packages->firstItem() + $i }}</div>
              @if(has_media($package->image_path))
                <img src="{{ media_url($package->image_path) }}" alt="{{ $package->name }}">
            @else
                <div class="pkg-admin-img-placeholder">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    <span>Belum ada foto</span>
                </div>
            @endif
        </div>
        <div class="pkg-admin-body">
            <div class="pkg-admin-name">{{ $package->name }}</div>
            <div class="pkg-admin-duration">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ $package->duration }}
            </div>
            <div class="pkg-admin-meta">
                <span class="badge {{ $cat['class'] }}">{{ $cat['label'] }}</span>
                <span class="pkg-admin-price">{{ $package->formatted_price }}</span>
            </div>
            <div class="pkg-admin-actions">
                <a href="{{ route('package.detail', $package->slug) }}" target="_blank"
                   class="btn btn-secondary btn-sm" title="Lihat di website">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/></svg>
                    Preview
                </a>
                <a href="{{ route('admin.packages.edit', $package) }}"
                   class="btn btn-secondary btn-sm" title="Edit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit
                </a>
                <button onclick="confirmDelete('{{ route('admin.packages.destroy', $package) }}')"
                        class="btn btn-danger btn-sm" title="Hapus">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                    Hapus
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($packages->hasPages())
<div style="margin-top:24px;display:flex;justify-content:flex-end;">
    {{ $packages->links() }}
</div>
@endif

@else
<div class="card">
    <div class="empty-state">
        <div class="empty-state-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
        </div>
        <h3>Belum Ada Paket</h3>
        <p>Mulai tambahkan paket perjalanan umroh.</p>
        <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">Tambah Paket Pertama</a>
    </div>
</div>
@endif

@endsection