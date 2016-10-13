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
                    <div class="control-group span13">
                        <label class="control-label">用户账号：</label>
                        <div class="controls" data-type="city">
                            <input type="text" class="control-text" name="username" id="username">
                        </div>
                    </div>
                    <div class="control-group span13">
                        <label class="control-label">QQ：</label>
                        <div class="controls" data-type="city">
                            <input type="text" class="control-text" name="qq" id="qq">
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="control-group span13">
                        <label class="control-label">注册时间：</label>
                        <div class="controls">
                            <input type="text" class="calendar calendar-time" name="regtimeStart"><span> - </span><input name="regtimeEnd" type="text" class="calendar calendar-time">
                        </div>
                    </div>
                    <div class="control-group span13">
                        <label class="control-label">最近登录：</label>
                        <div class="controls">
                            <input type="text" class="calendar calendar-time" name="logtimeStart"><span> - </span><input name="logtimeEnd" type="text" class="calendar calendar-time">
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
                    {title: '编号', dataIndex: 'uid', width: 80, elCls : 'center'},
                    {title: '用户账号', dataIndex: 'username', width: 90, elCls : 'center'},
                    {title: 'QQ', dataIndex: 'qq', width: 90},
                    {title: '账户余额', dataIndex: 'points', width: 80, elCls : 'center'},
                    {title: '注册时间', dataIndex: 'reg_time', width: 150, elCls : 'center'},
                    {title: '最近登录', dataIndex: 'login_time', width: 150, elCls : 'center'},
                    {
                        title: '操作',
                        width: 300,
                        renderer: function (v, obj) {
                            return "<a class='button button-success' title='用户信息' href='javascript:void(0);' onclick='showUserInfo(" + obj.uid + ")'>查看</a>";

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
    var width = 400;
    var height = 350;
    var Overlay = BUI.Overlay;
    var buttons = [
        {
            text:'确认',
            elCls : 'button button-primary',
            handler : function(){
                this.close();
            }
        }
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
            lazyLoad: false //不延迟加载
        },
        buttons: buttons,
        mask: false
    });
    dialog.show();
    dialog.get('loader').load({uid: uid});
}

</script>

</body>
</html>