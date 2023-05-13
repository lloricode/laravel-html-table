<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Lloricode\LaravelHtmlTable\Facades\LaravelHtmlTableFacade;
use Lloricode\LaravelHtmlTable\Tests\Support\TestModel;

beforeEach(function (): void {
    config()->set('database.default', 'testbench');
    config()->set('database.connections.testbench', [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ]);
    DB::connection()
        ->getSchemaBuilder()
        ->create(
            (new TestModel())->getTable(),
            function (Blueprint $table): void {
                $table->increments('id');
                $table->string('name');
                $table->string('email');
            }
        );
});

it('generate model', function (): void {
    TestModel::create([
        'name' => 'Orchestra',
        'email' => 'hello@orchestraplatform.com',
    ]);
    TestModel::create([
        'name' => 'Lloric',
        'email' => 'lloricode@gmail.com',
    ]);

    $generated = LaravelHtmlTableFacade::generateModel(
        ['Id', 'Name', 'Email'],  // Column for table
        TestModel::class, // Model
        ['id', 'name', 'email'], // Fields from model
        0, // Pagination Limit, if 0 all will show
        'border="1"' // Attributes sample js/css
    );

    expect($generated)
        ->toMatchTextSnapshot();
});
