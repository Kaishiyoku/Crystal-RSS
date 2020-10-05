<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

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
        $isAdministrator = $this->auth->check() && $this->auth->user()->is_administrator;

        \LaravelMenu::register()
            ->addClassNames('mr-auto')
            ->linkIf($this->auth->check(), 'feed.index,feed.category', '<i class="fas fa-rss"></i> ' . '<span class="d-lg-none d-xl-inline">' . __('common.nav.feed') . '</span>', true)
            ->linkIf($this->auth->check(), 'feed.search_show,feed.search_result', '<i class="fas fa-search"></i> ' . '<span class="d-lg-none d-xl-inline">' . __('common.nav.search') . '</span>', true)
            ->linkIf($this->auth->check(), 'statistics.index', '<i class="fas fa-chart-bar"></i> ' . '<span class="d-lg-none d-xl-inline">' . __('common.nav.statistics') . '</span>')
            ->linkIf(!$this->auth->check(), 'home.index', '<i class="fas fa-home"></i> ' . '<span class="d-lg-none d-xl-inline">' . __('common.nav.landing_page') . '</span>');

        \LaravelMenu::register('user')
            ->dropdownIf($this->auth->check(), '<i class="fas fa-user"></i> <span class="hidden md:inline">' . optional($this->auth->user())->name . '</span> ', \LaravelMenu::dropdownContainer()
                ->header(__('common.nav.general'))
                ->link('feed.history', '<i class="fas fa-history"></i> ' . __('common.nav.history'))
                ->link('profile.index,profile.edit_password,profile.edit_email,profile.confirm_new_email', '<i class="fas fa-user"></i> ' . __('common.nav.profile'))
                ->header(__('common.nav.manage'))
                ->link('feed.manage.index,feed.manage.create,feed.manage.edit', '<i class="fas fa-rss"></i> ' . __('common.nav.feed'))
                ->link('categories.index,categories.create,categories.edit', '<i class="fas fa-folder"></i> ' . __('common.nav.categories'))
                ->link('filter_keywords.index,filter_keywords.create,filter_keywords.edit', '<i class="fas fa-filter"></i> ' . __('common.nav.filter_keywords'))
                ->headerIf($isAdministrator, __('common.nav.administration'))
                ->linkIf($isAdministrator, 'horizon.index', '<i class="fas fa-compass"></i> ' . __('common.nav.horizon'))
                ->linkIf($isAdministrator, 'update_errors.index,update_errors.show', '<i class="fas fa-exclamation-triangle"></i> ' . __('common.nav.update_errors'))
                ->divider()
                ->link('logout', '<i class="fas fa-sign-out-alt"></i> ' . __('common.nav.logout'))
            )
            ->linkIf(!$this->auth->check(), 'login', '<i class="fas fa-sign-in-alt"/> ' . __('common.nav.login'))
            ->linkIf(!$this->auth->check(), 'register', '<i class="fas fa-user-plus"/> ' . __('common.nav.register'));

        return $next($request);
    }
}
