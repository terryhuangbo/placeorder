<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="renderer" content="webkit"/>
        <title>个人主页</title>
        <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/webuploader/0.1.5/expressInstall.css">
        <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/webuploader/0.1.5/webuploader.css">
        <link rel="stylesheet" type="text/css" href="/css/talent_comm.css">
        <link type="text/css" rel="stylesheet" href="/css/dreamSpace.css" />
        <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
        <?php
        $res =  \frontend\modules\personal\models\PersonalSkin::findOne(['username'=>$this->context->obj_username]);
        $per_skin = $res?['pc_id'=>$res->pc_id, 'mobile_id'=>$res->mobile_id]:['pc_id'=>1, 'mobile_id'=>2];
        ?>
        <script>
            var ua = navigator.userAgent;
            var ipad = ua.match(/(iPad).*OS\s([\d_]+)/),
                isIphone = !ipad && ua.match(/(iPhone\sOS)\s([\d_]+)/),
                isAndroid = ua.match(/(Android)\s+([\d.]+)/),
                isMobile = isIphone || isAndroid;
            var _PCID = <?= $per_skin['pc_id'] ?>;
            var _MOBILEID = <?= $per_skin['mobile_id'] ?>;
            var _SKINID = isMobile?_MOBILEID:_PCID;
            var _SKINTYPE = isMobile?1:0;
        </script>
        <script type="text/javascript" src="/js/talent_skin_edit.js"></script>
        <script src="http://static.vsochina.com/libs/jquery/1.8.3/jquery.min.js"></script>
        <!--[if lt IE 9]>
        <script src="http://static.vsochina.com/libs/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
        <script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
        <script type="text/javascript" src="/js/dreamSpace.js"></script>
    </head>
    <body>
        <?php
        $obj_username = $this->context->obj_username;  // 被访问用户
        $vso_uname = \frontend\modules\talent\models\User::getLoginedUsername();    // 登录用户
        $is_self = $this->context->is_self;
        $user_info = $this->context->user_info;
        $my_favors = \frontend\modules\personal\models\Person::getFavorList($vso_uname);
        $controller = yii::$app->controller->id;
        ?>
        <div class="theme-nav-fixed">
            <a href="<?= yii::$app->params['rc_frontendurl'] ?>" class="btn btn-darkgrey pull-right"><i class="glyphicon glyphicon-home"></i> &nbsp;返回首页</a>
            <?php if($this->context->is_self){?>
            <a href="<?= yii::$app->params['rc_frontendurl'] ?>/personal/skin/index/<?= $obj_username ?>" class="btn btn-darkgrey pull-right"><i class="glyphicon glyphicon-cog"></i> &nbsp;主页设置</a>
            <a href="<?= yii::$app->params['rc_frontendurl'] ?>/personal/work/create" class="btn btn-darkgrey pull-right"><i class="glyphicon glyphicon-send"></i> &nbsp;发布作品</a>
            <?php }?>
            <!-- 删除 -->
            <a href="javascript:void;" class="btn btn-darkgrey pull-right"><i class="glyphicon glyphicon-trash"></i></a>
            <!-- 编辑 -->
            <a href="javascript:void;" class="btn btn-darkgrey pull-right"><i class="glyphicon glyphicon-pencil"></i></a>
        </div>
        <div class="content-bg">
            <div class="theme-left">
                <div class="talent-info-table">
                    <div class="talent-info-cell">
                        <div class="talent-info">
                            <div class="talent-top-left">
                                <span href="javascript:void(0)" class="head-130">
                                    <img src="<?= $user_info['avatar'] ?>" alt="">
                                </span>
                                <p class="username-p">
                                <span class="username">
                                    <?= $user_info['nickname'] ?>
                                    <i class="icon-20 <?= $user_info['auth_sex'] == 1 ? 'icon-gender-boy' : ($user_info['auth_sex'] == 2 ? 'icon-gender-girl' : '') ?>"></i>
                                    <i class="icon-20 <?= $user_info['isvip'] ? 'icon-vip' : '' ?>"></i>
                                </span>
                                </p>
                                <p class="mold-p">
                                    <?= $user_info['indus_name'] ?>
                                </p>
                            </div>
                            <div class="talent-top-right">
                                <?php if(!$this->context->is_self){?>
                                <p class="action-p clearfix">

                                    <a href="javascript:;" onclick="showMessageWindow()"> <i class="icon-24 icon-24-mail"></i> 私信</a>
                                        <?php if(in_array($obj_username,$my_favors)){?>                                                                     <a href="javascript:void(0)"onclick="unfavor('<?=$obj_username?>','<?=$user_info['uid']?>')" id="<?=$obj_username?>" ><i class="icon-24 icon-24-hart"></i> 取消关注</a>
                                    <?php } elseif(!empty($vso_uname)) {?>
                                        <a href="javascript:void(0)" onclick="favor('<?=$obj_username?>','<?=$user_info['uid']?>')" id="<?=$obj_username?>"><i class="icon-24 icon-24-hart"></i> 加关注</a>
                                    <?php } else {?>
                                    <a href="<?=yii::$app->params['loginUrl']?>"><i class="icon-24 icon-24-hart"></i> 加关注</a>
                                    <?php }?>
                                     <?php if(empty($vso_uname)) {?>
                                <a href="<?=yii::$app->params['loginUrl']?>"><i class="icon-24 icon-24-hire"></i>雇佣</a>
                                <?php } else {?>
                                <a href="javascript:void(0)" onclick="dxtender('<?=$obj_username?>')" ><i class="icon-24 icon-24-hire"></i>雇佣</a>
                                <?php }?>
                                    <i class="icon-square"></i>
                                </p>
                                <?php } ?>
                                <?php
                                    $city=$user_info['city'] ? $user_info['city'] : ($user_info['province'] ? $user_info['province']: '');
                                    $auth_page_post= $user_info['auth_age_post'] ? $user_info['auth_age_post'] : '';
                                    $auth_constellation= $user_info['auth_constellation'] ? $user_info['auth_constellation'] : '';
                                    if($city||$auth_page_post||$auth_constellation)
                                    {
                                    ?>
                                <p class="info-p clearfix">
                                <span class="pull-right font14">
                                    <?=$city ?><?=($city&&$auth_page_post)?' · ':''?><?=$auth_page_post ?><?=empty($auth_page_post)?'':' · '?><?=$auth_constellation?></span>
                                    <i class="icon-square"></i>
                                </p>
                                <?php }?>
                                <?php if (!empty($user_info['lable']))
                                { ?>
                                    <p class="info-p clearfix">
                                        <?php foreach ($user_info['lable'] as $lable)
                                        { ?>
                                            <label for="" class="label-clarity"><?= $lable ?></label>
                                        <?php } ?>
                                        <i class="icon-square"></i>
                                    </p>
                                <?php } ?>
                                <!--    暂无                -->
                                <div class="info-p-left clearfix">
                                    <!--
                                        <p class="info-p clearfix">
                                            <span class="pull-right">32</span>
                                            <span class="pull-left" >人才排名</span>
                                        </p>
                                        <p class="info-p clearfix">
                                            <span class="pull-right">1232</span>
                                            <span class="pull-left" >热度</span>
                                        </p>
                                    -->
                                    <p class="info-p clearfix">
                                        <span class="pull-right" id="focus_num"><?= $user_info['focus_num'] ?></span>
                                        <span class="pull-left">粉丝数</span>

                                    </p>
                                    <i class="icon-square"></i>
                                </div>


                                <div class="info-p clearfix">
                                    <span class="pull-right">
                                        <div class="sharebox-new">
                                            <a class="weibo" data-cmd="tsina"></a>
                                            <a class="qq" data-cmd="qq"></a>
                                            <a class="zoom" data-cmd="qzone"></a>
                                            <a class="weixin" data-cmd="weixin">
                                                <div class="weixin-box">
                                                    <div class="pwx-triangle">
                                                        <span><em></em></span>
                                                    </div>
                                                    <div class="weixin-box-img"></div>
                                                    <p>创意云微信公众号</p>
                                                </div>
                                            </a>
                                        </div>
                                    </span>
                                    <span class="pull-left" >分享至&nbsp;&nbsp;&nbsp;</span>
                                    <i class="icon-square"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="theme-right">
                <div class="gradient-border"></div>
                <!--导航栏-->
                <div class="theme-nav">
                    <?php if (($this->context->id=='index'||($this->context->id=='worklist'
                            &&$this->context->action->id=='works'))&&($this->context->is_self)) { ?>
                        <div id="manage_action_before" class="pull-right">
                            <!--
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon2">
                                <span class="input-group-addon btn-green" id="basic-addon2"><i class="glyphicon glyphicon-search"></i></span>
                            </div>
                            -->
                            <a href="javascript:;" class="btn btn-green pull-right" id="manage_works"> <i class="glyphicon glyphicon-th"></i> &nbsp; 管理作品</a>
                        </div>
                        <div id="manage_action" class="pull-right">
                            <a href="javascript:;" class="btn btn-green pull-right" id="manage_action_save"> <i class="glyphicon glyphicon-log-in"></i> &nbsp; 退出管理</a>
                        </div>
                    <?php } ?>
                    <a href="<?= yii::$app->params['rc_frontendurl'] ?>/personal/index/<?= $obj_username ?>" <?php if(in_array($controller, ['index', 'work'])):?>class="active"<?php endif;?>>动态</a> /
                    <a href="<?= yii::$app->params['rc_frontendurl'] ?>/personal/worklist/index/<?= $obj_username ?>" <?php if($controller=='worklist'):?>class="active"<?php endif;?>>作品集</a> /
                    <a href="<?= yii::$app->params['rc_frontendurl'] ?>/personal/record/view/<?= $obj_username ?>" <?php if($controller=='record'):?>class="active"<?php endif;?>>交易记录</a>
                    <?php $count_personal_links = count($user_info['personal_links']);?>
                    <?php if ($count_personal_links > 0):?> /
                    <?php foreach($user_info['personal_links'] as $k => $val) {?>
                        <a href="<?= $val['link_url'] ?>"><?= $val['link_name'] ?></a> <?php if ($k != $count_personal_links - 1):?> / <?php endif;?>
                    <?php } ?>
                    <?php endif;?>
                    <br class="clear">
                </div>
                <!--/导航栏-->