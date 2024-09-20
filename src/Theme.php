<?php declare(strict_types=1);

namespace Emran\SimpleCRUD;

use Illuminate\Support\Arr;

class Theme
{
    /** @var array<string, string> */
    protected array $classes;

    public function __construct()
    {
        $this->classes = config('simple-crud.theme', []);
    }

    public function getClass(string $element): string
    {
        return Arr::get($this->classes, $element, '');
    }
}
