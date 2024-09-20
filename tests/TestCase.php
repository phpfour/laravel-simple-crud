<?php declare(strict_types=1);

namespace Emran\SimpleCRUD\Tests;

use Emran\SimpleCRUD\SimpleCRUDServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn(string $modelName) => 'Emran\\SimpleCRUD\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    /** @inheritDoc */
    protected function getPackageProviders($app)
    {
        return [
            SimpleCRUDServiceProvider::class,
        ];
    }

    /** @inheritDoc */
    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
