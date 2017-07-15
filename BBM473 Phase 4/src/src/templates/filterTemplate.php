<?php

class Filter
{
    private $db;
    private $category_format;
    private $sub_category_format;
    private $simple_content;
    private $category_selected;
    private $author_selected;
    private $publisher_selected;

    function __construct()
    {

        @include_once "DB.php";
        $this->db = new DB();

        $this->category_format = "        
            <div class=\"title\">
                <i class=\"dropdown icon\"></i>                
                %s
                <div id='category-%s' class=\"ui checkbox\" style='float: right'>
                    <input type=\"checkbox\" %s>
                    <label></label>
                </div>
            </div>            
            %s
        ";

        $this->sub_category_format = "
        <div class=\"content\">                 
            <div class=\"accordion transition hidden\">
              %s
            </div>
        </div>";

        $this->simple_content = "
        <div class=\"content\">
        </div>
        ";

        $this->category_selected = array();
        $this->author_selected = array();
        $this->publisher_selected = array();
    }

    function getFilterSelected($category_selected, $author_selected, $publisher_selected) {
        $this->category_selected = $category_selected;
        $this->author_selected = $author_selected;
        $this->publisher_selected = $publisher_selected;
        return $this->getFilter();
    }

    function getFilter()
    {

        $filter = "
            <div class=\"ui styled accordion\">
                <div class=\"active title\">
                    <i class=\"dropdown icon\"></i>                    
                    Categories
                </div>
                <div class=\"active content\">
                    <div class=\"accordion\">
                    " . self::getCategories() . "
                    </div>
                </div>                
            </div>
            <div class='ui styled accordion'>
            <div class=\"title\">
                    <i class=\"dropdown icon\"></i>
                    Authors
                </div>
                <div class=\"content\">
                    <div class=\"ui divided selection list\">
                        " . self::getAuthors() . "
                    </div>
                </div>
            </div>
            <div class='ui styled accordion'>
            <div class=\"title\">
                    <i class=\"dropdown icon\"></i>
                    Publishers
                </div>
                <div class=\"content\">
                    <div class=\"ui divided selection list\">
                        " . self::getPublishers() . "
                    </div>
                </div>
            </div>
    ";
        return $filter;
    }

    function getCategories()
    {
        list($n_row, $result) = $this->db->selectAll('PARENTCATEGORY_VIEW');

        $categories = "";
        for ($i = 0; $i < $n_row; $i++) {
            $sub_category = self::getSubcategories($result['CATEGORYID'][$i]);
            if ($sub_category == "") {
                $checked = in_array($result['CATEGORYID'][$i], $this->category_selected) ? "checked" : "";
                $categories .= sprintf($this->category_format, ucfirst(strtolower($result['CATEGORY_NAME'][$i])),
                    $result['CATEGORYID'][$i], $checked, $this->simple_content);
            } else {
                $checked = in_array($result['CATEGORYID'][$i], $this->category_selected) ? "checked" : "";
                $categories .= sprintf($this->category_format, ucfirst(strtolower($result['CATEGORY_NAME'][$i])), $result['CATEGORYID'][$i],
                    $checked, sprintf($this->sub_category_format, self::getSubcategories($result['CATEGORYID'][$i])));
            }
        }
        return $categories;
    }

    function getSubcategories($parent_id)
    {
        list($n_row, $result) = $this->db->selectById('CATEGORYINHERITANCE_VIEW', 'PARENTID', $parent_id);
        $categories = "";
        for ($i = 0; $i < $n_row; $i++) {
            $sub_category = self::getSubcategories($result['SUBID'][$i]);
            if ($sub_category == "") {
                $checked = in_array($result['SUBID'][$i], $this->category_selected) ? "checked" : "";
                $categories .= sprintf($this->category_format, ucfirst(strtolower($result['SUB_NAME'][$i])),
                    $result['SUBID'][$i], $checked, $this->simple_content);
            } else {
                $checked = in_array($result['SUBID'][$i], $this->category_selected) ? "checked" : "";
                $categories .= sprintf($this->category_format, ucfirst(strtolower($result['SUB_NAME'][$i])), $result['SUBID'][$i],
                    sprintf($this->sub_category_format, $checked, self::getSubcategories($result['SUB_NAME'][$i])));
            }
        }
        return $categories;
    }

    function getAuthors()
    {
        $author_format = "
        <a class=\"item\">
            <div class=\"ui horizontal label\">
                 <i class=\"write icon\"></i>
            </div>
            %s
            <div id='author-%s' class=\"ui checkbox\" style='float: right'>
                <input type=\"checkbox\" %s>
                <label></label>
            </div>
        </a>
        ";

        list($n_row, $result) = $this->db->selectAll('AUTHOR');
        $author_list = "";
        for ($i = 0; $i < $n_row; $i++) {
            $checked = in_array($result['AUTHORID'][$i], $this->author_selected) ? "checked" : "";
            $author_list .= sprintf($author_format, $result['AUTHOR_NAME'][$i], $result['AUTHORID'][$i], $checked);
        }
        return $author_list;
    }

    function getPublishers()
    {
        $publisher_format = "
        <a class=\"item\">
            <div class=\"ui horizontal label\">
                 <i class=\"write icon\"></i>
            </div>
            %s
            <div id='publisher-%s' class=\"ui checkbox\" style='float: right'>
                <input type=\"checkbox\" %s>
                <label></label>
            </div>
        </a>
        ";

        list($n_row, $result) = $this->db->selectAll('PUBLISHER');
        $publisher_list = "";
        for ($i = 0; $i < $n_row; $i++) {
            $checked = in_array($result['PUBLISHERID'][$i], $this->publisher_selected) ? "checked" : "";
            $publisher_list .= sprintf($publisher_format, $result['PUBLISHER_NAME'][$i], $result['PUBLISHERID'][$i], $checked);
        }
        return $publisher_list;
    }
}