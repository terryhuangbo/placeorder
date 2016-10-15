<?php

namespace frontend\modules\plorder\controllers;

use Yii;
use yii\helpers\ArrayHelper;
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

    /**
     * 商品介绍
     * @return type
     */
    public function actionView()
    {
        $gid = intval($this->req('gid'));
        if(empty($gid)){
            $this->toJson(-20001, '参数不能为空');
        }
        $mdl = new Goods();
        $goods = $mdl->_get_info(['gid' => $gid]);
        if(empty($goods)){
            $this->toJson(-20002, '商品信息不存在');
        }

        $_data = [
            'goods' => $goods
        ];
        return $this->render('view', $_data);
    }

    /**
     * 商品图文详情
     * @return type
     */
    public function actionDetail()
    {
        $gid = intval($this->req('gid'));
        if(empty($gid)){
            $this->toJson(-20001, '参数不能为空');
        }
        $mdl = new Goods();
        $goods = $mdl->_get_info(['gid' => $gid]);
        if(empty($goods)){
            $this->toJson(-20002, '商品信息不存在');
        }

        $_data = [
            'goods' => $goods
        ];
        return $this->render('detail', $_data);
    }


}
