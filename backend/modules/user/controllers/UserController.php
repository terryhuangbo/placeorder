<?php

namespace backend\modules\user\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\models\User;

/**
 * 后台用户和账号相关操作
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2016-10-13
**/
class UserController extends BaseController
{

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
        $search = $this->req('search');
        $page = $this->req('page', 0);
        $pageSize = $this->req('pageSize', 10);
        $offset = $page * $pageSize;
        if ($search) {
            //用户账号
            if (isset($search['username']))
            {
                $query = $query->andWhere(['username' => $search['username']]);
            }
            //QQ
            if (isset($search['qq']))
            {
                $query = $query->andWhere(['qq' => $search['qq']]);
            }
            //注册时间
            if (isset($search['regtimeStart'])) 
            {
                $query = $query->andWhere(['>', 'reg_time', strtotime($search['regtimeStart'])]);
            }
            if (isset($search['regtimeEnd'])) 
            {
                $query = $query->andWhere(['<', 'reg_time', strtotime($search['regtimeEnd'])]);
            }
            //最近登录
            if (isset($search['logtimeStart'])) 
            {
                $query = $query->andWhere(['>', 'login_time', strtotime($search['logtimeStart'])]);
            }
            if (isset($search['logtimeEnd'])) 
            {
                $query = $query->andWhere(['<', 'login_time', strtotime($search['logtimeEnd'])]);
            }
        }

        $_order_by = 'uid DESC';
        $count = $query->count();
        $userArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $userList = ArrayHelper::toArray($userArr, [
            'common\models\User' => [
                'uid',
                'username',
                'qq',
                'points',
                'reg_time' => function ($m) {
                    return date('Y-m-d h:i:s', $m->reg_time);
                },
                'login_time' => function ($m) {
                    return date('Y-m-d h:i:s', $m->login_time);
                },
                'update_time' => function ($m) {
                    return date('Y-m-d h:i:s', $m->update_time);
                },
            ],
        ]);
        $_data = [
            'userList' => $userList,
            'totalCount' => $count
        ];
        return json_encode($_data);
    }

    /**
     * 加载用户详情
     */
    function actionInfo()
    {
        $uid = intval($this->req('uid'));

        $mdl = new User();
        //检验参数是否合法
        if (empty($uid)) {
            $this->toJson(-20001, '用户编号id不能为空');
        }

        //检验用户是否存在
        $user = $mdl->getOne(['uid' => $uid]);
        if (!$user) {
            $this->toJson(-20003, '用户信息不存在');
        }
        $user['reg_time'] = date('Y-m-d h:i:s', $user['reg_time']);
        $user['login_time'] = date('Y-m-d h:i:s', $user['login_time']);
        $_data = [
            'user' => $user
        ];
        return $this->render('info', $_data);
    }

}
