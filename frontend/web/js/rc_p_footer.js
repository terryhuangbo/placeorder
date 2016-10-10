function showMessageWindow(){
    var vso_uname=$("#from_username").val();
    if(''===vso_uname)
    {
        $('#sendMessage').modal('hide');
        window.location.href="http://account.vsochina.com/user/login";
        return;
    }
    $('#sendMessage').modal('show');
}
/**
 * 发送站内信，
 */
function sendMessage() {
    if (!checkInner('tar_title', 'span_title', 2, 20) &&
            !checkInner('tar_content', 'message_content_tip', 5, 1000))
    {
        return false;
    }
    var data = $("#frm_msg").serialize();
    $.post('/personal/index/message/', data,
        function (json) {
            if (13790 === json.ret)
            {
                $('#sendMessage').modal('hide')
                $(':input', '#frm_msg').not(':button, :submit, :reset, :hidden').val('');
                $('#message_content_tip').html('已输入长度0，还可以输入1000字')
                alert('短信发送成功!');
            }else if(9012===json.ret){
                window.location.href="http://account.vsochina.com/user/login";
            }
            else
            {
                alert(json.message);
            }
        }, 'json');
}
/**
 * 统计字数
 */
function countChar(id1, id2, max) {
    var inputEle = $("#" + id1);
    var l1 = parseInt(inputEle.val().length);
    var l2 = max - l1;
    var str = '';
    if (l2 < 0) {
        str = "已超出限制范围，已输入长度:" + l1 + "！";
    } else {
        str = "已输入长度:" + l1 + "，还可以输入:" + l2 + "字";
    }
    $("#" + id2).html(str);
}
/**
 * 输入验证
 */
function checkInner(id1, id2, min, max) {
    var inputEle = $("#" + id1);
    var l1 = parseInt(inputEle.val().length);
    if (l1 < min)
    {
        var str = "请输入" + min + "-" + max + "字，已输入长度:" + l1 + "！";
        $("#" + id2).html(str);
        $("#" + id1).focus();
        return false;
    }
    var l2 = max - l1;
    if (l2 < 0) {
        var str = "已超出限制范围，已输入长度:" + l1 + "！";
        $("#" + id2).html(str);
        $("#" + id1).focus();
        return false;
    }
    if ('tar_content' === id1)
    {
        str = "已输入长度:" + l1 + "，还可以输入:" + l2 + "字";
        $("#" + id2).html(str);
        return true;
    }
    $("#" + id2).html('&nbsp;');
    return true;
}
function favor(obj_name, id)
{
    var currentUrl=$("#currentUrl").val();
    $.ajax({
        url: "/rc/search/favor",
        dataType: 'json',
        data: {redirect:currentUrl,obj_name: obj_name, id: id},
        success: function (data) {
            if (data.ret == 13380)
            {
                $('#' + obj_name).removeAttr("onclick");
                $('#' + obj_name).html("<i class='icon-24 icon-24-hart'></i> 取消关注");
                $('#' + obj_name).attr("onclick", "unfavor('" + obj_name + "','" + id + "')");
                $('#focus_num').html(data.focus_num);
            }else if(data.ret===13381||data.ret===13382){
                window.location.href="http://account.vsochina.com/user/login";
            } else {
                alert(data.message);
            }
        }
    });
}
function unfavor(obj_name, id)
{
    var currentUrl=$("#currentUrl").val();
    $.ajax({
        url: "/rc/search/un-favor",
        dataType: 'json',
        data: {redirect:currentUrl, obj_name: obj_name, id: id},
        success: function (data) {
            if (data.ret == 13400) {
                $('#' + obj_name).removeAttr("onclick");
                $('#' + obj_name).html("<i class='icon-24 icon-24-hart'></i> 加关注");
                $('#' + obj_name).attr("onclick", "favor('" + obj_name + "','" + id + "')");
                $('#focus_num').html(data.focus_num);
            }else if(data.ret===13381||data.ret===13382){
                window.location.href="http://account.vsochina.com/user/login";
            } else {
                alert(data.message);
            }
        }});
}
function dxtender(obj_name)
{
    var currentUrl=$("#currentUrl").val();
    $.ajax({
        url: "/rc/search/dxtender",
        dataType: 'json',
        data:{redirect:currentUrl},
        success: function (res) {
            if ("1"===res.data.auth_status) {
                window.open("http://www.vsochina.com/index.php?do=task_dxtender&bid_username=" + obj_name);
            } else
            {
                alert('您未通过企业认证，请认证通过后再发布雇佣项目！');
            }
        },
    });
}