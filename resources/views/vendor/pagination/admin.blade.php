@if ($paginator->hasPages())
    <nav style="display:flex;align-items:center;gap:8px;justify-content:center;flex-wrap:wrap;margin-top:16px;">
        @if ($paginator->onFirstPage())
            <span class="btn btn-secondary btn-sm" style="opacity:0.5;cursor:not-allowed;">&lsaquo; Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-secondary btn-sm" rel="prev">&lsaquo; Prev</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="btn btn-secondary btn-sm" style="opacity:0.5;cursor:default;">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="btn btn-primary btn-sm" style="cursor:default;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="btn btn-secondary btn-sm">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-secondary btn-sm" rel="next">Next &rsaquo;</a>
        @else
            <span class="btn btn-secondary btn-sm" style="opacity:0.5;cursor:not-allowed;">Next &rsaquo;</span>
        @endif
    </nav>
@endif
