<?php

declare(strict_types=1);

namespace Lloricode\LaravelHtmlTable\Tests\Support;

use Illuminate\Database\Eloquent\Model;

/**
 * @method self create(array $attributes)
 */
class TestModel extends Model
{
    public $timestamps = false;

    /** @var array */
    protected $fillable = ['email', 'name'];
}
