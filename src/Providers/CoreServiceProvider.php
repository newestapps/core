<?php

namespace Newestapps\Core\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/nw.php', 'nw');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->app->make(Factory::class)->load(__DIR__.'/../../database/factories.php');

        $this->publishes([
            __DIR__.'/../../config/nw.php' => config_path('nw.php'),
        ], 'config');

//        $this->registerRoutes();
    }

    private function registerRoutes()
    {
//        Route::prefix('...')
//            ->middleware('some-middleware')
//            ->namespace('Newestapps\Core\Http\Controllers')
//            ->group(__DIR__.'/../../routes/package-routes.php');
    }


}