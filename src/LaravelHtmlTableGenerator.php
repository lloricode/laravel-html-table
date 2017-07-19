<?php

namespace Lloricode\LaravelHtmlTable;

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
         * Contructor
         *      
         *
         *
         */
        public function __construct()
        {
                $this->_tags = $this->_getDefaultTags();
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
                $output = $this->_tags['head'].$this->_tags['head_row'];
                foreach($header as $row)
                {
                        $output .= $this->_tags['head_cell'].$row.$this->_tags['head_cell_end'];
                }
                return $output.$this->_tags['head_row_end'].$this->_tags['head_end'];
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
                foreach($data as $row1)
                {
                        $output .= $this->_tags['body_row'];
                        foreach($row1 as $row)
                        {
                                $output .= $this->_tags['body_cell'].$row.$this->_tags['body_cell_end'];
                        }
                        $output .= $this->_tags['body_row_end'];
                }
                return $output.$this->_tags['body_end'];
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
                        ?(' '.$return):'';
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
        private  function _generate(array $header,array $data = [])
        {
                $output = $this->_generateOpenTag();
                $output .= $this->_header($header);
                $output .= $this->_rows_data($data);
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
                                        // $this->_tags[$key] = $this->_attributes[$key];
                                        // unset($this->_attributes[$key]);
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
        public function generateTable($header, $data = [],$attributes = [])
        {
                $this->_attributes = $attributes;
                $this->_checTagsFromAttrbutes();
                return $this->_generate($header ,$data);
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