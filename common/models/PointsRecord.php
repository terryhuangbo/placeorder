<?php

namespace common\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "{{%points_record}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $point_id
 * @property integer $points
 * @property string $points_name
 * @property integer $create_at
 */
class PointsRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%points_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'point_id', 'points', 'create_at'], 'integer'],
            [['points_name'], 'string', 'max' => 50],
            [['create_at'], 'default', 'value' => time()],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => '积分赠送记录ID',
            'uid' => '用户ID',
            'point_id' => '赠送积分ID',
            'points' => '赠送积分数',
            'points_name' => '积分赠送名称',
            'create_at' => '创建时间',
        ];
    }

    /**
     * 获取列表
     * @param $where array
     * @param $order string
     * @return array|boolean
     */
    public function _get_list($where = [], $order = 'created_at desc', $page = 1, $limit = 20) {
        $_obj = self::find();
        if (isset($where['sql']) || isset($where['params'])) {
            $_obj->where($where['sql'], $where['params']);
        } else if (is_array($where)) {
            $_obj->where($where);
        }

        $_obj->orderBy($order);

        if (!empty($limit)) {
            $offset = max(($page - 1), 0) * $limit;
            $_obj->offset($offset)->limit($limit);
        }
        return $_obj->asArray(true)->all();
    }

    /**
     * 获取总条数
     * @param $where array
     * @return int
     */
    public function _get_count($where = []) {
        $_obj = self::find();
        if (isset($where['sql']) || isset($where['params'])) {
            $_obj->where($where['sql'], $where['params']);
        } else {
            $_obj->where($where);
        }
        return intval($_obj->count());
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
        if (!empty($where)) {
            try {
                return (new self)->deleteAll($where);
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }
}
