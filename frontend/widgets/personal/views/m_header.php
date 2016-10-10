<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit"/>
    <title></title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />

    <!--reset.css  header.css  footer.css-->
    <link rel="stylesheet" href="http://static.vsochina.com/libs/swiper/css/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/public/resetcss/mreset.css"/>
    <link rel="stylesheet" type="text/css" href="/css/rc_mobile_person.css"/>
    <!--jquery-->
    <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://static.vsochina.com/public/fontSize/fontSize.js"></script>
    <!--cookie domain-->
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
</head>
<body class="rc-grey-bg">
    <?php
        $action = yii::$app->controller->action->id ;
        $user_info = $this->context->user_info;
        $obj_username = $this->context->obj_username;  // 被访问用户
        $vso_uname = $this->context->vso_uname;    // 登录用户
        $is_self = $this->context->is_self;
    ?>
    <?php if( in_array($action, ['index', 'mabout'])){ ;?>
        <div class="rc-person-head">
            <p class="rc-person-num"><span class="color-green"><?= $user_info['focus_num'] ?></span> 粉丝 · <span class="color-green"><?= $user_info['views'] ?></span> 浏览</p>
            <div class="rc-person-img"><img src="<?= $user_info['avatar'] ?>"><i class="icon39 <?= $user_info['auth_sex']==1 ? 'icon-male' : 'icon-nvxing' ?>"></i></div>
            <p class="rc-person-name"><?= $user_info['nickname'] ?></p>
            <?php
                $city=$user_info['city'] ? $user_info['city'] : ($user_info['province'] ? $user_info['province']: '');
                $auth_page_post= $user_info['auth_age_post'] ? $user_info['auth_age_post'] : '';
                $auth_constellation= $user_info['auth_constellation'] ? $user_info['auth_constellation'] : '';
            ?>
            <p class="rc-person-style"><?=$city ?><?=($city&&$auth_page_post)?' · ':''?><?=$auth_page_post ?><?=empty($auth_page_post)?'':' · '?><?=$auth_constellation?></p>

            <?php if(!$is_self){?>
                <?php if(in_array($obj_username, $my_favors)){?>
                    <a href="javascript:void(0)" onclick="unfavor('<?=$obj_username?>','<?=$user_info['uid']?>')" id="<?=$obj_username?>" class="rc-person-btn btn-grey">取消关注</a>
                <?php } elseif(!empty($vso_uname)) {?>
                    <a href="javascript:void(0)" onclick="favor('<?=$obj_username?>','<?=$user_info['uid']?>')" id="<?=$obj_username?>" class="rc-person-btn">＋关注</a>
                <?php } else {?>
                    <a href="<?=yii::$app->params['loginUrl']?>" class="rc-person-btn">＋关注</a>
                <?php }?>
            <?php } ?>
            <div class="rc-half-btn-group clearfix">
                <a href="<?= yii::$app->params['rc_frontendurl'] ?>/personal/index/<?= $obj_username ?>" class="rc-half-btn <?php echo $action=='index' ? 'active' : '' ;?>">作品</a>
                <a href="<?= yii::$app->params['rc_frontendurl'] ?>/personal/mabout/<?= $obj_username ?>"  class="rc-half-btn <?php echo $action=='mabout' ? 'active' : '' ;?>">关于<?= $user_info['auth_sex']==1 ? '他' : '她' ?></a>
            </div>
        </div>
    <?php } ;?>
    <!--header-->
<script type="text/javascript">
    function favor(obj_name, id)
    {
        var currentUrl = window.location.href ;
        $.ajax({
            url: "/rc/search/favor",
            dataType: 'json',
            data: {redirect:currentUrl,obj_name: obj_name, id: id},
            success: function (data) {
                if (data.ret == 13380)
                {
                    $('#' + obj_name).removeAttr("onclick");
                    $('#' + obj_name).html("取消关注");
                    $('#' + obj_name).addClass("btn-grey");
                    $('#' + obj_name).attr("onclick", "unfavor('" + obj_name + "','" + id + "')");
                    $('#focus_num').html(data.focus_num);
                }else if(data.ret===13381||data.ret===13382){
                    window.location.href="http://account.vsochina.com/user/login";
                } else {
                    alert(data.message);
                }
            }
        });
    }
    function unfavor(obj_name, id)
    {
        var currentUrl=$("#currentUrl").val();
        $.ajax({
            url: "/rc/search/un-favor",
            dataType: 'json',
            data: {redirect:currentUrl, obj_name: obj_name, id: id},
            success: function (data) {
                if (data.ret == 13400) {
                    $('#' + obj_name).removeAttr("onclick");
                    $('#' + obj_name).html("加关注");
                    $('#' + obj_name).removeClass("btn-grey");
                    $('#' + obj_name).attr("onclick", "favor('" + obj_name + "','" + id + "')");
                    $('#focus_num').html(data.focus_num);
                }else if(data.ret===13381||data.ret===13382){
                    window.location.href="http://account.vsochina.com/user/login";
                } else {
                    alert(data.message);
                }
            }});
    }
</script>