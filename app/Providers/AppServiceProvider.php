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
        foreach (glob(base_path('modules/*/config/*.php')) as $configFile) {
            $configName = basename($configFile, '.php');
            $configPath = dirname($configFile);
            config()->set($configName, require $configPath . "/{$configName}.php");
        }
    }
}
