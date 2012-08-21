<legend>لیست مجموعه ها</legend>
<?php
echo $this->Html->link('افزودن مجموعه مطلب', array('action' => 'add'), array('class' => 'btn btn-primary btn-large'));
if (!empty($contentCategories)) {
    ?>
    <p>&nbsp;</p>
    <table class="table table-bordered table-striped">

        <tr>
            <th>ردیف</th>
            <th>نام</th>
            <th>تعداد مطالب</th>
            <th>وضعیت انتشار</th>
            <th>عملیات</th>
        </tr>
        <?php
        $j = 1;
        if (isset($this->params['named']['page']) && $this->params['named']['page'] > 1) {
            $j = $this->params['named']['page'] * 20 - 20 + 1;
        }
        foreach ($contentCategories as $contentCategory):
            ?>
            <tr>
                <td><?php echo $j; ?></td>
                <td><?php echo $contentCategory['ContentCategory']['name']; ?></td>
                <td><?php echo $contentCategory['ContentCategory']['contentCount']; ?></td>
                <td>
                    <?php
                    if ($contentCategory['ContentCategory']['published']) {
                        $src = 'back-end/bootstrap/tick.png';
                        echo $this->Form->postLink($this->Html->image($src), array('action' => 'unPublishContentCategory', $contentCategory['ContentCategory']['id'], 'admin' => TRUE), array('escape' => false));
                    } else {
                        $src = 'back-end/bootstrap/publish_x.png';
                        echo $this->Form->postLink($this->Html->image($src), array('action' => 'publishContentCategory', $contentCategory['ContentCategory']['id'], 'admin' => TRUE), array('escape' => false));
                    }
                    ?>
                </td>
                <td><?php echo $this->Form->postLink('حذف', array('action' => 'delete', $contentCategory['ContentCategory']['id'], 'admin' => TRUE), array('class' => 'btn btn-danger'), 'آیا از حذف این آیتم مطمئن هستید؟'); ?> | <?php echo $this->Html->link('ویرایش', array('action' => 'edit', $contentCategory['ContentCategory']['id'], 'admin' => TRUE), array('class' => 'btn btn-info')); ?></td>
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