<section id="faq">
    <div class="container">
        <div class="section-header center">
            <div class="section-tag reveal">FAQ</div>
            <h2 class="section-title reveal" style="transition-delay:0.1s">Pertanyaan yang Sering Ditanyakan</h2>
            <p class="section-sub reveal" style="transition-delay:0.2s">Temukan jawaban atas pertanyaan yang sering kami terima dari calon jamaah.</p>
            <div class="divider-ornament center reveal" style="transition-delay:0.3s"></div>
        </div>
        <div class="faq-container">

            @if($faqs && count($faqs) > 0)
                @foreach($faqs as $index => $faq)
                <div class="faq-item reveal" style="transition-delay:{{ 0.1 + ($index * 0.05) }}s">
                    <div class="faq-question">
                        {{ $faq->question }}
                        <div class="faq-icon">
                            <svg viewBox="0 0 24 24" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">{{ $faq->answer }}</div>
                    </div>
                </div>
                @endforeach
            @else
                {{-- Fallback static --}}
                <div class="faq-item reveal" style="transition-delay:0.1s">
                    <div class="faq-question">
                        Apa saja syarat untuk mendaftar umroh?
                        <div class="faq-icon"><svg viewBox="0 0 24 24" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">Syarat mendaftar umroh meliputi: (1) Paspor aktif dengan masa berlaku minimal 8 bulan, (2) KTP dan Kartu Keluarga, (3) Foto terbaru ukuran 3×4 dan 4×6 dengan background putih, (4) Buku nikah (untuk suami-istri), (5) Akte kelahiran (untuk anak), (6) Bukti pelunasan biaya paket.</div>
                    </div>
                </div>
                <div class="faq-item reveal" style="transition-delay:0.15s">
                    <div class="faq-question">
                        Dokumen apa saja yang perlu disiapkan?
                        <div class="faq-icon"><svg viewBox="0 0 24 24" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">Dokumen utama yang perlu disiapkan antara lain: paspor aktif, KTP, Kartu Keluarga, foto background putih, buku nikah (jika berangkat bersama pasangan), dan Surat Keterangan Sehat dari dokter. Tim kami akan membantu pengurusan semua dokumen tersebut.</div>
                    </div>
                </div>
                <div class="faq-item reveal" style="transition-delay:0.2s">
                    <div class="faq-question">
                        Kapan jadwal keberangkatan terdekat?
                        <div class="faq-icon"><svg viewBox="0 0 24 24" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">Jadwal keberangkatan kami bervariasi setiap bulan. Untuk informasi jadwal terbaru dan ketersediaan kursi, silakan hubungi tim kami via WhatsApp. Kami sarankan untuk mendaftar lebih awal karena kuota setiap grup terbatas.</div>
                    </div>
                </div>
                <div class="faq-item reveal" style="transition-delay:0.25s">
                    <div class="faq-question">
                        Apakah bisa bayar secara cicilan?
                        <div class="faq-icon"><svg viewBox="0 0 24 24" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">Ya, kami menyediakan skema cicilan yang fleksibel. Jamaah dapat membayar uang muka (DP) sebesar 30–50% dari total biaya paket, kemudian melunasi sisanya sesuai kesepakatan sebelum keberangkatan.</div>
                    </div>
                </div>
                <div class="faq-item reveal" style="transition-delay:0.3s">
                    <div class="faq-question">
                        Apakah Al-Ahza memiliki izin resmi dari Kemenag?
                        <div class="faq-icon"><svg viewBox="0 0 24 24" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">Ya, Al-Ahza telah terdaftar dan memiliki izin resmi dari Kementerian Agama Republik Indonesia sebagai Penyelenggara Perjalanan Ibadah Umroh (PPIU). Nomor izin kami dapat Anda cek di situs resmi Kemenag RI.</div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</section>