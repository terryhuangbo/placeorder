<?php

namespace common\models;

use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%card}}".
 *
 * @property integer $id
 * @property string $card_bn
 * @property integer $points
 * @property string $pwd
 * @property integer $group_id
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 */
class Card extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%card}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['points', 'group_id', 'status', 'create_time', 'update_time'], 'integer'],
            [['card_bn'], 'string', 'max' => 8],
            [['pwd'], 'string', 'max' => 50],
            [['card_bn'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '卡密ID',
            'card_bn' => '卡密编号',
            'points' => '卡密面值',
            'pwd' => '卡密密码',
            'group_id' => '卡组ID',
            'status' => '卡密状态（1-启用；2-禁用）',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}