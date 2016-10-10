<?php
/**
 * Created by PhpStorm.
 * User: Qingwenjie
 * Date: 2016/2/29
 * Time: 17:27
 */
namespace frontend\widgets\cart;

use common\models_shop\ShopWidget;
use yii;
use common\lib\Tools;
use common\models_shop\shop_cart;
class CartWidget extends ShopWidget {

    public $_proxy_dir = '';

    public function init() {

    }

    public function run() {
        $user_info = (new Tools)->_get_user_info();
        if(!empty($user_info))
        {
            $cart=new shop_cart();
            //获取用户购物车数据
            $user_cart=$cart->_get_list_with_goods(['buyer_username'=>$user_info['username']], 'add_time desc', 1, 0);
        }
        if(!empty($user_cart))
        {
            //设置用户购物车显示数据
            $cart_count=count($user_cart);
            $cart_data=$this->_prepare_cart_data($user_cart);
            $cart_li=$cart_data['cart_li'];
            $cart_amount=$cart_data['cart_amount'];
        }
        $data = [
            '_user_info' => $user_info,
            '_cart_count' => empty($cart_count)?0:$cart_count,
            '_cart_li' => empty($cart_li)?'':$cart_li,
            '_cart_amount' => empty($cart_amount)?0:sprintf("%.2f",$cart_amount),
            '_proxy_dir' => $this->_proxy_dir,
        ];
        return $this->render('rightbox', $data);
    }
    
    /**
     * 设置前台浮动购物车数据
     * @param type $user_cart
     * @return type
     */
    public function _prepare_cart_data($user_cart)
    {
        $cart_amount=0;
        $li='';
        foreach ($user_cart as $cart)
        {
            $li.='<li>
                <a class="j-close cartright-item-close" id="'.$cart['cart_id'].'"></a>
                <a target="_blank" href="'.yii::$app->params['shop_frontendurl'].'/index/index/detail?id='.$cart['goods_id'].'">
                    <dl class="clearfix">
                        <dt><img src="' . yiiParams('cloud_box')['thumbnail'] . '?' . http_build_query(['username' => $cart['shop_goods']['username'], 'width' => '120', 'height' => '120', 'path' => $cart['shop_goods']['thumb']]) . '" alt="'.$cart['shop_goods']['name'].'" alt="'.$cart['shop_goods']['name'].'"></dt>
                        <dd class="cartright-item-firstline" title="'.$cart['shop_goods']['name'].'">'.$cart['shop_goods']['name'].'</dd>
                        <dd class="cartright-item-secondline">价格：<span title="'.$cart['shop_goods']['price'].'">'.$cart['shop_goods']['price'].'</span></dd>
                    </dl>
                </a>
            </li>';
            $cart_amount=$cart_amount+$cart['shop_goods']['price'];
        }
        return ['cart_li'=>$li,'cart_amount'=>$cart_amount];
    }
}