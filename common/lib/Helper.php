<?php
/**
 * Created by PhpStorm.
 * User: Qingwenjie
 * Date: 2015/12/23
 * Time: 16:23
 */
namespace common\lib;

use yii;

class Helper extends \yii\db\ActiveRecord {

    //截取字符串
    public static function _str_cut($string, $length, $etc = '...') {
        $result = '';
        $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
        $strlen = strlen($string);
        for ($i = 0; (($i < $strlen) && ($length > 0)); $i++) {
            if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0')) {
                if ($length < 1.0) {
                    break;
                }
                $result .= substr($string, $i, $number);
                $length -= 1.0;
                $i += $number - 1;
            } else {
                $result .= substr($string, $i, 1);
                $length -= 0.5;
            }
        }
        $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        if ($i < $strlen) {
            $result .= $etc;
        }
        return $result;
    }

    /**
     * 从图片URL链接获取缩略图URL
     * @param string $url 图片源url链接，如
     * http://static.vsochina.com/data/uploads/resource/batch/12/187718508353a38b698283f.jpg_thumb_600.jpg
     * @param string $src 被替换掉部分，比如尺寸'_600'，如果为空，则在文件格式(比如'.jpg')前追加
     * @param string $rpl 替换的值，比如尺寸'_200'，如果为空，则为删除
     * @param bool $check 检查文件是否存在
     * @return string，如
     * http://static.vsochina.com/data/uploads/resource/batch/12/187718508353a38b698283f.jpg_thumb_200.jpg
     */
    public static function _get_thumb($url, $rpl = '', $src = '', $check = false)
    {
        //如果为空，视为在url后面追加缩略图尺寸信息
        if(empty($src))
        {
            $_img_arr = explode(".", $url);
            $format = "." . end($_img_arr);
            if (empty($rpl)) {
                $_new_format = $format;
            } else {
                $_new_format = $rpl . $format;
            }
            $_new_url =  str_replace($format, $_new_format, $url);
        }
        //如果不为空，视为将url中的尺寸替换为新的尺寸
        else
        {
            $_new_url =  str_replace($src, $rpl, $url);
        }

        //判断文件是否存在,不存在，则返回原始url
        if($check && !@file_get_contents($_new_url)){
            return $url;
        }
        return $_new_url;
    }
}