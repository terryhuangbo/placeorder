<?php

namespace frontend\modules\plorder\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\Card;
use common\models\User;


class CardController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;

    public function init(){
        $this->_uncheck = [
            'reg',
            'login',
        ];
    }

    /**
     * 用户登录
     */
    public function actionLogin()
    {
        $card_bn = $this->req('card_bn', '');
        $pwd = $this->req('pwd', '');
        if(empty($card_bn)){
            return $this->toJson('-20001', '请输入卡密');
        }
        $where = [
            'card_bn' => $card_bn,
        ];
        $card = Card::findOne($where);
        //判断是否登录成功
        if(empty($card)){
            return $this->toJson('-20003', '卡密不存在');
        }else if(empty($card->pwd)){
            return $this->toJson('20000', '卡密卡密登录成功');
        }else if(!empty($card->pwd) && empty($pwd)){
            return $this->toJson('-20004', '请输入卡密密码');
        }else if(!empty($card->pwd) && $card->pwd != $pwd){
            return $this->toJson('-20005', '卡密密码输入错误，请重新输入');
        }else{
            return $this->toJson('20000', '卡密卡密登录成功');
        }
    }

    /**
     * 退出登录
     * @return string
     */
    public function actionLogout()
    {
        $session = Yii::$app->session;
        $session->remove('user_id');
        $this->redirect('/plorder/user/reg');
    }

    /**
     * 卡密充值
     * @return string
     */
    public function actionCharge()
    {
        $card_bn = $this->req('card_bn', '');
        $charge_points = (int)$this->req('charge_points', 0);
        $card = Card::findOne(['card_bn' => $card_bn]);
        $user = User::findOne($this->uid);
        if(!$card){
            return $this->toJson('-20001', '卡密不存在');
        }
        if(!$user){
            return $this->toJson('-20001', '充值用户不存在');
        }
        if($charge_points <= 0){
            return $this->toJson('-20001', '充值金额正确');
        }
        $event = new \common\event\CardChargeEvent([
            'chargedUser' => $user,
            'points' => $charge_points,
        ]);
        $card->trigger(Card::EVENT_CHARGE, $event);

        return $this->toJson($event->code, $event->msg);
    }

    /**
     * 查看卡密余额
     * @return string
     */
    public function actionRemain()
    {
        $card_bn = $this->req('card_bn', '');
        $card = Card::findOne(['card_bn' => $card_bn]);
        if(!$card){
            return $this->toJson('-20001', '卡密不存在');
        }
        $_data = [
            'points' => $card['points']
        ];
        return $this->toJson('20000', '卡密不存在', $_data);
    }

    /**
     * 拆分卡密
     * @return string
     */
    public function actionSplit()
    {
        $card_bn = trim($this->req('card_bn', ''));
        $post = Yii::$app->request->post();
        $card = Card::findOne(['card_bn' => $card_bn]);
        if(!$card){
            return $this->toJson('-20001', '卡密不存在');
        }
        unset($post['card_bn']);
        $event = new \common\event\CardSplitEvent($post);
        $card->trigger(Card::EVENT_SPLIT, $event);

        return $this->toJson($event->code, $event->msg);
    }


}
