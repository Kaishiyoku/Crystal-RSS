<div class="navbar-link cursor-pointer select-none" data-provide-dropdown data-dropdown-target="#language-dropdown">
    <a>
        <i class="fas fa-globe-europe"></i>
        {{ upper(Session::get('locale')) }}
        <i class="fas fa-caret-down mt-1"></i>
    </a>

    <div id="language-dropdown" class="dropdown hidden rounded-md shadow-xl">
        @foreach (config('app.available_locales') as $locale)
            <a
                id="lang-link-{{ $locale }}"
                class="block dropdown-item {{ (Session::get('locale') === $locale ? ' dropdown-item-active' : '') }}"
                onclick="event.preventDefault(); document.getElementById('lang-form-{{ $locale }}').submit();"
            >
                {{ __('common.languages.' . $locale) }}
            </a>

            {{ Form::open(['route' => 'language.change', 'method' => 'post', 'id' => 'lang-form-' . $locale, 'style' => 'display: none;']) }}
                {{ Form::hidden('locale', $locale) }}
            {{ Form::close() }}
        @endforeach
    </div>
</div>
