<?php
/**
 * 公共弹窗
 * User: huangbo
 * Date: 2016/3/15
 * Time: 17:00
 */
namespace frontend\controllers;

use yii\web\Controller;
use yii;

class MessageController extends Controller {
    public $enableCsrfValidation = false;

    /**
     * 公共弹窗
     */
    public function actionIndex() {
        $msg = urldecode(yii::$app->request->get('msg'));
        return $this->render('index', ['msg' => $msg]);
    }

    /**
     * 有关商品，服务的公共提示页面
     */
    public function actionGoods() {
        $msg = urldecode(yii::$app->request->get('msg'));
        $msg = !empty($msg) ? $msg : '很抱歉，您查找的商品不存在，可能已下架或者已被买断版权';
        return $this->render('goods', ['msg' => $msg]);
    }

    /**
     * 公共目录树结构
     */
    public function actionTreeview() {
        return $this->render('treeview');
    }
}
