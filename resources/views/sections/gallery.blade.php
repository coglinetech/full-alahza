<section id="gallery">
    <div class="container">
        <div class="section-header center">
            <div class="section-tag reveal">Dokumentasi</div>
            <h2 class="section-title reveal" style="transition-delay:0.1s">Galeri Perjalanan</h2>
            <p class="section-sub reveal" style="transition-delay:0.2s">Momen-momen berharga perjalanan suci jamaah Al-Ahza ke Tanah Suci Makkah dan Madinah.</p>
            <div class="divider-ornament center reveal" style="transition-delay:0.3s"></div>
        </div>

        <div class="gallery-grid">

            @if($gallery && count($gallery) > 0)
                @foreach($gallery as $index => $item)
                @php($galleryImgUrl = media_url($item->image_path))
                <div class="gallery-item reveal" style="transition-delay:{{ 0.1 + ($index * 0.05) }}s"
                     data-caption="{{ $item->caption }}"
                     data-img="{{ $galleryImgUrl }}">
                    <div class="gallery-img" style="background:linear-gradient(135deg,#1a0f05,#3a2010);">
                        @if($galleryImgUrl !== '')
                        <img src="{{ $galleryImgUrl }}" alt="{{ $item->caption }}" style="width:100%;height:100%;object-fit:cover;" loading="lazy">
                        @endif
                    </div>
                    <div class="gallery-caption">{{ $item->caption }}</div>
                </div>
                @endforeach

            @else

                {{-- Fallback static saat DB belum ada gambar --}}

                {{-- Item 1: Masjidil Haram (span 2) --}}
                <div class="gallery-item reveal" style="transition-delay:0.1s"
                     data-caption="Suasana Masjidil Haram, Makkah Al-Mukarramah" data-img="">
                    <div class="gallery-img g1">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="rgba(197,160,78,0.6)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 21h18M9 21V10.5M15 21V10.5M12 3L2 10h20L12 3z"/>
                            <rect x="9" y="14" width="6" height="7" rx="0.5"/>
                            <path d="M12 3v0m0 0c0-1.5 1-2 1-2s-1 0-1 2z" stroke-width="0.5"/>
                        </svg>
                    </div>
                    <div class="gallery-caption">Masjidil Haram, Makkah</div>
                </div>

                {{-- Item 2: Raudhah --}}
                <div class="gallery-item reveal" style="transition-delay:0.15s"
                     data-caption="Raudhah Masjid Nabawi, Madinah" data-img="">
                    <div class="gallery-img g2">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="rgba(197,160,78,0.6)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </div>
                    <div class="gallery-caption">Raudhah, Madinah</div>
                </div>

                {{-- Item 3: Bandara --}}
                <div class="gallery-item reveal" style="transition-delay:0.2s"
                     data-caption="Keberangkatan jamaah Al-Ahza di bandara" data-img="">
                    <div class="gallery-img g3">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="rgba(197,160,78,0.6)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.5a2.5 2.5 0 0 0-2.5-2.5H15l-3-9H9.5l1.5 9H7l-1.5-2H4l1 5h17z"/>
                        </svg>
                    </div>
                    <div class="gallery-caption">Keberangkatan di Bandara</div>
                </div>

                {{-- Item 4: Jamaah bersama --}}
                <div class="gallery-item reveal" style="transition-delay:0.25s"
                     data-caption="Jamaah bersama tim Al-Ahza" data-img="">
                    <div class="gallery-img g4">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="rgba(197,160,78,0.6)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <div class="gallery-caption">Foto Bersama Jamaah</div>
                </div>

                {{-- Item 5: Hotel (span 2) --}}
                <div class="gallery-item reveal" style="transition-delay:0.3s"
                     data-caption="Hotel akomodasi jamaah Al-Ahza" data-img="">
                    <div class="gallery-img g5">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="rgba(197,160,78,0.6)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </div>
                    <div class="gallery-caption">Hotel Akomodasi</div>
                </div>

                {{-- Item 6: Ziarah --}}
                <div class="gallery-item reveal" style="transition-delay:0.35s"
                     data-caption="Ziarah ke situs bersejarah Islam" data-img="">
                    <div class="gallery-img g6">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="rgba(197,160,78,0.6)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="2" y1="12" x2="22" y2="12"/>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                        </svg>
                    </div>
                    <div class="gallery-caption">Ziarah Bersejarah</div>
                </div>

                {{-- Item 7: Thawaf --}}
                <div class="gallery-item reveal" style="transition-delay:0.4s"
                     data-caption="Ibadah thawaf di Masjidil Haram" data-img="">
                    <div class="gallery-img g7">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="rgba(197,160,78,0.6)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="23 4 23 10 17 10"/>
                            <polyline points="1 20 1 14 7 14"/>
                            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
                        </svg>
                    </div>
                    <div class="gallery-caption">Ibadah Thawaf</div>
                </div>

            @endif

        </div>
    </div>
</section>

{{-- Lightbox --}}
<div class="lightbox" id="lightbox">
    <button class="lightbox-close" id="lightboxClose" aria-label="Tutup">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
    </button>
    <div class="lightbox-content">
        <img src="" id="lightboxMainImg" style="display:none;" alt="">
        <p class="lightbox-caption" id="lightboxCaption"></p>
    </div>
</div>