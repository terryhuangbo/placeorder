<div class="personal">
    <div class="personal-banner">
        <div class="personal-banner-bg personal-blur">
            <div class="personal-banner-img"></div>
            <div class="personal-banner-mask"></div>
        </div>
        <div class="personal-banner-content">
            <div class="personal-banner-meta">
                <?php
                echo _r_tag(
                    1,
                    $_push_info,
                    '<h3>《<span><!--[title]--></span>》</h3><h4>作者：<span><!--[author]--></span></h4><hr><h5><!--[tag]--></h5>'
                );
                ?>
            </div>
            <div class="personal-banner-show">
                <ul class="personal-banner-graphic">
                    <?php
                    for ($i = 11; $i <= 18; $i++)
                    {
                        echo _r_tag(
                            $i,
                            $_push_info,
                            '<li><a <!--[target]--> href="<!--[link]-->"><img src="<!--[image]-->"></a></li>'
                        );
                    }
                    ?>
                </ul>
                <div class="personal-banner-control">
                    <ul>
                        <?php
                        for ($i = 1; $i <= 8; $i++)
                        {
                            echo _r_tag(
                                $i,
                                $_push_info,
                                '<li class="control-unit" data-name="<!--[title]-->" data-author="<!--[author]-->" data-tag="<!--[tag]-->"><a <!--[target]--> href="<!--[link]-->"><img src="<!--[image]-->"></a></li>'
                            );
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>