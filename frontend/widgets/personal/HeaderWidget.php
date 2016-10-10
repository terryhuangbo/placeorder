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
use frontend\modules\enterprise\models\CrmCompany;
use frontend\modules\personal\models\Person;
use frontend\modules\personal\models\PersonalSkin;
class HeaderWidget extends Widget
{
    public $obj_username = "";  // 被访问用户的用户名
    public $is_self = false;    // 被访问用户是否是当前登录用户
    public $user_info=array();  // 被访问用户信息
    public $vso_uname='';  // 当前登录用户
    public $skin_id=1;
    public $work_id=1;
    public $title='';
    public $controller='';

    public function init()
    {
        $this->controller = yii::$app->controller->id;
    }

    public function run()
    {
        $res =  PersonalSkin::findOne(['username'=>$this->obj_username]);
        $per_skin = $res?['pc_id'=>$res->pc_id, 'mobile_id'=>$res->mobile_id]:['pc_id'=>1, 'mobile_id'=>2];
        $my_favors = Person::getFavorList($this->vso_uname);
        $_title=$this->setHeaderTabInfo();
        $data=['per_skin'=>$per_skin,'my_favors'=>$my_favors,'_title'=>$_title];
        return isMobile() ? $this->render('m_header',$data) : $this->render('header',$data);
    }

    /**
     * 浏览器选项卡显示内容
     * @return string
     */
    public function setHeaderTabInfo()
    {
        $_title = " 个人中心 | " . $this->user_info['nickname'];
        if($this->controller=='index'){
            $_title = " 动态 | " . $this->user_info['nickname'];
        }else if($this->controller=='worklist'){
            $_title = " 作品集 | " . $this->user_info['nickname'];
        }else if($this->controller=='record'){
            $_title = " 交易记录 | " . $this->user_info['nickname'];
        }else if($this->controller=='work'){
            $_title = " 个人中心 | " . $this->user_info['nickname'];
        }
        return $_title;
    }
}