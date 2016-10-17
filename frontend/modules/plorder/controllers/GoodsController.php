<?php

namespace frontend\modules\plorder\controllers;

use Yii;
use app\base\BaseController;
use common\models\Goods;
use common\models\Meta;


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

        //是否是登陆后第一次访问
        //从cookies中校验用户登录信息
        $cookies = Yii::$app->request->cookies;
        $this->uid = $cookies->getValue('user_id', '');
        $this->card_bn = $cookies->getValue('card_bn', '');

        $just_login = $cookies->getValue('just_login', '');
        if(!(empty($this->uid) && empty($this->card_bn)) && empty($just_login)){
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'just_login',
                'value' => 2,
            ]));
            $just_login = 1;
        }
        $_data = [
            'goods' => $goods_list,
            'meta'  => (new Meta())->asArray(),
            'just_login'  => (int) $just_login
        ];

        return $this->render('index', $_data);
    }

}
