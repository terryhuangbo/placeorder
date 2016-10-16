<!DOCTYPE html>
<!-- saved from url=(0061)http://www.xdzk.net/index.php?m=Home&c=Goods&a=detail&id=1260 -->
<html lang="zh-cn"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>手工人气</title>
<link href="/static/css/bootstrap.min.css" rel="stylesheet">
<link href="/static/css/bootstrap-theme.min.css" rel="stylesheet">
<link href="/static/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="/static/css/jquery.dtGrid.min.css">
<link rel="stylesheet" href="/static/css/jwxh.css">
<script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/jquery.dtGrid.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/zh-cn.js" type="text/javascript" charset="utf-8"></script>
<style>
    .navbar-fixed-top, .navbar-fixed-bottom {
        z-index: 0;
    }
    .login_page,body{
        background-image:url(http://all-pt.upyun.cdn.95jw.cn/Uploads/image/2016-04-18/5714fd44b97e1.jpg);
        background-repeat:repeat
    }
    .menu,footer{
        background-color:#40cfe8
    }
    #login h2,.vertical-center .panel-title{
        background-color:#19d8eb
    }
    .btn{background-color:#2dd9ae!important
    }
    .div_url{
        padding-right:12px;
        padding-left:12px;
        max-width:165px
    }
    .thumbnail a{
        height:180px
    }
    .alert-danger{
        color:#007e94;
        background-color:#b4eef8;
        border-color:#40d0e8;
        background-image:none
    }
    .login_page,body {
        background-image: url("http://all-pt.upyun.cdn.95jw.cn/Uploads/image/2016-03-11/56e29f86ac53d.jpg");
        background-attachment: fixed;
    }
    .menu,footer {
        background-color: #0f0d0d;
    }
    #login h2,.vertical-center .panel-title {
        background-color: #070505;
    }
    .btn{
        background-color: #2ecc76 !important;
    }
    .div_url {
        padding-right: 6px !important;
        padding-left: 6px !important;
        max-width:300px !important;
    }
</style>
</head>
<body>

<!--顶部-->
<header>
	<div class="container-fluid menu">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-6"><a href="http://www.xdzk.net/index.php?m=Home&amp;c=Index&amp;a=index"><h2>手工人气</h2></a></div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 text-right">
					<div class="top_nav">
						<a href="http://www.xdzk.net/index.php?m=Home&amp;c=Index&amp;a=index" class="hidden-xs">切换到首页</a> <span class="hidden-xs">|</span> <a class="exit_login_a" href="http://www.xdzk.net/index.php?m=Home&amp;c=Card&amp;a=logout&amp;id=1260&amp;goods_type=135">退出登录</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>

<div class="container">
   <div class="row">
      <div class="col-md-12 banner">
																																																			<p>
	<span style="color:#E53333;font-size:24px;"><strong>手工人气每天中午12点和晚上12点开刷 急单不要下</strong></span>
</p>
<p>
	<span style="font-size:24px;color:#E53333;"><span style="font-size:24px;color:#E53333;"><b>下单的Q空间有说说即可 &nbsp;下单前空间必须设置允许任何人可访问</b></span></span>
</p>                                                                                                                                                                        	  </div>
   </div>
</div>

