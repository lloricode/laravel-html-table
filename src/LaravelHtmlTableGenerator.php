<?php

namespace Lloricode\LaravelHtmlTable;

use Closure;

class LaravelHtmlTableGenerator extends Generator
{

        /**
         * Contructor
         *
         *
         *
         */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * Set Link options on model generate
     *
     *
     * @param $label
     * @param $options
     * @return LaravelHtmlTableGenerator
     * @author Lloric Mayuga Garcia <lloricode@gmail.com>
     */
    public function optionLinks($routerName, $headerLabel = 'Option', $rowLabel = null)
    {
        $this->optionLinks = [
                        'routerName' => $routerName,
                        'headerLabel' => $headerLabel,
                        'rowLabel' => $rowLabel,
                ];

        return $this;
    }

    /**
     *
     * Generate a completed html table with header and data
     *
     *
     * @param $attributes
     * @param $data
     * @param $header
     * @return string
     * @author Lloric Mayuga Garcia <lloricode@gmail.com>
     */
    public function generate(array $header, $data = [], $attributes = [], $caption = null)
    {
        $this->setCaption($caption);

        $this->attributes = $attributes;
        $this->checTagsFromAttrbutes();
        return $this->execute($header, $data);
    }
        
    /**
     *
     * Generate a completed html table with header and data
     *
     *
     * @param $attributes
     * @param $data
     * @param $header
     * @return string
     * @author Lloric Mayuga Garcia <lloricode@gmail.com>
     */
    public function generateModel(array $header, $model, array $fields, $limit, $attributes = [], $caption = null)
    {
        $this->setCaption($caption);
                
        $this->attributes = $attributes;
        $this->checTagsFromAttrbutes();
        return $this->execute($header, $model, $limit, $fields);
    }

    /**
     *
     * Set closure for getting data from model with query bulder
     *
     * @param $closure
     * @return $this
     * @author Lloric Mayuga Garcia <lloricode@gmail.com>
     */
    public function modelResult(Closure $closure)
    {
        $this->modelResultClosure = $closure;
        return $this;
    }

    /**
    *
    * Generated links
    *
    *
    * @return string
    * @author Lloric Mayuga Garcia <lloricode@gmail.com>
    */
    public function links()
    {
        $links = $this->links;
        $this->links = null;
        return $links;
    }
}
