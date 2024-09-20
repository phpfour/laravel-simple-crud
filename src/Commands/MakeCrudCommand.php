<?php declare(strict_types=1);

namespace Emran\SimpleCRUD\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeCrudCommand extends GeneratorCommand
{
    /** @inheritDoc */
    protected $name = 'make:crud-resource';

    /** @inheritDoc */
    protected $description = 'Create a new CRUD resource';

    /** @inheritDoc */
    protected $type = 'CRUD Resource';

    /** @inheritDoc */
    protected function getStub(): string
    {
        return __DIR__.'/../../stubs/crud-resource.stub';
    }

    /** @inheritDoc */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\CrudResources';
    }

    /** @inheritDoc */
    protected function buildClass($name): string
    {
        $replace = [];

        if ($this->option('model')) {
            $replace = $this->buildModelReplacements($replace);
        }

        return str_replace(
            array_keys($replace),
            array_values($replace),
            parent::buildClass($name)
        );
    }

    /**
     * Build the model replacement values.
     *
     * @param array<string, string> $replace
     * @return array<string, string>
     */
    protected function buildModelReplacements(array $replace): array
    {
        $modelClass = $this->option('model');

        if (!is_string($modelClass)) {
            throw new \InvalidArgumentException('Model must be a string.');
        }

        if (!class_exists($modelClass)) {
            if ($this->confirm("A {$modelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('make:model', ['name' => $modelClass]);
            }
        }

        return array_merge($replace, [
            '{{ modelClass }}' => $modelClass,
            '{{ modelVariable }}' => lcfirst(class_basename($modelClass)),
        ]);
    }

    /**
     * Get the console command options.
     *
     * @return array<array<string|int|null>>
     */
    protected function getOptions(): array
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model that the CRUD resource will use'],
        ];
    }
}