<!--内容-->
<div class="container jwxh_main_div">
	<div class="row">
		<!--用户信息/卡信息-->
		<div class="col-md-4">
		<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">
						用户信息
					</h2>
				</div>
				<div class="panel-body">
					<ul class="card_info" ajax_href="/index.php?m=Home&amp;c=Card&amp;a=cardinfo&amp;id=1260&amp;goods_type=135">
						<li><span>用户帐号：</span><span class="user_name"><?php echo $user['username'] ?></span>　<a style="color:red;" href="javascript:void(0);" class="kmzh_gaimi">改密</a></li>
						<li><span>类型余额：</span><span class="card_kye"><?php echo $user['points'] ?></span>点</li>
						<li><span>当前类型：</span><span class="user_goods_type_title"><?php echo getValue($goods, 'name', '') ?></span></li>
						<li><span>最后登录：</span><span class="user_last_login"><?php echo $user['login_time'] ?></span></li>
					</ul>
				</div>
			</div>
        </div>

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">
						下单区
					</h2>
				</div>
				<div class="panel-body">
					<form role="form" method="post" class="order_post_form" onsubmit="return false;">
						<ul>
                            <li><span class="fixed-width-right-80">QQ号码：</span><input name="qq" type="text" placeholder="请输入QQ号码"></li>
                            <li><span class="fixed-width-right-80">下单数量：</span><input name="num" type="text" placeholder="范围1000-10000000之间"></li>
                            <input type="hidden" name="gid" value="<?php echo getValue($goods, 'gid', 0) ?>">
                            <li><span class="fixed-width-right-80">&nbsp;</span><button class="btn order_post_btn">确定下单手工人气</button></li>

                        </ul>
					</form>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">
						卡密充值
					</h2>
				</div>
				<div class="panel-body">
					<form role="form" method="post" class="card_chongzhi_form" onsubmit="return false;">
					<ul>
						<li>
							<span class="fixed-width-right-80">注意：</span>是将他人的卡充值给自己
						</li>
						<li><span class="fixed-width-right-80">输入卡密：</span><input class="kmcz_cardno" name="kmcz_cardno" type="text" placeholder="输入卡密">
                            <a href="javascript:void(0);" class="kmcz_cye">　查余额</a>
                            <span class="kmcz_yexs"></span>
                        </li>
						<li><span class="fixed-width-right-80">输入数量：</span><input name="usenum" type="text" placeholder="输入数量"></li>
						<li><span class="fixed-width-right-80">&nbsp;</span><button class="btn card_chongzhi_btn">点击充值卡密</button></li>
					</ul>
					<input class="kmcz_password" name="password" type="hidden" value="">
					</form>
				</div>
			</div>
		</div>

	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">
						拆分卡密
					</h2>
				</div>
				<div class="panel-body">
					<form role="form" method="post" class="card_chaika_form" onsubmit="return false;">
					<ul>
						<li><span class="fixed-width-right-80">输入卡密：</span><input name="cardbn" type="text" placeholder="待拆卡的卡密"></li>
						<li><span class="fixed-width-right-80">拆分数量：</span><input name="cardnum" type="text" placeholder="需要生成子卡的张数"></li>
						<li><span class="fixed-width-right-80">卡密面值：</span><input name="allnum" type="text" placeholder="每张子卡的面值是多少"></li>
						<li><span class="fixed-width-right-80">设置密码：</span><input name="password" type="text" placeholder="可空,空则默认无密码"><span class="hidden-xs"></span></li>
						<li>
							<span class="fixed-width-right-80">操作备注：</span><input name="user_note" type="text" placeholder="比填,做什么的？卡给谁的？">
							<button class="btn card_splitcard_btn hidden-xs">点击拆卡</button>
						</li>
						<li class="hidden-lg hidden-md hidden-sm">
							<span class="fixed-width-right-80">&nbsp;</span>
							<button class="btn card_chaika_btn">点击拆子卡密</button>
						</li>
					</ul>
					</form>
				</div>
			</div>
		</div>


		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">
						批量下单区域
					</h2>
				</div>
				<div class="panel-body">
					<form role="form" method="post" class="orders_xiadan_form" onsubmit="return false;">
						<div class="row jwxh_row_row">
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
								<textarea name="OrderList" class="orders_textarea"></textarea>
								<input type="hidden" name="goods_id" value="1260">
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<ul>
                                    <li>每次批量最高可下20单</li>
                                    <li><button class="btn orders_xiadan_btn">【确定提交批量订单】</button></li>
                                </ul>
							</div>
						</div>
						<div class="row jwxh_row_row">
							<ul>
								<li>批量格式：QQ号码----下单数量</li>
																								</ul>
						</div>
					</form>
				</div>
			</div>
		</div>

	</div>


	<div class="row">
		<div class="col-md-12">
			<div class="jwxh_main_div_nav_tabs">

				<ul class="nav nav-tabs">
				  <li class="active"><a href="http://www.xdzk.net/index.php?m=Home&amp;c=Goods&amp;a=detail&amp;id=1260#tab1" data-toggle="tab"><button type="button" class="btn btn_ddglq">订单管理</button></a></li>
				  <li><a href="http://www.xdzk.net/index.php?m=Home&amp;c=Goods&amp;a=detail&amp;id=1260#tab2" data-toggle="tab"><button type="button" class="btn btn_zkmglq">卡组管理</button></a></li>
				  <li><a href="http://www.xdzk.net/index.php?m=Home&amp;c=Goods&amp;a=detail&amp;id=1260#tab3" data-toggle="tab"><button type="button" class="btn btn_zkmglq">子卡管理</button></a></li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane active" id="tab1">

