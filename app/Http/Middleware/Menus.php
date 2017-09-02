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

        if ($this->auth->check()) {
            Menu::registerDefault([
                Menu::link('feed.index', '<i class="fa fa-rss" aria-hidden="true"></i> ' . '<span class="d-lg-none d-xl-inline">' . trans('common.nav.feed') . '</span>')
            ], ['class' => 'navbar-nav mr-auto']);
        } else {
            Menu::registerDefault([
                Menu::link('home.index', '<i class="fa fa-home" aria-hidden="true"></i> ' . '<span class="d-lg-none d-xl-inline">' . trans('common.nav.landing_page') . '</span>')
            ], ['class' => 'navbar-nav mr-auto']);
        }

        if ($this->auth->check()) {
            Menu::register('user', [
                Menu::dropdown([
                    Menu::dropdownHeader(trans('common.nav.general')),
                    Menu::link('feed.history', '<i class="fa fa-history" aria-hidden="true"></i> ' . trans('common.nav.history')),
                    Menu::dropdownHeader(trans('common.nav.manage')),
                    Menu::link('feed.manage.index', '<i class="fa fa-rss" aria-hidden="true"></i> ' . trans('common.nav.feed'), [], [], ['feed.manage.create', 'feed.manage.edit']),
                    Menu::link('categories.index', '<i class="fa fa-folder" aria-hidden="true"></i> ' . trans('common.nav.categories'), [], [], ['categories.create', 'categories.edit']),
                    Menu::dropdownDivider(),
                    Menu::link('logout', '<i class="fa fa-sign-out" aria-hidden="true"></i> ' . trans('common.nav.logout'), [], ['data-click' => '#logout-form'])

                ], '<i class="fa fa-user" aria-hidden="true"></i> ' . $this->auth->user()->name . ' ', null, [], ['class' => 'dropdown-menu-right'])
            ], ['class' => 'navbar-nav']);
        } else {
            Menu::register('user', [
                Menu::link('login', '<i class="fa fa-sign-in" aria-hidden="true"></i> ' . trans('common.nav.login')),
                Menu::link('register', '<i class="fa fa-user-plus" aria-hidden="true"></i> ' . trans('common.nav.register'))
            ], ['class' => 'navbar-nav']);
        }

        if ($this->auth->check() && $this->auth->user()->is_administrator) {
            Menu::register('administration', [

            ], ['class' => 'navbar-nav mr-auto']);

            Menu::register('administration-user', [

            ], ['class' => 'navbar-nav']);
        }

        return $next($request);
    }
}
