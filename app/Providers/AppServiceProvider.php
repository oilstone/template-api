<?php

namespace App\Providers;

use App\Factories\Stitch as StitchFactory;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Schema;
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
        $this->app->singleton('Illuminate\Contracts\Routing\ResponseFactory', function ($app) {
            return new ResponseFactory(
                $app['Illuminate\Contracts\View\Factory'],
                $app['Illuminate\Routing\Redirector']
            );
        });

        StitchFactory::boot();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     * @noinspection PhpUndefinedMethodInspection
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Queue::after(function () {
            Log::getLogger()->close();
        });
    }
}
