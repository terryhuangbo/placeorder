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
        foreach($this->group_bns as $group_bn){
            //卡组之下卡密数量
            $card_num = (new Card())->getCount(['group_bn' => $group_bn]);
            CardGroup::getDb()->createCommand()
                ->update(
                    CardGroup::tableName(),
                    ['card_num' => $card_num],
                    ['group_bn' => $group_bn]
                )->execute();
        }
    }

}
