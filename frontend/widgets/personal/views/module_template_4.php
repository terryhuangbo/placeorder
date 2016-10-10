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
    <ul class="personal-official-activity">
        <?php
        for ($i = 2; $i <= 6; $i++)
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