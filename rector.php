<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\ValueObject\PhpVersion;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__.'/src',
    ]);

    $rectorConfig->sets([
        SetList::PHP_81,
    ]);

    $rectorConfig->phpVersion(PhpVersion::PHP_81);

    //    $rectorConfig->phpstanConfig(__DIR__ . '/phpstan.neon.dist');
};
