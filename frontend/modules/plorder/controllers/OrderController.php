<?php

namespace frontend\modules\plorder\controllers;

use common\models\Card;
use Yii;
use app\base\BaseController;
use common\models\Goods;
use common\models\Order;
use common\models\Meta;
use common\models\CardGroup;


class OrderController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;

    public function init(){
        $this->_uncheck = [

        ];
    }

    /**
     * 用户中心
     * @return type
     */
    public function actionIndex()
    {
        $gid = $this->req('gid', 0);
        $goods = (new Goods())->getOne(['gid'  => $gid]);
        //商品为空，跳转到商品首页
        if(empty($goods)){
            $this->redirect('/plorder/goods/index');
        }
        //用户登录或者卡密登录
        if($this->userLog){
            $info = $this->user;
        }else{
            $info['username'] = $this->card['card_bn'];
            $info['login_time'] = $this->card['create_time'];
            $info['points'] = $this->card['points'];
        }

        $_data = [
            'info' => $info,
            'goods' => $goods,
            'meta'  => (new Meta())->asArray(),
            'userLog' => (int) $this->userLog,
        ];
        return $this->render('index', $_data);
    }

    /**
     * 生成订单
     * @return type
     */
    public function actionAdd()
    {
        $post = $this->req();
        if($this->userLog){
            $post['uid'] = $this->uid;
            $scenario = Order::SCENARIO_USER;
        }else{
            $post['card_bn'] = $this->card_bn;
            $scenario = Order::SCENARIO_CARD;
        }
        $mdl = new Order();
        $ret = $mdl->saveOrder($post, $scenario);
        return json_encode($ret);

    }

    /**
     * 批量下单
     * @return type
     */
    public function actionBatchAdd()
    {
        $text = $this->req('text', '');
        $gid  = $this->req('gid', 0);

        $orders = [];
        if(empty($text)){
            return $this->toJson('-20001', '请输入下单QQ和数量');
        }

        //获取qq-num
        $patter = '/(.*)(\s)*\b/';
        preg_match_all($patter, $text, $result);

        $patter1 = '/(\w+)-{4}(\w+)/';
        $str_arr = getValue($result, 1, []);
        foreach($str_arr as $str){
            if(!empty($str)){
                preg_match_all($patter1, $str, $res);
                $qq = reset($res[1]);
                $num = reset($res[2]);
                if(ctype_digit($qq) && ctype_digit($num)){
                    $orders[] = [
                        'qq' => $qq,
                        'num' => $num,
                        'uid' =>$this->uid,
                        'gid' =>$gid,
                    ];
                }
            }
        }

        //保存
        $success = [];
        $scenario = $this->userLog ? Order::SCENARIO_USER : Order::SCENARIO_CARD;
        foreach($orders as $order){
            $mdl = new Order();
            $ret = $mdl->saveOrder($order, $scenario);
            if($ret['code'] < 0){
                $_pre_msg = "QQ为{$order['qq']}下单失败：";
                $_suf_msg = count($success) > 0 ? '。已成功下单QQ：' . implode($success, '，') : '';
                return $this->toJson('-20001', $_pre_msg . $ret['msg'] . $_suf_msg);
            }
            $success[] = $order['qq'];
        }
        $_suf_msg = count($success) > 0 ? '已成功下单QQ：' . implode($success, '，') : '';
        return $this->toJson('20000', $_suf_msg);

    }

    /**
     * 订单列表
     * @return type
     */
    public function actionOrderList()
    {
        $qq = $this->req('qq', '');
        $format = [
            'qq',
            'num',
            'create_time' => function($m){
                return date('Y-m-d H:i:s', $m->create_time);
            },
            'goods_num_now' => function($m){
                return getValue($m, 'goods.num', 0);
            },
            'goods_num_org' => function($m){
                return getValue($m, 'goods.num', 0) + $m->num;
            },
            'status_name' => function ($m) {
                return Order::getOrderStatus($m->status);
            },
            'operate' => function ($m) {
                return '-无-';
            },
        ];
        $with = ['goods'];
        $where = ['and'];
        if($this->userLog){
            $where[] = ['uid' => $this->uid];
        }else{
            $where[] = ['card_bn' => $this->card_bn];
        }
        if(!empty($qq)){
            $where[] = ['like', 'qq', $qq];
        }
        $list = (new Order())->getRelationAll('*', $where,['with' => $with], 'oid DESC', 1, 0, $format);
        return $this->toJson('20000', '查询成功', $list);
    }

    /**
     * 卡密列表
     * @return type
     */
    public function actionCardList()
    {
        $card_bn = $this->req('card_bn', '');
        $group_bn = $this->req('group_bn', '');
        $select = [
             "card_id" => Card::tableName(). ".id",
             "card_status" => Card::tableName(). ".status",
             Card::tableName(). ".*",
             CardGroup::tableName(). ".*",
        ];
        $join = ['cardGroup'];
        $where = ['and'];
        if(!empty($card_bn)){
            $where[] = ['like', Card::tableName() . '.card_bn', $card_bn];
        }
        if(!empty($group_bn)){
            $where[] = [Card::tableName() . '.group_bn' => $group_bn];
        }

        if($this->userLog){
            $where[] = [Card::tableName() . '.uid' => $this->uid];
        }else{
            $card = Card::findOne(['card_bn' => $this->card_bn]);
            $where[] = ['pid' => $card->id];
        }

        $list = (new Card())->getRelationAll($select, $where,['joinWith' => $join], Card::tableName() . ".id DESC", 1, 0);
        foreach($list as $k => $m){
            $list[$k]['group_points'] = getValue($m, 'cardGroup.points');
            $list[$k]['create_time'] = date('Y-m-d H:i:s', getValue($m, 'create_time', 0));
            $list[$k]['status_name'] = Card::getCardStatus($m['card_status']);
            if($m['card_status'] == Card::STATUS_YES){
                $list[$k]['operate'] = '<a href="#" onclick="alterCard('. $m['card_id'] .', '. Card::STATUS_NO .')">禁用此卡</a>';
            }else{
                $list[$k]['operate'] = '<a href="#" onclick="alterCard('. $m['card_id'] .', '. Card::STATUS_YES .')">启用此卡</a>';
            }
        }
        return $this->toJson('20000', '查询成功', $list);
    }

    /**
     * 卡组列表
     * @return type
     */
    public function actionCardGroupList()
    {
        $card_bn = $this->req('card_bn', '');
        $group_bn = $this->req('group_bn', '');
        $comment = $this->req('comment', '');
        $select = [
            "group_id" => CardGroup::tableName(). ".id",
            "group_status" => CardGroup::tableName(). ".status",
            "group_points" => CardGroup::tableName(). ".points",
            Card::tableName(). ".*",
            CardGroup::tableName(). ".*",
        ];
        $join = ['card'];
        $where = ['and'];

        if(!empty($card_bn)){
            $where[] = [Card::tableName() . '.card_bn' => $card_bn];
        }
        if(!empty($group_bn)){
            $where[] = [CardGroup::tableName() . '.group_bn' => $group_bn];
        }
        if(!empty($comment)){
            $where[] = ['like', 'comment', $comment];
        }

        if($this->userLog){
            $where[] = [CardGroup::tableName() . '.uid' => $this->uid];
        }else{
            $card = Card::findOne(['card_bn' => $this->card_bn]);
            $where[] = [CardGroup::tableName() . '.group_bn' => $card->group_bn];
        }

        $list = (new CardGroup())->getRelationAll($select, $where,['joinWith' => $join], CardGroup::tableName() . ".id DESC", 1, 0);
        foreach($list as $k => $m){
            $list[$k]['create_time'] = date('Y-m-d H:i:s', getValue($m, 'create_time', 0));
            $list[$k]['status_name'] = CardGroup::getCardGroupStatus($m['group_status']);
            $list[$k]['sum_points'] = $m['points'] * $m['card_num'];
            if($m['group_status'] == CardGroup::STATUS_YES){
                $list[$k]['operate'] = '<a href="#" onclick="alterCardGroup('. $m['group_id'] .', '. CardGroup::STATUS_NO .')">禁用此卡组</a>';
            }else{
                $list[$k]['operate'] = '<a href="#" onclick="alterCardGroup('. $m['group_id'] .', '. CardGroup::STATUS_YES .')">启用此卡组</a>';
            }
        }
        lg($list);
        return $this->toJson('20000', '查询成功', $list);
    }





}
