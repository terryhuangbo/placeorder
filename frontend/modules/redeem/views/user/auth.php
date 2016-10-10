<!DOCTYPE html>
<html>
<head>
    <title>认证</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="browsermode" content="application">
    <meta name="x5-page-mode" content="app">
    <link rel="stylesheet" type="text/css" href="/css/header.css">
    <link rel="stylesheet" type="text/css" href="/css/renzheng.css">
    <script src="/js/jquery-1.11.3.min.js"></script>
    <script src="/plugins/webuploader/webuploader.js" type="text/javascript"></script>
    <script src="/js/tools.js"></script>

    <style type="text/css">
        .msg-error{
            color: darkorange;
            font-size: 12px;
            text-align: center;
            margin: 5px auto 10px auto;
        }
        .webuploader-element-invisible{
            display: none;
        }
        select{
            width: 100%;
            padding: 6px;
            padding-left: 100px;
            box-sizing: border-box;
            border: 1px solid #d2d2d2;
            border-radius: 6px;
            outline: none;
            background: #fff
        }


    </style>
</head>
<body>
<div class="body-All">
    <form id="auth">
        <div class="title">
            <span>用户认证</span>
        </div>
        <input type="hidden" name="uid" value="<?php echo $uid ?>">
        <div class="form-group">
            <label><span>*</span>真实姓名</label>
            <input type="text" name="name" placeholder="请输入您的真实姓名"/>
        </div>
        <div class="form-group">
            <label><span>*</span>手&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;机</label>
            <input type="text" name="mobile" placeholder="请输入您的手机号码"/>
        </div>
        <div class="form-group">
            <label><span>*</span>邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱</label>
            <input type="text" name="email" placeholder="请输入您的常用邮箱"/>
        </div>
        <div class="form-group">
            <label><span>*</span>用户类型</label>
            <select name="user_type">
                <?php foreach($type_list as $key => $val): ?>
                    <option value="<?php echo $key ?>"><?php echo $val ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-group">
            <div class="box type-img-content">
                <div class="type">
                    <div class="left">上传用户类型凭证（如名片，职称认证书等）</div>
                </div>
                <div class="pic usertypepic">
                    <div class="img upload_img">
                        <img src="/images/pic04.png">
                    </div>
                </div>
            </div>
        </div>

        <div class="pb"></div>
        <div class="button">
            <a href="javaScript:void(0);" id="submit" class="btn">确认</a>
        </div>
    </form>
</div>
</body>
<script>
    //上传
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
            server: "<?php echo yiiParams('uploader_url') ?>",
//            server: "/common/file/upload",
            // 选择文件的按钮。可选。
            pick: '.upload_img',
            fileNumLimit: 3,
            fileSizeLimit: 5 * 1024 * 1024,
            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
            formData: {
                objtype: 'usertype'
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
            if(response.code > 0){
                var data = response.data;
                var imgsrc = '<?php echo yiiParams('frontend') ?>' + data.filePath;
                $("#name_card_img").attr('src', data.filePath);
                $("#name_card_input").val(data.filePath);
                var img_html = '<div class="img ">'+
                                '    <img src="'+ imgsrc +'">'+
                                '    <input type="hidden" name="usetypeimg" value="'+ imgsrc +'">'+
                                '</div>';
                $(".usertypepic").prepend(img_html);
                if($("input[name=usetypeimg]").length == 3){
                    $(".upload_img").remove();
                }
            }else{
                alert('上传失败！');;
            }
        });

        // 文件上传完后都触发事件
        uploader.on('uploadComplete', function (file, response) {
            uploader.addButton({
                id: '.upload_img'
            });
//            uploader.reset();
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

    //提交
    $("#submit").on('click', function(){
        var param = $._get_form_json('#auth');
        $._ajax('/redeem/user/auth', param, 'POST', 'JSON', function(json){
            var code = json.code;
            var msg = json.msg;
            if(code > 0){
                window.location.href = '/redeem/home/index';
            }else if(code == -20001){
                var error = $('<p class="msg-error">'+ msg +'</p>');
                $("input[name=name]").closest('div').after(error);
                error.fadeOut(1500);
            }else if(code == -20002){
                var error = $('<p class="msg-error">'+ msg +'</p>');
                $("input[name=mobile]").closest('div').after(error);
                error.fadeOut(1500);
            }else if(code == -20003){
                var error = $('<p class="msg-error">'+ msg +'</p>');
                $("input[name=email]").closest('div').after(error);
                error.fadeOut(1500);
            }else if(code == -20007){
                var error = $('<p class="msg-error">'+ msg +'</p>');
                $(".type-img-content").after(error);
                error.fadeOut(1500);
            }
        });
    });

</script>
</html>