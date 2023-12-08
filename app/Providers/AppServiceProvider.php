<?php

namespace App\Providers;

use App\Models\category;
use Illuminate\Pagination\Paginator;
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

        Paginator::useBootstrapFive();
        view()->composer('layouts/frontend_master', function($test){
            $categories = category::with('subcategories')->get();
            $test->with('categories', $categories);
        });
    }
}
