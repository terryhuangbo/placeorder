var username = getCookie('vso_uname');
var proj_id = $("input[name='hidden_proj_id']").val();
$(function () {
    $(".detail-info-two .slideBox").slide({
        mainCell: "ul",
        vis: 4,
        autoPlay: false,
        prevCell: ".detail-bannerpart-prev",
        nextCell: ".detail-bannerpart-next",
        effect: "leftLoop"
    });

    $(".rightinfo-groupmember.num5").mCustomScrollbar({
        scrollButtons:{
            scrollSpeed:50
        },
        axis:"y"
    });

    $(document).on('click', '.detail-rightpart-questionlist dt a', function (event) {
        stopDefault(event);
        var _this = $(this);
        if (_this.hasClass('open')) {
            _this.removeClass('open').parent().next().stop(true, true).slideUp('300');
        }
        else {
            _this.addClass('open').parent().next().stop(true, true).slideDown('300');
        }
    });

    $(document).on('keyup', '.for-enter', function (event) {
        stopDefault(event);
        var _this = $(this);
        var txt = _this.val();
        var len = _this.val().length;
        if (len > 100) {
            txt = txt.substring(0, 100);
            _this.val(txt);
            alert("输入的内容不能超过100个字");
        }
    });

    $(document).on('click', '.detail-apply-close', function (event) {
        stopDefault(event);
        $(this).parents(".detail-apply-box").hide().remove();
    });

    $(document).on('click', '.apply-enter, .ask-question', function (event) {
        stopDefault(event);
        var _this = $(this),
            scrollTop = get_scrollTop_of_body(),
            px = event.pageX,
            x = parseInt(px),
            py = event.pageY,
            y = parseInt(py),
            bw = parseInt($("body").width()),
            wh = parseInt($(window).height()),
            _obj,
            left,
            top,
            appendHtml;
        if (getCookie('vso_uname') == '') {
            alert("登录后才能进行此操作");
            return false;
        }
        if (proj_id == '') {
            alert("缺少项目编号");
            return false;
        }

        if ($(".detail-apply-box").length > 0) {
            $(".detail-apply-box").stop(true, true).hide('300').remove();
        }
        else {
            if (_this.hasClass('apply-enter')) {
                appendHtml = '<div class="detail-apply-box">\
                                  <a href="javascript:void(0);" class="detail-apply-close"></a>\
                                  <div class="detail-apply-title">申请加入</div>\
                                  <div class="detail-apply-content">\
                                      <textarea name="forenter" class="for-enter" id="for_enter" placeholder="申请加入原因……" maxlength="100" autofocus></textarea>\
                                      <p class="word-limit"><span>100</span>字以内</p>\
                                  </div>\
                                  <div class="detail-apply-operate">\
                                      <a href="javascript:void(0);" class="yellow-btn w100" onclick="apply_join_project(' + proj_id + ')">申请</a>\
                                  </div>\
                              </div>';
                $(".dreamspace-detail-content").append(appendHtml);
                _obj = $(".detail-apply-box");
                _obj.find('textarea').placeholder();
                left = (px < (bw - 280)) ? px : "0px";
                var temp = wh - y + scrollTop - 327;
                top = (temp < 0) ? (y + temp + "px") : py;
                _obj.css({
                    "left": left,
                    "top": top
                }).show().find('textarea').focus();
            }
            else if (_this.hasClass('ask-question')) {
                appendHtml = '<div class="detail-apply-box">\
                                  <a href="javascript:void(0);" class="detail-apply-close"></a>\
                                  <div class="detail-apply-title">我要提问</div>\
                                  <div class="detail-apply-content">\
                                      <textarea name="forenter" class="for-enter" id="for_question" placeholder="有什么想要提问的……" autofocus></textarea>\
                                      <p class="word-limit"><span>100</span>字以内</p>\
                                  </div>\
                                  <div class="detail-apply-operate">\
                                      <a href="javascript:void(0);" class="yellow-btn w100" id="for_question_btn">提交</a>\
                                  </div>\
                              </div>';
                $(".dreamspace-detail-content").append(appendHtml);
                _obj = $(".detail-apply-box");
                _obj.find('textarea').placeholder();
                left = (x < (bw - 280)) ? px : "0px";
                var temp = wh - y + scrollTop - 327;
                top = (temp < 0) ? (y + temp + "px") : py;
                _obj.css({
                    "left": left,
                    "top": top
                }).show().find('textarea').focus();
            }
        }
    });
});

function stopPropagation(event) {
    if (event.stopPropagation)  event.stopPropagation();
    else  event.cancelBubble = true;
}

function get_scrollTop_of_body() {
    var scrollTop;
    //pageYOffset指的是滚动条顶部到网页顶部的距离
    if (typeof window.pageYOffset != 'undefined') {
        scrollTop = window.pageYOffset;
    }
    else if (typeof document.compatMode != 'undefined' && document.compatMode != 'BackCompat') {
        scrollTop = document.documentElement.scrollTop;
    }
    else if (typeof document.body != 'undefined') {
        scrollTop = document.body.scrollTop;
    }
    return parseInt(scrollTop);
}

function stopDefault(e) {
    if (e && e.preventDefault) {
        e.preventDefault();
    }
    else {
        window.event.returnValue = false;
    }
    return false;
}