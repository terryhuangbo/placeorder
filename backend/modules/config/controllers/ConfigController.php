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
            'content',
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
     * 添加财务
     * @return array
     */
    function actionContent()
    {
        $meta = new Meta();
        if(!$this->isAjax()){
            return $this->render('content-config', $meta->asArray());
        }
        $configs = Yii::$app->request->post('config', []);
        foreach($configs as $key => $val){
            $meta->setConfig($key, $val);
        }
        return $this->toJson(20000, '保存成功');
    }






}
