<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PlanteRepositoryInterface;
use App\Repositories\PlanteRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
{
    $this->app->bind(
        \App\Repositories\Interface\PlanteRepositoryInterface::class,
        \App\Repositories\PlanteRepository::class
    );
    $this->app->bind(
        \App\Repositories\Interface\CategoryRepositoryInterface::class,
        \App\Repositories\CategoryRepository::class
    );
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
