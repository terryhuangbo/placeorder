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
    <link rel="stylesheet" type="text/css" href="/css/jifenguanli.css">
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
        积分管理
    </header>
    <div class="header-box">
        <div class="head_portrait">
            <img src="<?php echo $user['avatar'] ?>">
        </div>
        <div class="basic">
            <div class="name"><?php echo $user['name'] ?></div>
            <div class="integral">我的积分：<span><?php echo $user['points'] ?></span></div>
        </div>
    </div>
    <table class="box" cellspacing="0">
        <tr>
            <th>日期</th>
            <th>积分</th>
            <th>操作</th>
        </tr>
        <?php foreach($record_list as $record): ?>
            <tr>
                <td><?php echo date('Y-m-d', $record['create_at']) ?></td>
                <td><?php echo $record['points'] > 0 ? '+' . $record['points'] : $record['points']  ?></td>
                <td><?php echo $record['points_name'] ?></td>
            </tr>
        <?php endforeach ?>
    </table>
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