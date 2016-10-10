<?php
use yii\helpers\ArrayHelper;
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit"/>
    <title><?= ArrayHelper::getValue($site, 'site_name', '') ?></title>
    <meta name="keywords" content="<?= ArrayHelper::getValue($site, 'seo_keywords', '') ?>"/>
    <meta name="description" content="<?= ArrayHelper::getValue($site, 'seo_desc', '') ?>"/>

    <!--reset.css  header.css  footer.css-->
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/swiper/css/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/public/resetcss/mreset.css"/>
    <link rel="stylesheet" type="text/css" href="/css/maker-mobile.css"/>
    <!--jquery-->
    <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/public/fontSize/fontSize.js"></script>
    <!--cookie domain-->
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
</head>
<body class='grey-bg'>
<?php if($action=="index"||$action=="mindex"){?>
<!--ads-->
<div class="mo-ads mobile-box hide"></div>
<!--/ads-->
<?php }?>
<!--fix top-->
<div class="mo-fixtop">
    <!--header-->
    <header class="mobile-box mo-header clearfix">
        <a href="http://maker.vsochina.com/m/index" class="mo-header-logo">
            <img src="/images/mobile/mobile-logo.png">
        </a>
        <a href="<?php echo isset($user_info['avatar']) ? 'javaScript:viod(0)' : 'http://account.vsochina.com/user/login';?>" class="mo-header-portrait">
            <img src="<?= ArrayHelper::getValue($user_info, 'avatar', '/images/mobile/mobile-portrait.png') ?>">
        </a>
    </header>
    <!--header-->
    <!--nav-->
    <ul class="mobile-box mo-nav clearfix">
        <li class="<?= ($action == 'mindex'||$action == 'index') ? 'active' : '' ;?>"><a href="http://maker.vsochina.com/m/index">首页</a></li>
        <li class="<?= $action == 'mlist' ? 'active' : '' ;?>"><a href="http://maker.vsochina.com/m/list">项目</a></li>
        <li class="<?= $action ==  'mrank' ? 'active' : '' ;?>"><a href="http://maker.vsochina.com/m/rank">排行榜</a></li>
        <li class="<?= $action == 'mactivity' ? 'active' : '' ;?>"><a href="http://maker.vsochina.com/m/activity">活动</a></li>
        <li class="<?= $action == 'mquanzi' ? 'active' : '' ;?>"><a href="http://maker.vsochina.com/m/circle">圈子</a></li>
    </ul>
    <!--/nav-->
</div>
<!--/fix top-->