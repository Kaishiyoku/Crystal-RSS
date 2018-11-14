<li class="nav-item dropdown">
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-globe" aria-hidden="true"></i>
        <span class="d-sm-inline d-lg-none d-xl-inline">{{ upper(Session::get('locale')) }}</span>
        <span class="caret"></span>
    </a>

    <div class="dropdown-menu" role="menu">
        @foreach (config('app.available_locales') as $locale)
            <a class="dropdown-item{{ Session::get('locale') == $locale ? ' active' : '' }}" href="{{ route('language.change') }}" onclick="event.preventDefault(); document.getElementById('lang-form-{{ $locale }}').submit();">
                {{ __('common.languages.' . $locale) }}
            </a>

            {{ Form::open(['route' => 'language.change', 'method' => 'post', 'id' => 'lang-form-' . $locale, 'style' => 'display: none;']) }}
            {{ Form::hidden('locale', $locale) }}
            {{ Form::close() }}
        @endforeach
    </div>
</li>