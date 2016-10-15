
	
	jQuery(document).ready(function() {     

		var card_kye,card_kmz,card_fkr,card_kmh,last_login_time;
		
		$('.exit_login').click(function (e) {
			var result=confirm( '确定要退出吗？');
			if(result){
				$.get($('.exit_login_a').attr('href'),function (data){
					if(!data.status){
						alert(data.info);
					} else {
						alert(data.info);
						setTimeout("location.href = '"+data.url+"'",200);
					}
				},'json');
			};
			return false;
		});

		function card_info() {
			$.get($('.card_info').attr('ajax_href'),function (data){
				if(data.status){
					card_kye=data.rows[0].usenum;
					card_kmz=data.rows[0].allnum;
					card_fkr=data.rows[0].time;
					card_kmh=data.rows[0].cardno;
					last_login_time=data.rows[0].last_login_time;
					show_card_info();
				}
			},'json');
		}
		
		function show_card_info() {
			$('.card_kye').html(card_kye);
			$('.card_kmz').html(card_kmz);
			$('.card_fkr').html(card_fkr);
			$('.card_kmh').html(card_kmh);
		}
		
		var km_is_password=false;
		$('.kmcz_cye').click(function (e) {
			cxye_password();
		});			
		
		$('.kmcz_cardno').blur(function (e) {
			cxye_password();
		});
		
		function cxye_password(){
			var kmcz_cardno=$('.kmcz_cardno').val();
			if(kmcz_cardno.length>0){
				$.post($('.kmcz_cye').attr('ajax_href'),"kmcz_cardno="+kmcz_cardno,function (data){
					if(data.status){
						km_is_password=data.rows[0].is_password;
						$('.kmcz_yexs').html("余:"+data.rows[0].usenum);
					}else{
						$('.kmcz_yexs').html('卡无效！');
					}
				},'json');
			};
			return false;
		}
		
		$('.card_chongzhi_btn').click(function (e) {
			var kmcz_cardno=$('.kmcz_cardno').val();
			if(km_is_password==true){
				var str=prompt("输入"+kmcz_cardno+"的密码，无密码请直接确定！","");
				$('.kmcz_password').val(str);
			}
			if(kmcz_cardno.length>0){
				$.post($('.card_chongzhi_form').attr('action'),$('.card_chongzhi_form').serialize(),function (data){
					if(data.status){
						card_info();
						cxye_password();
						/* 需要刷新列表 */
						//DtGrid_orders.refresh(true);/*刷新订单*/
						DtGrid_card_groups.refresh(true);/*刷新卡密*/
						DtGrid_cards.refresh(true);/*刷新卡密列表*/
						alert(data.info);
					}else{
						alert(data.info);
					}
				},'json');
			};
			return false;
		});
		
		$('.card_chaika_btn').click(function (e) {
			$.post($('.card_chaika_form').attr('action'),$('.card_chaika_form').serialize(),function (data){
				if(data.status){
					card_info();
					/* 需要刷新列表 */
					//DtGrid_orders.refresh(true);/*刷新订单*/
					DtGrid_card_groups.refresh(true);/*刷新卡密*/
					DtGrid_cards.refresh(true);/*刷新卡密列表*/
					alert(data.info);
				}else{
					alert(data.info);
				}
			},'json');

			return false;
		});
		
		$('.order_post_btn').click(function (e) {
			$.post($('.order_post_form').attr('action'),$('.order_post_form').serialize(),function (data){
				if(data.status){
					card_info();
					/* 需要刷新列表 */
					DtGrid_orders.refresh(true);/*刷新订单*/
					//DtGrid_card_groups.refresh(true);/*刷新卡密*/
					//DtGrid_cards.refresh(true);/*刷新卡密列表*/
					alert(data.info);
				}else{
					alert(data.info);
				}
			},'json');
			return false;
		});
		
	
		$('.order_xiangpian_post_btn').click(function (e) {
			$.post($('.order_post_form').attr('action'),$('.order_post_form').serialize()+'&'+$('.div_xiangpian').serialize(),function (data){
				if(data.status){
					card_info();
					/* 需要刷新列表 */
					DtGrid_orders.refresh(true);/*刷新订单*/
					//DtGrid_card_groups.refresh(true);/*刷新卡密*/
					//DtGrid_cards.refresh(true);/*刷新卡密列表*/
					alert(data.info);
				}else{
					alert(data.info);
				}
			},'json');
			return false;
		});
		
		$('.orders_xiadan_btn').click(function (e) {
			$.post($('.orders_xiadan_form').attr('action'),$('.orders_xiadan_form').serialize(),function (data){
				if(data.status){
					card_info();
					/* 需要刷新列表 */
					DtGrid_orders.refresh(true);/*刷新订单*/
					//DtGrid_card_groups.refresh(true);/*刷新卡密*/
					//DtGrid_cards.refresh(true);/*刷新卡密列表*/
					alert(data.info);
				}else{
					alert(data.info);
				}
			},'json');
			return false;
		});
		
		
		/* 订单操作按钮 */
		$("#dtGridContainer_orders").on("click",".ddglq_change_order_status",function(){
			var ajax_orderid=$(this).attr('ajax_orderid');
			var ajax_action=$(this).attr('ajax_action');
			var ajax_goods_type=$(this).attr('ajax_goods_type');
			var datastr='';
			if(ajax_action=='gaimi'){
				var ajax_ordermm=$(this).attr('ajax_ordermm');
				var str=prompt("输入对应帐号的新密码",ajax_ordermm);
				if(str){
					ajax_ordermm=str;
					datastr='order_id='+ajax_orderid+'&order_mm='+ajax_ordermm+'&action='+ajax_action+'&goods_type='+ajax_goods_type+'';
				}else{
					return false;
				}
			}else{
				datastr='order_id='+ajax_orderid+'&action='+ajax_action+'&goods_type='+ajax_goods_type+'';
			}

			$.post($('#dtGridContainer_orders').attr('ajax_change_order_status'),datastr,function (data){
				if(data.status){
					card_info();
					/* 需要刷新列表 */
					DtGrid_orders.refresh(true);/*刷新订单*/
					//DtGrid_card_groups.refresh(true);/*刷新卡密*/
					//DtGrid_cards.refresh(true);/*刷新卡密列表*/
					alert(data.info);
				}else{
					alert(data.info);
				}
			},'json');

			return false;
		});
		
		
		/* 卡密组操作按钮 */
		$("#dtGridContainer_card_groups").on("click",".zkmglq_change_card_group_status",function(){
			var zk_goods_type=$(this).attr('ajax_goods_type');
			var zk_card_group=$(this).attr('ajax_card_group');
			var zk_status=$(this).attr('ajax_status');
			var datastr='';
			datastr='zk_goods_type='+zk_goods_type+'&zk_cardno_group='+zk_card_group+'&zk_status='+zk_status+'';

			$.post($('#dtGridContainer_card_groups').attr('ajax_change_card_group_status'),datastr,function (data){
				if(data.status){
					/* 需要刷新列表 */
					//DtGrid_orders.refresh(true);/*刷新订单*/
					DtGrid_card_groups.refresh(true);/*刷新卡密*/
					//DtGrid_cards.refresh(true);/*刷新卡密列表*/
					alert(data.info);
				}else{
					alert(data.info);
				}
			},'json');

			return false;
		});
		
		
		/* 卡密操作按钮 */
		$("#dtGridContainer_cards").on("click",".zkmglq_change_card_status",function(){
			var zk_goods_type=$(this).attr('ajax_goods_type');
			var zk_cardno=$(this).attr('ajax_cardno');
			var zk_status=$(this).attr('ajax_status');
			var datastr='';
			datastr='zk_goods_type='+zk_goods_type+'&zk_cardno='+zk_cardno+'&zk_status='+zk_status+'';

			$.post($('#dtGridContainer_cards').attr('ajax_change_card_status'),datastr,function (data){
				if(data.status){
					/* 需要刷新列表 */
					//DtGrid_orders.refresh(true);/*刷新订单*/
					//DtGrid_card_groups.refresh(true);/*刷新卡密*/
					DtGrid_cards.refresh(true);/*刷新卡密列表*/
					alert(data.info);
				}else{
					alert(data.info);
				}
			},'json');

			return false;
		});
		
		
		
		
		/* 卡密下载按钮 */
		$("#dtGridContainer_card_groups").on("click",".zkmglq_down_card_group",function(){
			var zk_goods_type=$(this).attr('ajax_goods_type');
			var ajax_card_group=$(this).attr('ajax_card_group');
			var zk_formattype=$(this).attr('ajax_formattype');
			var datastr='';
			datastr='goods_type='+zk_goods_type+'&groupno='+ajax_card_group+'&formattype='+zk_formattype+'';
			var site_url=$('#dtGridContainer_card_groups').attr('ajax_card_group_down');
			if(site_url.indexOf('?')>0){
				site_url=site_url+'&'+datastr;
			}else{
				site_url=site_url+'?'+datastr;
			}
			window.open(site_url);
			return false;
		});
		
		/* placeholder动态隐藏与显示 */
		$("input").focus(function (e) {
			var placeholder=$(this).attr('placeholder');
			//alert(placeholder);
			$(this).attr('placeholder','');
			$(this).attr('temp_placeholder',placeholder);
		});
		
		/* placeholder动态隐藏与显示 */
		$("input").blur(function (e) {
			var placeholder=$(this).attr('temp_placeholder');
			//alert(placeholder);
			$(this).attr('placeholder',placeholder);
			$(this).attr('temp_placeholder','');
		});
		
		
		
		$('.togglecopy').click(function (e) {
			$('.select_none').toggle();
			return false;
		});
		
		
		/*修改卡密or用户的登录密码*/
		$('.kmzh_gaimi').click(function (e) {
			$('#KMZH_GaiMi_Modal').modal('show');
		}); 
		
		$('.Form_KMZH_XiuGaiMima_submit').click(function (e) {
			$.post($('.Form_KMZH_XiuGaiMima').attr('ajax_href'),$('.Form_KMZH_XiuGaiMima').serialize(),function (data){
				if(data.status){
					alert(data.info);
					$('#KMZH_GaiMi_Modal').modal('hide');
				}else{
					alert(data.info);
				}
			},'json');
			return false;
		}); 
		
		
		/* 默认刷新一次卡密信息 */
		card_info();
		
	});
	
	//----------------------//
	var card_groups_state = {0:'正常', 1:'已禁用组'};
	var dtGridColumns_card_groups = [
		{id:'groupno', title:'卡密组', type:'string', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'', fastQuery:true,resolution:function(value, record, column, grid, dataNo, columnNo){
				var content = '';
				content=''+record.groupno+' (ID:'+record.id+')';
				return content;
			}
		},
		{id:'all_num', title:'面值', type:'string', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'xs',  fastQuery:true, fastQueryType:'eq'},
		{id:'count_num', title:'张数', type:'string', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'xs',  fastQuery:true, fastQueryType:'eq'},
		{id:'all_count_num', title:'合计点', type:'string', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'',  fastQuery:true, fastQueryType:'eq'},
		{id:'password', title:'默认密码', type:'string', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'xs',  fastQuery:true, fastQueryType:'eq'},
		{id:'user_note', title:'备注信息', type:'string', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'xs',  fastQuery:true, fastQueryType:'eq'},
		{id:'time', title:'生成时间', type:'date', format:'yyyy-MM-dd', otype:'string', oformat:'yyyy-MM-dd', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'xs',  fastQuery:true, fastQueryType:'range' },
		{id:'status', title:'组状态', type:'string', codeTable:card_groups_state, headerStyle:'text-align: left;', columnClass:'text-left', hideType:'',  fastQuery:true, fastQueryType:'eq'},
		{id:'jwxh_action', title:'操作卡密组', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'xs', resolution:function(value, record, column, grid, dataNo, columnNo){
				var content = '';
				if( record.status==0 ){
					content=content+'<a href="#" class="zkmglq_change_card_group_status" ajax_card_group="'+record.groupno+'" ajax_goods_type="'+record.goods_type+'" ajax_status="1">禁止此组</a>&nbsp;';
				}
				if( record.status==1 ){
					content=content+'<a href="#" class="zkmglq_change_card_group_status" ajax_card_group="'+record.groupno+'" ajax_goods_type="'+record.goods_type+'" ajax_status="0">启用此组</a>&nbsp;';
				}
				if(content==''){
					content='-无-';
				}
				return content;
			}
		},
		{id:'jwxh_down', title:'下载卡密组', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'xs', resolution:function(value, record, column, grid, dataNo, columnNo){
				var content = '';
				content=content+'<a href="#" class=" zkmglq_down_card_group" ajax_card_group="'+record.groupno+'" ajax_goods_type="'+record.goods_type+'" ajax_formattype="0">仅卡</a>&nbsp;,&nbsp;';
				content=content+'<a href="#" class=" zkmglq_down_card_group" ajax_card_group="'+record.groupno+'" ajax_goods_type="'+record.goods_type+'" ajax_formattype="1">卡+数</a>&nbsp;,&nbsp;';
				content=content+'<a href="#" class=" zkmglq_down_card_group" ajax_card_group="'+record.groupno+'" ajax_goods_type="'+record.goods_type+'" ajax_formattype="2">卡+默认密</a>&nbsp;,&nbsp;';
				content=content+'<a href="#" class=" zkmglq_down_card_group" ajax_card_group="'+record.groupno+'" ajax_goods_type="'+record.goods_type+'" ajax_formattype="3">卡+默认密+数</a>&nbsp;';
				if(content==''){
					content='-无-';
				}
				return content;
			}
		}
		
	];
	var dtGridOption_card_groups = {
		lang : 'zh-cn',
		tableClass : 'table table-condensed',
		ajaxLoad : true,
		loadURL : $('#dtGridContainer_card_groups').attr('ajax_dtGrid_url'),
		exportFileName : '卡密组列表',
		columns : dtGridColumns_card_groups,
		gridContainer : 'dtGridContainer_card_groups',
		toolbarContainer : 'dtGridToolBarContainer_card_groups',
		tools : '',
		pageSize : 10,
		pageSizeLimit : [10, 20, 50, 100]
	};
	var DtGrid_card_groups = $.fn.DtGrid.init(dtGridOption_card_groups);
	
	jQuery(document).ready(function() {
		$(function(){
			$(function(){
				DtGrid_card_groups.load();
				$('#custom_search_card_groups').click(customSearch_card_groups);
			});
		});
	});
	//自定义查询
	function customSearch_card_groups(){
		DtGrid_card_groups.parameters = new Object();
		DtGrid_card_groups.parameters['card_groups_GroupId'] = $('#sokey_card_groups_GroupId').val();
		DtGrid_card_groups.parameters['card_groups_Card'] = $('#sokey_card_groups_Card').val();
		DtGrid_card_groups.parameters['card_groups_UserNote'] = $('#sokey_card_groups_UserNote').val();
		DtGrid_card_groups.refresh(true);
	}
	
	//----------------------//
	
	var cards_state = {0:'正常', 1:'已被禁用'};
	var dtGridColumns_cards = [
		{id:'cardno', title:'卡密', type:'string', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'',  fastQuery:true, fastQueryType:'eq'},
		{id:'usenum', title:'余额', type:'string', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'',  fastQuery:true, fastQueryType:'eq'},
		{id:'allnum', title:'面值', type:'string', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'xs',  fastQuery:true, fastQueryType:'eq'},
		{id:'groupid', title:'卡组ID', type:'string', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'xs',  fastQuery:true, fastQueryType:'eq'},
		{id:'time', title:'生成时间', type:'date', format:'yyyy-MM-dd', otype:'string', oformat:'yyyy-MM-dd', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'xs',  fastQuery:true, fastQueryType:'range' },
		{id:'status', title:'组状态', type:'string', codeTable:cards_state, headerStyle:'text-align: left;', columnClass:'text-left', hideType:'xs',  fastQuery:true, fastQueryType:'eq'},
		{id:'jwxh_action', title:'操作卡密组', headerStyle:'text-align: left;', columnClass:'text-left', hideType:'xs', resolution:function(value, record, column, grid, dataNo, columnNo){
				var content = '';
				if( record.status==0 ){
					content=content+'<a href="#" class="zkmglq_change_card_status" ajax_cardno="'+record.cardno+'" ajax_goods_type="'+record.goods_type+'" ajax_status="1">禁止此卡</a>&nbsp;';
				}
				if( record.status==1 ){
					content=content+'<a href="#" class="zkmglq_change_card_status" ajax_cardno="'+record.cardno+'" ajax_goods_type="'+record.goods_type+'" ajax_status="0">启用此卡</a>&nbsp;';
				}
				if(content==''){
					content='-无-';
				}
				return content;
			}
		}
		
	];
	var dtGridOption_cards = {
		lang : 'zh-cn',
		tableClass : 'table table-condensed',
		ajaxLoad : true,
		loadURL : $('#dtGridContainer_cards').attr('ajax_dtGrid_url'),
		exportFileName : '卡密组列表',
		columns : dtGridColumns_cards,
		gridContainer : 'dtGridContainer_cards',
		toolbarContainer : 'dtGridToolBarContainer_cards',
		tools : '',
		pageSize : 10,
		pageSizeLimit : [10, 20, 50, 100]
	};
	var DtGrid_cards = $.fn.DtGrid.init(dtGridOption_cards);
	
	jQuery(document).ready(function() {
		$(function(){
			$(function(){
				$(function(){
					DtGrid_cards.load();
					$('#custom_search_cards').click(customSearch_cards);
				});
			});
		});
	});
	//自定义查询
	function customSearch_cards(){
		DtGrid_cards.parameters = new Object();
		DtGrid_cards.parameters['cards_GroupId'] = $('#sokey_cards_GroupId').val();
		DtGrid_cards.parameters['cards_Card'] = $('#sokey_cards_Card').val();
		DtGrid_cards.parameters['cards_UserNote'] = $('#sokey_cards_UserNote').val();
		DtGrid_cards.refresh(true);
	}
	
	//----------------------//