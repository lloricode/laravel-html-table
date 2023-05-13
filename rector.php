<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src',
    ]);

    $rectorConfig->sets([
        SetList::PHP_74,
    ]);

    $rectorConfig->phpVersion(PhpVersion::PHP_74);

//    $rectorConfig->phpstanConfig(__DIR__ . '/phpstan.neon.dist');
};
