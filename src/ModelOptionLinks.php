<?php

declare(strict_types=1);

namespace Lloricode\LaravelHtmlTable;

class ModelOptionLinks
{
    public function __construct(
        public readonly string $routeName,
        public readonly string $headerLabel = 'Options',
        public readonly ?string $rowLabel = null,
    ) {
    }
}
