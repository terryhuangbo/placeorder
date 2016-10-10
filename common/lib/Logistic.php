<?php
/**
 * Created by PhpStorm.
 * User: Qingwenjie
 * Date: 2016/2/29
 * Time: 19:13
 */

namespace common\lib;

use yii;

class Logistic {
    public $layout = 'layout';
    public $enableCsrfValidation = false;
    private $_apikey = 'apikey:aa189f2a5edc7813767ca14ca206640b';//物流接口

    /**
     * 查询物流公司
     * @para $type 物流公司名称
     * @para $$number 物流编号
     * @return type
     */
    public function express1($type, $number)
    {

        if(empty($type) || empty($number)){
            return false;
        }

        $number = str_replace([" ","　","\t","\n","\r"], '', $number);
        $url = "http://apis.baidu.com/netpopo/express/express1?type={$type}&number={$number}";
        $res = $this->_curl($url);
        return json_decode($res, true);
    }

    /**
     * 查询物流编号
     * @return type
     */
    public function express2()
    {
        $url = 'http://apis.baidu.com/netpopo/express/express2';
        $res = $this->_curl($url);
        return json_decode($res, true);
    }

    /**
     * 查询方法curl
     * @return type
     */
    private function _curl($url){
        $ch = curl_init();
        $header = array($this->_apikey);
        // 添加apikey到header
        curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行HTTP请求
        curl_setopt($ch , CURLOPT_URL , $url);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

}
