<?php

use Lloricode\LaravelHtmlTable\Tests\TestCase;

class TestLaravelHtmlTable extends TestCase
{
        public function testHtmlOutputWithNoAttibutes()
        {
                $test_header = [
                        'col1','col2'
                ];

                $test_data = [
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
                
                $expected = '<table><thead><tr><th>col1</th><th>col2</th></tr></thead><tbody><tr><td>Lloric</td><td>Garcia</td></tr><tr><td>Foo</td><td>Bar</td></tr><tr><td>Foo1</td><td>bar11</td></tr><tr><td>tst</td><td>tesss</td></tr></tbody></table>';
                
                
                $this->assertEquals($expected, Table::generate($test_header, $test_data));        
        }

        public function testHtmlOutputWithAttibutesAltCells()
        {
                $test_header = [
                        'col1','col2'
                ];

                $test_data = [
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
                
                $attributes = [
                                            
                        'body_cell'      => '<td style="background-color:yellow">',

                        // Alternative                      
                        'alt_body_cell'      => '<td style="background-color:blue">', 
                ];

                $expected = '<table><thead><tr><th>col1</th><th>col2</th></tr></thead><tbody><tr><td style="background-color:yellow">Lloric</td><td style="background-color:yellow">Garcia</td></tr><tr><td style="background-color:blue">Foo</td><td style="background-color:blue">Bar</td></tr><tr><td style="background-color:yellow">Foo1</td><td style="background-color:yellow">bar11</td></tr><tr><td style="background-color:blue">tst</td><td style="background-color:blue">tesss</td></tr></tbody></table>';
                
                
                $this->assertEquals($expected, Table::generate($test_header, $test_data, $attributes));        
        }

        public function testHtmlOutputWithAttibutesArray()
        {
                $test_header = [
                        'col1','col2'
                ];

                $test_data = [
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
                
                $expected = '<table myclass="test_val"><thead><tr><th>col1</th><th>col2</th></tr></thead><tbody><tr><td>Lloric</td><td>Garcia</td></tr><tr><td>Foo</td><td>Bar</td></tr><tr><td>Foo1</td><td>bar11</td></tr><tr><td>tst</td><td>tesss</td></tr></tbody></table>';
                
                $attributes = ['myclass'=>'test_val'];

                
                $this->assertEquals($expected, Table::generate($test_header, $test_data, $attributes));        
        }

        public function testHtmlOutputWithAttibutesString()
        {
                $test_header = [
                        'col1','col2'
                ];

                $test_data = [
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
                
                $expected = '<table myclass="test_val"><thead><tr><th>col1</th><th>col2</th></tr></thead><tbody><tr><td>Lloric</td><td>Garcia</td></tr><tr><td>Foo</td><td>Bar</td></tr><tr><td>Foo1</td><td>bar11</td></tr><tr><td>tst</td><td>tesss</td></tr></tbody></table>';
                
                $attributes = 'myclass="test_val"';

                
                $this->assertEquals($expected, Table::generate($test_header, $test_data, $attributes));        
        }

        public function testHtmlOutputWithModifyDefaultTagsWithSameValue()
        {
                $test_header = [
                        'col1','col2'
                ];

                $test_data = [
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
                
                $expected = '<table><thead><tr><th>col1</th><th>col2</th></tr></thead><tbody><tr><td>Lloric</td><td>Garcia</td></tr><tr><td>Foo</td><td>Bar</td></tr><tr><td>Foo1</td><td>bar11</td></tr><tr><td>tst</td><td>tesss</td></tr></tbody></table>';
                
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

                
                $this->assertEquals($expected, Table::generate($test_header, $test_data, $attributes));        
        }
        public function testHtmlOutputWithModifyDefaultTagsWithOnlyTableOpenModified()
        {
                $test_header = [
                        'col1','col2'
                ];

                $test_data = [
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
                
                $expected = '<table class="class_value"><thead><tr><th>col1</th><th>col2</th></tr></thead><tbody><tr><td>Lloric</td><td>Garcia</td></tr><tr><td>Foo</td><td>Bar</td></tr><tr><td>Foo1</td><td>bar11</td></tr><tr><td>tst</td><td>tesss</td></tr></tbody></table>';
                
                $attributes = [ 'table' => '<table class="class_value">' ];

                
                $this->assertEquals($expected, Table::generate($test_header, $test_data, $attributes));        
        }

        public function testHtmlOutputWithModifyDefaultTagsWithOnlyHeaderCellsModified()
        {
                $test_header = [
                        'col1','col2'
                ];

                $test_data = [
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
                
                $expected = '<table><thead><tr><th class="class_header">col1</th><th class="class_header">col2</th></tr></thead><tbody><tr><td>Lloric</td><td>Garcia</td></tr><tr><td>Foo</td><td>Bar</td></tr><tr><td>Foo1</td><td>bar11</td></tr><tr><td>tst</td><td>tesss</td></tr></tbody></table>';
                
                $attributes = [ 'head_cell' => '<th class="class_header">' ];

                
                $this->assertEquals($expected, Table::generate($test_header, $test_data, $attributes));        
        }

        public function testHtmlOutputWithModifyDefaultTagsWithOpenTableAndHeaderCells()
        {
                $test_header = [
                        'col1','col2'
                ];

                $test_data = [
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
                
                $expected = '<table class="class_value"><thead><tr><th class="class_header">col1</th><th class="class_header">col2</th></tr></thead><tbody><tr><td>Lloric</td><td>Garcia</td></tr><tr><td>Foo</td><td>Bar</td></tr><tr><td>Foo1</td><td>bar11</td></tr><tr><td>tst</td><td>tesss</td></tr></tbody></table>';
                
                $attributes = [ 
                                'table' => '<table class="class_value">', 
                                'head_cell' => '<th class="class_header">'
                        ];

                
                $this->assertEquals($expected, Table::generate($test_header, $test_data, $attributes));        
        }
        
        public function testAddAttributesInCellData()
        {
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
                $expected = '<table class="table"><thead><tr><th>Date</th><th>Description</th><th>Amount</th></tr></thead><tbody><tr><td scope="row">1</td><td>Mark</td><td>Otto</td></tr><tr><td scope="row">2</td><td>foo</td><td>varr</td></tr></tbody></table>';

                $this->assertEquals($expected, Table::generate($header,$datas,['class'=>'table'])); 
        }
}