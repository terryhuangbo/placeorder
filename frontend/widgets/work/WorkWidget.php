<?php
/**
 * Created by PhpStorm.
 * User: Qingwenjie
 * Date: 2015/11/3
 * Time: 17:55
 */
namespace app\widgets\work;

use yii\base\Widget;

class WorkWidget extends Widget
{
    public $tmp_name;//模版名称
    public $_info;

    public function init()
    {

    }

    public function run()
    {
        return $this->render($this->tmp_name, ['_info' => $this->_info]);
    }

}