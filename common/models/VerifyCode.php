<?php

namespace common\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "{{%verifycode}}".
 *
 * @property integer $id
 * @property string $mobile
 * @property integer $verify_code
 * @property integer $update_at
 */
class VerifyCode extends \yii\db\ActiveRecord
{
    const EXPIRE_TIME = 120;//验证码过期时间

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%verifycode}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'verify_code', 'update_at'], 'integer'],
            [['mobile'], 'string', 'max' => 12],
            [['mobile'], 'unique'],
            [['update_at'], 'default', 'value' => time()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobile' => 'Mobile',
            'verify_code' => 'Verify Code',
            'update_at' => 'Update Time',
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

        if(!empty($order)){
            $_obj->orderBy($order);
        }

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
    public function _add($data) {
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

    /**
     * 保存记录
     * @param $mobile string
     * @param $code int
     * @return boolean
     */
    public function _save_code($mobile, $code){
        if(empty($mobile) || empty($code)){
            return false;
        }
        $mdl = (new self);
        $verify = $mdl->_get_info(['mobile' => $mobile]);
        $_data = [
            'mobile' => $mobile,
            'verify_code' => $code,
            'update_at' => time(),
        ];
        if($verify){
            $_data['id'] = $verify['id'];
        };
        $res = $mdl->_save($_data);
        return $res !== false ? true : false;
    }


}
