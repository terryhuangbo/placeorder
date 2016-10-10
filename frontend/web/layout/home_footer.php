<!--footer-->
<?php $site = \backend\modules\content\models\Site::getSiteSeo();?>
<div class="dsn-activity clearfix dsn-footer">
    <div class="ds-1200">
        <div class="col-xs-5">
            <?php if (!empty($site)): ?>
            <div class="dsn-footer-logo">
                <?php if (isset($site['site_logo']) && !empty($site['site_logo'])):?>
                <?= $site['site_logo'] ?>
                <?php endif;?>
            </div>
            <?php endif;?>

            <p class="color-black">苏州创意云网络科技有限公司 2008 - <?=date("Y",time())?> </p>
            <p class="color-black">All Rights Reserved</p>
            <p class="color-green">专注孵化优秀文化创意项目，实现年轻人创业梦想的摇篮！</p>
            <p class="color-grey">网络文化经营许可证：苏网文【2013】0897-043 </p>
            <p class="color-grey">增值电信业务经营许可证：苏B1 - 20130110   苏B2-20120347 </p>
        </div>
        <div class="col-xs-1">
            <dl class="dsn-footer-dl">
                <dt>本页导航</dt>
                <dd><a target="_blank" href="http://maker.vsochina.com/project/default/list">项目</a></dd>
                <dd><a target="_blank" href="http://create.vsochina.com/app/lst">工具</a></dd>
                <dd><a target="_blank" href="http://maker.vsochina.com/activity/default/index">活动</a></dd>
                <dd><a target="_blank" href="http://bbs.vsochina.com/forum-61-1.html">圈子</a></dd>
                <dd><a target="_blank" href="/project/default/create">项目入驻</a></dd>
                <dd><a target="_blank" href="http://rc.vsochina.com/rc/recruit/">人才入驻</a></dd>
                <dd><a target="_blank" href="http://create.vsochina.com/">我的工作室</a></dd>
                <dd><a href="http://maker.vsochina.com/home/default/mindex">手机版</a></dd>
                <!--<dd><a target="_blank" href="http://maker.vsochina.com/home/default/tuned">关于我们</a></dd>-->
            </dl>
        </div>
        <div class="col-xs-2">
            <dl class="dsn-footer-dl">
                <dt>全站导航</dt>
                <dd><a target="_blank" href="http://www.vsochina.com/task.html">任务大厅</a></dd>
                <dd><a target="_blank" href="http://maker.vsochina.com/index.php">在线创作</a></dd>
                <dd><a target="_blank" href="http://rc.vsochina.com/">创意人才</a></dd>
                <dd><a target="_blank" href="http://www.vsochina.com/shop_list.html">创意商城</a></dd>
                <dd><a target="_blank" href="http://render.vsochina.com/">渲染农场</a></dd>
                <dd><a target="_blank" href="http://bbs.vsochina.com/portal.php">创意社区</a></dd>
            </dl>
        </div>
        <div class="col-xs-4">
            <dl class="dsn-footer-dl">
                <dt>联系方式</dt>
                <dd>分享：
                    <div class="sharebox">
                        <a class="weibo" data-cmd="tsina" href="" target="_blank"></a>
                        <a class="qq" data-cmd="qq" href="" target="_blank"></a>
                        <a class="zoom" data-cmd="qzone" href="" target="_blank"></a>
                        <a class="weixin" data-cmd="weixin">
                            <div class="weixin-box">
                                <div class="wx-triangle">
                                    <span><em></em></span>
                                </div>
                                <div class="weixin-box-img"></div>
                                <p>创意云微信公众号</p>
                            </div>
                        </a>
                    </div>
                </dd>
                <dd class="pt20">客户服务QQ：<span class="color-line"> 4009287979</span>，<span class="color-line">2773398623</span></dd>
                <dd class="pt20">全国咨询热线（Hotline）：<b>400-164-7979</b>，<b>400-928-7979</b></dd>
                <dd class="pt20">地址（Address）：江苏省苏州市科灵路78号7号楼2层</dd>
                <dd class="pt20">邮编（Zip Code）：215000</dd>
            </dl>
        </div>
    </div>
</div>
<script type="text/javascript" src="http://rc.vsochina.com/js/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="http://rc.vsochina.com/js/share.js"></script>
<script type="text/javascript">
  shareLink();
    function shareLink(){
        var url = "http://maker.vsochina.com/";
        var title ="创意空间 · 专注文创项目孵化";
        var desc = "创意空间 · 专注文创项目孵化";
        var pic = "http://maker.vsochina.com/images/home/logo.jpg";
        var summary = "创意空间 · 专注文创项目孵化";
        share(url,title,pic,desc,summary,$(".sharebox"));
    };

</script>
<!--/footer-->
<!-- Piwik 数据统计 -->
<script type="text/javascript">
    //baidu_statistics
    var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
    document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fd426d199179c8a78bc6f6c2d577d9f91' type='text/javascript'%3E%3C/script%3E"));

  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//analyst.vsochina.com:8080/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 3]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//analyst.vsochina.com:8080/piwik.php?idsite=3" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->
<script type="text/javascript" src="http://account.vsochina.com/static/js/experience.js"></script>
