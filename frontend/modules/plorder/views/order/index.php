<!DOCTYPE html>
<html>
<head>
    <title>Somfy 积分兑换商城</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="browsermode" content="application">
    <meta name="x5-page-mode" content="app">
    <link rel="stylesheet" type="text/css" href="css/swiper-3.3.1.min.css">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/swiper-3.3.1.jquery.min.js"></script>
    <script type="text/javascript">
        $(function(){
            var mySwiper = new Swiper('.banner', {
                autoplay: 5000,
                direction : 'horizontal',
                loop : true,
            });

            $('.swiper-slide').height(mySwiper.width/2.3);
            $('.head_portrait').height($('.head_portrait img').outerWidth());

            $('header .left img').click(function(){
                $('.search-box').toggleClass('active');
                $('.banner').toggleClass('top');
            });
        });
    </script>
</head>
<body>
<div class="body-All">
    <header>
        <div class="left"><a><img src="images/search.png"></a></div>
        <img src="images/logo.png" class="logo">
        <div class="right">
            <a href="个人中心.html"><img src="images/icon07.png"></a>
            <a href="购物车.html"><img src="images/icon06.png"></a>
        </div>
    </header>
    <div class="search-box">
        <input type="text" placeholder="请输入您想要搜索的产品">
        <img src="images/search01.png">
    </div>
    <div class="banner top">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="images/banner.png"></div>
            <div class="swiper-slide"><img src="images/head_portrait.png"></div>
        </div>
    </div>
    <div class="personal-container">
        <div class="personal">
            <div class="personal-left">
                <div class="head_portrait">
                    <img src="images/head_portrait.png">
                </div>
                <div class="text">
                    <div><span>张玛丽</span></div>
                    <div class="integral"><span>我的积分：</span><span class="color">61000</span></div>
                    <div class="btn"><span>签到赚积分</span></div>
                </div>
            </div>
            <div class="personal-right">
                <img src="images/text.png">
            </div>
        </div>
    </div>
    <ul class="box">
        <a href="详情.html">
            <li>
                <div class="pic">
                    <img src="images/pic05.png">
                </div>
                <div class="exchange">我要<br>兑换</div>
                <div class="go"><img src="images/go1.png"></div>
                <div class="title">
                    <div class="text">东芝U盘16G 速闪USB3.0  迷你防水创意车载优盘</div>
                    <div class="integral"><span>999</span>积分</div>
                </div>
            </li>
        </a>
        <a href="详情.html">
            <li>
                <div class="pic">
                    <img src="images/pic05.png">
                </div>
                <div class="exchange">我要<br>兑换</div>
                <div class="go"><img src="images/go1.png"></div>
                <div class="title">
                    <div class="text">东芝U盘16G 速闪USB3.0  迷你防水创意车载优盘</div>
                    <div class="integral"><span>999</span>积分</div>
                </div>
            </li>
        </a>
    </ul>
</div>
</body>
</html>