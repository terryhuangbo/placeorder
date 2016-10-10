<?php
/**
 * Created by PhpStorm.
 * User: Qingwenjie
 * Date: 2016/3/22
 * Time: 10:06
 */

namespace common\lib;

use yii;

class Log extends \yii\db\ActiveRecord {
    /**
     * 写日志
     * @param $msg string 日志内容
     * @param $action_username string 日志操作者用户名，系统默认是system
     * @param $dir_name string 记录日志的路径或是表名
     * @param $type string 记录日志的方式
     * @param $db_link_name string 数据库链接名
     */
    public static function _write($msg = '', $action_username = 'system', $dir_name = 'shop_logs', $type = ['file'], $db_link_name = 'db_maker') {
        if (empty($msg)) {
            return false;
        }

        $ret = [];
        if (is_array($type) && !empty($type)) {
            $_self_mdl = new Log();
            $params = func_get_args();
            foreach ($type as $val) {
                $mdl_name = '_write_' . $val;
                if (method_exists($_self_mdl, $mdl_name)) {
                    $ret[$val] = $_self_mdl->$mdl_name($params);
                }
            }
        }
        return $ret;
    }

    /**
     * 写入文件
     * @param $params array
     * @return int
     */
    private function _write_file($params) {
        $action_username = empty($params[1]) ? 'system' : $params[1];
        $dir_name = empty($params[2]) ? 'shop_logs' : $params[2];

        $_client_ip = Tools::_get_ip();
        $log_str = "[date]" . date('H:i:s') . "-[action_username]{$action_username}-[msg]{$params[0]}-[client_ip]{$_client_ip}\n";
        $log_file_path = yii::$app->basePath . DIRECTORY_SEPARATOR . 'runtime' . DIRECTORY_SEPARATOR . $dir_name . DIRECTORY_SEPARATOR . date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . date('d') . '.log';
        $log_path = dirname($log_file_path);
        if (!is_dir($log_path)) {
            @mkdir($log_path, 0755, true);
            @touch($log_path . DIRECTORY_SEPARATOR . 'index.html');
        }
        return @file_put_contents($log_file_path, $log_str, FILE_APPEND);
    }

    /**
     * 写入db
     * @param $params array
     * @return boolean|int
     */
    private function _write_db($params) {
        $params[4] = empty($params[4]) ? 'db_maker' : $params[4];

        $log_data = [
            'action_username' => empty($params[1]) ? 'system' : $params[1],
            'msg' => empty($params[0]) ? '' : $params[0],
            'client_ip' => Tools::_get_ip(),
            'create_time' => time(),
        ];

        $db_name = '{{%' . (empty($params[2]) ? 'shop_logs' : $params[2]) . '}}';
        return yii::$app->$params[4]->createCommand()->insert($db_name, $log_data)->execute();
    }
}