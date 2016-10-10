<?php
use yii\helpers\Json;
//获取当前访问页面的module,controller,action名字
$moduleName = yii::$app->controller->module->id;
$controllerName = yii::$app->controller->id;
$actionName = yii::$app->controller->action->id;
?>
<script type="text/javascript">
<?php
    $navData = backend\modules\content\models\Nav::getNavData();
    echo "var indexNavData=" . Json::encode($navData);
    $site = \backend\modules\content\models\Site::getSiteSeo();
?>
</script>
<div class="dsn-header-top">
    <div class="ds-1200">
        <?php if (!empty($site) && isset($site['site_logo']) && !empty($site['site_logo'])): ?>
        <a href="http://maker.vsochina.com/" title="创意空间" style="float: left">
            <?= $site['site_logo'] ?>
        </a>
        <?php endif;?>
        <ul class="dsn-header-top-ul pull-right">
            <?php if($moduleName == 'home' && $controllerName == 'default' && $actionName == 'index'):?>
            <li class="cur">
            <?php else:?>
            <li>
            <?php endif;?>
               <a class="dsn-link" href="http://maker.vsochina.com/">首页</a>
            </li>
            <?php if($moduleName == 'project' && $controllerName == 'default' && $actionName == 'list'):?>
            <li class="cur">
            <?php else:?>
            <li>
            <?php endif;?>
                <a  href="http://maker.vsochina.com/project/default/list" class="dsn-link">项目</a>
                <!--
                <div class="dsn-link-drop">
                    <a href="" target="_blank">项目列表</a>
                    <a href="" target="_blank">项目入驻</a>
                </div>
                -->
            </li>
            <li>
                <a class="dsn-link">工具 <span class="dsn-triangle-up"></span></a>
                <div class="dsn-link-drop">
                    <!--<a target="_blank" href="http://create.vsochina.com">项目协同</a>-->
                    <a target="_blank" href="http://pan.vsochina.com">云&nbsp;&nbsp;&nbsp;盘</a>
                    <a target="_blank" href="http://create.vsochina.com/meeting">云会议</a>
                    <a target="_blank" href="http://create.vsochina.com/app/lst">云应用</a>
                    <a target="_blank" href="http://render.vsochina.com">云渲染</a>
                </div>
            </li>
            <?php if($moduleName == 'activity' && $controllerName == 'default' && $actionName == 'index'):?>
            <li class="cur">
            <?php else:?>
            <li>
            <?php endif;?>
                <a href="http://maker.vsochina.com/activity/default/index" class="dsn-link">活动</a>
            </li>
            <li>
                <a href="javascript:;" class="dsn-link">圈子<span class="dsn-triangle-up"></span></a>
                <div class="dsn-link-drop">
                    <a target="_blank" href="http://bbs.vsochina.com/forum.php?mod=forumdisplay&fid=45">动漫</a>
                    <a target="_blank" href="http://bbs.vsochina.com/forum.php?mod=forumdisplay&fid=44">影视</a>
                    <a target="_blank" href="http://bbs.vsochina.com/forum.php?mod=forumdisplay&fid=46">游戏</a>
                    <a target="_blank" href="http://bbs.vsochina.com/forum-94-1.html">小说</a>
                </div>
            </li>
            <li>
                <a href="javascript:;" class="dsn-link">申请入驻<span class="dsn-triangle-up"></span></a>
                <div class="dsn-link-drop">
                    <a target="_blank" href="/project/default/create">项目入驻</a>
                    <a target="_blank" href="http://rc.vsochina.com/rc/recruit/">人才入驻</a>
                </div>
            </li>
            <?php $userlimit = \frontend\modules\project\models\Project::indexlimi() ?>
            <?php if ($userlimit): ?>
                <li>
                    <a href="http://maker.vsochina.com/project/19" class="dsn-link">文创基金</a>
                </li>
            <?php endif; ?>
            <!--
            <li><a target="_blank" href="http://cz.vsochina.com/project/project?t=mp" class="dsn-link">申请孵化</a></li>-->
            <li class="dsn-login-before" style="padding-left: 0;"><a target="_blank" href="http://create.vsochina.com" class="dsn-link">我的工作室</a></li>
            <!--<li><a href="" class="dsn-link">关于我们</a></li>-->
            <li>
                <div class="dsn-btn-top" style="display: none">
                    <a target="_blank" href="http://cz.vsochina.com/" >我的工作室<!--<span class="dsn-triangle-up"></span>--></a>
                    <!--
                    <div class="dsn-link-drop">
                        <a target="_blank" href="http://account.vsochina.com/home">我的资料</a>
                        <a target="_blank" href="http://cz.vsochina.com/" ></a>
                        <a href="#" class="hlogout">退出登录</a>
                    </div>
                    -->
                </div>
                <div class="dsn-login-before-1" style="display: none"><a href="http://account.vsochina.com/user/login">登录</a><b> | </b><a href="http://account.vsochina.com/user/register">注册</a></div>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        init();
    });
    function loginState(){
        var uname = getCookie('vso_uname');
        var uid = getCookie('vso_uid');
        var usess = getCookie('vso_sess');
         if (uname != '' && uid != '' && usess != '' && uname != null && uid != null && usess != null) {
            return true;
         }else{
            return false;
         }
    }
    function init(){
        var logouturl = 'http://account.vsochina.com/user/logout?redirect=';
        var href = window.location.href;
        if (href.indexOf('?show_msg') > -1) {
            href = href.substring(0, href.indexOf('?show_msg'));
        }
        var redirect_url = encodeURIComponent(href);
        $(".headerLogin input[name=redirect]").val(redirect_url);
        $('.hlogout').attr('href', logouturl + redirect_url);
        if(loginState()){
            $(".dsn-btn-top").show();
            $(".dsn-login-before").hide();
        }else{
            $(".dsn-btn-top").hide();
            $(".dsn-login-before").show();
        }
    }
    /*导航栏 下拉菜单*/
    $(".dsn-header-top-ul li").hover(function(){
        $(this).addClass("active");
        $(this).siblings().removeClass("active");
    },function(){
        $(this).removeClass("active");
    });

</script>