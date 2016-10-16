<?php

namespace frontend\modules\plorder\controllers;

use Yii;
use app\base\BaseController;
use common\models\User;
use common\models\Card;


class UserController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;

    public function init(){
        $this->_uncheck = [
            'reg',
            'login',
            'card-login',
            'index',
        ];
    }

    /**
     * 用户注册
     * @return type
     */
    public function actionReg()
    {
        if(!$this->isAjax()){
            return $this->render('reg');
        }
        $post = $this->req();
        $mdl = new User();
        $mdl->scenario = User::SCENARIO_REG;
        $mdl->attributes = $post;
        if(!$mdl->validate()){
            $error = $mdl->getFirstErrors();
            return $this->toJson(-20001, reset($error));
        }
        $ret = $mdl->save();
        return json_encode($ret);
    }

    /**
     * 用户账号登录
     * @return type
     */
    public function actionLogin()
    {
        if(!$this->isAjax()){
            return $this->render('reg');
        }
        $username = $this->req('username', '');
        $pwd = $this->req('pwd', '');
        if(empty($username)){
            return $this->toJson('-20001', '请输入用户名');
        }
        if(empty($pwd)){
            return $this->toJson('-20002', '请输入密码');
        }
        $where = [
            'username' => $username,
            'pwd' => User::genPwd($pwd)
        ];
        $user = User::findOne($where);
        if(empty($user)){
            return $this->toJson('-20003', '用户名不存在或者密码错误');
        }
        $user->touch('login_time');//更新登录时间

        //保存账号登录信息
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => 'user_id',
            'value' => $user['uid'],
        ]));
        $cookies->remove('card_bn');

        return $this->toJson('20000', '登录成功');
    }

    /**
     * 卡密登录
     */
    public function actionCardLogin()
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
            $data = ['code' => '-20003', 'msg' => '卡密不存在'];
        }else if(empty($card->pwd)){
            $data = ['code' => '20000', 'msg' => '卡密卡密登录成功'];
        }else if(!empty($card->pwd) && empty($pwd)){
            $data = ['code' => '-20004', 'msg' => '请输入卡密密码'];
        }else if(!empty($card->pwd) && $card->pwd != $pwd){
            $data = ['code' => '-20005', 'msg' => '卡密密码输入错误，请重新输入'];
        }else{
            $data = ['code' => '20000', 'msg' => '卡密卡密登录成功'];
        }

        //卡密登录
        if($data['code'] > 0){
            //保存卡密登录信息
            $cookies = Yii::$app->response->cookies;
            $cookies->add(new \yii\web\Cookie([
                'name' => 'card_bn',
                'value' => $card['card_bn'],
            ]));
            $cookies->remove('user_id');
        }
        return $this->toJson($data['code'], $data['msg']);
    }

    /**
     * 退出登录
     * @return type
     */
    public function actionLogout()
    {
        $cookies = Yii::$app->response->cookies;
        $cookies->remove('user_id');
        $cookies->remove('card_bn');
        return $this->redirect('/plorder/user/reg');
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
        $user = User::findOne(['uid' => $this->uid, 'pwd' => User::genPwd($opwd)]);
        if(empty($user)){
            return $this->toJson('-20002', '旧密码输入错误，请重新输入');
        }
        $user->pwd = $pwd;
        //校验数据
        if (!$user->validate())
        {
            $errors = $user->getFirstErrors();
            return $this->toJson('-20003', reset($errors));
        }
        //保存数据
        $ret = $user->save();
        return $this->toJson($ret['code'], $ret['msg']);
    }


}
