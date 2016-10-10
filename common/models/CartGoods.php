<?php

namespace common\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "{{%cart_goods}}".
 *
 * @property integer $id
 * @property integer $cart_id
 * @property integer $gid
 * @property integer $uid
 * @property integer $count
 * @property integer $create_at
 */
class CartGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cart_goods}}';
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
            [['cart_id', 'gid',  'uid', 'count', 'create_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '购物车商品ID',
            'cart_id' => '购物车ID',
            'gid' => '商品ID',
            'uid' => '用户ID',
            'count' => '商品数量',
            'create_at' => '创建时间',
        ];
    }

    /**
     * 关联表-hasOne
     **/
    public function getUser() {
        return $this->hasOne(User::className(), ['uid' => 'uid']);
    }

    /**
     * 关联表-hasMany
     **/
    public function getGoods() {
        return $this->hasOne(Goods::className(), ['gid' => 'gid']);
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
     * 获取信息
     * @param $where array
     * @return array|boolean
     **/
    public function _get_info_all($where = []) {
        if (empty($where)) {
            return false;
        }
        $obj = self::find();
        if (!empty($obj)) {
            return $obj->where($where)->joinWith('goods')->asArray(true)->one();
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
     * 获取列表
     * @param $where array
     * @param $order string
     * @return array|boolean
     */
    public function _get_list_all($where = [], $order = '', $page = 1, $limit = 0) {
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
        return $_obj->with('goods')->asArray(true)->all();
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
     * 向购物车添加商品
     * @param $data array
     * @return array|boolean
     */
    public function _add_goods($data)
    {
        $g_mdl = new Goods();
        $c_mdl = new self();
        //uid
        if(empty($data['uid'])){
            return ['code' => -20000, 'msg' => '用户id不能为空'];
        }
        $uid = $data['uid'];
        //gid
        if(empty($data['gid'])){
            return ['code' => -20001, 'msg' => '商品id不能为空'];
        }
        $gid = $data['gid'];
        $goods = $g_mdl->_get_info(['gid' => $gid, 'goods_status' => $g_mdl::STATUS_UPSHELF]);
        if(!$goods){
            return ['code' => -20002, 'msg' => '商品不存在'];
        }
        //count
        if(empty($data['count']) || intval($data['count']) <= 0){
            return ['code' => -20003, 'msg' => '商品数量必须为正'];
        }
        $count = intval($data['count']);

        $cart_id = User::_get_cart($uid);;
        if(!$cart_id){
            return ['code' => -20004, 'msg' => '购物车不存在'];
        }

        $_save_data = [
            'cart_id' => $cart_id,
            'gid' => $gid,
            'uid' => $uid,
            'count' => $count,
            'create_at' => time(),
        ];

        //如果购物车已经有该商品
        $g_c = $c_mdl->_get_info(['gid' => $gid, 'uid' => $uid]);
        $_save_data['id'] = $g_c['id'];
        $_save_data['count'] = $count + $g_c['count'];

        $res = $c_mdl->_save($_save_data);
        if(!$res){
            return ['code' => -20000, 'msg' => '保存失败'];
        }
        return ['code' => 20000, 'msg' => '保存成功'];
    }


}
