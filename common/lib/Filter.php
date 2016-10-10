<?php

namespace common\lib;

use Yii;

/**
 * 站点安全-过滤类
 *
 */
class Filter
{
    /**
     * 标题过滤
     * @param $string String
     * @return type
     */
    public static function filters_title($string)
    {
        $string = trim($string);
        $string = str_replace("'", "", $string);
        $string = strip_tags($string);
        $string = stripslashes($string);

        return $string;
    }

    /**
     * 用户名过滤
     * @param $string String
     * @return type
     */
    public static function filters_username($string)
    {
        $length = strlen($string);
        if ($length < 2 || $length > 18) {
            return false;
        }
        for ($n = 0; $n < $length; $n++) {
            $t = ord($string[$n]);
            if ((47 < $t && $t < 58) || (64 < $t && $t < 91) || (96 < $t && $t < 123) || $t == 45 || $t == 95 || $t > 126) {
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * 内容过滤
     * @param $str String
     * @return type
     */
    public static function filters_outcontent($str)
    {
        $str = stripslashes($str);

        $str = preg_replace("/<div[^>]*?>/is", "", $str);
        $str = str_replace("aaaaa", "\r\n", $str);
        $str = str_replace("bbbbb", "\n", $str);
        $str = str_replace("ccccc", "\r", $str);
        $str = str_replace('\"', '"', $str);

        $str = str_replace(array('<HTML', '<BODY', '<INPUT', '<SCRIPT', '<FORM', '<IFRAME'), array('<html', '<body', '<input', '<script', '<form', '<iframe'), $str);
        $str = str_replace(array('<html', '<body', '<input', '<script', '<form', '<iframe', '<textarea', '</textarea>'), array('&lt;html', '&lt;body', '&lt;input', '&lt;script', '&lt;form', '&lt;iframe', '&lt;textarea', '&lt;/textarea&gt;'), $str);

        return $str;
    }

    /**
     * sql关键词转义
     */
    public static function sql_encode($str)
    {
        if (empty($str)) {
            return "";
        }
        $str = trim($str);

        $str = str_replace("_", "\_", $str);
        $str = str_replace("%", "\%", $str);
        $str = str_replace(chr(39), "&#39;", $str);
        $str = str_replace("'", "''", $str);
        $str = str_replace("select", "sel&#101;ct", $str);
        $str = str_replace("join", "jo&#105;n", $str);
        $str = str_replace("union", "un&#105;on", $str);
        $str = str_replace("where", "wh&#101;re", $str);
        $str = str_replace("insert", "ins&#101;rt", $str);
        $str = str_replace("delete", "del&#101;te", $str);
        $str = str_replace("update", "up&#100;ate", $str);
        $str = str_replace("like", "lik&#101;", $str);
        $str = str_replace("drop", "dro&#112;", $str);
        $str = str_replace("create", "cr&#101;ate", $str);
        $str = str_replace("modify", "mod&#105;fy", $str);
        $str = str_replace("rename", "ren&#097;me", $str);
        $str = str_replace("alter", "alt&#101;r", $str);
        $str = str_replace("cast", "ca&#115;", $str);

        return $str;
    }

    /**
     * sql关键词转义
     */
    public static function sql_decode($str)
    {
        if (empty($str)) {
            return "";
        }

        $str = str_replace("&#39;", chr(39), $str);
        $str = str_replace("''", "'", $str);
        $str = str_replace("sel&#101;ct", "select", $str);
        $str = str_replace("jo&#105;n", "join", $str);
        $str = str_replace("un&#105;on", "union", $str);
        $str = str_replace("wh&#101;re", "where", $str);
        $str = str_replace("ins&#101;rt", "insert", $str);
        $str = str_replace("del&#101;te", "delete", $str);
        $str = str_replace("up&#100;ate", "update", $str);
        $str = str_replace("lik&#101;", "like", $str);
        $str = str_replace("dro&#112;", "drop", $str);
        $str = str_replace("cr&#101;ate", "create", $str);
        $str = str_replace("mod&#105;fy", "modify", $str);
        $str = str_replace("ren&#097;me", "rename", $str);
        $str = str_replace("alt&#101;r", "alter", $str);
        $str = str_replace("ca&#115;", "cast", $str);
        return $str;
    }

    /**
     * 敏感词过滤
     */
    public static function censor($string)
    {

        global $dblink, $tablepre;


        $censoraray = $banned = $banwords = array();

        //待完善
        $query = $dblink->query("SELECT * FROM censor WHERE var='censor' ");
        if ($value = $dblink->fetch_array($query)) {
            $censorstr = is_array($value) ? $value['datavalue'] : $value;
        } else {
            $censorstr = '';
        }

        if (strlen(trim($censorstr)) > 0) {  //有值就屏蔽
            $censorarr = explode("\n", $censorstr);//按输入时候的回车分割为数组

            foreach ($censorarr as $censor) {
                $censor = trim($censor);
                if (empty($censor)) continue;
                list($find, $replace) = explode('=', $censor);
                $findword = $find;
                $find = preg_replace("/\\\{(\d+)\\\}/", ".{0,\\1}", preg_quote($find, '/'));//匹配屏蔽语法中的"a{1}s{2}s"
                switch ($replace) {
                    case '{BANNED}':
                        $banwords[] = preg_replace("/\\\{(\d+)\\\}/", "*", preg_quote($findword, '/'));
                        $banned[] = $find;
                        break;
                    default:
                        $censoraray['filter']['find'][] = '/' . $find . '/i';
                        $censoraray['filter']['replace'][] = $replace;
                        break;
                }
            }


            if ($banned) {
                $censoraray['banned'] = '/(' . implode('|', $banned) . ')/i';
                $censoraray['banword'] = implode(', ', $banwords);
            }

            if ($censoraray['banned'] && preg_match($censoraray['banned'], $string)) {
                return $censoraray['banned'];//有敏感词汇不予显示
            } else {
                $string = empty($censoraray['filter']) ? $string :
                    @preg_replace($censoraray['filter']['find'], $censoraray['filter']['replace'], $string);
            }

        }
        return $string;
    }

    /**
     * cookie加密
     */
    public static function set_cookie($var, $value, $life = 0, $prefix = 1)
    {
        global $cookiepre, $cookiedomain, $cookiepath, $timestamp, $_SERVER;

        setcookie(($prefix ? $cookiepre : '') . $var, $value, $life ? $timestamp + $life : 0, $cookiepath, $cookiedomain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
    }

    /**
     * 加密函数
     */
    public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
    {
        $ckey_length = 4;
        //note 随机密钥长度 取值 0-32;
        //note 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
        //note 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
        //note 当此值为 0 时，则不产生随机密钥

        $key = md5($key ? $key : UC_KEY);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if ($operation == 'DECODE') {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }

}

?>