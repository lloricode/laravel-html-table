
# Laravel Html Table
[![Latest Version on Packagist](https://img.shields.io/packagist/v/lloricode/laravel-html-table.svg)](https://packagist.org/packages/lloricode/laravel-html-table) [![Build Status](https://travis-ci.org/lloricode/laravel-html-table.svg?branch=master)](https://travis-ci.org/lloricode/laravel-html-table) [![Total Downloads](https://img.shields.io/packagist/dt/lloricode/laravel-html-table.svg)](https://packagist.org/packages/lloricode/laravel-html-table)

Generate Html Table with data from array/object.

## Install via [composer](https://getcomposer.org/).
```
composer require lloricode/laravel-html-table

```
## on laravel <= 5.4 you need add provider, while in laravel 5.5 it already in autoload
### Provider
```php
Lloricode\LaravelHtmlTable\Providers\LaravelHtmlTableProvider::class,
```

### Aliase
```php
 'Table'=>  Lloricode\LaravelHtmlTable\Facades\LaravelHtmlTableFacade::class,
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

{!! Table::generate($headers, $data) !!}

{!! Table::generate($headers, $data, $attributes) !!}

// Model way
   
   {!! Table::generateModel(
        ['Id', 'Name', 'Email'],  // Column for table
        'App\User' // Model
        ,['id', 'name', 'email'], // Fields from model
        0, // Pagination Limit, if 0 all will show
        'border="1"' // Attributes sample js/css
        ) !!}    

    {{ Table::links() }} // Generat this when limit is not 0


// then you can add a links

    {!! Table::optionLinks('my.route.name')    
         ->modelResult(function($query){  // you can add filter if you are using model generate
               $query->where('user_id', auth()->user()->id);
               return $query;
           })    
        ->generateModel(
           ['Id', 'Name', 'Email'],  // Column for table
           'App\User' // Model
          ,['id', 'name', 'email'], // Fields from model
            5, // Pagination Limit, if 0 all will show
           'border="1"' // Attributes sample js/css
        ) !!}   
// you can specify more args
// 1st route name, 2nd heder label, and 3rd is the every row label
  {!! Table::optionLinks('my.route.name', 'my option', 'view')->generateModel(
        ['Id', 'Name', 'Email'],  // Column for table
        'App\User' // Model
        ,['id', 'name', 'email'], // Fields from model
        5, // Pagination Limit, if 0 all will show
        'border="1"' // Attributes sample js/css
        ) !!}   

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

{!! Table::generate($headers, $data, $attributes) !!}
```

## Sample Output
 ```
<table myclass="test_val"><thead><tr><th>col1</th><th>col2</th></tr></thead><tbody><tr><td>Lloric</td><td>Garcia</td></tr><tr><td>Foo</td><td>Bar</td></tr><tr><td>Foo1</td><td>bar11</td></tr><tr><td>tst</td><td>tesss</td></tr></tbody></table>
 ```

 ## Adding attributes in cell data
 ```php
$header = [ 'Date', 'Description', 'Amount' ];
$datas = [
        [
                ['data'=>'1','scope'=>'row'],
                'Mark',
                'Otto'
        ],
        [
                ['data'=>'2','scope'=>'row'],
                'foo',
                'varr'
        ],
];
{!! Table::generate($header, $datas, ['class'=>'table']) !!}
<table class="table">
        <thead>
                <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                </tr>
        </thead>
        <tbody>
                <tr>
                        <td scope="row">1</td>
                        <td>Mark</td>
                        <td>Otto</td>
                </tr>
                <tr>
                        <td scope="row">2</td>
                        <td>foo</td>
                        <td>varr</td>
                </tr>
        </tbody>
</table>
                                                
 ```
#

# Feel free to use, you can send issue,request, and suggest.

Best regards. :)

