<?php

namespace Helpers\Classes;

class MenuBuilder{

    public $parentULClass;
    public $childClass;
    public $parentCaretIcon;
    public $menuItemClass;
    public $menuUrl;
    public $parentMenuLink;

    public function __construct($data, $config = []){
        
        $this->data = $data;

        $this->parentULClass = !empty($config['parent_ul_class']) ? $config['parent_ul_class'] : "";
        $this->childClass = !empty($config['child_class']) ? $config['child_class'] : "";
        $this->parentCaretIcon = !empty($config['parent_caret_icon']) ? $config['parent_caret_icon'] : "";
        $this->menuItemClass = !empty($config['menu_item_class']) ? $config['menu_item_class'] : "";
        $this->menuUrl = !empty($config['menu_url']) ? $config['menu_url'] : "";
        $this->parentMenuLink = isset($config['parent_menu_link']) ? $config['parent_menu_link'] : true;

        $this->parents = $this->data->where('parent',0)->sortBy('title');
    }

    public function getMenuHtml(){

        return $this->prepareMultiLabelMenu($this->parents);
    }

    private function prepareMultiLabelMenu($parents){

        $html = "<ul class='".$this->parentULClass."'>";

        foreach($parents as $parent){

            //if we have setup url in database, that is priority
            if(!empty($parent->url)){
                $url = $parent->url;
            }else{
                $search = ['[ID]','[SLUG]'];
                $replace = [
                    isset($parent->id) ? $parent->id : '',
                    isset($parent->slug) ? $parent->slug : '',
                ];

                $url = url(str_replace($search, $replace, $this->menuUrl));
            }

            $html .= "<li>";

            $children = $this->data->where('parent',(int)$parent->id)->sortBy('title');

            if($children->count() > 0){

                // if(!$this->parentMenuLink){
                //     $url = "#";
                // }

                //parent menu
                $html .= "<a class='".$this->menuItemClass."' href='".$url."'>".$parent->title." ".$this->parentCaretIcon."</a>";

                //calling this function recursive way
                $html .= $this->prepareMultiLabelMenu($children);
            }else{

                //children menu
                $html .= "<a href='".$url."'>".$parent->title."</a>";
            }

            $html .= "</li>";
        }

        $html .= "</ul>";

        return $html;
    }
}