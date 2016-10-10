<?php
/**
 * Created by PhpStorm.
 * User: Qingwenjie
 * Date: 2015/12/23
 * Time: 16:23
 */
namespace common\lib;

use yii;

class Http extends \yii\db\ActiveRecord {

    //post请求
    public function _post($url, $post_data = [], $header = []) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        if (!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    //get请求
    public function _get($url, $get_data = []) {
        $url = $url . '?' . http_build_query($get_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

}