<!-- 订单列表区开始 -->
<div class="div_search">
		<form class="form-inline" role="form">
			<div class="form-group">
					<label class="control-label" for="name">QQ号码：</label>
					<input type="text" class="form-control" id="sokey_qq" placeholder="请输入QQ号码">&nbsp;
				</div>			<button type="button" class="btn" id="custom_search_orders">模糊搜索订单</button>
		</form>
	</div>
<div id="dtGridContainer_orders" class="dt-grid-container" ajax_change_order_status="">

<table class="dt-grid table table-condensed" id="dt_grid_d0f0de9301d3c9faeac08e71a11379d6" style="">
	<thead>
	<tr class="dt-grid-headers">
    <th class="extra-column visible-xs "></th>
    <th columnno="0" columnid="aa" class="dt-grid-header   can-sort" style="text-align: left;">QQ号码</th>			<th columnno="1" columnid="need_num_0" class="dt-grid-header hidden-xs   can-sort" style="text-align: left;">		下单数量	</th>

    <th columnno="2" columnid="add_time" class="dt-grid-header hidden-xs   can-sort" style="text-align: left;">下单日期</th>

    <th columnno="3" columnid="start_num" class="dt-grid-header hidden-xs   can-sort" style="text-align: left;">		初始数量	</th>

    <th columnno="4" columnid="now_num" class="dt-grid-header   can-sort" style="text-align: left;">		当前数量	</th>

    <th columnno="5" columnid="order_state" class="dt-grid-header   can-sort" style="text-align: left;">		订单状态	</th>

    <th columnno="6" columnid="jwxh_action" class="dt-grid-header hidden-xs   can-sort" style="text-align: left;">		操作订单	</th>
    </tr>
    <tr  class="dt-grid-headers">
    	<td>111</td>
        <td>111</td>
        <td>111</td>
        <td>111</td>
        <td>111</td>
        <td>111</td>
        <td>111</td>
    </tr>
     <tr  class="dt-grid-headers">
    	<td>111</td>
        <td>111</td>
        <td>111</td>
        <td>111</td>
        <td>111</td>
        <td>111</td>
        <td>111</td>
    </tr>
    </thead>
    <tbody>
    </tbody>
    </table>
    </div>


<div id="dtGridToolBarContainer_orders" class="dt-grid-toolbar-container"><span class="pagination pagination-sm dt-grid-tools"></span><span class="dt-grid-pager"><ul id="d0f0de9301d3c9faeac08e71a11379d6_dtGridOperations" class="pagination pagination-sm dt-grid-pager-button"></ul><span class="dt-grid-pager-status text-primary">无查询记录...</span><div class="clearfix"></div></span><div class="clearfix"></div></div>

