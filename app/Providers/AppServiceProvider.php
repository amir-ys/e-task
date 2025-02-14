<?php

namespace App\Providers;

use App\Utilities\CustomPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->bindDependencies();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * @return void
     */
    public function bindDependencies(): void
    {
        $this->app->bind(
            LengthAwarePaginator::class,
            CustomPaginator::class
        );
    }
}
