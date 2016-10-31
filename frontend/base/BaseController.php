<?php

namespace app\base;

use Yii;
use yii\web\Controller;
use common\lib\Tools;
use common\models\User;
use common\models\Card;

class BaseController extends Controller
{
    public $layout = 'layout';
    public $enableCsrfValidation = false;
    public $uid = null;//用户ID
    public $user = null;//用户信息
    public $card_bn = null;//卡密登录账号
    public $card = null;//卡密信息
    public $userLog = null;//是否是用户账号登录 true-用户账号登录；false-卡密登录
    public $_uncheck = []; //不用校验登录的方法,可子类复写

    /**
     * 获取登录信息
     */
    public function beforeAction($action)
    {

        //不用校验的页面，自动跳过
        $action_id = Yii::$app->controller->action->id;
        if(in_array($action_id, $this->_uncheck)){
            return true;
        }

        //从cookies中校验用户登录信息
        $cookies = Yii::$app->request->cookies;
        $this->uid = $cookies->getValue('user_id', '');
        $this->card_bn = $cookies->getValue('card_bn', '');

        //检查是否登录
        if(empty($this->uid) && empty($this->card_bn)){
            $this->setReturnUrl();
            $this->redirect('/plorder/user/reg');
            return false;
        }

        //登录类型
        if(!empty($this->uid)){
            $this->userLog = true;
            $this->user = (new User())->getOne(['uid' => $this->uid]);
            if(empty($this->user)){
                $this->setReturnUrl();
                $this->redirect('/plorder/user/reg');
                return false;
            }
        }elseif(!empty($this->card_bn)){
            $this->userLog = false;
            $this->card = (new Card())->getOne(['card_bn' => $this->card_bn]);
            if(empty($this->card)){
                $this->setReturnUrl();
                $this->redirect('/plorder/user/reg');
                return false;
            }
        }

        return true;
    }


    /**
     * 保存返回链接
     * @return string
     */
    public function setReturnUrl($url = '')
    {
        if(empty($url)){
            Yii::$app->request->absoluteUrl;
        }
        //保存返回链接
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => 'return_url',
            'value' => Yii::$app->request->absoluteUrl,
        ]));
    }

    /**
     * 保存返回链接
     * @return string
     */
    public function getReturnUrl()
    {
        //从cookies中校验用户登录信息
        $cookies = Yii::$app->request->cookies;
        return $cookies->getValue('return_url', '');
    }



    /**
     * 判断是否是POST请求
     * @return string
     */
    public function isPost()
    {
        return Yii::$app->request->isPost;
    }



    /**
     * 判断是否是Get请求
     * @return string
     */
    public function isGet()
    {
        return Yii::$app->request->isGet;
    }

    /**
     * 判断是否是Ajax请求
     * @return string
     */
    public function isAjax()
    {
        return Yii::$app->request->isAjax;
    }

    /**
     * 获取浏览器类型
     * @return string
     */
    public function getBrowser()
    {
        $agent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '';
        if (strpos($agent, 'MSIE') !== false || strpos($agent, 'rv:11')) //ie11判断
        {
            return "ie";
        }
        else if (strpos($agent, 'Firefox') !== false)
        {
            return "firefox";
        }
        else if (strpos($agent, 'Chrome') !== false)
        {
            return "chrome";
        }
        else if (strpos($agent, 'Opera') !== false)
        {
            return 'opera';
        }
        else if ((strpos($agent, 'Chrome') == false) && strpos($agent, 'Safari') !== false)
        {
            return 'safari';
        }
        else
        {
            return 'unknown';
        }
    }

    /**
     * 返回格式化数据转json
     * @param int $code
     * @param string $msg
     * @param bool $data
     * @return string
     */
    public function toJson($code, $msg = '', $data = null) {
        @header('Content-Type:application/json;charset=utf-8');
        $r_data = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'request_ip' => Tools::getIP(),
        ];

        if (empty($code) && $code != 0) {
            $r_data['ret'] = -40400;
        }

        if (empty($msg)) {
            unset($r_data['msg']);
        }

        if ($data === null) {
            unset($r_data['data']);
        }

        $_callback_fun_name = '';
        $jsonp  = $this->req('jsonp');
        if (!empty($jsonp)) {
            $_callback_fun_name = $this->req('jsonp');
        }

        if (!empty($_callback_fun_name)) {
            exit($_callback_fun_name . '(' . $this->toJson($r_data) . ');');
        }

        return json_encode($r_data);
    }

    /**
     * 获取Request参数
     * @param string $key
     * @param bool|array|string $default 当请求的参数不存在时的默认值
     * @return string
     */
    public function req($key = '', $default = false) {
        $request = array_merge(Yii::$app->request->get(), Yii::$app->request->post());
        if(empty($key)){
            return $request;
        }
        if(!isset($request[$key])){
            return $default;
        }
        return $request[$key];
    }

}

?>