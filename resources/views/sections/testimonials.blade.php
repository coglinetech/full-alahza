<section id="testimonials">
    <div class="container">
        <div class="section-header center">
            <div class="section-tag reveal">Testimoni</div>
            <h2 class="section-title reveal" style="transition-delay:0.1s">Kata Jamaah Kami</h2>
            <p class="section-sub reveal" style="transition-delay:0.2s">Pengalaman nyata dari jamaah yang telah mempercayakan perjalanan suci mereka kepada Al-Ahza.</p>
            <div class="divider-ornament center reveal" style="transition-delay:0.3s"></div>
        </div>
        <div class="testimonials-slider reveal" style="transition-delay:0.4s">
            <div class="testimonials-track" id="testiTrack">

                @if($testimonials && count($testimonials) > 0)
                    @foreach($testimonials as $t)
                    <div class="testimonial-card">
                        <div class="testi-quote">"</div>
                        <div class="testi-stars">
                            @for($i = 0; $i < $t->rating; $i++)★@endfor
                        </div>
                        <p class="testi-content">{{ $t->content }}</p>
                        <div class="testi-person">
                            <div class="testi-avatar">{{ $t->initials }}</div>
                            <div>
                                <div class="testi-name">{{ $t->name }}</div>
                                <div class="testi-meta">{{ $t->city }}{{ $t->package_name ? ' · ' . $t->package_name : '' }}{{ $t->year ? ' ' . $t->year : '' }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    {{-- Fallback static --}}
                    <div class="testimonial-card">
                        <div class="testi-quote">"</div>
                        <div class="testi-stars">★★★★★</div>
                        <p class="testi-content">Pelayanan sangat memuaskan, hotel dekat Masjidil Haram, ustadz membimbing dengan sabar dan penuh ilmu. Alhamdulillah, ibadah kami terasa sangat khusyuk dan berkesan.</p>
                        <div class="testi-person">
                            <div class="testi-avatar">SA</div>
                            <div>
                                <div class="testi-name">Hj. Siti Aminah</div>
                                <div class="testi-meta">Ciamis · Umroh Reguler 2024</div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testi-quote">"</div>
                        <div class="testi-stars">★★★★★</div>
                        <p class="testi-content">Alhamdulillah, perjalanan lancar dan sangat nyaman. Semua urusan dari visa hingga hotel diurus dengan profesional. Terima kasih banyak Al-Ahza, insya Allah kami akan kembali!</p>
                        <div class="testi-person">
                            <div class="testi-avatar">AF</div>
                            <div>
                                <div class="testi-name">Ust. Ahmad Fauzi</div>
                                <div class="testi-meta">Tasikmalaya · Umroh Plus 2024</div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testi-quote">"</div>
                        <div class="testi-stars">★★★★★</div>
                        <p class="testi-content">Pertama kali umroh dan semuanya diurus dengan sangat baik. Saya yang awam pun merasa aman dan terbimbing dari awal hingga akhir. Insya Allah berangkat lagi tahun depan!</p>
                        <div class="testi-person">
                            <div class="testi-avatar">NR</div>
                            <div>
                                <div class="testi-name">Ibu Neng Rika</div>
                                <div class="testi-meta">Bandung · Umroh Reguler 2023</div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testi-quote">"</div>
                        <div class="testi-stars">★★★★★</div>
                        <p class="testi-content">Umroh plus premium-nya luar biasa! Hotel bintang 5, jalan kaki ke Masjidil Haram, pelayanan VIP yang benar-benar terasa. Al-Ahza membuktikan bahwa ibadah bisa dilakukan dengan nyaman. Sangat recommended!</p>
                        <div class="testi-person">
                            <div class="testi-avatar">DM</div>
                            <div>
                                <div class="testi-name">Bpk. Dedi Mulyadi</div>
                                <div class="testi-meta">Banjar · Umroh Plus Premium 2023</div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
        <div class="testi-controls">
            <button class="testi-btn" id="testiPrev">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <div class="testi-dots" id="testiDots"></div>
            <button class="testi-btn" id="testiNext">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>
    </div>
</section>