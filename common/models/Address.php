<?php

namespace common\models;

use Yii;
use yii\console\Exception;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property integer $add_id
 * @property integer $uid
 * @property string $receiver_name
 * @property string $receiver_phone
 * @property integer $province
 * @property integer $city
 * @property integer $county
 * @property string $detail
 * @property integer $receive_time
 * @property integer $type
 * @property integer $is_default
 * @property integer $is_deleted
 * @property integer $create_at
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * 收货时间
     */
    const REC_ALLDAY = 1;//一周七日
    const REC_WORKDAY = 2;//工作日
    const REC_HOLIDAY = 3;//双休及节假
    /**
     * 地址类型
     */
    const ADDR_HOME = 1;//家庭地址
    const ADDR_COMPANY = 2;//公司地址
    const ADDR_OTHER = 3;//其他

    /**
     * 是否默认
     */
    const DEFAULT_NO = 1;//非默认
    const DEFAULT_YES = 2;//默认
    /**
     * 是否删除
     */
    const NO_DELETE = 1;//未删除、正常
    const IS_DELETE = 2;//删除


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%address}}';
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
            [['uid', 'receive_time', 'type', 'is_default', 'is_deleted', 'create_at'], 'integer'],
            [['detail'], 'required'],
            [['detail'], 'string'],
            [['receiver_name'], 'string', 'max' => 50],
            [['receiver_phone'], 'string', 'max' => 12],
            [['province', 'city', 'county'], 'string', 'max' => 30],
            [['create_at'], 'default', 'value' => time()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'add_id' => '地址ID',
            'uid' => '用户ID',
            'receiver_name' => '收货人姓名',
            'receiver_phone' => '收货人联系方式',
            'province' => '省ID',
            'city' => '市ID',
            'county' => '县ID',
            'detail' => '详细地址',
            'receive_time' => '收货时间（1-一周七日；2-工作日；3-双休及节假）',
            'type' => '地址类型（1-家庭地址；2-公司地址；3-其他）',
            'is_default' => '是否为默认（1-否；2-是）',
            'is_deleted' => '是否已经删除（1-未删除；2-已经删除）',
            'create_at' => '创建时间',
        ];
    }

    /**
     * 关联表-hasMany
     **/
    public function getCheck() {
        return $this->hasOne(Check::className(), ['id' => 'check_id']);
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
    public function _get_list($where = [], $order = '', $page = 1, $limit = 0) {
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

                if (!empty($data['add_id'])) {//修改
                    $id = $data['add_id'];
                    $ret = $_mdl->updateAll($data, ['add_id' => $id]);
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
     * 添加地址
     * @param $param array
     * @return array|boolean
     */
    public function _add_address($param) {
        //收货人姓名校验
        if(empty($param['receiver_name'])){
            return ['code' => -20001, 'msg' => '收货人姓名不能为空'];
        }
        $receiver_name = $param['receiver_name'];
        if(strlen($receiver_name) > 50){
            return ['code' => -20001, 'msg' => '收货人姓名太长'];
        }

        //收货人联系方式校验
        if(empty($param['receiver_phone'])){
            return ['code' => -20002, 'msg' => '收货人手机号不能为空'];
        }
        $receiver_phone = $param['receiver_phone'];
        $pattern = '/^1[3|5|7|8][0-9]{9}$/';
        if(!preg_match($pattern, $receiver_phone)){
            return ['code' => -20002, 'msg' => '手机号格式不正确'];
        }

        //收货地址，省市县
        if($param['province'] == '省份' && $param['city'] == '地级市' && $param['county'] == '市、县级市'){
            return ['code' => -20003, 'msg' => '收货地址不能为空'];
        }

        //详细地址
        if(empty($param['detail'])) {
            return ['code' => -20004, 'msg' => '详细地址不能为空'];
        }

        //检验uid
        if(empty($param['uid'])){
            return ['code' => -20005, 'msg' => 'uid不能为空'];
        }
        $uid = $param['uid'];

        //add_id存在，则为修改
        if(!empty($param['add_id'])){
            $add = (new self())->_get_info(['add_id' => $param['add_id']]);
            if(!$add){
                return ['code' => -20006, 'msg' => '地址不存在'];
            }
        }

        //是否设为默认地址
        if(!in_array(intval($param['is_default']), [self::DEFAULT_YES, self::DEFAULT_NO])){
            return ['code' => -20007, 'msg' => '是否为默认地址状态错误'];
        }
        $param['is_default'] = intval($param['is_default']);

        //地址
        $param['province'] = getValue($param, 'province', '');
        $param['city'] = getValue($param, 'city', '');
        $param['county'] = getValue($param, 'county', '');

        $mdl = new self();
        //开启事务
        $transaction = yii::$app->db->beginTransaction();
        try {

            //如果为默认地址，更新已有的地址为非默认
            if($param['is_default'] == self::DEFAULT_YES){
                $ret = $mdl->updateAll(['is_default' => self::DEFAULT_NO], ['uid' => $uid]);
                if($ret === false){
                    $transaction->rollBack();
                    throw new Exception('默认地址信息更新失败');
                }
            }

            //认证表保存记录
            $res = $mdl->_save($param);
            if(!$res){
                $transaction->rollBack();
                throw new Exception('认证信息保存失败');
            }
            $add_id = self::getDb()->getLastInsertID();

            //执行
            $transaction->commit();
            $_data = [
                'uid' => $uid,
                'add_id' => $add_id,
            ];
            return ['code' => 20000, 'msg' => '保存成功！', 'data' => $_data];

        } catch (Exception $e) {
            $transaction->rollBack();
            return ['code' => -20000, 'msg' => $e->getMessage()];
        }
    }

    /**
     * 地址类型
     * @param $status int
     * @return array|boolean
     */
    public static function _get_address_type_name($status = 1){
        switch(intval($status)){
            case self::ADDR_HOME:
                $_name = '家庭地址';
                break;
            case self::ADDR_COMPANY:
                $_name = '公司地址';
                break;
            case self::ADDR_OTHER:
                $_name = '其他';
                break;
            default:
                $_name = '家庭地址';
                break;
        }
        return $_name;
    }

}
