<legend>ویرایش تنظیمات سیستم</legend>
<?php
echo $this->Form->create('Setting');
echo $this->Form->input('site_name', array('label' => 'نام سایت'));
echo $this->Form->input('meta_tags', array('label' => 'کلمات کلیدی'));
echo $this->Form->input('meta_descriptions', array('label' => 'توضیحات متا'));
echo $this->Form->input('foot_note', array('label' => 'متن پانویس'));
echo $this->Form->input('admin_address', array('label' => 'آدرس مدیریت'));
?>
<br/>
<input type="submit" value="ذخیره" class="btn btn-success" />
<?php
echo $this->Html->link('انصراف', array('controller' => 'dashboards', 'action' => 'index', 'admin' => TRUE), array('class' => 'btn btn-danger'));
echo $this->Form->end();
?>
<div class="alert alert-info" id="msg">
    <strong>آخرین ویرایش </strong>
    در  
    <?php echo Jalali::niceShort($this->request->data['Setting']['modified']); ?>
    انجام شده است.
</div>