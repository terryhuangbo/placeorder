<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo getValue($meta, 'site_name', '') ?></title>
    <meta name="keywords" content="<?php echo $meta['site_keywords'] ?>"/>
    <meta name="description" content="<?php echo $meta['site_description'] ?>"/>
    <link href="/static/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/css/bootstrap-theme.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/jwxh.css">
<style>
    .navbar-fixed-top, .navbar-fixed-bottom {
    z-index: 0;
    }
    /*水青色配色方案*/
    .login_page,body{background-image:url(/static/image/5714fd44b97e1.jpg);
    background-repeat:repeat}
    .menu,footer{background-color:#40cfe8}
    #login h2,.vertical-center .panel-title{background-color:#19d8eb}
    .btn{background-color:#2dd9ae!important}
    .div_url{padding-right:12px;padding-left:12px;max-width:165px}
    .thumbnail a{height:180px}
    .alert-danger{color:#007e94;background-color:#b4eef8;border-color:#40d0e8;background-image:none}
    .login_page,body {
        background-image: url("<?php echo yiiParams('img_host') . getValue($meta, 'site_bgimg', '') ?>");
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
					<h2><a href="<?php echo yiiUrl('/plorder/goods/index') ?>">新版post社区</a></h2>
				</div>
				<div class="col-md-4 col-sm-5 col-xs-5 text-right">
					<span class="nav_top_right"><a href="<?php echo yiiUrl('/plorder/goods/index') ?>">切换到首页</a></span>
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
							空间人气快刷
                        </h2>
					</div>

<!--					<form method="post" class="jwxh_form_data kmcz_cye" cardno_login_action="/index.php?m=Home&c=Card&a=login&id=350&goods_type=6" username_login_action="/index.php?m=Home&c=User&a=login&id=350&goods_type=6" user_sendpass_action="/index.php?m=Home&c=User&a=sendpass" username_register_action="/index.php?m=Home&c=User&a=register&id=350&goods_type=6" check_cardno_ajax_href="/index.php?m=Home&c=Card&a=cardinfo_no&id=350&goods_type=6" >-->
					<form method="post" class="jwxh_form_data kmcz_cye" onsubmit="return false">
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

                                    <p class="login_form_cardno_group_password" style="display:block;">
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
                                      <div class="form-group">必须访问邮箱中的连接一次才会将密码成功修改的哟~</div>
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
                                                  <input type="radio" name="reg_sex" value="1" checked>男生
                                                  <input type="radio" name="reg_sex" value="2">女生
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

<!--底部-->
<footer class="navbar-fixed-bottom hidden-xs hidden-sm">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-6 col-xs-6">
              <span><?php echo $meta['site_copyright'] ?>
                  <span class="hidden-xs hidden-sm">. All Rights Reserved</span>
              </span>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-6 text-right"><?php echo $meta['site_icp'] ?></div>
        </div>
    </div>
</footer>

<script src="/static/js/jquery.min.js"  type="text/javascript" charset="utf-8"></script>
<script src="/static/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/tools.js"  type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
    jQuery(document).ready(function() {
        $('.card_login_btn').click(function (e) {
            //卡密登录之前,先测试下有没有密码
            var param = {};
            var cardno = $.trim($("[name=cardno]").val());
            param.card_bn = cardno;
            if($("div.login_form_cardno_group_password:visible").length > 0){
                var password = $.trim($("[name=password]").val());
                param.pwd = password;
            }

            $._ajax('/plorder/user/card-login', param, 'POST', 'JSON', function(json){
                if(json.code > 0){
                    window.location.href = json.data.redirect_url || "/plorder/order/index";
                }else{
                    //输入卡密密码
                    if(json.code == -20004){
                        $('.login_input_cardno_password').attr('placeholder','有密码，请输入此卡密密码！');
                        $("div.login_form_cardno_group_password").show();
                    }else{
                        $(".card_login_btn").closest('p')._error(json.msg, 'p', 'prepend');
                    }
                }
            });
        });

        $('.username_login_btn').click(function (e) {
            var param = {};
            var username = $.trim($("[name=username]").val());
            var password = $.trim($("[name=username_password]").val());
            if(username == ''){
                $("[name=username]").closest('div')._error('账号不能为空');
                return
            }
            if(password == ''){
                $("[name=username_password]").closest('div')._error('密码不能为空');
                return
            }
            param = {
                username: username,
                pwd: password
            };
            $._ajax('/plorder/user/login', param, 'POST', 'JSON', function(json){
                if(json.code > 0){
                    window.location.href = json.data.redirect_url || "/plorder/order/index";
                }else{
                    $(".username_login_btn").closest('p')._error(json.msg, 'p', 'prepend');
                }
            });
            return false;
        });

        $('.user_sendpass_btn').click(function (e) {
            var username = $.trim($("[name=sendpass_username]").val());
            if(username == ''){
                $("[name=sendpass_username]").closest('div')._error('账号不能为空');
                return
            }
            $._ajax('/plorder/user/reset', {username:username}, 'POST', 'JSON', function(json){
                if(json.code > 0){
                    $(".user_sendpass_input").closest('div')._error('邮件发送成功，请及时到邮箱查收！');
                }else{
                    $(".user_sendpass_input").closest('div')._error(json.msg);
                }
            });
        });

        $('.username_register_btn').click(function (e) {
            var param = {};
            var username = $.trim($("[name=reg_username]").val());
            var password = $.trim($("[name=reg_password]").val());
            var sex = $("[name=reg_sex]:checked").val();
            var qq = $("[name=reg_qq]").val();
            if(username == ''){
                $("[name=reg_username]").closest('div')._error('账号不能为空');
                return
            }
            if(password == ''){
                $("[name=reg_password]").closest('div')._error('密码不能为空');
                return
            }
            if(qq == ''){
                $("[name=reg_qq]").closest('div')._error('QQ不能为空');
                return
            }
            param = {
                username: username,
                pwd: password,
                gender: sex,
                qq: qq
            };
            $._ajax('/plorder/user/reg', param, 'POST', 'JSON', function(json){
                if(json.code > 0){
                    alert('注册成功');
                    window.location.href = "/plorder/order/index";
                }else{
                    $(".username_register_btn").closest('p')._error(json.msg, 'p', 'prepend');
                }
            });
            return false;
        });

        $('.to_home_btn').click(function (e) {
            location.href = '/';
            return false;
        });

    });
</script>

<div style="display:none;">
	<script src="http://s11.cnzz.com/z_stat.php?id=1257842329&web_id=1257842329" language="JavaScript"></script>
</div>
</body>
</html>