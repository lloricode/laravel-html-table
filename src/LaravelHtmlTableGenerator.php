<?php

namespace Lloricode\LaravelHtmlTable;

use Illuminate\Database\Eloquent\Model;

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
                $this->_tags = $this->_getDefaultTags();
                $this->_links = NULL;
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
        public function generate($header, $data = [],$attributes = [], $caption = null)
        {
                $this->_setCaption($caption);

                $this->_attributes = $attributes;
                $this->_checTagsFromAttrbutes();
                return $this->_generate($header ,$data);
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
        public function generateModel($header, $model,array $fields, $limit, $attributes = [], $caption = null)
        {
                $this->_setCaption($caption);
                
                $this->_attributes = $attributes;
                $this->_checTagsFromAttrbutes();
                return $this->_generate($header, $model, $limit, $fields);
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
                $links = $this->_links;
                $this->_links = NULL;
                return $links;
        }
     
}
