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

        ];
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

        //给账号值
        if($this->userLog){
            $user = User::findOne($this->uid);
        }else{
            $user = Card::findOne(['card_bn' => $this->card_bn]);
        }
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
        $card_bn = $this->userLog ? $card_bn : $this->card_bn;
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

    /**
     * 用户账号登录
     * @return type
     */
    public function actionAlterPwd()
    {
        $opwd = $this->req('oldpwd', '');
        $pwd = $this->req('pwd', '');
        if(empty($opwd) || empty($pwd)){
            return $this->toJson('-20001', '请输入旧密码和新密码');
        }
        $card = Card::findOne(['card_bn' => $this->card_bn, 'pwd' => $opwd]);
        if(empty($card)){
            return $this->toJson('-20002', '旧密码输入错误，请重新输入');
        }
        $card->pwd = $pwd;
        //校验数据
        if (!$card->validate())
        {
            $errors = $card->getFirstErrors();
            return $this->toJson('-20003', reset($errors));
        }
        //保存数据
        $ret = $card->save();
        return $this->toJson($ret['code'], $ret['msg']);
    }


}
