<?php
/**
 * Created by PhpStorm.
 * User: Huangbo
 * Date: 2015/12/15
 * Time: 16:08
 */
namespace app\widgets\home;

use yii\base\Widget;
class HeaderWidget extends Widget
{
    public $site = array();  //站点信息
    public $action = '';  //站点信息
    public $user_info = array();  //站点信息

    public function init()
    {

    }

    public function run()
    {
        return $this->render('header',['site'=> $this->site, 'action'=> $this->action, 'user_info'=>$this->user_info]);
    }


}