<!--影视行业-->
<div class="talent-modal clearfix">
    <div class="m-warp">
        <p class="talent-fac-title">
            <?php echo _rep_tags(90001, $_info, '<i class="icon-20"><img src="<!--[pic]-->"></i>'); ?>
            <?php echo _rep_tags(90002, $_info, '<span class="maintitle"><!--[word]--></span>'); ?>
            <?php echo _rep_tags(90003, $_info, '<i class="subtitle"><!--[word]--></i>'); ?>
        </p>

        <div class="talent-modal-box">
            <div class="talent-modal-left">
                <?php echo _rep_tags(
                    90004,
                    $_info,
                    '<a href="<!--[link]-->" <!--[target]--> class="talent-modal-subject"><img data-original="<!--[pic]-->" alt="<!--[alt]-->" class="lazy"></a>'
                ); ?>
                <span class="talent-modal-subject-p">
                    <b class="talent-modal-subject-bg"></b>
                    <?php $code = '';
                    for ($i = 90005; $i <= 90010; $i++): ?>
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
                        <?php for ($i = 90011; $i <= 90012; $i++): ?>
                            <?php echo _rep_tags(
                                $i,
                                $_info,
                                '<li><a href="<!--[link]-->" <!--[target]-->><!--[word]--></a></li>'
                            ); ?>
                        <?php endfor; ?>
                    </ul>
                    <ul class="words clearfix">
                        <li>
                            <?php for ($i = 90013; $i <= 90028; $i++): ?>
                                <?php echo _rep_tags(
                                    $i,
                                    $_info,
                                    '<a href="<!--[link]-->" <!--[target]--> class="<!--[active]-->"><!--[word]--></a>'
                                ); ?>
                            <?php endfor; ?>
                        </li>
                        <li>
                            <?php for ($i = 90029; $i <= 90044; $i++): ?>
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
                    90045,
                    $_info,
                    '<a href="<!--[link]-->" <!--[target]--> class="recommend-imgbox"><img data-original="<!--[pic]-->" alt="<!--[alt]-->" class="lazy"></a>'
                ); ?>

                <div class="recommend-box">
                    <?php echo _rep_tags(
                        90046,
                        $_info,
                        '<a href="<!--[link]-->" <!--[target]--> class="recommend-box-half">',
                        '<a href="javascript:void(0);" class="recommend-box-half">'
                    ); ?>
                    <em class="info-tra-left"></em>
                    <?php echo _rep_tags(90047, $_info, '<p class="recommend-brand"><!--[word]--></p>'); ?>
                    <p class="recommend-brand-line"></p>
                    <?php echo _rep_tags(90048, $_info, '<p class="recommend-title"><!--[word]--></p>'); ?>
                    <p>
                        <?php echo _rep_tags(90049, $_info, '<!--[word]-->'); ?>
                        <?php echo _rep_tags(90050, $_info, '<span><!--[word]--></span>'); ?>
                    </p>
                    <?php echo _rep_tags(90046, $_info, '</a>', '</a>'); ?>

                    <?php echo _rep_tags(
                        90051,
                        $_info,
                        '<a href="<!--[link]-->" class="recommend-box-half text-right pt25">',
                        '<a href="javascript:void(0);" class="recommend-box-half text-right pt25">'
                    ); ?>
                    <em class="info-tra-right"></em>
                    <?php echo _rep_tags(90052, $_info, '<p class="recommend-brand"><!--[word]--></p>'); ?>
                    <p class="recommend-brand-line"></p>
                    <?php echo _rep_tags(90053, $_info, '<p class="recommend-title"><!--[word]--></p>'); ?>
                    <p>
                        <?php echo _rep_tags(90054, $_info, '<!--[word]-->'); ?>
                        <?php echo _rep_tags(90055, $_info, '<span><!--[word]--></span>'); ?>
                    </p>
                    <?php echo _rep_tags(90051, $_info, '</a>', '</a>'); ?>
                </div>

                <?php for ($i = 90056; $i <= 90057; $i++): ?>
                    <?php echo _rep_tags(
                        $i,
                        $_info,
                        '<a href="<!--[link]-->" <!--[target]--> class="recommend-imgbox"><img data-original="<!--[pic]-->" alt="<!--[alt]-->" class="lazy"></a>'
                    ); ?>
                <?php endfor; ?>

                <div class="recommend-box">
                    <?php echo _rep_tags(
                        90058,
                        $_info,
                        '<a href="<!--[link]-->" <!--[target]--> class="recommend-box-all f36 text-right">',
                        '<a href="javascript:void(0);" class="recommend-box-all f36 text-right">'
                    ); ?>
                    <em class="info-tra-right"></em>
                    <?php echo _rep_tags(90059, $_info, '<p class="recommend-brand"><!--[word]--></p>'); ?>
                    <p class="recommend-brand-line"></p>
                    <?php echo _rep_tags(90060, $_info, '<p class="recommend-title"><!--[word]--></p>'); ?>
                    <p>
                        <?php echo _rep_tags(90061, $_info, '<!--[word]-->'); ?>
                        <?php echo _rep_tags(90062, $_info, '<span><!--[word]--></span>'); ?>
                    </p>
                    <?php echo _rep_tags(90058, $_info, '</a>', '</a>'); ?>
                </div>

                <?php for ($i = 90063; $i <= 90064; $i++): ?>
                    <?php echo _rep_tags(
                        $i,
                        $_info,
                        '<a href="<!--[link]-->" <!--[target]--> class="recommend-imgbox"><img data-original="<!--[pic]-->" alt="<!--[alt]-->" class="lazy"></a>'
                    ); ?>
                <?php endfor; ?>

                <div class="recommend-box">
                    <?php echo _rep_tags(
                        90065,
                        $_info,
                        '<a href="<!--[link]-->" <!--[target]--> class="recommend-box-half-vertical pull-left">',
                        '<a href="javascript:void(0);" class="recommend-box-half-vertical pull-left">'
                    ); ?>
                    <em class="info-tra-left"></em>
                    <?php echo _rep_tags(90066, $_info, '<p class="recommend-brand"><!--[word]--></p>'); ?>
                    <p class="recommend-brand-line"></p>
                    <?php echo _rep_tags(90067, $_info, '<p class="recommend-title"><!--[word]--></p>'); ?>
                    <p class="recommend-orgin">
                        <?php echo _rep_tags(90068, $_info, '<!--[word]-->'); ?>
                        <?php echo _rep_tags(90069, $_info, '<span><!--[word]--></span>'); ?>
                    </p>
                    <?php echo _rep_tags(90065, $_info, '</a>', '</a>'); ?>

                    <?php echo _rep_tags(
                        90070,
                        $_info,
                        '<a href="<!--[link]-->" <!--[target]--> class="recommend-box-half-vertical pt70 pull-right">',
                        '<a href="javascript:void(0);" class="recommend-box-half-vertical pt70 pull-right">'
                    ); ?>
                    <em class="info-tra-top"></em>
                    <?php echo _rep_tags(90071, $_info, '<p class="recommend-brand"><!--[word]--></p>'); ?>
                    <p class="recommend-brand-line"></p>
                    <?php echo _rep_tags(90072, $_info, '<p class="recommend-title"><!--[word]--></p>'); ?>
                    <p class="recommend-orgin">
                        <?php echo _rep_tags(90073, $_info, '<!--[word]-->'); ?>
                        <?php echo _rep_tags(90074, $_info, '<span><!--[word]--></span>'); ?>
                    </p>
                    <?php echo _rep_tags(90070, $_info, '</a>', '</a>'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="talent-modal-ad clearfix">
    <div class="m-warp">
        <ul class="talent-ad-list">
            <?php for ($i = 90075; $i <= 90083; $i++): ?>
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