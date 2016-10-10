<style>
    /**内容超出 出现滚动条 **/
    .bui-stdmod-body{
        overflow-x : hidden;
        overflow-y : auto;
    }
    .log-detail{
        width: 300px;
    }

    .log-content{
        margin: 40px 0;
    }
</style>
<form class="form-horizontal bui-form bui-form-field-container" id="user_info_form" aria-disabled="false"
      onsubmit="return false;" aria-pressed="false">

    <?php foreach($log_list as $key => $val): ?>

        <div class="log-content">

            <div class="control-group log-detail-conten">
                <label class="control-label">(<?php echo $key + 1 ?>)</label>
                <div class="controls">
                    <span class="input-normal control-text bui-form-field" ><?php echo $val['time'] ?><br><?php echo $val['status'] ?></span>
                </div>
            </div>
        </div>

    <?php endforeach ?>

</form>
