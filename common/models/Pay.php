<?php

namespace common\models;

use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%pay}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $card_bn
 * @property integer $oid
 * @property integer $cost
 * @property integer $balance
 * @property integer $create_time
 */
class Pay extends BaseModel
{

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
        return '{{%pay}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'oid', 'cost', 'balance', 'create_time'], 'integer'],
            [['card_bn'], 'string'],
            //用户ID
            [
                'uid',
                'exist',
                'targetAttribute' => 'uid',
                'targetClass' => User::className(),
                'message' => '用户不存在',
                'on' => self::SCENARIO_USER
            ],
            //卡密
            [
                'card_bn',
                'exist',
                'targetAttribute' => 'card_bn',
                'targetClass' => Card::className(),
                'message' => '卡密不存在',
                'on' => self::SCENARIO_CARD
            ],
            //订单ID
            [
                'oid',
                'exist',
                'targetAttribute' => 'oid',
                'targetClass' => Order::className(),
                'message' => '订单不存在'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '支付ID',
            'uid' => '用户ID（如果是用户账号下单）',
            'card_bn' => '卡密（如果是卡密下单）',
            'oid' => '订单ID',
            'cost' => '消费金额（点数）',
            'balance' => '剩余金额（点数）',
            'create_time' => '创建时间',
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
    public function getOrder() {
        return $this->hasOne(Order::className(), ['oid' => 'oid']);
    }

    /**
     * 添加/更新订单
     * @param $param array
     * @param $scenario string 场景
     * @return array
     * @throw yii\db\Exception
     */
    public function savePay($param, $scenario = 'default')
    {
        $mdl = isset($param['id']) ? static::findOne(['id' => $param['id']]) : new static;
        if (empty($mdl))
        {
            return ['code' => -20001, 'msg' => '参数错误，或者财务不存在。'];
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


}
