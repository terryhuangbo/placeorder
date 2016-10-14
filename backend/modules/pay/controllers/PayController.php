<?php

namespace backend\modules\pay\controllers;

use common\models\Goods;
use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\Pay;

class PayController extends BaseController
{

    /**
     * 路由权限控制
     * @return array
     */
    public function limitActions()
    {
        return [
            'list',
            'list-view',
            'add',
            'info',
            'save',
            'update',
            'ajax-save',
            'ajax-delete',
            'ajax-change-status',
            'ajax-save-logestic',
        ];
    }

    /**
     * 订单列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 订单数据
     */
    public function actionList()
    {
        if ($this->isGet()) {
            return $this->render('list');
        }
        $mdl = new Pay();
        $query = $mdl::find();
        $search = $this->req('search');
        $page = $this->req('page', 0);
        $pageSize = $this->req('pageSize', 10);
        $offset = $page * $pageSize;
        $or_tb = Pay::tableName();
        $ur_tb = Goods::tableName();
        if ($search) {
            if (isset($search['uptimeStart'])) //时间范围
            {
                $query = $query->andWhere(['>', $or_tb . '.update_at', strtotime($search['uptimeStart'])]);
            }
            if (isset($search['uptimeEnd'])) //时间范围
            {
                $query = $query->andWhere(['<', $or_tb . '.update_at', strtotime($search['uptimeEnd'])]);
            }
            if (isset($search['goods_id'])) //商品编号
            {
                $query = $query->andWhere(['goods_id' => $search['goods_id']]);
            }
            if (isset($search['pay_status'])) //订单状态
            {
                $query = $query->andWhere(['pay_status' => $search['pay_status']]);
            }
            if (isset($search['goods_name'])) //商品名称
            {
                $query = $query->andWhere(['like', $or_tb . '.goods_name', $search['goods_name']]);
            }
        }

        $_pay_by = 'oid DESC';
        $query_count = clone($query);
        $payArr = $query
            ->joinWith('order')
            ->joinWith('user')
            ->offset($offset)
            ->limit($pageSize)
            ->orderBy($_pay_by)
            ->all();

        $count = $query_count->count();
        $payList = ArrayHelper::toArray($payArr, [
            'common\models\Pay' => [
                'oid',
                'uid',
                'cost',
                'username' => 'user.username',
                'balance',
                'order_bn' => 'order.order_bn',
                'goods_bn' => 'order.goods.goods_bn',
                'goods_name' => 'order.goods.name',
                'create_time' => function ($m) {
                    return date('Y-m-d h:i:s', $m->create_time);
                },
            ],
        ]);
        $_data = [
            'payList' => $payList,
            'totalCount' => $count
        ];
        return json_encode($_data);
    }

    /**
     * 添加订单
     * @return array
     */
    function actionAdd()
    {
        if(!$this->isAjax()){
            return $this->render('add');
        }
        $pay = $this->req('pay', []);
        if(isset($pay['oid'])){
            unset($pay['oid']);
        }
        $mdl = new Pay();
        $res = $mdl->savePay($pay);
        $this->toJson($res['code'], $res['msg']);
    }

    /**
     * 添加订单
     * @return array
     */
    function actionUpdate()
    {
        $oid = intval($this->req('oid'));
        $mdl = new Pay();
        //检验参数是否合法
        if (empty($oid)) {
            $this->toJson(-20001, '订单序号oid不能为空');
        }

        //检验订单是否存在
        $pay = $mdl->getOne(['oid' => $oid]);
        if (!$pay) {
            $this->toJson(-20002, '订单信息不存在');
        }
        $_data = [
            'pay' => $pay,
            'status_list' => $mdl::getPayStatus(),
        ];
        return $this->render('update', $_data);
    }

    /**
     * 改变订单状态
     * @return array
     */
    function actionAjaxSave()
    {
        $oid = intval($this->req('oid'));
        $pay_info = $this->req('pay', []);

        $mdl = new Pay();
        //检验参数是否合法
        if (empty($oid)) {
            $this->toJson(-20001, '订单序号oid不能为空');
        }
        if(empty($pay_info['pay_status'])){
            $this->toJson(-20002, '订单状态不能为空');
        }

        //检验订单是否存在
        $pay = $mdl->_get_info(['oid' => $oid]);
        if (!$pay) {
            $this->toJson(-20002, '订单信息不存在');
        }
        $res = $mdl->_save([
            'oid' => $oid,
            'pay_status' => intval($pay_info['pay_status']),
        ]);
        if(!$res){
            $this->toJson(-20003, '保存失败');
        }

        //保存
        $this->toJson(20000, '保存成功');
    }

    /**
     * 改变订单状态
     * @return array
     */
    function actionAjaxDelete()
    {
        $oid = intval($this->req('oid'));

        $mdl = new Pay();
        //检验参数是否合法
        if (empty($oid)) {
            $this->toJson(-20001, '订单序号oid不能为空');
        }

        //检验订单是否存在
        $pay = $mdl->_get_info(['oid' => $oid]);
        if (!$pay) {
            $this->toJson(-20002, '订单信息不存在');
        }

        $res = $mdl->_save([
            'oid' => $oid,
            'is_deleted' => $mdl::IS_DELETE,
        ]);
        if(!$res){
            $this->toJson(-20003, '删除失败');
        }
        $this->toJson(20000, '删除成功');
    }

    /**
     * 加载订单详情
     */
    function actionInfo()
    {
        $oid = intval($this->req('oid'));

        $mdl = new Pay();
        //检验参数是否合法
        if (empty($oid)) {
            $this->toJson(-20001, '用户编号id不能为空');
        }

        //检验用户是否存在
        $pay = $mdl->getRelationOne(['oid' => $oid], ['with' => ['goods']]);
        if (!$pay) {
            $this->toJson(-20003, '用户信息不存在');
        }
        $pay['create_time'] = date('Y-m-d h:i:s', $pay['create_time']);
        $_data = [
            'pay' => $pay
        ];
        return $this->render('info', $_data);
    }




}
