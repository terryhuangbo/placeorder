<?php

namespace backend\modules\points\controllers;

use common\models\Points;
use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\api\VsoApi;
use common\models\User;
use common\models\Auth;
use common\models\Goods;
use common\models\PointsConfig;
use app\modules\team\models\Team;

class PointsController extends BaseController
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
            'export',
            'info',
            'add',
            'update',
            'delete',
            'ajax-save',
            'ajax-check-goods',
            'types-list',
        ];
    }

    /**
     * 积分列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 积分数据
     */
    public function actionList()
    {
        if ($this->isGet()) {
            return $this->render('list');
        }
        $mdl = new Points();
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
                if ($search['filtertype'] == 2)//按照积分名称筛选
                {
                    $query = $query->andWhere(['like', $memTb . '.name', trim($search['filtercontent'])]);
                } elseif ($search['filtertype'] == 1)//按照积分ID筛选
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

        $_order_by = 'pid ASC';
        $query_count = clone($query);

        $pointsArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $totalCount = $query_count->count();

        $typeList = PointsConfig::_get_list();
        $pointsList = [];
        if(!empty($pointsArr)){
            foreach($pointsArr as $key => $point){
                $pointsList[] = [
                    'pid' => $point->pid,
                    'name' => $point->name,
                    'points' => $point->points,
                    'goods_id' => $point->goods_id,
                    'goods_name' => $point->goods_name,
                    'type' => $point->type,
                    'type_name' => _value($typeList[$point->pid]['name'], ''),
                    'update_at' => date('Y-m-d h:i:s', $point->update_at),
                    'create_at' => date('Y-m-d h:i:s', $point->create_at),
                ];
            }
        }
        $_data = [
            'pointList' => $pointsList,
            'totalCount' => $totalCount
        ];
        exit(json_encode($_data));
    }

    

    /**
     * 加载积分详情
     * @return array
     */
    function actionInfo()
    {
        $pid = intval($this->_request('pid'));

        $mdl = new User();
        //检验参数是否合法
        if (empty($pid)) {
            $this->_json(-20001, '积分编号id不能为空');
        }

        //检验积分是否存在
        $user = $mdl->_get_info(['pid' => $pid]);
        if (!$user) {
            $this->_json(-20003, '积分信息不存在');
        }
        $user['user_status'] = User::_get_user_status($user['user_status']);
        $user['user_type'] = User::_get_user_type($user['user_type']);
        $user['update_at'] = date('Y-m-d h:i:s', $user['update_at']);
        $user['create_at'] = date('Y-m-d h:i:s', $user['create_at']);
        $_data = [
            'user' => $user
        ];
        return $this->render('info', $_data);
    }

    /**
     * 添加积分信息
     * @return array
     */
    function actionAdd(){
        $typeList = PointsConfig::_get_list();
        $_data = [
            'typeList' => $typeList,
        ];
        return $this->render('add', $_data);
    }

    /**
     * 添加积分信息
     * @return array
     */
    function actionAjaxAdd(){

    }



    /**
     * 编辑积分信息
     * @return array
     */
    function actionUpdate()
    {
        $pid = intval($this->_request('pid'));

        $mdl = new Points();
        //检验参数是否合法
        if (empty($pid)) {
            $this->_json(-20001, '积分编号id不能为空');
        }

        //检验积分是否存在
        $points = $mdl->_get_info(['pid' => $pid]);
        if (!$points) {
            $this->_json(-20003, '积分信息不存在');
        }

        $typeList = PointsConfig::_get_list();

        $points['type_name'] = _value($typeList[$points['pid']]['name'], '');
        $points['update_at'] = date('Y-m-d h:i:s', $points['update_at']);
        $points['create_at'] = date('Y-m-d h:i:s', $points['create_at']);

        $_data = [
            'points' => $points,
            'typeList' => $typeList,
            'is_goods' => $points['type'] == $mdl::POINTS_PRAISE ? true : false
        ];
        return $this->render('edit', $_data);
    }

    /**
     * 编辑积分信息
     * @return array
     */
    function actionAjaxSave()
    {
        $pid = intval($this->_request('pid'));
        $type = intval($this->_request('type'));
        $points = intval($this->_request('points'));
        $goods_id = trim($this->_request('goods_id'));
        $goods_name = trim($this->_request('goods_name'));

        if(empty($pid)){//添加
            $mdl = new Points();
        }else{
            $mdl = Points::findOne(['pid' => $pid]);
            //检验积分是否存在
            $point_info = $mdl->_get_info(['pid' => $pid]);
            if (!$point_info) {
                $this->_json(-20002, '积分信息不存在');
            }
        }

        //检验参数是否合法
        if($points < 0){
            $this->_json(-20005, '积分数量必须为大于0的整数');
        }

        //检验积分类型
        $config = (new PointsConfig())->_get_info(['id' => $type]);
        if(!$config){
            $this->_json( -20003, '积分类型不存在');
        }
        $mdl->type = $type;
        $mdl->name = $config['name'];


        //如果是奖励积分，校验商品是否存在
        $mdl->goods_id = $goods_id;
        if($type == Points::POINTS_PRAISE){
            if(!$mdl->validate(['goods_id'])){
                $msg = $mdl->errors['goods_id'][0];//获取错误信息
                $this->_json( -20004, $msg);
            }
            $mdl->goods_id = '';
            $mdl->goods_name = '';
        }else{
            $mdl->goods_id = $goods_id;
            $mdl->goods_name = $goods_name;
        }
        $mdl->points = $points;
        $mdl->update_at = time();

        //保存
        if (!$mdl->save()) {
            $this->_json(-20000, '积分信息保存失败');
        }

        $this->_json(20000, '积分信息保存成功！');
    }


    /**
     * 异步校验商品信息
     * @return array
     */
    public function actionAjaxCheckGoods()
    {
        $goods_id = trim($this->_request('goods_id'));
        if(empty($goods_id)){
            $this->_json(-20001, '商品编号不能为空');
        }
        $mdl = new Goods();
        $goods = $mdl->_get_info(['goods_id' => $goods_id]);
        if(!$goods){
            $this->_json( -20002, '商品编号不存在');
        }
        $_data = [
            'goods_id' => $goods_id,
            'goods_name' => $goods['name'],
        ];
        $this->_json(20000, '校验成功！', $_data);
    }

    /**
     * 删除积分类型
     * @return array
     */
    public function actionDelete()
    {
        $ids = $this->_request('ids');
        $mdl = new Points();
        $id_arry = array_values($ids);

        //参数检验
        if (empty($id_arry))
        {
            $this->_json(-20001, '你没有选中任何对象');
        }

        //删除
        $res = $mdl->_delete(['in', 'pid', $id_arry]);
        if($res === false){
            $this->_json(-20001, '删除失败');
        }
        $this->_json(20000, '删除成功');
    }





}
