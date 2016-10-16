<?php

namespace frontend\modules\plorder\controllers;

use Yii;
use app\base\BaseController;
use common\models\Goods;


class GoodsController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;

    public function init(){
        $this->_uncheck = [
            'index',
        ];
    }

    /**
     * 商品列表
     * @return type
     */
    public function actionIndex()
    {
        $gmdl = new Goods();
        $format = [
           'gid',
           'goods_bn',
           'name',
           'images' => function($m){
               return yiiParams('img_host') . $m->images;
           },
        ];
        $goods_list = $gmdl->getAll(['status' => Goods::STATUS_UPSHELF], 'gid DESC', 0, 0, $format);
        $_data = [
            'goods' => $goods_list
        ];
        return $this->render('index', $_data);
    }

}
