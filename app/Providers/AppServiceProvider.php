<?php

namespace App\Providers;

use App\Contracts\ArticlesRepositoryContract;
use App\Contracts\TagsRepositoryContract;
use App\Repositories\ArticlesRepository;
use App\Repositories\TagsRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ArticlesRepositoryContract::class, ArticlesRepository::class);
        $this->app->bind(TagsRepositoryContract::class, TagsRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
