<legend>لیست منو ها</legend>
<?php
echo $this->Html->link('افزودن گزینه منو ', array('action' => 'add','menu_type_id' => @$this->request->named['menu_type_id']), array('class' => 'btn btn-primary btn-large'));
//Filtering
// we use action in options for rewrite action attr without querystring
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

if (!empty($menus)):
    ?>
    <p>&nbsp;</p>
    <table class="table table-bordered table-striped">

        <tr>
            <th>ردیف</th>
            <th>عنوان</th>
            <th>آدرس وب</th>
            <th>موقعیت</th>
            <th>نوع گزینه</th>
            <th id="grid-align">منتشر شده</th>
            <th id="grid-align" style="width: 78px;">ترتیب</th>
            <th id="grid-align">عملیات</th>
        </tr>
        <?php
        $j = 1;
        foreach ($menus as $menu):
            ?>
            <tr>
                <td><?php echo $j++; ?></td>
                <td><?php 
                for($i=0;$i<$menu['Menu']['level'] ; $i++){
                    echo $this->Html->tag('span','|&mdash;',array('class' => 'gi'));
                }
                echo $menu['Menu']['title']; 
                ?></td>
                <td><?php echo $this->Html->link(String::truncate($menu['Menu']['link'],40),$menu['Menu']['link'],array('target' => '_blank')); ?></td>
                <td><?php echo $menu['MenuType']['title']; ?></td>
                <td><?php echo $menu['Menu']['namedLinkType']; ?></td>
                <td id="grid-align">
                    <?php
                    if ($menu['Menu']['published']) {
                        $src = 'back-end/bootstrap/tick.png';
                        echo $this->Form->postLink($this->Html->image($src), array('action' => 'unPublishMenu', $menu['Menu']['id'], 'admin' => TRUE), array('escape' => false));
                    } else {
                        $src = 'back-end/bootstrap/publish_x.png';
                        echo $this->Form->postLink($this->Html->image($src), array('action' => 'publishMenu', $menu['Menu']['id'], 'admin' => TRUE), array('escape' => false));
                    }
                    ?>
                </td>
                <td id="grid-align"><?php 
                if(!empty($menu['Menu']['hasLeft'])){
                    echo $this->Form->postLink($this->Html->tag('i','',array('class' => 'icon-arrow-up icon-white')), array('action' => 'move', $menu['Menu']['id'],'Up', 'admin' => TRUE), array('class' => 'btn btn-info','style' => 'float:right','escape' => false));
                } 
                
                if(!empty($menu['Menu']['hasRight'])){ 
                    echo $this->Form->postLink($this->Html->tag('i','',array('class' => 'icon-arrow-down icon-white')), array('action' => 'move', $menu['Menu']['id'],'Down', 'admin' => TRUE), array('class' => 'btn btn-info','style' => 'float:left','escape' => false));
                }
                ?></td>
                <td id="grid-align">
                <?php echo $this->Form->postLink($this->Html->tag('i','',array('class' => 'icon-trash icon-white')).' حذف', array('action' => 'delete', $menu['Menu']['id'], 'admin' => TRUE), array('class' => 'btn btn-danger','escape' => false), 'آیا از حذف این آیتم مطمئن هستید؟'); ?> | 
                <?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'icon-pencil icon-white')).' ویرایش', array('action' => 'edit', $menu['Menu']['id'], 'admin' => TRUE), array('class' => 'btn btn-info','escape' => false)); ?></td>
            </tr>
            <?php
            $j++;
        endforeach;
        ?>
    </table>
    <?php endif; ?>
    <?php echo $this->Filter->limitAndPaginate(); ?>
