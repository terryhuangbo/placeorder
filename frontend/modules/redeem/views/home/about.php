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
    <link rel="stylesheet" type="text/css" href="/css/guanyuwomen.css">
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
        <img src="/images/logo.png" class="logo">
    </header>
    <div class="title">尚飞创新：让您的生活更幸福</div>
    <div class="small">10％销售收入会用于创新研发</div>
    <div class="text">每天都有400名尚飞工程师在不断探索和发现如何让您的家更为舒适和安全。每年都有400项专利诞生，从他们的渴望到创新，只为让您拥有更好的生活。就如：尚飞TaHoma One智能家居控制系统，只需轻轻一触，即可通过网络控制您家中所有的家居设备。</div>
    <div class="video">
        <video controls>
            <source src="/images/video.mp4" type="video/mp4">
        </video>
    </div>
    <div class="title">尚飞，从一家小型法国公司<br>到逐渐占据世界领先地位的品牌故事</div>
    <div class="text">创建于1969年，尚飞是一家法国集团，起源于Haute Savoie地区，位于Cluses，属于Arve valley的心脏区域。<br>尚飞始终忠于自己的价值观，现已遍布60多个国家，成为世界领先的家用和商用门窗自动化行业，拥有超过1亿个电机已销往世界各地。</div>
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