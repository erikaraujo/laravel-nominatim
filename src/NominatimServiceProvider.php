<?php

namespace ErikAraujo\Nominatim;

use Illuminate\Support\ServiceProvider;

class NominatimServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
            __DIR__.'/../config/nominatim.php' => config_path('nominatim.php'),
            ], 'config');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/nominatim.php', 'nominatim');

        $this->app->bind('nominatim', function () {
            return new Nominatim();
        });
    }
}
