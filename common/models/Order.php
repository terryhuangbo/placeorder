<?php

namespace common\models;

use Yii;
use common\base\BaseModel;
use common\lib\Tools;
use yii\db\Exception;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $oid
 * @property string $order_bn
 * @property integer $uid
 * @property integer $gid
 * @property integer $num
 * @property integer $amount
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 */
class Order extends BaseModel
{
    /**
     * 订单状态
     */
    const STATUS_YES = 1;//下单成功
    const STATUS_NO  = 2;//下单失败

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * 订单编号固定前缀
     */
    public $prefix  = 'ORD';

    /**
     * 订单编号后部分位数
     */
    public $len  = 6;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'num', 'status', 'amount', 'create_time', 'update_time'], 'integer'],
            [['order_bn'], 'string', 'max' => 30],
            //订单编号
            [['order_bn'], 'unique', 'message' => '订单编号必须唯一'],
            //订单状态
            ['status', 'in', 'range' => [self::STATUS_YES, self::STATUS_NO], 'message' => '订单状态错误'],
            //用户ID
            ['uid', 'required', 'message' => '用户ID必须存在'],
            ['uid', 'exist', 'targetAttribute' => 'uid', 'targetClass' => User::className(), 'message' => '用户不存在'],
            //商品ID
            ['gid', 'required', 'message' => '商品ID必须存在'],
            ['gid', 'exist', 'targetAttribute' => 'gid', 'targetClass' => Goods::className(), 'message' => '订单不存在'],
            //订单金额
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'oid' => '订单ID',
            'order_bn' => '订单编号',
            'uid' => '用户ID',
            'gid' => '订单ID',
            'num' => '购买数量',
            'amount' => '订单金额',
            'status' => '订单状态（1-下单成功；2-下单失败）',
            'create_time' => '创建时间',
            'update_time' => '创建时间',
        ];
    }

    /**
     * @inheritdoc
     */
    public function transactions() {
        return [
            self::SCENARIO_DEFAULT => self::OP_INSERT | self::OP_UPDATE,
        ];
    }

    /**
     * 关联表-hasOne
     **/
    public function getUser() {
        return $this->hasOne(User::className(), ['uid' => 'uid']);
    }

    /**
     * 关联表-hasOne
     **/
    public function getGoods() {
        return $this->hasOne(Goods::className(), ['gid' => 'gid']);
    }

    /**
     * 订单状态
     * @param $status int
     * @return array|boolean
     */
    public static function getOrderStatus($status = null){
        $statusArr = [
            self::STATUS_YES   => '下单成功',
            self::STATUS_NO    => '下单失败',
        ];
        return is_null($status) ? $statusArr : (isset($statusArr[$status]) ? $statusArr[$status] : '');
    }

    /**
     * 添加/更新订单
     * @param $param array
     * @param $scenario string 场景
     * @return array
     * @throw yii\db\Exception
     */
    public function saveOrder($param, $scenario = 'default')
    {
        $mdl = isset($param['oid']) ? static::findOne(['oid' => $param['oid']]) : new static;
        if (empty($mdl))
        {
            return ['code' => -20001, 'msg' => '参数错误，或者订单不存在。'];
        }

        //设置场景，块复制
        $mdl->scenario = $scenario;
        $mdl->attributes = $param;
        //校验数据
        if (!$mdl->validate())
        {
            $errors = $mdl->getFirstErrors();
            return ['code' => -20003, 'msg' => current($errors)];
        }
        //保存数据
        if (!$mdl->save(false))
        {
            return ['code' => -20000, 'msg' => '保存失败'];
        }
        return ['code' => 20000, 'msg' => '保存成功'];
    }

    /**
     * 生成财务数据
     * @inheritdoc
     */
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)){
            if($insert){
                //订单编号
                $this->order_bn = $this->genOrderBn();
                //订单金额
                $this->amount = $this->num * $this->goods->price;
                if($this->user->points < $this->amount){
                    throw new Exception('用户账户余额不足');
                }
            }
            return true;
        }
        return false;
    }

    /**
     * 生成财务数据
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if($insert){
            //用户账户抵扣
            $this->user->points =  $this->user->points - $this->amount;
            if(!$this->user->save()){
                throw new Exception('用户账户抵扣失败');
            }
            //生成财务数据
            $pay = new Pay();
            $pay->attributes = [
                'uid' => $this->uid,
                'oid' => $this->oid,
                'cost' => $this->amount,
                'balance' => $this->user->points,
            ];
            if(!$pay->save()){
                throw new Exception('生成财务数据失败');
            }
        }else{

        }
    }

    /**
     * 生成唯一订单编号，格式为BD-V-XXXXX  XXXXX为大写字母和数字的组合
     * @return string
     */
    protected function genOrderBn() {
        $rand_bn = $this->prefix . date('YmdHis', time()) . Tools::genUpcharNum($this->len);
        $exist = static::find()->where(['order_bn' => $rand_bn])->exists();
        if($exist){
            $this->genOrderBn();
        }
        return $rand_bn;
    }
}
