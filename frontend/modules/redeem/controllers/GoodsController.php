<?php

namespace frontend\modules\redeem\controllers;

use common\models\Goods;
use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\api\VsoApi;
use common\models\User;
use common\models\Auth;


class GoodsController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;


    /**
     * 商品列表
     * @return type
     */
    public function actionList()
    {
        return $this->render('index');
    }

    /**
     * 商品介绍
     * @return type
     */
    public function actionView()
    {
        $gid = intval($this->_request('gid'));
        if(empty($gid)){
            $this->_json(-20001, '参数不能为空');
        }
        $mdl = new Goods();
        $goods = $mdl->_get_info(['gid' => $gid]);
        if(empty($goods)){
            $this->_json(-20002, '商品信息不存在');
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
        $gid = intval($this->_request('gid'));
        if(empty($gid)){
            $this->_json(-20001, '参数不能为空');
        }
        $mdl = new Goods();
        $goods = $mdl->_get_info(['gid' => $gid]);
        if(empty($goods)){
            $this->_json(-20002, '商品信息不存在');
        }

        $_data = [
            'goods' => $goods
        ];
        return $this->render('detail', $_data);
    }


}
