@extends('layouts.admin')

@section('title', 'Dashboard - Al-Ahza')
@section('page-title', 'Dashboard')
@section('breadcrumb')
    <span class="tb-crumb-sep">›</span>
    <span class="tb-crumb-cur">Dashboard</span>
@endsection

@push('styles')
<style>
.dash-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 22px;
}
.dash-stat {
    background: var(--white);
    border: 1px solid var(--line);
    border-radius: var(--rl);
    padding: 18px 20px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    position: relative;
    overflow: hidden;
    transition: box-shadow 0.15s;
}
.dash-stat:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); }
.dash-stat::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
}
.dash-stat.gold::before   { background: var(--gold); }
.dash-stat.green::before  { background: #16a34a; }
.dash-stat.slate::before  { background: #64748b; }
.dash-stat.blue::before   { background: #3b82f6; }
.dash-stat-label {
    font-size: 10.5px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-3);
    margin-bottom: 8px;
}
.dash-stat-val {
    font-size: 32px;
    font-weight: 600;
    color: var(--text-1);
    line-height: 1;
    letter-spacing: -1px;
}
.dash-stat-sub {
    font-size: 11px;
    color: var(--text-3);
    margin-top: 5px;
}
.dash-stat-icon {
    width: 36px; height: 36px;
    border-radius: var(--r);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.dash-stat-icon svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 1.75; }
.dash-stat.gold  .dash-stat-icon { background: var(--gold-dim);              color: var(--gold); }
.dash-stat.green .dash-stat-icon { background: rgba(22,163,74,0.07);         color: #16a34a; }
.dash-stat.slate .dash-stat-icon { background: rgba(100,116,139,0.07);       color: #64748b; }
.dash-stat.blue  .dash-stat-icon { background: rgba(59,130,246,0.07);        color: #3b82f6; }

.dash-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 14px;
}
.dash-grid-3 {
    display: grid;
    grid-template-columns: 1.4fr 1fr 1fr;
    gap: 14px;
}

.dash-card {
    background: var(--white);
    border: 1px solid var(--line);
    border-radius: var(--rl);
    overflow: hidden;
}
.dash-card-head {
    padding: 12px 16px;
    border-bottom: 1px solid var(--line-soft);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}
.dash-card-title {
    font-size: 12.5px;
    font-weight: 600;
    color: var(--text-1);
    display: flex;
    align-items: center;
    gap: 7px;
}
.dash-card-title svg { width: 13px; height: 13px; stroke: var(--text-3); fill: none; stroke-width: 1.75; }

/* Package list */
.pkg-list { }
.pkg-list-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 16px;
    border-bottom: 1px solid var(--line-soft);
    transition: background 0.1s;
}
.pkg-list-item:last-child { border-bottom: none; }
.pkg-list-item:hover { background: #fafafa; }
.pkg-list-thumb {
    width: 40px; height: 52px;
    border-radius: 5px;
    object-fit: cover;
    background: var(--line-soft);
    border: 1px solid var(--line);
    flex-shrink: 0;
}
.pkg-list-thumb-placeholder {
    width: 40px; height: 52px;
    border-radius: 5px;
    background: var(--line-soft);
    border: 1px solid var(--line);
    display: flex; align-items: center; justify-content: center;
    color: var(--text-3); flex-shrink: 0;
}
.pkg-list-thumb-placeholder svg { width: 14px; height: 14px; stroke: currentColor; fill: none; }
.pkg-list-info { flex: 1; min-width: 0; }
.pkg-list-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-1);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 2px;
}
.pkg-list-dur { font-size: 11px; color: var(--text-3); }
.pkg-list-right { text-align: right; flex-shrink: 0; }
.pkg-list-price { font-size: 12.5px; font-weight: 600; color: var(--gold); }
.pkg-list-cat { font-size: 10.5px; color: var(--text-3); margin-top: 2px; }

/* Testi list */
.testi-list-item {
    padding: 12px 16px;
    border-bottom: 1px solid var(--line-soft);
    transition: background 0.1s;
}
.testi-list-item:last-child { border-bottom: none; }
.testi-list-item:hover { background: #fafafa; }
.testi-list-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    margin-bottom: 5px;
}
.testi-list-name { font-size: 12.5px; font-weight: 600; color: var(--text-1); }
.testi-list-stars { font-size: 12px; letter-spacing: 0.5px; }
.testi-list-text { font-size: 11.5px; color: var(--text-3); line-height: 1.5; font-style: italic; }
.testi-list-pkg { font-size: 10.5px; color: var(--text-3); margin-top: 4px; }

/* Quick links */
.quick-links { padding: 12px; display: grid; grid-template-columns: 1fr 1fr; gap: 6px; }
.quick-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 12px;
    border-radius: var(--r);
    border: 1px solid var(--line);
    text-decoration: none;
    color: var(--text-2);
    font-size: 12px;
    font-weight: 500;
    transition: all 0.15s;
    background: var(--bg);
}
.quick-link svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 1.75; flex-shrink: 0; color: var(--text-3); }
.quick-link:hover { background: var(--gold-pale); border-color: var(--gold-soft); color: var(--gold); }
.quick-link:hover svg { color: var(--gold); }

