<?php
use yii\helpers\Html;
use common\models\Order;
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>订单列表</title>
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
        _BASE_LIST_URL =  "<?php echo yiiUrl('pay/pay/list') ?>";
    </script>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="search-bar form-horizontal well">
            <form id="authsearch" class="form-horizontal">

                <div class="row">
                    <div class="control-group span8">
                        <label class="control-label">商品名称：</label>
                        <div class="controls">
                            <input type="text" class="control-text" name="goods_name">
                        </div>
                    </div>
                    <div class="control-group span8">
                        <label class="control-label">商品编号：</label>
                        <div class="controls">
                            <input type="text" class="control-text" name="goods_id">
                        </div>
                    </div>
                    <div class="control-group span8">
                        <label class="control-label">订单状态：</label>
                        <div class="controls" >
                            <select name="pay_status" id="checkstatus">
                                <option value="">请选择</option>
                                <?php foreach (Order::getOrderStatus() as $key => $name): ?>
                                    <option value="<?php echo $key ?>"><?php echo  $name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="control-group span18">
                        <label class="control-label">时间范围：</label>
                        <div class="controls">
                            <input type="text" class="calendar calendar-time" name="uptimeStart"><span> - </span><input name="uptimeEnd" type="text" class="calendar calendar-time">
                        </div>
                    </div>
                    <div class="row">
                        <div class="control-group span10">
                            <button type="button" id="btnSearch" class="button button-primary"  onclick="searchOrder()">查询</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="bui-grid-tbar">
        </div>
        <div id="pay_grid">
        </div>
    </div>
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
                root: 'payList',//数据返回字段,支持深成次属性root : 'data.records',
                totalProperty: 'totalCount',//总计字段
                pageSize: 10// 配置分页数目,
            });
            var grid = new Grid.Grid({
                render: '#pay_grid',
                idField: 'id', //自定义选项 id 字段
                selectedEvent: 'click',
                columns: [
                    {title: '序号', dataIndex: 'oid', width: 80, elCls : 'center'},
                    {title: '订单编号', dataIndex: 'order_bn', width: 200, elCls : 'center'},
                    {title: '买家账号', dataIndex: 'username', width: 120, elCls : 'center'},
                    {title: '商品编号', dataIndex: 'goods_bn', width: 120, elCls : 'center'},
                    {title: '商品名称', dataIndex: 'goods_name', width: 90, elCls : 'center',},
                    {title: '消费金额', dataIndex: 'cost', width: 90, elCls : 'center',},
                    {title: '账户余额', dataIndex: 'balance', width: 90, elCls : 'center',},
                    {title: '创建时间', dataIndex: 'create_time', width: 150, elCls : 'center'},
                    {
                        title: '操作',
                        width: 300,
                        renderer: function (v, obj) {
                            return "<a class='button button-success' onclick='showOrderInfo(" + obj.oid + ")'>查看</a>";
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
            $("#pay_grid").data("BGrid", grid);

        });

    });
</script>

<script>
/**
 * 搜索订单,刷新列表
 */
function searchOrder() {
    var search = {};
    var fields = $("#authsearch").serializeArray();//获取表单信息
    jQuery.each(fields, function (i, field) {
        if (field.value != "") {
            search[field.name] = field.value;
        }
    });
    var store = $("#pay_grid").data("BGrid").get('store');
    var lastParams = store.get("lastParams");
    lastParams.search = search;
    store.load(lastParams);//刷新
}
/**
 * 获取过滤项
 */
function getOrderGridSearchConditions() {
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
 * 显示订单详情
 */
function showOrderInfo(oid) {
    var width = 500;
    var height = 500;
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
        title: '订单信息',
        width: width,
        height: height,
        closeAction: 'destroy',
        loader: {
            url: "/pay/pay/info",
            autoLoad: true, //不自动加载
            params: {oid: oid},//附加的参数
            lazyLoad: false //不延迟加载
        },
        buttons: buttons,
        mask: false
    });
    dialog.show();
    dialog.get('loader').load({oid: oid});
}


/**
 * 更改订单详情
 */
function updateOrder(oid) {
    var width = 400;
    var height = 300;
    var Overlay = BUI.Overlay;
    var buttons = [];
    dialog = new Overlay.Dialog({
        title: '订单信息',
        width: width,
        height: height,
        closeAction: 'destroy',
        loader: {
            url: "/pay/pay/update",
            autoLoad: true, //不自动加载
            params: {oid: oid},//附加的参数
            lazyLoad: false, //不延迟加载
        },
        buttons: buttons,
        mask: false
    });
    dialog.show();
    dialog.get('loader').load({oid: oid});
}

/**
 *删除
 */
function del(oid) {
    BUI.Message.Confirm('您确定要删除？', function(){
        var param = param || {};
        param.oid = oid;
        $._ajax('<?php echo yiiUrl('pay/pay/ajax-delete') ?>', param, 'POST','JSON', function(json){
            if(json.code > 0){
                BUI.Message.Alert(json.msg, function(){
                    window.location.href = '<?php echo yiiUrl('pay/pay/list') ?>';
                }, 'success');
            }else{
                BUI.Message.Alert(json.msg, 'error');
                this.close();
            }
        });
    }, 'question');
}

</script>

</body>
</html>