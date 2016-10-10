<?php

namespace common\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "{{%points_config}}".
 *
 * @property integer $id
 * @property string $name
 */
class PointsConfig extends \yii\db\ActiveRecord
{
    /**
     * 积分类型
     */
    const POINTS_CONCERN = 1; //关注
    const POINTS_IDAUTH = 2;  //身份认证
    const POINTS_MOBILEAUTH = 3; //手机认证
    const POINTS_SIGNIN = 4; //每日签到
    const POINTS_WECHAT = 5; //分享微信
    const POINTS_PRAISE = 6; //奖励积分


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%points_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '积分类型表',
            'name' => '积分类别名称',
        ];
    }

    /**
     * 获取信息
     * @param $where array
     * @return array|boolean
     **/
    public function _get_info($where = []) {
        if (empty($where)) {
            return false;
        }

        $obj = self::findOne($where);
        if (!empty($obj)) {
            return $obj->toArray();
        }
        return false;
    }

    /**
     * 获取总列表
     * @return int
     */
    public static function _get_list()
    {
        return self::find()->select(['id', 'name'])->indexBy('id')->asArray(true)->all();
    }

    /**
     * 添加记录-返回新插入的自增id
     **/
    public static function _add($data) {
        if (!empty($data) && !empty($data['username'])) {
            try {
                $_mdl = new self;

                foreach ($data as $k => $v) {
                    $_mdl->$k = $v;
                }
                if(!$_mdl->validate()) {//校验数据
                    return false;
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
    public function _save($data) {
        if (!empty($data)) {
            $_mdl = new self();

            try {
                foreach ($data as $k => $v) {
                    $_mdl->$k = $v;
                }
                if(!$_mdl->validate()) {//校验数据
                    return false;
                }

                if (!empty($data['id'])) {//修改
                    $id = $data['id'];
                    $ret = $_mdl->updateAll($data, ['id' => $id]);
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

    /**
     * 删除记录
     * @param $where array
     * @return array|boolean
     */
    public function _delete($where) {
        if (empty($where)) {
            return false;
        }
        try {
            return (new self)->deleteAll($where);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 获取默认的类型，不可删除
     * @return array
     */
    public static function _get_basics() {
        return [
            self::POINTS_CONCERN,
            self::POINTS_IDAUTH,
            self::POINTS_MOBILEAUTH,
            self::POINTS_PRAISE,
            self::POINTS_SIGNIN,
            self::POINTS_WECHAT,
        ];
    }



}