<?php
use yii\helpers\Html;
use common\models\Meta;
$meta = new Meta();
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>内容配置</title>

    <link href="/css/dpl.css" rel="stylesheet">
    <link href="/css/bui.css" rel="stylesheet">
    <link href="/css/page-min.css" rel="stylesheet">
    <script src="/js/jquery.js" type="text/javascript"></script>
    <script src="/js/bui-min.js" type="text/javascript"></script>
    <script src="/js/common.js" type="text/javascript"></script>
    <script src="/js/tools.js" type="text/javascript"></script>
    <script src="/plugins/webuploader/webuploader.js" type="text/javascript"></script>
    <script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.all.js"></script>
    <style>
        .user_avatar {
            width: 120px;
            height: 80px;
            margin: 10px auto;
        }
        .demo-content{
            margin: 40px 60px;
        }

        .webuploader-element-invisible{
            display: none;
        }

        .layout-outer-content{
            padding: 15px;
            margin: 10px 0px 40px 130px;
            width: 300px;
            background-color: #f6f6fb;
            border: 1px solid #c3c3d6;
        }
        .layout-content{
            width: 300px;
            margin: 10px 120px;
        }
        .img-content-li{
            width: 200px;
            height: 150px;
            margin-left: -50px;
        }
        .img-content-li img{
            width: 120px;
            height:90px;
        }
        .img-content-li p{
            padding: 2px 0px;
        }

        .img-delete{
            position: relative;
            top:17px;
            left: 91px;
        }

    </style>
</head>

<body>
<div class="demo-content">
<form id="Config_Form" action="" class="form-horizontal" onsubmit="return false;" >
    <h2>内容配置</h2>

    <div class="control-group">
        <label class="control-label">登录框标题：</label>
        <div class="controls">
            <input name="config[login_title]" type="text" class="input-medium" data-rules="" value="<?echo $login_title ?>">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">登录提示：</label>
        <div class="controls">
            <input name="config[login_notice]" type="text" class="input-medium" data-rules="" value="<?echo $order_notice ?>">
        </div>
    </div>



    <div class="control-group">
        <label class="control-label">平台首页提示：</label>
        <div class="controls">
            <input name="config[home_notice]" type="text" class="input-medium" data-rules="" value="<?echo $home_notice ?>">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">是否启用弹窗：</label>
        <div class="controls">
            是<input name="config[home_model_on]" type="radio" class="input-medium" data-rules="" value="1" checked="<? $home_model_on ==1 ? 'checked' : ''?>">&nbsp;&nbsp;
            否<input name="config[home_model_on]" type="radio" class="input-medium" data-rules="" value="2" checked="<? $home_model_on ==2 ? 'checked' : ''?>">
        </div>

    </div>

    <div class="control-group">
        <label class="control-label">平台弹窗公告内容：</label>
        <div class="controls">
            <input name="config[home_model_notice]" type="text" class="input-medium" data-rules="" value="<?echo $home_model_notice ?>">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">下单页面标题：</label>
        <div class="controls">
            <input name="config[order_title]" type="text" class="input-medium" data-rules="" value="<?echo $order_title ?>">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">下单页面提示：</label>
        <div class="controls">
            <input name="config[order_notice]" type="text" class="input-medium" data-rules="" value="<?echo $order_notice ?>">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">平台卡密的长度：</label>
        <div class="controls">
            <input name="config[card_pwd_len]" type="text" class="input-medium" data-rules="" value="<?echo $login_notice ?>">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">卡密前缀字符：</label>
        <div class="controls">
            <input name="config[card_prefix]" type="text" class="input-medium" data-rules="" value="<?echo $card_prefix ?>">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">卡密后缀字符：</label>
        <div class="controls">
            <input name="config[card_subfix]" type="text" class="input-medium" data-rules="" value="<?echo $card_subfix ?>">
        </div>
    </div>


    <div class="row actions-bar">
        <div class="form-actions span13 offset3">
            <button type="submit" class="button button-primary" id="save-config">保存</button>
            <button type="reset" class="button" id="cancel-config">返回</button>
        </div>
    </div>
</form>

<!-- script start -->
<script type="text/javascript">
    BUI.use('bui/form',function(Form){
        var form = new Form.Form({
            srcNode : '#Config_Form'
        });
        form.render();

        //保存
        $("#save-config").on('click', function(){
            if(form.isValid()){
                var param = $._get_form_json("#Config_Form");
                $._ajax('/config/config/content', param, 'POST', 'JSON', function(json){
                    if(json.code > 0){
                        BUI.Message.Alert('保存成功', 'success');
                    }else{
                        BUI.Message.Alert(json.msg, 'error');
                        this.close();
                    }
                });
            }
        });
        //返回
        $("#cancel-config").on('click', function(){
            window.location.href = '/config/config/list';
        });
    });
</script>
<!-- script end -->

<script>




</script>

</div>
</body>
</html>