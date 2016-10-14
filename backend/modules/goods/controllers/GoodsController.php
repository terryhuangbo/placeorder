<?php

namespace backend\modules\goods\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\lib\Tools;
use common\models\Goods;
use app\modules\team\models\Team;

class GoodsController extends BaseController
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
            'ajax-change-status',
        ];
    }

    /**
     * 商品列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 商品数据
     */
    public function actionList()
    {
        if ($this->isGet()) {
            return $this->render('list');
        }
        $mdl = new Goods();
        $query = $mdl::find();
        $search = $this->req('search');
        $page = $this->req('page', 0);
        $pageSize = $this->req('pageSize', 10);
        $offset = $page * $pageSize;
        $memTb = $mdl::tableName();
        $teamTb = Team::tableName();
        if ($search) {
            if (isset($search['uptimeStart'])) //时间范围
            {
                $query = $query->andWhere(['>', $memTb . '.created_at', strtotime($search['uptimeStart'])]);
            }
            if (isset($search['uptimeEnd'])) //时间范围
            {
                $query = $query->andWhere(['<', $memTb . '.created_at', strtotime($search['uptimeEnd'])]);
            }
            if (isset($search['grouptype'])) //时间范围
            {
                $query = $query->andWhere(['group_id' => $search['grouptype']]);
            }
            if (isset($search['filtertype']) && !empty($search['filtercontent'])) {
                if ($search['filtertype'] == 2)//按照商品名称筛选
                {
                    $query = $query->andWhere(['like', $memTb . '.name', trim($search['filtercontent'])]);
                } elseif ($search['filtertype'] == 1)//按照商品ID筛选
                {
                    $query = $query->andWhere([$memTb . '.username' => trim($search['filtercontent'])]);
                }
            }
            if (isset($search['inputer']) && !empty($search['inputer'])) {
                $query = $query->andWhere(['like', $teamTb . '.nickname', trim($search['filtercontent'])]);
            }
            if (isset($search['inputercompany'])) //筛选条件
            {
                $query = $query->andWhere([$teamTb . '.company_id' => $search['inputercompany']]);
            }
            if (isset($search['checkstatus'])) //筛选条件
            {
                $query->andWhere([$memTb . '.check_status' => $search['checkstatus']]);
            }
        }
        //只能是上架，或者下架的产品
        $_order_by = 'gid DESC';
        $query_count = clone($query);
        $goodsArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $count = $query_count->count();
        $goodsList = ArrayHelper::toArray($goodsArr, [
            'common\models\Goods' => [
                'gid',
                'name',
                'price',
                'status',
                'thumb' => function($m){
                    return $m->images;
                },
                'status_name' => function ($m) {
                    return Goods::getGoodsStatus($m->status);
                },
                'create_time' => function ($m) {
                    return date('Y-m-d h:i:s', $m->create_time);
                },
                'update_time' => function ($m) {
                    return date('Y-m-d h:i:s', $m->update_time);
                },
            ],
        ]);
        $_data = [
            'goodsList' => $goodsList,
            'totalCount' => $count
        ];
        return json_encode($_data);
    }

    /**
     * 添加商品
     * @return array
     */
    function actionAdd()
    {
        if(!$this->isAjax()){
            return $this->render('add');
        }
        $goods = $this->req('goods', []);
        if(isset($goods['gid'])){
            unset($goods['gid']);
        }
        $mdl = new Goods();
        $goods['images'] = getValue($goods, 'thumb', '');
        $res = $mdl->saveGoods($goods);
        return $this->toJson($res['code'], $res['msg']);
    }

    /**
     * 添加商品
     * @return array
     */
    function actionUpdate()
    {
        $gid = intval($this->req('gid'));
        $goods_info = $this->req('goods', []);

        //检验参数是否合法
        if (empty($gid)) {
            return $this->toJson(-20001, '商品序号gid不能为空');
        }

        //检验商品是否存在
        $mdl = new Goods();
        $goods = $mdl->getOne(['gid' => $gid]);
        if (!$goods) {
            return $this->toJson(-20002, '商品信息不存在');
        }
        //加载
        if(!$this->isAjax()){
            $_data = [
                'goods' => $goods
            ];
            return $this->render('update', $_data);
        }
        //保存
        $goods_info['gid'] = $gid;
        $goods_info['images'] = getValue($goods_info, 'thumb', '');
        $ret = $mdl->saveGoods($goods_info);
        return $this->toJson($ret['code'], $ret['msg']);
    }

    /**
     * 改变商品状态
     * @return array
     */
    function actionAjaxChangeStatus()
    {
        $gid = intval($this->req('gid'));
        $goods_status = $this->req('goods_status');

        $mdl = new Goods();
        //检验参数是否合法
        if (empty($gid)) {
            return $this->toJson(-20001, '商品序号gid不能为空');
        }
        if(!in_array($goods_status, [$mdl::STATUS_OFFSHELF, $mdl::STATUS_UPSHELF, $mdl::STATUS_DELETE])){
            return $this->toJson(-20002, '商品状态不正确');
        }

        //检验商品是否存在
        $goods = $mdl->_get_info(['gid' => $gid]);
        if (!$goods) {
            return $this->toJson(-20003, '商品信息不存在');
        }

        $res = $mdl->_save([
            'gid' => $gid,
            'goods_status' => $goods_status,
        ]);
        if(!$res){
            return $this->toJson(-20003, '商品状态修改失败');
        }
        return $this->toJson(20000, '保存成功');
    }








}
