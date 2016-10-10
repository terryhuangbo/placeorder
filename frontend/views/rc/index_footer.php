<!--引入广告js文件-->
<script type="text/javascript" src="<?php echo yii::$app->params['staticUrl'] . yii::$app->params['rc_static_prefix_dir']; ?>/js/push.js"></script>
<!--引入广告js文件-->
<!--/content-->
<script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
<script src="/js/rc_index.js"></script>
<!--footer-->
<script type="text/javascript" src="http://account.vsochina.com/static/js/vsofooter.js"></script>
<!--add experience-->
<script type="text/javascript" src="http://account.vsochina.com/static/js/experience.js?v=1"></script>
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