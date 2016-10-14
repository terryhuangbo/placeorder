<?php

namespace common\models;

use Yii;
use common\base\BaseModel;
use common\lib\Tools;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property integer $gid
 * @property string $goods_bn
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
    const STATUS_UPSHELF  = 1;//上架
    const STATUS_OFFSHELF = 2;//下架
    const STATUS_DELETE   = 3;//删除

    /**
     * 商品编号固定前缀
     */
    public $prefix  = 'BD-V-';
    /**
     * 商品编号后部分位数
     */
    public $len  = 5;



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
            //商品编号
            [['goods_bn'], 'unique', 'message' => '商品编号必须唯一'],
            //商品价格
            ['price', 'required', 'message' => '商品价格不能为空'],
            //商品状态
            ['status', 'in', 'range' => [self::STATUS_UPSHELF, self::STATUS_OFFSHELF, self::STATUS_DELETE], 'message' => '商品状态错误'],
            //商品数量
            ['num', 'required', 'message' => '商品数量不能为空'],
            ['num', 'integer', 'min' => 1, 'tooSmall' => '商品数量不能为0'],
            //商品图片
            ['images', 'required', 'message' => '必须上传商品图片'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => '商品ID',
            'goods_bn' => '商品编号',
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
            self::STATUS_UPSHELF   => '启用',
            self::STATUS_OFFSHELF  => '禁用',
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
        $mdl = isset($param['gid']) ? static::findOne(['gid' => $param['gid']]) : new static;
        if (empty($mdl))
        {
            return ['code' => -20001, 'msg' => '参数错误，或者商品不存在。'];
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
     * 生成商品编号
     * @param bool $insert 是否是插入操作
     * @return array
     * @throw yii\db\Exception
     */
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)){
            if($insert){
                $this->goods_bn = $this->genGoodsBn();
            }
            return true;
        }
        return false;
    }

    /**
     * 生成唯一商品编号，格式为BD-V-XXXXX  XXXXX为大写字母和数字的组合
     * @return string
     */
    protected function genGoodsBn() {
        $rand_bn = $this->prefix . Tools::genUpcharNum($this->len);
        $exist = static::find()->where(['goods_bn' => $rand_bn])->exists();
        if($exist){
            $this->genGoodsBn();
        }
        return $rand_bn;
    }






}
