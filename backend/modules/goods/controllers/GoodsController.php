<?php

namespace backend\modules\goods\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\Goods;
use common\models\City;
use app\modules\team\models\Team;

class GoodsController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;
    public $checker_id = '';

    /**
     * 放置需要初始化的信息
     */
    public function init()
    {
        //后台登录人员ID
        $this->checker_id = Yii::$app->user->identity->uid;
    }

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
        $search = $this->_request('search');
        $page = $this->_request('page', 0);
        $pageSize = $this->_request('pageSize', 10);
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
        $query->andWhere(['in', 'goods_status', [$mdl::STATUS_UPSHELF, $mdl::STATUS_OFFSHELF]]);
        $_order_by = 'gid DESC';
        $query_count = clone($query);
        $userArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $count = $query_count->count();
        $goodsList = ArrayHelper::toArray($userArr, [
            'common\models\Goods' => [
                'gid',
                'goods_id',
                'name',
                'thumb',
                'description',
                'redeem_pionts',
                'goods_status',
                'status_name' => function ($m) {
                    return Goods::_get_goods_status($m->goods_status);
                },
                'inputer' => function ($m) {
                    return '录入人';
                },
                'checker' => function ($m) {
                    return '审核人';
                },
                'create_at' => function ($m) {
                    return date('Y-m-d h:i:s', $m->create_at);
                },
            ],
        ]);
        $_data = [
            'goodsList' => $goodsList,
            'totalCount' => $count
        ];
        exit(json_encode($_data));
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
        $goods = $this->_request('goods', []);
        if(isset($goods['gid'])){
            unset($goods['gid']);
        }
        $mdl = new Goods();
        $res = $mdl->_save_goods($goods);
        $this->_json($res['code'], $res['msg']);
    }

    /**
     * 添加商品
     * @return array
     */
    function actionUpdate()
    {
        $gid = intval($this->_request('gid'));
        $goods_info = $this->_request('goods', []);

        $mdl = new Goods();
        //检验参数是否合法
        if (empty($gid)) {
            $this->_json(-20001, '商品序号gid不能为空');
        }

        //检验商品是否存在
        $goods = $mdl->_get_info(['gid' => $gid]);
        if (!$goods) {
            $this->_json(-20002, '商品信息不存在');
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
        $res = $mdl->_save_goods($goods_info);
        $this->_json($res['code'], $res['msg']);
    }

    /**
     * 改变商品状态
     * @return array
     */
    function actionAjaxChangeStatus()
    {
        $gid = intval($this->_request('gid'));
        $goods_status = $this->_request('goods_status');

        $mdl = new Goods();
        //检验参数是否合法
        if (empty($gid)) {
            $this->_json(-20001, '商品序号gid不能为空');
        }
        if(!in_array($goods_status, [$mdl::STATUS_OFFSHELF, $mdl::STATUS_UPSHELF, $mdl::STATUS_DELETE])){
            $this->_json(-20002, '商品状态不正确');
        }

        //检验商品是否存在
        $goods = $mdl->_get_info(['gid' => $gid]);
        if (!$goods) {
            $this->_json(-20003, '商品信息不存在');
        }

        $res = $mdl->_save([
            'gid' => $gid,
            'goods_status' => $goods_status,
        ]);
        if(!$res){
            $this->_json(-20003, '商品状态修改失败');
        }
        $this->_json(20000, '保存成功');
    }








}
