<?php declare(strict_types=1);

namespace Emran\SimpleCRUD;

use Emran\SimpleCRUD\Commands\MakeCrudCommand;
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
            ->hasCommand(MakeCrudCommand::class);
    }
}
