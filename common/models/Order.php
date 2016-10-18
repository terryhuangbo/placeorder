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
 * @property integer $gid
 * @property integer $uid
 * @property integer $card_bn
 * @property integer $qq
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
    const STATUS_YES     = 1;//下单成功
    const STATUS_NO      = 2;//下单失败
    const STATUS_REFUND  = 3;//已退款

    /**
     * 场景
     */
    const SCENARIO_USER   = 'user';//用户下单
    const SCENARIO_CARD   = 'card';//卡密下单

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
            ['status', 'in', 'range' => [self::STATUS_YES, self::STATUS_NO, self::STATUS_REFUND], 'message' => '订单状态错误'],
            ['status', 'filter', 'filter' => 'intval'],
            //用户ID
            ['uid', 'required', 'message' => '用户ID必须存在', 'on' => self::SCENARIO_USER],
            ['uid', 'exist', 'targetAttribute' => 'uid', 'targetClass' => User::className(), 'message' => '用户不存在', 'on' => self::SCENARIO_USER],
            //卡密
            ['card_bn', 'required', 'message' => '用户ID必须存在', 'on' => self::SCENARIO_USER],
            ['card_bn', 'exist', 'targetAttribute' => 'card_bn', 'targetClass' => Card::className(), 'message' => '用户不存在', 'on' => self::SCENARIO_CARD],
            //商品ID
            ['gid', 'required', 'message' => '商品ID必须存在'],
            ['gid', 'exist', 'targetAttribute' => 'gid', 'targetClass' => Goods::className(), 'message' => '订单不存在'],
            //qq
            ['qq', 'required', 'message' => 'qq不能为空'],
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
            'gid' => '订单ID',
            'uid' => '用户ID(用户下单)',
            'card_bn' => '卡密（卡密下单）',
            'num' => '购买数量',
            'amount' => '订单金额',
            'status' => '订单状态（1-下单成功；2-下单失败）',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }

    /**
     * 应用场景
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        //注册
        $scenarios[self::SCENARIO_USER] = [
            'gid',
            'uid',
            'qq',
            'num',
        ];
        //登录
        $scenarios[self::SCENARIO_CARD] = [
            'gid',
            'card_bn',
            'qq',
            'num',
        ];

        return $scenarios;
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
     * 关联表-hasOne
     **/
    public function getCard() {
        return $this->hasOne(Card::className(), ['card_bn' => 'card_bn']);
    }

    /**
     * 订单状态
     * @param $status int
     * @return array|boolean
     */
    public static function getOrderStatus($status = null){
        $statusArr = [
            self::STATUS_YES     => '下单成功',
            self::STATUS_NO      => '下单失败',
            self::STATUS_REFUND  => '已退款',
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
        return $mdl->save(false);
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

                //用户下单的情况
                if($this->scenario === self::SCENARIO_USER){
                    //用户账户抵扣
                    if($this->user->points < $this->amount){
                        throw new Exception('用户账户余额不足');
                    }
                    $this->user->points -= $this->amount;
                    $ret = $this->user->save();
                    if($ret['code'] < 0){
                        throw new Exception('用户账户抵扣失败');
                    }
                }
                //卡密下单的情况
                else if($this->scenario === self::SCENARIO_CARD){
                    //卡密余额抵扣
                    if($this->card->points < $this->amount){
                        throw new Exception('用户账户余额不足');
                    }
                    $this->card->points -= $this->amount;
                    $ret = $this->card->save();
                    if($ret['code'] < 0){
                        throw new Exception('用户账户抵扣失败');
                    }
                }

                //商品库存
                if($this->goods->num < $this->num){
                    throw new Exception('商品库存不足');
                }
                $this->goods->num = $this->goods->num - $this->num;
                $ret = $this->goods->save();
                if($ret['code'] < 0){
                    throw new Exception('商品库存更新失败');
                }

            }else{//更新操作
                $dirtyAttr = $this->getDirtyAttributes(['status']);
                //退款操作
                if(!empty($dirtyAttr['status']) && (int) $dirtyAttr['status'] === self::STATUS_REFUND){
                    if(!empty($this->uid)){//退回个人账户
                        $this->user->points += $this->amount;
                        $ret = $this->user->save();
                        if($ret['code'] < 0){
                            throw new Exception('退款用户账号失败');
                        }
                        //生成财务数据
                        $pay = new Pay();
                        $pay->attributes = [
                            'oid' => $this->oid,
                            'cost' => -$this->amount,
                            'balance' => $this->user->points,
                        ];
                        $ret = $pay->save();
                        if($ret['code'] < 0){
                            throw new Exception('生成财务数据失败');
                        }
                    }else if(!empty($this->card_bn)){         //退回卡密
                        $this->card->points += $this->amount;
                        $ret = $this->card->save();
                        if($ret['code'] < 0){
                            throw new Exception('退款卡密账号失败');
                        }
                        //生成财务数据
                        $pay = new Pay();
                        $pay->attributes = [
                            'card_bn' => $this->card_bn,
                            'cost' => -$this->amount,
                            'balance' => $this->card->points,
                        ];
                        $ret = $pay->save();
                        if($ret['code'] < 0){
                            throw new Exception('生成财务数据失败');
                        }
                    }else{
                        throw new Exception('退款状态错误');
                    }
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
            //生成财务数据
            $pay = new Pay();
            $pay->cost = $this->amount;
            //场景-用户下单/卡密下单
            if($this->scenario === self::SCENARIO_USER){
                $pay->uid = $this->uid;
                $pay->balance = $this->user->points;
                $pay->scenario = Pay::SCENARIO_USER;
            }else{
                $pay->card_bn = $this->card_bn;
                $pay->balance = $this->card->points;
                $pay->scenario = Pay::SCENARIO_CARD;
            }
            $ret = $pay->save();
            if($ret['code'] < 0){
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
