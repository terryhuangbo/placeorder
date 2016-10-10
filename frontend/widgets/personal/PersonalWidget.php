<?php
/**
 * Created by PhpStorm.
 * User: Qingwenjie
 * Date: 2015/11/3
 * Time: 17:55
 */
namespace app\widgets\personal;

use yii;
use yii\base\Widget;
use common\models\CommonTalent;
class PersonalWidget extends Widget
{
    public $_temp_file_name;//模版名称
    public $_push_info;
    public $_widget_id;

    public function init()
    {

    }

    public function run()
    {
        if ($this->_temp_file_name == 'module_template_2')
        {
            $data = [
                'rc_sort' => yii::$app->sphinx->rank(),
                '_widget_id' => $this->_widget_id,
            ];
            //头像
            foreach ($data['rc_sort']['rc'] as $key => $item) {
                $data['rc_sort']['rc'][$key]['avatar'] = CommonTalent::getUserAvatar($item['username']);
            }
        }
        else
        {
            $data = ['_push_info' => $this->_push_info, '_widget_id' => $this->_widget_id,];
        }
        return $this->render($this->_temp_file_name, $data);
    }

}