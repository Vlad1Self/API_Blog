<?php

namespace App\Providers;

use App\Contracts\CategoryContract;
use App\Contracts\PostContract;
use App\Contracts\TagContract;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryContract::class, CategoryService::class);
        $this->app->bind(TagContract::class, TagService::class);
        $this->app->bind(PostContract::class, PostService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
