<?php

namespace App\Providers;

use App\Contracts\ArticlesRepositoryContract;
use App\Repositories\ArticlesRepository;
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
