<?php

namespace Emran\SimpleCRUD;

use Emran\SimpleCRUD\Commands\SimpleCRUDCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
