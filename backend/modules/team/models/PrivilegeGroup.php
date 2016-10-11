<?php

namespace app\modules\team\models;

use Yii;

/**
 * This is the model class for table "vso_point_privilege_group".
 *
 * @property integer $id
 * @property string $route
 * @property string $desc
 */
class PrivilegeGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%privilege_group}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groupname', 'grouptype'], 'required'],
            [['groupdesc'], 'string'],
            [['groupname'], 'unique'],
            [['groupname'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'groupname' => '分组名称',
            'grouptype' => '分组属性',
            'groupdesc' => '分组描述',
        ];
    }

    /**
     * 返回权限分组属性
     */
    public static function privilegeGroupArr()
    {
        //角色分组
        return array('1' => '系统内置', '2' => '自定义模块');

    }

    /**
     * 返回分组列表
     */

    public static function privilegeGrouplist()
    {
        $groups = new PrivilegeGroup();
        $groupArr = $groups->find()->orderBy('id desc')->asArray()->all();
        $gArr = array();
        foreach ($groupArr as $key => $group)
        {
            $gArr[$group['id']] = $group['groupname'];
        }
        $gArr[0] = '系统方法'; //内置，不可修改
        return $gArr;
    }
}
