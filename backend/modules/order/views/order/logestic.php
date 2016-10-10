<style>
    .save-info{
        text-align: center;
    }
</style>
<form class="form-horizontal bui-form bui-form-field-container" id="user_info_form" aria-disabled="false"
      onsubmit="return false;" aria-pressed="false">
    <input name="oid" type="hidden" value="<?php echo $order['oid'] ?>" >

    <div class="control-group">
        <label class="control-label">物流公司：</label>
        <div class="controls" >
            <select name="express_type" id="checkstatus">
                <option value="">请选择</option>
                <?php foreach ($exp_array as $key => $name): ?>
                    <option value="<?php echo $key ?>" <?php if($order['express_type'] == $key)echo 'selected="selected"' ?>><?php echo $name ?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">物流单号：</label>
        <div class="controls">
            <input name="express_num" class="input-normal control-text bui-form-field" data-rules="{required:true}"
                   type="text" v-role="proj-name" aria-disabled="false" value="<?php echo $order['express_num'] ?>">
        </div>
    </div>

    <div class="">
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
        $._ajax('/order/order/ajax-save-logestic', param, 'POST', 'JSON', function(json){
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
        window.location.href = '<?php echo yiiUrl('user/user/list') ?>';
    }

</script>