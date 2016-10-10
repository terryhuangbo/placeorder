<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use app\base\BaseController;
use common\models\Address;
use common\models\Order;

class AddressController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;

    /**
     * 添加地址
     * @return type
     */
    public function actionAdd()
    {
        //加载
        if(!$this->isAjax()){
            return $this->render('add', ['uid' => $this->uid]);
        }
        //保存
        $param = $this->_post();
        $param['uid'] = $this->uid;
        $res = (new Address())->_add_address($param);
        if($res['code'] < 0 ){
            $this->_json($res['code'], $res['msg']);
        }
        $this->_json($res['code'], $res['msg'], $res['data']);
    }

    /**
     * 更改地址
     * @return type
     */
    public function actionUpdate()
    {
        $add_id = $this->_request('add_id');
        //加载
        if(!$this->isAjax()){
            $add = (new Address())->_get_info(['add_id' => $add_id]);
            //如果没有，跳回列表页
            if(!$add){
                $this->redirect('/redeem/my/address');
            }
            $_data = [
                'uid' => $this->uid,
                'add' => $add,
            ];
            return $this->render('update', $_data);
        }
        //保存
        $param = $this->_request();
        $param['uid'] = $this->uid;
        $res = (new Address())->_add_address($param);
        if($res['code'] < 0 ){
            $this->_json($res['code'], $res['msg']);
        }
        $this->_json($res['code'], $res['msg'], $res['data']);
    }

    /**
     * 添加地址
     * @return type
     */
    public function actionChangeOrderAddress()
    {
        //加载
        if(!$this->isAjax()){
            $oid = $this->_request('oid');
            $_data = [
                'uid' => $this->uid,
                'oid' => $oid,
            ];
            return $this->render('order', $_data);
        }
        //保存
        $param = Yii::$app->request->post();
        $param['uid'] = $this->uid;
        $oid = $param['oid'];
        unset($param['oid']);
        lg($param);
        $res = (new Address())->_add_address($param);
        if($res['code'] < 0 ){
            $this->_json($res['code'], $res['msg']);
        }
        //修改订单地址
        $r_mdl = new Order();
        if(empty($oid)){
            $this->_json(-20001, '订单id不能为空');
        }
        $odr = $r_mdl->_get_info(['oid' => $oid, 'order_status' => Order::STATUS_PAY]);
        if(!$odr){
            $this->_json(-20001, '订单不存在，或者不能修改订单地址');
        }
        $add_id = $res['data']['add_id'];
        $ret = $r_mdl->_save([
            'oid' => $oid,
            'add_id' => $add_id,
        ]);
        if(!$ret){
            $this->_json(-20002, '订单地址修改失败');
        }
        $this->_json(20000, '订单地址修改成功');
    }

}
