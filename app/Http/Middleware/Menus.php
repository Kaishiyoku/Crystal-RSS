<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Kaishiyoku\Menu\Config\Config;
use Kaishiyoku\Menu\Facades\Menu;
use MikeAlmond\Color\Color;

class Menus
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Menu::setConfig(Config::forBootstrap4());

        $isLoggedIn = $this->auth->check();
        $isAdministrator = $isLoggedIn && $this->auth->user()->is_administrator;

        $administrationLinks = removeNulls(itemIf([
            Menu::dropdownHeader(__('common.nav.administration')),
            Menu::link('/horizon', '<i class="fas fa-compass"></i> ' . __('common.nav.horizon')),
            Menu::linkRoute('update_errors.index', '<i class="fas fa-exclamation-triangle"></i> ' . __('common.nav.update_errors'), [], [], ['update_errors.show']),
        ], $isAdministrator, []));

        Menu::setConfig(Config::forBootstrap4());

        if ($isLoggedIn) {
            Menu::registerDefault([
                Menu::linkRoute('feed.index', '<i class="fas fa-rss"></i> ' . '<span class="d-lg-none d-xl-inline">' . __('common.nav.feed') . '</span>', [], [], ['feed.category']),
                Menu::linkRoute('feed.search_show', '<i class="fas fa-search"></i> ' . '<span class="d-lg-none d-xl-inline">' . __('common.nav.search') . '</span>', [], [], ['feed.search_result']),
                Menu::linkRoute('statistics.index', '<i class="fas fa-chart-bar"></i> ' . '<span class="d-lg-none d-xl-inline">' . __('common.nav.statistics') . '</span>'),
            ], ['class' => 'navbar-nav mr-auto']);

            Menu::register('user', [
                Menu::dropdown(array_merge([
                    Menu::dropdownHeader(__('common.nav.general')),
                    Menu::linkRoute('feed.history', '<i class="fas fa-history"></i> ' . __('common.nav.history')),
                    Menu::linkRoute('profile.index', '<i class="fas fa-user"></i> ' . __('common.nav.profile'), [], [], ['profile.edit_password', 'profile.edit_email', 'profile.confirm_new_email']),
                    Menu::dropdownHeader(__('common.nav.manage')),
                    Menu::linkRoute('feed.manage.index', '<i class="fas fa-rss"></i></i> ' . __('common.nav.feed'), [], [], ['feed.manage.create', 'feed.manage.edit']),
                    Menu::linkRoute('categories.index', '<i class="fas fa-folder"></i> ' . __('common.nav.categories'), [], [], ['categories.create', 'categories.edit']),
                    Menu::linkRoute('filter_keywords.index', '<i class="fas fa-filter"></i> ' . __('common.nav.filter_keywords'), [], [], ['filter_keywords.create', 'filter_keywords.edit']),
                ], $administrationLinks, [
                    Menu::dropdownDivider(),
                    Menu::linkRoute('logout', '<i class="fas fa-sign-out-alt"></i> ' . __('common.nav.logout'), [], ['data-click' => '#logout-form']),
                ]), '<i class="fas fa-user"></i> ' . $this->auth->user()->name . ' ', null, [], ['class' => 'dropdown-menu-right'])
            ], ['class' => 'navbar-nav']);
        } else {
            Menu::registerDefault([
                Menu::linkRoute('home.index', '<i class="fas fa-home"></i> ' . '<span class="d-lg-none d-xl-inline">' . __('common.nav.landing_page') . '</span>')
            ], ['class' => 'navbar-nav mr-auto']);

            Menu::register('user', [
                Menu::linkRoute('login', '<i class="fas fa-sign-in-alt"></i> ' . __('common.nav.login')),
                Menu::linkRoute('register', '<i class="fas fa-user-plus"></i> ' . __('common.nav.register'))
            ], ['class' => 'navbar-nav']);
        }

        return $next($request);
    }
}
