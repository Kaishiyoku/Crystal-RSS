<li class="page-item{{ ($isActive) ? ' active' : '' }}">
    {{ Html::link(PaginateRoute::pageUrl($i), $i, ['class' => 'page-link']) }}
</li>