<?php
/**
 * Created by PhpStorm.
 * User: Huangbo
 * Date: 2015/12/15
 * Time: 16:08
 */
namespace app\widgets\personal;

use yii;
use yii\base\Widget;

class FooterWidget extends Widget
{
    public $obj_username = "";  // 被访问用户的用户名
    public $user_info=array();  // 被访问用户信息
    public $vso_uname='';  // 当前登录用户
    public $is_self = false;    // 被访问用户是否是当前登录用户
    public $work_id=1;
    public $title='';

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return isMobile() ? $this->render('m_footer') : $this->render('footer');
    }

}