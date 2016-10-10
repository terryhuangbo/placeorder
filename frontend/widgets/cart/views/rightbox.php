<link rel="stylesheet" href="<?php echo $_proxy_dir;?>/static/css/popout.css">
<link rel="stylesheet" href="<?php echo $_proxy_dir;?>/static/css/shop_rightbox.css">
<div class="vso-rightbox">
    <!-- 如果购物车非空，将类cartright-empty去掉 -->
    <div class="vso-rightbox-box vso-rightbox-cart <?= empty($_cart_count) ? 'cartright-empty' : '' ?>">
        <a class="vso-rightbox-block">
            <?= empty($_cart_count) ? '' : '<i class="icon-cart-update"></i>' ?>
        </a>

        <div class="vso-rightbox-pop">
            <div class="vso-rightbox-sidefill"></div>
            <div class="vso-rightbox-triangle"></div>
            <div class="vso-rightbox-triangle-border"></div>
            <div class="cartright-pop-top">
                <div class="cartright-pop-title">
                    购物车（<span class="cartright-pop-count"><?= $_cart_count ?></span>）
                </div>
                <ul class="cartright-pop-list">
                    <?= $_cart_li ?>
                </ul>
                <div class="cartright-pop-empty">
                    <div class="cartright-empty-img">
                        <img src="<?php echo $_proxy_dir;?>/static/images/rightbox/icon-70-cart.png" alt="购物车">
                    </div>
                    <div class="cartright-empty-first">购物车空空的</div>
                    <div class="cartright-empty-second">赶紧去挑选喜爱的商品!</div>
                    <div class="cartright-empty-link">
                        <a target="_blank" href="<?= yii::$app->params['shop_frontendurl'] ?>">“去逛逛”</a>
                    </div>
                </div>
            </div>
            <div class="cartright-pop-bottom">
                <a class="cartright-pop-balance" <?= empty($_cart_count) ? '' : 'target="_blank"' ?>
                   href="<?= empty($_cart_count) ? 'javascript:void(0)' : (yii::$app->params['shop_frontendurl'] . '/index/cart/cartlist') ?>">去购物车结算</a>

                <div class="cartright-pop-total">合计<span class="cartright-pop-amount">&yen;<?= $_cart_amount ?></span></div>
            </div>
        </div>
    </div>
    <div class="vso-rightbox-box vso-rightbox-wechat">
        <a class="vso-rightbox-block"></a>

        <div class="vso-rightbox-pop">
            <div class="vso-rightbox-sidefill"></div>
            <div class="vso-rightbox-triangle"></div>
            <div class="vso-rightbox-triangle-border"></div>
            <dl>
                <dt>
                    <img src="<?php echo yiiParams('http_proxy')['static.vsochina.com'];?>/public/rightbox/images/vso-rightbox/vso-qrcode.jpg" alt="蓝海创意云">
                </dt>
                <dd class="vso-rightbox-title">蓝海创意云微信</dd>
                <dd class="vso-rightbox-subtitle">扫描二维码分享到微信，沟通永不离线！</dd>
            </dl>
            <p><b class="vso-rightbox-red">*</b>您还可以关注蓝海创意云新浪微博</p>
        </div>
    </div>
    <div class="vso-rightbox-box vso-rightbox-top">
        <a class="vso-rightbox-block"></a>
    </div>
</div>
<script type="text/javascript" src="<?php echo $_proxy_dir;?>/static/js/popout.js"></script>
<script type="text/javascript">
    $(function () {
        $(document).on('mouseover mouseleave', '.vso-rightbox-box', function (event) {
            var _this = $(this),
                _obj = _this.find('.vso-rightbox-pop');
            if (_obj) {
                if (event.type == "mouseover") {
                    _obj.show();
                }
                else if (event.type == "mouseleave") {
                    _obj.hide();
                }
            }
        });

        $(window).scroll(function () {
            blackTop();
        });
        blackTop();
        function blackTop() {
            var _obj = $(".vso-rightbox-top");
            if ($(window).scrollTop() < 200) {
                _obj.hide();
            }
            else {
                _obj.show();
            }
        }

        $(document).on('click', '.vso-rightbox-top', function () {
            $('body,html').animate({scrollTop: 0}, 500);
            $(this).hide();
        });
        $(".cartright-item-close").on("click", function () {
            delete_cart($(this));
        });
    });
    $('._add_to_cart').click(function () {
        var goods_id = $(this).attr('goods-id');
        if (goods_id) {
            $.ajax({
                url: '<?php echo yii::$app->params['shop_frontendurl'] . yii::$app->urlManager->createUrl(['/index/cart/add'])?>',
                data: {goods_id: goods_id},
                jsonp: 'jsonpcallback',
                dataType: 'jsonp',
                success: function (d) {
                    if (d.ret == -20000) {
                        window.location.href = '<?php echo yii::$app->params['loginUrl'];?>';
                    } else if (d.ret == 20001) {
                        refresh_cart();
                        _alert(d.msg);
                    } else {
                        _alert(d.msg);
                    }
                }
            });
        } else {
            _alert('未找到商品数据！');
        }
    });    
    function refresh_cart()
    {
        $.ajax({
            url: '<?php echo yii::$app->params['shop_frontendurl'] . yii::$app->urlManager->createUrl(['/index/cart/refresh-cart'])?>',
            jsonp: 'jsonpcallback',
            dataType: 'jsonp',
            success: function (d) {
                if (d.ret === 20001) {
                    if(0<d.data._cart_count)
                    {
                        $('.vso-rightbox-cart').removeClass("cartright-empty");
                        $('.vso-rightbox-block').html('<i class="icon-cart-update"></i>');
                        $('.cartright-pop-balance').attr('href','<?=yii::$app->params['shop_frontendurl'] . '/index/cart/cartlist'?>');
                        $('.cartright-pop-balance').attr('target','_blank');
                    }
                    else
                    {
                        $('.vso-rightbox-cart').addClass("cartright-empty");
                        $('.vso-rightbox-block').html('');
                        $('.cartright-pop-balance').attr('href','javascript:void(0)');
                        $('.cartright-pop-balance').removeAttr('target');
                    }                    
                    $('.cartright-pop-count').html(d.data._cart_count);
                    $('.cartright-pop-list').html(d.data._cart_li);
                    $('.cartright-pop-amount').html('&yen;'+d.data._cart_amount);
                    $(".cartright-item-close").on("click", function () {
                        delete_cart($(this));
                    });
                } 
            }
        });
    }    
    
    function delete_cart(_obj)
    {
        var cartId = _obj.attr("id");
        $.ajax({
            jsonp: 'jsonpcallback',
            url: "<?=yii::$app->params['shop_frontendurl']?>/index/cart/delete?id=" + cartId,
            dataType: "jsonp",
            success: function (json) {
                if (json.ret === 20001) {
                    refresh_cart();
                }
                else {
                    _alert(json.msg);
                }
            }
        });
    }
</script>