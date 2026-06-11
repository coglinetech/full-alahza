@extends('layouts.app')

@section('title', $package->name . ' — Al-Ahza Travel Umroh')
@section('description', 'Detail lengkap paket ' . $package->name . '. ' . ($package->description ?? 'Melayani ibadah Umroh dengan amanah dan profesional.'))

{{-- ================================================================
     HERO
     ================================================================ --}}
<div class="detail-hero">
    <div class="detail-hero-inner">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <a href="{{ route('home') }}#packages">Paket Kami</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span class="breadcrumb-current" aria-current="page">{{ $package->name }}</span>
        </nav>

        @php
            $catLabels = \App\Models\Package::categoryLabels();
            $isFeatured = $package->category === \App\Models\Package::CATEGORY_UMROH_PLUS;
            $catLabel   = $catLabels[$package->category] ?? 'Paket';
        @endphp

        <div class="detail-category-pill">{{ $catLabel }}</div>
        <h1 class="detail-hero-title">{{ $package->name }}</h1>
        <div class="detail-hero-meta">
            <span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ $package->duration }}
            </span>
            <span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                Makkah & Madinah{{ $package->destination ? ', ' . $package->destination : '' }}
            </span>
            <span>Izin Resmi Kemenag RI</span>
        </div>
    </div>
</div>

{{-- ================================================================
     BODY
     ================================================================ --}}
