<?php

declare(strict_types=1);

namespace Lloricode\LaravelHtmlTable\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Lloricode\LaravelHtmlTable\LaravelHtmlTableGenerator
 */
class LaravelHtmlTableFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'lloricodelaravelhtmltable';
    }
}
