<?php

namespace Weeq\Init;

use Weeq\Init\Providers\RouteServiceProvider;
use Illuminate\Support\ServiceProvider;

class InitServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'init');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'init');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('init.php'),
            ], 'init-config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views'),
            ], 'init-views');
            
            
            // Publishing assets.
            $this->publishes([
                __DIR__.'/../resources/js' => resource_path('/js'),
                __DIR__. '/../package.json' =>  base_path('package.json'),
                __DIR__. '/../webpack.mix.js' =>  base_path('webpack.mix.js'),
                __DIR__. '/../tailwind.config.js' =>  base_path('tailwind.config.js'),
            ], 'init-assets');

            // Publishing the translation files.
            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang'),
            ], 'init-lang');

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'init');

        // Register the main class to use with the facade
        $this->app->singleton('init', function () {
            return new Init;
        });
    }
}
