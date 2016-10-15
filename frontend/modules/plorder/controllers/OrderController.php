<?php

namespace frontend\modules\plorder\controllers;

use common\models\CartGoods;
use common\models\Goods;
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
     * 用户中心
     * @return type
     */
    public function actionIndex()
    {
        $user = $this->user;
        $gid = $this->req('gid', 47);
        $user['login_time'] = date('Y-m-d H:i:s', $user['login_time']);
        $goods = (new Goods())->getOne(['gid'  => $gid]);
        //商品为空，跳转到商品首页
        if(empty($goods)){
            $this->redirect('/plorder/goods/index');
        }
        $_data = [
            'user' => $user,
            'goods' => $goods,
        ];
        return $this->render('index', $_data);
    }

    /**
     * 生成订单
     * @return type
     */
    public function actionAdd()
    {
        $post = $this->req();
        $post['uid'] = $this->uid;
        $mdl = new Order();
        $ret = $mdl->saveOrder($post);
        return json_encode($ret);

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
