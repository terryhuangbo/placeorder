<?php

namespace common\models;

use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%card_group}}".
 *
 * @property integer $id
 * @property string $group_bn
 * @property integer $points
 * @property integer $num
 * @property string $pwd
 * @property integer $status
 * @property string $comment
 * @property integer $create_time
 * @property integer $update_time
 */
class CardGroup extends BaseModel
{
    /**
     * 卡组状态
     */
    const STATUS_YES = 1;//启用
    const STATUS_NO  = 2;//禁用

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%card_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['points', 'num', 'status', 'create_time', 'update_time'], 'integer'],
            [['group_bn'], 'string', 'max' => 21],
            [['pwd'], 'string', 'max' => 50],
            [['comment'], 'string', 'max' => 200],
            [['create_time', 'update_time'], 'default', 'value' => time()],
            //卡组
            [['group_bn'], 'unique', 'message' => '卡组必须唯一'],
            //卡组状态
            ['status', 'in', 'range' => [self::STATUS_YES, self::STATUS_NO], 'message' => '卡组状态错误'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '卡组ID',
            'group_bn' => '卡组编号',
            'points' => '卡密面值',
            'num' => '卡密数量',
            'pwd' => '卡组密码',
            'status' => '卡组状态（1-启用；2-禁用）',
            'comment' => '卡组备注',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