<script type="text/javascript">
	var order_state = {0:'未开始', 1:'未开始', 2:'进行中', 3:'已完成', 4:'已退单', 5:'退单中', 6:'续费中', 7:'补单中', 8:'改密中', 9:'登录失败'};
		var dtGridColumns_orders = [
					{id:'aa', title:'QQ号码', type:'string', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'', fastQuery:true, fastQueryType:'eq'},		{id:'need_num_0', title:'下单数量', type:'string', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'xs',  fastQuery:true, fastQueryType:'eq'},		{id:'add_time', title:'下单日期', type:'date', format:'yyyy-MM-dd hh:mm:ss', otype:'string', oformat:'yyyy-MM-dd hh:mm:ss', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'xs',  fastQuery:true, fastQueryType:'range' },
		{id:'start_num', title:'初始数量', type:'string', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'xs',  fastQuery:true, fastQueryType:'eq'},
		{id:'now_num', title:'当前数量', type:'string', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'',  fastQuery:true, fastQueryType:'eq'},

		{id:'order_state', title:'订单状态', type:'string', codeTable:order_state, headerStyle:'text-align: left;', columnClass:'text-left', hideType:'',  resolution:function(value, record, column, grid, dataNo, columnNo){
				var content = '';
				if( record.order_state==9 ){
					switch(record.login_state){
						case 0:
							content=content+'正常-OR-异常';
							break;
						case 1:
							content=content+'登录保护';
							break;
						case 2:
							content=content+'号码冻结';
							break;
						case 3:
							content=content+'密码错误';
							break;
						default:
							content=content+'[警告:系统异常]';
					}
					value=content;
				}else{
					value=order_state[value];
				}
				if(value==''){
					value='-未知-';
				}
				return value;
			}
		},

		{id:'jwxh_action', title:'操作订单', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'xs', resolution:function(value, record, column, grid, dataNo, columnNo){
				var tuidan_array = [];
				var bugua_array =  [];
				var gaimi_array =  [];
				var content = '';
				if( $.inArray(record.order_state, tuidan_array)>=0 && record.order_state!=5 ){
					content=content+'<a href="#" class="ddglq_change_order_status" ajax_orderid="'+record.id+'" ajax_goods_type="'+record.goods_type+'" ajax_action="tuidan">退单</a>&nbsp;';
				}
				if( $.inArray(record.order_state, bugua_array)>=0 && record.order_state!=7 ){
					content=content+'<a href="#" class="ddglq_change_order_status" ajax_orderid="'+record.id+'" ajax_goods_type="'+record.goods_type+'" ajax_action="budan">补单</a>&nbsp;';
				}
								if(content==''){
					content='-无-';
				}
				return content;
			}
		}

	];
	var dtGridOption_orders = {
		lang : 'zh-cn',
		tableClass : 'table table-condensed',
		ajaxLoad : true,
		loadURL : '/index.php?m=home&c=order&a=orderlist_dtGrid&goods_id=1260&goods_type=135',
		exportFileName : '订单列表',
		columns : dtGridColumns_orders,
		gridContainer : 'dtGridContainer_orders',
		toolbarContainer : 'dtGridToolBarContainer_orders',
		tools : '',
		pageSize : 10,
		pageSizeLimit : [10, 20, 50]
	};
	var DtGrid_orders = $.fn.DtGrid.init(dtGridOption_orders);

	jQuery(document).ready(function() {
		$(function(){
            DtGrid_orders.load();
			$('#custom_search_orders').click(customSearch_orders);        });
	});
	//自定义查询
		function customSearch_orders(){
			DtGrid_orders.parameters = new Object();
			DtGrid_orders.parameters['qq'] = $('#sokey_qq').val();			DtGrid_orders.refresh(true);
		}</script>
<!-- 订单列表区结束 -->

					</div>

					<div class="tab-pane" id="tab2">


<!-- 卡密组列表区开始 -->
<div class="div_search">
	<form class="form-inline" role="form">
		<div class="form-group">
			<label class="control-label" for="name">精确卡密组：</label>
			<input type="text" class="form-control" id="sokey_card_groups_GroupId" placeholder="">&nbsp;
		</div>
		<div class="form-group">
			<label class="control-label" for="name">精确卡密：</label>
			<input type="text" class="form-control" id="sokey_card_groups_Card" placeholder="">&nbsp;
		</div>
		<div class="form-group">
			<label class="control-label" for="name">备注信息：</label>
			<input type="text" class="form-control" id="sokey_card_groups_UserNote" placeholder="">&nbsp;
		</div>
		<button type="button" class="btn" id="custom_search_card_groups">模糊搜索卡密组</button>
	</form>
</div>
<div id="dtGridContainer_card_groups" class="dt-grid-container" ajax_change_card_group_status="/index.php?m=home&amp;c=card&amp;a=change_card_group_status" ajax_card_group_down="/index.php?m=home&amp;c=card&amp;a=homeDown" ajax_dtgrid_url="/index.php?m=home&amp;c=card&amp;a=cardlist_dtGrid&amp;goods_id=1260&amp;goods_type=135">

