<?php
/**
 * Created by PhpStorm.
 * User: Qingwenjie
 * Date: 2016/2/29
 * Time: 19:13
 */

namespace common\lib;

use common\api\VsoApi;
use common\lib\Redis;
use common\utils\LHTCurl;
use common\utils\AESencrypt;
use yii;

class Tools {
    //获取用户登录信息
    public function _get_user_info() {

        $uid = $username = $token = '';

        if (!empty($_COOKIE['vso_uid'])) {
            $uid = $_COOKIE['vso_uid'];
        }

        if (!empty($_COOKIE['vso_uname'])) {
            $username = $_COOKIE['vso_uname'];
        }

        if (!empty($_COOKIE['vso_token'])) {
            $token = $_COOKIE['vso_token'];
        }

        if (!empty($uid) && !empty($username) && !empty($token)) {
            $appid = yii::$app->params['api_appid'];
            $appkey = yii::$app->params['api_token'];
            $_user_login_info = [
                'username' => $username,
                'vso_token' => $token,
                'appid' => $appid,
                'token' => md5($appid . $appkey)
            ];
            $_check_user = (new Http())->_post(yii::$app->params['user_login_status_api'], $_user_login_info);

            if (!empty($_check_user)) {
                $_check_ret = json_decode($_check_user, true);

                if (empty($_check_ret['ret']) || $_check_ret['ret'] !== 13000) {
                    return false;
                }
                return [
                    'uid' => $uid,
                    'username' => $_user_login_info['username'],
                ];
            }
        }
        return [];
    }

