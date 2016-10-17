<?php

namespace backend\modules\config\controllers;

use common\models\Goods;
use common\models\Order;
use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\Meta;

class ConfigController extends BaseController
{
    /**
     * 路由权限控制
     * @return array
     */
    public function limitActions()
    {
        return [
            'add',
            'info',
            'save',
            'update',
            'web',
        ];
    }

    /**
     * 路由权限控制
     * @return array
     */

    /**
     * 添加财务
     * @return array
     */
    function actionWeb()
    {
        $meta = new Meta();
        if(!$this->isAjax()){
            return $this->render('web-config', $meta->asArray());
        }
        $configs = Yii::$app->request->post('config', []);
        foreach($configs as $key => $val){
            $meta->setConfig($key, $val);
        }
        return $this->toJson(20000, '保存成功');
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
