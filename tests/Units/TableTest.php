<?php

declare(strict_types=1);

use Lloricode\LaravelHtmlTable\Facades\LaravelHtmlTableFacade;

test('html output with no attributes', function (): void {
    $test_header = [
        'col1', 'col2',
    ];

    $test_data = [
        [
            'Lloric', 'Garcia',
        ],
        [
            'Foo', 'Bar',
        ],
        [
            'Foo1', 'bar11',
        ],
        [
            'tst', 'tesss',
        ],
    ];

    expect(LaravelHtmlTableFacade::generate($test_header, $test_data))
        ->toMatchTextSnapshot();
});

test('html output with attributes alt cells', function (): void {
    $test_header = [
        'col1', 'col2',
    ];

    $test_data = [
        [
            'Lloric', 'Garcia',
        ],
        [
            'Foo', 'Bar',
        ],
        [
            'Foo1', 'bar11',
        ],
        [
            'tst', 'tesss',
        ],
    ];

    $attributes = [

        'body_cell' => '<td style="background-color:yellow">',

        // Alternative
        'alt_body_cell' => '<td style="background-color:blue">',
    ];

    expect(LaravelHtmlTableFacade::generate($test_header, $test_data, $attributes))
        ->toMatchTextSnapshot();
});

test('html output with attributes array', function (): void {
    $test_header = [
        'col1', 'col2',
    ];

    $test_data = [
        [
            'Lloric', 'Garcia',
        ],
        [
            'Foo', 'Bar',
        ],
        [
            'Foo1', 'bar11',
        ],
        [
            'tst', 'tesss',
        ],
    ];

    $attributes = ['myclass' => 'test_val'];

    expect(LaravelHtmlTableFacade::generate($test_header, $test_data, $attributes))
        ->toMatchTextSnapshot();
});

test('html output with attributes string', function (): void {
    $test_header = [
        'col1', 'col2',
    ];

    $test_data = [
        [
            'Lloric', 'Garcia',
        ],
        [
            'Foo', 'Bar',
        ],
        [
            'Foo1', 'bar11',
        ],
        [
            'tst', 'tesss',
        ],
    ];

    $attributes = 'myclass="test_val"';

    expect(LaravelHtmlTableFacade::generate($test_header, $test_data, $attributes))
        ->toMatchTextSnapshot();
});

test('html output with modify default tags with same value', function (): void {
    $test_header = [
        'col1', 'col2',
    ];

    $test_data = [
        [
            'Lloric', 'Garcia',
        ],
        [
            'Foo', 'Bar',
        ],
        [
            'Foo1', 'bar11',
        ],
        [
            'tst', 'tesss',
        ],
    ];

    $attributes = [
        // Main Table
        'table' => '<table>',
        'table_end' => '</table>',

        // Head
        'head' => '<thead>',
        'head_end' => '</thead>',

        'head_row' => '<tr>',
        'head_row_end' => '</tr>',
        'head_cell' => '<th>',
        'head_cell_end' => '</th>',

        // Data body
        'body' => '<tbody>',
        'body_end' => '</tbody>',

        'body_row' => '<tr>',
        'body_row_end' => '</tr>',
        'body_cell' => '<td>',
        'body_cell_end' => '</td>',

        // Alternative
        'alt_body_row' => '<tr>',
        'alt_body_row_end' => '</tr>',
        'alt_body_cell' => '<td>',
        'alt_body_cell_end' => '</td>',
    ];

    expect(LaravelHtmlTableFacade::generate($test_header, $test_data, $attributes))
        ->toMatchTextSnapshot();
});

test('html output with modify default tags with only table open modified', function (): void {
    $test_header = [
        'col1', 'col2',
    ];

    $test_data = [
        [
            'Lloric', 'Garcia',
        ],
        [
            'Foo', 'Bar',
        ],
        [
            'Foo1', 'bar11',
        ],
        [
            'tst', 'tesss',
        ],
    ];

    $attributes = ['table' => '<table class="class_value">'];

    expect(LaravelHtmlTableFacade::generate($test_header, $test_data, $attributes))
        ->toMatchTextSnapshot();
});

test('html output with modify default tags with only header cells modified', function (): void {
    $test_header = [
        'col1', 'col2',
    ];

    $test_data = [
        [
            'Lloric', 'Garcia',
        ],
        [
            'Foo', 'Bar',
        ],
        [
            'Foo1', 'bar11',
        ],
        [
            'tst', 'tesss',
        ],
    ];

    $attributes = ['head_cell' => '<th class="class_header">'];

    expect(LaravelHtmlTableFacade::generate($test_header, $test_data, $attributes))
        ->toMatchTextSnapshot();
});

test('html output with modify default tags with open table and header cells', function (): void {
    $test_header = [
        'col1', 'col2',
    ];

    $test_data = [
        [
            'Lloric', 'Garcia',
        ],
        [
            'Foo', 'Bar',
        ],
        [
            'Foo1', 'bar11',
        ],
        [
            'tst', 'tesss',
        ],
    ];

    $attributes = [
        'table' => '<table class="class_value">',
        'head_cell' => '<th class="class_header">',
    ];

    expect(LaravelHtmlTableFacade::generate($test_header, $test_data, $attributes))
        ->toMatchTextSnapshot();
});

test('add attributes in cell data', function (): void {
    $header = ['Date', 'Description', 'Amount'];
    $datas = [
        [
            ['data' => '1', 'scope' => 'row'],
            'Mark',
            'Otto',
        ],
        [
            ['data' => '2', 'scope' => 'row'],
            'foo',
            'varr',
        ],
    ];

    expect(LaravelHtmlTableFacade::generate($header, $datas, ['class' => 'table']))
        ->toMatchTextSnapshot();
});

test('add caption', function (): void {
    expect(LaravelHtmlTableFacade::generate(
        header: ['Header'],
        data: [['row data']],
        caption: 'My Table Caption'
    ))
        ->toMatchTextSnapshot();
});
