var username = getCookie('vso_uname');

function isMobileAvailable() {
    var avaliable = false;
    var mobile = $.trim($("input[name='mobile']").val());
    if (!/^1[34578][0-9]{9}$/.test(mobile)) {
        return false;
    }
    $.ajax({
        type: "POST",
        dataType: "JSON",
        async: false,
        data: {
            'mobile': mobile
        },
        url: "/project/default/is-mobile-available",
        success: function (json) {
            avaliable = json;
        }
    });
    return avaliable;
}

// 发送验证码
function send_valid_code(event) {
    var mobile = $.trim($("input[name='mobile']").val());
    var self = $(event.target || event.srcElement);
    if (!/^1[34578][0-9]{9}$/.test(mobile)) {
        alert("请输入正确的手机号");
        return false;
    }
    self.addClass("disabled").attr("disabled", true).val(60 + "秒后重发");
    var time = 60;
    var timeCode = setInterval(function () {
        time--;
        if (time <= 0) {
            clearTimeout(timeCode);
            self.val("发送验证码").removeClass("disabled").attr("disabled", false);
            return false;
        }
        self.val(time + "秒后重发");
    }, 1000);
    var valid_code = getRandStr(6);
    $.ajax({
        type: "POST",
        dataType: "json",
        data: {
            'mobile': mobile,
            'valid_code': valid_code,
            'content': '【蓝海创意云】感谢您入驻“创客空间”，验证码：' + valid_code
        },
        url: "/api/message/send-mobile-message",
        success: function (json) {
        }
    });
}

function check_valid_code() {
    var result = false;
    var mobile = $.trim($("input[name='mobile']").val());
    $.ajax({
        type: "POST",
        dataType: "JSON",
        async: false,
        data: {
            'mobile': mobile,
            'valid_code': $.trim($("input[name='valid_code']").val())
        },
        url: "/api/message/check-valid-code-by-mobile",
        success: function (json) {
            result = json.data == true ? true : false;
            // 验证通过，注册账号，入驻，返回的username作为项目管理员
            if (result) {
                $.ajax({
                    type: "GET",
                    async: false,
                    dataType: "json",
                    url: "/api/user/is-mobile-registed?mobile=" + mobile,
                    success: function (json) {
                        username = json.username;
                    }
                });
            }
        }
    });
    return result;
}
function loginLink(){
    window.location.href = "http://account.vsochina.com/user/login";
}
// 关注项目
function favor_project(_this) {
    var name = $(_this).attr('name');
    var proj_id = $(_this).attr('value');
    if (username == '') {
       confirm("登录后才能进行此操作",loginLink);
        return false;
    }
    if (proj_id == '') {
        alert("缺少项目编号");
        return false;
    }
    $.ajax({
        type: "POST",
        dataType: "json",
        async: false,
        url: "/project/favor/favor?id=" + proj_id,
        success: function (json) {
            if (json.result) {
                var widget_name = "a[name='" + name + "']";
                $(widget_name).html("已关注");
                $(widget_name).addClass('focused');
                var onclick = 'remove_favor_project(this)';
                $(widget_name).attr('onclick', onclick);
                $(".favor_num_" + proj_id).html(json.fans_num);
            }
            else {
                alert(json.msg);
            }
        }
    });
}

// 取消关注项目
function remove_favor_project(_this) {
    var name = $(_this).attr('name');
    var proj_id = $(_this).attr('value');
    if (username == '') {
        alert("登录后才能进行此操作");
        return false;
    }
    if (proj_id == '') {
        alert("缺少项目编号");
        return false;
    }
    $.ajax({
        type: "POST",
        dataType: "json",
        async: false,
        url: "/project/favor/remove-favor?id=" + proj_id,
        success: function (json) {
            if (json.result) {
                var widget_name = "a[name='" + name + "']";
                $(widget_name).html("关注");
                $(widget_name).removeClass('focused');
                var onclick = 'favor_project(this)';
                $(widget_name).attr('onclick', onclick);
                $(".favor_num_" + proj_id).html(json.fans_num);
            }
            else {
                alert(json.msg);
            }
        }
    });
}

// 申请加入项目
function apply_join_project(proj_id) {
    if (username == '') {
        alert("登录后才能进行此操作");
        return false;
    }
    if (proj_id == '') {
        alert("缺少项目编号");
        return false;
    }
    var content = $.trim($("#for_enter").val());
    if (content == '') {
        alert("请输入申请加入原因");
        return false;
    }
    $.ajax({
        type: "POST",
        dataType: "json",
        data: {
            'content': content
        },
        async: false,
        url: "/project/member/apply?id=" + proj_id,
        success: function (json) {
            alert(json.msg);
            if (json.result) {
                $("#for_enter").val("");
                $(".detail-apply-box").hide();
                $(".apply-enter").hide();
            }
        }
    });
}
/**
 * 生成指定长度的验证码
 * @param length
 * @returns {string}
 */
function getRandStr(length) {
    var res = "";
    for (var i = 0; i < length; i++) {
        res += Math.ceil(Math.random() * 9);
    }
    return res;
}