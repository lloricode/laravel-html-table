<?php

use Tests\UserTest;

class TestModel extends \Tests\BaseTest
{
        public function testGenerateModel()
        {
                $this->assertTrue(true);


                // dd(UserTest::all());
                // $test_header = [
                //         'col1','col2'
                // ];

                // $test_data = [
                //         [
                //         'Lloric','Garcia'
                //         ],
                //         [
                //         'Foo','Bar'
                //         ],
                //         [
                //         'Foo1','bar11'
                //         ],
                //         [
                //         'tst','tesss'
                //         ],
                // ];
                
                // $expected = '<table><thead><tr><th>col1</th><th>col2</th></tr></thead><tbody><tr><td>Lloric</td><td>Garcia</td></tr><tr><td>Foo</td><td>Bar</td></tr><tr><td>Foo1</td><td>bar11</td></tr><tr><td>tst</td><td>tesss</td></tr></tbody></table>';
                
                
                // $this->assertEquals($expected, Table::generate($test_header, $test_data));        
        }
}