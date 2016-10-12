<?php

namespace common\models;

use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%pay}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $oid
 * @property integer $cost
 * @property integer $balance
 * @property integer $create_time
 */
class Pay extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pay}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'oid', 'cost', 'balance', 'create_time'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '支付ID',
            'uid' => '用户ID',
            'oid' => '订单ID',
            'cost' => '消费金额（点数）',
            'balance' => '剩余金额（点数）',
            'create_time' => '创建时间',
        ];
    }
}
