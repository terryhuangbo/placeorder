<?php

namespace backend\modules\user\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\api\VsoApi;
use common\models\User;
use common\models\Auth;
use app\modules\team\models\Team;

class UserController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;
    public $checker_id = '';

    /**
     * 放置需要初始化的信息
     */
    public function init()
    {
        //后台登录人员ID
        $this->checker_id = Yii::$app->user->identity->uid;
    }

    /**
     * 路由权限控制
     * @return array
     */
    public function limitActions()
    {
        return [
            'list',
            'list-view',
            'export',
            'info',
            'update',
            'ajax-save',
            'ajax-change-status',
        ];
    }

    /**
     * 用户列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 用户数据
     */
    public function actionList()
    {
        if ($this->isGet()) {
            return $this->render('list');
        }
        $mdl = new User();
        $query = $mdl::find();
        $search = $this->_request('search');
        $page = $this->_request('page', 0);
        $pageSize = $this->_request('pageSize', 10);
        $offset = $page * $pageSize;
        if ($search) {
            if (isset($search['uptimeStart'])) //时间范围
            {
                $query = $query->andWhere(['>', 'update_at', strtotime($search['uptimeStart'])]);
            }
            if (isset($search['uptimeEnd'])) //时间范围
            {
                $query = $query->andWhere(['<', 'update_at', strtotime($search['uptimeEnd'])]);
            }
            if (isset($search['user_type'])) //用户类型
            {
                $query = $query->andWhere(['user_type' => $search['user_type']]);
            }
            if (isset($search['user_status'])) //用户状态
            {
                $query = $query->andWhere(['user_status' => $search['user_status']]);
            }
            if (isset($search['mobile'])) //手机号码
            {
                $query = $query->andWhere(['mobile' => $search['mobile']]);
            }
            if (isset($search['name'])) //用户名称
            {
                 $query = $query->andWhere(['like', 'name', $search['name']]);
            }
        }

        $_order_by = 'uid DESC';
        $userArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $userList = ArrayHelper::toArray($userArr, [
            'common\models\User' => [
                'uid',
                'nick',
                'name',
                'mobile',
                'avatar',
                'email',
                'points',
                'wechat' => 'wechat_openid',
                'user_type' => function ($m) {
                    return User::_get_user_type($m->user_type);
                },
                'user_status' => function ($m) {
                    return User::_get_user_status($m->user_status);
                },
                'status' => 'user_status',
                'inputer' => function ($m) {
                    return '录入人';
                },
                'name_card' => function ($m) {
                    $imgs_list = json_decode($m->user_type_imgs);
                    if(!empty($imgs_list)){
                        if(is_array($imgs_list)){
                            return $imgs_list[0];
                        }else{
                            return $imgs_list;
                        }
                    }
                    return '';
                },
                'checker' => function ($m) {
                    return '审核人';
                },
                'update_at' => function ($m) {
                    return date('Y-m-d h:i:s', $m->update_at);
                },
                'create_at' => function ($m) {
                    return date('Y-m-d h:i:s', $m->create_at);
                },
            ],
        ]);

        $_data = [
            'userList' => $userList,
            'totalCount' => count($userList)
        ];
        exit(json_encode($_data));
    }

    /**
     * 改变用户状态
     * @return array
     */
    function actionAjaxChangeStatus()
    {
        $uid = intval($this->_request('uid'));
        $status = intval($this->_request('status'));

        $mdl = new User();
        //检验参数是否合法
        if (empty($uid)) {
            $this->_json(-20001, '用户编号id不能为空');
        }
        if (!in_array($status, [$mdl::IS_DELETE, $mdl::NO_DELETE])) {
            $this->_json(-20002, '用户状态错误');
        }

        //检验用户是否存在
        $user = $mdl->_get_info(['uid' => $uid]);
        if (!$user) {
            $this->_json(-20003, '用户信息不存在');
        }

        if ($status == $mdl::NO_DELETE) {
            $rst = $mdl->_save([
                'uid' => $uid,
                'user_status' => $mdl::NO_DELETE,
                'update_at' => time(),
            ]);
            if (!$rst) {
                $this->_json(-20004, '用户信息保存失败');
            }
        } else {
            $rst = $mdl->_save([
                'uid' => $uid,
                'user_status' => $mdl::IS_DELETE,
                'update_at' => time(),
            ]);
            if (!$rst) {
                $this->_json(-20005, '用户信息保存失败');
            }
        }

        $this->_json(20000, '保存成功！');
    }

    /**
     * 加载用户详情
     * @return array
     */
    function actionInfo()
    {
        $uid = intval($this->_request('uid'));

        $mdl = new User();
        //检验参数是否合法
        if (empty($uid)) {
            $this->_json(-20001, '用户编号id不能为空');
        }

        //检验用户是否存在
        $user = $mdl->_get_info(['uid' => $uid]);
        if (!$user) {
            $this->_json(-20003, '用户信息不存在');
        }
        $user['user_status'] = User::_get_user_status($user['user_status']);
        $user['user_type'] = User::_get_user_type($user['user_type']);
        $user['update_at'] = date('Y-m-d h:i:s', $user['update_at']);
        $user['create_at'] = date('Y-m-d h:i:s', $user['create_at']);
        $_data = [
            'user' => $user
        ];
        return $this->render('info', $_data);
    }

    /**
     * 编辑用户信息
     * @return array
     */
    function actionUpdate()
    {
        $uid = intval($this->_request('uid'));

        $mdl = new User();
        //检验参数是否合法
        if (empty($uid)) {
            $this->_json(-20001, '用户编号id不能为空');
        }

        //检验用户是否存在
        $user = $mdl->_get_info(['uid' => $uid]);
        if (!$user) {
            $this->_json(-20003, '用户信息不存在');
        }

        $_data = [
            'user' => $user
        ];
        return $this->render('edit', $_data);
    }

    /**
     * 编辑用户信息
     * @return array
     */
    function actionAjaxSave()
    {
        $uid = intval($this->_request('uid'));
        $email = trim($this->_request('email'));
        $mobile = trim($this->_request('mobile'));

        $mdl = new User();
        //检验参数是否合法
        if (empty($uid)) {
            $this->_json(-20001, '用户编号id不能为空');
        }
        if (empty($email)) {
            $this->_json(-20002, '电子邮箱不能为空');
        }
        if (empty($mobile)) {
            $this->_json(-20003, '用户手机号码不能为空');
        }

        //检验用户是否存在
        $user = $mdl->_get_info(['uid' => $uid]);
        if (!$user) {
            $this->_json(-20004, '用户信息不存在');
        }

        $rst = $mdl->_save([
            'uid' => $uid,
            'email' => $email,
            'mobile' => $mobile,
            'update_at' => time(),
        ]);
        if (!$rst) {
            $this->_json(-20005, '用户信息保存失败');
        }

        $this->_json(20000, '用户信息保存成功！');
    }






}
