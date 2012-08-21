<?php
if(empty($this->passedArgs['elmID'])){
    echo 'اشکال در بازیابی';
    return;
}
?>
<div id="searchPostDiv">
<div>
    <form class="form-inline" onsubmit="$.get('<?php echo $this->Html->url() ?>',{'q':$('#searchPostText').val()},function(data){$('#searchPostDiv').parent().html(data);});return false;">
    <label class="inline">عنوان</label>
    <input id="searchPostText" type="text" value="<?php echo @$this->request->query['q'] ?>"/>
    <input type="submit" value="جستجو"class="btn" />
    </form>
</div>
<?php
if(empty($contents)){
    echo 'هیچ مطلبی یافت نشد';
    return;
}
?>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ردیف</th>
            <th>عنوان</th>
        </tr>
    </thead>
    <?php foreach($contents as $content):?>
    <tr>
        <td><?php echo $content['Content']['id'] ?></td>
        <td><a onclick="$('#<?php echo $this->passedArgs['elmID'] ?>').val('<?php echo $this->Html->url(array('action' => 'view',$content['Content']['id'],'admin' => false),true); ?>');$.modal.close();"><?php echo $content['Content']['title'] ?></a></td>
    </tr>
    <?php endforeach;?>
</table>
<div class="pagenavi">
	<span class="pages"><?php echo $this->Paginator->counter('صفحه {:page} از {:pages}') ?></span>
    <?php echo $this->Paginator->numbers(array('class' => 'page','separator' => ' ','href' => '#','onclick' => "$.get('".$this->Html->url()."/page:'+$(this).text(),function(data){\$('#searchPostDiv').parent().html(data);});return false;")); ?>
</div>
</div>