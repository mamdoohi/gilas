<legend>لیست نوع منو ها</legend>
<?php
echo $this->Html->link('افزودن نوع منو ', array('action' => 'add'), array('class' => 'btn btn-primary btn-large'));
if (!empty($menuTypes)) {
    ?>
    <p>&nbsp;</p>
    <table class="table table-bordered table-striped">

        <tr>
            <th>ردیف</th>
            <th>نوع</th>
            <th>عنوان</th>
            <th id="grid-align">گزینه های منو</th>
            <th id="grid-align">عملیات</th>
        </tr>
        <?php
        $j = 1;
        foreach ($menuTypes as $menuType):
            ?>
            <tr>
                <td><?php echo $j++; ?></td>
                <td><?php echo $menuType['MenuType']['type']; ?></td>
                <td><?php echo $menuType['MenuType']['title']; ?></td>
                <td id="grid-align"><?php echo $this->Html->link($menuType['MenuType']['childCount'],array('controller' => 'menus','action' => 'index', 'admin' => true, 'menu_type_id' => $menuType['MenuType']['id'])); ?></td>
                <td id="grid-align">
                <?php echo $this->Form->postLink($this->Html->tag('i','',array('class' => 'icon-trash icon-white')).' حذف', array('action' => 'delete', $menuType['MenuType']['id'], 'admin' => TRUE), array('class' => 'btn btn-danger','escape' => false), 'آیا از حذف این آیتم مطمئن هستید؟'); ?> | 
                <?php echo $this->Html->link($this->Html->tag('i','',array('class' => 'icon-pencil icon-white')).' ویرایش', array('action' => 'edit', $menuType['MenuType']['id'], 'admin' => TRUE), array('class' => 'btn btn-info','escape' => false)); ?></td>
            </tr>
            <?php
            $j++;
        endforeach;
        ?>
    </table>
    <?php
}
?>
<?php echo $this->Filter->limitAndPaginate(); ?>
