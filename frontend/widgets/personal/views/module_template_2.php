<div class="personal-ads">
    <div class="personal-title-box clear-float">
        <span class="personal-title">人才排行榜</span>
        <a target="_blank" href="<?php echo yii::$app->params['rc_frontendurl']?><?php echo yii::$app->urlManager->createUrl(
            ['/rc/index/rank']); ?>" class="personal-subtitle">More</a>
    </div>
    <ul class="personal-talent-list">

        <?php if (!empty($rc_sort['rc'])): ?>
            <?php $i = 1; ?>
            <?php foreach ($rc_sort['rc'] as $val): ?>
                <?php if ($i > 5)
                {
                    break;
                } ?>
                <li>
                    <dl>
                        <dt>
                            <a target="_blank" href="<?php echo yii::$app->params['rc_frontendurl']?><?php echo yii::$app->urlManager->createUrl(
                                ['/talent/default/view', 'username' => $val['username']]
                            ) ?>" class="talent-list-portrait">
                                <img src="<?php echo $val['avatar']; ?>">
                            </a>
                            <!--<i class="icon-14 icon-rise"></i>-->
                        </dt>
                        <dd class="talent-list-name"><?php echo $val['nickname']; ?></dd>
                        <dd class="talent-list-tag">-</dd>
                    </dl>
                    <i class="icon-32 <?php if ($i == 1): echo('gold');
                    elseif ($i == 2): echo('silver');
                    elseif ($i == 3): echo('bronze'); endif; ?> rankno"><?php echo $i; ?></i>
                </li>
                <?php $i++; ?>
            <?php endforeach; ?>
        <?php endif; ?>

    </ul>
</div>