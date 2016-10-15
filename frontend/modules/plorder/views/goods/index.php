<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新版post卡密社区</title>
    <link href="/static/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/css/bootstrap-theme.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/jwxh.css">
<style>
    .navbar-fixed-top, .navbar-fixed-bottom {
        z-index: 0;
    }
    /*四根弦 QQ821996993 承接网站建设，软件开发*/
    /*水青色配色方案*/
    .login_page,body{
        background-image:url(image/5714fd44b97e1.jpg);
        background-repeat:repeat
    }
    .menu,footer{background-color:#40cfe8}
    #login h2,.vertical-center .panel-title{background-color:#19d8eb}
    .btn{background-color:#2dd9ae!important}
    .div_url{padding-right:12px;padding-left:12px;max-width:165px}
    .thumbnail a{height:180px}
    .alert-danger{color:#007e94;background-color:#b4eef8;border-color:#40d0e8;background-image:none}
    .login_page,body {
        background-image: url("/static/image/56e29f86ac53d.jpg");
        background-attachment: fixed;
    }
    .menu,footer {
        background-color: #0f0d0d;
    }
    #login h2,.vertical-center .panel-title {
        background-color: #070505;
    }
    .btn{
        background-color: #2ecc76 !important;
    }
    .div_url {
        padding-right: 6px !important;
        padding-left: 6px !important;
        max-width:300px !important;
    }
</style>
</head>

<body class="login_page">
<!--顶部-->
<header>
    <div class="container-fluid menu">
        <div class="container">
            <h2 class="text-center" ><strong>新版post卡密社区</strong></h2>
        </div>
    </div>
</header>

<!--中间-->
<div class="container">
    <!--公告-->
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
            &times;
        </button>
        这是新版post卡密社区  感谢大家的支持  之前的Q冻结了  新售后QQ1356130480 有任何变动 看公告即可
    </div>
    <!--内容标签-->
    <div class="row">
            <?php foreach($goods as $good): ?>
                <div class="div_url col-xs-6 col-sm-3 col-md-2">
                    <div class="thumbnail">
                        <a target="_blank" href="page1-1.html">
                            <img class="img-rounded img-responsive"  src="<?php echo $good['images'] ?>" alt="<?php echo $good['name'] ?>" title="<?php echo $good['name'] ?>">
                        </a>
                    </div>
                </div>
            <?php endforeach ?>
     </div>
</div>


<!--底部-->
<footer class="navbar-fixed-bottom hidden-xs hidden-sm">
    <div class="container">
        <div class="row">
          <div class="col-md-8 col-sm-6 col-xs-6" ><span>Copyright © 新版post卡密平台<span class="hidden-xs hidden-sm">. All Rights Reserved</span></span></div>
          <div class="col-md-4 col-sm-6 col-xs-6 text-right">蜀ICP备123456号</div>
        </div>
    </div>
</footer>

<!--底部-->
<footer class="hidden-md hidden-lg">
    <div class="container">
        <div class="row">
          <div class="col-md-8 col-sm-6 col-xs-6" ><span><span class="hidden-xs">Copyright </span>© 新版post卡密平台<span class="hidden-xs hidden-sm">. All Rights Reserved</span></span></div>
          <div class="col-md-4 col-sm-6 col-xs-6 text-right">蜀ICP备123456号</div>
        </div>
    </div>
</footer>

<!--模态框-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">新版post卡密社区</h4>
            </div>
            <div class="modal-body"> 
                欢迎光临post新版社区  感谢大家的支持  新售后QQ1356130480 有任何变动 看公告即可          </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">
                关闭公告
                </button>
            </div>
        </div>
    </div>
</div>

<script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/jquery.cookie.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/tools.js"  type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
</script>

<div style="display:none;">
    <script src="http://s11.cnzz.com/z_stat.php?id=1257842329&web_id=1257842329" language="JavaScript"></script>
</div>

</body>
</html>