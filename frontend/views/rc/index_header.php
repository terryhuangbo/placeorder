<style>
    /*全局广告位隐藏，加载完毕时显示*/
    ._web_ad_ {
        display: none;
    }
</style>
<script>
    STATIC_RC_JS_URL_PREFIX_PATH = '<?php echo yii::$app->params['staticUrl'] . yii::$app->params['rc_static_prefix_dir']; ?>';
</script>
<link type="text/css" rel="stylesheet" href="/css/dreamSpace.css"/>
<script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
<script type="text/javascript" src="/js/dreamSpace.js"></script>
<!--header-->
<div class="talent-header border2">
    <div class="m-warp">
        <div class="talent-logo">
            <a href="<?php echo yii::$app->params['rc_frontendurl']; ?>"><img src="/images/logo.png" class="pull-left"/></a>
            <!-- 下拉菜单 -->
<!--            <div class="dropdown pull-left">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" id="dLabel">
                    企业用户 <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dLabel">
                    <li><a href="#">企业用户</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#">个人用户</a></li>
                </ul>
            </div>-->
            <!-- /下拉菜单 -->
        </div>

        <div class="talent-search">
            <div class="bdsug">
            </div>
            <div class="input-group _web_ad_" ad_data="{'b_id':5, 'row_num':1}">
                <form name="search" id="search" method="get" action="<?= yii::$app->params['rc_frontendurl'] ?>/search?" onsubmit="return checkParams()">
                    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="{word}" onkeyup="help(event)"
                           aria-describedby="basic-addon2" value="<?= isset($keyword) ? $keyword : '' ?>"  autocomplete="off">
                    <input type="submit" class="input-group-addon" id="basic-addon2" value="搜索"/>
                </form>
            </div>
            <p class="talent-label-s _web_ad_" ad_data="{'b_id':4, 'row_num':7,'sub_str':'0,-8'}"><a href="<?= yii::$app->params['rc_frontendurl'] ?>/rc/search?keyword={word|encodeURI}" target="_blank" class="active">{word}</a><b>|</b></p>
        </div>
        <a href="<?=yii::$app->params['rc_frontendurl']?>/rc/recruit/">
            <img src="/images/rc/index/yuegao.jpg" alt="" class="pull-right">
        </a>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        load_Logo();
    });
    function load_Logo() {
        $.ajax({
            type: "GET",
            async: false,
            url: "<?=yii::$app->params['rc_frontendurl']?>/rc/index/site-info?site_type=2",
            dataType: "jsonp",
            jsonp:'jsonpcallback',
            success: function (data) {
                if (data.site_logo != '') {
                    $(".talent-logo").html("<a href='<?php echo yii::$app->params['rc_frontendurl'];?>'>" + data.site_logo + "</a>");
                }
            }
        });
    }
    function checkParams() {
        if ('' == $.trim($('#keyword').val())) {
            location.reload();
            return false;
        }
    }
    var helpflag;
    function help(event) {
        clearTimeout(helpflag);
        var keyword = $('#keyword').val().trim();
        if (keyword !== "") {
            helpflag=setTimeout(function(){$.ajax({
                type: "GET",
                async: false,
                url: "/rc/search/remind?keyword=" + keyword,
                success: function (data) {
                    if (data)
                    {
                        $(".talent-search .bdsug").html(data);
                        $(".talent-search .bdsug").show();
                    }
                    else
                    {
                        $(".talent-search .bdsug").hide();
                    }
                },
                fail: function ()
                {
                    $(".talent-search .bdsug").hide();
                }
            });},300);
        }
        else
        {
            $(".talent-search .bdsug").hide();
        }
        stopPropagation(event);
    }
    $(".talent-search .form-control").on("click", function (event) {
        stopPropagation(event);
    });
    $(document).on("click", function () {
        $(".talent-search .bdsug").hide();
    });
    /*阻止冒泡*/
    function stopPropagation(event) {
        if (event.stopPropagation)
            event.stopPropagation();
        else
            event.cancelBubble = true;
    }
</script>
<!--/header-->