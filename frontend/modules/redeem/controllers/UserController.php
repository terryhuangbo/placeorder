<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\User;
use common\models\Auth;
use common\models\Session;
use common\models\VerifyCode;
use common\lib\Sms;
use common\lib\WechatAuth;


class UserController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;

    public function init(){
        $this->_uncheck = [
            'reg',
            'send-sms',
            'wechat',
            'wechat-auth',
            'rect',
        ];
    }

    /**
     * 用户注册
     * @return type
     */
    public function actionReg()
    {
        $session = Yii::$app->session;
        $redirect = $this->_request('redirect', '');
        if(!empty($redirect)){
            $session->set('REDIRECT_URL', $redirect);
        }

        //加载
        if(!$this->isAjax()){
            $key = $this->_request('key', '');
            $_data = [
                'key' => $key,
            ];
            return $this->render('reg', $_data);
        }

        //保存
        $mobile = trim($this->_request('mobile'));
        $verifycode = intval($this->_request('verifycode'));
        $key = trim($this->_request('key'));

        $param = [
            'mobile' => $mobile,
            'verifycode' => $verifycode,
            'key' => $key,
        ];
        $res = (new User())->_add_user($param);
        if($res['code'] < 0 ){
            $this->_json($res['code'], $res['msg']);
        }

        //设置登录session
        $session->set('user_id', $res['data']['uid']);

        //判断是否有跳转
        $redirect = $session->get('REDIRECT_URL');
        if(!empty($redirect)){
            $session->remove('REDIRECT_URL');
        }
        $_data = [
            'redirect' => !empty($redirect) ? $redirect : '/redeem/home/index'
        ];
        //成功返回
        $this->_json(20000, '成功', $_data);
    }

    /**
     * 微信入口
     * @return type
     */
    public function actionWechat()
    {

        $options = yiiParams('wechatConfig');
        $auth = new WechatAuth($options);

        $open_id = $auth->wxuser['open_id'];
        $nickname = $auth->wxuser['nickname'];
        $avatar = $auth->wxuser['avatar'];
        session_destroy();

        $user = (new User())->_get_info(['wechat_openid' => $open_id]);

        //有记录，表示已经注册，跳转到首页
        if($user){
            return $this->redirect('/redeem/user/rect?uid=' . $user['uid']);
        }

        //无记录，跳转到登录页
        $sess = new Session();
        $key = md5(microtime() + rand(0, 10000));
        $res = $sess->_save([
            'key' => $key,
            'wechat_openid' => $open_id,
            'nick' => $nickname,
            'avatar' => $avatar,
        ]);
        if($res){
            $_url = "/redeem/user/reg?key=" . $key;
            return $this->redirect($_url);
        }
    }

    /**
     * 中转跳转页面
     * @return type
     */
    public function actionRect()
    {
        $uid = $this->_request('uid');
        if(empty($uid)){
            return $this->redirect('/redeem/user/reg');
        }
        $session = Yii::$app->session;
        $session->set('user_id', $uid);
        return $this->redirect('/redeem/home/index');
    }

    /**
     * 发送验证码
     * @return type
     */
    public function actionSendSms()
    {
        $mobile = trim($this->_request('mobile'));
        $sms = new Sms();
        $randnum = $sms->randnum();
        $msg = "{$randnum} (动态验证码),请在30分钟内填写";
        $res = $sms->send($mobile, $msg);

        if($res != 0){
            $this->_json(-20001, '验证码发送失败，请重新发送');
        }
        $ret = (new VerifyCode())->_save_code($mobile, $randnum);
        if(!$ret){
            $this->_json(-20002, '验证码保存失败');
        }
        $this->_json(20000, '发送成功');
    }

    /**
     * 用户认证
     * @return type
     */
    public function actionAuth()
    {

        //加载
        $uid = $this->uid;
        if(!$this->isAjax()){
            $_data = [
                'uid' => $uid,
                'type_list' => User::_get_user_type_list(),
            ];
            return $this->render('auth', $_data);
        }
        //保存
        $auth = (new Auth())->_get_info(['uid' => $uid]);
//        if(!$auth){
//            $this->_json(-20001, '认证信息不存在，请先进行手机认证');
//        }
        $name = trim($this->_request('name'));
        $email = trim($this->_request('email'));
        $mobile = trim($this->_request('mobile'));
        $user_type = intval($this->_request('user_type'));
        $user_type_imgs = $this->_request('usetypeimg');
        $param = [
            'auth_id' => $auth['auth_id'],
            'uid' => $uid,
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'user_type' => $user_type,
            'user_type_imgs' => $user_type_imgs,
        ];
        $res = (new Auth())->_add_auth($param);
        if($res['code'] < 0 ){
            $this->_json($res['code'], $res['msg']);
        }
        $this->_json($res['code'], $res['msg'], $res['data']);
    }

    /**
     * 微信认证入口
     * @return type
     */
    public function actionWechatAuth()
    {

        $options = yiiParams('wechatConfig');
        $auth = new WechatAuth($options);

        $open_id = $auth->wxuser['open_id'];
        $nickname = $auth->wxuser['nickname'];
        $avatar = $auth->wxuser['avatar'];
        session_destroy();

//        $user = (new User())->_get_info(['wechat_openid' => $open_id]);
        $user = false;//留待开发..

        $sess = new Session();
        $key = md5(microtime() + rand(0, 10000));
        $res = $sess->_save([
            'key' => $key,
            'wechat_openid' => $open_id,
            'nick' => $nickname,
            'avatar' => $avatar,
        ]);

        //有记录，表示已经认证，跳转到首页
        if($res){
            if($user){
                $this->redirect('/redeem/home/index?uid=' . $user['uid']);
            }else{
                $_url = "/redeem/user/reg?key=" . $key . '&redirect=/redeem/user/auth';
                $this->redirect($_url);
            }
        }
    }
    
    /**
     * 退出登录
     * @return type
     */
    public function actionLogout()
    {
        $session = Yii::$app->session;
        $session->remove('user_id');
        $this->redirect('/redeem/user/reg');
    }

}
