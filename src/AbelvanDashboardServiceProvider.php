<?php

namespace Abelvan\Dashboard;

use Illuminate\Support\ServiceProvider;

class AbelvanDashboardServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/config/AbelvanDashboard.php', 'dashboard');

        // Register the main class to use with the facade
        $this->app->singleton('abelvan', function () {
            return new DashboardFacade;
        });

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('DashboardFacade', Abelvan\Dashboard\DashboardFacade::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        $this->publishes([
            __DIR__.'/config/AbelvanDashboard.php' => config_path('AbelvanDashboard.php'),
        ], 'Abelvan-config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/dashboard'),
        ], 'Abelvan-views');

        

        $this->loadViewsFrom(__DIR__.'/resources/views', 'Abelvan');

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/dashboard'),
        ], 'assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/dashboard'),
        ], 'lang');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
