<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>新版post卡密社区</title>
    <link href="/static/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/css/bootstrap-theme.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/jwxh.css">
<style>
    .navbar-fixed-top, .navbar-fixed-bottom {
    z-index: 0;
    }
    /*水青色配色方案*/
    .login_page,body{background-image:url(image/5714fd44b97e1.jpg);
    background-repeat:repeat}
    .menu,footer{background-color:#40cfe8}
    #login h2,.vertical-center .panel-title{background-color:#19d8eb}
    .btn{background-color:#2dd9ae!important}
    .div_url{padding-right:12px;padding-left:12px;max-width:165px}
    .thumbnail a{height:180px}
    .alert-danger{color:#007e94;background-color:#b4eef8;border-color:#40d0e8;background-image:none}
    .login_page,body {
        background-image: url("image/56e29f86ac53d.jpg");
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

<body class="login_page">
<!--顶部-->
<header>
	<div class="container-fluid menu">

		<div class="container">

			<div class="row">

				<div class="col-md-8 col-sm-7 col-xs-7 ">

					<h2><a href="index.html">新版post社区</a></h2>

				</div>

				<div class="col-md-4 col-sm-5 col-xs-5 text-right">

					<span class="nav_top_right"><a href="index.html">切换到首页</a></span>

				</div>

			</div>

		</div>

	</div>

</header>



<!--内容-->

<div class="container">

	<div class="empty-height hidden-xs">

	</div>

	<div class="row">

		<div class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6">

			<div class=" vertical-center">

				<div class="panel panel-default">

					<div class="panel-heading">

						<h2 class="panel-title">

							空间人气快刷						</h2>

					</div>

					<form method="post" class="jwxh_form_data kmcz_cye" cardno_login_action="/index.php?m=Home&c=Card&a=login&id=350&goods_type=6" username_login_action="/index.php?m=Home&c=User&a=login&id=350&goods_type=6" user_sendpass_action="/index.php?m=Home&c=User&a=sendpass" username_register_action="/index.php?m=Home&c=User&a=register&id=350&goods_type=6" check_cardno_ajax_href="/index.php?m=Home&c=Card&a=cardinfo_no&id=350&goods_type=6" >

					<div class="panel-body">

						<ul id="myTab" class="nav nav-tabs">

						   <li class="active">

							  <a href="#card_login_form" data-toggle="tab">

								卡密登录

							  </a>

						   </li>

						   <li><a href="#user_login_form" data-toggle="tab">帐号登录</a></li>

						   <li><a href="#user_register_form" data-toggle="tab">注册帐号</a></li>

						</ul>

						<div id="myTabContent" class="tab-content">

							<div class="tab-pane fade in active" id="card_login_form">

								<p class="login_description"><label>																																																<span><b>下单前设置好空间权限 &nbsp;允许任何人可以访问 &nbsp;下单前Q空间必须要有说说</b></span>							 							 							 							 							 							 </label></p>								<p>

								  <div class="form-group">

									<div class="input-group">

									  <div class="input-group-addon">卡密</div>

									  <input class="form-control login_input_cardno card_login_input" name="cardno" type="text" placeholder="输入空间人气快刷卡密">

									</div>

								  </div>

								</p>



								<p class="login_form_cardno_group_password" style="display:none;">

								  <div class="form-group login_form_cardno_group_password" style="display:none;">

									<div class="input-group" >

									  <div class="input-group-addon">密码</div>

									  <input class="form-control login_input_cardno_password card_login_input" name="password" type="password" placeholder="卡密密码,无密则不填">

									</div>

								  </div>

								</p>



								<p>

									<button class="btn card_login_btn" type="submit">卡密登入空间人气快刷</button>

								</p>

							</div>





							<div class="tab-pane fade" id="user_login_form">

								<p class="login_description"><label>																																																<span><b>下单前设置好空间权限 &nbsp;允许任何人可以访问 &nbsp;下单前Q空间必须要有说说</b></span>							 							 							 							 							 							 </label></p>								<p>

								  <div class="form-group">

									<div class="input-group">

									  <div class="input-group-addon">帐号</div>

									  <input class="form-control login_input_username user_login_input" name="username" type="text" placeholder="输入你的用户帐号">

									</div>

								  </div>

								</p>

								<p>

								  <div class="form-group">

									<div class="input-group" >

									  <div class="input-group-addon">密码</div>

									  <input class="form-control user_login_input" name="username_password" type="password" placeholder="用户名的密码,必填">

									</div>

								  </div>

								</p>

								<p>

								  <div class="form-group">

									<a href="#user_sendpass_form" data-toggle="tab">忘记了密码？</a>

								  </div>

								</p>

								<p>

									<button class="btn username_login_btn" type="submit">登入新版post社区</button>

								</p>

							</div>





							<div class="tab-pane fade" id="user_sendpass_form">

								<p class="login_description">系统将把新密码连接发送至你注册时的邮箱/QQ邮箱中！</p>

								<p>

								  <div class="form-group">

									<div class="input-group">

									  <div class="input-group-addon">帐号</div>

									  <input class="form-control user_sendpass_input" name="sendpass_username" type="text" placeholder="输入你的用户帐号">

									</div>

								  </div>

								</p>

								<p>

								  <div class="form-group">

									必须访问邮箱中的连接一次才会将密码成功修改的哟~

								  </div>

								</p>



								<p>

									<a href="#user_login_form" data-toggle="tab"><button class="btn"">返回登录</button></a>

									<br/>

									<button class="btn user_sendpass_btn right" type="submit">发送密码邮件给我</button>

								</p>

							</div>





							<div class="tab-pane fade" id="user_register_form">



								<p>

								  <div class="form-group">

									<div class="input-group">

									  <div class="input-group-addon">帐号</div>

									  <input class="form-control user_register_input" name="reg_username" type="text" placeholder="输入你的用户帐号">

									</div>

								  </div>

								</p>



								<p>

								  <div class="form-group">

									<div class="input-group" >

									  <div class="input-group-addon">密码</div>

									  <input class="form-control user_register_input" name="reg_password" type="password" placeholder="用户名的密码,比填">

									</div>

								  </div>

								</p>



								<p>

								  <div class="form-group">

									<div class="input-group" >

									  <div class="input-group-addon">性别</div>



										<label class="checkbox-inline form-control">

											  <input type="radio" name="reg_sex" value="0" checked>男生



											  <input type="radio" name="reg_sex" value="1">女生

										</label>



									</div>

								  </div>

								</p>



								<p>

								  <div class="form-group">

									<div class="input-group" >

									  <div class="input-group-addon">Q号</div>

									  <input class="form-control user_register_input" name="reg_qq" type="text" placeholder="用于紧急联系,找回密码">

									</div>

								  </div>

								</p>





								<p>

									<button class="btn username_register_btn right" type="submit">注册新版post社区帐号</button>

								</p>



							</div>

						</div>



					</div>

					<input name="id" class="span2" type="hidden" value="350">

					<input name="goods_type" class="span2" type="hidden" value="6">

				</form>

				</div>





			</div>

		</div>

	</div>

</div>



<!--底部 登录页使用固定-->

<footer class="navbar-fixed-bottom hidden-xs hidden-sm">

	<div class="container">

		<div class="row">

		  <div class="col-md-8 col-sm-6 col-xs-6" ><span>Copyright © 新版post卡密平台<span class="hidden-xs hidden-sm">. All Rights Reserved</span></span></div>

		  <div class="col-md-4 col-sm-6 col-xs-6 text-right">蜀ICP备123456号</div>

		</div>

	</div>

</footer>



<!--底部 登录页使用固定-->

<footer class="navbar-fixed-bottom hidden-md hidden-lg">

	<div class="container">

		<div class="row">

		  <div class="col-md-8 col-sm-6 col-xs-6" ><span><span class="hidden-xs">Copyright </span>© 新版post卡密平台<span class="hidden-xs hidden-sm">. All Rights Reserved</span></span></div>

		  <div class="col-md-4 col-sm-6 col-xs-6 text-right">蜀ICP备123456号</div>

		</div>

	</div>

</footer>



<script src="js/jquery.min.js"  type="text/javascript" charset="utf-8"></script>

<script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">

		jQuery(document).ready(function() {



			$('.card_login_btn').click(function (e) {

				//卡密登录之前,先测试下有没有密码

				login_is_password();

				form_submit('cardno_login_action');

				return false;

			});

			$('.username_login_btn').click(function (e) {

				form_submit('username_login_action');

				return false;

			});

			$('.user_sendpass_btn').click(function (e) {

				form_submit('user_sendpass_action');

				return false;

			});

			$('.username_register_btn').click(function (e) {

				form_submit('username_register_action');

				return false;

			});



			$('.to_home_btn').click(function (e) {

				location.href = '/';

				return false;

			});





			$('.card_login_input').keypress(function(event){

				if(event.keyCode ==13){

					form_submit('cardno_login_action');

					return false;

				}

			});

			$('.user_login_input').keypress(function(event){

				if(event.keyCode ==13){

					form_submit('username_login_action');

					return false;

				}

			});

			$('.user_register_input').keypress(function(event){

				if(event.keyCode ==13){

					form_submit('username_register_action');

					return false;

				}

			});





			$('.login_input_cardno').bind("blur keyup",function(){

				var login_input_cardno=$('.login_input_cardno').val();

				if(login_input_cardno.length>=8){

					login_is_password();

				}

				return false;

			});



			function login_is_password() {

				var login_input_cardno=$('.login_input_cardno').val();

				if(login_input_cardno.length>0){

					$.post($('.kmcz_cye').attr('check_cardno_ajax_href'),"kmcz_cardno="+login_input_cardno,function (data){

						if(data.status){

							if(data.rows[0].is_password){

								$('.login_input_cardno_password').attr('placeholder','有密码,请输入此卡密密码！');

								$('.login_form_cardno_group_password').show();

							}else{

								$('.login_input_cardno_password').val('');

								$('.login_form_cardno_group_password').hide();

							}

						}else{

							$('.login_input_cardno_password').attr('placeholder','卡密密码,无密则不填！');

							$('.login_input_cardno_password').val('');

							$('.login_form_cardno_group_password').hide();

						}

					},'json');

				};

			}



			function form_submit(attr_str) {

				$.post($('.jwxh_form_data').attr(attr_str), $('.jwxh_form_data').serialize(),function (data){

					if(!data.status){

						alert(data.info);

					} else {

						alert(data.info);

						setTimeout("location.href = '"+data.url+"'",200);

					}

				},'json');

			}



		});

</script>


<div style="display:none;">

	<script src="http://s11.cnzz.com/z_stat.php?id=1257842329&web_id=1257842329" language="JavaScript"></script>

</div>



</body>

</html>