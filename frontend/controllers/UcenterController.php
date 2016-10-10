<?php
/**
 * Created by PhpStorm.
 * User: Huangbo
 * Date: 2016/05/09
 * Time: 17:48
 */
namespace frontend\controllers;

use yii;
use common\lib\Tools;
use yii\web\Controller;

class UcenterController extends Controller {

    public $_module_name;
    public $_controller_name;
    public $_action_name;
    public $_user;

    public function beforeAction($action) {
        $this->_module_name = $this->module->id;
        $this->_controller_name = yii::$app->controller->id;
        $this->_action_name = $action->id;
        return true;
    }

    //初始化方法
    public function init() {
        if (!$this->_check_user_login()) {
            $this->_jump_to_login();
        }
    }


    //校验用户是否登录
    private function _check_user_login() {
        $this->_user = (new Tools())->_get_user_info();
        if (!$this->_user) {
            setcookie('vso_uid', null);
            setcookie('vso_uname', null);
            setcookie('vso_token', null);
            return false;
        } else {
            return true;
        }
    }

    /**
     * 跳转登录之前，先写入本地跳转cookie
     */
    private function _jump_to_login() {
        error_reporting(0);
        @setcookie('redirect_url', yii::$app->getRequest()->absoluteUrl, 0, '/', yii::$app->params['cookiedomain']);
        header("Location:". yii::$app->params['user_http_sync_login_url']);
        exit;
    }

    //返回json数据
    public function _return_json($data) {
        return exit(json_encode($data));
    }

}