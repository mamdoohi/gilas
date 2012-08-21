<legend>لیست مجموعه های وب لینک</legend>
<?php
echo $this->Html->link('افزودن مجموعه وب لینک', array('action' => 'add'), array('class' => 'btn btn-primary btn-large'));
if (!empty($weblinkCategories)) {
    ?>
    <p>&nbsp;</p>
    <table class="table table-bordered table-striped">

        <tr>
            <th>ردیف</th>
            <th>نام</th>
            <th>تعداد لینک</th>
            <th>عملیات</th>
        </tr>
        <?php
        $j = 1;
        if (isset($this->params['named']['page']) && $this->params['named']['page'] > 1) {
            $j = $this->params['named']['page'] * 20 - 20 + 1;
        }
        foreach ($weblinkCategories as $weblinkCategory):
            ?>
            <tr>
                <td><?php echo $j; ?></td>
                <td><?php echo $weblinkCategory['WeblinkCategory']['name']; ?></td>
                <td><?php echo $weblinkCategory['WeblinkCategory']['linkCount']; ?></td>
                <td><?php echo $this->Form->postLink('حذف', array('action' => 'delete', $weblinkCategory['WeblinkCategory']['id'], 'admin' => TRUE), array('class' => 'btn btn-danger'), 'آیا از حذف این آیتم مطمئن هستید؟'); ?> | <?php echo $this->Html->link('ویرایش', array('action' => 'edit', $weblinkCategory['WeblinkCategory']['id'], 'admin' => TRUE), array('class' => 'btn btn-info')); ?></td>
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