<table class="dt-grid table table-condensed" id="dt_grid_f794fc98de87c25849f4b6f483a01d91" style="">

	<thead>
    <tr class="dt-grid-headers">
    <th class="extra-column visible-xs "></th>
    <th columnno="0" columnid="groupno" class="dt-grid-header   can-sort" style="text-align: left;">		卡密组	</th>

    <th columnno="1" columnid="all_num" class="dt-grid-header hidden-xs   can-sort" style="text-align: left;">		面值	</th>

    <th columnno="2" columnid="count_num" class="dt-grid-header hidden-xs   can-sort" style="text-align: left;">		张数	</th>

    <th columnno="3" columnid="all_count_num" class="dt-grid-header   can-sort" style="text-align: left;">		合计点	</th>

    <th columnno="4" columnid="password" class="dt-grid-header hidden-xs   can-sort" style="text-align: left;">		默认密码	</th>

    <th columnno="5" columnid="user_note" class="dt-grid-header hidden-xs   can-sort" style="text-align: left;">		备注信息	</th>

    <th columnno="6" columnid="time" class="dt-grid-header hidden-xs   can-sort" style="text-align: left;">		生成时间	</th>

    <th columnno="7" columnid="status" class="dt-grid-header   can-sort" style="text-align: left;">		组状态	</th>

    <th columnno="8" columnid="jwxh_action" class="dt-grid-header hidden-xs   can-sort" style="text-align: left;">		操作卡密组	</th>

    <th columnno="9" columnid="jwxh_down" class="dt-grid-header hidden-xs   can-sort" style="text-align: left;">		下载卡密组	</th>

    </tr>
    <tr class="dt-grid-headers">
    	<td>111</td>
        <td>111</td>
        <td>111</td>
        <td>111</td>
        <td>111</td>
        <td>111</td>
        <td>111</td>
    </tr>
    <tr class="dt-grid-headers">
    	<td>111</td>
        <td>111</td>
        <td>111</td>
        <td>111</td>
        <td>111</td>
        <td>111</td>
        <td>111</td>
    </tr>
    </thead>
    <tbody>
    </tbody>
    </table>
    </div>
<div id="dtGridToolBarContainer_card_groups" class="dt-grid-toolbar-container"><span class="pagination pagination-sm dt-grid-tools"></span><span class="dt-grid-pager"><ul id="f794fc98de87c25849f4b6f483a01d91_dtGridOperations" class="pagination pagination-sm dt-grid-pager-button"></ul><span class="dt-grid-pager-status text-primary">无查询记录...</span><div class="clearfix"></div></span><div class="clearfix"></div></div>


<!-- 卡密组列表区结束 -->

					</div>

					<div class="tab-pane" id="tab3">

<!-- 卡密详细列表区开始 -->
<div class="div_search">
	<form class="form-inline" role="form">
		<div class="form-group">
			<label class="control-label" for="name">精确卡密组：</label>
			<input type="text" class="form-control" id="sokey_cards_GroupId" placeholder="">&nbsp;
		</div>
		<div class="form-group">
			<label class="control-label" for="name">模糊卡密：</label>
			<input type="text" class="form-control" id="sokey_cards_Card" placeholder="">&nbsp;
		</div>
		<button type="button" class="btn" id="custom_search_cards">搜索详细卡密</button>
	</form>
