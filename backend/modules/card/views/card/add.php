<?php
use yii\helpers\Html;
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>添加卡密</title>

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
            width: 700px;
            background-color: #f6f6fb;
            border: 1px solid #c3c3d6;
        }
        .layout-content{
            width: 700px;
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
    <script>
        _BASE_LIST_URL =  "<?php echo yiiUrl('auth/auth/list') ?>";
    </script>
</head>

<body>
<div class="demo-content">
    <form id="Goods_Form" action="" class="form-horizontal" onsubmit="return false;" >
        <h2>添加卡密</h2>

        <div class="control-group">
            <label class="control-label"><s>*</s>卡组：</label>
            <div class="controls">
                <input name="card[group_bn]" type="text" class="input-medium" data-rules="{required : true}">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">面值：</label>
            <div class="controls">
                <input name="card[points]" type="text" class="input-medium" data-rules="">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">密码：</label>
            <div class="controls">
                <input name="card[pwd]" type="text" class="input-medium" data-rules="">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><s>*</s>生成数量：</label>
            <div class="controls">
                <input name="card[card_num]" type="text" class="input-medium" data-rules="{min:1, required : true}">
            </div>
        </div>

        <div class="row actions-bar">
            <div class="form-actions span13 offset3">
                <button type="submit" class="button button-primary" id="save-card">保存</button>
                <button type="reset" class="button" id="cancel-card">返回</button>
            </div>
        </div>
    </form>

    <!-- script start -->
    <script type="text/javascript">
        BUI.use('bui/form',function(Form){
            var form = new Form.Form({
                srcNode : '#Goods_Form'
            });
            form.render();

            //保存
            $("#save-card").on('click', function(){
                if(form.isValid()){
                    var param = $._get_form_json("#Goods_Form");
                    $._ajax('/card/card/add', param, 'POST', 'JSON', function(json){
                        if(json.code > 0){
                            BUI.Message.Alert(json.msg, function(){
//                                window.location.href = '/card/card/list';
                            }, 'success');

                        }else{
                            BUI.Message.Alert(json.msg, 'error');
                            this.close();
                        }
                    });
                }
            });
            //返回
            $("#cancel-card").on('click', function(){
//                window.location.href = '/card/card/list';
            });
        });
    </script>
    <!-- script end -->
</div>
</body>
</html>