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

    public function init(){
        $this->_uncheck = [

        ];
    }

    /**
     * 用户中心
     * @return type
     */
    public function actionIndex()
    {
        $user = $this->user;
        $gid = $this->req('gid', 0);
        lg($gid);
        $goods = (new Goods())->getOne(['gid'  => $gid]);
        //商品为空，跳转到商品首页
        if(empty($goods)){
            $this->redirect('/plorder/goods/index');
        }
        lg($this->userLog);
        if($this->userLog){
            $info = $this->user;
        }else{
            $info['username'] = $this->card['card_bn'];
            $info['login_time'] = $this->card['create_time'];
            $info['points'] = $this->card['points'];
        }
        $_data = [
            'info' => $info,
            'goods' => $goods,
            'userLog' => (int) $this->userLog,
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
        if($this->userLog){
            $post['uid'] = $this->uid;
            $scenario = Order::SCENARIO_USER;
        }else{
            $post['card_bn'] = $this->card_bn;
            $scenario = Order::SCENARIO_CARD;
        }
        $mdl = new Order();
        $ret = $mdl->saveOrder($post, $scenario);
        return json_encode($ret);

    }

    /**
     * 批量下单
     * @return type
     */
    public function actionBatchAdd()
    {
        $text = $this->req('text', '');
        $gid  = $this->req('gid', 0);

        $orders = [];
        if(empty($text)){
            return $this->toJson('-20001', '请输入下单QQ和数量');
        }

        //获取qq-num
        $patter = '/(.*)(\s)*\b/';
        preg_match_all($patter, $text, $result);

        $patter1 = '/(\w+)-{4}(\w+)/';
        $str_arr = getValue($result, 1, []);
        foreach($str_arr as $str){
            if(!empty($str)){
                preg_match_all($patter1, $str, $res);
                $qq = reset($res[1]);
                $num = reset($res[2]);
                if(ctype_digit($qq) && ctype_digit($num)){
                    $orders[] = [
                        'qq' => $qq,
                        'num' => $num,
                        'uid' =>$this->uid,
                        'gid' =>$gid,
                    ];
                }
            }
        }

        //保存
        $success = [];
        foreach($orders as $order){
            $mdl = new Order();
            $ret = $mdl->saveOrder($order);
            if($ret['code'] < 0){
                $_pre_msg = "QQ为{$order['qq']}下单失败：";
                $_suf_msg = count($success) > 0 ? '。已成功下单QQ：' . implode($success, '，') : '';
                return $this->toJson('-20001', $_pre_msg . $ret['msg'] . $_suf_msg);
            }
            $success[] = $order['qq'];
        }
        $_suf_msg = count($success) > 0 ? '已成功下单QQ：' . implode($success, '，') : '';
        return $this->toJson('20000', $_suf_msg);

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



}
