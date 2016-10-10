<?php
namespace common\lib;

/**
 * Created by PhpStorm.
 * User: huangbo
 * Date: 2016/6/15
 * Time: 14:53
 */
class Sms
{
    private $account = 'Sigenx8888_acc';  //账号
    private $pswd = 'snowman@626';  //密码
    private $url = 'http://222.73.117.156/msg/HttpBatchSendSM?'; //短信服务连接
    private $post_data = [];
    private $sessionkey = '';
    private $expire = 60; //过期时间

    //构造方法初始化
    public function __construct()
    {

    }

    public function send($mobile, $msg)
    {
        $this->post_data = [
            'account' => iconv('GB2312', 'GB2312', $this->account),
            'pswd' => iconv('GB2312', 'GB2312', $this->pswd),
            'mobile' => $mobile,
            'msg' => $msg,
            'needstatus' => true,
        ];
        $this->sessionkey = md5($mobile);

        $o = "";
        foreach ($this->post_data as $k => $v) {
            $o .= "$k=" . urlencode($v) . "&";
        }
        $post_data = substr($o, 0, -1);
        $result = $this->curl($this->url, $post_data);
        $data = explode(',', $result);
        if(!isset($data[1])){
            return false;
        }
        //发送成功,保存sessoin
        if(!$data[1] == 0){
            //开启会话并设置过期时间
            session_set_cookie_params($this->expire);
            session_start();
            $_SESSION[$this->sessionkey] = $msg;
        }
        return $data[1];
    }

    //获取地址
    private function curl($url, $post_data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $result = curl_exec($ch);

        return $result;
    }

    //随机生成数字
    public function randnum(){
        srand((double)microtime() * 1000000);//create a random number feed.
        $ychar = "0,1,2,3,4,5,6,7,8,9";
        $list = explode(",", $ychar);
        $code = "";
        for ($i = 0; $i < 6; $i++) {
            $randnum = rand(0, 9);
            $code .= $list[$randnum];
        }
        return $code;
    }


}