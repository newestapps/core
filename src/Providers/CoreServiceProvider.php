<?php

namespace Newestapps\Core\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;
use Newestapps\Core\Services\NewestappsService;
use Overtrue\LaravelLang\Commands\Publish;

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

        // Overtrue language publisher
        $this->commands(Publish::class);

        // Data structure version
        $this->app->singleton('X-NW-VERSION', function () {
            return '1.0.0';
        });

        $this->app->singleton('nw-core', NewestappsService::class);

        $this->app->singleton(Manager::class, function () {
            return new Manager();
        });
    }

    private function registerRoutes()
    {
//        Route::prefix('...')
//            ->middleware('some-middleware')
//            ->namespace('Newestapps\Core\Http\Controllers')
//            ->group(__DIR__.'/../../routes/package-routes.php');
    }


}