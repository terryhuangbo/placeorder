<?php

namespace app\base;

use Yii;
use yii\web\Controller;
use yii\helpers\Json;
use common\lib\Tools;
use yii\filters\AccessControl;
use app\modules\team\models\Role;
use app\modules\team\models\Privilege;

class BaseController extends Controller
{
    public $layout = 'layout';
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $actions = $this->limitActions();
        if (empty($actions))
        {
            return true;
        }
        else
        {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => $actions,
                            'allow' => true,
                            'matchCallback' => function ($rule, $action)
                            {
                                $prilist = Role::prilist();
                                $route = $this->module->id . '/' . $this->id . '/' . $this->action->id;
                                $privilege = Privilege::findOne(['route' => $route]);
                                $isSuperAdmin = false;
                                if (Yii::$app->user->identity->uid == 1 && Yii::$app->user->identity->role_id == 1)
                                {
                                    $isSuperAdmin = true;
                                }
                                //超级管理
                                if ($isSuperAdmin)
                                {
                                    return true;
                                }
                                //无权限配置或权限配置为空也是超管
                                elseif (empty($privilege) || !$prilist)
                                {
                                    return true;
                                }
                                elseif (!empty($privilege) && in_array($privilege->id, $prilist))
                                {
                                    return true;
                                }
                                else
                                {
                                    if (isset($_GET['ajax']))
                                    {
                                        $result = ['result' => false, 'message' => '对不起！权限错误或访问未授权！如有需要请联系管理员'];
                                        echo json_encode($result);
                                    }
                                    else
                                    {
                                        echo "对不起！访问未授权！如有需要请联系管理员";
                                    }
                                    die();
                                }
                            }
                        ]
                    ]
                ]
            ];
        }
    }

    /**
     * 限制action数组，用于权限过滤，子类可以重写
     * @return array 限制actions数组
     */
    public function limitActions()
    {
        return [];
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
     * 转json
     * @param array $data
     * @return string
     */
    public function _to_json($data) {
        if (!empty($data)) {
            return json_encode($data);
        }
        return json_encode([]);
    }

    /**
     * 返回格式化数据转json
     * @param int $code
     * @param string $msg
     * @param bool $data
     * @return string
     */
    public function _json($code, $msg = '', $data = null) {
        @header('Content-Type:application/json;charset=utf-8');
        $r_data = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'request_ip' => Tools::_get_ip(),
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
        if (!empty($this->_request('jsonp'))) {
            $_callback_fun_name = $this->_request('jsonp');
        }

        if (!empty($_callback_fun_name)) {
            exit($_callback_fun_name . '(' . $this->_to_json($r_data) . ');');
        }

        exit($this->_to_json($r_data));
    }

    /**
     * 获取Request参数
     * @param string $key
     * @param bool|array|string $default 当请求的参数不存在时的默认值
     * @return string
     */
    public function _request($key = '', $default = false) {
        $request = array_merge(Yii::$app->request->get(), Yii::$app->request->post());
        if(empty($key)){
            return $request;
        }
        if(!isset($request[$key])){
            return $default;
        }
        return $request[$key];
    }

    /**
     * 获取值
     * @param $data mixed 要判断是否存在的值
     * @param $default mixed 当$data不存在时默认值
     * @param $empty bool true-同时验证$data还不能为空, 默认不验证
     * @return mixed mix
     **/
    public function _value($data, $default = '', $empty = false)
    {
        if ($empty) {
            return !empty($data) ? $data : $default;
        } else {
            return isset($data) ? $data : $default;
        }
    }

}

?>