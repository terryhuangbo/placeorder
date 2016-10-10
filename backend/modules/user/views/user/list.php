<?php
use yii\helpers\Html;
use common\models\User;
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>用户信息列表</title>
    <link href="/css/dpl.css" rel="stylesheet">
    <link href="/css/bui.css" rel="stylesheet">
    <link href="/css/page-min.css" rel="stylesheet">
    <script src="/js/jquery.js" type="text/javascript"></script>
    <script src="/js/bui-min.js" type="text/javascript"></script>
    <script src="/js/page-min.js" type="text/javascript"></script>
    <script src="/js/common.js" type="text/javascript"></script>
    <script src="/js/tools.js" type="text/javascript"></script>
    <style>
        .user_avatar {
            width: 120px;
            height: 80px;
            margin: 10px auto;
        }
    </style>
    <script>
        _BASE_LIST_URL =  "<?php echo yiiUrl('user/user/list?ajax=1') ?>";
    </script>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="search-bar form-horizontal well">
            <form id="usersearch" class="form-horizontal">
                <div class="row">
                    <div class="control-group span12">
                        <label class="control-label">姓名：</label>
                        <div class="controls" data-type="city">
                            <input type="text" class="control-text" name="name" id="name">
                        </div>
                    </div>
                    <div class="control-group span10">
                        <label class="control-label">手机号：</label>
                        <div class="controls" data-type="city">
                            <input type="text" class="control-text" name="mobile" id="name">
                        </div>
                    </div>
                    <div class="control-group span10">
                        <label class="control-label">用户类型：</label>
                        <div class="controls" >
                            <select name="user_type" id="grouptype">
                                <option value="">请选择</option>
                                <?php foreach (User::_get_user_type_list() as $key => $name): ?>
                                    <option value="<?php echo $key ?>"><?php echo $name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="control-group span10">
                        <label class="control-label">用户状态：</label>
                        <div class="controls" >
                            <select name="user_status" id="checkstatus">
                                <option value="">请选择</option>
                                <?php foreach (User::_get_user_status_list() as $key => $name): ?>
                                    <option value="<?php echo $key ?>"><?php echo  $name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group span16">
                        <label class="control-label">时间范围：</label>
                        <div class="controls">
                            <input type="text" class="calendar calendar-time" name="uptimeStart"><span> - </span><input name="uptimeEnd" type="text" class="calendar calendar-time">
                        </div>
                    </div>

                    <div class="control-group span10">
                        <button type="button" id="btnSearch" class="button button-primary"  onclick="searchUsers()">查询</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="bui-grid-tbar">
        </div>
        <div id="users_grid">
        </div>
    </div>
</div>

<div id="reason_content" style="display: none" >
    <form id="reason_form" class="form-horizontal">
        <div class="control-group" >
            <div class="control-group" style="height: 80px">
                <label class="control-label"></label>
                <div class="controls ">
                    <textarea class="input-large" id="reason_text" style="height: 60px" data-rules="{required : true}" type="text"></textarea>
                </div>
            </div>
            <div class="control-group style="">
            <label class="control-label"></label>
            <div class="controls">
                <span><b>提示：</b>输入字数不能超过50个字</span>
            </div>
        </div>
    </form>
</div>

<script>
    $(function () {
        BUI.use('common/page');
        BUI.use('bui/form', function (Form) {
            var form = new Form.HForm({
                srcNode: '#usersearch'
            });
            form.render();
        });
        BUI.use('bui/calendar', function (Calendar) {
            var datepicker = new Calendar.DatePicker({
                trigger: '.calendar-time',
                showTime: true,
                autoRender: true
            });
        });
        //设置表格属性
        BUI.use(['bui/grid', 'bui/data'], function (Grid, Data) {
            var Grid = Grid;
            var store = new Data.Store({
                url: _BASE_LIST_URL,
                proxy: {//设置请求相关的参数
                    method: 'post',
                    dataType: 'json', //返回数据的类型
                    limitParam: 'pageSize', //一页多少条记录
                    pageIndexParam: 'page' //页码
                },
                autoLoad: true, //自动加载数据
                params: {
                },
                root: 'userList',//数据返回字段,支持深成次属性root : 'data.records',
                totalProperty: 'totalCount',//总计字段
                pageSize: 10// 配置分页数目,
            });
            var grid = new Grid.Grid({
                render: '#users_grid',
                idField: 'id', //自定义选项 id 字段
                selectedEvent: 'click',
                columns: [
                    {title: '用户编号', dataIndex: 'uid', width: 80, elCls : 'center'},
                    {title: '微信昵称', dataIndex: 'nick', width: 90, elCls : 'center',},
                    {title: '真实姓名', dataIndex: 'name', width: 90, elCls : 'center',},
                    {
                        title: '微信头像',
                        width: 140,
                        elCls : 'center',
                        renderer: function (v, obj) {
                            return "<img class='user_avatar' src='"+ obj.avatar +"'>";
                        }
                    },
                    {
                        title: '名片',
                        width: 140,
                        elCls : 'center',
                        renderer: function (v, obj) {
                            return "<img class='user_avatar name_card'  onclick='viewNameCard(this)' src='"+ obj.name_card +"'>";
                        }
                    },
                    {title: '手机号码', dataIndex: 'mobile', width: 90},
                    {title: '电子邮箱', dataIndex: 'email', width: 130},
                    {title: '积分', dataIndex: 'points', width: 80, elCls : 'center'},
                    {title: '微信公众号', dataIndex: 'wechat', width: 120},
                    {title: '用户类型', dataIndex: 'user_type', width: 80, elCls : 'center'},
                    {title: '用户状态', dataIndex: 'user_status', width: 80, elCls : 'center'},
                    {title: '更新时间', dataIndex: 'update_at', width: 150, elCls : 'center'},
                    {
                        title: '操作',
                        width: 300,
                        renderer: function (v, obj) {
                            if(parseInt(obj.status) == <?php echo User::NO_DELETE ?>){
                                return "<a class='button button-success' title='用户信息' href='javascript:void(0);' onclick='showUserInfo(" + obj.uid + ")'>查看</a>" +
                                " <a class='button button-primary' onclick='updateUser(" + obj.uid + ")'>编辑</a>"+
                                " <a class='button button-danger' onclick='disableUser(" + obj.uid + ")'>禁用</a>";
                            }else if(parseInt(obj.status) == <?php echo User::IS_DELETE ?>){
                                return "<a class='button button-success' title='用户信息' href='javascript:void(0);' onclick='showUserInfo(" + obj.uid + ")'>查看</a>" +
                                " <a class='button button-info' onclick='updateUser(" + obj.uid + ")'>编辑</a>"+
                                " <a class='button button-primary' onclick='enableUser(" + obj.uid + ")'>启用</a>";
                            }

                        }
                    }
                ],
                loadMask: true, //加载数据时显示屏蔽层
                store: store,
                // 底部工具栏
                bbar: {
                    // pagingBar:表明包含分页栏
                    pagingBar: true
                },
                plugins: Grid.Plugins.CheckSelection,// 插件形式引入多选表格
            });
            grid.render();
            $("#users_grid").data("BGrid", grid);

        });

    });
