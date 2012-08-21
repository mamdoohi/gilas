<?php
$this->Html->script('modal',false);
$this->Html->css('modal',null,array('inline' => false));
?>
<legend>افزودن گزینه منو</legend>
<?php
$parentsOption = array();
foreach($parents as $parent){
    $char = '';
    for($i =0; $i< $parent['Menu']['level']; $i ++){
        $char .= '- ';
    }
    $parentsOption[] = array(
        'name' => $char . $parent['Menu']['title'],
        'value' => $parent['Menu']['id'],
        'position' => $parent['Menu']['menu_type_id'],
    );
}
$parents = array();
echo $this->Form->create('Menu');
echo $this->Form->input('link_type', array(
    'label' => 'نوع گزینه', 
    'id' => 'linkType',
    'options' => $linkTypes,
    'error' => array('attributes' => array('class' => 'alert alert-error', 'id' => 'msg'))
    )
);
echo $this->Form->input('menu_type_id', array('label' => 'موقعیت منو','id' => 'position','value' => @$this->request->named['menu_type_id'] ,'error' => array('attributes' => array('class' => 'alert alert-error', 'id' => 'msg'))));
echo $this->Form->input('parent_id', array(
    'label' => 'گزینه پدر', 
    'id' => 'parentMenu',
    'options' => $parentsOption,
    'empty' => array(0 => '--- انتخاب مجموعه ---'), 
    'error' => array('attributes' => array('class' => 'alert alert-error', 'id' => 'msg'))
    )
);
echo $this->Form->input('title', array('label' => 'عنوان', 'error' => array('attributes' => array('class' => 'alert alert-error', 'id' => 'msg'))));
echo $this->Form->input('link', array(
    'label' => 'آدرس وب', 
    'error' => array('attributes' => array('class' => 'alert alert-error', 'id' => 'msg')),
    'after' => $this->Html->tag('a','انتخاب گزینه',array('class' => 'btn','id' => 'chooseItem','style' => 'display:none')),
    )
);
?>
<div>
    <label>منتشر شده</label>
    <input type="radio" name="data[Menu][published]" value="1" <?php if ($this->Form->value('Menu.published') == 1) echo 'checked=""' ?> /> بله
    <input type="radio" name="data[Menu][published]" value="0" <?php if ($this->Form->value('Menu.published') == 0) echo 'checked=""' ?> /> خیر
</div>
<br />
<input type="submit" value="ذخیره" class="btn btn-success" />
<?php echo $this->Html->link('انصراف', array('action' => 'index', 'admin' => TRUE), array('class' => 'btn btn-danger')); ?>
<?php echo $this->Form->end(); ?>

<script>
    $(function(){
        var linkType = 'External';
        var changeLinkStatus = function(){
            linkType = $('#linkType').val()
            if(linkType != 'External'){
                $('#chooseItem').show()
                $('#MenuLink').attr('readonly','readonly')
            }else{
                $('#chooseItem').hide()
                $('#MenuLink').removeAttr('readonly')
            }
        }
        
        $('#linkType').change(function(){
            changeLinkStatus()
            $('#MenuLink').val('')
        })
        
        $('#linkType').load(function(){
            changeLinkStatus()
        })
        
        $('#linkType').trigger('load')
        
        $('#chooseItem').click(function(){
            url = '<?php echo $this->Html->url(array('controller' => '#Controller', 'action' => 'getLinkItem')) ?>/elmID:MenuLink';
            url = url.replace(/#Controller/g,linkType)
            $.get(url,function(data){
                $.modal(data,{overlayClose:true});
            })
        })
        $('#position').change(function(){
            position = $(this).attr('value')
            $('#parentMenu option').each(function(){
                $this = $(this)
                // hide all
                $this.hide().attr('disabled','disabled')
                //show related position
                if($this.attr('position') == position){
                    $this.show().removeAttr('disabled')
                }
                //select empty option
                if($this.val() == 0){
                    $this.attr('selected','selected');
                    $this.show().removeAttr('disabled')
                }
            })
        })
        $('#position').trigger('change')
    })
</script>
