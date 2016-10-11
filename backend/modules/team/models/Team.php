<?php

namespace app\modules\team\models;

use Yii;
use yii\db\ActiveRecord;

class Team extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    //查找username名称是否唯一
    public function ckunique($attribute, $params)
    {
        if (Team::ckuser($this->$attribute, $this->username))
        {
            $this->addError($attribute, '帐号名已经被占用');
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'role_id'], 'required'],
            [['username', 'nickname'], 'string'],
            [['username'], 'unique'],
            [['nickname', 'username', 'email'], 'string', 'max' => 225]
        ];
    }

    /**
     * @编辑时检查role是否重复
     */
    public function ckuser($user)
    {
        $count = static::find()->where(["username" => $user])->count();
        if ($count)
        {
            return true;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'UID',
            'username' => '登录帐号',
            'nickname' => '显示名称',
            'role_id' => '团队分组',
            'password' => '后台密码',
            'email' => '联系邮箱'
        ];
    }
}
