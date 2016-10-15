<?php

namespace app\base;

use Yii;
use yii\web\Controller;
use common\lib\Tools;
use common\models\User;

class BaseController extends Controller
{
    public $layout = 'layout';
    public $enableCsrfValidation = false;
    public $uid = '';//用户ID
    public $user = '';//用户信息
    public $_uncheck = []; //不用校验登录的方法,可子类复写

    /**
     * 获取登录信息
     */
    public function beforeAction()
    {
        //不用校验的页面，自动跳过
        $action_id = Yii::$app->controller->action->id;
        if(in_array($action_id, $this->_uncheck)){
            return true;
        }

        //从session中校验用户登录信息
        $session = Yii::$app->session;
        if(!$session->isActive){
            $session->open();
        }
        $this->uid = $session->get('user_id');
        if(empty($this->uid)){
            $this->redirect('/plorder/user/reg');
            return false;
        }
        $this->user = (new User())->getOne(['uid' => $this->uid]);
        if(empty($this->user)){
            $this->redirect('/plorder/user/reg');
            return false;
        }
        return true;
    }

    /**
     * 跳回登录页面
     * @return string
     */
    public function _to_login()
    {
        return $this->redirect('/redeem/user/reg');
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