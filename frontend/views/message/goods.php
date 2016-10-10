<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title></title>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="renderer" content="webkit"/>
        <!--reset.css  header.css  footer.css-->
        <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css?v=20150807"/>
        <!--css-->
        <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.2.0/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="/css/popup.css">
        <!--jquery-->
        <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
        <script src="http://static.vsochina.com/libs/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <!--cookie domain-->
        <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
        <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
    </head>
    <body>
        <div class="hint-wrap">
            <div class="hint-imgbox">
                <img src="/images/message/hint.png" alt="提示">
            </div>
            <div class="hint-title">
                <?= $msg ?>
            </div>
            <dl class="hint-intro clearfix">
                <dt>你可以：</dt>
                <dd>1.尝试输入其他关键词搜索</dd>
                <dd>
                    2.去看看其他感兴趣的商品
                    <a class="hint-btn" href="<?php echo yii::$app->params['shop_frontendurl']?>">返回商城首页</a>
                </dd>
            </dl>
        </div>
    </body>
<script>
    $(document).ready(function () {
        var order_msg = '<?php echo $msg?>';
        if (order_msg == "") {
            window.location.href = "<?php echo yii::$app->params['shop_frontendurl']?>";
        }
    });
</script>
</html>