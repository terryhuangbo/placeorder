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
            [['order_bn'], 'string', 'max' => 30]
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
