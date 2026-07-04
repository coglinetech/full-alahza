<section id="packages">
    <div class="container">
        <div class="section-header center">
            <div class="section-tag reveal">Paket Perjalanan</div>
            <h2 class="section-title reveal" style="transition-delay:0.1s">Paket Perjalanan Kami</h2>
            <p class="section-sub reveal" style="transition-delay:0.2s">Pilih paket ibadah yang sesuai dengan kebutuhan dan kemampuan Anda.</p>
            <div class="divider-ornament center reveal" style="transition-delay:0.3s"></div>
        </div>
        <div class="packages-grid">

            @if($packages && count($packages) > 0)
                @foreach($packages as $index => $package)
                @php
                    $badges = [
                        'umroh_reguler' => ['label' => 'Terpopuler',     'class' => ''],
                        'umroh_plus'    => ['label' => 'Premium',        'class' => 'vip'],
                    ];
                    $isFeatured = $package->category === 'umroh_plus';
                    $isPrimary  = $package->category === 'umroh_reguler';
                    $badge      = $badges[$package->category] ?? ['label' => 'Paket', 'class' => ''];
                    $checkColor = $isFeatured ? 'background:linear-gradient(135deg,#2E7D52,#1a5c38)' : '';
                @endphp
                <div class="package-card {{ $isFeatured ? 'featured' : '' }} reveal" style="transition-delay:{{ ($index+1)*0.1 }}s">
                    @if($badge['label'])
                        <div class="pkg-badge {{ $badge['class'] === 'vip' ? 'vip' : '' }}"
                             @if($badge['class'] === 'green') style="background:#e8f5ee;color:#1a5c38;" @endif>
                            {{ $badge['label'] }}
                        </div>
                    @endif

                    {{-- Foto / Brosur --}}
                    <div class="pkg-photo">
                        @if(has_media($package->image_path))
                            <img src="{{ media_url($package->image_path) }}" 
                                alt="{{ $package->name }}" 
                                loading="lazy">
                        @else
                            <div class="pkg-photo-placeholder">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="rgba(197,160,78,0.35)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                                <span>Brosur segera hadir</span>
                            </div>
                        @endif
                    </div>

                    {{-- Body --}}
                    <div class="pkg-body">
                        <div class="pkg-name">{{ $package->name }}</div>
                        <div class="pkg-duration">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $package->duration }}
                        </div>
                        <div class="pkg-price-label">Mulai dari</div>
                        <div class="pkg-price-main">{{ $package->formatted_price }}</div>

                        @if($package->highlights)
                        <ul class="pkg-highlights">
                            @foreach($package->highlights as $h)
                            <li>
                                <div class="check-icon" @if($isFeatured) style="{{ $checkColor }}" @endif>
                                    <svg viewBox="0 0 12 12" stroke-width="2" stroke="white" fill="none"><polyline points="2 6 5 9 10 3"/></svg>
                                </div>
                                {{ $h }}
                            </li>
                            @endforeach
                        </ul>
                        @endif

                        <a href="{{ route('package.detail', $package->slug) }}"
                           class="pkg-btn {{ $isPrimary ? 'primary' : '' }}">
                            Detail Paket
                        </a>
                    </div>
                </div>
                @endforeach

            @else
                {{-- Fallback static --}}
                @php
                $staticCards = [
                    [
                        'name' => 'Umroh Reguler', 'slug' => 'umroh-reguler',
                        'duration' => '9 Hari / 12 Hari', 'price' => 'Rp 25.000.000',
                        'badge' => 'Terpopuler', 'badgeClass' => '', 'featured' => false, 'primary' => true,
                        'highlights' => ['Pesawat PP langsung', 'Hotel bintang 4 dekat Masjidil Haram', 'Visa umroh & asuransi perjalanan', 'Makan 3× sehari, Muthawif berpengalaman', 'Manasik lengkap & ziarah Madinah'],
                    ],
                    [
                        'name' => 'Umroh Plus', 'slug' => 'umroh-plus',
                        'duration' => '12–15 Hari', 'price' => 'Rp 35.000.000',
                        'badge' => 'Premium', 'badgeClass' => 'vip', 'featured' => true, 'primary' => false,
                        'highlights' => ['Semua fasilitas paket reguler', 'Destinasi tambahan (Turki / Dubai / Mesir / Aqsa)', 'City tour & guide lokal berpengalaman', 'Hotel bintang 4–5 di semua destinasi', 'Dokumentasi perjalanan profesional'],
                    ],
                ];
                @endphp
                @foreach($staticCards as $i => $card)
                <div class="package-card {{ $card['featured'] ? 'featured' : '' }} reveal" style="transition-delay:{{ ($i+1)*0.1 }}s">
                    <div class="pkg-badge {{ $card['badgeClass'] === 'vip' ? 'vip' : '' }}">{{ $card['badge'] }}</div>
                    <div class="pkg-photo">
                        <div class="pkg-photo-placeholder">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="rgba(197,160,78,0.35)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21"/>
                            </svg>
                            <span>Brosur segera hadir</span>
                        </div>
                    </div>
                    <div class="pkg-body">
                        <div class="pkg-name">{{ $card['name'] }}</div>
                        <div class="pkg-duration">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $card['duration'] }}
                        </div>
                        <div class="pkg-price-label">Mulai dari</div>
                        <div class="pkg-price-main">{{ $card['price'] }}</div>
                        <ul class="pkg-highlights">
                            @foreach($card['highlights'] as $h)
                            <li>
                                <div class="check-icon" @if($card['featured']) style="background:linear-gradient(135deg,#2E7D52,#1a5c38)" @endif>
                                    <svg viewBox="0 0 12 12" stroke-width="2" stroke="white" fill="none"><polyline points="2 6 5 9 10 3"/></svg>
                                </div>
                                {{ $h }}
                            </li>
                            @endforeach
                        </ul>
                        <a href="/paket/{{ $card['slug'] }}" class="pkg-btn {{ $card['primary'] ? 'primary' : '' }}">
                            Detail Paket
                        </a>
                    </div>
                </div>
                @endforeach
            @endif

        </div>
    </div>
</section>