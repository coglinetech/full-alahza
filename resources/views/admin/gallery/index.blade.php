@extends('layouts.admin')

@section('title', 'Galeri — Al-Ahza Admin')
@section('page-title', 'Galeri')
@section('breadcrumb')
    <span class="topbar-breadcrumb-sep">›</span>
    <span class="topbar-breadcrumb-current">Galeri</span>
@endsection

@push('styles')
<style>
.gallery-admin-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
}
.gallery-admin-item {
    background: white;
    border-radius: 12px;
    border: 1px solid rgba(92,61,46,0.08);
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    overflow: hidden;
    transition: all 0.2s;
}
.gallery-admin-item:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.08); }
.gallery-admin-img {
    width: 100%;
    aspect-ratio: 1;
    overflow: hidden;
    background: var(--off-white);
    position: relative;
}
.gallery-admin-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s;
}
.gallery-admin-item:hover .gallery-admin-img img { transform: scale(1.05); }
.gallery-admin-img-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    color: rgba(92,61,46,0.15);
}
.gallery-admin-body { padding: 12px; }
.gallery-admin-caption {
    font-size: 12px; font-weight: 600;
    color: var(--brown);
    margin-bottom: 4px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.gallery-admin-meta { font-size: 11px; color: var(--text-secondary); margin-bottom: 10px; }
.gallery-admin-actions { display: flex; gap: 6px; }
.sort-handle {
    cursor: grab;
    color: rgba(92,61,46,0.2);
    display: flex; align-items: center;
    padding: 0 4px;
}
.sort-handle:active { cursor: grabbing; }
.gallery-order-badge {
    position: absolute;
    top: 8px; left: 8px;
    background: rgba(0,0,0,0.55);
    color: white;
    font-size: 11px;
    font-weight: 700;
    width: 22px; height: 22px;
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
}
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Galeri Foto</h1>
        <p>Kelola foto-foto yang ditampilkan di bagian galeri website.</p>
    </div>
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Upload Foto
    </a>
</div>

@if($images->count() > 0)
<div class="gallery-admin-grid" id="galleryGrid">
    @foreach($images as $img)
    <div class="gallery-admin-item" data-id="{{ $img->id }}">
        <div class="gallery-admin-img">
            <div class="gallery-order-badge">{{ $loop->iteration }}</div>
            @if($img->image_path)
                <img src="{{ media_url($img->image_path) }}" alt="{{ $img->caption }}">
            @else
                <div class="gallery-admin-img-placeholder">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </div>
            @endif
        </div>
        <div class="gallery-admin-body">
            <div class="gallery-admin-caption">{{ $img->caption ?: 'Tanpa caption' }}</div>
            <div class="gallery-admin-meta">
                @if($img->is_active)
                    <span class="badge badge-green" style="font-size:10px;">Aktif</span>
                @else
                    <span class="badge badge-gray" style="font-size:10px;">Nonaktif</span>
                @endif
            </div>
            <div class="gallery-admin-actions">
                <a href="{{ route('admin.gallery.edit', $img) }}" class="btn btn-secondary btn-sm" style="flex:1;justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit
                </a>
                <button onclick="confirmDelete('{{ route('admin.gallery.destroy', $img) }}')" class="btn btn-danger btn-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6M10 11v6M14 11v6M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="card">
    <div class="empty-state" style="text-align: center; padding: 48px 20px;">
        <div class="empty-state-icon" style="color: rgba(92,61,46,0.2); margin-bottom: 16px;">
            {{-- Tambahkan width="64" dan height="64" di sini --}}
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <circle cx="8.5" cy="8.5" r="1.5"/>
                <polyline points="21 15 16 10 5 21"/>
            </svg>
        </div>
        <h3 style="margin-bottom: 8px;">Galeri Kosong</h3>
        <p style="color: var(--text-secondary); margin-bottom: 24px;">Upload foto-foto kegiatan perjalanan umroh untuk ditampilkan di website.</p>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">Upload Foto Pertama</a>
    </div>
</div>
@endif
@endsection
    <style>
        .gallery-admin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
        }

        .gallery-admin-item {
            background: white;
            border-radius: 12px;
            border: 1px solid rgba(92, 61, 46, 0.08);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            transition: all 0.2s;
        }

        .gallery-admin-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }

        .gallery-admin-img {
            width: 100%;
            aspect-ratio: 1;
            overflow: hidden;
            background: var(--off-white);
            position: relative;
        }

        .gallery-admin-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.3s;
        }

        .gallery-admin-item:hover .gallery-admin-img img {
            transform: scale(1.05);
        }

        .gallery-admin-img-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(92, 61, 46, 0.15);
        }

        .gallery-admin-body {
            padding: 12px;
        }

        .gallery-admin-caption {
            font-size: 12px;
            font-weight: 600;
            color: var(--brown);
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .gallery-admin-meta {
            font-size: 11px;
            color: var(--text-secondary);
            margin-bottom: 10px;
        }

        .gallery-admin-actions {
            display: flex;
            gap: 6px;
        }

        .sort-handle {
            cursor: grab;
            color: rgba(92, 61, 46, 0.2);
            display: flex;
            align-items: center;
            padding: 0 4px;
        }

        .sort-handle:active {
            cursor: grabbing;
        }

        .gallery-order-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: rgba(0, 0, 0, 0.55);
            color: white;
            font-size: 11px;
            font-weight: 700;
            width: 22px;
            height: 22px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div class="page-header-left">
            <h1>Galeri Foto</h1>
            <p>Kelola foto-foto yang ditampilkan di bagian galeri website.</p>
        </div>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Upload Foto
        </a>
    </div>

    @if ($images->count() > 0)
        <div class="gallery-admin-grid" id="galleryGrid">
            @foreach ($images as $img)
                <div class="gallery-admin-item" data-id="{{ $img->id }}">
                    <div class="gallery-admin-img">
                        <div class="gallery-order-badge">{{ $loop->iteration }}</div>
                        @if ($img->image_path)
                            <img src="{{ media_url($img->image_path) }}" alt="{{ $img->caption }}">
                        @else
                            <div class="gallery-admin-img-placeholder">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <circle cx="8.5" cy="8.5" r="1.5" />
                                    <polyline points="21 15 16 10 5 21" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="gallery-admin-body">
                        <div class="gallery-admin-caption">{{ $img->caption ?: 'Tanpa caption' }}</div>
                        <div class="gallery-admin-meta">
                            @if ($img->is_active)
                                <span class="badge badge-green" style="font-size:10px;">Aktif</span>
                            @else
                                <span class="badge badge-gray" style="font-size:10px;">Nonaktif</span>
                            @endif
                        </div>
                        <div class="gallery-admin-actions">
                            <a href="{{ route('admin.gallery.edit', $img) }}" class="btn btn-secondary btn-sm"
                                style="flex:1;justify-content:center;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path
                                        d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                Edit
                            </a>
                            <button onclick="confirmDelete('{{ route('admin.gallery.destroy', $img) }}')"
                                class="btn btn-danger btn-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6" />
                                    <path
                                        d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6M10 11v6M14 11v6M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <div class="empty-state" style="text-align: center; padding: 48px 20px;">
                <div class="empty-state-icon" style="color: rgba(92,61,46,0.2); margin-bottom: 16px;">
                    {{-- Tambahkan width="64" dan height="64" di sini --}}
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <circle cx="8.5" cy="8.5" r="1.5" />
                        <polyline points="21 15 16 10 5 21" />
                    </svg>
                </div>
                <h3 style="margin-bottom: 8px;">Galeri Kosong</h3>
                <p style="color: var(--text-secondary); margin-bottom: 24px;">Upload foto-foto kegiatan perjalanan umroh
                    untuk ditampilkan di website.</p>
                <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">Upload Foto Pertama</a>
            </div>
        </div>
    @endif
@endsection
