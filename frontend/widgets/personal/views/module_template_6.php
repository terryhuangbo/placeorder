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
        <a href="<?php echo yii::$app->params['rc_frontendurl'] . yii::$app->urlManager->createUrl(['rc/personal/cover_story', 'w_id' => $_widget_id]); ?>"
           target="_blank" class="personal-subtitle">More</a>
        <?php
        /*echo _r_tag(
            3,
            $_push_info,
            '<a <!--[target]--> href="<!--[link]-->" class="personal-subtitle"><!--[word]--></a>'
        );*/
        ?>
    </div>
    <div class="personal-cover-story">
        <div class="personal-cover-left fl">
            <?php
            echo _r_tag(
                4,
                $_push_info,
                '<a <!--[target]--> href="<!--[link]-->"><img src="<!--[image]-->"></a>'
            );
            ?>
        </div>
        <div class="personal-cover-intro fl">
            <i class="personal-triangle"></i>
            <div class="cover-intro-left fl">
                <?php
                echo _r_tag(
                    5,
                    $_push_info,
                    '<p class="cover-intro-author"><!--[word]--></p>'
                );
                ?>
                <?php
                echo _r_tag(
                    6,
                    $_push_info,
                    '<p class="cover-intro-tag"><!--[word]--></p>'
                );
                ?>
                <?php
                echo _r_tag(
                    7,
                    $_push_info,
                    '<p class="cover-intro-fans"><!--[word]--></p>'
                );
                ?>
            </div>
            <div class="cover-intro-right fr">
                <p>
                    <?php
                    echo _r_tag(
                        8,
                        $_push_info,
                        '<!--[word]-->'
                    );
                    ?>
                    <?php
                    echo _r_tag(
                        9,
                        $_push_info,
                        '<a <!--[target]--> href="<!--[link]-->" class="personal-readmore"><!--[word]--></a>'
                    );
                    ?>
                </p>
            </div>
        </div>
        <ul class="personal-cover-works fl">
            <?php
            for ($i = 10; $i <= 13; $i++)
            {
                echo _r_tag(
                    $i,
                    $_push_info,
                    '<li>
                        <a <!--[target]--> href="<!--[link]-->" class="personal-bigger">
                            <img src="<!--[image]-->">
                        </a>
                    </li>'
                );
            }
            ?>
        </ul>
    </div>
</div>