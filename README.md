
# Laravel Html Table

Generate Html Table with data from array/object.


## Provider
```php
Lloricode\LaravelHtmlTable\LaravelHtmlTableProvider::class,
```

## Aliase
```php
 'Table'=>  Lloricode\LaravelHtmlTable\LaravelHtmlTableFacade::class,
 ```

### Sample in view.
 ```php

    $headers = [ 'First Name', 'Last Name' ];

    $data = [
        [
            'Lloric','Garcia'
        ],
        [
            'Foo','Bar'
        ],
    ];

    $attributes = 'class="table"';

    {{ Table::generateTable($headers, $data) }}

    {{ Table::generateTable($headers, $data, $attributes) }}

 ```