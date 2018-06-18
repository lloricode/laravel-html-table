<?php

namespace Lloricode\LaravelHtmlTable\Tests;

use Illuminate\Database\Schema\Blueprint;
use Lloricode\LaravelHtmlTable\Tests\Models\User;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    
    public function setUp()
    {
        parent::setUp();
        
        $this->setUpDatabase($this->app);
    }

            /**
     * Set up the database.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('slug');
            $table->string('password');

        });

        User::create([
            'name' => 'Orchestra',
            'email' => 'hello@orchestraplatform.com',
            'slug' => str_slug('Orchestra orchestraplatform'),
            'password' => \Hash::make('456'),
        ]);
        User::create([
            'name' => 'Lloric',
            'email' => 'lloricode@gmail.com',
            'slug' => str_slug('Lloric Garcia'),
            'password' => \Hash::make('1234'),
        ]);
    }


    protected function getPackageAliases($app)
    {
        return [
            'Table' => "Lloricode\\LaravelHtmlTable\\Facades\\LaravelHtmlTableFacade"
        ];
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
