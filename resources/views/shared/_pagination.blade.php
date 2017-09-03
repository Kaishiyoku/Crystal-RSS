@if ($items->lastPage() > 1)
    <ul class="pagination mt-4 mr-2 d-inline-flex">
        @if (PaginateRoute::hasPreviousPage())
            <li class="page-item">
                {{ Html::link(PaginateRoute::previousPageUrl(), '&laquo;', ['class' => 'page-link']) }}
            </li>
        @else
            <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">«</span>
                </a>
            </li>
        @endif
    </ul>

    @foreach ($ranges = getPageRanges($items->currentPage(), $items->lastPage()) as $a => $range)
        <ul class="pagination mt-4 d-inline-flex">
            @for ($i = $range['start']; $i <= $range['end']; $i++)
                @include('shared._page_link', ['isActive' => $items->currentPage() == $i, 'i' => $i])
            @endfor
        </ul>

        @if ($a != count($ranges) - 1)
            ...
        @endif
    @endforeach

    <ul class="pagination mt-4 ml-2 d-inline-flex">
        @if (PaginateRoute::hasNextPage($items))
            <li class="page-item">
                {{ Html::link(PaginateRoute::nextPageUrl($items), '&raquo;', ['class' => 'page-link']) }}
            </li>
        @else
            <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        @endif
    </ul>
@endif