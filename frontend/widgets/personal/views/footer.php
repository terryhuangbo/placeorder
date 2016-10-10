
<!--私信-->
<div class="modal fade" id="sendMessage" tabindex="-1" role="dialog">
       <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       <h4 class="modal-title" id="myModalLabel">私信：<?=$this->context->user_info['nickname']?>（<?=$this->context->user_info['username']?>）</h4>
                </div>
                <form method="post" id="frm_msg" name="frm_msg">
                    <input type="hidden" name="to_username" id="to_username" value="<?= $this->context->obj_username ?>">
                    <input type="hidden" name="username" id="from_username" value="<?= $this->context->vso_uname ?>">
                    <div class="modal-body clearfix">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="" class="form-label">消息标题：</label>
                                <input type="text" class="form-control" placeholder="" maxlength="20" name="tar_title" id="tar_title" msgArea="span_title" onblur="checkInner('tar_title','span_title',2,20)" >
                                <div><span id="span_title">&nbsp;</span></div>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">消息内容：</label>
                                <textarea class="form-control" name="tar_content" id="tar_content"  placeholder=""  onkeyup="countChar('tar_content','message_content_tip',1000)" onblur="checkInner('tar_content','message_content_tip',5,1000)" ></textarea>
                                <div class="message-details">
                                <span id="message_content_tip" class="tip">已输入长度0，还可以输入1000字</span>
                            </div>
                            </div>
                            <div class="form-group btn-works-group text-right">
                                <input type="button" class="btn btn-darkgrey" onclick="sendMessage()" value="发 送"/>
                                <input type="reset" class="btn btn-darkgrey" value="重 置"/>
                            </div>
                        </div>
                        <input type="hidden" id="currentUrl" value="<?=yii::$app->params['rc_frontendurl'].yii::$app->request->getUrl();?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
<a href="javascript:;" id="rc_back_top">
    <div class="triangle-up"></div>
</a>
<script src="http://static.vsochina.com/libs/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="http://static.vsochina.com/libs/masonry/3.3.2/masonry.pkgd.min.js"></script>
<!--<script type="text/javascript" src="http://static.vsochina.com/libs/webuploader/0.1.5/webuploader.js"></script>-->
<!--<script type="text/javascript" src="/js/upload.js"></script>-->
<script src="/js/share.js"></script>
<script src="/js/jquery.qrcode.min.js"></script>
<script src="/js/talent_space.js"></script>
<script type="text/javascript" src="http://www.vsochina.com/resource/js/form_and_validation.js"></script>
<script src="/js/rc_p_footer.js"></script>
<script>
    $(".masonry-action-change").on("click", function (event) {
        var offsetTop = $(this).offset().top;
        var offsetLeft = $(this).offset().left;
        var offsetHeight = $(this).height();
        var _this = $(this);
        if ($(".works-sample-ul:visible").length >= 1 && $(this).hasClass("active")) {
            $(".works-sample-ul").slideUp();
            _this.removeClass("active");
        } else if ($(".works-sample-ul:visible").length >= 1 && !$(this).hasClass("active")) {
            $(".works-sample-ul").slideUp(100, function () {
                $(".works-sample-ul").css({"left": offsetLeft + "px", "top": (offsetTop + offsetHeight) + "px"}).slideDown();
                $(".masonry-action-change").removeClass("active");
                _this.addClass("active");
            });
        } else {
            $(".works-sample-ul").css({"left": offsetLeft + "px", "top": (offsetTop + offsetHeight) + "px"}).slideDown();
            $(".masonry-action-change").removeClass("active");
            $(this).addClass("active");
        }
        stopPropagation(event);
    });
    $(document).on("click", function () {
        $(".works-sample-ul").slideUp(100, function () {
            $(".masonry-action-change").removeClass("active");
        });
    })
    $("#manage_works").on("click", function () {
        $(".masonry-action").hide();
        $(".masonry-action-self").show();
        $("#manage_action").show();
        $("#manage_action_before").hide();
        $('[data-link="true"]').attr("data-link", "false");
    });
    $("#manage_action_save").on("click", function () {
        $("#manage_action").hide();
        $("#manage_action_before").show();
        $(".masonry-action").show();
        $(".masonry-action-self").hide();
        $('[data-link="false"]').attr("data-link", "true");
    });
    /*阻止冒泡*/
    function stopPropagation(event) {
        if (event.stopPropagation)
            event.stopPropagation();
        else
            event.cancelBubble = true;
    }

    $(document).on("click", '[data-link="true"]', function () {
        var url = $(this).attr("data-link-url");
        window.open(url);
    });

    sharePersonal();
    function sharePersonal(){
        var username = $.trim($(".username").text());
        var url = "http://rc.vsochina.com/personal/index/" + $.trim($("#to_username").val());
        var title = username +"的个人空间";
        var desc = "";
        var summary = "高大上！"+username+"的个人空间，来自蓝海创意云的创意人才。蓝海创意云-一个云端的创客空间";
        var pic = $(".head-130 img").attr("src");
        share(url,title,pic,desc,summary,$(".sharebox-new"))
    };
    //返回底部
    $(document).ready(function(){
        setTimeout(function(){
            if ($("body").height()>$(window).height()) $("#rc_back_top").css("display","inline-block");
            else $("#rc_back_top").css("display","none");
        },1000);
        $(window).resize(function(){
            if ($("body").height()>$(window).height()) $("#rc_back_top").css("display","inline-block");
            else $("#rc_back_top").css("display","none");
        });
    });

    $("#rc_back_top").click(function(){
        $('body,html').animate({scrollTop:0},500);
        return false;
    });
</script>
<!-- Piwik -->
<script type="text/javascript">
    var _paq = _paq || [];
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="//analyst.vsochina.com:8080/";
        _paq.push(['setTrackerUrl', u+'piwik.php']);
        _paq.push(['setSiteId', 6]);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();
</script>
<noscript><p><img src="//analyst.vsochina.com:8080/piwik.php?idsite=6" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->
</body>
</html>