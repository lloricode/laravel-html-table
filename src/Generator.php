<?php

namespace Lloricode\LaravelHtmlTable;

use Illuminate\Database\Eloquent\Model;

class Generator
{
    
        
        /**
         *
         *
         *
         *
         * @type array
         */
    protected $tags;
        
    /**
     *
     *
     *
     *
     * @type mixed
     */
    protected $attributes;
        
    /**
     *
     *
     *
     *
     * @type string
     */
    protected $links;
   
    /**
     *
     *
     *
     *
     * @type string
     */
    protected $caption;

    /**
     *
     *
     *
     *
     * @type optionLinks
     */
    protected $optionLinks;
        
    protected $modelResultClosure;
         
         
    /**
         * Contructor
         *
         *
         *
         */
    public function __construct()
    {
        $this->tags = $this->_getDefaultTags();
        $this->links = null;
        $this->optionLinks = null;
        $this->modelResultClosure = null;
    }


        
    /**
     *
     * Generate Html Header with value.
     *
     *
     * @param array $header
     * @return string
     * @author Lloric Mayuga Garcia <lloricode@gmail.com>
     */
    private function _header(array $header)
    {
        $output = $this->tags['head'];

        $output .= $this->tags['head_row'];

        foreach ($header as $row) {
            $output .= $this->tags['head_cell'].$row.$this->tags['head_cell_end'];
        }
        
        if (!is_null($this->optionLinks)) {
            $output .= $this->tags['head_cell'].$this->optionLinks['headerLabel'].$this->tags['head_cell_end'];
        }

        return $output.$this->tags['head_row_end'].$this->tags['head_end'];
    }


    protected function setCaption($caption)
    {
        $this->caption = $caption;
    }
        
        
    /**
     *
     * Generate Rows with data.
     *
     *
     * @param array $data
     * @return string
     * @author Lloric Mayuga Garcia <lloricode@gmail.com>
     */
    private function _rows_data(array $data)
    {
        $output = $this->tags['body'];

        $alt = 0;
        foreach ($data as $row1) {
            $alter = ($alt%2===0)?'':'alt_';

            $output .= $this->tags[$alter.'body_row'];
            foreach ($row1 as $row) {
                $body_cell_tag_close = $this->tags['body_cell_end'];
                if (is_array($row) && array_key_exists('data', $row)) {
                    $data = $row['data'];
                    unset($row['data']);
                                          
                    if (isset($row['body_celltags'])) {
                        $body_cell_tag = $row['body_celltags'];
                        $body_cell_tag_open = $body_cell_tag['open'];
                        $body_cell_tag_close = $body_cell_tag['close'];
                    } else {
                        $body_cell_tag_open = trim($this->tags[$alter.'body_cell'], '>').$this->_attributeToString($row).'>';
                    }
                } else {
                    $data   = $row;
                    $attrib = '';
                    $body_cell_tag_open = $this->tags[$alter.'body_cell'];
                }


                $output .= $body_cell_tag_open.$data.$body_cell_tag_close;
            }
            $output .= $this->tags['body_row_end'];

            $alt++;
        }
        return $output.$this->tags['body_end'];
    }

    private function _rows_data_with_model($model, array $fields, $limit)
    {
        $model = $model::select($fields);

        if (!is_null($this->modelResultClosure)) {
            $c = $this->modelResultClosure;
            $model = $c($model);
        }

        if ($limit == 0) {
            $objt = $model->get();
        } else {
            $objt = $model->paginate($limit);
            $this->links = $objt->links();
        }

        $data=[];
        
        foreach ($objt as $r) {
            $t=[];
            foreach ($fields as $f) {
                $t[]=$r[$f];
            }
            
            if (!is_null($this->optionLinks)) {
                $t[] = $this->_optionLinks($r);
            }

            $data[]=$t;
        }
        return $this->_rows_data($data);
    }
    
    private function _optionLinks($model)
    {
        $link = route($this->optionLinks['routerName'], $model->{$model->getRouteKeyName()});
        $label = null;
        if (!is_null($this->optionLinks['rowLabel'])) {
            $label = $this->optionLinks['rowLabel'];
        } else {
            $label = 'View';
        }
        return "<a href=\"$link\">$label</a>";
    }
        
    /**
     *
     * Convert attributes to string format.
     *
     *
     * @return mixed
     * @author Lloric Mayuga Garcia <lloricode@gmail.com>
     */
    private function _attributeToString($param)
    {
        $return = '';
        if (is_array($param)) {
            foreach ($param as $key => $value) {
                if (!array_key_exists($key, $this->tags)) {
                    $return .= $this->_attributeToString("$key=\"$value\"");
                }
            }
        } else {
            $return = $param;
        }
        return ((strlen($return)>0) && !empty($return))
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
     * @author Lloric Mayuga Garcia <lloricode@gmail.com>
     */
    protected function execute(array $header, $model_or_array, $limit = null, array $fields = null)
    {
        $output = $this->generateOpenTag();

        if (!is_null($this->caption)) {
            $output .= "<caption>{$this->caption}</caption>";
        }
                
        $output .= $this->_header($header);
        if (is_array($model_or_array)) {
            $output .= $this->_rows_data($model_or_array);
        } elseif (is_string($model_or_array) && !is_null($fields)&& !is_null($limit)) {
            $output .= $this->_rows_data_with_model($model_or_array, $fields, $limit);
        }
        
        $this->_resetDefaultTags();
        $this->optionLinks = null;
        return $output . $this->tags['table_end'];
    }

        
    /**
     *
     * Generate a open tag for <table> with attribute specified
     *
     *
     *
     * @return string
     * @author Lloric Mayuga Garcia <lloricode@gmail.com>
     */
    protected function generateOpenTag()
    {
        $openTag = $this->tags['table'];
        return rtrim($openTag, '>'). $this->_attributeToString($this->attributes).'>';
    }

        
    /**
     *
     * Override default tags,
     * with on existed keys on array $this->tags.
     *
     *
     * @author Lloric Mayuga Garcia <lloricode@gmail.com>
     */
    protected function checTagsFromAttrbutes()
    {
        if (is_array($this->attributes)) {
            // Get all keys
            foreach (array_keys($this->tags) as $key) {
                // if default key exist in attribute given by user,
                // replay the valu from default key.
                if (array_key_exists($key, $this->attributes)) {
                    $this->tags[$key] = $this->attributes[$key];
                    unset($this->attributes[$key]);
                }
            }
        }
    }
    
    /**
     *
     * Reset Tags
     *
     *
     * @author Lloric Mayuga Garcia <lloricode@gmail.com>
     */
    private function _resetDefaultTags()
    {
        $this->tags = $this->_getDefaultTags();
    }
    /**
     *
     * Default html table tags.
     *
     *
     * @return array
     * @author Lloric Mayuga Garcia <lloricode@gmail.com>
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
