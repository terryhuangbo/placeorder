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
    public $checker_id = null;//后台登录人员ID

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
     * 需要初始化的信息
     */
    public function init()
    {
        parent::init();
        //后台登录人员ID
        $this->checker_id = Yii::$app->user->identity->uid;
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