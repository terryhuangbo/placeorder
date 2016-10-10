<?php

namespace common\models;

use Yii;
use yii\db\Exception;
use common\models\User;
use common\models\Points;


/**
 * This is the model class for table "{{%auth}}".
 *
 * @property integer $auth_id
 * @property integer $uid
 * @property string $nick
 * @property string $name
 * @property string $avatar
 * @property integer $mobile
 * @property string $email
 * @property string $name_card
 * @property integer $user_type
 * @property integer $user_type_imgs
 * @property string $wechat_openid
 * @property integer $auth_status
 * @property string $reason
 * @property integer $update_at
 * @property integer $create_at
 */
class Auth extends \yii\db\ActiveRecord
{
    /**
     * 用户类型
     */
    const TYPE_COMMON = 1;//普通用户
    const TYPE_SELLER = 2;//销售
    const TYPE_DESIGNER = 3;//家装设计师

    const CHECK_WAITING = 1;//待审核
    const CHECK_PASS = 2;//审核通过
    const CHECK_UNPASS = 3;//审核不通过

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth}}';
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
            [['uid', 'user_type', 'auth_status', 'create_at', 'update_at'], 'integer'],
            [['mobile'], 'string', 'max' => 11],
            [['nick', 'name'], 'string', 'max' => 30],
            [['avatar', 'name_card'], 'string', 'max' => 250],
            [['email'], 'string', 'max' => 40],
            [['user_type_imgs'], 'string', 'max' => 600],
            [['wechat_openid'], 'string', 'max' => 50],
            [['reason'], 'string'],
            [['create_at', 'update_at'], 'default', 'value' => time()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auth_id' => '认证ID',
            'uid' => '用户ID',
            'nick' => '微信昵称',
            'name' => '真实姓名',
            'avatar' => '微信头像',
            'mobile' => '手机号码',
            'email' => '邮箱',
            'name_card' => '名片',
            'user_type' => '用户类型（1-普通用户；2-销售/门店导购；3-设计师；4-零售经销商；5-项目经销商；6-安装商/安装人员；7尚飞员工）',
            'user_type_imgs' => '用户类型图片',
            'auth_status' => '认证状态（1-待审核；2-审核通过；3-审核不通过）',
            'reason' => '审核不通过的原因',
            'create_at' => '创建时间',
        ];
    }

    /**
     * 获取信息
     * @param $where array
     * @return array|boolean
     **/
    public function _get_info($where = [])
    {
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
    public function _get_list($where = [], $order = 'created_at desc', $page = 1, $limit = 20)
    {
        $_obj = self::find();
        if (isset($where['sql']) || isset($where['params'])) {
            $_obj->where($where['sql'], $where['params']);
        } else if (is_array($where)) {
            $_obj->where($where);
        }

        $_obj->orderBy($order);

        if (!empty($limit)) {
            $offset = max(($page - 1), 0) * $limit;
            $_obj->offset($offset)->limit($limit);
        }
        return $_obj->asArray(true)->all();
    }

    //获取总条数
    public function _get_count($where = [])
    {
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
    public static function _add($data)
    {
        if (!empty($data) && !empty($data['username'])) {
            try {
                $_mdl = new self;

                foreach ($data as $k => $v) {
                    $_mdl->$k = $v;
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
    public function _save($data)
    {
        if (!empty($data)) {
            $_mdl = new self();

            try {
                foreach ($data as $k => $v) {
                    $_mdl->$k = $v;
                }

                if (!empty($data['auth_id'])) {//修改
                    $id = $data['auth_id'];
                    $ret = $_mdl->updateAll($data, ['auth_id' => $id]);
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
    public static function _delete($where)
    {
        if (empty($where)) {
            return false;
        }
        try {
            return (new self)->deleteAll($where);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 用户类型
     * @param $type int
     * @return array|boolean
     */
    public static function _get_user_type($type = 1)
    {
        switch (intval($type)) {
            case self::TYPE_COMMON:
                $_name = '普通用户';
                break;
            case self::TYPE_SELLER:
                $_name = '销售';
                break;
            case self::TYPE_DESIGNER:
                $_name = '家装设计师';
                break;
            default:
                $_name = '销售';
                break;
        }
        return $_name;
    }

    /**
     * 审核状态
     * @param $status int
     * @return array|boolean
     */
    public static function _get_auth_status($status = 1){
        switch(intval($status)){
            case self::CHECK_WAITING:
                $_name = '待审核';
                break;
            case self::CHECK_PASS:
                $_name = '审核通过';
                break;
            case self::CHECK_UNPASS:
                $_name = '审核未通过';
                break;
            default:
                $_name = '待审核';
                break;
        }
        return $_name;
    }

    /**
     * 审核类型列表
     * @return array|boolean
     */
    public static function _get_auth_type_list(){
        return [
            self::CHECK_PASS => '审核通过',
            self::CHECK_UNPASS => '审核未通过',
            self::CHECK_WAITING => '待审核',
        ];
    }

    /**
     * 保存审核状态
     * @param $auth_id int 审核记录id
     * @param $auth_status int 认证记录id
     * @param $reason string 如果审核不通过，则为审核不通过的原因
     * @return array|boolean
     */
    public static function _save_check($auth_id, $auth_status, $reason = '')
    {
        $mdl = new self;
        $mdl_us = new User();
        //检验审核是否存在
        $auth = $mdl->_get_info(['auth_id' => $auth_id]);
        if (!$auth) {
            return ['code' => -20003, 'msg' => '审核信息不存在'];
        }
        $uid = $auth['uid'];
        $user = $mdl_us->_get_info(['uid' => $uid]);
        if (!$user) {
            return ['code' => -20003, 'msg' => '用户信息不存在'];
        }

        //审核通过
        if ($auth_status == $mdl::CHECK_PASS) {

            //开启事务
            $transaction = yii::$app->db->beginTransaction();
            try {
                //保存审核信息
                $rst = $mdl->_save([
                    'auth_id' => $auth_id,
                    'auth_status' => $mdl::CHECK_PASS,
                    'reason' => '',
                    'update_at' => time(),
                ]);
                if (!$rst) {
                    $transaction->rollBack();
                    throw new Exception('用户审核信息保存失败');
                }

                //保存用户信息
                $res = $mdl_us->_save([
                    'uid' => $uid,
                    'nick' => $auth['nick'],
                    'name' => $auth['name'],
                    'avatar' => $auth['avatar'],
                    'name_card' => $auth['name_card'],
                    'user_type_imgs' => $auth['user_type_imgs'],
                    'mobile' => $auth['mobile'],
                    'email' => $auth['email'],
                    'user_type' => $auth['user_type'],
                    'wechat_openid' => $auth['wechat_openid'],
                    'update_at' => time(),
                ]);
                if (!$res) {
                    $transaction->rollBack();
                    throw new Exception('用户信息保存失败');
                }

                //添加积分更新记录
                $ret = Points::_add_points($uid, Points::POINTS_IDAUTH);
                if($ret['code'] < 0){
                    $transaction->rollBack();
                    throw new Exception($ret['msg']);
                }

                //待完成：发送微信通知


                //执行
                $transaction->commit();
                return ['code' => 20000, 'msg' => '用户信息保存成功'];

            } catch (Exception $e) {
                $transaction->rollBack();
                return ['code' => -20000, 'msg' => $e->getMessage()];
            }

        } else {//审核不通过
            if (empty($reason)) {
                return ['code' => -20005, 'msg' => '审核不通过的原因不能为空'];
            }
            if (strlen($reason) > yiiParams('checkdeny_reason_limit')) {
                return ['code' => -20006, 'msg' => '审核不通过的原因超过字数限制'];
            }

            $rst = $mdl->_save([
                'auth_id' => $auth_id,
                'auth_status' => $mdl::CHECK_UNPASS,
                'reason' => $reason,
                'update_at' => time(),
            ]);
            if (!$rst) {
                return ['code' => -20004, 'msg' => '审核信息保存失败'];
            }
            return ['code' => 20000, 'msg' => '用户信息保存成功'];

        }
    }

    /**
     * 新增认证记录
     *@param $param array
     * @return array|boolean
     */
    public static function _add_auth($param){

        //验证真实姓名
        if(empty($param['name'])){
            return ['code' => -20001, 'msg' => '真实姓名不能为空'];
        }
        $name = $param['name'];
        if(!strlen($name) > 10){
            return ['code' => -20001, 'msg' => '真实姓名字数不能超过10个字'];
        }

        //验证手机号
        if(empty($param['mobile'])){
            return ['code' => -20002, 'msg' => '手机号不能为空'];
        }
        $mobile = $param['mobile'];
        $pattern = '/^1[3|5|7|8][0-9]{9}$/';
        if(!preg_match($pattern, $mobile)){
            return ['code' => -20002, 'msg' => '手机号格式不正确'];
        }

        //验证邮箱
        if(empty($param['email'])){
            return ['code' => -20003, 'msg' => '邮箱不能为空'];
        }
        $email = $param['email'];
        $pattern = '/^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}$/';
        if(!preg_match($pattern, $email)){
            return ['code' => -20003, 'msg' => '邮箱格式不正确'];
        }

        //验证uid
        if(empty($param['uid'])){
            return ['code' => -20004, 'msg' => 'uid不能为空'];
        }
        $uid = $param['uid'];
        $user = (new User())->_get_info(['uid' => $uid, 'mobile' => $mobile]);
        $auth = (new self())->_get_info(['uid' => $uid, 'mobile' => $mobile]);
        if(!$user || !$auth){
            return ['code' => -20005, 'msg' => '用户信息或者认证信息不存在'];
        }

        //验证用户类型图片
        if(empty($param['user_type'])){
            return ['code' => -20006, 'msg' => '请选择用户类型'];
        }
        $user_type = $param['user_type'];
        if(empty($param['user_type_imgs'])){
            return ['code' => -20007, 'msg' => '请上传1-3张认证图片'];
        }
        $user_type_imgs = $param['user_type_imgs'];

        $a_mdl = new self();

        //开启事务
        $transaction = yii::$app->db->beginTransaction();
        try {

            //认证表插入记录
            $res_a = $a_mdl->_save([
                'auth_id' => $auth['auth_id'],
                'name' => $name,
                'mobile' => $mobile,
                'email' => $email,
                'user_type' => $user_type,
                'user_type_imgs' => json_encode($user_type_imgs),
            ]);
            if(!$res_a){
                $transaction->rollBack();
                throw new Exception('认证信息保存失败');
            }

            //添加积分更新记录
            $ret = Points::_add_points($uid, Points::POINTS_IDAUTH);
            if($ret['code'] < 0){
                $transaction->rollBack();
                throw new Exception($ret['msg']);
            }

            //执行
            $transaction->commit();

            return ['code' => 20000, 'msg' => '保存成功！', 'data' => ['uid' => $uid]];

        } catch (Exception $e) {
            $transaction->rollBack();
            return ['code' => -20000, 'msg' => $e->getMessage()];
        }

    }
}