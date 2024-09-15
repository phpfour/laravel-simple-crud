<?php

namespace Emran\SimpleCRUD;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Emran\SimpleCRUD\Commands\SimpleCRUDCommand;

class SimpleCRUDServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-simple-crud')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_simple_crud_table')
            ->hasCommand(SimpleCRUDCommand::class);
    }
}