<div class="detail-body">
    <div class="detail-container">
        <div class="detail-grid">

            {{-- ============ KIRI ============ --}}
            <div class="detail-left">

                <a href="{{ route('home') }}#packages" class="detail-back">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                    Kembali ke semua paket
                </a>

                {{-- MOBILE BROSUR — full poster seperti halaman utama --}}
                <div class="brosur-mobile-banner">
                    <div class="brosur-mobile-img">
                          @if(isset($package) && has_media($package->image_path))
                            <img src="{{ media_url($package->image_path) }}" alt="Brosur {{ $package->name }}">
                        @else
                            <div class="brosur-mobile-placeholder">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="rgba(197,160,78,0.3)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="brosur-mobile-info">
                        <div class="brosur-mobile-name">{{ $package->name }}</div>
                        <div class="brosur-mobile-price">{{ $package->formatted_price }}</div>
                        <a href="https://wa.me/081122869911?text=Assalamualaikum%2C+saya+ingin+mendaftar+paket+{{ urlencode($package->name) }}"
                           target="_blank" class="brosur-mobile-wa">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            Daftar via WhatsApp
                        </a>
                          @if(isset($package) && has_media($package->image_path))
                            <a href="{{ media_url($package->image_path) }}"
                            download="{{ $package->name }}.jpg"
                            class="brosur-mobile-secondary">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                Download Brosur
                            </a>
                        @else
                            <a href="https://wa.me/081122869911?text=Minta+brosur+paket+{{ urlencode($package->name) }}"
                               target="_blank" class="brosur-mobile-secondary">
                                Minta Brosur via WhatsApp
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Harga (tanpa tombol WhatsApp) --}}
                <div class="detail-price-strip">
                    <div>
                        <div class="detail-price-label">Mulai dari</div>
                        <div class="detail-price-main">{{ $package->formatted_price }}</div>
                        <div class="detail-price-note">Per orang · Sudah termasuk pajak & asuransi</div>
                    </div>
                </div>

                {{-- Info cards --}}
                <div class="detail-info-row">
                    <div class="detail-info-card">
                        <div class="detail-info-label">Durasi</div>
                        <div class="detail-info-value">{{ $package->duration }}</div>
                    </div>
                    <div class="detail-info-card">
                        <div class="detail-info-label">Keberangkatan</div>
                        <div class="detail-info-value">Setiap Bulan</div>
                    </div>
                    <div class="detail-info-card">
                        <div class="detail-info-label">Status</div>
                        <div class="detail-info-value" style="color:#2E7D52;">Tersedia</div>
                    </div>
                </div>

                {{-- Fasilitas --}}
                @if($package->highlights && count($package->highlights) > 0)
                <div class="detail-block">
                    <div class="detail-block-header">Yang Sudah Termasuk</div>
                    <div class="detail-block-body">
                        <ul class="detail-highlights">
                            @foreach($package->highlights as $h)
                            <li>
                                <div class="detail-check {{ $isFeatured ? 'green' : '' }}">
                                    <svg viewBox="0 0 12 12" stroke-width="2" stroke="white" fill="none"><polyline points="2 6 5 9 10 3"/></svg>
                                </div>
                                {{ $h }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                {{-- Deskripsi --}}
                @if($package->description)
                <div class="detail-block">
                    <div class="detail-block-header">Tentang Paket Ini</div>
                    <div class="detail-block-body">
                        <div class="detail-desc">{!! nl2br(e($package->description)) !!}</div>
                    </div>
                </div>
                @endif

                {{-- Syarat --}}
                <div class="detail-block">
                    <div class="detail-block-header">Syarat Pendaftaran</div>
                    <div class="detail-block-body">
                        <ul class="detail-req-list">
                            <li><div class="detail-req-dot"></div>Paspor aktif minimal berlaku 8 bulan</li>
                            <li><div class="detail-req-dot"></div>KTP & Kartu Keluarga</li>
                            <li><div class="detail-req-dot"></div>Foto terbaru ukuran 3×4 & 4×6 dengan background putih</li>
                            <li><div class="detail-req-dot"></div>Buku nikah (untuk suami-istri yang berangkat bersama)</li>
                            <li><div class="detail-req-dot"></div>DP minimal 30% dari total biaya paket</li>
                        </ul>
                    </div>
                </div>

                {{-- Paket lainnya --}}
                @if($others && count($others) > 0)
                <div class="detail-block">
                    <div class="detail-block-header">Paket Lainnya</div>
                    <div class="detail-block-body">
                        <div class="other-pkg-list">
                            @foreach($others as $other)
                            <a href="{{ route('package.detail', $other->slug) }}" class="other-pkg-item">
                                <div>
                                    <div class="other-pkg-name">{{ $other->name }}</div>
                                    <div class="other-pkg-dur">{{ $other->duration }}</div>
                                </div>
                                <div class="other-pkg-right">
                                    <div class="other-pkg-price">{{ $other->formatted_price }}</div>
                                    <div class="other-pkg-arrow">›</div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

            </div>{{-- /kiri --}}

            {{-- ============ KANAN — sticky brosur (desktop only) ============ --}}
            <div class="detail-right">
                <div class="brosur-card">
                    <div class="brosur-img-wrap">
                        @if($package->image_path)
                            <img src="{{ media_url($package->image_path) }}" alt="Brosur {{ $package->name }}">
                        @else
                            <div class="brosur-placeholder">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="rgba(197,160,78,0.3)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                                <div>
                                    <div class="brosur-placeholder-title">Brosur Sedang Disiapkan</div>
                                    <div class="brosur-placeholder-sub">Hubungi kami untuk mendapatkan brosur lengkap paket ini.</div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="brosur-footer">
                        <a href="https://wa.me/081122869911?text=Assalamualaikum%2C+saya+ingin+mendaftar+paket+{{ urlencode($package->name) }}"
                           target="_blank" class="brosur-btn-primary">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            Daftar via WhatsApp
                        </a>
                        @if($package->image_path)
                            <a href="{{ media_url($package->image_path) }}"
                            download="{{ $package->name }}.jpg"
                            class="brosur-btn-secondary">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                Download Brosur
                            </a>
                        @else
                            <a href="https://wa.me/081122869911?text=Minta+brosur+paket+{{ urlencode($package->name) }}"
                               target="_blank" class="brosur-btn-secondary">
                                Minta Brosur via WhatsApp
                            </a>
                        @endif
                    </div>
                    <div class="brosur-trust">
                        Terdaftar Resmi Kemenag RI · PPIU
                    </div>
                </div>
            </div>{{-- /kanan --}}

        </div>
    </div>
</div>