<section id="banner-iklan">
    <div class="container">
        @if($banners && count($banners) > 0)
            @foreach($banners as $banner)
            <div class="banner-iklan-card reveal">
                @if(has_media($banner->image_path))
                <div class="banner-iklan-bg">
                    <img src="{{ media_url($banner->image_path) }}" alt="{{ $banner->title }}" loading="lazy">
                </div>
                @endif
                <div class="banner-iklan-overlay"></div>
                <div class="banner-iklan-content">
                    @if($banner->subtitle)
                    <div class="banner-iklan-tag">{{ $banner->subtitle }}</div>
                    @endif
                    <h3 class="banner-iklan-title">{{ $banner->title }}</h3>
                    @if($banner->link_url)
                    <a href="{{ $banner->link_url }}" class="banner-iklan-btn" target="_blank" rel="noopener">
                        {{ $banner->link_label ?? 'Selengkapnya' }}
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        @endif
    </div>
</section> 
