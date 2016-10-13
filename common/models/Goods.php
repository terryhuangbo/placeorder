<?php

namespace common\models;

use Yii;
use common\base\BaseModel;
use common\base\TimeBehavior;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property integer $gid
 * @property string $name
 * @property string $images
 * @property integer $num
 * @property integer $price
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 */
class Goods extends BaseModel
{
    /**
     * 商品状态
     */
    const STATUS_YES = 1;//启用
    const STATUS_NO  = 2;//禁用

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['num', 'price', 'status', 'create_time', 'update_time'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['images'], 'string', 'max' => 600],
            //商品状态
            ['status', 'in', 'range' => [self::STATUS_YES, self::STATUS_NO], 'message' => '商品状态错误'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => '商品ID',
            'name' => '商品名称',
            'images' => '商品图片',
            'num' => '商品数量',
            'price' => '商品价格',
            'status' => '商品状态（1-启用；2-禁用）',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }

    /**
     * 商品状态
     * @param $status int
     * @return array|boolean
     */
    public static function getGoodsStatus($status = null){
        $statusArr = [
            self::STATUS_YES => '启用',
            self::STATUS_NO  => '禁用',
        ];
        return is_null($status) ? $statusArr : (isset($statusArr[$status]) ? $statusArr[$status] : '');
    }

    /**
     * 添加/更新商品
     * @param $param array
     * @param $scenario string 场景
     * @return array
     * @throw yii\db\Exception
     */
    public function saveGoods($param, $scenario = 'default')
    {
        $mdl = !empty($param['gid']) ? static::findOne(['gid' => $param['gid']]) : new static;
        if (empty($mdl))
        {
            return ['code' => -20001, 'msg' => '参数错误'];
        }

        //设置场景，块复制
        $mdl->scenario = $scenario;
        $mdl->attributes = $param;
        //校验数据
        if (!$mdl->validate())
        {
            $errors = $mdl->getFirstErrors();
            return ['ret' => -20003, 'msg' => current($errors)];
        }
        //保存数据
        if (!$mdl->save(false))
        {
            return ['code' => -20000, 'msg' => '保存失败'];
        }
        return ['code' => 20000, 'msg' => '保存成功'];
    }






}
