<?php

namespace common\models;

use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%cart}}".
 *
 * @property integer $cart_id
 * @property integer $uid
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cart}}';
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
            [['uid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cart_id' => '购物车ID',
            'uid' => '用户ID',
        ];
    }

    /**
     * 添加记录-返回新插入的自增id
     **/
    public function _add($data) {
        if (!empty($data) && !empty($data['uid'])) {
            try {
                $_mdl = new self;

                foreach ($data as $k => $v) {
                    $_mdl->$k = $v;
                }
                $ret = $_mdl->insert();
                if ($ret !== false) {
                    return self::getDb()->getLastInsertID();
                }
                return false;
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * 保存记录
     * @param $data array
     * @return array|boolean
     */
    public function _save($data)
    {
        if (!empty($data)) {
            $_mdl = new self();

            try {
                foreach ($data as $k => $v) {
                    $_mdl->$k = $v;
                }

                if (!empty($data['cart_id'])) {//修改
                    $id = $data['cart_id'];
                    $ret = $_mdl->updateAll($data, ['cart_id' => $id]);
                } else {//增加
                    $ret = $_mdl->insert();
                }

                if ($ret !== false) {
                    return true;
                }
                return false;
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }




}
