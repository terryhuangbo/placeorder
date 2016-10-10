<?php

namespace backend\modules\auth\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\api\VsoApi;
use common\models\User;
use common\models\Auth;
use app\modules\team\models\Team;
use common\lib\Upload;

class AuthController extends BaseController
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
            'ajax-check',
            'upload-name-card',
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
        $mdl = new Auth();
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
            if (isset($search['auth_status'])) //用户状态
            {
                $query = $query->andWhere(['auth_status' => $search['auth_status']]);
            }
            if (isset($search['mobile'])) //手机号码
            {
                $query = $query->andWhere(['mobile' => $search['mobile']]);
            }
            if (isset($search['name'])) //用户状态
            {
                $query = $query->andWhere(['like', 'name', $search['name']]);
            }
        }

        $_order_by = 'auth_id DESC';
        $userArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $authList = ArrayHelper::toArray($userArr, [
            'common\models\Auth' => [
                'auth_id',
                'nick',
                'name',
                'mobile',
                'avatar',
                'email',
                'auth_status',
                'wechat' => 'wechat_openid',
                'user_type' => function ($m) {
                    return User::_get_user_type($m->user_type);
                },
                'status_name' => function ($m) {
                    return Auth::_get_auth_status($m->auth_status);;
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
                'inputer' => function ($m) {
                    return '录入人';
                },
                'checker' => function ($m) {
                    return '审核人';
                },
                'update_at' => function ($m) {
                    return date('Y-m-d h:i:s', $m->update_at);
                },
            ],
        ]);
        $_data = [
            'userList' => $authList,
            'totalCount' => count($authList)
        ];
        exit(json_encode($_data));
    }

    /**
     * 改变用户状态
     * @return array
     */
    function actionAjaxCheck()
    {

        $auth_id = intval($this->_request('auth_id'));
        $auth_status = intval($this->_request('auth_status'));
        $reason = trim($this->_request('reason'));

        //检验参数是否合法
        if (empty($auth_id)) {
            $this->_json(-20001, '审核编号id不能为空');
        }
        if (!in_array($auth_status, [Auth::CHECK_PASS, Auth::CHECK_UNPASS])) {
            $this->_json(-20002, '审核状态错误');
        }

        //保存状态及原因
        $reslut = Auth::_save_check($auth_id, $auth_status, $reason);

        $this->_json($reslut['code'], $reslut['msg']);
    }

    /**
     * 加载用户详情
     * @return array
     */
    function actionInfo()
    {
        $auth_id = intval($this->_request('auth_id'));

        $mdl = new Auth();
        //检验参数是否合法
        if (empty($auth_id)) {
            $this->_json(-20001, '审核编号id不能为空');
        }

        //检验用户是否存在
        $auth = $mdl->_get_info(['auth_id' => $auth_id]);
        if (!$auth) {
            $this->_json(-20003, '审核信息不存在');
        }
        $auth['status_name'] = Auth::_get_auth_status($auth['auth_status']);
        $auth['user_type'] = User::_get_user_type($auth['user_type']);
        $auth['update_at'] = date('Y-m-d h:i:s', $auth['update_at']);
        $auth['create_at'] = date('Y-m-d h:i:s', $auth['create_at']);
        $_data = [
            'auth' => $auth
        ];
        return $this->render('info', $_data);
    }

    /**
     * 上传名片，并且更新
     * @return array
     */
    public function actionUploadNameCard() {
        $objtype = trim($this->_request('objtype', 'pictures', true));
        $auth_id = intval($this->_request('auth_id'));

        //检验参数是否合法
        if (empty($auth_id)) {
            $this->_json(-20001, '审核编号id不能为空');
        }
        //检验用户是否存在
        $mdl = new Auth();
        $auth = $mdl->_get_info(['auth_id' => $auth_id]);
        if (!$auth) {
            $this->_json(-20003, '审核信息不存在');
        }

        $up_mdl = new Upload();
        $result = $up_mdl->upload(yiiParams('img_save_dir'), $objtype);
        //上传失败
        if($result['code'] < 0){
            $this->_json(-20000, $result['msg']);
        }
        //保存名片
        $res = $mdl->_save([
            'auth_id' => $auth_id,
            'name_card' => $result['data']['filePath'],
        ]);
        if(!$res){
            $this->_json(-20004, '保存名片失败');
        }

        //成功返回
        $this->_json(20000, $result['msg'], $result['data']);
    }

}
