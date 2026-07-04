<nav id="navbar">
    <a href="{{ url('/') }}" class="nav-logo">
        {{-- height dan max-width di sini adalah kunci agar logo tidak overflow --}}
        <img src="{{ asset('images/logo.png') }}" alt="Al-Ahza"
            style="height:38px; width:auto; max-width:120px; object-fit:contain; display:block; flex-shrink:0;">
        <div>
            <div class="nav-logo-sub">Travel Umroh</div>
        </div>
    </a>

    <ul class="nav-menu">
        <li><a href="{{ url('/') }}#hero">Home</a></li>
        <li><a href="{{ url('/') }}#packages">Paket Kami</a></li>
        <li><a href="{{ url('/') }}#why-us">Kenapa Al-Ahza</a></li>
        <li><a href="{{ url('/') }}#about">Tentang Kami</a></li>
        {{-- <li><a href="{{ url('/') }}#gallery">Galeri</a></li> --}}
        {{-- <li><a href="{{ url('/') }}#testimonials">Testimoni</a></li> --}}
        <li><a href="{{ url('/') }}#faq">FAQ</a></li>
    </ul>

    <a href="https://wa.me/081122869911" target="_blank" class="nav-cta">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
        </svg>
        Hubungi Kami
    </a>

    <button class="hamburger" id="hamburger" aria-label="Menu" aria-expanded="false">
        <span></span>
        <span></span>
        <span></span>
    </button>
</nav>

<div class="mobile-overlay" id="mobileOverlay" aria-hidden="true"></div>

<div class="mobile-drawer" id="mobileDrawer" aria-hidden="true">
    <button class="drawer-close" id="drawerClose" aria-label="Tutup menu">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round">
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
    </button>
    <a href="{{ url('/') }}">Home</a>
    <a href="{{ url('/') }}#packages">Paket Kami</a>
    <a href="{{ url('/') }}#why-us">Kenapa Al-Ahza</a>
    <a href="{{ url('/') }}#about">Tentang Kami</a>
    <a href="{{ url('/') }}#gallery">Galeri</a>
    <a href="{{ url('/') }}#testimonials">Testimoni</a>
    <a href="{{ url('/') }}#faq">FAQ</a>
    <a href="https://wa.me/081122869911" target="_blank" class="drawer-wa">Hubungi WhatsApp</a>
</div>
