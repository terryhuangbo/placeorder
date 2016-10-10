<!DOCTYPE html>
<html>
<head>
    <title>手机绑定</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="browsermode" content="application">
    <meta name="x5-page-mode" content="app">
    <link rel="stylesheet" type="text/css" href="/css/header.css">
    <link rel="stylesheet" type="text/css" href="/css/renzheng.css">
    <script src="/js/jquery-1.11.3.min.js"></script>
    <script src="/js/tools.js"></script>
    <style type="text/css">
        .verificationCode{
            padding-right:80px !important;
        }
        .send{
            font-size: 12px;
            background: #fec200;
            color: #fff;
            padding: 2px 5px;
            margin-top:-25px;
            position:absolute;
            right:20px;
            width: 76px;
            text-align: center;
        }
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
    <form id="reg">
        <div class="title">
            <span>用户认证</span>
        </div>
        <input type="hidden" name="key" value="<?php echo $key ?>"/>
        <div class="form-group">
            <label>手机号码</label>
            <input type="text" name="mobile" placeholder="请输入您的手机号码"/>
        </div>

        <div class="form-group">
            <label>验&nbsp;证&nbsp;码</label>
            <input class="verificationCode" name="verifycode" type="text" placeholder="请输入验证码"/>
            <div class="send">发送验证码</div>
        </div>
        <div class="pb"></div>
        <div class="button">
            <a href="javaScript:void(0);" id="submit" class="btn">确认</a>
        </div>
    </form>

</div>
</body>
<script>
    $("#submit").on('click', function(){
        var param = $._get_form_json('#reg');
        $._ajax('/redeem/user/reg', param, 'POST', 'JSON', function(json){
            var code = json.code;
            var msg = json.msg;
            if(code > 0){
                window.location.href = json.data.redirect;
            }else if(code == -20001 || code == -20002 ){
                var error = $('<p class="msg-error">'+ msg +'</p>');
                $("input[name=mobile]").closest('div').after(error);
                error.fadeOut(1500);
            }else if(code == -20003 || code == -20004  || code == -20005 ){
                var error = $('<p class="msg-error">'+ msg +'</p>');
                $("input[name=verifycode]").closest('div').after(error);
                error.fadeOut(1500);
            }
        });
    });

    //发送验证码
    $(".send").on('click', function(){
        var param = $._get_form_json('#reg');
        $._ajax('/redeem/user/send-sms', param, 'POST', 'JSON', function(json){
            if(json.code > 0){
                $(document).data('countdown', 60);
                settime();
            }else{
                var error = $('<p class="msg-error">'+ json.msg +'</p>');
                $("input[name=verifycode]").closest('div').after(error);
                error.fadeOut(1500);
            }
        });
    });

    //自动获取
    function settime() {
        var dom = $('.send');
        var count = parseInt($(document).data('countdown'));
        if (count == 0) {
            dom.text("发送验证码");
        } else {
            dom.text("重新发送(" + count + ")");
            $(document).data('countdown', count-1)
        }
        setTimeout(function() {
            settime()
        },1000)
    }

</script>


</html>
