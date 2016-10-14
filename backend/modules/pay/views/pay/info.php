<?php
use common\models\Order;
?>
<div id="content" style="display: block" >
    <form id="form" class="form-horizontal">
        <div class="row">

            <div class="control-group ">
                <label class="control-label">订单编号：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $pay['pay_bn'] ?></span>
                </div>
            </div>

            <div class="control-group ">
                <label class="control-label">订单状态：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo Order::getOrderStatus($pay['status']) ?></span>
                </div>
            </div>

            <div class="control-group ">
                <label class="control-label">订单金额：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $pay['num'] * getValue($pay, 'goods.price', 0) ?></span>
                </div>
            </div>

            <div class="control-group ">
                <label class="control-label">商品名称：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo getValue($pay, 'goods.name', '') ?></span>
                </div>
            </div>

            <div class="control-group ">
                <label class="control-label">商品数量：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $pay['num'] ?></span>
                </div>
            </div>

            <div class="control-group ">
                <label class="control-label">商品编号：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo getValue($pay, 'goods.goods_bn', '') ?></span>
                </div>
            </div>

            <div class="control-group ">
                <label class="control-label">商品价格：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo getValue($pay, 'goods.price', 0) ?></span>
                </div>
            </div>

            <div class="control-group ">
                <label class="control-label">创建时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $pay['create_time']?></span>
                </div>
            </div>

        </div>
    </form>
</div>