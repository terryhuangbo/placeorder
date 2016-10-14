<?php

namespace common\models;

use Yii;
use common\lib\Tools;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%card_group}}".
 *
 * @property integer $id
 * @property string $group_bn
 * @property integer $points
 * @property string $pwd
 * @property string $card_num
 * @property integer $status
 * @property string $comment
 * @property integer $create_time
 * @property integer $update_time
 */
class CardGroup extends BaseModel
{
    /**
     * 卡组状态
     */
    const STATUS_YES = 1;//启用
    const STATUS_NO  = 2;//禁用

    /**
     * 商品编号固定前缀
     */
    public $prefix  = 'KMZ_';
    /**
     * 商品编号后部分位数
     */
    public $len  = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%card_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['points', 'card_num','status', 'create_time', 'update_time'], 'integer'],
            [['group_bn'], 'string', 'max' => 21],
            [['pwd'], 'string', 'max' => 50],
            [['comment'], 'string', 'max' => 200],
            //卡组
            [['group_bn'], 'unique', 'message' => '卡组必须唯一'],
            //卡组状态
            ['status', 'in', 'range' => [self::STATUS_YES, self::STATUS_NO], 'message' => '卡组状态错误'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '卡组ID',
            'group_bn' => '卡组编号',
            'points' => '卡密面值',
            'pwd' => '卡组密码',
            'card_num' => '卡密数量',
            'status' => '卡组状态（1-启用；2-禁用）',
            'comment' => '卡组备注',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }



    /**
     * 卡组状态
     * @param $status int
     * @return array|boolean
     */
    public static function getCardGroupStatus($status = null){
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
    public function saveCardGroup($param, $scenario = 'default')
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
            if($insert){//添加卡组
                $this->group_bn = $this->genCardGroupBn();
            }else{//更新卡组

            }
            return true;
        }
        return false;
    }

    /**
     * 生成唯一卡密编号，格式为BD-V-XXXXX  XXXXX为大写字母和数字的组合
     * @return string
     */
    protected function genCardGroupBn() {
        $rand_bn = $this->prefix . Tools::genUpcharNum($this->len);
        $exist = static::find()->where(['group_bn' => $rand_bn])->exists();
        if($exist){
            $this->genCardGroupBn();
        }
        return $rand_bn;
    }
}