</div>
<div id="dtGridContainer_cards" class="dt-grid-container" ajax_change_card_status="/index.php?m=home&amp;c=card&amp;a=change_card_status" ajax_dtgrid_url="/index.php?m=home&amp;c=card&amp;a=cardslist_dtGrid&amp;goods_id=1260&amp;goods_type=135"><table class="dt-grid table table-condensed" id="dt_grid_ee55d6168457509b79d4cf14937f0d44" style="">

	<thead>
    	<tr class="dt-grid-headers">
        	<th class="extra-column visible-xs "></th>
            <th columnno="0" columnid="cardno" class="dt-grid-header   can-sort" style="text-align: left;">		卡密	</th>

            <th columnno="1" columnid="usenum" class="dt-grid-header   can-sort" style="text-align: left;">		余额	</th>

            <th columnno="2" columnid="allnum" class="dt-grid-header hidden-xs   can-sort" style="text-align: left;">		面值	</th>

            <th columnno="3" columnid="groupid" class="dt-grid-header hidden-xs   can-sort" style="text-align: left;">		卡组ID	</th>

            <th columnno="4" columnid="time" class="dt-grid-header hidden-xs   can-sort" style="text-align: left;">		生成时间	</th>

            <th columnno="5" columnid="status" class="dt-grid-header hidden-xs   can-sort" style="text-align: left;">		组状态	</th>

            <th columnno="6" columnid="jwxh_action" class="dt-grid-header hidden-xs   can-sort" style="text-align: left;">		操作卡密组	</th>

          </tr>
          <tr class="dt-grid-headers">
          		<td>111</td>
                <td>111</td>
                <td>111</td>
                <td>111</td>
                <td>111</td>
                <td>111</td>
                <td>111</td>
          </tr>
           <tr class="dt-grid-headers">
          		<td>111</td>
                <td>111</td>
                <td>111</td>
                <td>111</td>
                <td>111</td>
                <td>111</td>
                <td>111</td>
          </tr>
          </thead>
          <tbody>
          </tbody>
          </table>
          </div>


<div id="dtGridToolBarContainer_cards" class="dt-grid-toolbar-container"><span class="pagination pagination-sm dt-grid-tools"></span><span class="dt-grid-pager"><ul id="ee55d6168457509b79d4cf14937f0d44_dtGridOperations" class="pagination pagination-sm dt-grid-pager-button"></ul><span class="dt-grid-pager-status text-primary">无查询记录...</span><div class="clearfix"></div></span><div class="clearfix"></div></div>

<!-- 卡密详细列表区结束 -->

					</div>

				</div>

			</div>
		</div>
	</div>

</div>


<!--底部-->
<footer class="navbar-fixed-bottom hidden-xs hidden-sm">
	<div class="container">
		<div class="row">
		  <div class="col-md-8 col-sm-6 col-xs-6"><span>Copyright © 新版post卡密平台<span class="hidden-xs hidden-sm">. All Rights Reserved</span></span></div>
		  <div class="col-md-4 col-sm-6 col-xs-6 text-right">蜀ICP备123456号</div>
		</div>
	</div>
</footer>

<!--底部-->
<footer class="hidden-md hidden-lg">
	<div class="container">
		<div class="row">
		  <div class="col-md-8 col-sm-6 col-xs-6"><span><span class="hidden-xs">Copyright </span>© 新版post卡密平台<span class="hidden-xs hidden-sm">. All Rights Reserved</span></span></div>
		  <div class="col-md-4 col-sm-6 col-xs-6 text-right">蜀ICP备123456号</div>
		</div>
	</div>
</footer>


<!-- 模态框修改密码（Modal） -->
<div class="modal fade" id="KMZH_GaiMi_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  ×
            </button>
            <h4 class="modal-title" id="myModalLabel">
               修改密码
            </h4>
         </div>
         <div class="modal-body">
			<div class="container-fluid">
				<form role="form" class="Form_KMZH_XiuGaiMima form-horizontal alter-pwd-form" onsubmit="return false;">
                        <div class="form-group">
							<label class="col-sm-2 control-label">原密码</label>
							<div class="col-sm-10">
								<input type="password" name="oldpassword" class="form-control" placeholder="旧密码,若无则不写">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">新的密码</label>
							<div class="col-sm-10">
								<input type="password" name="newpassword" class="form-control" placeholder="请输入新的密码">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">确认新密码</label>
							<div class="col-sm-10">
								<input type="password" name="renewpassword" class="form-control" placeholder="重复输入新密码，和上方相同">
							</div>
						</div>
				</form>
			</div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">
                取消
            </button>
            <button type="button" class="btn alter-pwd">
               提交更改密码
            </button>
         </div>
      </div><!-- /.modal-content -->
   </div><!-- /.modal -->
</div><!-- /.modal -->

<script src="/static/js/jwxh.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/tools.js" type="text/javascript" charset="utf-8"></script>

