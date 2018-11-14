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

        $adminLinks = $isAdministrator ? [
            Menu::dropdownHeader(__('common.nav.administration')),
            Menu::link('/horizon', '<i class="fa fa-compass" aria-hidden="true"></i> ' . __('common.nav.horizon')),
        ] : [];

        Menu::setConfig(Config::forBootstrap4());

        if ($isLoggedIn) {
            Menu::registerDefault([
                Menu::linkRoute('feed.index', '<i class="fa fa-rss" aria-hidden="true"></i> ' . '<span class="d-lg-none d-xl-inline">' . __('common.nav.feed') . '</span>', [], [], ['feed.category']),
                Menu::linkRoute('feed.search_show', '<i class="fa fa-search" ariad-hidden="true"></i> ' . '<span class="d-lg-none d-xl-inline">' . __('common.nav.search') . '</span>', [], [], ['feed.search_result'])
            ], ['class' => 'navbar-nav mr-auto']);

            Menu::register('user', [
                Menu::dropdown(array_merge([
                    Menu::dropdownHeader(__('common.nav.general')),
                    Menu::linkRoute('feed.history', '<i class="fa fa-history" aria-hidden="true"></i> ' . __('common.nav.history')),
                    Menu::linkRoute('profile.index', '<i class="fa fa-user" aria-hidden="true"></i> ' . __('common.nav.profile'), [], [], ['profile.edit_password', 'profile.edit_email', 'profile.confirm_new_email']),
                    Menu::dropdownHeader(__('common.nav.manage')),
                    Menu::linkRoute('feed.manage.index', '<i class="fa fa-rss" aria-hidden="true"></i> ' . __('common.nav.feed'), [], [], ['feed.manage.create', 'feed.manage.edit']),
                    Menu::linkRoute('categories.index', '<i class="fa fa-folder" aria-hidden="true"></i> ' . __('common.nav.categories'), [], [], ['categories.create', 'categories.edit']),
                ], $adminLinks, [
                    Menu::dropdownDivider(),
                    Menu::linkRoute('logout', '<i class="fa fa-sign-out" aria-hidden="true"></i> ' . __('common.nav.logout'), [], ['data-click' => '#logout-form']),
                ]), '<i class="fa fa-user" aria-hidden="true"></i> ' . $this->auth->user()->name . ' ', null, [], ['class' => 'dropdown-menu-right'])
            ], ['class' => 'navbar-nav']);
        } else {
            Menu::registerDefault([
                Menu::linkRoute('home.index', '<i class="fa fa-home" aria-hidden="true"></i> ' . '<span class="d-lg-none d-xl-inline">' . __('common.nav.landing_page') . '</span>')
            ], ['class' => 'navbar-nav mr-auto']);

            Menu::register('user', [
                Menu::linRoutek('login', '<i class="fa fa-sign-in" aria-hidden="true"></i> ' . __('common.nav.login')),
                Menu::linkRoute('register', '<i class="fa fa-user-plus" aria-hidden="true"></i> ' . __('common.nav.register'))
            ], ['class' => 'navbar-nav']);
        }

        return $next($request);
    }
}
