<?php

namespace backend\modules\pay\controllers;

use common\models\Goods;
use common\models\Order;
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
     * 财务列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 财务数据
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
        $ur_tb = Order::tableName();
        if ($search) {
            if (isset($search['uptimeStart'])) //时间范围
            {
                $query = $query->andWhere(['>', $or_tb . '.update_time', strtotime($search['uptimeStart'])]);
            }
            if (isset($search['uptimeEnd'])) //时间范围
            {
                $query = $query->andWhere(['<', $or_tb . '.update_time', strtotime($search['uptimeEnd'])]);
            }
            if (isset($search['order_bn'])) //商品编号
            {
                $query = $query->andWhere([$ur_tb . '.order_bn' => $search['order_bn']]);
            }
            if (isset($search['order_status'])) //财务状态
            {
                $query = $query->andWhere([$ur_tb . '.status' => $search['order_status']]);
            }
        }
        $_pay_by = 'id DESC';

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
                'id',
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
     * 添加财务
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
     * 加载财务详情
     */
    function actionInfo()
    {
        $id = intval($this->req('id'));

        $mdl = new Pay();
        //检验参数是否合法
        if (empty($id)) {
            $this->toJson(-20001, '用户编号id不能为空');
        }

        //检验用户是否存在
        $pay = $mdl->getRelationOne(['id' => $id], ['with' => ['user', 'order.goods']]);
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
