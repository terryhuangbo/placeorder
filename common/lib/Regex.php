<?php
namespace common\lib;

use yii;
use yii\validators\Validator;
use yii\base\InvalidConfigException;

/**
 * 数据验证类
 * 验证各种常用的数据，用于扩展Yii2的核心验证类
 * 使用方法和Yii2核心验证器相似
 * 1.用在数据模型model的rules方法里面：
 * ```php
 * ['name', RegexValidator::className(), 'method' => 'lowerchars', 'message' => '名字必须全为小写字母']
 * [
 *    ['name', 'status'],
 *     RegexValidator::className(),
 *    'method' => ['mobile', 'zh'],
 *    'message' => ['手机格式不正确'， '必须为中文']
 * ]
 * ```
 * 2.脱离model独立使用，必须要配置[method]参数:
 * ```php
 * $valid = new RegexValidator([
 *  'method' => ['zh', 'negative'],
 *  'message' => ['必须为汉字', '必须为负数'],
 * )];
 * $valid->validate($value, $error);
 * if($error){
 *    echo $error;
 * }
 * ```
 * 3.直接调用RegexValidator里的各个静态方法进行验证:
 * $value = 'Abc';
 * $ret = RegexValidator::mobile($value);
 * if(!$ret){
 *    echo ...;
 * }
 * @see yii\validators\Validator
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2016-09-07
 */
class Regex extends Validator
{
    /**
     * @var string|array 所要采用的验证方法,可以为string,也可以为如果个方法组成的array
     * 所有的方法必须属于RegexValidator
     */
    public $method = null;
    /**
     * @var array 验证的方法列表
     * 方法必须属于RegexValidator
     */
    private $_methodArray = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->_methodArray = (array)$this->method;
        if(empty($this->_methodArray)){
            throw new InvalidConfigException("Configuration error:no validating method are found!");
        }
        foreach($this->_methodArray  as $method){
            if(!$this->hasMethod($method)){
                throw new InvalidConfigException("Validating method:\"{$method}\" does not exits!");
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        //将错误信息转化为数组，数组元素对应[_methodArray]的验证方法
        $this->message = (array)$this->message;
        foreach($this->_methodArray  as $k => $method){
            $ret = call_user_func([$this, $method], $value);
            if($ret === false){
                $error = isset($this->message[$k]) ? $this->message[$k] : Yii::t('yii', '{attribute} is invalid.');
                $this->addError($model, $attribute, $error);
            }
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        $this->message = (array)$this->message;
        foreach($this->_methodArray as $k => $method){
            $ret = call_user_func([$this, $method], $value);
            if($ret === false){
                $error = isset($this->message[$k]) ? $this->message[$k] : Yii::t('yii', "\"{$value}\" is invalid specified by the validator:". static::className() ."::$method");
                return [$error, []];
            }
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {

    }

    /**
     * 数字
     * @param $data mixed 数字或者字符串
     * @return bool
     **/
    public static function number($data = null)
    {
        $_pattern = "/^[0-9]+$/";
        return self::_regex($_pattern, $data);
    }

    /**
     * 非负整数
     * @param $data mixed 数字或者字符串
     * @return bool
     **/
    public static function unsigned($data = null)
    {
        $_pattern = "/^\d+$/";
        return self::_regex($_pattern, $data);
    }

    /**
     * 正整数
     * @param $data mixed 数字或者字符串
     * @return bool
     **/
    public static function positive($data = null)
    {
        $_pattern = '/^\+?[0-9]*[1-9][0-9]*$/';
        return self::_regex($_pattern, $data);
    }

    /**
     * 负整数
     * @param $data mixed 数字或者字符串
     * @return bool
     **/
    public static function negative($data = null)
    {
        $_pattern = "/^\-[0-9]*[1-9][0-9]*$/";
        return self::_regex($_pattern, $data);
    }

    /**
     * 由26个英文字母组成的字符串
     * @param $data mixed 数字或者字符串
     * @return bool
     **/
    public static function chars($data = null)
    {
        $_pattern = "/^[A-Za-z]+$/";
        return self::_regex($_pattern, $data);
    }

    /**
     * 由26个大写英文字母组成的字符串
     * @param $data mixed 数字或者字符串
     * @return bool
     **/
    public static function uperchars($data = null)
    {
        $_pattern = "/^[A-Z]+$/";
        return self::_regex($_pattern, $data);
    }

    /**
     * 由26个小写写英文字母组成的字符串
     * @param $data mixed 数字或者字符串
     * @return bool
     **/
    public static function lowerchars($data = null)
    {
        $_pattern = "/^[a-z]+$/";
        return self::_regex($_pattern, $data);
    }

    /**
     * 由数字和26个英文字母组成的字符串
     * @param $data mixed 数字或者字符串
     * @return bool
     **/
    public static function numschars($data = null)
    {
        $_pattern = "/^[A-Za-z0-9]+$/";
        return self::_regex($_pattern, $data);
    }

    /**
     * 手机号码
     * @param $data mixed 数字或者字符串
     * @return bool
     **/
    public static function mobile($data = null)
    {
        $_pattern = "/^(0|86|17951)?(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/";
        return self::_regex($_pattern, $data);
    }

    /**
     * Email
     * @param $data mixed 数字或者字符串
     * @return bool
     **/
    public static function email($data = null)
    {
        $_res = filter_var($data, FILTER_VALIDATE_EMAIL);
        return empty($_res) ? false : true;
    }

    /**
     * 邮编
     * @param $data mixed 数字或者字符串
     * @return bool
     **/
    public static function postcode($data = null)
    {
        $_pattern = "/^[1-9]\d{5}(?!\d)$/";
        return self::_regex($_pattern, $data);
    }

    /**
     * 中文
     * @param $data mixed 数字或者字符串
     * @return bool
     **/
    public static function zh($data = null)
    {
        $_pattern = "/^[\x{4e00}-\x{9fa5}]+$/u";
        return self::_regex($_pattern, $data);
    }

    /**
     * URL地址
     * @param $data mixed 数字或者字符串
     * @return bool
     **/
    public static function url($data = null)
    {
        $_res = filter_var($data, FILTER_VALIDATE_URL);
        return empty($_res) ? false : true;
    }

    /**
     * 身份证
     * @param $data mixed 数字或者字符串
     * @return bool
     **/
    public static function identity($data = null)
    {
        $_pattern = "/^(^\d{15}$)|(^\d{17}([0-9]|X)$)$/";
        return self::_regex($_pattern, $data);
    }

    /**
     * IPv4
     * @param $data mixed 数字或者字符串
     * @return bool
     **/
    public static function ip($data = null)
    {
        $_res = filter_var($data, FILTER_VALIDATE_IP);
        return empty($_res) ? false : true;
    }

    /**
     * 匹配正则公共方法
     * @param $pattern string 匹配模式
     * @param $subject string 对象
     * @return bool
     */
    private static function _regex($pattern, $subject = null)
    {
        if ($subject === null)
        {
            return false;
        }
        if (preg_match($pattern, $subject))
        {
            return true;
        }
        return false;
    }

}