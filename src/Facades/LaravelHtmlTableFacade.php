<?php

namespace Lloricode\LaravelHtmlTable\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Collective\Html\HtmlBuilder
 */
class LaravelHtmlTableFacade extends Facade
{

        /**
        * Get the registered name of the component.
        *
        * @return string
        */
    protected static function getFacadeAccessor()
    {
        return 'lloricodelaravelhtmltable';
    }
}
