<!DOCTYPE html>
<html>
<head>
    <title>我的购物车</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="browsermode" content="application">
    <meta name="x5-page-mode" content="app">
    <link rel="stylesheet" type="text/css" href="/css/header.css">
    <link rel="stylesheet" type="text/css" href="/css/gouwuche.css">
    <script src="/js/jquery-1.11.3.min.js"></script>
    <script src="/js/tools.js"></script>
    <script type="text/javascript">
        $(function(){
            $('.back').click(function(){
                history.back();
            });
            $('.box').click(function(){
//                $(this).toggleClass('active');
            });
        });
        <!-- 增加数量 -->
        function numAdd(thi) {
            var num_root = $(thi).parents('.count').find('input');
            var num_add = parseInt(num_root.val())+1;
            var cg_id = parseInt($(thi).attr('c_g_id'));
            var points = parseInt($(thi).attr('points'));
            var param = {num: num_add, cg_id: cg_id};
            $._ajax('/redeem/cart/ajax-change-goods-num', param, 'POST', 'JSON', function(json){
                num_root.val(num_add);
                var total = parseInt($("#totalpoints").text());
                $("#totalpoints").text(total + points);
            });
        }
        <!-- 减少数量 -->
        function numDec(thi) {
            var num_root = $(thi).parents('.count').find('input');
            var num_dec = parseInt(num_root.val())-1;
            var num_name = num_root.attr('name');
            var cg_id = parseInt($(thi).attr('c_g_id'));
            var points = parseInt($(thi).attr('points'));
            if(num_dec == 0){
                if(confirm('你确定要删除该商品？')){
                    var param = {num: num_dec, cg_id: cg_id};
                    $._ajax('/redeem/cart/ajax-change-goods-num', param, 'POST', 'JSON', function(json){
                        $('div[c_g_id='+ cg_id +']').remove();
                        var total = parseInt($("#totalpoints").text());
                        $("#totalpoints").text(total - points);
                    });
                }
                return false;
            }else{
                var param = {num: num_dec, cg_id: cg_id};
                $._ajax('/redeem/cart/ajax-change-goods-num', param, 'POST', 'JSON', function(json){
                    num_root.val(num_dec);
                    var total = parseInt($("#totalpoints").text());
                    $("#totalpoints").text(total - points);
                });
            }
        }

    </script>
</head>
<body>
<div class="body-All">
    <header>
        <div class="back"><a><img src="/images/back.png"></a></div>
        购物车
        <div class="home"><a href="/redeem/home/index"><img src="/images/home.png"></a></div>
    </header>
    <div class="box-container">
        <?php if(!empty($cart_goods)): ?>
            <?php foreach($cart_goods as $val): ?>
                <div class="box active" c_g_id="<?php echo $val['id'] ?>">
                    <div class="pic">
                        <a href="/redeem/goods/view?gid=<?php echo $val['gid'] ?>">
                            <img src="<?php echo yiiParams('img_host') . getValue($val, 'goods.thumb', '') ?>">
                        </a>
                    </div>
                    <div class="text">
                        <div class="title"><?php echo getValue($val, 'goods.name', '') ?></div>
                        <div>
                            <div class="integral">积分&nbsp;&nbsp;<span><?php echo getValue($val, 'goods.redeem_pionts', 0) ?></span></div>
                            <div class="count">
                                <img c_g_id="<?php echo $val['id'] ?>" points="<?php echo getValue($val, 'goods.redeem_pionts', 0) ?>" src="/images/+.png" onclick="numAdd(this)">
                                <input type="text" name="number" value="<?php echo $val['count'] ?>" />
                                <img c_g_id="<?php echo $val['id'] ?>"  points="<?php echo getValue($val, 'goods.redeem_pionts', 0) ?>" src="/images/-.png" onclick="numDec(this)">
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
    <div class="exchange">
        <div class="needIntegral">共&nbsp;<span id="totalpoints"><?php echo $total_points ?></span>&nbsp;积分</div>
        <div class="button"><a href="javaScript:void(0)" class="btn redeemnow">立即兑换</a></div>
    </div>
</div>
</body>
<script>
    $(".redeemnow").on('click', function(){
        var goods_chosen = $(".box-container").find("div.active");
        if(goods_chosen.length == 0){
            return
        }
        var gid_arr = Array();
        $.each(goods_chosen, function(i, dom){
            gid_arr.push($(dom).attr('c_g_id'))
        });
        var gids = JSON.stringify(gid_arr);
        var param = {gids: gids};
        $._ajax('/redeem/order/ajax-add', param, 'POST', 'JSON', function(json){
            if(json.code > 0){
                window.location.href = '/redeem/order/list';
            }else{
                if(json.code == -20003){
                    alert('由于您的积分有限，请您继续活跃获得积分');
                }
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