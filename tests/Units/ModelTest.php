<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
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

    expect(LaravelHtmlTableFacade::links())
        ->toBeNull();
});

it('generate with modified query', function (): void {
    TestModel::create([
        'name' => 'Orchestra',
        'email' => 'hello@orchestraplatform.com',
    ]);
    TestModel::create([
        'name' => 'Lloric',
        'email' => 'lloricode@gmail.com',
    ]);

    $generated = LaravelHtmlTableFacade::modelResult(
        function (Builder $query) {
            return $query->where('name', 'Lloric');
        }
    )
        ->generateModel(
            header: ['Id', 'Name', 'Email'],
            model: TestModel::class,
            fields: ['id', 'name', 'email'],
            limit: 0
        );

    expect($generated)
        ->toMatchTextSnapshot();

    expect(LaravelHtmlTableFacade::links())
        ->toBeNull();
});

it('generate w/ limit', function (int $limit): void {
    TestModel::create([
        'name' => 'Orchestra',
        'email' => 'hello@orchestraplatform.com',
    ]);
    TestModel::create([
        'name' => 'Lloric',
        'email' => 'lloricode@gmail.com',
    ]);

    $generated = LaravelHtmlTableFacade::generateModel(
        header: ['Id'],
        model: TestModel::class,
        fields: ['id'],
        limit: $limit
    );

    if ($limit === 0) {
        expect(LaravelHtmlTableFacade::links())
            ->toBeNull();
    } else {
        expect(LaravelHtmlTableFacade::links())
            ->toBeInstanceOf(View::class);
    }

    expect($generated)
        ->toMatchTextSnapshot();
})->with([0, 1]);

it('generate w/ options', function (): void {
    TestModel::create([
        'name' => 'Orchestra',
        'email' => 'hello@orchestraplatform.com',
    ]);

    Route::get('/test/{model}')
        ->name('test.model.show');

    $generated = LaravelHtmlTableFacade::optionLinks('test.model.show')
        ->generateModel(
            header: ['name'],
            model: TestModel::class,
            fields: ['name'],
            limit: 0
        );

    expect($generated)
        ->toMatchTextSnapshot();

    expect(LaravelHtmlTableFacade::links())
        ->toBeNull();
});
