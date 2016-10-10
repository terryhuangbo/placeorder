<?php
use yii\helpers\Html;
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>积分类型列表</title>
    <link href="/css/dpl.css" rel="stylesheet">
    <link href="/css/bui.css" rel="stylesheet">
    <link href="/css/page-min.css" rel="stylesheet">
    <script src="/js/jquery.js" type="text/javascript"></script>
    <script src="/js/bui-min.js" type="text/javascript"></script>
    <script src="/js/page-min.js" type="text/javascript"></script>
    <script src="/js/common.js" type="text/javascript"></script>
    <script src="/js/tools.js" type="text/javascript"></script>
    <script>
        var _ACTMARK="list";
        var _BASE_LIST_URL = "<?php echo yiiUrl('points/config/list') ?>";
    </script>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="search-bar form-horizontal well">
        </div>

        <div class="bui-grid-tbar">
            <a class="button button-primary" title="添加积分类型"  href="#" onclick="addConfig()" id="addVip1">添加积分类型</a>
        </div>

        <div class="bui-grid-tbar">
        </div>

        <div id="config_grid">
        </div>

        <div id="config_grid">
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
</div>


<script>
    $(function () {
        BUI.use('common/page');
        BUI.use('bui/form', function (Form) {
            var form = new Form.HForm({
                srcNode: '#vipsearch'
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
                root: 'configList',//数据返回字段,支持深成次属性root : 'data.records',
                totalProperty: 'totalCount',//总计字段
                pageSize: 10// 配置分页数目,
            });
            var grid = new Grid.Grid({
                render: '#config_grid',
                idField: 'id', //自定义选项 id 字段
                selectedEvent: 'click',
                columns: [
                    {title: '编号', dataIndex: 'id', width: 150, elCls : 'center'},
                    {title: '名称', dataIndex: 'name', width: 300, elCls : 'center'},
                    {
                        title: '操作',
                        width: 400,
                        renderer: function (v, obj) {
                            if(obj.delete == 1){
                                return " <a class='button button-primary' onclick='updateConfig(" + obj.id + ")'>编辑</a>"+
                                " <a class='button button-danger' onclick='deleteConfig(" + obj.id + ")'>删除</a>";
                            }else{
                                return " <a class='button button-primary' onclick='updateConfig(" + obj.id + ")'>编辑</a>";
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
                plugins: [ Grid.Plugins.CheckSelection] // 插件形式引入多选表格
            });
            grid.render();
            $("#config_grid").data("BGrid", grid);
        });
    });
</script>

<script>


/**
 * 添加积分类型
 */
function addConfig(id){
    var width = 400;
    var height = 200;
    var Overlay = BUI.Overlay;
    var buttons = [];
    dialog = new Overlay.Dialog({
        title: '积分类型信息',
        width: width,
        height: height,
        closeAction: 'destroy',
        loader: {
            url: "/points/config/add",
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
 * 更新积分类型
 */
function updateConfig(id){
    var width = 400;
    var height = 200;
    var Overlay = BUI.Overlay;
    var buttons = [];
    dialog = new Overlay.Dialog({
        title: '积分类型信息',
        width: width,
        height: height,
        closeAction: 'destroy',
        loader: {
            url: "/points/config/update",
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
 * 更新积分类型
 */
function deleteConfig(configId){
    //如果不传，表示删除勾选
    var configIds = [];
    if (configId) {
        configIds.push(configId);
    }
    else {
        configIds = $("#config_grid").data("BGrid").getSelectionValues();
    }
    if (configIds.length == 0) {
        return;
    }

    BUI.Message.Confirm('您确定要删除的积分类型吗？', function(){
        doDeleteConfigs(configIds);
    }, 'question');

}

/**
 * 删除会员
 */
function doDeleteConfigs(configIds) {
    $._ajax('/points/config/delete', {ids: configIds}, 'POST', 'JSON', function(json){
        if(json.code > 0){
            BUI.Message.Alert(json.msg, function(){
                window.location.href = '<?php echo yiiUrl('points/config/list') ?>';
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