<?php

namespace common\api;

use common\utils\LHTCurl;
use yii\helpers\Json;
use yii;

/**
 * vso接口通信类
 * @author zhmhuang
 */
class VsoApi
{
    /**
     * 获取接口用的token
     */
    protected static function getApiToken()
    {
        return yii::$app->params['api_token'];
    }

    /**
     * 获取接口用的appid
     */
    protected static function getApiAppId()
    {
        return yii::$app->params['api_appid'];
    }

    /**
     * 发送请求
     * @param string $url 接口地址
     * @param array $data 参数数据
     * @param string $type 请求方式,默认post
     * @param bool $onlyData 是否只返回data部分数据，true：只返回data，false:返回完整json，默认为true
     * @return bool|array
     */
    public static function send($url, $data = null, $type = "post", $onlyData = true)
    {
        $responseStr = "";
        if (empty($data))
        {
            $data = [];
        }
        $data['appid'] = self::getApiAppId();
        $data['token'] = self::getApiToken();
        if ($type == "post")
        {
            $responseStr = LHTCurl::post($url, http_build_query($data));
        }
        else
        {
            $linkChar = strpos($url, '?') === false ? '?' : '&';
            $url = $url . $linkChar . http_build_query($data);
            $responseStr = LHTCurl::get($url);
        }
        return Json::decode($responseStr);
    }
}

?>