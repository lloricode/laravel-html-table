
# Laravel Html Table
[![Build Status](https://travis-ci.org/lloricode/laravel-html-table.svg?branch=master)](https://travis-ci.org/lloricode/laravel-html-table)

Generate Html Table with data from array/object.

## Install via [composer](https://getcomposer.org/).
```
composer require lloricode/laravel-html-table
```

## Provider
```php
Lloricode\LaravelHtmlTable\LaravelHtmlTableProvider::class,
```

## Aliase
```php
 'Table'=>  Lloricode\LaravelHtmlTable\LaravelHtmlTableFacade::class,
 ```

## Sample in view.
 ```php

$headers = [ 'col1','col2' ];

$data = [
        [
                'Lloric','Garcia'
        ],
        [
                'Foo','Bar'
        ],
        [
                'Foo1','bar11'
        ],
        [
                'tst','tesss'
        ],
];

$attributes = 'class="table"';
// Or
$attributes = ['myclass'=>'test_val'];

{{ Table::generateTable($headers, $data) }}

{{ Table::generateTable($headers, $data, $attributes) }}

// Model way
  
     {!! Table::generateTableFromModel(
         ['Name'],  // Column for table
         'App\User' // Model
         ,['name'], // Fields from model
         1, // Pagination Limit, if 0 all will show
         'border="1"' // Attributes sample js/css
         ) !!}   

    {{ Table::links() }} // Generat this when limit is not 0


 ```
## This is all default values html tags
```php
$attributes = [
        // Main Table
        'table'         => '<table>',
        'table_end'     => '</table>',

        // Head 
        'head'          => '<thead>',
        'head_end'      => '</thead>',

        'head_row'      => '<tr>',
        'head_row_end'  => '</tr>',
        'head_cell'      => '<th>',
        'head_cell_end'  => '</th>',

        // Data body
        'body'          => '<tbody>',
        'body_end'      => '</tbody>',

        'body_row'      => '<tr>',
        'body_row_end'  => '</tr>',                        
        'body_cell'      => '<td>',
        'body_cell_end'  => '</td>',

        // Alternative
        'alt_body_row'      => '<tr>',
        'alt_body_row_end'  => '</tr>',                        
        'alt_body_cell'      => '<td>',
        'alt_body_cell_end'  => '</td>'
];

{{ Table::generateTable($headers, $data, $attributes) }}
```

## Sample Output
 ```
<table myclass="test_val"><thead><tr><th>col1</th><th>col2</th></tr></thead><tbody><tr><td>Lloric</td><td>Garcia</td></tr><tr><td>Foo</td><td>Bar</td></tr><tr><td>Foo1</td><td>bar11</td></tr><tr><td>tst</td><td>tesss</td></tr></tbody></table>
 ```