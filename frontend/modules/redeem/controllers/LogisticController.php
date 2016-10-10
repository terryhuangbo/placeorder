<?php

namespace frontend\modules\redeem\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\base\BaseController;
use common\lib\Http;
use common\api\VsoApi;
use common\models\User;


class LogisticController extends BaseController
{

    public $layout = 'layout';
    public $enableCsrfValidation = false;
    private $_apikey = 'apikey:aa189f2a5edc7813767ca14ca206640b';//物流接口

    /**
     * 生成订单
     * @return type
     */
    public function actionDetail()
    {
        $this->render('detail');
    }

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

}
