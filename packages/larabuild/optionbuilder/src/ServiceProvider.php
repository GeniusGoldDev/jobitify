<?php
namespace Larabuild\Optionbuilder;
use Exception;

class ServiceProvider extends \Illuminate\Support\ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {

        $configPath = __DIR__ . '/../config/optionbuilder.php';
        $this->mergeConfigFrom($configPath, 'optionbuilder');
        $this->app->bind('settings', function($app) {
            return new Settings();
        });

        require_once('helpers.php');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'optionbuilder');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'optionbuilder');

        $this->publishes([
            __DIR__.'/../config/optionbuilder.php' => config_path('optionbuilder.php')
        ], 'config');
        
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/optionbuilder'),
        ], 'assets');

        $this->publishes([
            __DIR__.'/../routes' => base_path('routes'),
        ], 'routes');

        $this->publishes([
            __DIR__.'/../demo/settings' => app_path('Optionbuilder'),
        ], 'demosettings');

        if( !$this->app->runningInConsole() ){
            if ( empty(config('optionbuilder')) ) {
                throw new Exception("No optionbuilder config found, please run: php artisan vendor:publish --provider=\"Larabuild\Optionbuilder\ServiceProvider\" --tag=config");
            }
        }

    }
}

