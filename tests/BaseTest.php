<?php

declare(strict_types=1);
namespace Tests;


use Lloricode\LaravelHtmlTable\LaravelHtmlTableGenerator;

// use PHPUnit\Framework\TestCase;

class BaseTest extends \Orchestra\Testbench\TestCase
{

    protected $table;

    public function setUp()
    {
        parent::setUp();

        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->artisan('migrate', ['--database' => 'testbench']);

        $this->table = new LaravelHtmlTableGenerator;
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return ['Lloricode\LaravelHtmlTable\Providers\LaravelHtmlTableProvider'];
    }
}
