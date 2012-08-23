<?php

/**
 * Menu Helper used for generating menu 
 * 
 * @package     Gilas
 * @author      Hamid
 * @copyright   2012
 * @version     0.1
 * @access      public
 */
class MenuHelper extends AppHelper{

/**
 * Used Helpers
 *
 * @var array
 */
    public $helpers = array('Html');
    
/**
 * Getting menu items for current $menuTypeID
 * 
 * @param integer $menuTypeID  : id of MenuType Model
 * @param string  $classDiv    : div class for output
 * @param string  $activeStyle : class attribute for active item
 * @return
 */
    public function getMenu($menuTypeID,$classDiv,$activeStyle){
        $items = $this->requestAction(array('controller' => 'menus', 'action' => 'getMenu', 'admin' => false, $menuTypeID));
        $output = $this->__generateMenu($items,$activeStyle);
        return $this->Html->div($classDiv, $output);
    }
    
/**
 * Generate recursive menu items
 * 
 * @param array  $menus       : items
 * @param string $activeStyle : class attribute for active item
 * @return ul li tag
 */
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