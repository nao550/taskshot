$(function() {
    $(".editable").click(edit_toggle());
});

function edit_toggle(){
    var edit_flag = false;
    return function(){
        if ( edit_flag ) return;

        var taskid = [$(this).siblings('.taskcd').children('span').text(), $('#token').val()];
        var $input = $("<input>").attr("type","text").val($(this).text());

        $(this).html($input);
        $("input",this).focus().blur(function(){
            save(this,taskid);
            $(this).after($(this).val()).unbind().remove();
            edit_flag=false;
        });
        edit_flag=true;
    }
}

function save(elm,taskid) {
    var chString = $(elm).val();
    var chParentStr = elm.parentNode.className;

    if (chParentStr.indexOf('taskrank') !== -1){
        chParent = 'taskrank';
    }
    if (chParentStr.indexOf('tasktag') !== -1){
        chParent = 'tasktag';
    }
    if (chParentStr.indexOf('taskdate') !== -1){
        chParent = 'taskdate';
    }
    if (chParentStr.indexOf('taskwork') !== -1){
        chParent = 'taskwork';
    }

    //alert("「"+chString+chNode+"」を保存しました。");
    // submit で保存する処理
    var $form = $('<form>', {'action': '#', 'method': 'POST'});
    $form.append($('<input>', {'type':'hidden', 'name':'mode', 'value': 'upTask'}));
    $form.append($('<input>', {'type':'hidden', 'name':'idclass', 'value': chParent}));
    $form.append($('<input>', {'type':'hidden', 'name':'idvalue','value': chString}));
    $form.append($('<input>', {'type':'hidden', 'name':'cd','value': taskid[0]}));
    $form.append($('<input>', {'type':'hidden', 'name':'token','value': taskid[1]}));
    $form.append($('</form>'));
    $form.appendTo(document.body);
    $form.submit();
}

function logout(){
    if (window.confirm('Do you want logout?')) {
        var $form = $('<form>', {'action':'#', 'method':'POST'});
        $form.append($('<input>', {'type':'hidden', 'name':'mode', 'value':'logout'}));
        $form.append($('</form>'));
        $form.appendTo(document.body);
        $form.submit();
    }
}

