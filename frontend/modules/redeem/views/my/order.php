<?php
use common\models\Order;
?>
<!DOCTYPE html>
<html>
<head>
    <title>【兑换】东芝U盘16G 速闪USB3.0 迷你防水创意车载优盘</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="browsermode" content="application">
    <meta name="x5-page-mode" content="app">
    <link rel="stylesheet" type="text/css" href="/css/header.css">
    <link rel="stylesheet" type="text/css" href="/css/wodedingdan.css">
    <script src="/js/jquery-1.11.3.min.js"></script>
    <script src="/js/tools.js"></script>
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
        我的订单
        <div class="home"><a href="/redeem/home/index"><img src="/images/home.png"></a></div>
    </header>
    <div class="menu">
        <span class="active" data-order_status="all" target="#quanbu">全部</span>
        <span data-order_status="payed">已支付</span>
        <span  data-order_status="topay">待支付</span>
    </div>
    <ul id="quanbuer" class="box " style="display: block">
        <?php foreach($order_list as $order): ?>
            <a href="<?php echo in_array($order['order_status'], [Order::STATUS_PAY, Order::STATUS_SEND])
                ? 'javaScript:void(0)' : '/redeem/logestic/detail?oid=' . $order['oid'] ?>">
                <li>
                    <div class="top">
                        <div class="number">订单编号：<?php echo $order['order_id'] ?></div>
                        <div class="time">交易时间：<?php echo date('Y/m/d', $order['create_at']) ?></div>
                    </div>
                    <div class="bottom">
                        <div class="pic">
                            <img src="<?php echo getValue($order, 'goods.thumb', '') ?>">
                        </div>
                        <div class="state"><?php echo getValue($status_list, [$order['order_status']], '') ?></div>
                        <div class="integral"><span><?php echo $order['points_cost'] ?></span>积分</div>
                        <div class="text"><?php echo $order['goods_name'] ?></div>
                    </div>
                </li>
            </a>
        <? endforeach ?>
    </ul>

</div>
</body>
<script>
    $('.menu').find('span').on('click', function(){
        $('.menu span').removeClass('active');
        $(this).addClass('active');

        $._ajax('/redeem/my/ajax-load-order', $(this).data(), 'POST', 'JSON', function(json){
            if(json.code > 0){
                var data = json.data.order_list;
                var html = '';
                $.each(data, function(i, order){
                    html +=
                    '<a href="'+ order.link +'"> '+
                    '    <li>'+
                    '        <div class="top">'+
                    '            <div class="number">订单编号：'+ order.order_id +'</div>'+
                    '            <div class="time">交易时间：'+ order.time +'</div>'+
                    '        </div>'+
                    '        <div class="bottom">'+
                    '            <div class="pic">'+
                    '                <img src="'+ order.goods.thumb +'">'+
                    '            </div>'+
                    '            <div class="state">'+ order.status_name +'</div>'+
                    '            <div class="integral"><span>'+ order.points_cost +'</span>积分</div>'+
                    '            <div class="text">'+ order.goods_name +'</div>'+
                    '        </div>'+
                    '    </li>'+
                    '</a>';
                });
                $("#quanbuer").html(html);
            }else{
                alert('添加失败');
            }
        });
    });
</script>

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