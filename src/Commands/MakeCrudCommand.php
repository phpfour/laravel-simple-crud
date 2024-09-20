<?php declare(strict_types=1);

namespace Emran\SimpleCRUD\Commands;

use Illuminate\Console\Command;

class MakeCrudCommand extends Command
{
    /** @inheritDoc */
    public $signature = 'make:simple-crud {name}';

    /** @inheritDoc */
    public $description = 'Create a Simple CRUD';

    public function handle(): int
    {
        $this->comment('WIP');

        return self::SUCCESS;
    }
}
