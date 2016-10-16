<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\event;

use yii\base\Event;

/**
 * 卡密充值事件
 *
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2.0
 */
class CardChargeEvent extends Event
{
    /**
     * @var User 待充值的用户
     */
    public $chargedUser = null;

    /**
     * @var int 充值金额
     */
    public $points = 0;

    /**
     * @var int 重置结果代码
     */
    public $code = 0;

    /**
     * @var string 重置结果消息
     */
    public $msg = '';



}
