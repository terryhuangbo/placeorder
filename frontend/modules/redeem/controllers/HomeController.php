<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\User;
use common\models\Goods;
use common\models\Points;
use common\models\PointsRecord;


class HomeController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;

    /**
     * 用户列表
     * @return type
     */
    public function actionIndex()
    {
        $g_mdl = new Goods();

        $_goods_list = $g_mdl->_get_list(['goods_status' => $g_mdl::STATUS_UPSHELF], 'gid DESC');
        $_data = [
            'user' => $this->user,
            'goods_list' => $_goods_list,
        ];

        return $this->render('index', $_data);
    }

    /**
     * 索索
     * @return type
     */
    public function actionSearch()
    {
        $keywords = urldecode($this->_request('keywords'));
        if(empty($keywords)) {
            $this->_json(-20001, '关键词不能为空');
        }

        $g_mdl = new Goods();
        if(!empty($keywords)){
            $param = [
                'sql' => "`goods_status` = :goods_status AND `name` like '%{$keywords}%'",
                'params' => [':goods_status' => $g_mdl::STATUS_UPSHELF]
            ];
        }else{
            $param = [
                'sql' => "`goods_status` = :goods_status",
                'params' => [':goods_status' => $g_mdl::STATUS_UPSHELF]
            ];
        }

        $_goods_list = $g_mdl->_get_list($param,'gid DESC');

        $_data = [
            'goods' => $_goods_list,
        ];
        $this->_json(20000, '成功', $_data);
    }

    /**
     * 签到赚积分
     * @return type
     */
    public function actionSign()
    {
        $p_mdl = new Points();
        $r_mdl = new PointsRecord();
        $sign = $r_mdl::find()
            ->where(['uid' => $this->uid])
            ->andWhere(['point_id' => Points::POINTS_SIGNIN])
            ->andWhere(['>', 'create_at', strtotime('today')])
            ->andWhere(['<', 'create_at', strtotime('today + 1 day')])
            ->asArray()
            ->one();
        if($sign){
            $this->_json(-20001, '今天已经签到过了');
        }
        $ret = $p_mdl->_add_points($this->uid, Points::POINTS_SIGNIN);
        $this->_json($ret['code'], $ret['msg']);
    }

    /**
     * 分享赚积分
     * @return type
     */
    public function actionShare()
    {
        $p_mdl = new Points();
        $ret = $p_mdl->_add_points($this->uid, Points::POINTS_WECHAT);
        $this->_json($ret['code'], $ret['msg']);
    }

    /**
     * 用户列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 积分规则
     * @return type
     */
    public function actionRules()
    {
        return $this->render('rules');
    }

    /**
     * 关于我们
     * @return type
     */
    public function actionAbout()
    {
        return $this->render('about');
    }




}
