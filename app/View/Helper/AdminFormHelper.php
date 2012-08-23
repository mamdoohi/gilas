<?php

/**
 * AdminForm Helper class, is a easy way for managering
 * With this class we can select or deselect items, and doing actions for selected items 
 * 
 * @package     Gilas
 * @author      Hamid Mamdoohi
 * @copyright   2012
 * @version     0.1
 * @access      public
 */
class AdminFormHelper extends AppHelper{

/**
 * Used Helpers
 *
 * @var array
 */
    public $helpers = array('Html','Form');
    
/**
 * Special keys that used in url parameter in methods
 *
 * @var array
 */
    public $keys = array(
        'action',       // action method that data must be send to it
        'firstChild',   // true | false : true = send first selected item, false = send all 
        'method',       // post|get : sending method
        'extraField',   // extra fields that must be send with cuurent request
    );
 
/**
 * Hold added items to toolbar
 *
 * @var array
 */
    public $items = array();
 
 /**
 * Index of checkbox for any row
 * with this we create difference id for any checkbox in row,
 * starts by -1, because by first calling it increase
 * 
 * @var integer
 */
    private $__index = -1;
    
/**
 * Add item to toolbar row and create 'a' tag for this item 
 * 
 * @param mixed $title : title of item
 * @param mixed $url    : url of item, this param used for option of $.adminForm
 * @param mixed $options : options for this tag
 * @return void
 */
    public function addToolbarItem($title, $url , $options = array()){
        $this->items[] = compact('title', 'url', 'options');
    }
        
/**
 * Show toolbar
 * 
 * @param mixed $title : Title for current toolbar
 * @param bool $return : true | false : true = return output, false : echo output
 * @return output
 */
    public function showToolbar($title, $return = false){
        if(empty($this->items)){
            return false;
        }
        $output = '';
        foreach($this->items as $item){
            $output .= $this->Html->tag('li',$this->__createItem($item));
        }
        $toolbar = $this->Html->tag('ul',$output, array('id' => 'toolbar'));
        $title = $this->Html->div('title', $title);
        $output = $this->Html->div('row',$title . $toolbar,array('id' => 'toolbar-menu'));
        if($return){
            return $output;
        }
        echo $output;
        
    }

/**
 * Generate 'a' tag for current $item
 * 
 * @param array $item : contain all parameters of self::addToolbarItem() in one array
 * @param bool $inToolbar: true | false : true = this item used in toolbar, false = this item used in row
 * @return 'a' tag
 */
    private function __createItem($item,$inToolbar = true){
        extract($item);
        // Normal Link
        if(!empty($url['normalLink'])){
            unset($url['normalLink']);
            return $this->Html->link($title, $url,$options); 
        }
        if(is_array($url)){
            $extraField = array();
            foreach($url as $key => $value){
                if(!in_array($key,$this->keys) || is_int($key)){
                    $extraField[$key] = $value;
                    unset($url[$key]);
                }
            }
            if(! empty($url['extraField'])){
                $extraField = Set::merge($extraField,$url['extraField']);
            }
            if(! empty($extraField)){
                $url['extraField'] = $extraField;
            }
            
        }  
        $url = json_encode($url);
        // replace " with '
        $url = str_replace('"',"'",$url);
        $options['onclick'] = '$.adminForm('.$url.');';
        if(! $inToolbar){
            $options['onclick'] = '$.adminForm.chooseCb(this);'.$options['onclick'];    
        }
        return $this->Html->link($title, 'javascript:void(0);',$options);     
    }
    
/**
 * Return start 'form' tag 
 * 
 * @return 'form' tag
 */
    public function startFormTag(){
        return $this->Form->create(null,array('action' => 'dispatch','id' => 'adminForm'));
    }
    
/**
 * Return checkbox that with it, we can (select| deselect) all rows
 * 
 * @return 'checkbox' tag 
 */
    public function selectAll(){
        return $this->Html->useTag('input',null,array('type' => 'checkbox', 'id' => 'selectAll'));
    }
    
/**
 * Return checkbox for current row
 * 
 * @param number $id : ID of current row
 * @return 'checkbox' tag 
 */
    public function checkbox($id){
        // increase for this index
        $this->__index ++;
        
        $tagID = 'cb'.$this->__index;
        return $this->Html->useTag('input','id[]',array('type' => 'checkbox', 'value' => $id,'id' => $tagID));
    }
    
/**
 * We can use items for any row as same as toolbar item,
 * items is same self::addToolbarItem()
 * 
 * @param mixed $title
 * @param mixed $url
 * @param mixed $options
 * @return
 */
    public function item($title, $url,  $options = array()){
        $item = compact('title', 'url', 'options');
        return $this->__createItem($item,false);
    }
    
/**
 * Add script to document
 * 
 * @return void
 */
    public function beforeRender(){
        $this->Html->script('back-end/adminform',false);
    }
    
/**
 * Return end 'form' tag
 * 
 * @return
 */
    public function endFormTag(){
        return $this->Form->end();
    }
}
