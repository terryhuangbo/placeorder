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
    <link rel="stylesheet" type="text/css" href="/css/xinzengdizhi.css">
    <script>
        var Province = '省份';
        var City = '地级市';
        var County = '市、县级市';
    </script>
    <script src="/js/jquery-1.11.3.min.js"></script>
    <script class="resources library" src="/js/area.js" type="text/javascript"></script>
    <script src="/js/tools.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            $('.back').click(function(){
                history.back();
            });
            $('.type-bottom span').click(function(){
                $('.type-bottom span').removeClass('active');
                $(this).addClass('active');
            });
            $('.time-bottom span').click(function(){
                $('.time-bottom span').removeClass('active');
                $(this).addClass('active');
            });
            $('.checkbox').click(function(){
                $(this).toggleClass('checked');
            });
        });
    </script>
    <style type="text/css">
        .msg-error{
            color: darkorange;
            font-size: 12px;
            text-align: center;
            margin: 5px auto 10px auto;
        }
    </style>
</head>
<body>
<div class="body-All">
    <header>
        <div class="back"><a><img src="/images/back.png"></a></div>
        新增地址
        <div class="determine">确定</div>
    </header>
    <form id="address">
        <div class="box">
            <input type="hidden" name="oid" value="<?php echo $oid ?>">
            <div class="form-group">
                <label>收货人姓名</label>
                <input type="text" name="receiver_name" placeholder="请输入收货人姓名" />
            </div>
            <div class="form-group">
                <label>收货人手机</label>
                <input type="text" name="receiver_phone" placeholder="请输入收货人手机号码" />
            </div>
            <div class="address">
                <div>收货地址</div>
                <div class="mt">
                    <label>省份</label>
                    <select id="s_province" name="province">
                        <option>请选择</option>
                    </select>
                </div>
                <div class="mt">
                    <label>城市</label>
                    <select id="s_city" name="city" >
                        <option>请选择</option>
                    </select>
                </div>
                <div class="mt">
                    <label>区县</label>
                    <select id="s_county" name="county"></select>
                        <option>请选择</option>
                    </select>
                </div>

                <div class="mt">
                    <label>详细<br>地址</label>
                    <textarea name="detail"></textarea>
                </div>
                <div class="mt">
                    <div class="top">地址类型</div>
                    <div class="type-bottom bottom addtype">
                        <span class="active" addtype="1">家庭地址</span>
                        <span addtype="2">公司地址</span>
                        <span addtype="3">其他</span>
                        <input type="hidden" name="type" value="1">
                    </div>
                </div>
                <div class="mt">
                    <div class="top">常用收货时间</div>
                    <div class="time-bottom bottom receive_time">
                        <span class="active" receive_time="1">一周七日</span>
                        <span receive_time="2">工作日</span>
                        <span receive_time="3">双休及节假</span>
                        <input type="hidden" name="receive_time" value="1">
                    </div>
                </div>
                <div class="mt checkbox checked">
                    <input type="checkbox" name="is_default" value=""/>设为默认地址
                </div>
            </div>
        </div>
        <div class="button">
            <a href="javaScript:void(0);" id="submit" class="btn">保存</a>
        </div>
    </form>
</div>
</body>
<script type="text/javascript">
    //省市县联动
    _init_area();

    var Gid  = document.getElementById ;
    var showArea = function(){
        Gid('show').innerHTML = "<h3>省" + Gid('s_province').value + " - 市" +
        Gid('s_city').value + " - 县/区" +
        Gid('s_county').value + "</h3>"
    }
    $("#s_county").on('onchange', function(){
        showArea();
    });

    $("div.addtype > span").on('click', function(){
        var dom = $(this);
        $("input[name=type]").val(dom.attr('addtype'));
    });
    $("div.receive_time > span").on('click', function(){
        var dom = $(this);
        $("input[name=receive_time]").val(dom.attr('receive_time'));
    });

    $("#submit").on('click', function(){
        var param = $._get_form_json('#address');
        param.is_default  = $(".checkbox").hasClass("checked") ? 2 : 1;
        $._ajax('/redeem/address/change-order-address', param, 'POST', 'JSON', function(json){
            var code = json.code;
            var msg = json.msg
            if(code > 0){
                history.back();
            }else if(code == -20001){
                var error = $('<p class="msg-error">'+ msg +'</p>');
                $("input[name=receiver_name]").closest('div').after(error);
                error.fadeOut(1500);
            }else if(code == -20002){
                var error = $('<p class="msg-error">'+ msg +'</p>');
                $("input[name=receiver_phone]").closest('div').after(error);
                error.fadeOut(1500);
            }else if(code == -20003){
                var error = $('<p class="msg-error">'+ msg +'</p>');
                $("*[name=county]").closest('div').after(error);
                error.fadeOut(1500);
            }else if(code == -20004){
                var error = $('<p class="msg-error">'+ msg +'</p>');
                $("*[name=detail]").closest('div').after(error);
                error.fadeOut(1500);
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