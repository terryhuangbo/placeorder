<?php

namespace common\models;

use Yii;
use yii\db\Exception;
use common\models\Address;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $oid
 * @property integer $order_id
 * @property integer $gid
 * @property integer $uid
 * @property string $goods_id
 * @property string $goods_name
 * @property string $points_cost
 * @property integer $order_status
 * @property integer $count
 * @property integer $add_id
 * @property integer $express_type
 * @property integer $express_num
 * @property integer $is_deleted
 * @property integer $update_at
 * @property integer $create_at
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * 商品状态
     */
    const STATUS_PAY        = 1;//待付款
    const STATUS_SEND       = 2;//待发货
    const STATUS_RECEIVE    = 3;//待收货
    const STATUS_DONE       = 4;//已完成
    const STATUS_UNDO       = 5;//已撤销
    const STATUS_COMMENT    = 6;//待评论

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
        return '{{%order}}';
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
            [['gid', 'uid', 'order_status', 'points_cost', 'count', 'add_id', 'is_deleted', 'update_at', 'create_at'], 'integer'],
            [['goods_id'], 'string', 'max' => 40],
            [['express_type'], 'string', 'max' => 20],
            [['express_num'], 'string', 'max' => 30],
            [['goods_name', 'order_id'], 'string', 'max' => 50],
            [['create_at'], 'default', 'value' => time()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'oid' => '订单ID',
            'order_id' => '订单编号',
            'gid' => '商品ID',
            'uid' => '用户ID',
            'goods_id' => '商品编号',
            'goods_name' => '商品名称',
            'points_cost' => '所需积分',
            'order_status' => '订单状态（1-待付款；2-待发货；3-待收货；4-已完成；5-已撤销；6-待评论）',
            'count' => '商品数量',
            'add_id' => '地址ID',
            'express_type' => '物流公司类型',
            'express_name' => '物流编号',
            'is_deleted' => '是否删除(1-未删除；2-已删除)',
            'update_at' => '更新时间',
            'create_at' => '创建时间',
        ];
    }

    /**
     * 关联表-hasMany
     **/
    public function getAddress() {
        return $this->hasOne(Address::className(), ['add_id' => 'add_id']);
    }

    /**
     * 关联表-hasMany
     **/
    public function getGoods() {
        return $this->hasOne(Goods::className(), ['gid' => 'gid']);
    }

    /**
     * 关联表-hasMany
     **/
    public function getUser() {
        return $this->hasOne(User::className(), ['uid' => 'uid']);
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

        $obj = self::find();
        return $obj->where($where)
            ->joinWith('address')
            ->asArray(true)
            ->one();
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

        $_obj->andWhere([self::tableName() . '.is_deleted' => self::NO_DELETE]);
        if(!empty($order)){
            $_obj->orderBy($order);
        }

        if (!empty($limit)) {
            $offset = max(($page - 1), 0) * $limit;
            $_obj->offset($offset)->limit($limit);
        }

        return $_obj->joinWith('address')->joinWith('goods')->asArray(true)->all();
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

        return $_obj->joinWith('address')->joinWith('goods')->asArray(true)->all();
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

                if (!empty($data['oid'])) {//修改
                    $id = $data['oid'];
                    $ret = $_mdl->updateAll($data, ['oid' => $id]);
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
     * 生成商品id
     * @return sting
     */
    private static function _gen_order_id(){
        return date('YmdHis', time()) . substr(md5(microtime() . rand(0, 10000)), 0, 7);
    }

    /**
     * 添加订单
     * @param $gids array
     * @param $uid int
     * @return array|boolean
     */
    public function _add_orders($uid, $gids) {
        //参数验证
        if(empty($uid) ||empty($gids)){
            return ['code' => -20002, 'msg' => '参数不合法'];
        }
        $u_mdl = new User();
        $cg_mdl = new CartGoods();
        $ad_mdl = new Address();
        $r_mdl = new self();

        //积分数是否足够
        $user = $u_mdl->_get_info(['uid' => $uid]);
        $points = $user['points'];
        $total_points = 0;
        $list = $cg_mdl->_get_list_all(['in' , 'id', $gids]);
        if($list){
            foreach($list as $val){
                $total_points += $val['count'] * getValue($val, 'goods.redeem_pionts', 0);
            }
        }
        if($points < $total_points){
            return ['code' => -20003, 'msg' => '您的积分数量不够'];
        }

        //获取默认地址
        $add_id_default = Address::find()->select('add_id')->where(['uid' => $uid, 'is_default' => Address::DEFAULT_YES])->scalar();
        $add_id_al = Address::find()->select('add_id')->where(['uid' => $uid])->scalar();
        $add_id = $add_id_default;
        if(empty($add_id)){
            $add_id = $add_id_default;
        }
        if(empty($add_id)){
            $add_id = $add_id_al;
        }
        if(empty($add_id)){
//            return ['code' => -20004, 'msg' => '您还没有添加地址'];
            $add_id = 0;
        }


        //开启事务
        $transaction = yii::$app->db->beginTransaction();
        try {

            foreach($gids as $key => $cg_id){
                //生成订单
                $good = $cg_mdl->_get_info_all([$cg_mdl::tableName() . '.id' => $cg_id]);
                if(!$good){
                    $transaction->rollBack();
                    throw new Exception('商品信息不存在或者已经下架');
                }
                $cost_points =  $good['count'] * getValue($good, 'goods.redeem_pionts', 0);
                $_data = [
                    'order_id' => $r_mdl::_gen_order_id(),
                    'gid' => $good['gid'],
                    'uid' => $uid,
                    'goods_id' => getValue($good, 'goods.goods_id', ''),
                    'goods_name' => getValue($good, 'goods.name', ''),
                    'count' => $good['count'],
                    'add_id' => $add_id,
                    'points_cost' => $cost_points,
                    'order_status' => self::STATUS_PAY,
                    'update_at' => time(),
                ];
                $ret = $r_mdl->_save($_data);
                if(!$ret){
                    $transaction->rollBack();
                    throw new Exception('生成订单失败');
                }
            }

            //删除购物车相应商品
            $ret = $cg_mdl->_delete(['in', 'id', $gids]);
            if($ret === false){
                $transaction->rollBack();
                throw new Exception('购物车更新失败');
            }

            //执行
            $transaction->commit();

            return ['code' => 20000, 'msg' => '保存成功！', 'data' => ['uid' => $uid]];

        } catch (Exception $e) {
            $transaction->rollBack();
            return ['code' => -20000, 'msg' => $e->getMessage()];
        }
    }

    /**
     * 支付订单
     * @param $uid int
     * @param $oids array
     * @return array|boolean
     */
    public function _pay_orders($uid, $oids) {
        //参数验证
        if(empty($uid) ||empty($oids)){
            return ['code' => -20002, 'msg' => '参数不合法'];
        }
        $u_mdl = new User();
        $p_mdl = new Points();
        $r_mdl = new self();

        //积分数是否足够
        $user = $u_mdl->_get_info(['uid' => $uid]);
        $points = $user['points'];
        $total_points = 0;
        $list = $r_mdl->_get_list(['in' , 'oid', $oids]);
        if($list){
            foreach($list as $val){
                $total_points += $val['points_cost'];
            }
        }
        if($points < $total_points){
            return ['code' => -20003, 'msg' => '您的积分数量不够'];
        }

        //开启事务
        $transaction = yii::$app->db->beginTransaction();
        try {

            foreach($oids as $key => $oid){
                //支付订单，只能是未支付的订单，及其重要
                $ord = $r_mdl->_get_info(['oid' => $oid, 'order_status' => self::STATUS_PAY]);
                if(!$ord){
                    $transaction->rollBack();
                    throw new Exception('订单不存在或者已经支付过了');
                }
                $_data = [
                    'oid' => $ord['oid'],
                    'order_status' => self::STATUS_SEND,
                    'update_at' => time(),
                ];
                $ret = $r_mdl->_save($_data);
                if(!$ret){
                    $transaction->rollBack();
                    throw new Exception('订单状态修改失败');
                }

                //更新积分，生成记录
                $res = $p_mdl->_dec_points($uid, $ord['points_cost']);
                if($res['code'] < 0){
                    $transaction->rollBack();
                    throw new Exception($res['msg']);
                }
            }

            //执行
            $transaction->commit();

            return ['code' => 20000, 'msg' => '保存成功！', 'data' => ['uid' => $uid]];

        } catch (Exception $e) {
            $transaction->rollBack();
            return ['code' => -20000, 'msg' => $e->getMessage()];
        }
    }


    /**
     * 订单状态
     * @param $status int
     * @return array|boolean
     */
    public static function _get_order_status($status = 1){
        switch(intval($status)){
            case self::STATUS_PAY:
                $_name = '待付款';
                break;
            case self::STATUS_SEND:
                $_name = '待发货';
                break;
            case self::STATUS_RECEIVE:
                $_name = '待收货';
                break;
            case self::STATUS_DONE:
                $_name = '已完成';
                break;
            case self::STATUS_UNDO:
                $_name = '已撤销';
                break;
            case self::STATUS_COMMENT:
                $_name = '待评论';
                break;

            default:
                $_name = '';
                break;
        }
        return $_name;
    }

    /**
     * 订单状态列表
     * @return array|boolean
     */
    public static function _get_status_list(){
        $statusArr = [];
        $statusArr[self::STATUS_PAY]     = '待付款';
        $statusArr[self::STATUS_SEND]    = '待发货';
        $statusArr[self::STATUS_RECEIVE] = '待收货';
        $statusArr[self::STATUS_DONE]    = '已完成';
        $statusArr[self::STATUS_UNDO]    = '已撤销';
        $statusArr[self::STATUS_COMMENT] = '待评论';

        return $statusArr;
    }


}
