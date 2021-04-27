<div style="justify-content: space-evenly;" class="d-flex w-100 primary-pagination">
    <a class="primary-button" {{ $paginator->previousPageUrl() ? "href={$paginator->previousPageUrl()}" : '' }} class="mr-2 w-50" {{ $paginator->currentPage() === $paginator->firstItem() ? 'disabled' : '' }}>Назад</a>
    <a class="primary-button" {{ $paginator->nextPageUrl() ? "href={$paginator->nextPageUrl()}": '' }} class="ml-2 w-50" {{ $paginator->currentPage() === $paginator->lastPage() ? 'disabled' : '' }}>Вперед</a>
</div>

