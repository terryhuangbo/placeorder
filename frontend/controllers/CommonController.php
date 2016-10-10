<?php

namespace frontend\controllers;
use yii;
use yii\web\Controller;
use yii\helpers\Json;
use yii\filters\AccessControl;
use app\modules\team\models\Role;
use app\modules\team\models\Privilege;

class CommonController extends \yii\web\Controller
{
    /**
     * 返回，限制action数组，用于权限过滤，子类可以重写
     * @return array 限制actions数组
     */
    public function limitActions()
    {
        return [];
    }

    /**
     * 获取get或者post中的参数，默认先从get中取
     * @param unknown $key 参数名
     * @param bool $required true的时候如果参数为空，将直接输出错误
     * @param unknown $default 默认值，在$required=false时生效
     */
    public function getHttpParam ($key, $required = true, $default = null)
    {
        $p = isset($_GET [$key]) ? $_GET [$key] : (isset($_POST [$key]) ? $_POST [$key] : null);

        if ($required && $p === null)
        {
            $message = "missing param:$key";
            $this->printError($message);
        }
        if ($p === null)
        {
            $p = $default;
        }
        return $p;
    }

    public function isPost()
    {
        return \Yii::$app->request->isPost;
    }

    public function getYiiParam ($key)
    {
        return \Yii::$app->params [$key];
    }

    public function getLoginUsername ()
    {
        return \Yii::$app->user->getId();
    }

    public function printError ($message = null, $code = null)
    {
        if ($message == null)
        {
            $message = \Yii::t('app', 'error');
        }
        $data = ["result" => false, "errorMessage" => $message, "code" => $code];
        $this->_echoJson($data);
    }

    public function printSuccess ($data = [], $code = null)
    {
        $data = array_merge(["result" => true, "code" => $code], $data);
        $this->_echoJson($data);
    }

    public function _echoJson ($data)
    {
        // ie10以下不认识application/json
        //if (strpos($_SERVER ['HTTP_USER_AGENT'], "MSIE 8.0") || strpos($_SERVER ['HTTP_USER_AGENT'], "MSIE 9.0"))
        //{
        //    header('Content-Type:text/html;');
        //}
        echo Json::encode($data);
        exit;
    }

    /**
     * 判断是否是https请求
     * @return boolean
     */
    public static function isHttpsRequest()
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on");
    }

    /**
     * 获取浏览器类型
     * @return string
     */
    public static function getBrowser()
    {
        $agent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '';
        if(strpos($agent,'MSIE') !== false || strpos($agent,'rv:11')) //ie11判断
        {
            return "ie";
        }
        else if(strpos($agent,'Firefox') !== false)
        {
            return "firefox";
        }
        else if(strpos($agent,'Chrome') !== false)
        {
            return "chrome";
        }
        else if(strpos($agent,'Opera') !== false)
        {
            return 'opera';
        }
        else if((strpos($agent,'Chrome') == false) && strpos($agent,'Safari') !== false)
        {
            return 'safari';
        }
        else
        {
            return 'unknown';
        }
    }
}

?>