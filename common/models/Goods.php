<?php

namespace common\models;

use Yii;
use yii\base\Exception;
use common\lib\Filter;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property integer $gid
 * @property string $goods_id
 * @property string $name
 * @property string $thumb
 * @property string $thumb_list
 * @property string $description
 * @property integer $redeem_pionts
 * @property integer $goods_status
 * @property integer $create_at
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * 商品状态
     */
    const STATUS_UPSHELF = 1;//上架
    const STATUS_OFFSHELF = 2;//下架
    const STATUS_DELETE = 3;//删除

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
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
            [['thumb_list', 'description'], 'string'],
            [['redeem_pionts', 'goods_status', 'create_at'], 'integer'],
            [['goods_id'], 'string', 'max' => 40],
            [['name'], 'string', 'max' => 50],
            [['thumb'], 'string', 'max' => 120],
            [['create_at'], 'default', 'value' => time()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => '商品ID',
            'goods_id' => '商品编号',
            'name' => '商品名称',
            'thumb' => '商品缩略图',
            'thumb_list' => '商品图列表',
            'description' => '商品详情',
            'redeem_pionts' => '兑换积分',
            'goods_status' => '状态（1-上架；2-下架；3-删除）',
            'create_at' => '创建时间',
        ];
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
                if(!$_mdl->validate()) {//校验数据
                    return false;
                }

                if (!empty($data['gid'])) {//修改
                    $id = $data['gid'];
                    $ret = $_mdl->updateAll($data, ['gid' => $id]);
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
     * 添加商品
     * @param $goods array
     * @return array|boolean
     */
    public function _save_goods($goods) {
        //参数校验
        if(empty($goods['name']) || strlen($goods['name']) > 50){
            return ['code' => -20002, 'msg' => '商品名称不符合规范！'];
        }
        if(empty($goods['redeem_pionts']) || $goods['redeem_pionts'] < 0){
            return ['code' => -20003, 'msg' => '兑换积分不正确！'];
        }
        if(empty($goods['description'])){
            return ['code' => -20004, 'msg' => '商品描述不能为空！'];
        }
        if(empty($goods['thumb'])){
            return ['code' => -20005, 'msg' => '请上传商品缩略图'];
        }
        if(empty($goods['thumb_list'])){
            return ['code' => -20006, 'msg' => '请上传商品图片！'];
        }

        $_save_data = [
            'goods_id' => static::_gen_goods_id(),
            'name' => Filter::filters_title($goods['name']),
            'redeem_pionts' => intval($goods['redeem_pionts']),
            'description' => Filter::filters_outcontent($goods['description']),
            'thumb' =>trim($goods['thumb']),
            'thumb_list' => json_encode($goods['thumb_list']),
        ];
        if(isset($goods['gid'])){//更新，否则为添加
            $_save_data['gid'] = $goods['gid'];
        }

        //保存信息
        $res = (new self)->_save($_save_data);
        if(!$res){
            return ['code' => -20000, 'msg' => '商品信息保存失败'];
        }
        return ['code' => 20000, 'msg' => '商品信息保存成功'];

    }

    /**
     * 生成商品id
     * @return sting
     */
    private static function _gen_goods_id(){
        return date('YmdHis', time()) . substr(md5(microtime() . rand(0, 10000)), 0, 5);
    }

    /**
     * 审核状态
     * @param $status int
     * @return array|boolean
     */
    public static function _get_goods_status($status = 1){
        switch(intval($status)){
            case self::STATUS_UPSHELF:
                $_name = '上架';
                break;
            case self::STATUS_OFFSHELF:
                $_name = '下架';
                break;
            case self::STATUS_DELETE:
                $_name = '删除';
                break;
            default:
                $_name = '上架';
                break;
        }
        return $_name;
    }



}
