<?php
/**
 * Created by PhpStorm.
 * User: Huangbo
 * Date: 2015/12/15
 * Time: 16:08
 */
namespace app\widgets\home;

use yii;
use yii\base\Widget;

class FooterWidget extends Widget
{
    public function init()
    {

    }

    public function run()
    {

        return $this->render('footer');
    }

}