</script>

<script>


/**
 * 搜索用户,刷新列表
 */
function searchUsers() {
    var search = {};
    var fields = $("#usersearch").serializeArray();//获取表单信息
    jQuery.each(fields, function (i, field) {
        if (field.value != "") {
            search[field.name] = field.value;
        }
    });
    var store = $("#users_grid").data("BGrid").get('store');
    var lastParams = store.get("lastParams");
    lastParams.search = search;
    store.load(lastParams);//刷新
}
/**
 * 获取过滤项
 */
function getUserGridSearchConditions() {
    var search = {};
    var upusername = $("#upusername").val();
    if (upusername != "") {
        search.upusername = upusername;
    }
    var username = $("#username").val();
    if (username != "") {
        search.username = username;
    }
    return search;
}


/**
 * 显示用户详情
 */
function showUserInfo(uid) {
    var width = 700;
    var height = 450;
    var Overlay = BUI.Overlay;
    var buttons = [];
    buttons = [
        {
            text:'确认',
            elCls : 'button button-primary',
            handler : function(){
                this.close();
            }
        },
//        {
//            text:'修改',
//            elCls : 'button button-primary',
//            handler : function(){
//                window.location.href = '/user/user/update/?mid=' + id;
//            }
//        }
    ];
    dialog = new Overlay.Dialog({
        title: '用户信息',
        width: width,
        height: height,
        closeAction: 'destroy',
        loader: {
            url: "/user/user/info",
            autoLoad: true, //不自动加载
            params: {uid: uid},//附加的参数
            lazyLoad: false, //不延迟加载
        },
        buttons: buttons,
        mask: false
    });
    dialog.show();
    dialog.get('loader').load({uid: uid});
}

/**
 * 更改用户详情
 */
function updateUser(uid) {
    var width = 400;
    var height = 300;
    var Overlay = BUI.Overlay;
    var buttons = [];
    dialog = new Overlay.Dialog({
        title: '用户信息',
        width: width,
        height: height,
        closeAction: 'destroy',
        loader: {
            url: "/user/user/update",
            autoLoad: true, //不自动加载
            params: {uid: uid},//附加的参数
            lazyLoad: false, //不延迟加载
        },
        buttons: buttons,
        mask: false
    });
    dialog.show();
    dialog.get('loader').load({uid: uid});
}



/**
 * 启用用户
 */
function enableUser(uid) {
    var msg = '您确定要启用此用户？';
    BUI.Message.Confirm(msg, function(){
        var param = param || {};
        param.uid = uid;
        param.status = 1;
        $._ajax('<?php echo yiiUrl('user/user/ajax-change-status') ?>', param, 'POST','JSON', function(json){
            if(json.code > 0){
                BUI.Message.Alert(json.msg, function(){
                    window.location.href = '<?php echo yiiUrl('user/user/list') ?>';
                }, 'success');

            }else{
                BUI.Message.Alert(json.msg, 'error');
                this.close();
            }
        });
    }, 'success');

}

/**
 * 启用用户
 */
function disableUser(uid) {
    var msg = '您确定要禁用此用户？';
    BUI.Message.Confirm(msg, function(){
        var param = param || {};
        param.uid = uid;
        param.status = 2;
        $._ajax('<?php echo yiiUrl('user/user/ajax-change-status') ?>', param, 'POST','JSON', function(json){
            if(json.code > 0){
                BUI.Message.Alert(json.msg, function(){
                    window.location.href = '<?php echo yiiUrl('user/user/list') ?>';
                },  'success');
            }else{
                BUI.Message.Alert(json.msg, 'error');
                this.close();
            }
        });
    }, 'error');

}

/**
 * 查看名片
 */
function viewNameCard(dom){
    var src = $(dom).attr('src');
    BUI.use('bui/overlay',function(Overlay){
        var dialog = new Overlay.Dialog({
            title:'名片',
            width:600,
            height:500,
            closeAction: 'destroy',
            buttons: [
                {
                    text:'确认',
                    elCls : 'button button-primary',
                    handler : function(){
                        this.close();
                    }
                },
            ],
            //配置文本
            bodyContent:'<div style="text-align: center"><img style="width: 560px; height:400px;" src="'+ src +'"></div>',
            success:function () {
                this.close();
            }
        });
        dialog.show();
    });
}

</script>

</body>
</html>