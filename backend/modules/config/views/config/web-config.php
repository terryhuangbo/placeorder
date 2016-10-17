<?php
use yii\helpers\Html;
use common\models\Meta;
$meta = new Meta();
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>网站配置</title>

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
        <h2>网站配置</h2>
        <div class="control-group">
            <label class="control-label">站点名称：</label>
            <div class="controls">
                <input name="config[site_name]" type="text" class="input-medium" data-rules="" value="<?echo $site_name ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">网站标题：</label>
            <div class="controls">
                <input name="config[site_title]" type="text" class="input-medium" data-rules="" value="<?echo $site_title ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">网站关键字：</label>
            <div class="controls">
                <input name="config[site_keywords]" type="text" class="input-medium" data-rules="" value="<?echo $site_keywords ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">网站描述：</label>
            <div class="controls">
                <input name="config[site_description]" type="text" class="input-medium" data-rules="" value="<?echo $site_description ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">网站备案号：</label>
            <div class="controls">
                <input name="config[site_icp]" type="text" class="input-medium" data-rules="" value="<?echo $site_icp ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">网站底部版权：</label>
            <div class="controls">
                <input name="config[site_copyright]" type="text" class="input-medium" data-rules="" value="<?echo $site_copyright ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">平台LOGO标志：</label>
            <div id="thumbpic-logo" class="controls">
                <span class="button button-primary">上传图片</span>
            </div>
        </div>
        <div class="row" >
            <div class="span16 layout-outer-content">
                <div id="thumbpic-content-logo" class="layout-content" aria-disabled="false" aria-pressed="false" >
                    <?php if(!empty($site_logo)): ?>
                        <div id="" class=" pull-left img-content-li">
                            <a href="javaScript:;"><span class="label label-important img-delete" file-path="<?php $site_logo ?>" attr="config[site_logo]" onclick="deleteFile(this)">删除</span></a>
                            <div aria-disabled="false"  class="" aria-pressed="false">
                                <img  src="<?php echo $site_logo ?>" />
                                <input type="hidden" name="config[site_logo]" value="<?php echo $site_logo ?>">
                                <p></p>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">平台背景图片：</label>
            <div id="thumbpic-bgimg" class="controls">
                <span class="button button-primary">上传图片</span>
            </div>
        </div>
        <div class="row" >
            <div class="span16 layout-outer-content">
                <div id="thumbpic-content-bgimg" class="layout-content" aria-disabled="false" aria-pressed="false" >
                    <?php if(!empty($site_bgimg)): ?>
                        <div id="" class=" pull-left img-content-li">
                            <a href="javaScript:;"><span class="label label-important img-delete" file-path="<?php $site_bgimg ?>" attr="config[site_bgimg]" onclick="deleteFile(this)">删除</span></a>
                            <div aria-disabled="false"  class="" aria-pressed="false">
                                <img  src="<?php echo $site_bgimg ?>" />
                                <input type="hidden" name="config[site_bgimg]" value="<?php echo $site_bgimg ?>">
                                <p></p>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">网站ICO图标：</label>
            <div id="thumbpic-ico" class="controls">
                <span class="button button-primary">上传图片</span>
            </div>
        </div>
        <div class="row" >
            <div class="span16 layout-outer-content">
                <div id="thumbpic-content-ico" class="layout-content" aria-disabled="false" aria-pressed="false" >
                    <?php if(!empty($site_icp_icon)): ?>
                        <div id="" class=" pull-left img-content-li">
                            <a href="javaScript:;"><span class="label label-important img-delete" file-path="<?php $site_bgimg ?>" attr="config[site_icp_icon]" onclick="deleteFile(this)">删除</span></a>
                            <div aria-disabled="false"  class="" aria-pressed="false">
                                <img  src="<?php echo $site_icp_icon ?>" />
                                <input type="hidden" name="config[site_icp_icon]" value="<?php echo $site_icp_icon ?>">
                                <p></p>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
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
                    $._ajax('/config/config/web', param, 'POST', 'JSON', function(json){
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

        $(function () {
            /*上传缩略图*/
            var uploader = WebUploader.create({
                // 选完文件后，是否自动上传。
                auto: true,
                //文件名称
                fileVal: 'attachment',
                // swf文件路径
                swf: '/plugins/webuploader/Uploader.swf',
                // 文件接收服务端。
                server: "/common/file/upload",
                // 选择文件的按钮。可选。
                pick: '#thumbpic-logo',
                //文件数量
//                fileNumLimit: 1,
                //文件大小 byte
                fileSizeLimit: 5 * 1024 * 1024,
                // 只允许选择图片文件。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                },
                //传递的参数
                formData: {
                    objtype: 'config'
                }
            });
            // 当有文件添加进来之前
            uploader.on('beforeFileQueued', function (handler) {

            });
            // 当有文件添加进来的时候-执行队列
            uploader.on( 'fileQueued', function( file ) {

            });
            //文件数量，格式等出错
            uploader.on('error', function (handler) {
                _file_upload_notice(handler);
            });
            // 文件上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on('uploadSuccess', function (file, response) {
                if(response.code > 0){
                    var data = response.data;
                    var div =
                        '<div id="'+ file.id +'" class=" pull-left img-content-li">'+
                        '<a href="javaScript:;"><span class="label label-important img-delete" ' +
                        'file-path="'+ data.filePath +'" attr="config[site_logo]" onclick="deleteFile(this)">删除</span></a>'+
                        '<div aria-disabled="false"  class="" aria-pressed="false">'+
                        '<img  src="'+ data.filePath +'" />'+
                        '<input type="hidden" name="config[site_logo]" value="'+ data.filePath +'">'+
                        '<p>'+ file.name +'</p>'+
                        '</div>'+
                        '</div>';
                    $('#thumbpic-content-logo').html(div);
                    uploader.reset();
                }else{
                    BUI.Message.Alert('上传失败！');
                }
            });
            // 文件上传失败，显示上传出错。
            uploader.on('uploadError', function (file) {

            });
        });

        //平台背景图片
        var uploader1 = WebUploader.create({
            // 选完文件后，是否自动上传。
            auto: true,
            //文件名称
            fileVal: 'attachment',
            // swf文件路径
            swf: '/plugins/webuploader/Uploader.swf',
            // 文件接收服务端。
            server: "/common/file/upload",
            // 选择文件的按钮。可选。
            pick: '#thumbpic-bgimg',
            //文件数量
//                fileNumLimit: 1,
            //文件大小 byte
            fileSizeLimit: 5 * 1024 * 1024,
            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
            //传递的参数
            formData: {
                objtype: 'config'
            }
        });
        // 当有文件添加进来之前
        uploader1.on('beforeFileQueued', function (handler) {

        });
        // 当有文件添加进来的时候-执行队列
        uploader1.on( 'fileQueued', function( file ) {

        });
        //文件数量，格式等出错
        uploader1.on('error', function (handler) {
            _file_upload_notice(handler);
        });
        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader1.on('uploadSuccess', function (file, response) {
            if(response.code > 0){
                var data = response.data;
                var div =
                    '<div id="'+ file.id +'" class=" pull-left img-content-li">'+
                    '<a href="javaScript:;"><span class="label label-important img-delete" ' +
                    'file-path="'+ data.filePath +'" attr="config[site_bgimg]" onclick="deleteFile(this)">删除</span></a>'+
                    '<div aria-disabled="false"  class="" aria-pressed="false">'+
                    '<img  src="'+ data.filePath +'" />'+
                    '<input type="hidden" name="config[site_bgimg]" value="'+ data.filePath +'">'+
                    '<p>'+ file.name +'</p>'+
                    '</div>'+
                    '</div>';
                $('#thumbpic-content-bgimg').html(div);
                uploader1.reset();


            }else{
                BUI.Message.Alert('上传失败！');
            }
        });
        // 文件上传失败，显示上传出错。
        uploader1.on('uploadError', function (file) {

        });

        //网站ICO图标
        var uploader2 = WebUploader.create({
            // 选完文件后，是否自动上传。
            auto: true,
            //文件名称
            fileVal: 'attachment',
            // swf文件路径
            swf: '/plugins/webuploader/Uploader.swf',
            // 文件接收服务端。
            server: "/common/file/upload",
            // 选择文件的按钮。可选。
            pick: '#thumbpic-ico',
            //文件数量
//                fileNumLimit: 1,
            //文件大小 byte
            fileSizeLimit: 5 * 1024 * 1024,
            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
            //传递的参数
            formData: {
                objtype: 'config'
            }
        });
        // 当有文件添加进来之前
        uploader2.on('beforeFileQueued', function (handler) {

        });
        // 当有文件添加进来的时候-执行队列
        uploader2.on( 'fileQueued', function( file ) {

        });
        //文件数量，格式等出错
        uploader2.on('error', function (handler) {
            _file_upload_notice(handler);
        });
        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader2.on('uploadSuccess', function (file, response) {
            if(response.code > 0){
                var data = response.data;
                var div =
                    '<div id="'+ file.id +'" class=" pull-left img-content-li">'+
                    '<a href="javaScript:;"><span class="label label-important img-delete" ' +
                    'file-path="'+ data.filePath +'" attr="config[site_icp_icon]" onclick="deleteFile(this)">删除</span></a>'+
                    '<div aria-disabled="false"  class="" aria-pressed="false">'+
                    '<img  src="'+ data.filePath +'" />'+
                    '<input type="hidden" name="config[site_icp_icon]" value="'+ data.filePath +'">'+
                    '<p>'+ file.name +'</p>'+
                    '</div>'+
                    '</div>';
                $('#thumbpic-content-ico').html(div);
                uploader2.reset();

            }else{
                BUI.Message.Alert('上传失败！');
            }
        });
        // 文件上传失败，显示上传出错。
        uploader2.on('uploadError', function (file) {

        });



        var _file_upload_notice = function (handler) {
            switch (handler) {
                case 'Q_TYPE_DENIED':
                    alert('文件类型不正确！');
                    break;
                case 'Q_EXCEED_SIZE_LIMIT':
                    alert('上传文件总大小超过限制！');
                    break;
                case 'Q_EXCEED_NUM_LIMIT':
                    alert('上传文件总数量超过限制！');
                    break;
            }
        };

        var deleteFile = function (dom){
            var attr = $(dom).attr('attr');
            $(dom).closest(".layout-content").html('<input type="hidden" name="'+ attr +'" value=" ">');
        }


    </script>

</div>
</body>
</html>