<?php

namespace common\models;

use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $oid
 * @property string $order_bn
 * @property integer $pid
 * @property integer $num
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 */
class Order extends BaseModel
{
    /**
     * 订单状态
     */
    const STATUS_YES = 1;//下单成功
    const STATUS_NO  = 2;//下单失败

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'num', 'status', 'create_time', 'update_time'], 'integer'],
            [['order_bn'], 'string', 'max' => 30],
            //订单状态
            ['status', 'in', 'range' => [self::STATUS_YES, self::STATUS_NO], 'message' => '订单状态错误'],
            //商品ID
            ['pid', 'exist', 'targetAttribute' => 'id', 'targetClass' => Goods::className(), 'message' => '商品不存在']

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'oid' => '订单ID',
            'order_bn' => '订单编号',
            'pid' => '商品ID',
            'num' => '购买数量',
            'status' => '订单状态（1-下单成功；2-下单失败）',
            'create_time' => '创建时间',
            'update_time' => '创建时间',
        ];
    }
}
