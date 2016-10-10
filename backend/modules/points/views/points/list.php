<?php
use yii\helpers\Html;
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>积分数值列表</title>
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
            height: auto;
            width: 80px;
            margin: 10px auto;
        }
    </style>
    <script>
        _BASE_LIST_URL =  "<?php echo yiiUrl('points/points/list') ?>";
    </script>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="search-bar form-horizontal well">

        </div>
        <div class="bui-grid-tbar">
            <a class="button button-primary" title="添加积分对象"  href="#" onclick="addPoints()" id="addVip1">添加积分对象</a>
        </div>
        <div class="bui-grid-tbar">
        </div>
        <div id="points_grid">
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
                root: 'pointList',//数据返回字段,支持深成次属性root : 'data.records',
                totalProperty: 'totalCount',//总计字段
                pageSize: 10// 配置分页数目,
            });
            var grid = new Grid.Grid({
                render: '#points_grid',
                idField: 'id', //自定义选项 id 字段
                selectedEvent: 'click',
                columns: [
                    {title: '积分编号', dataIndex: 'pid', width: 80, elCls : 'center'},
                    {title: '积分名称', dataIndex: 'name', width: 90, elCls : 'center'},
                    {title: '积分数量', dataIndex: 'points', width: 90, elCls : 'center'},
                    {title: '商品编号', dataIndex: 'goods_id', width: 130, elCls : 'center'},
                    {title: '商品名称', dataIndex: 'goods_name', width: 130, elCls : 'center'},
                    {title: '更新时间', dataIndex: 'update_at', width: 150, elCls : 'center'},
                    {
                        title: '操作',
                        width: 300,
                        renderer: function (v, obj) {
                            return " <a class='button button-primary' onclick='updatePoints(" + obj.pid + ")'>编辑</a>"+
                            " <a class='button button-danger' onclick='deletePoints(" + obj.pid + ")'>删除</a>";
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
                plugins: [ Grid.Plugins.CheckSelection] // 插件形式引入多选表格
            });
            grid.render();
            $("#points_grid").data("BGrid", grid);

        });

    });
</script>

<script>
/**
 * 搜索用户,刷新列表
 */
function searchPoints() {
    var search = {};
    var fields = $("#usersearch").serializeArray();//获取表单信息
    jQuery.each(fields, function (i, field) {
        if (field.value != "") {
            search[field.name] = field.value;
        }
    });
    var store = $("#points_grid").data("BGrid").get('store');
    var lastParams = store.get("lastParams");
    lastParams.search = search;
    store.load(lastParams);//刷新
}
/**
 * 获取过滤项
 */
function getPointGridSearchConditions() {
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
 * 显示积分数值
 */
function showPointInfo(pid) {
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
        title: '积分数值',
        width: width,
        height: height,
        closeAction: 'destroy',
        loader: {
            url: "/user/user/info",
            autoLoad: true, //不自动加载
            params: {pid: pid},//附加的参数
            lazyLoad: false, //不延迟加载
        },
        buttons: buttons,
        mask: false
    });
    dialog.show();
    dialog.get('loader').load({pid: pid});
}

/**
 * 添加积分数值
 */
function addPoints(id){
    var width = 400;
    var height = 400;
    var Overlay = BUI.Overlay;
    var buttons = [];
    dialog = new Overlay.Dialog({
        title: '积分数值信息',
        width: width,
        height: height,
        closeAction: 'destroy',
        loader: {
            url: "/points/points/add",
            autoLoad: true, //不自动加载
            params: {id: id},//附加的参数
            lazyLoad: false, //不延迟加载
        },
        buttons: buttons,
        mask: false
    });
    dialog.show();
    dialog.get('loader').load({id: id});

}

/**
 * 显示积分数值
 */
function updatePoints(pid) {
    var width = 400;
    var height = 400;
    var Overlay = BUI.Overlay;
    var buttons = [];
    dialog = new Overlay.Dialog({
        title: '积分数值',
        width: width,
        height: height,
        closeAction: 'destroy',
        loader: {
            url: "/points/points/update",
            autoLoad: true, //不自动加载
            params: {pid: pid},//附加的参数
            lazyLoad: false, //不延迟加载
        },
        buttons: buttons,
        mask: false
    });
    dialog.show();
    dialog.get('loader').load({pid: pid});
}


/**
 * 更新积分类型
 */
function deletePoints(pointId){
    //如果不传，表示删除勾选
    var pointIds = [];
    if (pointId) {
        pointIds.push(pointId);
    }
    else {
        pointIds = $("#points_grid").data("BGrid").getSelectionValues();
    }
    if (pointIds.length == 0) {
        return;
    }

    BUI.Message.Confirm('您确定要删除的积分类型吗？', function(){
        doDeletePoints(pointIds);
    }, 'question');

}

/**
 * 删除会员
 */
function doDeletePoints(pointIds) {
    $._ajax('/points/points/delete', {ids: pointIds}, 'POST', 'JSON', function(json){
        if(json.code > 0){
            BUI.Message.Alert(json.msg, function(){
                window.location.href = '<?php echo yiiUrl('points/points/list') ?>';
            }, 'success');

        }else{
            BUI.Message.Alert(json.msg, 'error');
            this.close();
        }
    });
}




</script>

</body>
</html>