<?php
use yii\helpers\Html;
use common\models\Auth;
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>用户审核信息列表</title>
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
        _BASE_LIST_URL =  "<?php echo yiiUrl('auth/auth/list') ?>";
    </script>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="search-bar form-horizontal well">
            <form id="authsearch" class="form-horizontal">
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
                        <label class="control-label">审核状态：</label>
                        <div class="controls" >
                            <select name="auth_status" id="checkstatus">
                                <option value="">请选择</option>
                                <?php foreach (Auth::_get_auth_type_list() as $key => $name): ?>
                                    <option value="<?php echo $key ?>" <?php echo $key == Auth::CHECK_WAITING ? 'selected="selected"' : '' ?>><?php echo $name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="control-group span16">
                        <label class="control-label">时间范围：</label>
                        <div class="controls">
                            <input type="text" class="calendar calendar-time" name="uptimeStart"><span> - </span><input name="uptimeEnd" type="text" class="calendar calendar-time">
                        </div>
                    </div>

                    <div class="control-group span10">
                        <button type="button" id="btnSearch" class="button button-primary"  onclick="searchAuth()">查询</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="bui-grid-tbar">
        </div>
        <div id="auths_grid">
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
                <span><b>提示：</b>输入字数不能超过<?php echo yiiParams('checkdeny_reason_limit') ?>个字</span>
            </div>
        </div>
    </form>
</div>

<script>
    $(function () {
        BUI.use('common/page');
        BUI.use('bui/form', function (Form) {
            var form = new Form.HForm({
                srcNode: '#authsearch'
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
                render: '#auths_grid',
                idField: 'id', //自定义选项 id 字段
                selectedEvent: 'click',
                columns: [
                    {title: '用户编号', dataIndex: 'auth_id', width: 80, elCls : 'center'},
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
                    {title: '微信公众号', dataIndex: 'wechat', width: 120},
                    {title: '用户类型', dataIndex: 'user_type', width: 80, elCls : 'center'},
                    {title: '审核状态', dataIndex: 'status_name', width: 80, elCls : 'center'},
                    {title: '更新时间', dataIndex: 'update_at', width: 150, elCls : 'center'},
                    {
                        title: '审核',
                        width: 300,
                        renderer: function (v, obj) {
                            if(obj.auth_status == 1){
                                return "<a class='button button-primary' title='用户信息' href='javascript:void(0);' onclick='showCheckInfo(" + obj.auth_id + ")'>编辑</a>" +
                                " <a class='button button-primary' onclick='checkPass(" + obj.auth_id + ")'>通过</a>"+
                                " <a class='button button-danger' onclick='checkUnPass(" + obj.auth_id + ")'>不通过</a>";
                            }else if(obj.auth_status == 2){
                                return "<a class='button button-info' title='用户信息' href='javascript:void(0);' onclick='showCheckInfo(" + obj.auth_id + ")'>查看</a>" +
                                " <a class='button button-success' >已审核</a>";
                            }else if(obj.auth_status == 3){
                                return "<a class='button button-primary' title='用户信息' href='javascript:void(0);' onclick='showCheckInfo(" + obj.auth_id + ")'>编辑</a>" +
                                " <a class='button button-primary' onclick='checkPass(" + obj.auth_id + ")'>通过</a>";
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
            $("#auths_grid").data("BGrid", grid);

        });

    });
</script>

<script>

/**
 * 搜索用户,刷新列表
 */
function searchAuth() {
    var search = {};
    var fields = $("#authsearch").serializeArray();//获取表单信息
    jQuery.each(fields, function (i, field) {
        if (field.value != "") {
            search[field.name] = field.value;
        }
    });
    var store = $("#auths_grid").data("BGrid").get('store');
    var lastParams = store.get("lastParams");
    lastParams.search = search;
    store.load(lastParams);//刷新
}
/**
 * 获取过滤项
 */
function getAuthGridSearchConditions() {
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
function showCheckInfo(auth_id) {
    var width = 700;
    var height = 500;
    var Overlay = BUI.Overlay;
    var buttons = [
        {
            text:'确认',
            elCls : 'button button-primary',
            handler : function(){
                window.location.href = '/auth/auth/list';
                this.close();
            }
        },
    ];
    dialog = new Overlay.Dialog({
        title: '用户信息',
        width: width,
        height: height,
        closeAction: 'destroy',
        loader: {
            url: "/auth/auth/info",
            autoLoad: true, //不自动加载
            params: {auth_id: auth_id},//附加的参数
            lazyLoad: false, //不延迟加载
        },
        buttons: buttons,
        mask: false
    });
    dialog.show();
    dialog.get('loader').load({auth_id: auth_id});
}


/**
 * 审核通过
 */
function checkPass(auth_id) {
    var param = param || {};
    param.auth_id = auth_id;
    param.auth_status = 2;
    $._ajax('<?php echo yiiUrl('auth/auth/ajax-check') ?>', param, 'POST','JSON', function(json){
        if(json.code > 0){
            BUI.Message.Alert(json.msg, function(){
                window.location.href = '<?php echo yiiUrl('auth/auth/list') ?>';
            }, 'success');

        }else{
            BUI.Message.Alert(json.msg, 'error');
            this.close();
        }
    });

}

/**
 * 审核不通过
 */
function checkUnPass(auth_id) {
    var Overlay = BUI.Overlay;
    var dialog_reason = new Overlay.Dialog({
        title:'请填写审核不通过的原因',
        width:380,
        height:210,
        closeAction: 'destroy',
        contentId:'reason_content',
        buttons: [
            {
                text: '保存',
                elCls: 'button button-primary',
                handler: function () {
                    var param = {};
                    var dom = $("#reason_text");
                    var reason = $.trim(dom.val());
                    if(reason == '' || reason == undefined){
                        BUI.Message.Alert('原因不能为空', 'error');
                        return;
                    }
                    if($._str_len(reason) > 100){
                        BUI.Message.Alert('您的输入超过最大限制字数', 'error');
                        return;
                    }
                    param.reason = reason;
                    param.auth_id = auth_id;
                    param.auth_status = 3;
                    $._ajax('<?php echo yiiUrl('auth/auth/ajax-check') ?>', param, 'POST','JSON', function(json){
                        if(json.code > 0){
                            BUI.Message.Alert(json.msg, 'success');
                            window.location.href = '<?php echo yiiUrl('auth/auth/list') ?>';
                            dom._clear_form();
                            this.close();
                        }else{
                            BUI.Message.Alert(json.msg, 'error');
                            this.close();
                        }
                    });
                }
            },
            {
                text: '取消',
                elCls: 'button button-danger',
                handler: function () {
                    window.location.href = '<?php echo yiiUrl('auth/auth/list') ?>';
                    this.close();
                }
            }
        ],
    });
    dialog_reason.show();
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