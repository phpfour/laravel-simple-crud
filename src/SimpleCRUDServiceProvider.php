<?php declare(strict_types=1);

namespace Emran\SimpleCRUD;

use Emran\SimpleCRUD\Commands\MakeCrudCommand;
use Emran\SimpleCRUD\Commands\MakeCrudControllerCommand;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SimpleCRUDServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-simple-crud')
            ->hasConfigFile()
            ->hasViews()
            ->hasCommands([
                MakeCrudCommand::class,
                MakeCrudControllerCommand::class,
            ]);
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(SimpleCRUD::class, function () {
            return new SimpleCRUD();
        });
    }

    public function packageBooted(): void
    {
        $this->registerRouteMacro();
        $this->registerBladeComponents();
    }

    protected function registerRouteMacro(): void
    {
        Route::macro('simpleCrud', function (string $name, string $controller) {
            Route::get($name, [$controller, 'index'])->name("$name.index");
            Route::get("$name/create", [$controller, 'create'])->name("$name.create");
            Route::post($name, [$controller, 'store'])->name("$name.store");
            Route::get("$name/{id}", [$controller, 'show'])->name("$name.show");
            Route::get("$name/{id}/edit", [$controller, 'edit'])->name("$name.edit");
            Route::put("$name/{id}", [$controller, 'update'])->name("$name.update");
            Route::delete("$name/{id}", [$controller, 'destroy'])->name("$name.destroy");
        });
    }

    protected function registerBladeComponents(): void
    {
        Blade::component('simple-crud::components.field-wrapper', 'simple-crud-field-wrapper');
    }
}
