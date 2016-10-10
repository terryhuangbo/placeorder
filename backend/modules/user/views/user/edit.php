<style>
    .save-info{
        text-align: center;
    }
</style>
<form class="form-horizontal bui-form bui-form-field-container" id="user_info_form" aria-disabled="false"
      onsubmit="return false;" aria-pressed="false">
    <input name="uid" v-role="proj-id" type="hidden" class="bui-form-field" aria-disabled="false"
           value="<?php echo $user['uid'] ?>" style="display: none;">

    <div class="control-group">
        <label class="control-label">手机号码：</label>
        <div class="controls">
            <input name="mobile" class="input-normal control-text bui-form-field" data-rules="{required:true}"
                   type="text" v-role="proj-name" aria-disabled="false" value="<?php echo $user['mobile'] ?>">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">电子邮箱：</label>
        <div class="controls">
            <input name="email" class="input-normal control-text bui-form-field" data-rules="{required:true}"
                   type="text" v-role="proj-name" aria-disabled="false" value="<?php echo $user['email'] ?>">
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
        $._ajax('/user/user/ajax-save', param, 'POST', 'JSON', function(json){
            if(json.code > 0){
                BUI.Message.Alert(json.msg, function(){
                    window.location.href = '<?php echo yiiUrl('user/user/list') ?>';
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