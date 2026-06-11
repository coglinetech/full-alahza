@extends('layouts.admin')

@section('title', 'Testimoni — Al-Ahza Admin')
@section('page-title', 'Testimoni')
@section('breadcrumb')
    <span class="topbar-breadcrumb-sep">›</span>
    <span class="topbar-breadcrumb-current">Testimoni</span>
@endsection

@push('styles')
<style>
.testi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 16px;
}
.testi-card {
    background: white;
    border-radius: 14px;
    border: 1px solid rgba(92,61,46,0.08);
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    padding: 22px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    transition: all 0.2s;
    position: relative;
}
.testi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}
.testi-card.inactive {
    opacity: 0.55;
}
.testi-card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
}
.testi-avatar {
    width: 42px; height: 42px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: 16px;
    flex-shrink: 0;
}
.testi-person-info { flex: 1; min-width: 0; }
.testi-person-name {
    font-weight: 700;
    font-size: 14px;
    color: var(--brown);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.testi-person-meta {
    font-size: 11px;
    color: var(--text-secondary);
    margin-top: 2px;
}
.testi-stars {
    font-size: 14px;
    letter-spacing: 1px;
    flex-shrink: 0;
}
.testi-content {
    font-size: 13px;
    color: var(--text-secondary);
    line-height: 1.7;
    font-style: italic;
    position: relative;
    padding-left: 14px;
    border-left: 2px solid rgba(197,160,78,0.25);
    flex: 1;
}
.testi-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding-top: 12px;
    border-top: 1px solid rgba(92,61,46,0.06);
}
.testi-package-tag {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    color: var(--text-secondary);
    background: var(--off-white);
    border: 1px solid rgba(92,61,46,0.08);
    padding: 4px 10px;
    border-radius: 100px;
    max-width: 160px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.testi-package-tag svg { width: 11px; height: 11px; flex-shrink: 0; }
.testi-actions {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
}
.testi-num {
    position: absolute;
    top: 14px; right: 14px;
    font-size: 10px;
    font-weight: 700;
    color: rgba(92,61,46,0.2);
}
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Testimoni Jamaah</h1>
        <p>Kelola ulasan dan testimoni dari jamaah yang ditampilkan di website.</p>
    </div>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Testimoni
    </a>
</div>

{{-- Stats bar --}}
@if($testimonials->count() > 0)
<div style="display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
    <div style="background:white;border-radius:10px;border:1px solid rgba(92,61,46,0.08);padding:12px 20px;display:flex;align-items:center;gap:10px;box-shadow:0 1px 6px rgba(0,0,0,0.03);">
        <div style="font-size:22px;font-weight:700;font-family:'Playfair Display',serif;color:var(--brown);">{{ $testimonials->total() }}</div>
        <div style="font-size:12px;color:var(--text-secondary);">Total Testimoni</div>
    </div>
    <div style="background:white;border-radius:10px;border:1px solid rgba(92,61,46,0.08);padding:12px 20px;display:flex;align-items:center;gap:10px;box-shadow:0 1px 6px rgba(0,0,0,0.03);">
        <div style="font-size:22px;font-weight:700;font-family:'Playfair Display',serif;color:var(--emerald);">{{ $testimonials->where('is_active', true)->count() }}</div>
        <div style="font-size:12px;color:var(--text-secondary);">Aktif ditampilkan</div>
    </div>
    <div style="background:white;border-radius:10px;border:1px solid rgba(92,61,46,0.08);padding:12px 20px;display:flex;align-items:center;gap:10px;box-shadow:0 1px 6px rgba(0,0,0,0.03);">
        <span style="color:#F59E0B;font-size:16px;">★</span>
        <div style="font-size:22px;font-weight:700;font-family:'Playfair Display',serif;color:var(--brown);">
            {{ number_format($testimonials->avg('rating'), 1) }}
        </div>
        <div style="font-size:12px;color:var(--text-secondary);">Rata-rata rating</div>
    </div>
</div>
@endif

@if($testimonials->count() > 0)
<div class="testi-grid">
    @foreach($testimonials as $i => $testi)
    <div class="testi-card {{ !$testi->is_active ? 'inactive' : '' }}">
        <div class="testi-num">#{{ $testimonials->firstItem() + $i }}</div>

        <div class="testi-card-top">
            <div class="testi-avatar">{{ strtoupper(substr($testi->name, 0, 1)) }}</div>
            <div class="testi-person-info">
                <div class="testi-person-name">{{ $testi->name }}</div>
                <div class="testi-person-meta">
                    {{ $testi->city ?? '' }}
                    @if($testi->city && $testi->year) · @endif
                    {{ $testi->year ?? '' }}
                </div>
            </div>
            <div class="testi-stars">
                <span style="color:#F59E0B;">{{ str_repeat('★', $testi->rating) }}</span><span style="color:#E5E7EB;">{{ str_repeat('★', 5 - $testi->rating) }}</span>
            </div>
        </div>

        <div class="testi-content">{{ Str::limit($testi->content, 120) }}</div>

        <div class="testi-footer">
            <div class="testi-package-tag">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
                {{ $testi->package_name ?? 'Tanpa paket' }}
            </div>
            <div class="testi-actions">
                <form action="{{ route('admin.testimonials.toggle', $testi) }}" method="POST">
                    @csrf @method('PATCH')
                    <label class="toggle" title="{{ $testi->is_active ? 'Sembunyikan' : 'Tampilkan' }}">
                        <input type="checkbox" {{ $testi->is_active ? 'checked' : '' }} onchange="this.form.submit()">
                        <span class="toggle-slider"></span>
                    </label>
                </form>
                <a href="{{ route('admin.testimonials.edit', $testi) }}" class="btn btn-secondary btn-icon" title="Edit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </a>
                <button onclick="confirmDelete('{{ route('admin.testimonials.destroy', $testi) }}')" class="btn btn-danger btn-icon" title="Hapus">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($testimonials->hasPages())
<div style="margin-top:24px;display:flex;justify-content:flex-end;">
    {{ $testimonials->links() }}
</div>
@endif

@else
<div class="card">
    <div class="empty-state">
        <div class="empty-state-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        </div>
        <h3>Belum Ada Testimoni</h3>
        <p>Tambahkan testimoni dari jamaah untuk membangun kepercayaan calon jamaah baru.</p>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">Tambah Testimoni</a>
    </div>
</div>
@endif

@endsection