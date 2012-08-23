<?php
// Add
$this->AdminForm->addToolbarItem(
    $this->Html->tag('i','',array('class' => 'icon-plus icon-white')).' افزودن',
    array('action' => 'add','menu_type_id' => @$this->request->named['menu_type_id'],'normalLink' => true ),
    array('class' => 'btn btn-success','escape' => false)
);
// Delete
$this->AdminForm->addToolbarItem(
    $this->Html->tag('i','',array('class' => 'icon-trash icon-white')).' حذف',
    array('action' => 'delete'),
    array('class' => 'btn btn-danger','escape' => false)
);
// Edit
$this->AdminForm->addToolbarItem(
    $this->Html->tag('i','',array('class' => 'icon-pencil icon-white')).' ویرایش',
    array('action' => 'edit','method' => 'get','firstChild' => true),
    array('class' => 'btn btn-info','escape' => false)
);
// Order up
$this->AdminForm->addToolbarItem(
    $this->Html->tag('i','',array('class' => 'icon-arrow-up icon-white')).' حرکت به بالا',
    array('action' => 'move','type' => 'Up'),
    array('class' => 'btn btn-info','escape' => false)
);
//Order Down
$this->AdminForm->addToolbarItem(
    $this->Html->tag('i','',array('class' => 'icon-arrow-down icon-white')).' حرکت به پایین',
    array('action' => 'move','type' => 'Down'),
    array('class' => 'btn btn-info','escape' => false)
);
// Publish
$this->AdminForm->addToolbarItem(
    $this->Html->tag('i','',array('class' => 'icon-ok icon-white')).' انتشار',
    array('action' => 'publishMenu'),
    array('class' => 'btn btn-info','escape' => false)
);
// unPublish
$this->AdminForm->addToolbarItem(
    $this->Html->tag('i','',array('class' => 'icon-remove icon-white')).' عدم انتشار',
    array('action' => 'unPublishMenu'),
    array('class' => 'btn btn-info','escape' => false)
);
//Show toolbar
$this->AdminForm->showToolbar('لیست منو ها');

//Filtering
// we use action in options for rewriting action attr without querystring
echo $this->Filter->create('Menu',array('action' => 'index'));
echo $this->Filter->input('title',array('label' => 'عنوان'));
echo $this->Filter->input('published',array(
    'label' => 'وضعیت',
    'options' => array('' => '','0' => 'منتشر نشده', '1' => 'منتشر شده'))
);
echo $this->Filter->input('menu_type_id',array(
    'label' => 'موقعیت منو',
    'options' => $menuTypes,
    'empty' => ''
    )
);
echo $this->Filter->end();

if (!empty($menus)){
    // start form tag
    echo $this->AdminForm->startFormTag();
    //start table tag
    echo $this->Html->tag('table',null,array('class' => 'table table-bordered table-striped'));
    // th tag
    echo $this->Html->tableHeaders(array(
            $this->AdminForm->selectAll(),
            'ردیف',
            'عنوان',
            'آدرس وب ',
            'موقعیت',
            'نوع گزینه',
            array('منتشر شده' => array('id' => 'grid-align' )),
            array('ترتیب' => array('id' => 'grid-align', 'style' => 'width: 78px;' )),
        )
    );
    //current index
    $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
    
    foreach ($menus as $menu){
        
        // start TR tag
        echo $this->Html->tag('tr');
        
        // checkbox
        echo $this->Html->tag('td',$this->AdminForm->checkbox($menu['Menu']['id']),array('id' => 'grid-align'));
        
        // row count
        echo $this->Html->tag('td',++$index,array('id' => 'grid-align'));
        
        // title with count level in begin
        $title = $menu['Menu']['title'];
        for($i=0;$i<$menu['Menu']['level'] ; $i++){
            $title = $this->Html->tag('span','|&mdash;',array('class' => 'gi')) . $title;
        }
        echo $this->Html->tag('td',$title);
        
        // link with truncate if it is longer that 40 character
        echo $this->Html->tag('td',
            $this->Html->link(
                String::truncate($menu['Menu']['link'],40),$menu['Menu']['link'],array('target' => '_blank')
            )
        );
        
        // menu type title
        echo $this->Html->tag('td',$menu['MenuType']['title']);
        
        // link type title
        echo $this->Html->tag('td',$menu['Menu']['namedLinkType']);
        
        // published or non published
        $typePublish = null;
        if ($menu['Menu']['published']) {
            // Published
            $typePublish = $this->AdminForm->item(
                $this->Html->image('back-end/bootstrap/tick.png'),//title
                array('action' => 'unPublishMenu'),// url
                array('escape' => false)//option
            );
        } else {
            // Non Published
            $typePublish = $this->AdminForm->item(
                $this->Html->image('back-end/bootstrap/publish_x.png'),
                array('action' => 'publishMenu'),
                array('escape' => false)
            );
        }
        echo $this->Html->tag('td',$typePublish,array('id' => 'grid-align'));
        
        // Ordering
        $ordering = null;
        
        // order up
        if(!empty($menu['Menu']['hasLeft'])){
           $ordering .= $this->AdminForm->item(
                $this->Html->tag('i','',array('class' => 'icon-arrow-up icon-white')),
                array('action' => 'move','type' => 'Up'),
                array('class' => 'btn btn-info','style' => 'float:right','escape' => false)
            );
        } 
        
        // order down
        if(!empty($menu['Menu']['hasRight'])){ 
            $ordering .= $this->AdminForm->item(
                $this->Html->tag('i','',array('class' => 'icon-arrow-down icon-white')),
                array('action' => 'move','type' => 'Down'),
                array('class' => 'btn btn-info','style' => 'float:left','escape' => false)
            );
        }
        echo $this->Html->tag('td',$ordering);
        
        // end TR tag
        echo $this->Html->useTag('tagend','tr');
        
    }//end foreach Ln 82
    echo $this->Html->useTag('tagend','table');//end table tag
    echo $this->AdminForm->endFormTag();// end form tag
}//end if Ln 56
echo $this->Filter->limitAndPaginate();// limitation and pagination
?>