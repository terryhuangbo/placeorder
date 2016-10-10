<?php
/**
 * Created by PhpStorm.
 * User: LuChuang
 * Date: 2015/11/3
 * Time: 10:14
 */

namespace app\modules\team\controllers;

use Yii;
use yii\data\Pagination;
use app\base\CommonWebController;
use app\modules\team\models\Privilege;
use app\modules\team\models\PrivilegeGroup;
use app\modules\team\models\RolePrivilege;

class PrivilegeController extends CommonWebController
{
    public $layout = 'layout';

    /**
     * 路由权限控制
     * @return array
     */
    public function limitActions()
    {
        return [
            'list',
            'list-view',
            'add',
            'update',
            'del',
            'review',
            'add-group',
            'list-group',
            'update-group',
            'del-group'
        ];
    }

    /**
     * @权限列表
     *
     */
    public function actionList()
    {
        $model = new Privilege();
        $query = $model->find();
        $searchKey = $this->getHttpParam('key', false, false);
        if ($searchKey)
        {
            $query->where(['like', 'desc', $searchKey]);
            $query->orWhere(['like', 'route', $searchKey]);
        }
        $count = $query->count();
        $page = new Pagination(['defaultPageSize' => yii::$app->params['page_size'], 'totalCount' => $count]);
        $privileges = $query->orderBy('id desc')->offset($page->offset)->limit($page->limit)->all();
        return $this->render(
            'list',
            [
                'page' => $page,
                'privileges' => $privileges,
                'grouptypearr' => PrivilegeGroup::privilegeGrouplist(),
                'searchKey' => $searchKey
            ]
        );
    }

    /**
     * @return string 权限添加
     */
    public function  actionAdd()
    {
        $model = new Privilege();
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if ($model->save())
            {
                $role_pri = new RolePrivilege();
                //将权限赋给管理员
                $role_pri->role_id = 1;//管理员组账号
                $role_pri->privilege_id = $model->id;
                $role_pri->save();

                Yii::$app->session->setFlash('success', '权限添加成功！');
            }
            else
            {
                Yii::$app->session->setFlash('error', '权限添加失败！');
            }
        }
        return $this->render('add', ['model' => $model, 'grouptypearr' => PrivilegeGroup::privilegeGrouplist()]);
    }

    /**
     * @修改权限信息
     */
    public function actionUpdate($id)
    {
        $model = Privilege::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if ($model->save())
            {
                Yii::$app->session->setFlash('success', '权限修改成功！');
            }
            else
            {
                Yii::$app->session->setFlash('error', '权限修改失败！');
            }
        }
        return $this->render(
            'update',
            array('model' => $model, 'grouptypearr' => PrivilegeGroup::privilegeGrouplist())
        );
    }

    /**
     * @删除权限信息；删除操作会影响到权限角色表，所以对于权限角色表也要更新数据；
     */
    public function  actionDel($id)
    {
        $role = Privilege::findOne($id);
        if ($role->delete())
        {
            Yii::$app->session->setFlash('success', '操作成功');
        }
        else
        {
            Yii::$app->session->setFlash('error', '操作失败！');
        }
        return $this->redirect(Yii::$app->urlManager->createUrl(['team/privilege/list']));
    }

    /**
     * @param $id
     * @return string 内容预览
     */
    public function actionReview($id)
    {
        $data = Privilege::findOne($id);
        return $this->render('review', array('data' => $data));
    }

    /**
     * @权限列表
     *
     */
    public function actionListGroup()
    {
        $model = new PrivilegeGroup();
        $count = $model->find()->count();
        $page = new Pagination(['defaultPageSize' => yii::$app->params['page_size'], 'totalCount' => $count]);
        $list = $model->find()->orderBy('id desc')->offset($page->offset)->limit($page->limit)->all();

        return $this->render(
            'listgroup',
            ['page' => $page, 'privilegesgroups' => $list, 'grouptypearr' => PrivilegeGroup::privilegeGroupArr()]
        );
    }

    /**
     * @return string 权限添加
     */
    public function  actionAddGroup()
    {
        $model = new PrivilegeGroup();
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if ($model->save())
            {
//                $role_pri = new RolePrivilege();
//                //将权限赋给管理员
//                $role_pri->role_id = 1;//管理员组账号
//                $role_pri->privilege_id = $model->id;
//                $role_pri->save();

                Yii::$app->session->setFlash('success', '权限分组添加成功！');
            }
            else
            {
                Yii::$app->session->setFlash('error', '权限分组添加失败！');
            }
        }
        return $this->render('addgroup', ['model' => $model, 'grouptypearr' => PrivilegeGroup::privilegeGroupArr()]);
    }

    /**
     * @修改权限信息
     */
    public function actionUpdateGroup($id)
    {
        $model = PrivilegeGroup::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if ($model->save())
            {
                Yii::$app->session->setFlash('success', '权限修改成功！');
            }
            else
            {
                Yii::$app->session->setFlash('error', '权限修改失败！');
            }
        }
        return $this->render(
            'updategroup',
            array('model' => $model, 'grouptypearr' => PrivilegeGroup::privilegeGroupArr())
        );
    }

    /**
     * @删除权限信息；删除操作会影响到权限角色表，所以对于权限角色表也要更新数据；
     */
    public function  actionDelGroup($id)
    {
        $role = PrivilegeGroup::findOne($id);
        if ($role->delete())
        {
            Yii::$app->session->setFlash('success', '操作成功');
        }
        else
        {
            Yii::$app->session->setFlash('error', '操作失败！');
        }
        return $this->redirect(Yii::$app->urlManager->createUrl(['team/privilege/list-group']));
    }


}