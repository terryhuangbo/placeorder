<?php

namespace app\modules\team\models;

use Yii;

/**
 * This is the model class for table "vso_point_privilege".
 *
 * @property integer $id
 * @property string $route
 * @property string $desc
 */
class Privilege extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%privilege}}';
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
            [['route', 'desc', 'grouptype'], 'required'],
            [['desc'], 'string'],
            [['route'], 'unique'],
            [['route'], 'string', 'max' => 35]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'route' => '路由地址',
            'grouptype' => '权限分组',
            'desc' => '路由名称',
        ];
    }

    /**
     * 获取权限路由列表
     * @return array
     */
    public static function getPrilist()
    {
        $pri = Privilege::find()->asArray()->all();
        $privilegeGroup = PrivilegeGroup::privilegeGrouplist();
        $newpri = array();
        foreach ($pri as $key => $item)
        {
            $item['groupname'] = $privilegeGroup[$item['grouptype']];
            $newpri[$item['grouptype']][$item['id']] = $item['desc'];
        }
        return $newpri;
    }
}
