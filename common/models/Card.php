<?php

namespace common\models;

use Yii;
use common\base\BaseModel;
use common\lib\Tools;

/**
 * This is the model class for table "{{%card}}".
 *
 * @property integer $id
 * @property string $card_bn
 * @property integer $points
 * @property string $pwd
 * @property integer $group_id
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 */
class Card extends BaseModel
{
    /**
     * 卡密状态
     */
    const STATUS_YES = 1;//启用
    const STATUS_NO  = 2;//禁用

    /**
     * 场景
     */
    const SCENARIO_UPDATE = 'update';  //修改
    const SCENARIO_ADD    = 'add';     //添加

    /**
     * 商品编号固定前缀
     */
    public $prefix  = 'SU_';
    /**
     * 商品编号后部分位数
     */
    public $len  = 18;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%card}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'status', 'create_time', 'update_time'], 'integer'],
            [['card_bn'], 'string', 'max' => 8],
            [['pwd'], 'string', 'max' => 50],
            [['card_bn'], 'unique', 'message' => '卡密必须唯一'],
            //面值
            ['points',  'required', 'message' => '卡密面值不能为空'],
            ['points',  'integer', 'min' => 1, 'tooSmall' => '卡密面值必须大于0', 'on' => self::SCENARIO_ADD],//添加时，面值必须大于0
            ['points',  'integer', 'min' => 0, 'tooSmall' => '卡密面值必须大于等于0', 'on' => self::SCENARIO_UPDATE],
            //卡密状态
            ['status', 'in', 'range' => [self::STATUS_YES, self::STATUS_NO], 'message' => '卡密状态错误'],
            //卡组号必须存在
            ['group_id', 'exist', 'targetAttribute' => 'id', 'targetClass' => CardGroup::className(), 'message' => '卡组号不存在']

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '卡密ID',
            'card_bn' => '卡密编号',
            'points' => '卡密面值',
            'pwd' => '卡密密码',
            'group_id' => '卡组ID',
            'status' => '卡密状态（1-启用；2-禁用）',
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
        //对投稿进行举报
        $scenarios[self::SCENARIO_ADD] = [
            'points',
            'pwd',
            'group_id',
            'status',
        ];
        //对留言进行举报
        $scenarios[self::SCENARIO_UPDATE] = [
            'points',
            'pwd',
            'group_id',
            'status',
        ];

        return $scenarios;
    }

    /**
     * 卡密状态
     * @param $status int
     * @return array|boolean
     */
    public static function getCardStatus($status = null){
        $statusArr = [
            self::STATUS_YES   => '启用',
            self::STATUS_NO    => '禁用',
        ];
        return is_null($status) ? $statusArr : (isset($statusArr[$status]) ? $statusArr[$status] : '');
    }

    /**
     * 添加/更新卡密
     * @param $param array
     * @param $scenario string 场景
     * @return array
     * @throw yii\db\Exception
     */
    public function saveCard($param, $scenario = 'default')
    {
        $mdl = isset($param['id']) ? static::findOne(['id' => $param['id']]) : new static;
        if (empty($mdl))
        {
            return ['code' => -20001, 'msg' => '参数错误，或者卡密不存在。'];
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
     * 生成卡密编号
     * @param bool $insert 是否是插入操作
     * @return array
     * @throw yii\db\Exception
     */
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)){
            if($insert){
                $this->card_bn = $this->genCardBn();
            }
            return true;
        }
        return false;
    }

    /**
     * 生成唯一卡密编号，格式为BD-V-XXXXX  XXXXX为大写字母和数字的组合
     * @return string
     */
    protected function genCardBn() {
        $rand_bn = $this->prefix . Tools::genUpcharNum($this->len);
        $exist = static::find()->where(['card_bn' => $rand_bn])->exists();
        if($exist){
            $this->genCardBn();
        }
        return $rand_bn;
    }
}
