<?php

declare(strict_types=1);
namespace Tests;


use Lloricode\LaravelHtmlTable\LaravelHtmlTableGenerator;

// use PHPUnit\Framework\TestCase;

class BaseTest extends \Orchestra\Testbench\TestCase
{
    protected $table;

    public function setUp()
    {
        parent::setUp();

        $this->table = new LaravelHtmlTableGenerator;
    }
}
