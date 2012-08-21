<?php
$this->Html->script('modal',false);
$this->Html->css('modal',null,array('inline' => false));
?>
<legend>افزودن تصویر به اسلایدر</legend>

<?php
echo $this->Form->create('SliderItem', array(
    'inputDefaults' => array(
        'error' => array(
            'attributes' => array(
                'class' => 'alert alert-error',
                'id' => 'msg'
            )
        ),
        'empty' => array(
            0 => '--- انتخاب مجموعه ---'
        )
    ),
    'type' => 'file'
));
echo $this->Form->input('link', array(
    'label' => 'نشانی اینترنتی',
    'after' => $this->Html->tag('a','انتخاب گزینه',array('class' => 'btn','id' => 'chooseItem')),
));
echo $this->Form->input('title', array('label' => 'عنوان'));
echo $this->Form->input('description', array('label' => 'توضیحات'));
echo $this->Form->input('image', array('label' => 'انتخاب تصویر','type' => 'file'));
?>
<div>
    <label>منتشر شده</label>
    <input type="radio" name="data[SliderItem][published]" value="1" <?php if ($this->Form->value('SliderItem.published') == 1) echo 'checked=""' ?> /> بله
    <input type="radio" name="data[SliderItem][published]" value="0" <?php if ($this->Form->value('SliderItem.published') == 0) echo 'checked=""' ?> /> خیر
</div>
<br/>
<input type="submit" value="ذخیره" class="btn btn-success" />
<?php
echo $this->Html->link('انصراف', array('action' => 'index', 'admin' => TRUE), array('class' => 'btn btn-danger'));
echo $this->Form->end();
?>
<script>
    $(function(){
        $('#chooseItem').click(function(){
            url = '<?php echo $this->Html->url(array('controller' => 'Contents', 'action' => 'getLinkItem')) ?>/elmID:SliderItemLink';
            $.get(url,function(data){
                $.modal(data,{overlayClose:true});
            })
        })
    })
</script>