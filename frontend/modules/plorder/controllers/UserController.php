<?php

namespace frontend\modules\plorder\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\User;


class UserController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;

    public function init(){
        $this->_uncheck = [
            'reg',
            'login',
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
        return $this->toJson('20000', '登录成功');
    }

    /**
     * 退出登录
     * @return type
     */
    public function actionLogout()
    {
        $session = Yii::$app->session;
        $session->remove('user_id');
        $this->redirect('/plorder/user/reg');
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

    /**
     * 用户中心
     * @return type
     */
    public function actionIndex()
    {
        $user = $this->user;
        $user['login_time'] = date('Y-m-d H:i:s', $user['login_time']);
        $_data = [
            'user' => $user,
        ];
        return $this->render('index', $_data);
    }

}
