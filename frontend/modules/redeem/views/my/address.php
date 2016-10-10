<!DOCTYPE html>
<html>
<head>
    <title>尚飞积分商城</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="browsermode" content="application">
    <meta name="x5-page-mode" content="app">
    <link rel="stylesheet" type="text/css" href="/css/header.css">
    <link rel="stylesheet" type="text/css" href="/css/wodedizhi.css">
    <script src="/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $('.back').click(function(){
                history.back();
            });
        });
    </script>
</head>
<body>
<div class="body-All">
    <header>
        <div class="back"><a><img src="/images/back.png"></a></div>
        收货地址
    </header>
    <ul class="box">
        <?php foreach($list as $add): ?>
            <li>
                <div class="top">
                    <span><?php echo $add['receiver_name'] ?></span>&nbsp;&nbsp;
                    <span><?php echo $add['receiver_phone'] ?></span>&nbsp;
                    <?php if($add['is_default'] == \common\models\Address::DEFAULT_YES): ?>
                        <span class="default">默认</span>
                    <?php endif ?>
                </div>
                <div class="middle">
                    <span><?php echo $add['province'] ?></span>&nbsp;
                    <span><?php echo $add['city'] ?></span>&nbsp;
                    <span><?php echo $add['county'] ?></span>&nbsp;
                    <span><?php echo $add['detail'] ?></span>
                    <span class="edit"><a href="/redeem/address/update?uid=<?php echo $uid ?>&add_id=<?php echo $add['add_id'] ?>"><img src="/images/icon05.png"></a></span>
                </div>
                <div class="bottom">地址类型：<?php echo $add['type_name'] ?></div>
            </li>
        <?php endforeach ?>
    </ul>
    <div class="button"><a href="/redeem/address/add?uid=<?php echo $uid ?>" class="btn">新增地址</a></div>
</div>
</body>
<!--微信分享-->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    wx.config({
        debug: false,
        appId: '<?php echo $this->context->signPackage["appId"];?>',
        timestamp: <?php echo $this->context->signPackage["timestamp"];?>,
        nonceStr: '<?php echo $this->context->signPackage["nonceStr"];?>',
        signature: '<?php echo $this->context->signPackage["signature"];?>',
        jsApiList: [
            // 所有要调用的 API 都要加到这个列表中
            "onMenuShareAppMessage",
            "onMenuShareTimeline",
        ]
    });
    wx.ready(function () {
        // 在这里调用 API
        //发送给朋友
        wx.onMenuShareAppMessage({
            title: '', // 分享标题
            desc: '会员积分，超值兑换', // 分享描述
            link: '', // 分享链接
            imgUrl: '<?php echo yiiParams('share_img') ?>', // 分享图标
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
                $._ajax('/redeem/home/share', {}, 'POST', 'JSON', function(json){});
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
        //分享到朋友圈
        wx.onMenuShareTimeline({
            title: '', // 分享标题
            link: '', // 分享链接
            imgUrl: '<?php echo yiiParams('share_img') ?>', // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
                $._ajax('/redeem/home/share', {}, 'POST', 'JSON', function(json){});
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
    });
</script>
</html>