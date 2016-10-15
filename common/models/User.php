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
 * @property integer $gender
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
     * 性别
     */
    const SEX_MALE   = 1;//男
    const SEX_FEMALE = 2;//女

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
            [['qq','gender', 'qq', 'points', 'reg_time', 'login_time', 'update_time'], 'integer'],
            [['username', 'pwd'], 'string', 'max' => 50],
            //用户名，密码，qq都不能为空
            [['username', 'pwd', 'qq'], 'required'],
            //用户账号必须唯一
            ['username', 'unique', 'message' => '用户账号必须唯一'],
            //qq必须唯一
            ['qq', 'unique', 'message' => 'qq必须唯一'],
            //性别
            ['gender', 'in', 'range' => [self::SEX_MALE, self::SEX_FEMALE], 'message' => '性别错误'],
            //密码，进行加密操作
            ['pwd', 'filter', 'filter' => [$this, 'genPwd']],
            //账户余额
            ['points', 'integer', 'min' => 0],
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
            'gender' => '性别（1-男；2-女）',
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
                'create' => ['reg_time', 'login_time'],
                'update' => 'update_time',
            ],
        ];
    }

    /**
     * 应用场景
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        //注册
        $scenarios[self::SCENARIO_REG] = [
            'username',
            'pwd',
            'qq',
            'gender',
        ];
        //登录
        $scenarios[self::SCENARIO_LOGIN] = [
            'username',
            'pwd',
        ];

        return $scenarios;
    }

    /**
     * 添加/更新用户
     * @param $param array
     * @param $scenario string 场景
     * @return array
     * @throw yii\db\Exception
     */
    public function saveUser($param, $scenario = 'default')
    {
        $mdl = isset($param['uid']) ? static::findOne(['uid' => $param['uid']]) : new static;
        if (empty($mdl))
        {
            return ['code' => -20001, 'msg' => '参数错误，或者用户不存在。'];
        }

        //设置场景，块复制
        $mdl->scenario = $scenario;
        $mdl->attributes = $param;
        //校验数据
        if (!$mdl->validate())
        {
            $errors = $mdl->getFirstErrors();
            return ['code' => -20003, 'msg' => current($errors)];
        }
        //保存数据
        return $mdl->save(false);
    }

    /**
     * 生成密码，对原始密码进行加密操作
     * @return string
     */
    public static function genPwd($pwd){
        return md5(sha1($pwd));
    }

}
