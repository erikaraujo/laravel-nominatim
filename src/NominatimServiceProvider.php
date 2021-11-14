<?php

namespace ErikAraujo\Nominatim;

use ErikAraujo\Nominatim\Commands\NominatimCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NominatimServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-nominatim')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-nominatim_table')
            ->hasCommand(NominatimCommand::class);
    }
}
