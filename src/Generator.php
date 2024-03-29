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

    private string|array|TableTags $customTags;

    protected ?Htmlable $links = null;

    protected ?string $caption = null;

    protected ?ModelOptionLinks $optionLinks = null;

    protected ?Closure $modelResultClosure = null;

    public function __construct()
    {
        $this->reset();
    }

    /** Generate Html Header with value. */
    private function header(array $header): string
    {
        $output = $this->tags->head;

        $output .= $this->tags->head_row;

        foreach ($header as $row) {

            $close = $this->tags->head_cell_end;
            if (is_array($row) && array_key_exists('data', $row)) {
                $data = $row['data'];
                unset($row['data']);

                if (isset($row['header_celltags'])) {
                    $open = $row['header_celltags']['open'];
                    $close = $row['header_celltags']['close'];
                } else {
                    $open = trim($this->tags->head_cell, '>').
                        $this->attributeToString($row).
                        '>';
                }
            } else {
                $data = $row;
                $open = $this->tags->head_cell;
            }

            $output .= $open.$data.$close;
        }

        if (! is_null($this->optionLinks)) {
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

        foreach ($data as $alt => $row1) {
            $alter = ! ($alt % 2 === 0);

            $output .= $this->tags->getBodyRow($alter);
            foreach ($row1 as $row) {
                $bodyCellTagClose = $this->tags->body_cell_end;
                if (is_array($row) && array_key_exists('data', $row)) {
                    $data = $row['data'];
                    unset($row['data']);

                    if (isset($row['body_celltags'])) {
                        $bodyCellTagOpen = $row['body_celltags']['open'];
                        $bodyCellTagClose = $row['body_celltags']['close'];
                    } else {
                        $bodyCellTagOpen = trim($this->tags->getBodyCell($alter), '>').
                            $this->attributeToString($row).
                            '>';
                    }
                } else {
                    $data = $row;
                    $bodyCellTagOpen = $this->tags->getBodyCell($alter);
                }

                $output .= $bodyCellTagOpen.$data.$bodyCellTagClose;
            }
            $output .= $this->tags->body_row_end;

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

            if (! is_null($this->optionLinks)) {
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

        $label = $this->optionLinks?->rowLabel ?? trans('View');

        return "<a href=\"$link\">$label</a>";
    }

    private function attributeToString(array|string|TableTags $param): string
    {
        if ($param instanceof TableTags) {
            return '';
        }

        $return = '';
        if (is_array($param)) {
            foreach ($param as $key => $value) {
                if (! property_exists($this->tags, (string) $key)) {
                    $return .= "$key=\"$value\"";
                }
            }
        } else {
            $return = $param;
        }

        return filled($return) ? (' '.trim($return)) : '';
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

        if (! is_null($this->caption)) {
            $output .= "<caption>$this->caption</caption>";
        }

        $output .= $this->header($header);
        if (is_array($modelOrArray)) {
            $output .= $this->rowsData($modelOrArray);
        } elseif (is_string($modelOrArray) && ! is_null($fields) && ! is_null($limit)) {
            $output .= $this->rowsDataWithModel($modelOrArray::query(), $fields, $limit);
        }

        $this->reset();

        return $output.$this->tags->table_end;
    }

    /** Generate an open tag for <table> with attribute specified */
    protected function generateOpenTag(): string
    {
        $openTag = $this->tags->table;

        return rtrim($openTag, '>').$this->attributeToString($this->customTags).'>';
    }

    /** Override default tags, with on existed keys on array $this->tags. */
    protected function applyCustomTags(string|array|TableTags $customTags): void
    {
        $this->customTags = $customTags;

        if (is_array($this->customTags) && filled($this->customTags)) {
            // Get all keys
            $newAttributes = [];
            foreach ($this->tags->properties() as $key) {
                // if default key exist in attribute given by user,
                // replace the value from default key.
                if (array_key_exists($key, $this->customTags)) {
                    $newAttributes[$key] = $this->customTags[$key];
                    unset($this->customTags[$key]);
                }
            }
            if (filled($newAttributes)) {
                $this->tags = new TableTags(...$newAttributes);
            }
        } elseif ($this->customTags instanceof TableTags) {
            $this->tags = $this->customTags;
        }
    }

    private function reset(): void
    {
        $this->tags = new TableTags();
        $this->optionLinks = null;
    }
}
