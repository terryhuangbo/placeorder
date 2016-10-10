<?php
use yii\helpers\Json;
?>
<script type="text/javascript">
<?php
    $navData = backend\modules\content\models\Nav::getNavData();
    echo "var indexNavData=" . Json::encode($navData);
?>
</script>
<div class="ds-header clearfix">
    <div class="ds-1200">
        <div class="ds-logo">
            <?= \backend\modules\content\models\Site::getSiteLogo(1);?>
        </div>
        <div class="ds-header-right">
            <div class="maker-static-img">
                <img src="/images/maker-static-logo.png" alt="在线创作创客空间">
            </div>
            <div class="ds-share">
                <div class="w-baidu-share">
                    <div class="bdsharebuttonbox">
                        <a title="分享到QQ" class="bds_sqq" data-cmd="sqq"></a>
                        <a title="分享到QQ空间" class="bds_qzone" data-cmd="qzone"></a>
                        <a title="分享到新浪微博" class="bds_tsina" data-cmd="tsina"></a>
                        <a title="分享到腾讯微博" class="bds_tqq" data-cmd="tqq"></a>
                        <a title="分享到人人网" class="bds_renren" data-cmd="renren"></a>
                        <a title="分享到微信" class="bds_weixin" data-cmd="weixin"></a>
                        <a class="bds_more" data-cmd="more"></a>
                    </div>
                </div>
            </div>
            <br class="clear">
            <ul class="ds-nav">
                <?php $navList = \backend\modules\content\models\Nav::getNavData();?>
                <?php if(count($navList) > 0):?>
                    <?php foreach($navList as $k => $v):?>
                        <?php $has_children = isset($v['children']) ;?>
                        <li<?php if($has_children):?> class="ds-mine"<?php endif;?>>
                            <?php $route = yii::$app->controller->module->module->requestedRoute;?>
                            <?php if($v['link_type'] == 0):?>
                                <a href="<?php if($v['link']):?><?= $v['link']?><?php else:?>javascript:void(0);<?php endif;?>" <?php if($has_children):?> class="ds-mine-link"<?php endif;?>>
                                    <?= $v['label'] ?>
                                    <?php if($has_children):?>
                                        <i class="icon-10 arrow-down"></i>
                                    <?php endif;?>
                                </a>
                            <?php elseif($v['link_type']==1):?>
                                <a href="<?php if($v['link']):?><?= $v['link']?><?php else:?>javascript:void(0);<?php endif;?>" <?php if($v['link_type'] == 1):?> target="_blank"<?php endif;?> <?php if($has_children):?> class="ds-mine-link"<?php endif;?>>
                                    <?= $v['label'] ?>
                                    <?php if($has_children):?>
                                        <i class="icon-10 arrow-down"></i>
                                    <?php endif;?>
                                </a>
                            <?php elseif($v['link_type']==2 && $route == ''):?>
                                <a href="<?php if($v['link']):?><?= $v['link']?><?php else:?>javascript:void(0);<?php endif;?>" <?php if($has_children):?> class="ds-mine-link"<?php endif;?>>
                                    <?= $v['label'] ?>
                                    <?php if($has_children):?>
                                        <i class="icon-10 arrow-down"></i>
                                    <?php endif;?>
                                </a>
                            <?php endif;?>
                            <!--<a href="<?php /*if($v['link']):*/?><?/*= $v['link']*/?><?php /*else:*/?>javascript:void(0);<?php /*endif;*/?>" <?php /*if($v['link_type'] == 1):*/?> target="_blank"<?php /*endif;*/?> <?php /*if($has_children):*/?> class="ds-mine-link"<?php /*endif;*/?>>
                                <?/*= $v['label'] */?>
                                <?php /*if($has_children):*/?>
                                <i class="icon-10 arrow-down"></i>
                                <?php /*endif;*/?>
                            </a>-->
                            <?php if($has_children):?>
                            <div class="ds-mine-box">
                                <i class="triangle-top"></i>
                                <?php foreach ($v['children'] as $ck => $cv):?>
                                    <a href="<?php if($cv['link']):?><?= $cv['link']?><?php else:?>javascript:void(0);<?php endif;?>" <?php if($cv['link_type'] == 1):?> target="_blank"<?php endif;?> <?php if($ck == count($v['children']) - 1):?> class="last"<?php endif;?>>
                                        <?= $cv['label'] ?>
                                    </a>
                                <?php endforeach;?>
                            </div>
                            <?php endif;?>
                        </li>
                    <?php endforeach;?>
                <?php endif;?>
                <?php $userlimit = \frontend\modules\project\models\Project::indexlimi() ?>
                <?php if ($userlimit){ ?>
                <li><a href="http://maker.vsochina.com/project/19">孵化项目</a></li>
                <?php } ?>
                <li class="ds-search-li">
                    <div class="ds-search">
                        <div class="ds-search-bg"></div>
                        <i class="ds-icon-16 ds-icon-search" onclick=""></i>
                        <input type="text" value="" id="">
                    </div>
                </li>
                <li class="ds-block-li"><span class="ds-icon-16 ds-icon-block"></span></li>
            </ul>
        </div>

        <div class="ds-menu">
            <div class="ds-menu-bg"></div>
            <div class="ds-menu-content">
                <div class="ds-menu-news">
                </div>
                <div class="ds-menu-link">
                    <p class="ds-menu-title">平台导航</p>
                    <a target="_blank" href="http://www.vsochina.com/task.html" class="first"><b>·</b>任务大厅</a>
                    <a target="_blank" href="http://create.vsochina.com/"><b>·</b>创客空间</a>
                    <a target="_blank" href="http://render.vsochina.com/"><b>·</b>渲染农场</a>
                    <a target="_blank" href="http://www.vsochina.com/shop_list.html"><b>·</b>创意商城</a>
                    <a target="_blank" href="http://bbs.vsochina.com"><b>·</b>文创论坛</a>
                </div>
                <div class="ds-menu-manage">
                    <p class="ds-menu-title">项目管理</p>
                    <a target="_blank" href="http://cz.vsochina.com"><i class="icon-24 icon-24-xm"></i>进入项目</a>
                    <p class="ds-menu-title">云盘</p>
                    <a target="_blank" href="http://pan.vsochina.com"><i class="icon-24 icon-24-yunpan"></i>进入云盘</a>
                    <p class="ds-menu-title">云会议</p>
                    <a target="_blank" href="http://create.vsochina.com/meeting"><i class="icon-24 icon-24-huiyi"></i>云会议</a>
                </div>
                <div class="ds-menu-app">
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        load_app_list();
        load_news();
    });

    function load_app_list() {
        $.ajax({
            type: "POST",
            dataType: "json",
            async: false,
            url: "/app/default/recom-list",
            success: function (json) {
                var html = '<p class="ds-menu-title">云应用</p>';
                if (json.length > 0) {
                    for (var i = 0; i < json.length; i++) {
                        html += '<a target="_blank" href="http://create.vsochina.com/app/detail/' + json[i].id + '">\
                                <img src="' + json[i].img_url_cover + '" alt="' + json[i].name + '" width="50" height="50">\
                            </a>';
                    }
                }
                html += '<a target="_blank" href="http://create.vsochina.com/app/lst" class="ds-menu-app-more">…<br>更多</a>';
                $(".ds-menu-app").append(html);
            }
        });
    }

    function load_news() {
        $.ajax({
            type: "POST",
            async: false,
            url: "/news/default/news-list",
            dataType: "json",
            async: true,
            success: function (json) {
                var html = '<p class="ds-menu-title">最新资讯</p>';
                $.each(json, function (i, val) {
                    html += "<a target='_blank' href=" + val.link + ">" + val.title + "<i class='icon-14 icon-new'></i></a>";
                });
                $(".ds-menu-news").html(html);
            },
            fail: function (json) {
            }
        });
    }

    $(function () {
        var pname = window.location.pathname;
        if ((pname === '/project/default/index') || (pname === '/')) {
            $('.ds-nav .first').addClass('active').siblings().removeClass('active');
        }
        else if (pname === '/activity/million/intro') {
            $('.ds-nav .dreamintro').addClass('active').siblings().removeClass('active');
        }
        else if(pname === '/project/default/my-project') {
            $('.ds-nav .ds-mine-link').addClass('active').siblings().removeClass('active');
        }
    });

    window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16","bdPopupOffsetLeft":"-210"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
</script>