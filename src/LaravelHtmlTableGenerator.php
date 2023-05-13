<?php

declare(strict_types=1);

namespace Lloricode\LaravelHtmlTable;

use Closure;

class LaravelHtmlTableGenerator extends Generator
{
    public function __construct()
    {
        parent::__construct();
    }

    /** Set Link options on model generate */
    public function optionLinks(
        string $routerName,
        string $headerLabel = 'Option',
        ?string $rowLabel = null
    ): self {
        $this->optionLinks = [
            'routerName' => $routerName,
            'headerLabel' => $headerLabel,
            'rowLabel' => $rowLabel,
        ];

        return $this;
    }

    /** Generate a completed html table with header and data */
    public function generate(
        array $header,
        array $data = [],
        array|string $attributes = [],
        ?string $caption = null
    ): string {
        $this->setCaption($caption);

        $this->attributes = $attributes;
        $this->checkTagsFromAttributes();

        return $this->execute($header, $data);
    }

    /** Generate a completed html table with header and data
     * @param class-string<\Illuminate\Database\Eloquent\Model> $model
     */
    public function generateModel(
        array $header,
        string $model,
        array $fields,
        int $limit,
        array|string $attributes = [],
        ?string $caption = null
    ): string {
        $this->setCaption($caption);

        $this->attributes = $attributes;
        $this->checkTagsFromAttributes();

        return $this->execute($header, $model, $limit, $fields);
    }

    /** Set closure for getting data from model with query builder */
    public function modelResult(Closure $closure): self
    {
        $this->modelResultClosure = $closure;

        return $this;
    }

    /** Generated links */
    public function links(): ?string
    {
        $links = $this->links;
        $this->links = null;

        return $links;
    }
}
