<div class="personal-ads">
    <div class="personal-title-box clear-float">
        <?php
        echo _r_tag(
            1,
            $_push_info,
            '<span class="personal-title"><!--[word]--></span>'
        );
        ?>
    </div>
    <ul class="personal-talent-together">
        <?php
        for($i=2;$i<=5;$i++){
            echo _r_tag(
                $i,
                $_push_info,
                '<li>
                    <a <!--[target]--> href="<!--[link]-->" class="personal-bigger">
                        <div class="talent-together-bg">
                            <img src="<!--[image]-->">
                        </div>
                        <p>
                            <span class="fs30"><!--[word]--></span>
                            <span class="fs16"><!--[word2]--></span>
                            <!--[word3]-->
                            <span><!--[word4]--></span>
                            <!--[word5]-->
                        </p>
                    </a>
                </li>'
            );
        }
        ?>
    </ul>
</div>