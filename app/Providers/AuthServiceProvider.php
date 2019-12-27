<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\FeedItem;
use App\Models\FilterKeyword;
use App\Models\UpdateError;
use App\Policies\CategoryPolicy;
use App\Policies\FeedItemPolicy;
use App\Policies\FilterKeywordPolicy;
use App\Policies\UpdateErrorPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        UpdateError::class => UpdateErrorPolicy::class,
        FeedItem::class => FeedItemPolicy::class,
        FilterKeyword::class => FilterKeywordPolicy::class,
        Category::class => CategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
