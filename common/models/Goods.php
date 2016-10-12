<?php

namespace common\models;

use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property integer $gid
 * @property string $name
 * @property string $images
 * @property integer $num
 * @property integer $price
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 */
class Goods extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['num', 'price', 'status', 'create_time', 'update_time'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['images'], 'string', 'max' => 600]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => '商品ID',
            'name' => '商品名称',
            'images' => '商品图片',
            'num' => '商品数量',
            'price' => '商品价格',
            'status' => '商品状态（1-启用；2-禁用）',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
