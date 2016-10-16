<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\behavior;

use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\base\Behavior;
use yii\db\Exception;
use common\models\User;
use common\models\Card;
use common\models\CardGroup;


/**
 * 卡组或者卡密做插入，更新操时，会执行的行为
 *
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2016-10-14 16:19
 */
class CardBehavior extends Behavior
{
    /**
     * @var callable|Expression The expression that will be used for generating the timestamp.
     */
    public $group_bns = [];


    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'handleInsert', //将事件和事件处理器绑定
            ActiveRecord::EVENT_AFTER_UPDATE => 'handleUpdate', //将事件和事件处理器绑定
            Card::EVENT_CHARGE => 'handleCharge', //将事件和事件处理器绑定
            Card::EVENT_SPLIT => 'handleSplit', //将事件和事件处理器绑定
        ];

    }

    /**
     * @inheritdoc
     */
    public function handleInsert($event) {
        $owner = $this->owner;
        if($owner instanceof Card){
            if(empty($this->group_bns)){
                $group_bn = $owner->group_bn;
                $this->group_bns = [$group_bn];
            }
            $this->_updateCardGroup();
        }else{
            throw new Exception('参数错误！');
        }
    }

    /**
     * @inheritdoc
     */
    public function handleUpdate($event) {
        $owner = $this->owner;
        if($owner instanceof Card){
            $dirtyAttr = $event->changedAttributes;
            if(!isset($dirtyAttr['group_bn'])){
                return true;
            }
            if(empty($this->group_bns)){
                $this->group_bns = [$dirtyAttr['group_bn'], $owner->getAttribute('group_bn')];
            }
            $this->_updateCardGroup();
        }else{
            throw new Exception('参数错误！');
        }
    }

    /**
     * 更新卡组表对应卡组下的卡密数量
     * @inheritdoc
     */
    private function _updateCardGroup() {
        $mdl = new Card();
        foreach($this->group_bns as $group_bn){
            //卡组之下卡密数量
            $card_num = $mdl->getCount(['group_bn' => $group_bn]);
            CardGroup::getDb()->createCommand()
                ->update(
                    CardGroup::tableName(),
                    ['card_num' => $card_num],
                    ['group_bn' => $group_bn]
                )->execute();
        }
    }

    /**
     * 处理卡充值事件
     */
    public function handleCharge($event) {
        $card = $this->owner;
        $user = $event->chargedUser;//用户或者卡密
        $points = $event->points;
        if(!($user instanceof User) && !($user instanceof Card)){
            $event->code = -20002;
            $event->msg = '充值用户不存在';
        }
        //判断充值金额是否足够
        if($card->points < $points){
            $event->code = -20003;
            $event->msg = '此卡余额不足';
        }
        //保存
        $transaction = Card::getDb()->beginTransaction();
        try{
            $user->points += $points;
            $ret = $user->save();
            if($ret['code'] < 0){
                throw new Exception('用户充值失败');
            }

            $card->points -= $points;
            $ret = $card->save();
            if($ret['code'] < 0){
                throw new Exception('卡密扣款失败');
            }

            $transaction->commit();
            $event->code = 20000;
            $event->msg = '充值成功';
            $event->handled = true;

        }catch (Exception $e){
            $transaction->rollBack();
            $event->code = -20000;
            $event->msg = $e->getMessage();
        }

    }

    /**
     * 处理拆卡事件
     */
    public function handleSplit($event) {
        $user = $event->splitedUser;
        $num = (int) $event->num;
        $each_points = (int) $event->each_points;
        $pwd = $event->pwd;
        $comment = $event->comment;

        if(!($user instanceof User) && !($user instanceof Card)){
            $event->code = -20002;
            $event->msg = '充值用户不存在';
        }

        //充值金额是否为正整数
        if($each_points <= 0){
            $event->code = -20001;
            $event->msg = '充值金额错误';
            return;
        }
        //卡余额是否足够
        if($user->points < $num * $each_points){
            $event->code = -20002;
            $event->msg = '余额不足';
            return;
        }

        //保存
        $transaction = Card::getDb()->beginTransaction();
        try{

            //原卡扣款
            $user->points -= $num * $each_points;
            $ret = $user->save();
            if($ret['code'] < 0){
                throw new Exception('卡密扣款失败');
            }

            //生成新的卡组
            $group = new CardGroup();
            $group->uid = $user->uid;
            $group->points = $each_points;
            $group->pwd = $pwd;
            $group->card_num = $num;
            $group->comment = $comment;
            $ret = $group->save();
            if($ret['code'] < 0){
                throw new Exception('卡组生成失败');
            }
            $group_bn = $group->group_bn;

            //生成新卡
            for($i=0; $i<$num; $i++){
                $new_card = new Card();
                $new_card->off(Card::EVENT_AFTER_INSERT);//解除更新卡组操作
                $new_card->attributes = [
                    'uid' => $user->uid,
                    'pid' => ($user instanceof Card) ?  $user->id : 0,
                    'points' => $each_points,
                    'pwd' => $pwd,
                    'group_bn' => $group_bn,
                ];
                $ret = $new_card->save();
                if($ret['code'] < 0){
                    throw new Exception('生成新卡失败');
                }
            }

            $transaction->commit();

            $event->code = 20000;
            $event->msg = '拆卡成功';
            $event->handled = true;

        }catch (Exception $e){
            $transaction->rollBack();

            $event->code = -20000;
            $event->msg = $e->getMessage();
        }

    }



}
