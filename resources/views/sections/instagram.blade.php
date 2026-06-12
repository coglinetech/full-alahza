<section id="instagram">
    <div class="container">
        <div class="section-header center">
            <div class="section-tag reveal">Ikuti Perjalanan Kami</div>
            <h2 class="section-title reveal" style="transition-delay:0.1s">Preview Instagram @alahzaofficial</h2>
            <p class="section-sub reveal" style="transition-delay:0.2s">Lihat sekilas postingan terbaru dari akun
                Instagram resmi Al-Ahza. Temukan kisah perjalanan umroh, momen jamaah, dan inspirasinya di sana.</p>
            <div class="divider-ornament center reveal" style="transition-delay:0.3s"></div>
        </div>

        @php
            $instagramPosts = [
                [
                    'title' => 'Momen suci di Masjidil Haram',
                    'subtitle' => 'Kebersamaan jamaah saat ibadah di Tanah Suci.',
                    'type' => 'post',
                    'image' =>
                        'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=900&q=80',
                ],
                [
                    'title' => 'Reels perjalanan bersama jamaah',
                    'subtitle' => 'Kisah singkat yang penuh hangat dan doa selama perjalanan.',
                    'type' => 'reels',
                    'image' =>
                        'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80',
                ],
                [
                    'title' => 'Persiapan manasik umroh',
                    'subtitle' => 'Rangkaian kegiatan sebelum keberangkatan yang penuh makna.',
                    'type' => 'post',
                    'image' =>
                        'https://images.unsplash.com/photo-1487014679447-9f8336841d58?auto=format&fit=crop&w=900&q=80',
                ],
                [
                    'title' => 'Senyum jamaah sampai tujuan',
                    'subtitle' => 'Suasana bahagia menyambut ibadah suci bersama tim kami.',
                    'type' => 'reels',
                    'image' =>
                        'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=900&q=80',
                ],
            ];
        @endphp

        <div class="instagram-grid">
            @foreach ($instagramPosts as $index => $post)
                <a href="https://www.instagram.com/alahzaofficial/" class="instagram-card reveal"
                    style="transition-delay:{{ 0.1 + $index * 0.05 }}s" target="_blank" rel="noreferrer noopener">
                    <div class="instagram-card-media">
                        <img src="{{ $post['image'] }}" alt="Preview {{ $post['title'] }}" loading="lazy">
                        <div class="instagram-media-badge">
                            <span class="instagram-icon" aria-hidden="true">📷</span>
                            <span>@alahzaofficial</span>
                        </div>
                        <div class="instagram-media-type">{{ ucfirst($post['type']) }}</div>
                    </div>
                    <div class="instagram-card-body">
                        <div class="instagram-card-title">{{ $post['title'] }}</div>
                        <p class="instagram-card-desc">{{ $post['subtitle'] }}</p>
                        <div class="instagram-card-footer">Lihat postingan di Instagram</div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="instagram-cta center reveal" style="transition-delay:0.3s">
            <a href="https://www.instagram.com/alahzaofficial/" class="pkg-btn primary" target="_blank"
                rel="noreferrer noopener">Kunjungi Instagram Al-Ahza</a>
        </div>
    </div>
</section>
