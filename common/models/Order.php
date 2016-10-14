<?php

namespace common\models;

use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $oid
 * @property string $order_bn
 * @property integer $gid
 * @property integer $num
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'num', 'status', 'create_time', 'update_time'], 'integer'],
            [['order_bn'], 'string', 'max' => 30],
            //订单状态
            ['status', 'in', 'range' => [self::STATUS_YES, self::STATUS_NO], 'message' => '订单状态错误'],
            //商品ID
            ['gid', 'exist', 'targetAttribute' => 'gid', 'targetClass' => Goods::className(), 'message' => '商品不存在']

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
            'gid' => '商品ID',
            'num' => '购买数量',
            'status' => '订单状态（1-下单成功；2-下单失败）',
            'create_time' => '创建时间',
            'update_time' => '创建时间',
        ];
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
}
