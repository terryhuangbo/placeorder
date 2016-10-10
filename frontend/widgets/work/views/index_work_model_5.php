<!--影视行业-->
<div class="talent-modal clearfix">
    <div class="m-warp">
        <p class="talent-fac-title">
            <?php echo _rep_tags(80001, $_info, '<i class="icon-20"><img src="<!--[pic]-->"></i>'); ?>
            <?php echo _rep_tags(80002, $_info, '<span class="maintitle"><!--[word]--></span>'); ?>
            <?php echo _rep_tags(80003, $_info, '<i class="subtitle"><!--[word]--></i>'); ?>
        </p>

        <div class="talent-modal-box">
            <div class="talent-modal-left">
                <?php echo _rep_tags(
                    80004,
                    $_info,
                    '<a href="<!--[link]-->" <!--[target]--> class="talent-modal-subject"><img data-original="<!--[pic]-->" alt="<!--[alt]-->" class="lazy"></a>'
                ); ?>
                <span class="talent-modal-subject-p">
                    <b class="talent-modal-subject-bg"></b>
                    <?php $code = '';
                    for ($i = 80005; $i <= 80010; $i++): ?>
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
                        <?php for ($i = 80011; $i <= 80012; $i++): ?>
                            <?php echo _rep_tags(
                                $i,
                                $_info,
                                '<li><a href="<!--[link]-->" <!--[target]-->><!--[word]--></a></li>'
                            ); ?>
                        <?php endfor; ?>
                    </ul>
                    <ul class="words clearfix">
                        <li>
                            <?php for ($i = 80013; $i <= 80028; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" <!--[target]--> class="<!--[active]-->"><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </li>
                        <li>
                            <?php for ($i = 80029; $i <= 80044; $i++): ?>
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
                    80045,
                    $_info,
                    '<a href="<!--[link]-->" <!--[target]--> class="recommend-imgbox"><img data-original="<!--[pic]-->" alt="<!--[alt]-->" class="lazy"></a>'
                ); ?>

                <div class="recommend-box">
                    <?php echo _rep_tags(
                        80046,
                        $_info,
                        '<a href="<!--[link]-->" <!--[target]--> class="recommend-box-half">',
                        '<a href="javascript:void(0);" class="recommend-box-half">'
                    ); ?>
                    <em class="info-tra-left"></em>
                    <?php echo _rep_tags(80047, $_info, '<p class="recommend-brand"><!--[word]--></p>'); ?>
                    <p class="recommend-brand-line"></p>
                    <?php echo _rep_tags(80048, $_info, '<p class="recommend-title"><!--[word]--></p>'); ?>
                    <p>
                        <?php echo _rep_tags(80049, $_info, '<!--[word]-->'); ?>
                        <?php echo _rep_tags(80050, $_info, '<span><!--[word]--></span>'); ?>
                    </p>
                    <?php echo _rep_tags(80046, $_info, '</a>', '</a>'); ?>

                    <?php echo _rep_tags(
                        80051,
                        $_info,
                        '<a href="<!--[link]-->" class="recommend-box-half text-right pt25">',
                        '<a href="javascript:void(0);" class="recommend-box-half text-right pt25">'
                    ); ?>
                    <em class="info-tra-right"></em>
                    <?php echo _rep_tags(80052, $_info, '<p class="recommend-brand"><!--[word]--></p>'); ?>
                    <p class="recommend-brand-line"></p>
                    <?php echo _rep_tags(80053, $_info, '<p class="recommend-title"><!--[word]--></p>'); ?>
                    <p>
                        <?php echo _rep_tags(80054, $_info, '<!--[word]-->'); ?>
                        <?php echo _rep_tags(80055, $_info, '<span><!--[word]--></span>'); ?>
                    </p>
                    <?php echo _rep_tags(80051, $_info, '</a>', '</a>'); ?>
                </div>

                <?php for ($i = 80056; $i <= 80057; $i++): ?>
                    <?php echo _rep_tags(
                        $i,
                        $_info,
                        '<a href="<!--[link]-->" <!--[target]--> class="recommend-imgbox"><img data-original="<!--[pic]-->" alt="<!--[alt]-->" class="lazy"></a>'
                    ); ?>
                <?php endfor; ?>

                <div class="recommend-box">
                    <?php echo _rep_tags(
                        80058,
                        $_info,
                        '<a href="<!--[link]-->" <!--[target]--> class="recommend-box-all f36 text-right">',
                        '<a href="javascript:void(0);" class="recommend-box-all f36 text-right">'
                    ); ?>
                    <em class="info-tra-right"></em>
                    <?php echo _rep_tags(80059, $_info, '<p class="recommend-brand"><!--[word]--></p>'); ?>
                    <p class="recommend-brand-line"></p>
                    <?php echo _rep_tags(80060, $_info, '<p class="recommend-title"><!--[word]--></p>'); ?>
                    <p>
                        <?php echo _rep_tags(80061, $_info, '<!--[word]-->'); ?>
                        <?php echo _rep_tags(80062, $_info, '<span><!--[word]--></span>'); ?>
                    </p>
                    <?php echo _rep_tags(80058, $_info, '</a>', '</a>'); ?>
                </div>

                <?php for ($i = 80063; $i <= 80064; $i++): ?>
                    <?php echo _rep_tags(
                        $i,
                        $_info,
                        '<a href="<!--[link]-->" <!--[target]--> class="recommend-imgbox"><img data-original="<!--[pic]-->" alt="<!--[alt]-->" class="lazy"></a>'
                    ); ?>
                <?php endfor; ?>

                <div class="recommend-box">
                    <?php echo _rep_tags(
                        80065,
                        $_info,
                        '<a href="<!--[link]-->" <!--[target]--> class="recommend-box-half-vertical pull-left">',
                        '<a href="javascript:void(0);" class="recommend-box-half-vertical pull-left">'
                    ); ?>
                    <em class="info-tra-left"></em>
                    <?php echo _rep_tags(80066, $_info, '<p class="recommend-brand"><!--[word]--></p>'); ?>
                    <p class="recommend-brand-line"></p>
                    <?php echo _rep_tags(80067, $_info, '<p class="recommend-title"><!--[word]--></p>'); ?>
                    <p class="recommend-orgin">
                        <?php echo _rep_tags(80068, $_info, '<!--[word]-->'); ?>
                        <?php echo _rep_tags(80069, $_info, '<span><!--[word]--></span>'); ?>
                    </p>
                    <?php echo _rep_tags(80065, $_info, '</a>', '</a>'); ?>

                    <?php echo _rep_tags(
                        80070,
                        $_info,
                        '<a href="<!--[link]-->" <!--[target]--> class="recommend-box-half-vertical pt70 pull-right">',
                        '<a href="javascript:void(0);" class="recommend-box-half-vertical pt70 pull-right">'
                    ); ?>
                    <em class="info-tra-top"></em>
                    <?php echo _rep_tags(80071, $_info, '<p class="recommend-brand"><!--[word]--></p>'); ?>
                    <p class="recommend-brand-line"></p>
                    <?php echo _rep_tags(80072, $_info, '<p class="recommend-title"><!--[word]--></p>'); ?>
                    <p class="recommend-orgin">
                        <?php echo _rep_tags(80073, $_info, '<!--[word]-->'); ?>
                        <?php echo _rep_tags(80074, $_info, '<span><!--[word]--></span>'); ?>
                    </p>
                    <?php echo _rep_tags(80070, $_info, '</a>', '</a>'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="talent-modal-ad clearfix">
    <div class="m-warp">
        <ul class="talent-ad-list">
            <?php for ($i = 80075; $i <= 80083; $i++): ?>
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