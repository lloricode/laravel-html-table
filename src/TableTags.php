<?php

declare(strict_types=1);

namespace Lloricode\LaravelHtmlTable;

use ReflectionClass;

class TableTags
{
    public function __construct(
        // Main Table
        public readonly string $table = '<table>',
        public readonly string $table_end = '</table>',

        // Head
        public readonly string $head = '<thead>',
        public readonly string $head_end = '</thead>',
        public readonly string $head_row = '<tr>',
        public readonly string $head_row_end = '</tr>',
        public readonly string $head_cell = '<th>',
        public readonly string $head_cell_end = '</th>',

        // Data body
        public readonly string $body = '<tbody>',
        public readonly string $body_end = '</tbody>',
        public readonly string $body_row = '<tr>',
        public readonly string $body_row_end = '</tr>',
        public readonly string $body_cell = '<td>',
        public readonly string $body_cell_end = '</td>',

        // Alternative
        public readonly string $alt_body_row = '<tr>',
        public readonly string $alt_body_row_end = '</tr>',
        public readonly string $alt_body_cell = '<td>',
        public readonly string $alt_body_cell_end = '</td>',
    ) {
    }

    public function properties(): array
    {
        $properties = [];
        foreach ((new ReflectionClass($this))
            ->getProperties() as $property
        ) {
            $properties[] = $property->getName();
        }

        return $properties;
    }
}
