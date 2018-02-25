<?php

use Lloricode\LaravelHtmlTable\Tests\TestCase;

class TestModel extends TestCase
{
        public function testGenerateModel()
        {
                $expected = '<table border="1"><thead><tr><th>Id</th><th>Name</th><th>Email</th></tr></thead><tbody><tr><td>1</td><td>Orchestra</td><td>hello@orchestraplatform.com</td></tr><tr><td>2</td><td>Lloric</td><td>lloricode@gmail.com</td></tr></tbody></table>';
                $generated = Table::generateModel(
                        ['Id', 'Name', 'Email'],  // Column for table
                        'Lloricode\LaravelHtmlTable\Tests\Models\User' // Model
                        ,['id', 'name', 'email'], // Fields from model
                        0, // Pagination Limit, if 0 all will show
                        'border="1"' // Attributes sample js/css
                        ) ;
                $this->assertEquals($expected, $generated);        
        }
}