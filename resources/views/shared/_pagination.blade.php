@if ($items->lastPage() > 1)
    <ul class="pagination mt-4">
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

        @for ($i = 1; $i <= $items->lastPage(); $i++)
            <li class="page-item{{ ($items->currentPage() == $i) ? ' active' : '' }}">
                {{ Html::link(PaginateRoute::pageUrl($i), $i, ['class' => 'page-link']) }}
            </li>
        @endfor

        @if(PaginateRoute::hasNextPage($items))
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