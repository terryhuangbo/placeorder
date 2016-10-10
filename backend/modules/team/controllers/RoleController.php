<?php
namespace app\modules\team\controllers;

use app\modules\team\models\PrivilegeGroup;
use Yii;
use yii\data\Pagination;
use app\base\CommonWebController;
use app\modules\team\models\Role;
use app\modules\team\models\RoleForm;
use app\modules\team\models\Privilege;
use app\modules\team\models\RolePrivilege;

class RoleController extends CommonWebController
{
    public $layout = 'layout';

    /**
     * 路由权限控制
     * @return array
     */
    public function limitActions()
    {
        return ['list', 'list-view', 'add', 'update', 'del', 'details', 'search', 'joined', 'members', 'member'];
    }

    /**
     * @rolelist 用户组列表
     */
    public function actionList()
    {
        $model = new Role();
        $count = $model->find()->count();
        $page = new Pagination(['defaultPageSize' => yii::$app->params['page_size'], 'totalCount' => $count]);
        $roles = $model->find()->orderBy('id desc')->offset($page->offset)->limit($page->limit)->all();

        return $this->render('list', ['page' => $page, 'roles' => $roles]);
    }

    /**
     * @Roleadd  添加角色组
     */
    public function actionAdd()
    {
        $model = new RoleForm();
        $model->scenario = 'add';//验证规则场景识别

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $post = Yii::$app->request->post('RoleForm');
            // echo "<pre/>";print_r(Yii::$app->request->post());
            //角色入库
            $role = new Role();
            $role->role = $post['role'];
            $role->desc = $post['desc'];
            $role->save();

            //角色权限入库
            if (isset($post['prilist']))
            {
                $list = $post['prilist'];
                $role_id = $role->id;
                foreach ($list as $v)
                {
                    $obj = new RolePrivilege();
                    $obj->role_id = $role_id;
                    $obj->privilege_id = $v;
                    $obj->save();
                }
                Yii::$app->session->setFlash('success', '角色添加成功！权限也分配了');
            }
            else
            {
                Yii::$app->session->setFlash('success', '角色添加成功！但没做权限设置，索引是超级管理员');
            }
        }
        $prilist = Privilege::getPrilist();
        $privilegeGroup = PrivilegeGroup::privilegeGrouplist();
        return $this->render(
            'add',
            array('model' => $model, 'prilist' => $prilist, 'privilegeGroup' => $privilegeGroup)
        );
    }

    /**
     * 删除角色分组
     * @param $id
     */
    public function actionDel($id)
    {
        $role = Role::findOne($id);
        if ($role->delete())
        {
            Yii::$app->session->setFlash('success', '操作成功！');
        }
        else
        {
            Yii::$app->session->setFlash('error', '操作失败！');
        }
        $this->redirect(Yii::$app->urlManager->createUrl(['team/role/list']));

    }

    /**
     * 更新角色分组
     * @param $id
     * @return string
     */
    public function actionUpdate($id)
    {
        $role = Role::findOne($id);
        $roleform = new RoleForm();
        $roleform->scenario = 'update';//验证规则场景识别
        $roleform->attributes = $role->attributes;
        //当前用户权限
        $jsarr = array();
        foreach ($role->prilist as $v)
        {
            array_push($jsarr, $v->privilege_id);
        }
        //权限添加
        if ($roleform->load(Yii::$app->request->post()) && $roleform->validate())
        {

            //更新role模型
            $post = Yii::$app->request->post('RoleForm');
            $role->role = $post['role'];
            $role->desc = $post['desc'];
            $role->save();

            //检查权限是否改动
            if (isset($post['prilist']))
            {
                $pri = $post['prilist'];
                sort($pri);
                if (implode('', $pri) != implode('', $jsarr))
                {
                    //执行操作，删除原有权限oprilist，更新现有权限prilist
                    sort($jsarr);
                    foreach ($jsarr as $v)
                    {
                        RolePrivilege::deleteAll(
                            'role_id=:id and privilege_id=:pid',
                            [':id' => $post['id'], ':pid' => $v]
                        );
                    }
                    foreach ($post['prilist'] as $v)
                    {
                        $obj = new RolePrivilege();
                        $obj->role_id = $post['id'];
                        $obj->privilege_id = $v;
                        $obj->save();
                    }
                }
            }
            else
            {
                //删除全部权限
                RolePrivilege::deleteAll('role_id=:id ', [':id' => $post['id']]);
            }
            Yii::$app->session->setFlash('success', '更新成功！');
        }


        /**
         * 构造权限列表
         */
        $prilist = Privilege::getPrilist();
        $newprilist = array();
        foreach ($prilist as $groupid => $list)
        {
            foreach ($list as $id => $desc)
            {
                if (in_array($id, $jsarr))
                {
                    $chk = 'checked="true" ';
                    $css = 'background-color:#008000;color:#fff';
                }
                else
                {
                    $chk = $css = '';
                }
                $newprilist[$groupid][] = array('id' => $id, 'desc' => $desc, 'chk' => $chk, 'css' => $css);
            }
        }

        /**
         * 权限分组
         */
        $privilegeGroup = PrivilegeGroup::privilegeGrouplist();
        $privilegeGroup = $privilegeGroup;


        return $this->render(
            'update',
            array('model' => $roleform, 'prilist' => $newprilist, 'privilegeGroup' => $privilegeGroup)
        );
    }


    /**
     * @param $id
     * @return string  角色预览
     */
    public function actionReview($id)
    {
        //获取角色拥有的权限
        $role = Role::findOne($id);//获取当前角色对象
        $prilist = $role->prilist;//获取当前角色权限列表
        return $this->render('review', array('role' => $role, 'prilist' => $prilist));
    }

}