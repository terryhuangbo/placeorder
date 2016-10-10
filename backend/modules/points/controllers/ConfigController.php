<?php

namespace backend\modules\points\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\PointsConfig;
use app\modules\team\models\Team;

class ConfigController extends BaseController
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
            'add',
            'ajax-add',
            'update',
            'ajax-save',
            'delete',
        ];
    }

    /**
     * 用户数据
     */
    public function actionList()
    {
        if ($this->isGet()) {
            return $this->render('list');
        }
        $configList = PointsConfig::_get_list();
        $basics = PointsConfig::_get_basics();
        foreach($configList as $key => $val){
            $configList[$key]['delete'] = in_array($val['id'], $basics) ? 0 : 1;
        }
        $_data = [
            'configList' => $configList,
            'totalCount' => count($configList)
        ];
        exit(json_encode($_data));
    }

    /**
     * 添加积分类型
     * @return array
     */
    function actionAdd()
    {
        return $this->render('add');
    }

    /**
     * 添加积分类型
     * @return array
     */
    function actionAjaxAdd()
    {
        $name = trim($this->_request('name'));

        $mdl = new PointsConfig();
        //检验参数是否合法
        if (empty($name)) {
            $this->_json(-20001, '积分类型名称不能为空');
        }

        //判断是否存在
        $config = $mdl->_get_info(['name' => $name]);
        if($config){
            $this->_json(-20002, '积分类型已经存在，请勿重复添加！');
        }

        $rst = $mdl->_save([
            'name' => $name,
        ]);
        if (!$rst) {
            $this->_json(-20003, '添加失败');
        }
        $this->_json(20000, '添加成功！');
    }

    /**
     * 编辑积分类型
     * @return array
     */
    function actionUpdate()
    {
        $id = intval($this->_request('id'));

        $mdl = new PointsConfig();
        //检验参数是否合法
        if (empty($id)) {
            $this->_json(-20001, '用户编号id不能为空');
        }

        //检验用户是否存在
        $config = $mdl->_get_info(['id' => $id]);
        if (!$config) {
            $this->_json(-20003, '积分类型不存在');
        }

        $_data = [
            'config' => $config
        ];
        return $this->render('edit', $_data);
    }

    /**
     * 编辑积分类型
     * @return array
     */
    function actionAjaxSave()
    {
        $id = intval($this->_request('configid'));
        $name = trim($this->_request('name'));

        $mdl = new PointsConfig();
        //检验参数是否合法
        if (empty($id)) {
            $this->_json(-20001, '用户编号id不能为空');
        }
        if (empty($name)) {
            $this->_json(-20002, '积分类型名称不能为空');
        }

        //检验用户是否存在
        $user = $mdl->_get_info(['id' => $id]);
        if (!$user) {
            $this->_json(-20004, '积分类型不存在');
        }

        $rst = $mdl->_save([
            'id' => $id,
            'name' => $name,
        ]);
        if (!$rst) {
            $this->_json(-20005, '积分类型保存失败');
        }

        $this->_json(20000, '保存成功！');
    }

    /**
     * 删除积分类型
     * @return array
     */
    public function actionDelete()
    {
        $ids = $this->_request('ids');
        $mdl = new PointsConfig();
        $id_arry = array_values($ids);

        //参数检验
        if (empty($id_arry))
        {
            $this->_json(-20001, '你没有选中任何对象');
        }

        //检验不可删除的对新
        $config_arry = $mdl::_get_basics();
        foreach($id_arry as $v){
            if(in_array($v, $config_arry)){
                $this->_json(-20002, '你所选中的对象包含系统默认，不可删除');
            }
        }

        //删除
        $res = (new PointsConfig())->_delete(['in', 'id', $id_arry]);
        if($res === false){
            $this->_json(-20001, '删除失败');
        }
        $this->_json(20000, '删除成功');
    }

}
