<!--影视行业-->
<div class="talent-modal clearfix">
    <div class="m-warp">
        <p class="talent-fac-title">
            <?php echo _rep_tags(100001, $_info, '<i class="icon-20"><img src="<!--[pic]-->"></i>'); ?>
            <?php echo _rep_tags(100002, $_info, '<span class="maintitle"><!--[word]--></span>'); ?>
            <?php echo _rep_tags(100003, $_info, '<i class="subtitle"><!--[word]--></i>'); ?>
        </p>

        <div class="talent-modal-box">
            <div class="talent-modal-left">
                <?php echo _rep_tags(
                    100004,
                    $_info,
                    '<a href="<!--[link]-->" <!--[target]--> class="talent-modal-subject"><img data-original="<!--[pic]-->" alt="<!--[alt]-->" class="lazy"></a>'
                ); ?>
                <span class="talent-modal-subject-p">
                    <b class="talent-modal-subject-bg"></b>
                    <?php $code = '';
                    for ($i = 100005; $i <= 100010; $i++): ?>
                        <?php $code .= _rep_tags(
                            $i,
                            $_info,
                            '<a href="<!--[link]-->" <!--[target]-->><!--[word]--></a><b>|</b>'
                        ); ?>
                    <?php endfor;
                    echo substr($code, 0, -8); ?>
                </span>

                <div class="talent-modal-word">
                    <ul class="assists clearfix">
                        <?php for ($i = 100011; $i <= 100012; $i++): ?>
                            <?php echo _rep_tags(
                                $i,
                                $_info,
                                '<li><a href="<!--[link]-->" <!--[target]-->><!--[word]--></a></li>'
                            ); ?>
                        <?php endfor; ?>
                    </ul>
                    <ul class="words clearfix">
                        <li>
                            <?php for ($i = 100013; $i <= 100028; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" <!--[target]--> class="<!--[active]-->"><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </li>
                        <li>
                            <?php for ($i = 100029; $i <= 100044; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" <!--[target]--> class="<!--[active]-->"><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="talent-modal-right">
                <?php echo _rep_tags(
                    100045,
                    $_info,
                    '<a href="<!--[link]-->" <!--[target]--> class="recommend-imgbox"><img data-original="<!--[pic]-->" alt="<!--[alt]-->" class="lazy"></a>'
                ); ?>

                <div class="recommend-box">
                    <?php echo _rep_tags(
                        100046,
                        $_info,
                        '<a href="<!--[link]-->" <!--[target]--> class="recommend-box-half">',
                        '<a href="javascript:void(0);" class="recommend-box-half">'
                    ); ?>
                    <em class="info-tra-left"></em>
                    <?php echo _rep_tags(100047, $_info, '<p class="recommend-brand"><!--[word]--></p>'); ?>
                    <p class="recommend-brand-line"></p>
                    <?php echo _rep_tags(100048, $_info, '<p class="recommend-title"><!--[word]--></p>'); ?>
                    <p>
                        <?php echo _rep_tags(100049, $_info, '<!--[word]-->'); ?>
                        <?php echo _rep_tags(100050, $_info, '<span><!--[word]--></span>'); ?>
                    </p>
                    <?php echo _rep_tags(100046, $_info, '</a>', '</a>'); ?>

                    <?php echo _rep_tags(
                        100051,
                        $_info,
                        '<a href="<!--[link]-->" class="recommend-box-half text-right pt25">',
                        '<a href="javascript:void(0);" class="recommend-box-half text-right pt25">'
                    ); ?>
                    <em class="info-tra-right"></em>
                    <?php echo _rep_tags(100052, $_info, '<p class="recommend-brand"><!--[word]--></p>'); ?>
                    <p class="recommend-brand-line"></p>
                    <?php echo _rep_tags(100053, $_info, '<p class="recommend-title"><!--[word]--></p>'); ?>
                    <p>
                        <?php echo _rep_tags(100054, $_info, '<!--[word]-->'); ?>
                        <?php echo _rep_tags(100055, $_info, '<span><!--[word]--></span>'); ?>
                    </p>
                    <?php echo _rep_tags(100051, $_info, '</a>', '</a>'); ?>
                </div>

                <?php for ($i = 100056; $i <= 100057; $i++): ?>
                    <?php echo _rep_tags(
                        $i,
                        $_info,
                        '<a href="<!--[link]-->" <!--[target]--> class="recommend-imgbox"><img data-original="<!--[pic]-->" alt="<!--[alt]-->" class="lazy"></a>'
                    ); ?>
                <?php endfor; ?>

                <div class="recommend-box">
                    <?php echo _rep_tags(
                        100058,
                        $_info,
                        '<a href="<!--[link]-->" <!--[target]--> class="recommend-box-all f36 text-right">',
                        '<a href="javascript:void(0);" class="recommend-box-all f36 text-right">'
                    ); ?>
                    <em class="info-tra-right"></em>
                    <?php echo _rep_tags(100059, $_info, '<p class="recommend-brand"><!--[word]--></p>'); ?>
                    <p class="recommend-brand-line"></p>
                    <?php echo _rep_tags(100060, $_info, '<p class="recommend-title"><!--[word]--></p>'); ?>
                    <p>
                        <?php echo _rep_tags(100061, $_info, '<!--[word]-->'); ?>
                        <?php echo _rep_tags(100062, $_info, '<span><!--[word]--></span>'); ?>
                    </p>
                    <?php echo _rep_tags(100058, $_info, '</a>', '</a>'); ?>
                </div>

                <?php for ($i = 100063; $i <= 100064; $i++): ?>
                    <?php echo _rep_tags(
                        $i,
                        $_info,
                        '<a href="<!--[link]-->" <!--[target]--> class="recommend-imgbox"><img data-original="<!--[pic]-->" alt="<!--[alt]-->" class="lazy"></a>'
                    ); ?>
                <?php endfor; ?>

                <div class="recommend-box">
                    <?php echo _rep_tags(
                        100065,
                        $_info,
                        '<a href="<!--[link]-->" <!--[target]--> class="recommend-box-half-vertical pull-left">',
                        '<a href="javascript:void(0);" class="recommend-box-half-vertical pull-left">'
                    ); ?>
                    <em class="info-tra-left"></em>
                    <?php echo _rep_tags(100066, $_info, '<p class="recommend-brand"><!--[word]--></p>'); ?>
                    <p class="recommend-brand-line"></p>
                    <?php echo _rep_tags(100067, $_info, '<p class="recommend-title"><!--[word]--></p>'); ?>
                    <p class="recommend-orgin">
                        <?php echo _rep_tags(100068, $_info, '<!--[word]-->'); ?>
                        <?php echo _rep_tags(100069, $_info, '<span><!--[word]--></span>'); ?>
                    </p>
                    <?php echo _rep_tags(100065, $_info, '</a>', '</a>'); ?>

                    <?php echo _rep_tags(
                        100070,
                        $_info,
                        '<a href="<!--[link]-->" <!--[target]--> class="recommend-box-half-vertical pt70 pull-right">',
                        '<a href="javascript:void(0);" class="recommend-box-half-vertical pt70 pull-right">'
                    ); ?>
                    <em class="info-tra-top"></em>
                    <?php echo _rep_tags(100071, $_info, '<p class="recommend-brand"><!--[word]--></p>'); ?>
                    <p class="recommend-brand-line"></p>
                    <?php echo _rep_tags(100072, $_info, '<p class="recommend-title"><!--[word]--></p>'); ?>
                    <p class="recommend-orgin">
                        <?php echo _rep_tags(100073, $_info, '<!--[word]-->'); ?>
                        <?php echo _rep_tags(100074, $_info, '<span><!--[word]--></span>'); ?>
                    </p>
                    <?php echo _rep_tags(100070, $_info, '</a>', '</a>'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="talent-modal-ad clearfix">
    <div class="m-warp">
        <ul class="talent-ad-list">
            <?php for ($i = 100075; $i <= 100083; $i++): ?>
                <?php echo _rep_tags(
                    $i,
                    $_info,
                    '<li><a href="<!--[link]-->" <!--[target]-->><img data-original="<!--[pic]-->" alt="<!--[alt]-->" class="lazy"></a><b></b></li>'
                ); ?>
            <?php endfor; ?>
        </ul>
    </div>
</div>
<!--/影视行业-->