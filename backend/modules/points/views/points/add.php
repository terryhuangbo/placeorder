
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
<form class="form-horizontal bui-form bui-form-field-container" id="points_form" aria-disabled="false"
      onsubmit="return false;" aria-pressed="false">
    <input name="pid" v-role="proj-id" type="hidden" class="bui-form-field" aria-disabled="false"
           value="" style="display: none;">

    <div class="control-group ">
        <label class="control-label">类型：</label>
        <div class="controls" >
            <select name="type" id="points_type">
                <option value="">请选择</option>
                <?php foreach ($typeList as $key => $val): ?>
                    <option value="<?php echo $val['id'] ?>" >
                        <?php echo $val['name'] ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">积分数量：</label>
        <div class="controls">
            <input name="points" class="input-normal control-text bui-form-field" data-rules="{required:true}"
                   type="text"  aria-disabled="false" value="">
        </div>

    </div>

    <div class="control-group goods-info" style="display: none">
        <label class="control-label">商品编号：</label>
        <div class="controls">
            <input name="goods_id"  class="input-normal control-text bui-form-field" data-rules="{required:true}"
                   type="text"  aria-disabled="true" value="">
        </div>
    </div>

    <div class="control-group goods-info" style="display: none">
        <label class="control-label">商品名称：</label>
        <div class="controls">
            <input name="goods_name_show" disabled="disabled" class="input-normal control-text " data-rules="{required:true}"
                   type="text"  aria-disabled="true" value="">
            <input name ="goods_name" type="hidden" value="">
        </div>
    </div>


    <div class="">
        <div class="control-group save-info">
            <div class="">
                <input type="submit" class="button button-primary save-info-button" onclick="saveInfo()" value="保存">
                <input type="submit" class="button button-danger save-info-button" onclick="cancelInfo()" value="取消">
            </div>
        </div>
    </div>
</form>

<script>
    function saveInfo(){
        var param = $._get_form_json("#points_form");
        $._ajax('/points/points/ajax-save', param, 'POST', 'JSON', function(json){
            if(json.code > 0){
                BUI.Message.Alert(json.msg, function(){
                    window.location.href = '<?php echo yiiUrl('points/points/list') ?>';
                }, 'success');

            }else{
                BUI.Message.Alert(json.msg, 'error');
                this.close();
            }
        });
    }

    function cancelInfo(){
        window.location.href = '<?php echo yiiUrl('points/points/list') ?>';
    }

    $("input[name=goods_id]").on('blur', function(){
        var dom = $(this);
        var goods_id = dom.val();
        if($.trim(goods_id) == ''){
            dom._errorTips('商品编号不能为空！');
            return false;
        }
        dom._waiting(true);
        $._ajax('/points/points/ajax-check-goods', {goods_id: goods_id}, 'POST', 'JSON', function(json){
            if(json.code > 0){
                dom._waiting(false);
                dom._errorTips(false);
                $("input[name=goods_name]").val(json.data.goods_name);
                $("input[name=goods_name_show]").val(json.data.goods_name);
            }else{
                dom._waiting(false);
                dom._errorTips(json.msg);
                $("input[name=goods_name]").val('');
                return false;
            }
        });
    });

    $("#points_type").on('change', function(){
        var val = parseInt($(this).val());
        if(val == 6){
            $('.goods-info').show();
        }else{
            $('.goods-info').hide();
        }
    });

</script>