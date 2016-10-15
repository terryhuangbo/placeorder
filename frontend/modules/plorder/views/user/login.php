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
        }
    </style>
</head>
<body>
<div class="body-All">
    <div class="title">
        <span>用户认证</span>
    </div>
    <div class="form-group">
        <label>手机号码</label>
        <input type="text" placeholder="请输入您的手机号码"/>
    </div>
    <div class="form-group">
        <label>验&nbsp;证&nbsp;码</label>
        <input class="verificationCode" type="text" placeholder="请输入验证码"/>
        <div class="send">发送验证码</div>
    </div>
    <div class="pb"></div>
    <div class="button">
        <a href="" class="btn">确认</a>
    </div>
</div>
</body>
</html>