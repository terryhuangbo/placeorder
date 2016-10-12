<?php

namespace common\models;

use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $uid
 * @property string $username
 * @property string $pwd
 * @property integer $qq
 * @property integer $reg_time
 * @property integer $login_time
 * @property integer $update_time
 */
class User extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qq', 'reg_time', 'login_time', 'update_time'], 'integer'],
            [['username', 'pwd'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => '用户id',
            'username' => '用户名',
            'pwd' => '密码',
            'qq' => 'qq',
            'reg_time' => '注册时间',
            'login_time' => '最近登录时间',
            'update_time' => '更新时间',
        ];
    }
}
