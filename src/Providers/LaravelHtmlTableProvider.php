<?php

declare(strict_types=1);

namespace Lloricode\LaravelHtmlTable\Providers;

use Lloricode\LaravelHtmlTable\LaravelHtmlTableGenerator;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelHtmlTableProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-html-table');
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(
            'lloricodelaravelhtmltable',
            fn ($app) => new LaravelHtmlTableGenerator()
        );
    }
}
