<?php

declare(strict_types=1);

namespace Lloricode\LaravelHtmlTable\Tests;

use Lloricode\LaravelHtmlTable\Providers\LaravelHtmlTableProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [LaravelHtmlTableProvider::class];
    }
}
