<?php
/**
 * Created by PhpStorm.
 * User: Huangbo
 * Date: 2016/5/20
 * Time: 14:09
 */

namespace common\lib;

use yii;

class Redis {
    private $_redis     = 'redis';//配置项链接名称
    private $_prefix    = 'VSO_MALL_';//键名前缀
    private $_auto_json = true;//自动转换成json格式

    /**
     * 设置缓存
     * @param $key string
     * @param $data array | string
     * @param $expire int 生存时间(单位s)，如果为0，则永不过期
     * @return bool
     */
    public function _set($key, $data, $expire = 1800) {
        if (!empty($key)) {
            $_save_data = $this->_auto_json ? json_encode($data) : $data;
            if ($expire === 0) {
                $res = yii::$app->{$this->_redis}->setex($this->_prefix . $key, $expire, $_save_data);
            } else {
                $res = yii::$app->{$this->_redis}->set($this->_prefix . $key, $_save_data);
            }
            return $res;
        }
        return false;
    }

    /**
     * 按key获取缓存
     * @param $key string
     * @return array
     */
    public function _get($key) {
        if (empty($key)) {
            return false;
        }
        $data = yii::$app->{$this->_redis}->get($this->_prefix . $key);
        return $this->_auto_json ? json_decode($data, true) : $data;
    }

    /**
     * 删除缓存
     * @param $key string
     * @return array
     */
    public function _del($key) {
        if (!empty($key)) {
            $res = yii::$app->{$this->_redis}->del($this->_prefix . $key);
            if ($res == 1) {
                return true;
            }
        }
        return false;
    }
}