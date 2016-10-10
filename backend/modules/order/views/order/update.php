<style>
    .save-info-content{
        margin-left: 130px;
        margin-top: 20px;
    }
</style>
<form class="form-horizontal bui-form bui-form-field-container" id="user_info_form" aria-disabled="false"
      onsubmit="return false;" aria-pressed="false">
    <input name="oid" v-role="proj-id" type="hidden" class="bui-form-field" aria-disabled="false"
           value="<?php echo $order['oid'] ?>" style="display: none;">

    <div class="control-group span10">
        <label class="control-label">订单状态：</label>
        <div class="controls" >
            <select name="order[order_status]" id="checkstatus">
                <option value="">请选择</option>
                <?php foreach ($status_list as $key => $name): ?>
                    <option value="<?= $key ?>" <?php echo $order['order_status'] == intval($key) ? 'selected="selected"' : "" ?>><?php echo $name ?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>

    <div class="save-info-content">
        <div class="control-group save-info">
            <div class=" ">
                <input type="submit" class="button button-primary save-info-button" onclick="saveInfo()" value="保存">
                <input type="submit" class="button button-danger save-info-button" onclick="cancelInfo()" value="取消">
            </div>
        </div>
    </div>
</form>

<script>
    function saveInfo(){
        var param = $._get_form_json("#user_info_form");
        $._ajax('/order/order/ajax-save', param, 'POST', 'JSON', function(json){
            if(json.code > 0){
                BUI.Message.Alert(json.msg, function(){
                    window.location.href = '<?php echo yiiUrl('order/order/list') ?>';
                }, 'success');

            }else{
                BUI.Message.Alert(json.msg, 'error');
                this.close();
            }
        });
    }

    function cancelInfo(){
        window.location.href = '<?php echo yiiUrl('order/order/list') ?>';
    }

</script>