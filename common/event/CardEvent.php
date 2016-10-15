<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\event;

use yii\base\Event;

/**
 * 卡组，卡密有插入或者更新操作时会触发此操作
 *
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2.0
 */
class CardEvent extends Event
{
    /**
     * @var array The attribute values that had changed and were saved.
     */
    public $changedAttributes;
    /**
     * @var string 用户ID，用于给用户充值
     */
    public $user_id = null;

    /**
     * @var int 充值金额
     */
    public $charge_points = 0;
}
