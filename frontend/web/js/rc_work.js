//显示新建/修改作品集弹层
function showWorklist(event,id, name, cover)
{
    if ('' === id.trim())
    {
        //新建作品集
        $('#myModalLabelCreate').html('创建作品集');
        $('#name').val('');
        $('#cover').val('');
        $('#status').val('');
        $('#p_work_id').val('');
        $('#worklist_cover').attr('src', '');
        $('#myModal').modal('show');
    }
    else
    {
        //更新作品集
        $('#myModalLabelCreate').html('更新作品集');
        $('#name').val(name);
        $('#cover').val(cover);
        $('#p_work_id').val(id);
        $('#worklist_cover').attr('src', cover);
        $('#myModal').modal('show');
    }
    stopPropagation(event);
}
//显示删除作品集弹层
function showDelete(event,id)
{
    $('#p_work_id').val(id);
    $('#status').val('2');
    $('#deleteModal').modal('show');
     stopPropagation(event);
}
//隐藏新建/修改作品集弹层
function hideWorklist()
{
    $('#myModalLabelCreate').html('创建作品集');
    $('#name').val('');
    $('#cover').val('');
    $('#p_work_id').val('');
    $('#worklist_cover').attr('src', '');
    $('#myModal').modal('hide');
}
//隐藏删除作品集弹层
function hideDelete()
{
    $('#p_work_id').val('');
    $('#status').val('');
    $('#deleteModal').modal('hide');
}
//更新作品集
function updateWorklist()
{
    var username = $('#username').val();
    var p_work_id = $('#p_work_id').val();
    var cover = $('#cover').val();
    var name = $('#name').val();
    var status = $('#status').val();
    $.ajax({
        type: 'post',
        url: "/personal/worklist/create",
        dataType: 'json',
        data: {username: username, p_work_id: p_work_id, cover: cover, name: name, status: status},
        success: function (data) {
            if (data.ret == 13640 || data.ret === 13645)
            {
                $('#myModal').modal('hide');
                location.reload();
            } else {
                alert(data.message);
            }
        }
    });
}
//跨越上传文件
function uploadfile() {
    if ('' == $("#attachment").val())
    {
        alert('请作品集封面图片');
        return false;
    }
    jQuery("#upload").submit();
}
//回调用设置作品集图片
function setfileurl(fileurl) {
    $("#cover").val(fileurl);
    $("#worklist_cover").attr("src", fileurl).show();
}
//显示删除作品弹层
function showWorkDelete(event,id)
{
    $('#hidden_work_id').val(id);
    $('#deleteModal').modal('show');
     stopPropagation(event);
}
//隐藏删除作品集弹层
function hideWorkDelete()
{
    $('#hidden_work_id').val('');
    $('#deleteModal').modal('hide');
}
//删除作品
function deleteWork(){
    var id = $('#hidden_work_id').val();
    $.ajax({
        type: 'post',
        url: "/personal/index/delete-work",
        dataType: 'json',
        data: {workid: id},
        success: function (data) {
            if (data.ret === 13672)
            {
                hideWorkDelete();
                location.reload();
            } else {
                alert(data.message);
            }
        }
    });
}
//动态页面选择作品
function selectWork(id){
    $("#hidden_work_id").val(id);
}
//动态页面更新作品的作品集
function changeWorklist(p_work_id){
    var workid = $('#hidden_work_id').val();
    $.ajax({
        type: 'post',
        url: "/personal/index/update-work",
        dataType: 'json',
        data: {workid: workid, p_work_id: p_work_id},
        success: function () {
            location.reload();
        }
    });
}

function stopPropagation(event){
    if (event.stopPropagation)  event.stopPropagation();
    else  event.cancelBubble = true;
}