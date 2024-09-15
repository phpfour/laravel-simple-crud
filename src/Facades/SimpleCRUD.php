<?php

namespace Emran\SimpleCRUD\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Emran\SimpleCRUD\SimpleCRUD
 */
class SimpleCRUD extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Emran\SimpleCRUD\SimpleCRUD::class;
    }
}
