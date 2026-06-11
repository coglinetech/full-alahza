// ============================================================
// NAVBAR SCROLL
// ============================================================
window.addEventListener('scroll', () => {
    document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 80);
}, { passive: true });

// ============================================================
// MOBILE DRAWER
// ============================================================
document.addEventListener('DOMContentLoaded', () => {

    const hamburger   = document.getElementById('hamburger');
    const drawer      = document.getElementById('mobileDrawer');
    const overlay     = document.getElementById('mobileOverlay');
    const drawerClose = document.getElementById('drawerClose');

    function openDrawer() {
        if (!drawer || !overlay) return;
        drawer.classList.add('open');
        overlay.classList.add('open');
        hamburger?.classList.add('active');
        hamburger?.setAttribute('aria-expanded', 'true');
        drawer.setAttribute('aria-hidden', 'false');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        if (!drawer || !overlay) return;
        drawer.classList.remove('open');
        overlay.classList.remove('open');
        hamburger?.classList.remove('active');
        hamburger?.setAttribute('aria-expanded', 'false');
        drawer.setAttribute('aria-hidden', 'true');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    hamburger?.addEventListener('click', () => {
        drawer?.classList.contains('open') ? closeDrawer() : openDrawer();
    });

    overlay?.addEventListener('click', closeDrawer);
    drawerClose?.addEventListener('click', closeDrawer);

    // Tutup drawer saat link di-klik
    drawer?.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', closeDrawer);
    });

    // Tutup drawer saat resize ke desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth > 1024) closeDrawer();
    }, { passive: true });

    // ESC key tutup drawer
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeDrawer();
    });

    // ============================================================
    // SCROLL REVEAL
    // ============================================================
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('visible');
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal, .reveal-left, .reveal-right')
        .forEach(el => revealObserver.observe(el));

    // ============================================================
    // COUNT-UP ANIMATION
    // ============================================================
    function countUp(el) {
        const target    = parseFloat(el.dataset.target);
        const isDecimal = el.dataset.decimal === 'true';
        const duration  = 2000;
        const start     = performance.now();

        function update(time) {
            const progress = Math.min((time - start) / duration, 1);
            const ease     = 1 - Math.pow(1 - progress, 3);
            const current  = target * ease;

            if (isDecimal) {
                el.textContent = current.toFixed(1) + '/5';
            } else if (target > 100) {
                el.textContent = Math.round(current).toLocaleString('id-ID') + '+';
            } else {
                el.textContent = Math.round(current) + '+';
            }

            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                el.textContent = isDecimal
                    ? target + '/5'
                    : (target > 100 ? target.toLocaleString('id-ID') : target) + '+';
            }
        }
        requestAnimationFrame(update);
    }

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                countUp(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.stat-num[data-target]')
        .forEach(el => counterObserver.observe(el));

    // ============================================================
    // FAQ ACCORDION
    // ============================================================
    document.querySelectorAll('.faq-question').forEach(btn => {
        btn.addEventListener('click', () => {
            const item   = btn.parentElement;
            const isOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
            if (!isOpen) item.classList.add('open');
        });
    });

    // ============================================================
    // TESTIMONIALS SLIDER
    // ============================================================
    const track = document.getElementById('testiTrack');
    if (track) {
        const cards         = track.querySelectorAll('.testimonial-card');
        const dotsContainer = document.getElementById('testiDots');
        const prevBtn       = document.getElementById('testiPrev');
        const nextBtn       = document.getElementById('testiNext');
        let testiIdx = 0;
        let testiAuto;

        function getVisible() {
            if (window.innerWidth >= 1024) return 3;
            if (window.innerWidth >= 640)  return 2;
            return 1;
        }

        function buildDots() {
            if (!dotsContainer) return;
            dotsContainer.innerHTML = '';
            const vis   = getVisible();
            const count = Math.max(1, cards.length - vis + 1);
            for (let i = 0; i < count; i++) {
                const d = document.createElement('div');
                d.className = 'dot' + (i === 0 ? ' active' : '');
                d.addEventListener('click', () => goTesti(i));
                dotsContainer.appendChild(d);
            }
        }

        function goTesti(idx) {
            const vis  = getVisible();
            const max  = Math.max(0, cards.length - vis);
            testiIdx   = Math.max(0, Math.min(idx, max));
            const cardW = cards[0].offsetWidth + 24;
            track.style.transform = `translateX(-${testiIdx * cardW}px)`;
            dotsContainer?.querySelectorAll('.dot')
                .forEach((d, i) => d.classList.toggle('active', i === testiIdx));
        }

        function startAuto() {
            testiAuto = setInterval(() => {
                const vis = getVisible();
                goTesti((testiIdx + 1) % Math.max(1, cards.length - vis + 1));
            }, 5000);
        }

        track.parentElement?.addEventListener('mouseenter', () => clearInterval(testiAuto));
        track.parentElement?.addEventListener('mouseleave', startAuto);

        prevBtn?.addEventListener('click', () => goTesti(testiIdx - 1));
        nextBtn?.addEventListener('click', () => goTesti(testiIdx + 1));

        buildDots();
        startAuto();
        window.addEventListener('resize', () => { buildDots(); goTesti(0); }, { passive: true });
    }

    // GALLERY LIGHTBOX
    const lightbox        = document.getElementById('lightbox');
    const lightboxClose   = document.getElementById('lightboxClose');
    const lightboxMainImg = document.getElementById('lightboxMainImg');

    document.querySelectorAll('.gallery-item').forEach(item => {
        item.addEventListener('click', () => {
            const caption = item.dataset.caption || '';
            const imgSrc  = item.dataset.img;

            if (lightbox && imgSrc) {
                const captionEl = document.getElementById('lightboxCaption');
                if (captionEl) captionEl.textContent = caption;

                // Gunakan img yang sudah ada di blade
                lightboxMainImg.src = imgSrc;
                lightboxMainImg.style.display = 'block';

                lightbox.classList.add('open');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    lightbox?.addEventListener('click', e => {
        if (e.target === lightbox) closeLightbox();
    });

    lightboxClose?.addEventListener('click', closeLightbox);

    function closeLightbox() {
        lightbox?.classList.remove('open');
        document.body.style.overflow = '';
        if (lightboxMainImg) {
            lightboxMainImg.src = '';
            lightboxMainImg.style.display = 'none';
        }
    }
    // 
});