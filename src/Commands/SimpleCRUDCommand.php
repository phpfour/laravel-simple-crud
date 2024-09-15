<?php

namespace Emran\SimpleCRUD\Commands;

use Illuminate\Console\Command;

class SimpleCRUDCommand extends Command
{
    public $signature = 'laravel-simple-crud';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
