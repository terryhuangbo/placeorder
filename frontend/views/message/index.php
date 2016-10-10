<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title></title>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="renderer" content="webkit"/>
        <!--reset.css  header.css  footer.css-->
        <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css?v=20150807"/>
        <!--css-->
        <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.2.0/css/bootstrap.min.css"/>
        <link type="text/css" rel="stylesheet" href="http://static.vsochina.com/libs/webuploader/0.1.5/webuploader.css">
        <link rel="stylesheet" type="text/css" href="/css/popup.css">
        <!--jquery-->
        <script type="text/javascript" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
        <script src="http://static.vsochina.com/libs/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <!--cookie domain-->
        <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
        <script type="text/javascript" src="http://account.vsochina.com/static/js/referer_getter.js"></script>
        <script type="text/javascript" src="http://static.vsochina.com/libs/webuploader/0.1.5/webuploader.js"></script>
    </head>
    <body>
        <a id="popup_btn_report" class="popup-btn">点击按钮出现举报弹窗</a>
        <a id="popup_btn_remark" class="popup-btn">点击按钮出现互评弹窗</a>

        <!-- 举报弹窗 -->
        <div id="popup_wrap_report" class="popup-wrap">
            <div class="popup-bg"></div>
            <div class="popup-content">
                <a class="popup-content-close">×</a>
                <div class="popup-content-top">
                    <span class="popup-content-title">举报提交</span>
                </div>
                <div class="popup-content-formbox">
                    <form action="" method="">
                        <div class="popup-form-group clearfix">
                            <label for="" class="popup-form-label">附件上传：</label>
                            <div class="popup-form-item">
                                <div class="popup-form-upload">
                                    <div class="clearfix">
                                        <div id="upload_attachment_local" class="popup-upload-btn btn-local">
                                            <a>本地上传</a>
                                        </div>
                                        <div id="upload_attachment_studio" class="popup-upload-btn btn-studio">
                                            <a onclick="">工作室上传</a>
                                        </div>
                                    </div>
                                    <ul id="upload_list" class="uploader-list clearfix"></ul>
                                </div>
                                <div>只允许上传一个附件</div>
                                <div>支持格式为:.doc,.docx,.rar,.zip(上限500MB)</div>
                            </div>
                        </div>
                        <div class="popup-form-group clearfix">
                            <label for="" class="popup-form-label">原因：</label>
                            <div class="popup-form-item">
                                <textarea row="3" maxlength="100"></textarea>
                                <div>最多可以输入100个字符</div>
                            </div>
                        </div>
                        <div class="popup-form-group clearfix">
                            <label for="" class="popup-form-label">交易维权：</label>
                            <div class="popup-form-item">
                                <div class="popup-form-intro">
                                    1.与被维权人有实际交易，但发现其在[“创意云”在线创作平台]上有违规情况，可以通过维权途径告知网站，维权为实名。
                                </div>
                                <div class="popup-form-intro">
                                    2.与他人无实际交易产生，但发现其在[“创意云”在线创作平台]上有违规情况，可以通过举报、投诉途径告知网站，举报、投诉为匿名。
                                </div>
                            </div>
                        </div>
                        <div class="popup-form-group popup-form-btnbox">
                            <button class="popup-form-confirm">保存</button>
                            <button class="popup-form-cancel">取消</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/ 举报弹窗 -->

        <!-- 互评弹窗 -->
        <div id="popup_wrap_remark" class="popup-wrap">
            <div class="popup-bg"></div>
            <div class="popup-content">
                <a class="popup-content-close">×</a>
                <div class="popup-content-top">
                    <span class="popup-content-title">双方互评</span>
                </div>
                <div class="popup-content-formbox">
                    <form action="" method="">
                        <div class="popup-form-group clearfix">
                            <label for="" class="popup-form-label">评价类型：</label>
                            <div class="popup-form-item">
                                <div class="popup-form-remarktype clearfix">
                                    <div class="popup-remarktype-item">
                                        <input type="radio" name="remark_status" value="1" checked>
                                        <label>好评</label>
                                        <i class="icon-remark icon-remark-good"></i>
                                    </div>
                                    <div class="popup-remarktype-item">
                                        <input type="radio" name="remark_status" value="2">
                                        <label>中评</label>
                                        <i class="icon-remark icon-remark-middle"></i>
                                    </div>
                                    <div class="popup-remarktype-item">
                                        <input type="radio" name="remark_status" value="3">
                                        <label>差评</label>
                                        <i class="icon-remark icon-remark-bad"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="popup-form-group clearfix">
                            <label for="" class="popup-form-label">评价内容：</label>
                            <div class="popup-form-item">
                                <textarea row="3" maxlength="100"></textarea>
                                <div>最多可以输入100个字符</div>
                            </div>
                        </div>
                        <div class="popup-form-group clearfix">
                            <label for="" class="popup-form-label">好评质量：</label>
                            <div class="popup-form-item">
                                <dl class="popup-form-starrate clearfix">
                                    <dt>工作态度</dt>
                                    <dd class="starrate-cancel"></dd>
                                    <dd class="starrate-star star-left"></dd>
                                    <dd class="starrate-star star-right"></dd>
                                    <dd class="starrate-star star-left"></dd>
                                    <dd class="starrate-star star-right"></dd>
                                    <dd class="starrate-star star-left"></dd>
                                    <dd class="starrate-star star-right"></dd>
                                    <dd class="starrate-star star-left"></dd>
                                    <dd class="starrate-star star-right"></dd>
                                    <dd class="starrate-star star-left"></dd>
                                    <dd class="starrate-star star-right"></dd>
                                    <dd class="starrate-result"></dd>
                                </dl>
                            </div>
                        </div>
                        <div class="popup-form-group popup-form-btnbox">
                            <button class="popup-form-confirm">确定</button>
                            <button class="popup-form-cancel">取消</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/ 互评弹窗 -->

        <script type="text/javascript">
            var uploader;

            $('#popup_btn_report').on('click', function(event) {
                $('#popup_wrap_report').show();
                uploader = WebUploader.create({
                    auto: true,
                    fileVal: 'attachment',
                    swf: '/static/webuploader/Uploader.swf',
                    server: 'http://api.vsochina.com/file/index/upload',
                    pick: '#upload_attachment_local',
                    accept: {
                        title: 'attachment',
                        extensions: 'doc,docx,rar,zip',
                        mimeTypes: 'application/msword,application/octet-stream,application/x-rar-compressed,application/zip'
                    },
                    fileNumLimit: 1,
                    fileSizeLimit: 500 * 1024 * 1024,
                    formData: {}
                });

                uploader.on('fileQueued', function (file) {
                    var _list = $("#upload_list"),
                        _li = $('<li id="' + file.id + '" title="' + file.name + '">\
                                    <span class="icon-progress">0%</span>\
                                    <a class="uploader-list-op uploader-delete">×</a>\
                                </li>');
                    _list.append(_li);
                    $(".uploader-delete").on('click', function (event) {
                        var _this = $(this),
                            _obj = _this.closest('li'),
                            fileId = _obj.attr('id');
                        uploader.removeFile(fileId, true);
                        _obj.remove();
                    });
                });

                uploader.on('uploadProgress', function (file, percentage) {
                    $("#" + file.id).find('.icon-progress').html(percentage * 100 + '%');
                });

                uploader.on('uploadSuccess', function (file, response) {
                    $('#' + file.id).find('.icon-progress').html(file.name + '已上传成功');
                });

                uploader.on('uploadError', function (file) {
                    $('#' + file.id).find('.icon-progress').html('失败');
                });
            });

            $(document).on('click', '.popup-content-close, .popup-bg', function(event) {
                $(this).closest('.popup-wrap').hide();
            });

            $("#popup_btn_remark").on('click', function(event) {
                $("#popup_wrap_remark").show();
            });

            $(".starrate-star").hover(function(event) {
                $('.starrate-star').removeClass('active');
                $(this).prevAll('.starrate-star').addClass('hover');
            }, function(event) {
                var point = parseFloat($('.starrate-result').html().split('分')[0]),
                    index = point / 0.5 - 1,
                    _objs = $('.starrate-star');
                _objs.removeClass('hover').eq(index).addClass('active').prevAll('.starrate-star').addClass('active');
            });
            $(document).on('click', '.starrate-star', function(event) {
                var _this = $(this),
                    point = 0.5 * (_this.index('.starrate-star') + 1) + '分';
                _this.addClass('active').prevAll('.starrate-star').addClass('active');
                _this.siblings('.starrate-result').html(point);
            });
            $(document).on('click', '.starrate-cancel', function(event) {
                $('.starrate-star').removeClass('active');
                $('.starrate-result').html('');
            });

            function stopPropagation(e) {
                if(e.stopPropagation()) {
                    e.stopPropagation();
                }
                else {
                    e.cancelBubble = true;
                }
            }
        </script>
    </body>
</html>