$(function(){
    var taskid = [$('#taskcd').val(), $('#token').val()];
    $('#taskrank').click(edit_toggle(taskid));
});

$(function(){
    var taskid = [$('#taskcd').val(), $('#token').val()];
    $('#tasktag').click(edit_toggle(taskid));
});

$(function(){
    var taskid = [$('#taskcd').val(), $('#token').val()];
    $('#taskdate').click(edit_toggle(taskid));
});

$(function() {
    var taskid = [$('#taskcd').val(), $('#token').val()];
    $('#taskwork').click(edit_toggle(taskid));
});

function edit_toggle(taskid){
    var edit_flag = false;
    return function(){
        if ( edit_flag ) return;
        var $input = $("<input>").attr("type","text").val($(this).text());
        $(this).html($input);

        $("input",this).focus().blur(function(){
            save(this, taskid);

            $(this).after($(this).val()).unbind().remove();
            edit_flag=false;
        });
        edit_flag=true;
    }
}

function save(elm,taskid) {
    chString = $(elm).val();
    chParent = elm.parentNode.id;

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