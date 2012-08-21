<?php

class MenuHelper extends AppHelper{
    public $helpers = array('Html');
    public function getMenu($menuTypeID,$classDiv,$activeStyle){
        $items = $this->requestAction(array('controller' => 'menus', 'action' => 'getMenu', 'admin' => false, $menuTypeID));
        $output = $this->__generateMenu($items,$activeStyle);
        return $this->Html->div($classDiv, $output);
    }
    
    private function __generateMenu($menus,$activeStyle){
        $output = null;
        if($menus){
            foreach($menus as $menu){
                $child = null;
                if($menu['children']){
                    $child = $this->__generateMenu($menu['children'],$activeStyle);
                    $child = $this->Html->tag('ul',$child,array('class' => 'sub-menu' ));
                }
                $output .= $this->Html->tag('li',$this->Html->link($menu['Menu']['title'],$menu['Menu']['link']).$child,array('class' => (Router::url(null,true) == $menu['Menu']['link'])?$activeStyle:'' ));
                
            }
        }
        return $output;
    }
}