<?php

namespace backend\modules\card\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\lib\Tools;
use common\models\Card;

/**
 * 卡密相关操作
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2016-10-13
 **/
class CardController extends BaseController
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
            'add',
            'info',
            'save',
            'update',
            'ajax-save',
            'ajax-change-status',
        ];
    }

    /**
     * 卡密列表
     * @return type
     */
    public function actionListView()
    {
        return $this->render('list');
    }

    /**
     * 卡密数据
     */
    public function actionList()
    {
        if ($this->isGet()) {
            return $this->render('list');
        }
        $mdl = new Card();
        $query = $mdl::find();
        $search = $this->req('search');
        $page = $this->req('page', 0);
        $pageSize = $this->req('pageSize', 10);
        $offset = $page * $pageSize;
        $query->where(['status' => [Card::STATUS_YES, Card::STATUS_NO]]);
        if ($search) {
            if (isset($search['uptimeStart'])) //时间范围
            {
                $query = $query->andWhere(['>', 'create_time', strtotime($search['uptimeStart'])]);
            }
            if (isset($search['uptimeEnd'])) //时间范围
            {
                $query = $query->andWhere(['<', 'create_time', strtotime($search['uptimeEnd'])]);
            }
            if (!empty($search['name'])) {
                $query = $query->andWhere(['like', 'name', trim($search['name'])]);
            }
            if (isset($search['status'])) //筛选条件
            {
                $query->andWhere(['status' => (int) $search['status']]);
            }
        }
        //只能是上架，或者下架的产品
        $_order_by = 'id DESC';
        $count = $query->count();
        $cardArr = $query
            ->offset($offset)
            ->limit($pageSize)
            ->orderby($_order_by)
            ->all();
        $cardList = ArrayHelper::toArray($cardArr, [
            'common\models\Card' => [
                'id',
                'card_bn',
                'points',
                'status',
                'group_id',
                'pwd',
                'status_name' => function ($m) {
                    return Card::getCardStatus($m->status);
                },
                'create_time' => function ($m) {
                    return date('Y-m-d h:i:s', $m->create_time);
                },
                'update_time' => function ($m) {
                    return date('Y-m-d h:i:s', $m->update_time);
                },
            ],
        ]);
        $_data = [
            'cardList' => $cardList,
            'totalCount' => $count,
        ];
        return json_encode($_data);
    }

    /**
     * 添加卡密
     * @return array
     */
    function actionAdd()
    {
        if(!$this->isAjax()){
            return $this->render('add');
        }
        $card = $this->req('card', []);
        if(isset($card['id'])){
            unset($card['id']);
        }
        $card_num = intval(getValue($card, 'card_num', 0));
        if(empty($card_num)) {
            return $this->toJson(-20002, '生成卡密数量不能为空');
        }

        $valid_mdl = new Card();
        $valid_mdl->scenario = Card::SCENARIO_ADD;
        $valid_mdl->setAttributes($card);
        //校验数据
        if (!$valid_mdl->validate())
        {
            $errors = $valid_mdl->getFirstErrors();
            return $this->toJson(-20003, reset($errors));
        }
        //保存数据
        for($i=0; $i<$card_num; $i++){
            $mdl = new Card();
            $mdl->setAttributes($card);
            if (!$mdl->save(false))
            {
                $errors = $mdl->getFirstErrors();
                return $this->toJson(-20004, reset($errors));
            }
        }
        return $this->toJson(20000, '卡密添加成功');
    }

    /**
     * 添加卡密
     * @return array
     */
    function actionUpdate()
    {
        $id = intval($this->req('id'));
        $card_info = $this->req('card', []);

        //检验参数是否合法
        if (empty($id)) {
            return $this->toJson(-20001, '卡密序号id不能为空');
        }

        //检验卡密是否存在
        $mdl = new Card();
        $card = $mdl->getOne(['id' => $id]);
        if (!$card) {
            return $this->toJson(-20002, '卡密信息不存在');
        }
        //加载
        if(!$this->isAjax()){
            $_data = [
                'card' => $card
            ];
            return $this->render('update', $_data);
        }
        //保存
        $card_info['id'] = $id;
        $ret = $mdl->saveCard($card_info, Card::SCENARIO_UPDATE);
        return $this->toJson($ret['code'], $ret['msg']);
    }

    /**
     * 改变卡密状态
     * @return array
     */
    function actionAjaxChangeStatus()
    {
        $id = intval($this->req('id', 0));
        $card_status = $this->req('card_status', 0);
        $mdl = new Card();
        $update_info = [
            'id' => $id,
            'status' => $card_status,
        ];
        $ret = $mdl->saveCard($update_info);
        return $this->toJson($ret['code'], $ret['msg']);
    }

}
