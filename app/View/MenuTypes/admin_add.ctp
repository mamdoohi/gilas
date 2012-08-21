<legend>افزودن نوع منو</legend>
<?php
echo $this->Form->create();
echo $this->Form->input('type', array('label' => 'نوع', 'error' => array('attributes' => array('class' => 'alert alert-error', 'id' => 'msg'))));
echo $this->Form->input('title', array('label' => 'عنوان', 'error' => array('attributes' => array('class' => 'alert alert-error', 'id' => 'msg'))));
echo $this->Form->input('description', array('label' => 'توضیحات', 'error' => array('attributes' => array('class' => 'alert alert-error', 'id' => 'msg'))));
?>
<br />
<input type="submit" value="ذخیره" class="btn btn-success" />
<?php echo $this->Html->link('انصراف', array('action' => 'index', 'admin' => TRUE), array('class' => 'btn btn-danger')); ?>
<?php echo $this->Form->end(); ?>