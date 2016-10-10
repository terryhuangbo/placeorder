<?php
namespace common\utils;
use yii\base\Exception;
/**
 * curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); //设置请求方式
 *    
 *  curl_setopt($ch,CURLOPT_HTTPHEADER,array("X-HTTP-Method-Override: $method"));//设置头
 *  // 需返回HTTP headercurl_setopt($ch, CURLOPT_HEADER, 1);
 *  使用post, put, delete等REStful方式访问url
 *
 *  post:   
 *   
 *    curl_setopt($ch, CURLOPT_POST, 1 );   
 *   
 *  put, delete:   
 *   
 *    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");  
 * @author zhmhuang
 *
 */
class LHTCurl
{
    public static function post($url, $data=null)
    {
        $ch = curl_init() ;
        curl_setopt($ch, CURLOPT_URL, $url) ;
        curl_setopt($ch, CURLOPT_POST, 1) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名,http_build_query是为了支持多维数组
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//成功时不返回true，只返回结果
        //不进行ssl验证，为了https调试
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $output=curl_exec($ch);
        self::checkResponse($output, $ch);
        curl_close($ch) ;
        return $output;
    }
    
    public static function get($url)
    {
        $ch = curl_init() ;
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);//成功时不返回true，只返回结果
        //不进行ssl验证，为了https调试
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $output=curl_exec($ch);
        self::checkResponse($output, $ch);
        curl_close($ch) ;
        return $output;
    }

    /**
     * 检查通信结果是否异常
     * @param unknown $result
     * @param unknown $ch
     */
    protected static function checkResponse($result,$ch)
    {
        if(!$result)
        {
            if(curl_errno($ch)){//出错则显示错误信息
                var_dump(curl_error($ch));exit;
                throw new Exception('Curl error');
            }
        }
        else
        {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if(in_array($httpCode, ['404', '403', '502', '503']))
            {
                throw new Exception('Curl error:' . $httpCode);
            }
        }
    } 
}

?>