<div style="display:none;">
	<script src="/static/z_stat.php" language="JavaScript"></script><script src="/static/core.php" charset="utf-8" type="text/javascript"></script><a href="http://www.cnzz.com/stat/website.php?web_id=1257842329" target="_blank" title="站长统计">站长统计</a>
</div>

<script type="text/javascript">
    //修改密码
    $(".alter-pwd").on('click', function(){
        var param = $._get_form_json(".alter-pwd-form");

//        if(param.newpassword)
        if(param.oldpassword == ''){
            $("[name=oldpassword]").closest('div')._error('请输入旧密码');
            return
        }
        if(param.newpassword == ''){
            $("[name=newpassword]").closest('div')._error('请输入新密码');
            return
        }
        if(param.renewpassword == ''){
            $("[name=renewpassword]").closest('div')._error('请再次输入新密码');
            return
        }
        if(param.renewpassword != param.newpassword){
            $("[name=renewpassword]").closest('div')._error('两次输入的密码不匹配，请重新输入');
            return
        }

        $._ajax('/plorder/user/alter-pwd', {oldpwd: param.oldpassword, pwd: param.newpassword}, 'POST', 'JSON', function(json){
            if(json.code > 0){
                alert(json.msg);
            }else{
                $(".alter-pwd").closest('div')._error(json.msg, 'p', 'prepend');
            }
        });
    });

    //单个下单
    $(".order_post_btn").on('click', function(){
        var param = $._get_form_json(".order_post_form");
        if(param.qq == ''){
            $("[name=qq]").closest('li')._error('请输入QQ');
            return
        }
        if(param.num == ''){
            $("[name=num]").closest('li')._error('请输入QQ');
            return
        }
        $._ajax('/plorder/order/add', param, 'POST', 'JSON', function(json){
            if(json.code > 0){
                alert(json.msg);
            }else{
                $(".order_post_btn").closest('li')._error(json.msg, 'p', 'prepend');
            }
        });
    });

    //批量下单
    $(".orders_xiadan_btn").on('click', function(){
        var param = {};
        var text = $.trim($(".orders_textarea").val());
        if(text == ''){
            $(".orders_textarea").closest('div')._error('请输入下单QQ和下单数量', 'p', 'append');
            return
        }
        param.text = text;
        param.gid = <?php echo getValue($goods, 'gid', 0); ?>;
        $._ajax('/plorder/order/batch-add', param, 'POST', 'JSON', function(json){
            if(json.code > 0){
                alert(json.msg);
            }else{
                alert(json.msg);
            }
        });
    });

    //卡密充值
    $(".card_chongzhi_btn").on('click', function(){
        var param = $._get_form_json(".card_chongzhi_form");
        if(param.kmcz_cardno == ''){
            $("[name=kmcz_cardno]").closest('li')._error('请输入卡密');
            return
        }
        if(param.usenum == ''){
            $("[name=usenum]").closest('li')._error('请输入数量');
            return
        }
        var val = {
            card_bn: param.kmcz_cardno,
            charge_points: param.usenum
        };
        $._ajax('/plorder/card/charge', val, 'POST', 'JSON', function(json){
            if(json.code > 0){
                alert(json.msg);
            }else{
                alert(json.msg);
            }
        });
    });

    //拆分卡密
    $(".card_splitcard_btn").on('click', function(){
        var param = $._get_form_json(".card_chaika_form");
        if(param.cardbn == ''){
            $("[name=cardbn]").closest('li')._error('请输入待拆卡卡密');
            return
        }
        if(param.cardnum == ''){
            $("[name=cardnum]").closest('li')._error('请输入拆分数量');
            return
        }
        if(param.allnum == ''){
            $("[name=allnum]").closest('li')._error('请输入卡密面值');
            return
        }
        var val = {
            card_bn: param.cardbn,
            num: param.cardnum,
            each_points: param.allnum,
            pwd: param.password,
            comment: param.user_note
        };
        $._ajax('/plorder/card/split', val, 'POST', 'JSON', function(json){
            if(json.code > 0){
                alert(json.msg);
            }else{
                $(".card_splitcard_btn").closest('li')._error(json.msg);
            }
        });
    });






</script>


</body></html>