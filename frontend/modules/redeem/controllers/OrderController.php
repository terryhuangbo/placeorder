<?php

namespace frontend\modules\redeem\controllers;

use common\models\CartGoods;
use common\models\Order;
use Yii;
use app\base\BaseController;
use common\models\User;
use common\models\Auth;
use common\models\Address;


class OrderController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;


    /**
     * 生成订单
     * @return type
     */
    public function actionAdd()
    {
        $gids = json_decode($this->_request('gids'));
        if(empty($gids)){
            $this->_json(-20001, '没有选择购物车的任何商品');
        }

        $m_mdl = new Address();

        $cg_mdl = new CartGoods();
        $total_points = 0;
        $list = $cg_mdl->_get_list_all(['in' , 'id', $gids]);
        if($list){
            foreach($list as $val){
                $total_points += $val['count'] * getValue($val, 'goods.redeem_pionts', 0);
            }
        }

        //收货地址
        $address = $m_mdl->_get_info([
            'uid' => $this->uid,
            'is_default' => $m_mdl::DEFAULT_YES,
            'is_deleted' => $m_mdl::NO_DELETE
        ]);
        $address['type_name'] = $m_mdl::_get_address_type_name($address['type']);

        $_data = [
            'cart_goods' => $list,
            'total_points' => $total_points,
            'address' => $address,
        ];
        return $this->render('add', $_data);
    }

    /**
     * 订单列表
     * @return type
     */
    public function actionList()
    {
        $r_mdl = new Order();
        $list = $r_mdl->_get_list_all([$r_mdl::tableName() . '.uid' => $this->uid, 'order_status' => Order::STATUS_PAY]);
        $_data = [
            'order_list' => $list,
        ];
        return $this->render('list', $_data);
    }

    /**
     * 生成订单
     * @return type
     */
    public function actionAjaxAdd()
    {
        $gids = json_decode($this->_request('gids'));
        if(empty($gids)){
            $this->_json(-20001, '没有选择购物车的任何商品');
        }

        $order = new Order();
        $res = $order->_add_orders($this->uid, $gids);
        $this->_json($res['code'], $res['msg']);
    }

    /**
     * 兑换
     * @return type
     */
    public function actionPay()
    {
        $oids = json_decode($this->_request('oids'));
        if(empty($oids)){
            $this->_json(-20001, '您没有选择任何订单');
        }

        $order = new Order();
        $res = $order->_pay_orders($this->uid, $oids);
        $this->_json($res['code'], $res['msg']);
    }

}
