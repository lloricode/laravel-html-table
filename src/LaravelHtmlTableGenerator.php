<?php

namespace Lloricode\LaravelHtmlTable;

use Illuminate\Database\Eloquent\Model;
use App;

class LaravelHtmlTableGenerator
{
        
        /**
         *
         *      
         *
         *
         * @type array
         */
        private $_tags; 
        
        /**
         *
         *      
         *
         *
         * @type mixed
         */   
        private $_attributes;    
        
        /**
         *
         *      
         *
         *
         * @type string
         */   
         private $_links;    
   
        /**
         *
         *      
         *
         *
         * @type string
         */   
         private $_caption;    
         


        
        /**
         * Contructor
         *      
         *
         *
         */
        public function __construct()
        {
                $this->_tags = $this->_getDefaultTags();
                $this->_links = NULL;
        }       


        
        /**
         *
         * Generate Html Header with value.
         *
         *
         * @param array $header
         * @return string
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function _header(array $header)
        {
                $output = $this->_tags['head'];

                $output .= $this->_tags['head_row'];

                foreach($header as $row)
                {
                        $output .= $this->_tags['head_cell'].$row.$this->_tags['head_cell_end'];
                }
                return $output.$this->_tags['head_row_end'].$this->_tags['head_end'];
        }


        private function _setCaption($caption)
        {
                $this->_caption = $caption;
        }
        
        
        /**
         *
         * Generate Rows with data.
         *
         *
         * @param array $data
         * @return string
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function _rows_data(array $data)
        {
                $output = $this->_tags['body'];

                $alt = 0;
                foreach($data as $row1)
                {
                        $alter = ($alt%2===0)?'':'alt_';

                        $output .= $this->_tags[$alter.'body_row'];
                        foreach($row1 as $row)
                        {
                                $body_cell_tag_close = $this->_tags['body_cell_end'];
                                if(is_array($row) && array_key_exists('data',$row))
                                {
                                        $data = $row['data'];
                                        unset($row['data']);
                                          
                                        if(isset($row['body_cell_tags']))
                                        {
                                                $body_cell_tag = $row['body_cell_tags'];
                                                $body_cell_tag_open = $body_cell_tag['open'];
                                                $body_cell_tag_close = $body_cell_tag['close'];
                                        }
                                        else
                                        {
                                                $body_cell_tag_open = trim($this->_tags[$alter.'body_cell'],'>').$this->_attributeToString($row).'>';  
                                        }
                                }
                                else
                                {
                                        $data   = $row;
                                        $attrib = '';
                                        $body_cell_tag_open = $this->_tags[$alter.'body_cell'];
                                }


                                $output .= $body_cell_tag_open.$data.$body_cell_tag_close;
                        }
                        $output .= $this->_tags['body_row_end'];

                        $alt++;
                }
                return $output.$this->_tags['body_end'];
        }

        private function _rows_data_with_model($model, array $fields, $limit)
        {
                if($limit == 0)
                {
                        $objt = $model::all();
                }
                else{
                        $objt = $model::paginate($limit);
                        $this->_links = $objt->links();
                }
                $data=[];

                foreach($objt as $r)
                {
                        $t=[];
                        foreach($fields as $f)
                        {
                                $t[]=$r->$f;
                        }
                        $data[]=$t;
                }
                return $this->_rows_data($data);
        }
        
        /**
         *
         * Convert attributes to string format.
         *
         *
         * @return mixed
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function _attributeToString($param)
        {
                $return = '';
                if(is_array($param))
                {
                        foreach($param as $key => $value)
                        {
                                if(!array_key_exists($key,$this->_tags))
                                {
                                        $return .= $this->_attributeToString("$key=\"$value\"");
                                }
                        }
                }else
                {
                        $return = $param;
                }
                return ( (strlen($return)>0) && !empty($return))
                        ?(' '.trim($return)):'';
        }



        /**
         *
         * Start Generating table with data.
         *
         *
         * @param array $header
         * @param array $data
         * @return string a generated completed html table with data.
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private  function _generate(array $header, $model_or_array, $limit = NULL,array $fields = NULL)
        {
                $output = $this->_generateOpenTag();

                if(!is_null($this->_caption))
                {
                        $output .= "$output<caption>{$this->_caption}</caption>";
                }
                
                $output .= $this->_header($header);
                if(is_array($model_or_array))
                {
                        $output .= $this->_rows_data($model_or_array);
                }
                elseif(is_string($model_or_array) && !is_null($fields)&& !is_null($limit))
                {
                        $output .= $this->_rows_data_with_model($model_or_array, $fields, $limit);
                }
                $this->_resetDefaultTags();
                return $output.'</table>';
        }

        
        /**
         *
         * Generate a open tag for <table> with attribute specified
         *  
         *
         *
         * @return string 
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function _generateOpenTag()
        {
                $openTag = $this->_tags['table'];
                return rtrim($openTag,'>'). $this->_attributeToString($this->_attributes).'>';
        }

        
        /**
         *
         * Override default tags,
         * with on existed keys on array $this->_tags.
         *
         *
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function _checTagsFromAttrbutes()
        {
                if(is_array($this->_attributes))
                {
                        // Get all keys
                        foreach(array_keys($this->_tags) as $key)
                        {
                                // if default key exist in attribute given by user,
                                // replay the valu from default key.
                                if(array_key_exists($key,$this->_attributes))
                                {
                                        $this->_tags[$key] = $this->_attributes[$key];
                                        unset($this->_attributes[$key]);
                                }
                        }
                }
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
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function generateTable($header, $data = [],$attributes = [], $caption = null)
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
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function generateTableFromModel($header, $model,array $fields, $limit, $attributes = [], $caption = null)
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
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function links()
        {
                $links = $this->_links;
                $this->_links = NULL;
                return $links;
        }


         /**
         *
         * Reset Tags
         *
         *
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function _resetDefaultTags()
        {
                $this->_tags = $this->_getDefaultTags();
        }
        /**
         *
         * Default html table tags.      
         *
         *
         * @return array
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function _getDefaultTags()
        {
                return [
                        // Main Table
                        'table'         => '<table>',
                        'table_end'     => '</table>',

                        // Head 
                        'head'          => '<thead>',
                        'head_end'      => '</thead>',

                        'head_row'      => '<tr>',
                        'head_row_end'  => '</tr>',
                        'head_cell'      => '<th>',
                        'head_cell_end'  => '</th>',

                        // Data body
                        'body'          => '<tbody>',
                        'body_end'      => '</tbody>',

                        'body_row'      => '<tr>',
                        'body_row_end'  => '</tr>',                        
                        'body_cell'      => '<td>',
                        'body_cell_end'  => '</td>',

                        // Alternative
                        'alt_body_row'      => '<tr>',
                        'alt_body_row_end'  => '</tr>',                        
                        'alt_body_cell'      => '<td>',
                        'alt_body_cell_end'  => '</td>'
                ];
        }
}
