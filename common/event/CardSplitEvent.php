<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\event;

use yii\base\Event;

/**
 * 拆卡事件
 *
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2.0
 */
class CardSplitEvent extends Event
{
    /**
     * @var int 拆分数量
     */
    public $num = null;

    /**
     * @var int 卡密面值
     */
    public $each_points = 0;

    /**
     * @var int 密码
     */
    public $pwd = '';

    /**
     * @var string 备注
     */
    public $comment = '';


    /**
     * @var int 事件处理结果代码
     */
    public $code = 0;

    /**
     * @var string 事件处理结果消息
     */
    public $msg = '';



}
