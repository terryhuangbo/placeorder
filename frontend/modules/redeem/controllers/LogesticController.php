<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use app\base\BaseController;
use common\models\Order;
use common\lib\Logistic;


class LogesticController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;
    private $_apikey = 'apikey:aa189f2a5edc7813767ca14ca206640b';//物流接口

    /**
     * 查询物流公司
     * @return type
     */
    public function actionExpress1()
    {
        $type = trim($this->_request('type'));
        $number = trim($this->_request('number'));

        if(empty($type) || empty($number)){
            $this->_json(-20001, '缺少参数');
        }

        $number = str_replace([" ","　","\t","\n","\r"], '', $number);
        $url = "http://apis.baidu.com/netpopo/express/express1?type={$type}&number={$number}";
        $res = $this->_curl($url);

        $this->_json(20000, '成功', json_decode($res));
    }

    /**
     * 查询物流编号
     * @return type
     */
    public function actionExpress2()
    {
        $url = 'http://apis.baidu.com/netpopo/express/express2';
        $res = $this->_curl($url);
        $this->_json(20000, '成功', json_decode($res));
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

    /**
     * 异步获取订单信息
     * @return array
     */
    function actionDetail()
    {
        $oid = intval($this->_request('oid'));

        $mdl = new Order();
        //检验参数是否合法
        if (empty($oid)) {
            $this->_json(-20001, '订单序号oid不能为空');
        }

        //检验订单是否存在
        $order = $mdl->_get_info(['oid' => $oid]);
        if (!$order) {
            $this->_json(-20002, '订单信息不存在');
        }

        $lgt = new Logistic();
        $res = $lgt->express1($order['express_type'], $order['express_num']);
        $type = getValue($res, 'result.type');
        $express = $lgt->exp_detail(strtoupper($type));

        $_data = [
            'log_list' => getValue($res, 'result', []),
            'express' => $express,
        ];
        return $this->render('detail', $_data);
    }

}