    static function _get_ip() {
        $ip_address = '0.0.0.0';
        if (!empty($_SERVER['HTTP_CDN_SRC_IP'])) {
            $ip_address = $_SERVER['HTTP_CDN_SRC_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['REMOTE_ADDR']) AND isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        if ($ip_address === 'Unknown') {
            $ip_address = '0.0.0.0';
            return $ip_address;
        }
        if (strpos($ip_address, ',') !== 'Unknown') {
            $x = explode(',', $ip_address);
            $ip_address = trim(end($x));
        }
        return $ip_address;
    }

    //转JSON
    public static function _to_json($data) {
        return json_encode($data);
    }

    //转数组
    public static function _to_array($json) {
        if (empty($json)) {
            return [];
        }
        return json_decode($json, true);
    }

    /*
     * 发送站内信
     */
    public static function _send_msg($to_user, $title, $content) {
        //发送站内消息,目前直接写消息,待优化消息接口,直接调用模板
        $data = [
            'to_username' => $to_user,
            'title' => $title,
            'content' => $content,
        ];
        return VsoApi::send(yii::$app->params['apiMessageSendUrl'], $data, "post");
    }

    /**
     * 用户资金收入
     * 从 “冻结人民币帐号” 往 "用户"
     * 人民币、创意币 操作接口
     * 调用uc的支付接口
     * @param $user_info //用户信息，必须包含 username
     * @param $cash //人民币
     * @param $credit //创意币
     * @param $action //财务业务类型
     * @param $source ,
     * @param $obj_type 交易类型 service, task ,onlinechage
     * @param $obj_id 交易对象明细，例如商品编号，任务编号
     * @param $finance_source //资金池  冻结人民币账号 人民币营收账号  默认人民币渠道账号
     * @param null $profit 利润
     * @param null $charge
     * @param null $order_id 订单编号
     * @param null $fina_mem 财务备注信息
     * @return bool  //结果处理，如果成功 code = 0,message = success,result = true
     *
     * 外部调用示例
     * Tools::cash_in(['username'=>'86991653','credit'=>395180,'balance'=>952711], 9, 0, 'buy_service', '', 'buy_service',  time(),"冻结人民币账号",'','',100995,'shop pay test');
     */
    public static function cash_in($user_info, $cash, $credit, $action, $source, $obj_type, $obj_id, $finance_source = '冻结人民币账号', $profit = null, $charge = null, $order_id = null, $fina_mem = null) {
        try {
            $encrypt_obj = new AESencrypt();
            $CASH_IN_SALT = yii::$app->params['CASH_IN_SALT'];//'!#%&(';
            $url = yii::$app->params['uc_cash_in_api_url'];//'https://account.vsochina.com/api/finance/cash_in';
            $post = array();
            $username = $user_info['username'];
            $post['check_unique_key'] = $unique_id = md5(json_encode([$finance_source, $username, $cash, $credit, $action, $source, $obj_type, $obj_id, $profit, $charge, $order_id, $fina_mem]));
            $post['finance_source'] = $finance_source;
            $post['username'] = $username;
            $post['cash'] = $cash; //人民币
            $post['credit'] = $credit; //创意币
            $post['action'] = $action; //财务业务类型
            $post['profit'] = $profit;
            $post['obj_type'] = $obj_type; //目标类型
            $post['obj_id'] = $obj_id;
            $post['fina_mem'] = $fina_mem;
            $post['unique_id'] = time() . rand(1000, 2000);
            $post['source'] = $source;
            $post['charge'] = $charge !== null ? floatval($charge) : null;
            $post['order_id'] = $order_id;
            $post['token_code'] = md5($username . 'v-s-o' . $CASH_IN_SALT . $post['credit'] . $post['cash']);
            $post['encrypt_code'] = $encrypt_obj->_encrypt($action . "-" . $obj_type . "-" . $post['unique_id'] . "-" . $credit . "-" . $post['cash']);
            $result = LHTCurl::post($url, $post);
            $result_obj = json_decode($result, true);
            if (!$result_obj['code']) {
                return true;
            } else {
                //放入队列，重新处理
                return false;
            }
        } catch (yii\base\Exception $e) {
            //放入队列，重新处理
            return false;
        }
    }

    /**
     * 用户支出
     * 从  "用户" 往  “冻结人民币帐号”
     * 调用uc的支付接口
     * @param $user_info //用户信息，必须包含 username，
     * @param $cash //人民币
     * @param $credit //创意币
     * @param $action //财务业务类型
     * @param $source ,
     * @param $obj_type 交易类型 buy_service, task ,onlinechage
     * @param $obj_id 交易对象明细，例如商品编号，任务编号
     * @param $finance_target //资金池  冻结人民币账号 人民币营收账号  默认人民币渠道账号
     * @param null $profit 利润
     * @param null $charge
     * @param null $order_id 订单编号
     * @param null $fina_mem 财务备注信息
     * @return bool
     *
     * 外部调用示例
     *Tools::cash_out(['username' => '86991653', 'credit' => 395180, 'balance' => 952711], 9, 0, 'buy_service', '', 'buy_service', time(), "冻结人民币账号", '', '', 100995, 'shop pay test');
     */
    public static function cash_out($user_info, $cash, $credit, $action, $source, $obj_type, $obj_id, $finance_target = '冻结人民币账号', $profit = null, $charge = null, $order_id = null, $fina_mem = '商城交易') {
        try {
            $encrypt_obj = new AESencrypt();
            $CASH_OUT_SALT = yii::$app->params['CASH_OUT_SALT'];//'!#%&(';
            $url = yii::$app->params['uc_cash_out_api_url'];//'https://account.vsochina.com/api/finance/cash_in';
            $post = array();
            $username = $user_info['username'];
            $post['check_unique_key'] = $unique_id = md5(json_encode([$finance_target, $username, $cash, $credit, $action, $source, $obj_type, $obj_id, $profit, $charge, $order_id, $fina_mem]));
            $post['finance_target'] = $finance_target;
            $post['username'] = $username;
            $post['cash'] = $cash; //人民币
            $post['credit'] = $credit; //创意币
            $post['action'] = $action; //财务业务类型
            $post['profit'] = $profit;
            $post['obj_type'] = $obj_type; //目标类型
            $post['obj_id'] = $obj_id;
            $post['fina_mem'] = $fina_mem;
            $post['unique_id'] = time() . rand(1000, 2000);
            // $post['source'] = $source;
            $post['charge'] = $charge !== null ? floatval($charge) : null;
            $post['order_id'] = $order_id;
            $post['token_code'] = md5($username . 'v-s-o' . $CASH_OUT_SALT . $post['credit'] . $post['cash']);
            $post['encrypt_code'] = $encrypt_obj->_encrypt($action . "-" . $obj_type . "-" . $post['unique_id'] . "-" . $credit . "-" . $post['cash']);
            $result = LHTCurl::post($url, $post);
            $result_obj = json_decode($result, true);
            //结果处理，如果成功 code = 0,message = success,result = true
            if (!$result_obj['code']) {
                return true;
            } else {
                //放入队列，重新处理
                return false;
            }
        } catch (Exception $e) {
            //放入队列，重新处理
            return false;
        }
    }

    //下载文件
    function download_file($file_url) {
        $file_url = iconv('utf-8', 'gb2312', $file_url);
        //将编码转为支持中英文的gb2312编码
        if (!isset($file_url) || trim($file_url) == '') {
            return '500';
        }
        $file_size = strlen(file_get_contents($file_url));
        $file_name = basename($file_url);
        //输入文件标签
        header("Content-type: application/octet-stream");
        header("Accept-Ranges: bytes");
        header("Accept-Length: " . $file_size);
        header("Content-Disposition: attachment; filename=" . $file_name);
        $file_type = fopen($file_url, 'r'); //打开文件
        //输出文件内容
        $buffer = 1024;   //定义1KB的缓存空间
        $file_count = 0;  //计数器,计算发送了多少数据
        while (!feof($file_type) && ($file_size > $file_count)) {
            //如果文件还没读到结尾，且还有数据没有发送
            $senddata = fread($file_type, $buffer);
            //读取文件内容到缓存区
            $file_count += $senddata;
            echo $senddata;
        }
        fclose($file_type);
    }

    /**
     * 获取用户认证的手机号
     * @return string
     */
    public function _get_user_tel($username) {
        if (empty($username)) {
            return false;
        }
        $result = VsoApi::send(yii::$app->params['getUserAuthMobileUrl'], ['username' => $username], 'get');
        if (!empty($result['data'])) {
            $user_mobile_info = $result['data'];
        } else {
            return '';
        }
        return isset($user_mobile_info['mobile']) ? $user_mobile_info['mobile'] : '';
    }

    //修改文件代理地址前缀
    public static function _change_proxy_path($path) {
        $_preg_arr = [
            'http://static.vsochina.com' => rtrim(yiiParams('shop_index_url'), '/') . yiiParams('http_proxy')['static.vsochina.com'],
            'http://www.vsochina.com' => 'https://www.vsochina.com',
        ];
        $_source_path = array_keys($_preg_arr);//搜索字符串
        $_change_path = array_values($_preg_arr);//最终替换字符转

        if (is_array($path)) {
            foreach ($path as $k => $val) {
                $_new_data[$k] = str_replace($_source_path, $_change_path, $val);
            }
        } else {
            $_new_data = str_replace($_source_path, $_change_path, $path);
        }
        return $_new_data;
    }

    //媒体中心修改临时文件夹名称前缀
    public static function _change_tmp_dir_path($path, $_dirname, $_new_dirname) {
        $_preg_arr = [
            $_dirname => $_new_dirname,
        ];
        $_source_path = array_keys($_preg_arr);//搜索字符串
        $_change_path = array_values($_preg_arr);//最终替换字符转

        if (is_array($path)) {
            foreach ($path as $k => $val) {
                $_new_data[$k] = str_replace($_source_path, $_change_path, $val);
            }
        } else {
            $_new_data = str_replace($_source_path, $_change_path, $path);
        }
        return $_new_data;
    }

    /**
     * 获取用户详情
     * @param string $username
     * @return array|bool
     */
    public function _get_user($username) {
        if(empty($username)){
            return false;
        }
        $redis = new Redis();
        $info  = $redis->_get('USER_DETAIL' . $username);
        if($info){
            return $info;
        }
        $data['username'] = $username;
        $rst = VsoApi::send(yiiParams('user_detail'), $data, 'get');
        if (!isset($rst['data']) || empty($rst['data'])){
            return false;
        }
        $info = $rst['data'];
        //获取用户头像，覆盖已有的
        $info['avatar'] = $this->_get_avatar($info['uid']);
        $redis->_set('USER_DETAIL' . $username, $info);
        return $info;

    }

    /**
     * 获取用户头像
     * @param $uid int
     * @param $size string 尺寸大小
     * @return array|bool
     */
    public function _get_avatar($uid, $size='small') {
        if(empty($uid)){
            return false;
        }
        // 头像尺寸
        $sizeArr = ['middle', 'small', 'org'];
        if (in_array($size, $sizeArr))
        {
            $size = 'small';
        }
        $uid = sprintf("%09d", $uid);
        $dir1 = substr($uid, 0, 3);
        $dir2 = substr($uid, 3, 2);
        $dir3 = substr($uid, 5, 2);
        $dir = $dir1 . '/' . $dir2 . '/' . $dir3 . '/' . substr($uid, -2);
        $fpath = $dir . "_avatar_{$size}.jpg";

        // 头像log文件地址
        $log_file = yii::$app->params['avatar_path'] . "{$dir}_avatar.txt";

        if (@fopen($log_file, 'r')) {
            $log_info = file_get_contents($log_file);
            $info = explode("|", $log_info);
            switch ($info[0]) {
                case "sys": // 系统默认头像
                    $avatar = "system/" . $info[1] . "_" . $size . ".jpg";
                    break;
                case "cus":
                    $avatar = $fpath;
                    break;
            }
        } else {
            $avatar = "default/man_" . $size . ".jpg";
        }
        return yii::$app->params['avatar_path'] . $avatar;
    }

}
