<!--导航栏-->
<div class="theme-nav">
    <?php if (isset($user_info['index']) && $user_info['index'] == 'index')
    { ?>
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
    <a href="<?= yii::$app->params['rc_frontendurl'] ?>/personal/index/<?= $user_info['username'] ?>" class="active">动态</a> /
    <a href="<?= yii::$app->params['rc_frontendurl'] ?>/personal/index/works/<?= $user_info['username'] ?>">作品集</a> /
    <a href="<?= yii::$app->params['rc_frontendurl'] ?>/personal/record/view/<?= $user_info['username'] ?>">交易记录</a>
    <br class="clear">
</div>


<!--/导航栏-->