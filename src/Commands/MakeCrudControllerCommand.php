<?php declare(strict_types=1);

namespace Emran\SimpleCRUD\Commands;

use Illuminate\Console\Command;

class MakeCrudControllerCommand extends Command
{
    /** @inheritDoc */
    public $signature = 'make:simple-crud-controller {name}';

    /** @inheritDoc */
    public $description = 'Create a Simple CRUD Controller';

    public function handle(): int
    {
        $this->comment('WIP');

        return self::SUCCESS;
    }
}
