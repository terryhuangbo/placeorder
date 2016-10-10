<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use app\base\BaseController;
use common\models\CartGoods;


class CartController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;


    /**
     * 生成订单
     * @return type
     */
    public function actionList()
    {
        return $this->render('list');
    }

    /**
     * 兑换
     * @return type
     */
    public function actionPay()
    {
        return $this->render('pay');
    }

    /**
     * 添加购物车商品
     * @return type
     */
    public function actionAjaxAddGoods()
    {
        $gid = intval($this->_request('gid'));
        $count = intval($this->_request('count'));

        $cg_mdl = new CartGoods();
        $res = $cg_mdl->_add_goods(['uid' => $this->uid, 'gid' => $gid, 'count' => $count]);
        $this->_json($res['code'], $res['msg']);
    }

    /**
     * 购物车商品列表
     * @return type
     */
    public function actionGoodsList()
    {
        $cg_mdl = new CartGoods();
        $list = $cg_mdl->_get_list_all([$cg_mdl::tableName() . '.uid' => $this->uid]);
        $total_points = 0;
        if($list){
            foreach($list as $val){
                $total_points += $val['count'] * getValue($val, 'goods.redeem_pionts', 0);
            }
        }
        $_data = [
            'cart_goods' => $list,
            'total_points' => $total_points,
        ];
        return $this->render('list', $_data);
    }

    /**
     *改变向购物车商品数量
     * @return array|boolean
     */
    public function actionAjaxChangeGoodsNum()
    {
        $newnum = intval($this->_request('num'));
        $cg_id = intval($this->_request('cg_id'));
        $mdl = new CartGoods();
        $cg = $mdl->_get_info(['id' => $cg_id]);
        if(!$cg){
            $this->_json(-20001, '购物车商品不存在');
        }

        if($newnum < 0){
            $this->_json(-20002, '购物车商品数量不能为负数');
        }
        if($newnum > 0){
            $ret = $mdl->_save([
                'id' => $cg_id,
                'count' => $newnum,
            ]);
            if(!$ret){
                $this->_json(-20003, '购物车商品更改失败');
            }
        }else{ //删除
            $ret = $mdl->_delete(['id' => $cg_id ]);
            if($ret === false){
                $this->_json(-20003, '购物车商品删除失败');
            }
        }

        $this->_json(20000, '保存成功');
    }

}
