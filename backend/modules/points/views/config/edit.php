
<style>
    .avatar_content{
        height: 120px;
        width: 140px;
        display: block;
        margin-bottom: 20px;
    }
    .avatar_img{
        height: auto;
        width: 100px;
        margin: 0 auto 80px 120px;
    }
    .save-info{
        margin: 50px 0 10px 0px;
        text-align: center;
        display: block;
    }


</style>
<form class="form-horizontal bui-form bui-form-field-container" id="user_info_form" aria-disabled="false"
      onsubmit="return false;" aria-pressed="false">
    <input name="configid" v-role="proj-id" type="hidden" class="bui-form-field" aria-disabled="false"
           value="<?php echo $config['id'] ?>" style="display: none;">

    <div class="control-group">
        <label class="control-label">积分类型名称：</label>
        <div class="controls">
            <input name="name" class="input-normal control-text bui-form-field" data-rules="{required:true}"
                   type="text" v-role="proj-name" aria-disabled="false" value="<?php echo $config['name'] ?>">
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
        $._ajax('/points/config/ajax-save', param, 'POST', 'JSON', function(json){
            if(json.code > 0){
                BUI.Message.Alert(json.msg, function(){
                    window.location.href = '<?php echo yiiUrl('points/config/list') ?>';
                }, 'success');

            }else{
                BUI.Message.Alert(json.msg, 'error');
                this.close();
            }
        });
    }

    function cancelInfo(){
        window.location.href = '<?php echo yiiUrl('points/config/list') ?>';
    }

</script>