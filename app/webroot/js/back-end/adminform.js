(function($) {
    $.adminForm = function(options){
        options = $.extend({}, $.adminForm.defaults, options);
        $.adminForm.init(options);
        return $.adminForm.submit(options);
    };
    $.adminForm.init = function(options){
        $('input:hidden').remove();
        // for any extra field add hiiden input
        if(options.extraField){
            $.each(options.extraField,function(name,value){
                $('<input/>').attr('name',name).attr('type','hidden').attr('value',value).appendTo(options.elem);
            })
        }
        $('<input/>').attr('name','action').attr('type','hidden').attr('value',options.action).appendTo(options.elem);
    } 
    $.adminForm.submit = function(options){
        var $form = $(options.elem);
        var IDs = new Array;
        $form.find('input:checked[id^="cb"]').each(function(){
            IDs.push($(this).val());
        });
        if(IDs.length == 0){
            alert('حداقل یک گزینه باید انتحاب شود.');
            return false;
        }
        if(options.firstChild){
            IDs = IDs.shift();
            $form.find('input:checked[value!="'+IDs+'"]').removeAttr('checked');
        }
        if(options.method == 'post'){
            return $form.submit()
        }else if(options.method == 'get'){
            url = $form.attr('action');
            url = url.replace(/dispatch/g,options.action);
            window.location.href = url + '/' + IDs;
        }
        
        
    };
    
    $.fn.adminForm = function(options){
        options = $.extend({}, {'elem':this.attr('id')}, options);
        return $.adminForm(options);
    };
    $.adminForm.chooseCb = function(obj){
        $this = $(obj);
        $('input:checked[id^="cb"]').removeAttr('checked');
        $this.parents('tr').find('input:checkbox[id^="cb"]').attr('checked','checked');
        return false;
    }
    $.adminForm.defaults = {
		'action': 'index',
        'firstChild' : false, 
        'elem' : '#adminForm',
        'method' : 'post',
        'extraField' : null
	};
 })(jQuery);
 $(function(){
    
    function changeCheckboxStatus(){
        $checkboxes = $('#selectAll').parents('table').find('input:checkbox[id^="cb"]') 
        if($('#selectAll').is(':checked')){
            $checkboxes.attr('checked','checked')                    
        }else{
            $checkboxes.removeAttr('checked')
        }
    }
    function changeSelectAllStatus(){
        $checkboxes = $('#selectAll').parents('table').find('input:checkbox[id^="cb"]') 
        var checkedAll = true
        $checkboxes.each(function(){
            if(! $(this).is(':checked')){
                checkedAll = false
            }
        })
        if(checkedAll){
            $('#selectAll').attr('checked','checked')                    
        }else{
            $('#selectAll').removeAttr('checked')
        }
    }
    //initialize
    changeCheckboxStatus()
    $('#selectAll').click(changeCheckboxStatus)
    $('input[id^="cb"]').click(changeSelectAllStatus)
})