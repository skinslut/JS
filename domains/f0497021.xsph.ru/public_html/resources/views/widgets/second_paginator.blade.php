@if ($paginator->lastPage() > 1)
<div class="second-pagination">
    <a class="second-pagination__item" {{ $paginator->previousPageUrl() ? "href={$paginator->previousPageUrl()}" : '' }}><</a>
    @if($paginator->lastPage() <= 6)
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <a class="second-pagination__item @if($paginator->currentPage() == $i) item-active @endif" href="{{ $paginator->url($i) }}">{{ $i }}</a>
        @endfor
    @else
        <a class="second-pagination__item @if($paginator->currentPage() == 1) item-active @endif" href="{{ $paginator->url(1) }}">1</a>
        @if($paginator->currentPage() >= 4)
            <a class="second-pagination__item">...</a>
        @endif
        @for ($i = $paginator->currentPage() - 1; $i <= $paginator->currentPage() + 1; $i++)
            @if($i <= 1 || $i >= $paginator->lastPage())
                @continue
            @endif
                <a class="second-pagination__item @if($paginator->currentPage() == $i) item-active @endif" href="{{ $paginator->url($i) }}">{{ $i }}</a>
        @endfor
        @if($paginator->currentPage() <= $paginator->lastPage() - 3)
            <a class="second-pagination__item">...</a>
        @endif
        <a class="second-pagination__item @if($paginator->currentPage() == $paginator->lastPage()) item-active @endif" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
    @endif
    <a class="second-pagination__item" {{ $paginator->nextPageUrl() ? "href={$paginator->nextPageUrl()}": '' }}>></a>
</div>
@endif
