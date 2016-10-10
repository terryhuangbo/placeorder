<?php
    $obj_username = $this->context->obj_username;  // 被访问用户
    $vso_uname = $this->context->vso_uname;    // 登录用户
    $is_self = $this->context->is_self;
    $user_info = $this->context->user_info;
    $controller = yii::$app->controller->id;
//    $ent_auth_status = isset($this->context->user_info['auth_enterprise_record']['auth_status']) ? $this->context->user_info['auth_enterprise_record']['auth_status'] : 3;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="renderer" content="webkit"/>
        <link rel="shortcut icon" href="<?= $user_info['avatar'] ?>" type="image/x-icon"/>
        <title><?php if(!empty(Yii::$app->view->params['_page_config']['title'])){echo Yii::$app->view->params['_page_config']['title'];}else{echo $_title;}?></title>
        <meta name="keywords" content="<?php if(!empty(Yii::$app->view->params['_page_config']['keyword'])){echo Yii::$app->view->params['_page_config']['keyword'];}else{echo "";}?>"/>
        <meta name="description" content="<?php if(!empty(Yii::$app->view->params['_page_config']['description'])){echo Yii::$app->view->params['_page_config']['description'];}else{echo "";}?>"/>
        <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/webuploader/0.1.5/expressInstall.css">
        <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/webuploader/0.1.5/webuploader.css">
        <link type="text/css" rel="stylesheet" href="/css/dreamSpace.css" />
        <link rel="stylesheet" type="text/css" href='http://www.vsochina.com/resource/css/userWork/userwork.css' />
        <link rel="stylesheet" type="text/css" href="/css/talent_comm.css">
        <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
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

            var _SAVESIGNITURE_URL ="<?= yii::$app->urlManager->createUrl('/personal/index/save-signture/')?>";
            var  _OBJUSERNAME = "<?= $this->context->obj_username ?>";
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
        <div class="theme-nav-fixed">
            <?php if(in_array($controller,['index','worklist','record'])) { ?>
                <a href="<?= yii::$app->params['rc_frontendurl'] ?>" class="btn btn-darkgrey pull-right"><i class="glyphicon glyphicon-home"></i> &nbsp;人才库首页</a>
            <?php } else if(in_array($controller,['goods'])) { ?>
                <a href="<?= yii::$app->params['shop_frontendurl'] ?>" class="btn btn-darkgrey pull-right"><i class="glyphicon glyphicon-home"></i> &nbsp;商城首页</a>
            <?php }?>
            <?php if($this->context->is_self){?>
                <?php if(in_array($controller, ['index','worklist','record'])){?>
                    <a href="<?= yii::$app->urlManager->createUrl("personal/skin/index")?>" class="btn btn-darkgrey pull-right"><i class="glyphicon glyphicon-cog"></i> &nbsp;主页设置</a>
                <?php }?>
                    <a href="<?= yii::$app->urlManager->createUrl("personal/work/create");?>" class="btn btn-darkgrey pull-right"><i class="glyphicon glyphicon-send"></i> &nbsp;发布作品</a>
            <?php }?>
        </div>
        <div class="content-bg">
            <div class="theme-left">
                <div class="talent-info-table">
                    <div class="talent-info-cell">
                        <div class="talent-info">
                            <div class="talent-top-left">
                                <span href="javascript:void(0)" class="head-130">
                                    <a href="<?= yii::$app->urlManager->createUrl('/personal/index/index') ?>"><img src="<?= $user_info['avatar'] ?>" alt=""></a>
                                </span>
                                <p class="username-p">
                                <span class="username">
                                    <a href="<?= yii::$app->urlManager->createUrl('/personal/index/index') ?>"><?= $user_info['nickname'] ?>
                                    <i class="icon-20 <?= $user_info['auth_sex'] == 1 ? 'icon-gender-boy' : ($user_info['auth_sex'] == 2 ? 'icon-gender-girl' : '') ?>"></i>
                                    <i class="icon-20 <?= $user_info['isvip'] ? 'icon-vip' : '' ?>"></i></a>
                                </span>
                                </p>
                                <p class="mold-p">
                                    <?= $user_info['indus_name'] ?>
                                </p>
                                <?php if(!empty($vso_uname)&&($vso_uname == $obj_username)){?>
                                    <div class="message-p self">
                                        <div class="message-p-bg"></div>
                                        <i class="icon-14 icon-14-bluepencil"></i>
                                        <input class="message-p-input" type="text" placeholder="写点什么吧" value="<?= $user_info['signture'] ?>" maxlength="50">
                                        <span class="message-p-txt"><?php echo !empty($user_info['signture'])?$user_info['signture']:'写点什么吧' ?></span>
                                    </div>
                                <?php } else {?>
                                    <div class="message-p visitor">
                                        <div class="message-p-bg"></div>
                                        <p class="message-p-msg"><?php echo !empty($user_info['signture'])?$user_info['signture']:'这个人很懒，什么也没留下...' ?></p>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="talent-top-right">
                                <?php if(!$this->context->is_self){?>
                                <p class="action-p clearfix">

                                    <a href="javascript:;" onclick="showMessageWindow()"> <i class="icon-24 icon-24-mail"></i> 私信</a>
                                        <?php if(in_array($obj_username,$my_favors)){?>                                                                     <a href="javascript:void(0)"onclick="unfavor('<?=$obj_username?>','<?=$user_info['uid']?>')" id="<?=$obj_username?>" ><i class="icon-24 icon-24-hart"></i> 取消关注</a>
                                    <?php } elseif(!empty($vso_uname)) {?>
                                        <a href="javascript:void(0)" onclick="favor('<?=$obj_username?>','<?=$user_info['uid']?>')" id="<?=$obj_username?>"><i class="icon-24 icon-24-hart"></i> 加关注</a>
                                    <?php } else {?>
                                    <a href="<?= yii::$app->params['create_service']. $obj_username ?> "><i class="icon-24 icon-24-hart"></i> 加关注</a>
                                    <?php }?>
                                     <?php if(empty($vso_uname)) {?>
                                    <a href="<?=yii::$app->params['create_service']?>"><i class="icon-24 icon-24-hire"></i>雇佣</a>
                                    <?php } else {?>
                                    <a href="javascript:void(0)" onclick="dxtender('<?=$obj_username?>')" ><i class="icon-24 icon-24-hire"></i>雇佣</a>
                                        <i class="icon-square"></i>
                                    </p>
                                <?php }} ?>
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
                    <a href="<?= yii::$app->urlManager->createUrl('/personal/index/index') ?>" <?php if(in_array($controller, ['index', 'work'])):?>class="active"<?php endif;?>>动态</a> /
                    <a href="<?= yii::$app->urlManager->createUrl('/personal/worklist/index/')?>" <?php if($controller=='worklist'):?>class="active"<?php endif;?>>作品集</a> /
                    <?php if($this->context->user_info['has_shop']): ?>
                    <a href="<?= yii::$app->urlManager->createUrl('/personal/goods/index/')?>" <?php if($controller=='goods'):?>class="active"<?php endif;?>>可售商品</a>/
                    <?php endif ?>
                    <a href="<?= yii::$app->urlManager->createUrl('/personal/record/view/')?>" <?php if($controller=='record'):?>class="active"<?php endif;?>>交易记录</a>
                    <?php $count_personal_links = count($user_info['personal_links']);?>
                    <?php if ($count_personal_links > 0):?> /
                    <?php foreach($user_info['personal_links'] as $k => $val) {?>
                        <a href="<?= $val['link_url'] ?>"><?= $val['link_name'] ?></a> <?php if ($k != $count_personal_links - 1):?> / <?php endif;?>
                    <?php } ?>
                    <?php endif;?>
                    <br class="clear">
                </div>
                <!--/导航栏-->

                <script type="text/javascript">
                    $(function(){
                        $(".message-p-input").outerWidth($('.message-p-txt').outerWidth());
                        $(".message-p-input").on('keydown', function(event) {
                            var el = $(this);
                            var _input = $(this),
                                myHtml = _input.val(),
                                _span = _input.next('.message-p-txt'),
                                spanW;
                            _span.html(myHtml);
                            spanW = _span.outerWidth() + 10;
                            if(_span.outerWidth() <= 430)
                            {
                                _input.outerWidth(spanW);
                            }
                            else
                            {
                                _input.outerWidth(430);
                            }
                            if(event.keyCode==13){
                                el.trigger("blur");
                            }
                        });
                        $(".message-p-input").on('keyup', function(event) {
                            var _input = $(this),
                                _span = _input.next('.message-p-txt'),
                                myHtml = _input.val(),
                                spanW;
                            _span.html(myHtml);
                            spanW = _span.outerWidth() + 10;
                            if(_span.outerWidth() <= 430)
                            {
                                _input.outerWidth(spanW);
                            }
                            else
                            {
                                _input.outerWidth(430);
                            }
                        });
                    });

                    $(".message-p-input").on('blur', function(event) {
                        var _this  = $(this),
                            _span = _this.next(".message-p-txt"),
                            value = _this.val();
                            param = {};
                            param.signture = $.trim(value);
                            param.username = _OBJUSERNAME;
                        if(param.signture== "")
                        {
//                            _this.val("写点什么吧fds");
                            _span.html("写点什么吧");
                            _this.outerWidth(_span.outerWidth());
                            return;
                        }else{
                            $.ajax({
                                type: "get",
                                url: _SAVESIGNITURE_URL,
                                dataType: "json",
                                data: param,
                                success: function(json){
                                    if(!json.success){
                                        alert(json.msg);
                                    }
                                }
                            });
                        }
                    });
                </script>