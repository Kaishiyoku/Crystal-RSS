<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $administrationCheckFn = function ($request) {
            if (!$request->user() || !$request->user()->is_administrator) {
                throw new UnauthorizedHttpException('Unauthorized');
            }

            return true;
        };

        Horizon::auth($administrationCheckFn);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }

        if (env('ENABLE_TELESCOPE')) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }
}
