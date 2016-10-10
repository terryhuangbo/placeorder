<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\YiiUser;

class UserForm extends Model
{
    public $username;
    public $password;
    public $verifyCode;
    private $_user = false;

    public function rules()
    {
        return [
            [['username', 'password'], 'required', 'message' => '{attribute}不能为空！'],
            ['username', 'string', 'max' => 50, 'tooLong' => '{attribute}长度必需在100以内'],
            ['password', 'string', 'max' => 32, 'tooLong' => '{attribute}长度必需在32以内'],
            ['password', 'validatePassword', 'message' => '用户名或密码不正确！'],
        ];
    }

    /**
     * @
     */
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'verifyCode' => '验证',
        ];
    }

    /**
     * @
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            $username = $this->getUser();
            if (!$username)
            {
                $this->addError($attribute, '用户名或密码不正确');
            }
        }
    }

    /**
     * @根据用户名密码查询用户
     */
    public function getUser()
    {
        if ($this->_user === false)
        {
            $this->_user = YiiUser::find()->where(['username' => $this->username, 'password' => md5($this->password)])->one();
        }
        return $this->_user;
    }


    /**
     * @用户登录
     */
    public function login()
    {
        if ($this->validate())
        {
            return Yii::$app->user->login($this->getUser(), 3600 * 24 * 1);
        }
        else
        {
            return false;
        }
    }
}

?>