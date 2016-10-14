<?php
use common\models\Auth;
?>
<style>
    .avatar_content{
        height: 120px;
        width: 140px;
        display: block;
        margin-bottom: 20px;
        margin-right: 160px;
    }
    .avatar_img{
        height: 100px;
        width: 120px;
        margin: 10px 40px;
    }

</style>
<!--<link rel="stylesheet" href="/plugins/webuploader/webuploader.css" type="text/css"/>-->
<script src="/plugins/webuploader/webuploader.js" type="text/javascript"></script>
<div id="content" style="display: block" >
    <form id="form" class="form-horizontal">
        <div class="row">

            <div class="control-group span8">
                <label class="control-label">微信昵称：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['nick'] ?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">真实姓名：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['name'] ?></span>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="control-group span10 avatar_content" >
                <label class="control-label">微信头像：</label>
                <div class="controls">
                    <img class="avatar_img" src="<?php echo $auth['avatar'] ?>">
                </div>
            </div>
            <div  class="control-group span10 avatar_content" >
                <label class="control-label <?php echo $auth['auth_status'] != Auth::CHECK_PASS ? 'upload_name_card' : ''  ?>">
                    名片：<?php echo $auth['auth_status'] != Auth::CHECK_PASS ? '【点击更改】' : ''  ?>
                </label>
                <div  class="controls <?php echo $auth['auth_status'] != Auth::CHECK_PASS ? 'upload_name_card' : ''  ?>" >
                    <img id="name_card_img" class="avatar_img" src="<?php echo $auth['name_card'] ?>">
                    <input id="name_card_input" type="hidden" value="<?php echo $auth['name_card'] ?>">
                </div>
            </div>
        </div>
        <div class="row">

            <div class="control-group span8">
                <label class="control-label">手机号码：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['mobile']?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">邮箱：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['email'] ?></span>
                </div>
            </div>

            <div class="control-group span8">
                <label class="control-label">微信公众号：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['wechat_openid'] ?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">用户类型：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['user_type'] ?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">审核状态：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['status_name'] ?></span>
                </div>
            </div>


            <div class="control-group span8">
                <label class="control-label">申请时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['create_at'] ?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">更新时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $auth['update_at'] ?></span>
                </div>
            </div>
        </div>
    </form>
</div>
<style>
    .webuploader-element-invisible{
        display: none;
    }
</style>
<script>

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

    $(function () {
        // 初始化Web Uploader
        var uploader = WebUploader.create({
            // 选完文件后，是否自动上传。
            auto: true,
            //文件名称
            fileVal: 'attachment',
            // swf文件路径
            swf: '/plugins/webuploader/Uploader.swf',
            // 文件接收服务端。
            server: "/auth/auth/upload-name-card",
            // 选择文件的按钮。可选。
            pick: '.upload_name_card',
            fileNumLimit: 1,
            fileSizeLimit: 2 * 1024 * 1024,
            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
            formData: {
                objtype: 'auth',
                auth_id: <?php echo $auth['auth_id'] ?>
            }
        });

        // 当有文件添加进来之前
        uploader.on('beforeFileQueued', function (handler) {
//            uploader.reset();
        });

        // 当有文件添加进来的时候
        uploader.on( 'fileQueued', function( file ) {

        });

        // 文件上传过程中创建进度条实时显示。
        uploader.on( 'uploadProgress', function( file, percentage ) {

        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on('uploadSuccess', function (file, response) {
            $('#' + file.id).addClass('upload-state-done');
            if(response.code > 0){
                var data = response.data;
                $("#name_card_img").attr('src', data.filePath);
                $("#name_card_input").val(data.filePath);
            }else{
                BUI.Message.Alert('上传失败！');
            }
        });

        // 文件上传完后都触发事件
        uploader.on('uploadComplete', function (file, response) {
            uploader.reset();
        });

        //文件出错
        uploader.on('error', function (handler) {
            _file_upload_notice(handler);
        });

        // 文件上传失败，显示上传出错。
        uploader.on('uploadError', function (file) {
            alert('上传失败！');
        });

        // 完成上传完了，成功或者失败，先删除进度条。
        uploader.on('uploadComplete', function (file) {
            $('#' + file.id).find('.progress').remove();
        });
    });
</script>