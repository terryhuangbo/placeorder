<div class="personal-intro">
    <div class="personal-title-box clear-float">
        <?php
        echo _r_tag(
            1,
            $_push_info,
            '<span class="personal-title"><!--[word]--></span>'
        );
        ?>
        <?php
        echo _r_tag(
            2,
            $_push_info,
            '<span class="personal-additional"><!--[word]--></span>'
        );
        ?>
        <a href="<?php echo yii::$app->params['rc_frontendurl'] . yii::$app->urlManager->createUrl(['rc/personal/weekly', 'w_id' => $_widget_id]); ?>"
           target="_blank" class="personal-subtitle">More</a>
        <?php
        /*echo _r_tag(
            3,
            $_push_info,
            '<a <!--[target]--> href="<!--[link]-->" class="personal-subtitle"><!--[word]--></a>'
        );*/
        ?>
    </div>
    <div class="personal-creative-weekly">
        <?php
        echo _r_tag(
            4,
            $_push_info,
            '<div class="personal-weekly-top"><a <!--[target]--> href="<!--[link]-->"><img src="<!--[image]-->"></a></div>'
        );
        ?>

        <div class="personal-weekly-bottom">
            <div class="weekly-bottom-box weekly-bottom-text personal-firstcolor">
                <hr>
                <?php
                echo _r_tag(
                    5,
                    $_push_info,
                    '<p class="weekly-bottom-works"><!--[word]--></p>'
                );
                ?>
                <?php
                echo _r_tag(
                    6,
                    $_push_info,
                    '<p class="weekly-bottom-tag"><!--[word]--></p>'
                );
                ?>
                <?php
                echo _r_tag(
                    7,
                    $_push_info,
                    '<p class="weekly-bottom-author"><!--[word]--></p>'
                );
                ?>
                <i class="personal-triangle"></i>
            </div>
            <div class="weekly-bottom-box weekly-bottom-smallimg">
                <?php
                echo _r_tag(
                    8,
                    $_push_info,
                    '<a <!--[target]--> href="<!--[link]-->" class="personal-bigger"><img src="<!--[image]-->" /></a>'
                );
                ?>
            </div>
            <div class="weekly-bottom-box weekly-bottom-text personal-secondcolor">
                <hr>
                <?php
                echo _r_tag(
                    9,
                    $_push_info,
                    '<p class="weekly-bottom-works"><!--[word]--></p>'
                );
                ?>
                <?php
                echo _r_tag(
                    10,
                    $_push_info,
                    '<p class="weekly-bottom-tag"><!--[word]--></p>'
                );
                ?>
                <?php
                echo _r_tag(
                    11,
                    $_push_info,
                    '<p class="weekly-bottom-author"><!--[word]--></p>'
                );
                ?>
                <i class="personal-triangle"></i>
            </div>
            <div class="weekly-bottom-box weekly-bottom-bigimg">
                <?php
                echo _r_tag(
                    12,
                    $_push_info,
                    '<a <!--[target]--> href="<!--[link]-->" class="personal-bigger"><img src="<!--[image]-->"></a>'
                );
                ?>
            </div>
        </div>
    </div>
</div>