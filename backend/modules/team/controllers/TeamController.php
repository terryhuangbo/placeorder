<?php
namespace app\modules\team\controllers;

use Yii;
use yii\data\Pagination;
use app\base\CommonWebController;
use app\modules\team\models\Team;
use app\modules\team\models\Role;

class TeamController extends CommonWebController
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
     * 基础维护管理列表
     * @return string
     */
    public function actionList()
    {
        //角色分组
        $roleArr = array();
        $roles = Role::find()->All();
        foreach ($roles as $v)
        {
            $roleArr[$v->id] = $v->role . '(' . $v->desc . ')';
        }
        $model = new Team();
        $query = $model->find();
        $searchKey = $this->getHttpParam('key', false, false);
        if ($searchKey)
        {
            $query->Where(['like', 'nickname', $searchKey]);
            $query->orWhere(['like', 'username', $searchKey]);
        }
        $count = $query->count();
        $page = new Pagination(['defaultPageSize' => yii::$app->params['page_size'], 'totalCount' => $count]);
        $users = $query->orderBy('uid desc')->offset($page->offset)->limit($page->limit)->all();
        return $this->render(
            'list',
            [
                'page' => $page,
                'users' => $users,
                'companyarr' => yii::$app->params['lhtxcompany'],
                'rolearr' => $roleArr,
                'searchKey' => $searchKey
            ]
        );
    }

    /**
     * 添加添加后台登录成员
     */
    public function actionAdd()
    {
        $model = new Team();
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $post = Yii::$app->request->post("Team");
            $model->password = md5($post['password']); //密码进行md5处理
            $model->save();
            Yii::$app->session->setFlash('success', '成员添加成功！');
        }

        return $this->render(
            'add',
            array('model' => $model, 'companyarr' => yii::$app->params['lhtxcompany'], 'rolearr' => Role::getRoleArr())
        );
    }

    /**
     * 删除成员
     * @id 成员ID
     * 最后跳转会列表
     * @param $id
     */
    public function actionDel($id)
    {
        $team = Team::findOne($id);
        if ($team->delete())
        {
            Yii::$app->session->setFlash('success', '操作成功！');
        }
        else
        {
            Yii::$app->session->setFlash('error', '操作失败！');
        }
        $this->redirect(Yii::$app->urlManager->createUrl(['team/team/list']));
    }

    /**
     * 更新成员信息
     * 密码是直接 md5(明文)
     * 不输入，不修改
     * @param $id
     */
    public function actionUpdate($id)
    {

        $model = Team::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $post = Yii::$app->request->post();
            $password = $post['Team']['password'];
            // 判断密码是否是密文
            if (preg_match("/^[a-z0-9]{32}$/", $password))
            {
                $model->password = $password;
            }
            else
            {
                $model->password = md5($password);
            }
            if ($model->save())
            {
                Yii::$app->session->setFlash('success', '修改成功！');
            }
            else
            {
                Yii::$app->session->setFlash('error', '修改失败！');
            }
            $this->redirect(Yii::$app->urlManager->createUrl(['team/team/list']));
        }
        else
        {
//            $model->scenario = 'edit';//验证规则场景识别
            return $this->render(
                'update',
                array(
                    'model' => $model,
                    'companyarr' => yii::$app->params['lhtxcompany'],
                    'rolearr' => Role::getRoleArr()
                )
            );
        }
    }
}