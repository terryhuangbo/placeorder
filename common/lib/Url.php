<?php
/**
 * Created by PhpStorm.
 * User: Qingwenjie
 * Date: 2016/3/2
 * Time: 17:33
 */

namespace common\lib;


class Url {

    public static function _params($add = [], $del = []) {
        $_url = $_SERVER["REQUEST_URI"];
        $_par = parse_url($_url);
        if (isset($_par['query'])) {
            parse_str($_par['query'], $_query);
        } else {
            $_query = [];
        }
        if (!empty($add)) {
            $_query = array_merge($_query, $add);
        }

        if(!empty($del)){
            foreach ($del as $val) {
                unset($_query[$val]);
            }
        }

        return $_par['path'] . '?' . http_build_query($_query);

    }

    //基于当前url增加参数
    public static function _add_params($params_arr = []) {
        $_url = $_SERVER["REQUEST_URI"];
        $_par = parse_url($_url);
        if (isset($_par['query'])) {
            parse_str($_par['query'], $_query);
        } else {
            $_query = [];
        }
        $_new_query = array_merge($_query, $params_arr);
        return $_par['path'] . '?' . http_build_query($_new_query);
    }

    //基于当前url删除参数
    public static function _del_params($params_str = []) {
        $_url = $_SERVER["REQUEST_URI"];
        $_par = parse_url($_url);
        if (isset($_par['query'])) {
            parse_str($_par['query'], $_query);
        } else {
            $_query = [];
        }
        if (!empty($params_str)) {
            foreach ($params_str as $val) {
                unset($_query[$val]);
            }
        }
        if (!empty($_query)) {
            return $_par['path'] . '?' . http_build_query($_query);
        } else {
            return $_par['path'];
        }
    }
}