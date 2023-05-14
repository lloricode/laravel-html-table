<?php

declare(strict_types=1);

namespace Lloricode\LaravelHtmlTable;

use Closure;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Generator
{
    protected TableTags $tags;

    protected string|array $attributes;

    protected ?Htmlable $links = null;

    protected ?string $caption = null;

    protected ?ModelOptionLinks $optionLinks = null;

    protected ?Closure $modelResultClosure = null;

    public function __construct()
    {
        $this->resetDefaultTags();
    }

    /** Generate Html Header with value. */
    private function header(array $header): string
    {
        $output = $this->tags->head;

        $output .= $this->tags->head_row;

        foreach ($header as $row) {
            $output .= $this->tags->head_cell.$row.$this->tags->head_cell_end;
        }

        if ( ! is_null($this->optionLinks)) {
            $output .= $this->tags->head_cell.$this->optionLinks->headerLabel.$this->tags->head_cell_end;
        }

        return $output.$this->tags->head_row_end.$this->tags->head_end;
    }

    protected function setCaption(?string $caption): void
    {
        $this->caption = $caption;
    }

    /** Generate Rows with data. */
    private function rowsData(array $data): string
    {
        $output = $this->tags->body;

        $alt = 0;
        foreach ($data as $row1) {
            $alter = ($alt % 2 === 0) ? '' : 'alt_';

            $output .= $this->tags->{$alter . 'body_row'};
            foreach ($row1 as $row) {
                $bodyCellTagClose = $this->tags->body_cell_end;
                if (is_array($row) && array_key_exists('data', $row)) {
                    $data = $row['data'];
                    unset($row['data']);

                    if (isset($row['body_celltags'])) {
                        $bodyCellTag = $row['body_celltags'];
                        $bodyCellTagOpen = $bodyCellTag['open'];
                        $bodyCellTagClose = $bodyCellTag['close'];
                    } else {
                        $bodyCellTagOpen = trim((string) $this->tags->{$alter . 'body_cell'}, '>').$this->attributeToString($row).'>';
                    }
                } else {
                    $data = $row;
                    $bodyCellTagOpen = $this->tags->{$alter . 'body_cell'};
                }

                $output .= $bodyCellTagOpen.$data.$bodyCellTagClose;
            }
            $output .= $this->tags->body_row_end;

            $alt++;
        }

        return $output.$this->tags->body_end;
    }

    private function rowsDataWithModel(Builder $query, array $fields, int $limit): string
    {
        $query
            ->when(
                $this->optionLinks === null,
                fn (Builder $query): Builder => $query->select($fields),
                fn (Builder $query): Builder => $query->select([
                    ...$fields,
                    $query->getModel()->getRouteKeyName(),
                ]),
            )
            ->when(
                $this->modelResultClosure !== null,
                /** @phpstan-ignore-next-line  */
                fn (Builder $query): Builder => value($this->modelResultClosure, $query)
            );

        if ($limit === 0) {
            $models = $query->get();
        } else {
            $models = $query->paginate($limit);
            $this->links = $models->links();
        }

        $result = [];

        $models->each(function (Model $m) use ($fields, &$result) {
            $attributes = [];
            foreach ($fields as $f) {
                $attributes[] = $m->getAttribute($f);
            }

            if ( ! is_null($this->optionLinks)) {
                $attributes[] = $this->optionLinks($m);
            }

            $result[] = $attributes;
        });

        return $this->rowsData($result);
    }

    private function optionLinks(Model $model): string
    {
        $link = null;

        if ($this->optionLinks?->routeName !== null) {
            $link = route($this->optionLinks->routeName, $model->getRouteKey());
        }

        $label = $this->optionLinks?->rowLabel ?? 'View';

        return "<a href=\"$link\">$label</a>";
    }

    /** Convert attributes to string format. */
    private function attributeToString(array|string $param): string
    {
        $return = '';
        if (is_array($param)) {
            foreach ($param as $key => $value) {
                if ( ! property_exists($this->tags, $key)) {
                    $return .= $this->attributeToString("$key=\"$value\"");
                }
            }
        } else {
            $return = $param;
        }

        return ((strlen((string) $return) > 0) && ! empty($return))
                        ? (' '.trim((string) $return)) : '';
    }

    /**
     * Start Generating table with data.
     *
     * @param  array|class-string<\Illuminate\Database\Eloquent\Model>|null  $modelOrArray
     */
    protected function execute(
        array $header,
        array|string|null $modelOrArray,
        ?int $limit = null,
        ?array $fields = null
    ): string {
        $output = $this->generateOpenTag();

        if ( ! is_null($this->caption)) {
            $output .= "<caption>$this->caption</caption>";
        }

        $output .= $this->header($header);
        if (is_array($modelOrArray)) {
            $output .= $this->rowsData($modelOrArray);
        } elseif (is_string($modelOrArray) && ! is_null($fields) && ! is_null($limit)) {
            $output .= $this->rowsDataWithModel($modelOrArray::query(), $fields, $limit);
        }

        $this->resetDefaultTags();
        $this->optionLinks = null;

        return $output.$this->tags->table_end;
    }

    /** Generate an open tag for <table> with attribute specified */
    protected function generateOpenTag(): string
    {
        $openTag = $this->tags->table;

        return rtrim($openTag, '>').$this->attributeToString($this->attributes).'>';
    }

    /** Override default tags, with on existed keys on array $this->tags. */
    protected function checkTagsFromAttributes(): void
    {
        if (is_array($this->attributes)) {
            // Get all keys
            $newAttributes = [];
            foreach ($this->tags->properties() as $key) {
                // if default key exist in attribute given by user,
                // replace the value from default key.
                if (array_key_exists($key, $this->attributes)) {
                    $newAttributes[$key] = $this->attributes[$key];
                    unset($this->attributes[$key]);
                }
            }
            if (filled($newAttributes)) {
                $this->tags = new TableTags(...$newAttributes);
            }
        }
    }

    /** Reset Tags */
    private function resetDefaultTags(): void
    {
        $this->tags = new TableTags();
    }
}
