<?php

declare(strict_types=1);
namespace Lloricode\LaravelHtmlTable\Tests;
require_once('src/LaravelHtmlTableGenerator.php');
use PHPUnit\Framework\TestCase;
use Lloricode\LaravelHtmlTable\LaravelHtmlTableGenerator;


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
                
                $table = new LaravelHtmlTableGenerator;
                
                $this->assertEquals($expected,$table->generateTable($test_header, $test_data));        
        }

        // public function testHtmlOutputWithAttibutesArray()
        // {
        //         $test_header = [
        //                 'col1','col2'
        //         ];

        //         $test_data = [
        //                 [
        //                 'Lloric','Garcia'
        //                 ],
        //                 [
        //                 'Foo','Bar'
        //                 ],
        //                 [
        //                 'Foo1','bar11'
        //                 ],
        //                 [
        //                 'tst','tesss'
        //                 ],
        //         ];
                
        //         $expected = '<table myclass="test_val"><thead><tr><th>col1</th><th>col2</th></tr></thead><tbody><tr><td>Lloric</td><td>Garcia</td></tr><tr><td>Foo</td><td>Bar</td></tr><tr><td>Foo1</td><td>bar11</td></tr><tr><td>tst</td><td>tesss</td></tr></tbody></table>';
                
        //         $attributes = ['myclass','test_val'];

        //         $table = new LaravelHtmlTableGenerator;
                
        //         $this->assertEquals($expected,$table->generateTable($test_header, $test_data, $attributes));        
        // }
        
}