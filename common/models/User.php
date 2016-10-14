<?php

namespace common\models;

use Yii;
use common\base\BaseModel;
use common\behavior\TimeBehavior;


/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $uid
 * @property string $username
 * @property string $pwd
 * @property integer $qq
 * @property integer $points
 * @property integer $reg_time
 * @property integer $login_time
 * @property integer $update_time
 */
class User extends BaseModel
{
    /**
     * 场景
     */
    const SCENARIO_REG   = 'register';//注册
    const SCENARIO_LOGIN = 'login';   //登录

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
            [['qq', 'points', 'reg_time', 'login_time', 'update_time'], 'integer'],
            [['username', 'pwd'], 'string', 'max' => 50],
            //用户账号必须唯一
            ['username', 'unique', 'message' => '用户账号必须唯一'],
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
            'qq' => 'QQ',
            'points' => '用户余额点数',
            'reg_time' => '注册时间',
            'login_time' => '最近登录时间',
            'update_time' => '更新时间',
        ];
    }

    /**
     * 注册时间，登录时间，更新时间自动更新时间戳
     * @return array
     */
    public function behaviors()
    {
        return [
            'timeStamp' => [
                'class' => TimeBehavior::className(),
                'create' => 'reg_time',
                'update' => 'update_time',
            ],
        ];
    }

    /**
     * 应用场景
     * @return array
     */
    public function scenarios(){

    }


}
