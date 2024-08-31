<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(
            'App\Repositories\Contracts\AuthUserRepositoryInterface',
            'App\Repositories\Eloquents\AuthUserRepository'
        );

        $this->app->bind(
            'App\Repositories\Contracts\VehiclesRepositoryInterface',
            'App\Repositories\Eloquents\VehiclesRepository'
        );

        $this->app->bind(
            'App\Repositories\Contracts\SuppliersRepositoryInterface',
            'App\Repositories\Eloquents\SuppliersRepository'
        );
    }
}
