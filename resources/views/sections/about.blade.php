<section id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-text">
                <div class="section-tag reveal-left">Tentang Kami</div>
                <h2 class="section-title reveal-left" style="transition-delay:0.1s">Tentang Al-Ahza</h2>
                <div class="divider-ornament reveal-left" style="transition-delay:0.2s"></div>
                <br>
                <p class="reveal-left" style="transition-delay:0.3s">Al-Ahza Travel Umroh didirikan dengan satu tekad
                    mulia: menghadirkan layanan perjalanan ibadah yang amanah, profesional, dan penuh keikhlasan bagi
                    seluruh masyarakat muslim Indonesia, khususnya di Ciamis dan sekitarnya.</p>
                <p class="reveal-left" style="transition-delay:0.35s">Sejak berdiri, kami telah memberangkatkan ribuan
                    jamaah ke Tanah Suci dengan standar layanan yang terus kami tingkatkan. Kepercayaan jamaah adalah
                    amanah yang kami jaga dengan sepenuh hati.</p>
                <div class="about-vision reveal-left" style="transition-delay:0.4s">
                    <strong>Visi Kami</strong>
                    <p>"Menjadi penyelenggara perjalanan ibadah Umroh terpercaya yang mengutamakan kenyamanan, keamanan,
                        dan kekhusyukan jamaah."</p>
                </div>
            </div>
            <div class="about-visual reveal-right">
                <div class="about-img-main">
                    @if ($aboutImage)
                        <img src="{{ media_url($aboutImage) }}" alt="About Al-Ahza"
                            style="width:100%;height:100%;object-fit:cover;border-radius:12px;">
                    @else
                        <!-- fallback -->
                        <div class="kabah-illustration">
                            <svg>...</svg>
                        </div>
                    @endif
                </div>
                <div class="about-img-overlay">
                    <div class="num">★ 4.9</div>
                    <div class="label">Rating Jamaah</div>
                </div>
            </div>
        </div>
    </div>
</section>