/* Activity / empty */
.dash-empty { padding: 28px 16px; text-align: center; color: var(--text-3); font-size: 12px; }
</style>
@endpush

@section('content')

{{-- STATS --}}
<div class="dash-stats">
    <div class="dash-stat gold">
        <div>
            <div class="dash-stat-label">Paket Perjalanan</div>
            <div class="dash-stat-val">{{ $stats['packages'] }}</div>
            <div class="dash-stat-sub">Paket tersedia</div>
        </div>
        <div class="dash-stat-icon">
            <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
        </div>
    </div>
    <div class="dash-stat green">
        <div>
            <div class="dash-stat-label">Testimoni</div>
            <div class="dash-stat-val">{{ $stats['testimonials'] }}</div>
            <div class="dash-stat-sub">Ulasan jamaah</div>
        </div>
        <div class="dash-stat-icon">
            <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        </div>
    </div>
    <div class="dash-stat slate">
        <div>
            <div class="dash-stat-label">Galeri</div>
            <div class="dash-stat-val">{{ $stats['gallery'] }}</div>
            <div class="dash-stat-sub">Foto diunggah</div>
        </div>
        <div class="dash-stat-icon">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        </div>
    </div>
    <div class="dash-stat blue">
        <div>
            <div class="dash-stat-label">FAQ</div>
            <div class="dash-stat-val">{{ $stats['faqs'] }}</div>
            <div class="dash-stat-sub">Pertanyaan aktif</div>
        </div>
        <div class="dash-stat-icon">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3M12 17h.01"/></svg>
        </div>
    </div>
</div>

{{-- ROW 1: Paket + Testimoni --}}
<div class="dash-grid" style="margin-bottom:14px;">

    {{-- Paket Terbaru --}}
    <div class="dash-card">
        <div class="dash-card-head">
            <div class="dash-card-title">
                <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
                Paket Terbaru
            </div>
            <a href="{{ route('admin.packages.index') }}" class="btn btn-ghost btn-sm">Lihat semua →</a>
        </div>
        <div class="pkg-list">
            @forelse($recentPackages as $pkg)
            <div class="pkg-list-item">
                @if($pkg->image_path)
                    <img src="{{ media_url($pkg->image_path) }}" alt="{{ $pkg->name }}" class="pkg-list-thumb">
                @else
                    <div class="pkg-list-thumb-placeholder">
                        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                @endif
                <div class="pkg-list-info">
                    <div class="pkg-list-name">{{ $pkg->name }}</div>
                    <div class="pkg-list-dur">{{ $pkg->duration }}</div>
                </div>
                <div class="pkg-list-right">
                    <div class="pkg-list-price">{{ $pkg->formatted_price }}</div>
                    <div class="pkg-list-cat">{{ str_replace('_', ' ', $pkg->category) }}</div>
                </div>
            </div>
            @empty
            <div class="dash-empty">Belum ada paket ditambahkan.</div>
            @endforelse
        </div>
    </div>

    {{-- Testimoni Terbaru --}}
    <div class="dash-card">
        <div class="dash-card-head">
            <div class="dash-card-title">
                <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                Testimoni Terbaru
            </div>
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-ghost btn-sm">Lihat semua →</a>
        </div>
        @forelse($recentTestimonials as $testi)
        <div class="testi-list-item">
            <div class="testi-list-top">
                <div class="testi-list-name">{{ $testi->name }}</div>
                <div class="testi-list-stars">
                    <span style="color:#f59e0b;">{{ str_repeat('★', $testi->rating) }}</span><span style="color:#e5e7eb;">{{ str_repeat('★', 5 - $testi->rating) }}</span>
                </div>
            </div>
            <div class="testi-list-text">"{{ Str::limit($testi->content, 70) }}"</div>
            @if($testi->package_name)
            <div class="testi-list-pkg">📦 {{ $testi->package_name }}</div>
            @endif
        </div>
        @empty
        <div class="dash-empty">Belum ada testimoni ditambahkan.</div>
        @endforelse
    </div>

</div>

@endsection