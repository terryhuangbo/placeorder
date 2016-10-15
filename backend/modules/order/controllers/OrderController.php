<?php

namespace backend\modules\order\controllers;

use common\models\Goods;
use Yii;
use yii\base\Object;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\User;
use common\models\Order;

class OrderController extends BaseController
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
            'logistic',
            'ajax-save',
            'ajax-delete',
            'ajax-change-status',
            'ajax-save-logestic',
            'logestic-detail',
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
        $mdl = new Order();
        $query = $mdl::find();
        $search = $this->req('search');
        $page = $this->req('page', 0);
        $pageSize = $this->req('pageSize', 10);
        $offset = $page * $pageSize;
        $or_tb = Order::tableName();
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
            if (isset($search['order_status'])) //订单状态
            {
                $query = $query->andWhere(['order_status' => $search['order_status']]);
            }
            if (isset($search['goods_name'])) //商品名称
            {
                $query = $query->andWhere(['like', $or_tb . '.goods_name', $search['goods_name']]);
            }
        }

        $_order_by = 'oid DESC';
        $query_count = clone($query);
        $orderArr = $query
            ->joinWith('goods')
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();

        $count = $query_count->count();
        $orderList = ArrayHelper::toArray($orderArr, [
            'common\models\Order' => [
                'oid',
                'gid',
                'order_bn',
                'goods_bn' => 'goods.goods_bn',
                'goods_name' => 'goods.name',
                'qq',
                'num',
                'amount',
                'status',
                'status_name' => function ($m) {
                    return Order::getOrderStatus($m->status);
                },
                'create_time' => function ($m) {
                    return date('Y-m-d h:i:s', $m->create_time);
                },
            ],
        ]);
        $_data = [
            'orderList' => $orderList,
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
        $order = $this->req('order', []);
        if(isset($order['oid'])){
            unset($order['oid']);
        }
        $mdl = new Order();
        $res = $mdl->saveOrder($order);
        $this->toJson($res['code'], $res['msg']);
    }

    /**
     * 添加订单
     * @return array
     */
    function actionUpdate()
    {
        $oid = intval($this->req('oid'));
        $mdl = new Order();
        //检验参数是否合法
        if (empty($oid)) {
            $this->toJson(-20001, '订单序号oid不能为空');
        }

        //检验订单是否存在
        $order = $mdl->getOne(['oid' => $oid]);
        if (!$order) {
            $this->toJson(-20002, '订单信息不存在');
        }
        $_data = [
            'order' => $order,
            'status_list' => $mdl::getOrderStatus(),
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
        $order_info = $this->req('order', []);

        $mdl = new Order();
        //检验参数是否合法
        if (empty($oid)) {
            $this->toJson(-20001, '订单序号oid不能为空');
        }
        if(empty($order_info['order_status'])){
            $this->toJson(-20002, '订单状态不能为空');
        }

        //检验订单是否存在
        $order = $mdl->_get_info(['oid' => $oid]);
        if (!$order) {
            $this->toJson(-20002, '订单信息不存在');
        }
        $res = $mdl->_save([
            'oid' => $oid,
            'order_status' => intval($order_info['order_status']),
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

        $mdl = new Order();
        //检验参数是否合法
        if (empty($oid)) {
            $this->toJson(-20001, '订单序号oid不能为空');
        }

        //检验订单是否存在
        $order = $mdl->_get_info(['oid' => $oid]);
        if (!$order) {
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

        $mdl = new Order();
        //检验参数是否合法
        if (empty($oid)) {
            $this->toJson(-20001, '用户编号id不能为空');
        }

        //检验用户是否存在
        $order = $mdl->getRelationOne(['oid' => $oid], ['with' => ['goods']]);
        if (!$order) {
            $this->toJson(-20003, '用户信息不存在');
        }
        $order['create_time'] = date('Y-m-d h:i:s', $order['create_time']);
        $_data = [
            'order' => $order
        ];
        return $this->render('info', $_data);
    }

}
