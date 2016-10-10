$(function() {
    $(".scrollTop").click(function() {
        $("html,body").animate({
            scrollTop : $("#pageTop").offset().top
        });
    });
});
//清除字符串
function clearstr(a) {
    a.value = a.value.replace(/(^[0|\D]+)|([\D]+)/g, "");
}
function check_name(data) {
    return data;
    var data_arr = data.split("/");
    var data_file_name = data_arr.pop();
    var data_file_name_split_arr = data_file_name.split(".");
    var process_obj = data_file_name_split_arr[0];
    var process_obj = process_obj.replace(process_obj.substr(process_obj.length-3,3),"");
    data_file_name_split_arr[0] = process_obj ;
    var new_file_name_str = data_file_name_split_arr.join(".");
    data_arr.push(new_file_name_str);
    var final_name = data_arr.join("/");
    return final_name;
}
function file_limit_size(b, c) {
    var a;
    var c = c * 1024 * 1024;
    if (window.ActiveXObject) {
        var d = new Image();
        d.dynsrc = b;
        a = d.fileSize;
    } else {
        if (navigator.userAgent.indexOf("Firefox") != -1) {
            a = document.getElementById("myFile").files[0].size;
        } else {
            if (navigator.userAgent.indexOf("Chrome") != -1) {
                a = document.getElementById("myFile").files[0].fileSize;
            }
        }
    }
    if (a > c) {
        return false;
    } else {
        return true;
    }
}
function setprint(a) {
    $("#"+a).printArea();
}
var sizei = 0;
var setfontsize = function() {
    i = sizei + 1;
    sizei = sizei + 1;
    var a = new Array("12", "14", "16", "18");
    if (i < a.length) {
        if (i > 0) {
            $("#details").removeClass("font" + a[i -= 1]);
        }
        $("#details").addClass("font" + a[i += 1]);
    } else {
        sizei = 0;
        $("#details").removeClass("font" + a[3]);
        $("#details").addClass("font" + a[0]);
    }
};
function clearspecial(a) {
    a.value = a.value.replace(/[^a-z\d\u4e00-\u9fa5]/ig, "");
}
var share = function(a, b) {
    var d = a.id;
    if (d && a.tagName == "A") {
        if ($(a).find("div").length) {
            var c = $(a).find("div:first");
            c.attr("href", a.href);
            c.attr("id", "div_" + d);
        } else {
            var c = "<div id='div_" + d + "' href='" + a.href
                    + "' class='icon16 share'>分享</div>";
            $(a).html(c);
        }
    }
    a = $(a).find("div:first").get(0);
    ajaxmenu(a, 250, "1", "2", "43");
    return false;
};

function login_vso_box(){
    $("#redirectpop").val(""+encodeURIComponent(window.location.href)+"");
    $("submitpop").val("submit");
    $("#login_pop").submit();

    if($("#login_vso_box_username").val()==undefined||$("#login_vso_box_username").val()==''){
        return;
    }
    if($("#login_vso_box_password").val()==undefined||$("#login_vso_box_password").val()==''){
        return;
    }
    // 保存cookie
    var date=new Date();
    var username = $("#login_vso_box_username").val();
    var password = hex_md5($("#login_vso_box_password").val());
    if($("#ckb_rembMe").attr("checked")){
        var expiresDays=10;
        //将date设置为10天以后的时间
        date.setTime(date.getTime()+expiresDays*24*3600*1000);
        //将两个cookie设置为10天后过期
        document.cookie="username=" + username + ";expires="+ date.toGMTString() ;
        document.cookie="password=" + password + ";expires="+ date.toGMTString() ;
    }else{
        //删除cookie
        date.setTime(date.getTime()-10);
        document.cookie="username=" + username + ";expires="+date.toGMTString();
        document.cookie="password=" + password + ";expires="+date.toGMTString();
    }


        /*
     * @ 修改人：侯庆东
     * @ 修改说明：获取到当前登录时的url,发送ajax,通过判断改值得出用户是在哪个频道登录的
     * @ 修改时间：2013/08/23
     */
    var my_login_nav = location.href ;
    $.ajax({
                    type : "post",
                    url : "index.php?do=login&login_type=3",
                    data:{
                        txt_account:$("#login_vso_box_username").val(),
                        pwd_password:$("#login_vso_box_password").val(),
                        rembMe:$("#ckb_rembMe").attr("checked"),
                        my_login_nav:my_login_nav,
                        noCookie:"就是没有cookie啦"
                    },
                    dataType: "json",
                    success: function (data) {
                            if(data.status==1){
                                    if(redurl!=undefined&&redurl!=""){
                                        location.href = redurl ;
                                    }else{
                                        window.location.reload();
                                    }
                            }else{
                                showDialog(data.msg,"alert","提示","",0);
                            }
                    },
                    beforeSend : function(XMLHttpRequest) {
                    },
                    complete : function(XMLHttpRequest, textStatus) {

                    },
                    error : function(data) {
//                        for(var k in data){
//                            alert("key "+k+ "value"+data[k]);
//                        }
                        if(data.status==200&&data.readyState==4&&data.statusText=="OK"){
                            if(redurl!=undefined&&redurl!=""){
                                location.href = redurl ;
                                }else{
                                    window.location.reload();
                            }
                        }
                    }
                });
}

function login_vso_box_fabu(){
    if($("#login_vso_box_username").val()==undefined||$("#login_vso_box_username").val()==''){
        return;
    }
    if($("#login_vso_box_password").val()==undefined||$("#login_vso_box_password").val()==''){
        return;
    }
    // 保存cookie
    var date=new Date();
    var username = $("#login_vso_box_username").val();
    var password = hex_md5($("#login_vso_box_password").val());
    if($("#ckb_rembMe").attr("checked")){
        var expiresDays=10;
        //将date设置为10天以后的时间
        date.setTime(date.getTime()+expiresDays*24*3600*1000);
        //将两个cookie设置为10天后过期
        document.cookie="username=" + username + ";expires="+ date.toGMTString() ;
        document.cookie="password=" + password + ";expires="+ date.toGMTString() ;
    }else{
        //删除cookie
        date.setTime(date.getTime()-10);
        document.cookie="username=" + username + ";expires="+date.toGMTString();
        document.cookie="password=" + password + ";expires="+date.toGMTString();
    }

    /*
     * @ 修改人：侯庆东
     * @ 修改说明：获取到当前登录时的url,发送ajax,通过判断改值得出用户是在哪个频道登录的
     * @ 修改时间：2013/08/23
     */
    var my_login_nav = location.href;
    $.ajax({
                    type : "post",
                    url : "index.php?do=login&login_type=3",
                    data:{
                        txt_account:$("#login_vso_box_username").val(),
                        pwd_password:$("#login_vso_box_password").val(),
                        my_login_nav:my_login_nav,
                        noCookie:"就是没有cookie啦"
                    },
                    dataType: "json",
                    success: function (data) {
                            if(data.status==1){
                                $("#task_release").submit();
                            }else{
                                //alert(data.msg);
                                showDialog(data.msg,"alert","提示","",0);
                                return false;
                            }
                    },
                    error : function(data) {
                        if(data.status==200&&data.readyState==4&&data.statusText=="OK"){
                            if(redurl!=undefined&&redurl!=""){
                                $("#task_release").submit();
                            }else{
                                return false;
                            }
                        }
                    }
                });
}

function hide_Window(){
    $("#div_login_box").remove();
}

//拖动代码2
function drag(o,s){
    if (typeof o == "string"){
        o = document.getElementById(o);
    }
    o.orig_x = parseInt(o.style.left) - document.body.scrollLeft;
    o.orig_y = parseInt(o.style.top) - document.body.scrollTop;
    o.orig_index = o.style.zIndex;
    o.onmousedown = function(a){
        this.style.cursor = "move";
        this.style.zIndex = 10000;
        var d=document;
        if(!a)a=window.event;
        var x = a.clientX+d.body.scrollLeft-o.offsetLeft;
        var y = a.clientY+d.body.scrollTop-o.offsetTop;
        d.ondragstart = "return false;"
        d.onselectstart = "return false;"
        d.onselect = "document.selection.empty();"
        if(o.setCapture)
            o.setCapture();
        else if(window.captureEvents)
            window.captureEvents(Event.MOUSEMOVE|Event.MOUSEUP);
        d.onmousemove = function(a){
            if(!a)a=window.event;
            o.style.left = a.clientX+document.body.scrollLeft-x;
            o.style.top = a.clientY+document.body.scrollTop-y;
            o.orig_x = parseInt(o.style.left) - document.body.scrollLeft;
            o.orig_y = parseInt(o.style.top) - document.body.scrollTop;
        }
        d.onmouseup = function(){
            if(o.releaseCapture)
                o.releaseCapture();
            else if(window.captureEvents)
                window.captureEvents(Event.MOUSEMOVE|Event.MOUSEUP);
            d.onmousemove = null;
            d.onmouseup = null;
            d.ondragstart = null;
            d.onselectstart = null;
            d.onselect = null;
            o.style.cursor = "normal";
            o.style.zIndex = o.orig_index;
        }
    }
    if (s){
        var orig_scroll = window.onscroll?window.onscroll:function (){};
        window.onscroll = function (){
            orig_scroll();
            o.style.left = o.orig_x + document.body.scrollLeft;
            o.style.top = o.orig_y + document.body.scrollTop;
        }
    }
}
function funMove(obj){
    drag(obj.id);
}
function check_user_login(a) {
    if (isNaN(uid) || uid == 0) {
        showDialog("创意云登录", "notice", "登陆消息提示", "redirect_url()", 0);
        //createLogin_box();
        return false;
    } else {
        return true;
    }
}
function check_user_login1(a) {
    if (isNaN(uid) || uid == 0) {
        if (a != undefined) {
            showWindow1('message', '/index.php?do=login_window&redirectURI=' + encodeURIComponent(a));
        }
        else {
            showWindow1('message', '/index.php?do=login_window');
        }
        return false;
    }
    else {
        return true;
    }
}
function check_user_login2(a) {
    if (isNaN(a) || a == 0) {
        showWindow1('message', '/index.php?do=login_window');
        return false;
    }
    else {
        return true;
    }
}
//创建登录框
function createLogin_box(){
    $div = "<div onclick='drag(this)' id='div_login_box' class='noClass'>"
                    + "<div class='login_box_head'>&emsp;创意云登录 "
                        + "<span><a class='flbc' style='float:right;' title='close' onclick='hide_Window();' href='javascript:;''>关闭</a></span>"
                    + "</div>"
                    + "<div class='login_box'>"
                        + "<form method='post' action='/index.php?do=login'>"
                            + "<div class='login_box_bar'>用户名<input id='login_vso_box_username' style='background:none' class='input_text_area' type='text' autocomplete='off' name='txt_account' value=''></div>"
                            + "<div class='login_box_bar'>密&emsp;码<input id='login_vso_box_password'style='background:none' class='input_text_area' type='password' autocomplete='off' name='pwd_password'><a href='#' style='float:right; margin-right:5px;'>忘记密码?</a></div>"
                            + "<div class='login_box_bar backgroud'> "
                                + "<input type='checkbox' style='float:left'/><div class='login_remindme'>记住我</div>"
                                + "<input type='checkbox' style='margin-left:70px;float:left'/><div class='login_remindme' >保持登录状态</div>"
                            + "</div>"
                            + "<div class='login_box_loginbutton'> "
                                 + "<button class='loginbutton' onclick='login_vso_box();return false;' type='submit'></button>"
                                 + "<div class='lanse_tip'>还没有创意云账号？&emsp;<a href='/index.php?do=register'>立刻注册</a></div>"
                            + "</div>"
                            + "<div class='login_box_loginbutton font'>"
                                + "<div class='yijiandenglu'>使用合作网站账号一键登录</div>"
                                + "<div class='login_box_qq'></div>"
                                + "<div class='login_box_xinlang'></div>"
                                + "<div class='login_box_douban'></div>"
                                + "<div class='login_box_renren'></div>"
                                + "<div class='login_box_taobao'></div>"
                            + "</div>"
                        + "</form>"
                    + "</div>"
                + "</div>";
        // 添加一个不存在的Class 判断该div是否存在
        if(!$('#div_login_box').hasClass("noClass")){
            $('body').append($div);
        }
}


function win_confirm(a) {
    if (a) {
        location.href = a;
    }
}
function login() {
    location.href = "index.php?do=login";
}
function redirect_url(b) {
    var c = window.location.href;
    var a = b ? b : "index.php?do=login";
    b = a.replace(/\?/, "\\?");
    var d = c.search(b);
    if (d == -1) {
        setcookie("loginrefer", c, 120);
    }
    window.location.href = $("#base_href").attr("href")+a;
}
function loadingControl(a, c, b) {
    $(a).find(c).animate({
        width : "100%"
    }, b, function() {
        $(this).html("complete!")
    })
}
function favor(j, g, f, c, a, b, h, n, p) {
    if (check_user_login1()) {
        var d = "/index.php?do=ajax&view=ajax&ac=favor";
        $.post(d, {
            pk: j,
            keep_type: g,
            obj_id: a,
            model_code: f,
            obj_uid: c,
            obj_name: b,
            origin_id: h,
            page_size: n,
            page: p
        }, function (l) {
            if (l.status == 1) {
                var type = "right";
                if (l.data == '您无法收藏自己的任务！' || l.data == '您已经收藏了此任务，无需继续收藏！') {
                    type = "alert"
                }
                if (g == 'space') {
                    showDialog("<span style='font-size:14px'>" + l.data + "!</span>", type, l.msg, 'window.location.reload()');
                }
                else {
                    showDialog(l.data, type, l.msg);
                }
                return false;
            }
            else {
                if (g == 'space') {
                    showDialog(l.data, "alert", l.msg, 'window.location.reload()');
                }
                else {
                    showDialog(l.data, "alert", l.msg);
                }
                return false;
            }
        }, "json");
    }
}
//游戏试玩(游戏单页调用)  suhui 20130902
function game_play_info(j, g, f, c, a, b,h) {
    //if (check_user_login1()) {
        //去掉对登录的判断
        var d = "index.php?do=ajax&view=ajax&ac=game_play";
        $.post(d, {
            pk : j,
            keep_type : g,
            model_code : f,
            obj_uid : c,
            obj_id : a,
            obj_name : b,
            username:h
        }, function(l) {

        }, "json")
    //}
    //document.getElementById("hidden_show").style.display="none";
    //$('#game_play_window').show();
}
//游戏试玩(列表页调用)
function game_play(j, g, f, c, a, b,h) {
    //if (check_user_login1()) {
    //去掉对登录的判断
        var d = "index.php?do=ajax&view=ajax&ac=game_play";
        $.post(d, {
            pk : j,
            keep_type : g,
            model_code : f,
            obj_uid : c,
            obj_id : a,
            obj_name : b,
            username:h
        }, function(l) {

        }, "json")
    //}
}
function contentCheck(g, j, d, c, b, h) {
    var a = $("#" + g).val();
    if (a.length > c) {
        if (b == 1) {
            tipsAppend(h, j + "内容不得多于" + c + "个字", "warning", "orange")
        } else {
            var f = $("#" + g).attr("msgArea");
            $("#" + f).addClass("valid_error").html(
                    "<span>" + j + "内容不得多于" + c + "个字</span>")
        }
        return false
    } else {
        if (a.length < d) {
            if (b == 1) {
                tipsAppend(h, j + "内容不得少于" + d + "个字", "warning", "orange")
            } else {
                var f = $("#" + g).attr("msgArea");
                $("#" + f).addClass("valid_error").html(
                        "<span>" + j + "内容不得少于" + d + "个字</span>")
            }
            return false
        } else {
            var f = $("#" + g).attr("msgArea");
            $("#" + f).removeClass("valid_error").html(" ");
            return a
        }
    }
}
function ifOut(f, a, b, d,id) {
    if($("#" + f + " li") == undefined){
        return true;
    }
    if(id){
        var divEle = $("#"+id).children("div");
        if($(divEle).length>=5){
            showDialog("文件上传数量超过限制，最大" + a + "个。", "alert", "操作提示");
            return false;
        }
    }
    var c = parseInt($("#" + f + " li").length) + 0;
    if (c >= a) {
        if (b == 1) {
            tipsAppend(d, "文件上传数量超过限制，最大" + a + "个。", "warning", "orange")
        } else {
            showDialog("文件上传数量超过限制，最大" + a + "个。", "alert", "操作提示")
        }
        return false
    } else {
        return true
    }
}
function mark(d, c, f, a) {
    var b = "";
    c && f && a ? b += "do-" + c + "*" + f + "-" + a : "";
    showWindow("mark", d + "&jump_url=" + b, "get", 0);
    return false
}
function tipsAppend(f, g, d, b) {
    $("#" + f).before("<div id='tips'></div>");
    var a = $("<div class='messages " + b + "'><span class='icon16 m_t4'>" + d
            + "</span>" + g + "</div>");
    $("#tips").empty().append(a);
    msgshow(a);
    var c = setTimeout(function() {
        msghide($("#tips"));
        clearTimeout(c)
    }, 2000)
}
function msgshow(b) {
    var a = setTimeout(function() {
        b.slideDown(200);
        clearTimeout(a)
    }, 100)
}
function msghide(a) {
    a.animate({
        opacity : 0.01
    }, 200, function() {
        a.slideUp(200, function() {
            a.remove()
        })
    })
}
function upload(f, o, h, j, l, d, b, n, g, m) {
    var c = document.getElementById(f);
    if (isExtName(c, 1, g, m)) {
        h == "back" ? pre = "../../" : pre = "";
        var a = pre + "index.php?do=ajax&view=upload&task_id=" + j
                + "&file_type=" + o + "&obj_type=" + d + "&obj_id=" + l
                + "&file_name=" + f;

        $.ajaxFileUpload({
            url : a,
            fileElementId : f,
            dataType : "json",
            success : function(p) {
                if (p.err) {
                    if (g == 1) {
                        tipsAppend(m, p.err, "error", "red");
                    } else {
                        showDialog(decodeURI(p.err), "alert", "错误提示", "", 0);
                    }
                    return false;
                } else {
                    p.filename = f;
                    uploadResponse(p);
                }
            },
            error : function(q, p, r) {
                if (g == 1) {
//                    tipsAppend(m, r, "error", "red")
                    showDialog("文件上传失败！可能文件大小超出限制(100M)", "alert", "错误提示", "", 0);
                } else {
                    showDialog("文件上传失败！可能文件大小超出限制(100M)", "alert", "错误提示", "", 0);
                }
                return false;
            }
        });
    }
}
function sendMessage(b, a) {
    if (check_user_login()) {
        if (uid == b) {
            showDialog("无法给自己发送站内短信", "alert", "操作提示");
            return false;
        }
        showWindow("message", "index.php?do=ajax&view=message&op=send&to_uid="
                + b + "&to_username=" + a);
        return false;
    }
}
var redirect_u;
function reset_message_window () {
    $("#tar_title").val("");
    $("#tar_content").val("");
    $("#length_show").text("已输入长度:0，还可以输入:500字");
}

function sendMessage1(b, a) {
    reset_message_window();
    redirect_u = window.location.href;
    if (check_user_login1()) {
        if (uid == b) {
            showDialog("无法给自己发送站内短信", "alert", "操作提示");
            return false;
        }
        showWindow1("message", "index.php?do=ajax&view=message&op=send&to_uid="
                + b + "&to_username=" + a);
        return false;
    }
}
function report(g, d, a, f, b) {
    // if (check_user_login1(uid)) {
    if (1) {
        var c = "";
        if (d == "1") {
            c = "维权";
        } else {
            if (d == "2") {
                c = "举报";
            } else {
                c = "投诉";
            }
        }
        if (uid == f) {
            showDialog("无法对自己发起" + c, "alert", "操作提示");
            return false;
        } else {
            showWindow("report",
                    basic_url + "&op=report&type=" + d + "&obj=" + g
                            + "&obj_id=" + a + "&to_uid=" + f + "&to_username="
                            + b, "get", "0");
        }
    }
}
function _report(g, u, d, a, f, b) {
    // if (check_user_login1(uid)) {
    if (1) {
        var c = "";
        if (d == "1") {
            c = "维权";
        } else {
            if (d == "2") {
                c = "举报";
            } else {
                c = "投诉";
            }
        }
        if (uid == f) {
            showDialog("无法对自己发起" + c, "alert", "操作提示");
            return false;
        } else {
            showWindow2("report",
                    u + "&op=report&type=" + d + "&obj=" + g
                            + "&obj_id=" + a + "&to_uid=" + f + "&to_username="
                            + b, "get", "0");
        }
    }
}
function addFav(b, a) {
    if (document.all) {
        window.external.addFavorite(a, b)
    } else {
        if (window.sidebar) {
            window.sidebar.addPanel(b, a, "")
        }
    }
}
function setHomepage(b) {
    if (document.all) {
        document.body.style.behavior = "url(#default#homepage)";
        document.body.setHomePage(b)
    } else {
        if (window.sidebar) {
            if (window.netscape) {
                try {
                    netscape.security.PrivilegeManager
                            .enablePrivilege("UniversalXPConnect")
                } catch (c) {
                    alert("this action was aviod by your browser，if you want to enable，please enter about:config in your address line,and change the value of signed.applets.codebase_principal_support to true")
                }
            }
            var a = Components.classes["@mozilla.org/preferences-service;1"]
                    .getService(Components.interfaces.nsIPrefBranch);
            a.setCharPref("browser.startup.homepage", b)
        }
    }
}
var STYLEID = "1", STATICURL = "", IMGDIR = "resource/img/keke", VERHASH = "cC0", charset = "gbk", keke_uid = "0", cookiepre = "keke", cookiedomain = "", cookiepath = "", attackevasive = "0", disallowfloat = "", creditnotice = "";
var BROWSER = {};
var USERAGENT = navigator.userAgent.toLowerCase();
browserVersion({
    ie : "msie",
    firefox : "",
    chrome : "",
    opera : "",
    safari : "",
    maxthon : "",
    mozilla : "",
    webkit : ""
});
if (BROWSER.safari) {
    BROWSER.firefox = true
}
BROWSER.opera = BROWSER.opera ? opera.version() : 0;
var CSSLOADED = [];
var JSMENU = [];
JSMENU.active = [];
JSMENU.timer = [];
JSMENU.drag = [];
JSMENU.layer = 0;
JSMENU.zIndex = {
    win : 1200,
    menu : 1300,
    dialog : 1400,
    prompt : 1500
};
JSMENU["float"] = "";
var AJAX = [];
AJAX.url = [];
AJAX.stack = [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ];
var CURRENTSTYPE = null;
var keke_uid = isUndefined(keke_uid) ? 0 : keke_uid;
var creditnotice = isUndefined(creditnotice) ? "" : creditnotice;
var cookiedomain = isUndefined(cookiedomain) ? "" : cookiedomain;
var cookiepath = isUndefined(cookiepath) ? "" : cookiepath;
var KEKECODE = [];
KEKECODE.num = "-1";
KEKECODE.html = [];
var USERABOUT_BOX = true;
function browserVersion(types) {
    var other = 1;
    for (i in types) {
        var v = types[i] ? types[i] : i;
        if (USERAGENT.indexOf(v) != -1) {
            var re = new RegExp(v + "(\\/|\\s)([\\d\\.]+)", "ig");
            var matches = re.exec(USERAGENT);
            var ver = matches != null ? matches[2] : 0;
            other = ver !== 0 ? 0 : other
        } else {
            var ver = 0
        }
        eval("BROWSER." + i + "= ver")
    }
    BROWSER.other = other
}
function getEvent() {
    if (document.all) {
        return window.event
    }
    func = getEvent.caller;
    while (func != null) {
        var a = func.arguments[0];
        if (a) {
            if ((a.constructor == Event || a.constructor == MouseEvent)
                    || (typeof (a) == "object" && a.preventDefault && a.stopPropagation)) {
                return a
            }
        }
        func = func.caller
    }
    return null
}
function isUndefined(a) {
    return typeof a == "undefined" ? true : false
}
function in_array(c, b) {
    if (typeof c == "string" || typeof c == "number") {
        for ( var a in b) {
            if (b[a] == c) {
                return true
            }
        }
    }
    return false
}
function trim(a) {
    return (a + "").replace(/(\s+)$/g, "").replace(/^\s+/g, "")
}
function strlen(a) {
    return (BROWSER.ie && a.indexOf("\n") != -1) ? a.replace(/\r?\n/g, "_").length
            : a.length
}
function mb_strlen(c) {
    var a = 0;
    for ( var b = 0; b < c.length; b++) {
        a += c.charCodeAt(b) < 0 || c.charCodeAt(b) > 255 ? (charset == "utf-8" ? 3
                : 2)
                : 1
    }
    return a
}
function mb_cutstr(g, f, b) {
    var a = 0;
    var c = "";
    var b = !b ? "..." : "";
    f = f - b.length;
    for ( var d = 0; d < g.length; d++) {
        a += g.charCodeAt(d) < 0 || g.charCodeAt(d) > 255 ? (charset == "utf-8" ? 3
                : 2)
                : 1;
        if (a > f) {
            c += b;
            break
        }
        c += g.substr(d, 1)
    }
    return c
}
if (BROWSER.firefox && window.HTMLElement) {
    HTMLElement.prototype.__defineSetter__("outerHTML", function(b) {
        var a = this.ownerDocument.createRange();
        a.setStartBefore(this);
        var c = a.createContextualFragment(b);
        this.parentNode.replaceChild(c, this);
        return b
    });
    HTMLElement.prototype.__defineGetter__("outerHTML", function() {
        var a;
        var b = this.attributes;
        var d = "<" + this.tagName.toLowerCase();
        for ( var c = 0; c < b.length; c++) {
            a = b[c];
            if (a.specified) {
                d += " " + a.name + '="' + a.value + '"'
            }
        }
        if (!this.canHaveChildren) {
            return d + ">"
        }
        return d + ">" + this.innerHTML + "</" + this.tagName.toLowerCase()
                + ">"
    });
    HTMLElement.prototype.__defineGetter__("canHaveChildren", function() {
        switch (this.tagName.toLowerCase()) {
        case "area":
        case "base":
        case "basefont":
        case "col":
        case "frame":
        case "hr":
        case "img":
        case "br":
        case "input":
        case "isindex":
        case "link":
        case "meta":
        case "param":
            return false
        }
        return true
    })
}
function setcookie(h, g, f, d, b, c) {
    var a = new Date();
    a.setTime(a.getTime() + f * 1000);
    b = !b ? cookiedomain : b;
    d = !d ? cookiepath : d;
    document.cookie = escape(cookiepre + h) + "=" + escape(g)
            + (a ? "; expires=" + a.toGMTString() : "")
            + (d ? "; path=" + d : "/") + (b ? "; domain=" + b : "")
            + (c ? "; secure" : "")
}
function getcookie(c) {
    c = cookiepre + c;
    var b = document.cookie.indexOf(c);
    var a = document.cookie.indexOf(";", b);
    return b == -1 ? "" : unescape(document.cookie.substring(b + c.length + 1,
            (a > b ? a : document.cookie.length)))
}
function thumbImg(c, d) {
    if (!c) {
        return
    }
    c.onload = null;
    file = c.src;
    zw = c.offsetWidth;
    zh = c.offsetHeight;
    if (zw < 2) {
        if (!c.id) {
            c.id = "img_" + Math.random()
        }
        setTimeout("thumbImg(document.getElementById('" + c.id + "'), " + d
                + ")", 100);
        return
    }
    zr = zw / zh;
    d = !d ? 0 : 1;
    if (d) {
        fixw = c.getAttribute("_width");
        fixh = c.getAttribute("_height");
        if (zw > fixw) {
            zw = fixw;
            zh = zw / zr
        }
        if (zh > fixh) {
            zh = fixh;
            zw = zh * zr
        }
    } else {
        var b = isUndefined(b) ? "600" : b;
        var a = b.split("%");
        if (a.length > 1) {
            fixw = document.getElementById("wrap").clientWidth - 200;
            if (a[0]) {
                fixw = fixw * a[0] / 100
            } else {
                if (a[1]) {
                    fixw = fixw < a[1] ? fixw : a[1]
                }
            }
        } else {
            fixw = a[0]
        }
        if (zw > fixw) {
            zw = fixw;
            zh = zw / zr;
            c.style.cursor = "pointer";
            if (!c.onclick) {
                c.onclick = function() {
                    zoom(c, c.src)
                }
            }
        }
    }
    c.width = zw;
    c.height = zh
}
var zoomclick = 0, zoomstatus = 1;
function zoom(c, f) {
    f = !f ? c.src : f;
    if (!zoomstatus) {
        window.open(f, "", "");
        return
    }
    if (!c.id) {
        c.id = "img_" + Math.random()
    }
    var d = c.id + "_zmenu";
    var a = document.getElementById(d);
    var l = d + "_img";
    var g = d + "_zimg";
    var b = (document.documentElement.clientHeight ? document.documentElement.clientHeight
            : document.body.clientHeight) - 70;
    if (!a) {
        a = document.createElement("div");
        a.id = d;
        var h = fetchOffset(c);
        a.innerHTML = "<div onclick=\"document.getElementById('append_parent').removeChild(document.getElementById('"
                + c.id
                + '_zmenu\'))" style="z-index:600;filter:alpha(opacity=50);opacity:0.5;background:#FFF;position:absolute;width:'
                + c.clientWidth
                + "px;height:"
                + c.clientHeight
                + "px;left:"
                + h.left
                + "px;top:"
                + h.top
                + 'px"><table width="100%" height="100%"><tr><td valign="middle" align="center"><img src="'
                + IMGDIR
                + '/loading.gif" /></td></tr></table></div><div style="position:absolute;top:-100000px;display:none"><img id="'
                + l + '" src="' + f + '"></div>';
        document.getElementById("append_parent").appendChild(a);
        document.getElementById(l).onload = function() {
            document.getElementById(l).parentNode.style.display = "";
            var p = document.getElementById(l).width;
            var q = document.getElementById(l).height;
            var o = p / q;
            var m = document.body.clientWidth * 0.95;
            m = p > m ? m : p;
            var n = m / o;
            if (n > b) {
                n = b;
                m = n * o
            }
            document.getElementById("append_parent").removeChild(a);
            a = document.createElement("div");
            a.id = d;
            a.style.overflow = "visible";
            a.style.width = (m < 300 ? 300 : m) + 20 + "px";
            a.style.height = n + 50 + "px";
            a.innerHTML = '<div class="zoominner"><p id="'
                    + d
                    + '_ctrl"><span class="y"><a href="'
                    + f
                    + '" class="imglink" target="_blank" title="在新窗口打开">在新窗口打开</a><a href="#" id="'
                    + d
                    + '_adjust" class="imgadjust" title="实际大小">实际大小</a><a href="javascript:;" onclick="hideMenu()" class="imgclose" title="关闭">关闭</a></span>鼠标滚轮缩放图片</p><div align="center" onmousedown="zoomclick=1" onmousemove="zoomclick=2" onmouseup="if(zoomclick==1) hideMenu()"><img id="'
                    + g + '" src="' + f + '" width="' + m + '" height="' + n
                    + '" w="' + p + '" h="' + q + '"></div></div>';
            document.getElementById("append_parent").appendChild(a);
            document.getElementById(d + "_adjust").onclick = function(r) {
                j(r, 1)
            };
            if (a.addEventListener) {
                a.addEventListener("DOMMouseScroll", j, false)
            }
            a.onmousewheel = j;
            showMenu({
                menuid : d,
                duration : 3,
                pos : "00",
                cover : 1,
                drag : d,
                maxh : b + 70
            })
        }
    } else {
        showMenu({
            menuid : d,
            duration : 3,
            pos : "00",
            cover : 1,
            drag : d,
            maxh : a.clientHeight
        })
    }
    if (BROWSER.ie) {
        doane(event)
    }
    var j = function(q, m) {
        var o = document.getElementById(g).getAttribute("w");
        var r = document.getElementById(g).getAttribute("h");
        var p = o / 10;
        var n = r / 10;
        if (!m) {
            if (!q) {
                q = window.event
            }
            if (q.altKey || q.shiftKey || q.ctrlKey) {
                return
            }
            if (q.wheelDelta <= 0 || q.detail > 0) {
                if (document.getElementById(g).width - p <= 200
                        || document.getElementById(g).height - n <= 200) {
                    doane(q);
                    return
                }
                document.getElementById(g).width -= p;
                document.getElementById(g).height -= n
            } else {
                if (document.getElementById(g).width + p >= o) {
                    doane(q);
                    return
                }
                document.getElementById(g).width += p;
                document.getElementById(g).height += n
            }
        } else {
            document.getElementById(g).width = o;
            document.getElementById(g).height = r
        }
        a.style.width = (parseInt(document.getElementById(g).width < 300 ? 300
                : parseInt(document.getElementById(g).width)) + 20)
                + "px";
        a.style.height = (parseInt(document.getElementById(g).height) + 50)
                + "px";
        setMenuPosition("", d, "00");
        doane(q)
    }
}
function showMenu(n) {
    var B = isUndefined(n.ctrlid) ? n : n.ctrlid;
    var c = isUndefined(n.showid) ? B : n.showid;
    var j = isUndefined(n.menuid) ? c + "_menu" : n.menuid;
    var t = document.getElementById(B);
    var z = document.getElementById(j);
    if (!z) {
        return
    }
    var m = isUndefined(n.mtype) ? "menu" : n.mtype;
    var q = isUndefined(n.evt) ? "mouseover" : n.evt;
    var d = isUndefined(n.pos) ? "43" : n.pos;
    var A = isUndefined(n.layer) ? 1 : n.layer;
    var a = isUndefined(n.duration) ? 2 : n.duration;
    var l = isUndefined(n.timeout) ? 250 : n.timeout;
    var o = isUndefined(n.maxh) ? 600 : n.maxh;
    var p = isUndefined(n.cache) ? 1 : n.cache;
    var x = isUndefined(n.drag) ? "" : n.drag;
    var w = x && document.getElementById(x) ? document.getElementById(x) : z;
    var u = isUndefined(n.fade) ? 0 : n.fade;
    var y = isUndefined(n.cover) ? 0 : n.cover;
    var g = isUndefined(n.zindex) ? JSMENU.zIndex["menu"] : n.zindex;

    g = y ? g + 200 : g;
    if (typeof JSMENU.active[A] == "undefined") {
        JSMENU.active[A] = []
    }
    if (q == "click" && in_array(j, JSMENU.active[A]) && m != "win") {
        hideMenu(j, m);
        return
    }
    if (m == "menu") {
        hideMenu(A, m)
    }
    if (t) {
        if (!t.initialized) {
            t.initialized = true;
            t.unselectable = true;
            t.outfunc = typeof t.onmouseout == "function" ? t.onmouseout : null;
            t.onmouseout = function() {
                if (this.outfunc) {
                    this.outfunc()
                }
                if (a < 3 && !JSMENU.timer[j]) {
                    JSMENU.timer[j] = setTimeout("hideMenu('" + j + "', '" + m
                            + "')", l)
                }
            };
            t.overfunc = typeof t.onmouseover == "function" ? t.onmouseover
                    : null;
            t.onmouseover = function(D) {
                doane(D);
                if (this.overfunc) {
                    this.overfunc()
                }
                if (q == "click") {
                    clearTimeout(JSMENU.timer[j]);
                    JSMENU.timer[j] = null
                } else {
                    for ( var C in JSMENU.timer) {
                        if (JSMENU.timer[C]) {
                            clearTimeout(JSMENU.timer[C]);
                            JSMENU.timer[C] = null
                        }
                    }
                }
            }
        }
    }
    var b = function(D, E, F) {
        E = E ? E : window.event;
        if (F == 1) {
            if (in_array(BROWSER.ie ? E.srcElement.tagName : E.target.tagName,
                    [ "TEXTAREA", "INPUT", "BUTTON", "SELECT" ])) {
                return
            }
            JSMENU.drag = [ E.clientX, E.clientY ];
            JSMENU.drag[2] = parseInt(D.style.left);
            JSMENU.drag[3] = parseInt(D.style.top);
            document.onmousemove = function(H) {
                try {
                    b(D, H, 2)
                } catch (G) {
                }
            };
            document.onmouseup = function(H) {
                try {
                    b(D, H, 3)
                } catch (G) {
                }
            };
            doane(E)
        } else {
            if (F == 2 && JSMENU.drag[0]) {
                var C = [ E.clientX, E.clientY ];
                D.style.left = (JSMENU.drag[2] + C[0] - JSMENU.drag[0]) + "px";
                D.style.top = (JSMENU.drag[3] + C[1] - JSMENU.drag[1]) + "px";
                doane(E)
            } else {
                if (F == 3) {
                    JSMENU.drag = [];
                    document.onmousemove = null;
                    document.onmouseup = null
                }
            }
        }
    };
    if (!z.initialized) {
        z.initialized = true;
        z.ctrlkey = B;
        z.mtype = m;
        z.layer = A;
        z.cover = y;
        if (t && t.getAttribute("fwin")) {
            z.scrolly = true
        }
        z.style.position = "absolute";
        z.style.zIndex = g + A;
        z.onclick = function(C) {
            if (!C || BROWSER.ie) {
                window.event.cancelBubble = true;
                return window.event
            } else {
                C.stopPropagation();
                return C
            }
        };
        if (a < 3) {
            if (a > 1) {
                z.onmouseover = function() {
                    clearTimeout(JSMENU.timer[j]);
                    JSMENU.timer[j] = null
                }
            }
            if (a != 1) {
                z.onmouseout = function() {
                    JSMENU.timer[j] = setTimeout("hideMenu('" + j + "', '" + m
                            + "')", l)
                }
            }
        }
        if (y) {
            var h = document.createElement("div");
            h.id = j + "_cover";
            h.style.position = "absolute";
            h.style.zIndex = z.style.zIndex - 1;
            h.style.left = h.style.top = "0px";
            h.style.width = "100%";
            h.style.height = Math.max(document.documentElement.clientHeight,
                    document.body.scrollHeight)
                    + "px";
            h.style.backgroundColor = "#000";
            h.style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity=50)";
            h.style.opacity = 0.5;
            h.onclick = function() {
                hideMenu()
            };
            document.getElementById("append_parent").appendChild(h);
            _attachEvent(window, "load", function() {
                h.style.height = Math.max(
                        document.documentElement.clientHeight,
                        document.body.scrollHeight)
                        + "px"
            }, document)
        }
    }
    if (x) {
        w.style.cursor = "move";
        w.onmousedown = function(C) {
            try {
                b(z, C, 1)
            } catch (D) {
            }
        }
    }
    z.style.display = "";
    if (y) {
        document.getElementById(j + "_cover").style.display = ""
    }
    if (u) {
        var f = 0;
        var r = function(C) {
            if (C == 100) {
                clearTimeout(D);
                return
            }
            z.style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity="
                    + C + ")";
            z.style.opacity = C / 100;
            C += 10;
            var D = setTimeout(function() {
                r(C)
            }, 50)
        };
        r(f);
        z.fade = true
    } else {
        z.fade = false
    }
    setMenuPosition(c, j, d);
    if (o && z.scrollHeight > o) {
        z.style.height = o + "px";
        if (BROWSER.opera) {
            z.style.overflow = "auto"
        } /*else {
            z.style.overflowY = "auto"
        }*/
    }
    if (!a) {
        setTimeout("hideMenu('" + j + "', '" + m + "')", l)
    }
    if (!in_array(j, JSMENU.active[A])) {
        JSMENU.active[A].push(j)
    }
    z.cache = p;
    if (A > JSMENU.layer) {
        JSMENU.layer = A
    }
}
function setMenuPosition(c, f, h) {
    function m(o) {
        while ((o = o.offsetParent) != null) {
            if (o.style.position == "absolute") {
                return 2
            }
        }
        return 1
    }
    var l = document.getElementById(c);
    var g = f ? document.getElementById(f) : document.getElementById(c
            + "_menu");
    if (isUndefined(h)) {
        h = "43"
    }
    var a = parseInt(h.substr(0, 1));
    var j = parseInt(h.substr(1, 1));
    var n = sx = sy = sw = sh = ml = mt = mw = mcw = mh = mch = bpl = bpt = 0;
    if (!g || (a > 0 && !l)) {
        return
    }
    if (l) {
        n = fetchOffset(l, BROWSER.ie && BROWSER.ie < 7 ? m(g) : 0);
        sx = n.left;
        sy = n.top;
        sw = l.offsetWidth;
        sh = l.offsetHeight
    }
    mw = g.offsetWidth;
    mcw = g.clientWidth;
    mh = g.offsetHeight;
    mch = g.clientHeight;
    switch (a) {
    case 1:
        bpl = sx;
        bpt = sy;
        break;
    case 2:
        bpl = sx + sw;
        bpt = sy;
        break;
    case 3:
        bpl = sx + sw;
        bpt = sy + sh;
        break;
    case 4:
        bpl = sx;
        bpt = sy + sh;
        break
    }
    switch (j) {
    case 0:
        g.style.left = (document.body.clientWidth - g.clientWidth) / 2 + "px";
        mt = (document.documentElement.clientHeight - g.clientHeight) / 2;
        break;
    case 1:
        ml = bpl - mw;
        mt = bpt - mh;
        break;
    case 2:
        ml = bpl;
        mt = bpt - mh;
        break;
    case 3:
        ml = bpl;
        mt = bpt;
        break;
    case 4:
        ml = bpl - mw;
        mt = bpt;
        break
    }
    var b = Math.max(document.documentElement.scrollTop,
            document.body.scrollTop);
    var d = Math.max(document.documentElement.scrollLeft,
            document.body.scrollLeft);
    if (in_array(j, [ 1, 4 ]) && ml < 0) {
        ml = bpl;
        if (in_array(a, [ 1, 4 ])) {
            ml += sw
        }
    } else {
        if (ml + mw > d + document.body.clientWidth && sx >= mw) {
            ml = bpl - mw;
            if (in_array(a, [ 2, 3 ])) {
                ml -= sw
            }
        }
    }
    if (in_array(j, [ 1, 2 ]) && mt < 0) {
        mt = bpt;
        if (in_array(a, [ 1, 2 ])) {
            mt += sh
        }
    } else {
        if (mt + mh > b + document.documentElement.clientHeight && sy >= mh) {
            mt = bpt - mh;
            if (in_array(a, [ 3, 4 ])) {
                mt -= sh
            }
        }
    }
    if (h == "210") {
        ml += 69 - sw / 2;
        mt -= 5;
        if (l.tagName == "TEXTAREA") {
            ml -= sw / 2;
            mt += sh / 2
        }
    }
    if (j == 0 || g.scrolly) {
        if (BROWSER.ie && BROWSER.ie < 7) {
            if (j == 0) {
                mt += b
            }
        } else {
            if (g.scrolly) {
                mt -= b
            }
            g.style.position = "fixed"
        }
    }
    if (ml) {
        g.style.left = ml + "px"
    }
    if (mt) {
        g.style.top = mt + "px"
    }
    if (j == 0 && BROWSER.ie && !document.documentElement.clientHeight) {
        g.style.position = "absolute";
        g.style.top = (document.body.clientHeight - g.clientHeight) / 2 + "px"
    }
    if (g.style.clip && !BROWSER.opera) {
        g.style.clip = "rect(auto, auto, auto, auto)"
    }
}
function doane(a) {
    e = a ? a : window.event;
    if (!e) {
        e = getEvent()
    }
    if (BROWSER.ie) {
        e.returnValue = false;
        e.cancelBubble = true
    } else {
        if (e) {
            e.stopPropagation();
            e.preventDefault()
        }
    }
}
function _attachEvent(d, b, c, a) {
    a = !a ? d : a;
    if (d.addEventListener) {
        d.addEventListener(b, c, false)
    } else {
        if (a.attachEvent) {
            d.attachEvent("on" + b, c)
        }
    }
}
function _detachEvent(d, b, c, a) {
    a = !a ? d : a;
    if (d.removeEventListener) {
        d.removeEventListener(b, c, false)
    } else {
        if (a.detachEvent) {
            d.detachEvent("on" + b, c)
        }
    }
}
function fetchOffset(f, h) {
    var b = 0, a = 0, h = !h ? 0 : h;
    if (f.getBoundingClientRect && !h) {
        var c = f.getBoundingClientRect();
        var d = Math.max(document.documentElement.scrollTop,
                document.body.scrollTop);
        var g = Math.max(document.documentElement.scrollLeft,
                document.body.scrollLeft);
        if (document.documentElement.dir == "rtl") {
            g = g + document.documentElement.clientWidth
                    - document.documentElement.scrollWidth
        }
        b = c.left + g - document.documentElement.clientLeft;
        a = c.top + d - document.documentElement.clientTop
    }
    if (b <= 0 || a <= 0) {
        b = f.offsetLeft;
        a = f.offsetTop;
        while ((f = f.offsetParent) != null) {
            if (h == 2 && f.style.position == "absolute") {
                continue
            }
            b += f.offsetLeft;
            a += f.offsetTop
        }
    }
    return {
        left : b,
        top : a
    }
}
function hideMenu(a, l) {
    a = isUndefined(a) ? "" : a;
    //默认设成menu
    l = isUndefined(l) ? "menu" : l;
    if (a == "") {
        for ( var d = 1; d <= JSMENU.layer; d++) {
            hideMenu(d, l)
        }
        return
    } else {
        if (typeof a == "number") {
            for ( var b in JSMENU.active[a]) {
                hideMenu(JSMENU.active[a][b], l)
            }
            return
        } else {
            //参数a为元素id,string类型,比较元素的mtype是否为l,若是的话两种情况,1为不显示,2为移除,移除的条件是g.cache是否为真
            if (typeof a == "string") {
                var g = document.getElementById(a);
                if (!g || (l && g.mtype != l)) {
                    return
                }
                clearTimeout(JSMENU.timer[a]);
                var c = function() {
                    if (g.cache) {
                        g.style.display = "none";
                        if (g.cover) {
                            document.getElementById(a + "_cover").style.display = "none"
                        }
                    } else {
                        g.parentNode.removeChild(g);
                        if (g.cover) {
                            document.getElementById(a + "_cover").parentNode
                                    .removeChild(document.getElementById(a
                                            + "_cover"))
                        }
                    }
                    var m = [];
                    for ( var j in JSMENU.active[g.layer]) {
                        if (a != JSMENU.active[g.layer][j]) {
                            m.push(JSMENU.active[g.layer][j])
                        }
                    }
                    JSMENU.active[g.layer] = m
                };
                if (g.fade) {
                    var h = 100;
                    var f = function(m) {
                        if (m == 0) {
                            clearTimeout(j);
                            c();
                            return
                        }
                        g.style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity="
                                + m + ")";
                        g.style.opacity = m / 100;
                        m -= 10;
                        var j = setTimeout(function() {
                            f(m)
                        }, 50)
                    };
                    f(h)
                } else {
                    c()
                }
            }
        }
    }
}
function showDialog_mobile(msg, mode, t, func, cover, funccancel) {
    cover = isUndefined(cover) ? (mode == "info" ? 0 : 1) : cover;
    mode = in_array(mode, [ "confirm", "notice", "info", "right" ]) ? mode
            : "alert";
    var menuid = "fwin_dialog";
    var menuObj = document.getElementById(menuid);
    if (menuObj) {
        hideMenu("fwin_dialog", "dialog")
    }
    menuObj = document.createElement("div");
    menuObj.style.display = "none";
    menuObj.className = "fwinmask";
    menuObj.id = menuid;
    var mobile_cover = document.getElementById('mobile_auth_cover');
    var height = document.body.scrollHeight;
    document.getElementById("append_parent").appendChild(menuObj);
    var s = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="m_c"><h3 class="flb"><em>';
    s += t ? t : "提示信息";
    <!-- hhzhou@2012-09-03 for 关闭刷新页面 -->
    s += '</em><span><a href="javascript:;" id="fwin_dialog_close" class="flbc" onclick="hideMenu(\''
            + menuid + "', 'dialog')\" title=\"关闭\">关闭</a></span></h3>";
    /*s += mode == "confirm" ?'</em><span><a href="javascript:;" id="fwin_dialog_close" class="flbc" onclick="hideMenu(\''
            + menuid + "', 'dialog')\" title=\"关闭\">关闭</a></span></h3>"
            : '</em><span><a href="javascript:;" id="fwin_dialog_close_ex" class="flbc" onclick="hideMenu(\''
                + menuid + "', 'dialog')\" title=\"关闭\">关闭</a></span></h3>";
    */
    if (mode == "info") {
        s += msg ? msg : ""
    } else {
        s += '<div class="c'
                + (mode == "info" ? "" : " altw")
                + '"><div class="'
                + (mode == "alert" ? "alert_error"
                        : mode == "confirm" ? "confirm_info"
                                : mode == "right" ? "alert_right"
                                        : "alert_info") + '"><p>' + msg
                + "</p></div></div>";
        s += '<p class="o pns"><button id="fwin_dialog_submit" value="true" class="pn pnc"><strong>确定</strong></button>';
        s += mode == "confirm" ? '<button id="fwin_dialog_cancel" value="true" class="pn" onclick="hideMenu(\''
                + menuid + "', 'dialog')\"><strong>取消</strong></button>"
                : "";
        s += "</p>"
    }
    s += '</td></tr></table>';
    menuObj.innerHTML = s;
    if (document.getElementById("fwin_dialog_submit")) {
        document.getElementById("fwin_dialog_submit").onclick = function() {
            if (typeof func == "function") {
                func()
            } else {
                eval(func)
            }
            hideMenu(menuid, "dialog")
        };
        document.getElementById("fwin_dialog_close").onclick = document
        .getElementById("fwin_dialog_submit").onclick
    }
    if (document.getElementById("fwin_dialog_cancel")) {
        document.getElementById("fwin_dialog_cancel").onclick = function() {
            if (typeof funccancel == "function") {
                mobile_cover.innerHTML="<div id='fwin_dialog_cover' style='position: absolute; z-index: -10; top: 0px; left: 0px; width: 100%; height: "+height+"px; background-color: rgb(0, 0, 0); opacity: 0.0;'></div>";

                funccancel()
            } else {
                mobile_cover.innerHTML="<div id='fwin_dialog_cover' style='position: absolute; z-index: -10; top: 0px; left: 0px; width: 100%; height: "+height+"px; background-color: rgb(0, 0, 0); opacity: 0.0;'></div>";

                eval(funccancel)
            }
            hideMenu(menuid, "dialog")
        };
        document.getElementById("fwin_dialog_close").onclick = document
                .getElementById("fwin_dialog_cancel").onclick
    }
    showMenu({
        mtype : "dialog",
        menuid : menuid,
        duration : 3,
        pos : "00",
        zindex : JSMENU.zIndex["dialog"],
        cache : 0,
        cover : cover
    })
}

function showDialog1(msg, mode, t, func, cover, funccancel) {
    if (isNaN(uid) || uid == 0) {
        showWindow('message', '/index.php?do=login_window');
    }
    else{
        showDialog(msg,mode,t,func,cover,funccancel);
    }
}

function showDialog(msg, mode, t, func, cover, funccancel) {
    cover = isUndefined(cover) ? (mode == "info" ? 0 : 1) : cover;
    mode = in_array(mode, [ "confirm", "notice", "info", "right" ]) ? mode : "alert";
    var menuid = "fwin_dialog";
    var menuObj = document.getElementById(menuid);
    if (menuObj) {
        hideMenu("fwin_dialog", "dialog")
    }
    menuObj = document.createElement("div");
    menuObj.style.display = "none";
    menuObj.className = "fwinmask";
    menuObj.id = menuid;
    document.getElementById("append_parent").appendChild(menuObj);
    var s = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="m_c"><h3 class="flb"><em>';
    s += t ? t : "提示信息";
    <!-- hhzhou@2012-09-03 for 关闭刷新页面 -->
    s += '</em><span><a href="javascript:;" id="fwin_dialog_close" class="flbc" onclick="hideMenu(\''
            + menuid + "', 'dialog')\" title=\"关闭\">关闭</a></span></h3>";
    /*s += mode == "confirm" ?'</em><span><a href="javascript:;" id="fwin_dialog_close" class="flbc" onclick="hideMenu(\''
            + menuid + "', 'dialog')\" title=\"关闭\">关闭</a></span></h3>"
            : '</em><span><a href="javascript:;" id="fwin_dialog_close_ex" class="flbc" onclick="hideMenu(\''
                + menuid + "', 'dialog')\" title=\"关闭\">关闭</a></span></h3>";
    */
//    if (mode == "info") {
//        s += msg ? msg : ""
//    } else {
        s += '<div class="c altw'
                //+ (mode == "info" ? "" : " altw")
                + '"><div class="'
                + (mode == "alert" ? "alert_error"
                        : mode == "confirm" ? "confirm_info"
                                : mode == "right" ? "alert_right"
                                        : "alert_info") + '"><p>' + msg
                + "</p></div></div>";
        s += '<p class="o pns"><button id="fwin_dialog_submit" value="true" class="pn pnc"><strong>确定</strong></button>';
        s += mode == "confirm" ? '<button id="fwin_dialog_cancel" value="true" class="pn" onclick="hideMenu(\''
                + menuid + "', 'dialog')\"><strong>取消</strong></button>"
                : "";
        s += "</p>"
//    }
    s += '</td></tr></table>';
    menuObj.innerHTML = s;
    if (document.getElementById("fwin_dialog_submit")) {
        document.getElementById("fwin_dialog_submit").onclick = function() {
            hideMenu(menuid, "dialog")
            if (typeof func == "function") {
                func()
            } else {
                $result = msg.indexOf("手机认证");
                if($result > 0){
                    func = "location.href = 'http://account.vsochina.com/auth/mobile'";
                }
                eval(func)
            }

        };
        document.getElementById("fwin_dialog_close").onclick = document
        .getElementById("fwin_dialog_submit").onclick
    }
    if (document.getElementById("fwin_dialog_cancel")) {
        document.getElementById("fwin_dialog_cancel").onclick = function() {
            if (typeof funccancel == "function") {
                funccancel()
            } else {
                eval(funccancel)
            }
            hideMenu(menuid, "dialog")
        };
        document.getElementById("fwin_dialog_close").onclick = document
                .getElementById("fwin_dialog_cancel").onclick
    }
    showMenu({
        mtype : "dialog",
        menuid : menuid,
        duration : 3,
        pos : "00",
        zindex : JSMENU.zIndex["dialog"],
        cache : 0,
        cover : cover
    })
}

function showDialog_code(msg, mode, t, func, cover, funccancel, code) {
    cover = isUndefined(cover) ? (mode == "info" ? 0 : 1) : cover;
    mode = in_array(mode, [ "confirm", "notice", "info", "right" ]) ? mode
            : "alert";
    var menuid = "fwin_dialog";
    var menuObj = document.getElementById(menuid);
    if (menuObj) {
        hideMenu("fwin_dialog", "dialog")
    }
    menuObj = document.createElement("div");
    menuObj.style.display = "none";
    menuObj.className = "fwinmask";
    menuObj.id = menuid;
    document.getElementById("append_parent").appendChild(menuObj);
    var s = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="m_c"><h3 class="flb"><em>';
    var m = '<ul class="cgjoy_box">'+
            '<li>你的激活码是<span id="code_info">'+code+'</span></li>'+
            '<li  class="cgjoy_box_btn"><a onclick="setCopy(\''+code+'\',\'复制成功\');">点击复制</a></li>'+
            '<li class="font18">赶紧去<a href="/index.php?do=pre_res">注册账号&gt;&gt;</a></li>'+
            '<li class="cgjoy_tip">注册页面中的优惠卡注册选项可使用获得的 激活码进行注册并获得创意币。</li>'+
        '</ul>';
    s += t ? t : "提示信息";
    <!-- hhzhou@2012-09-03 for 关闭刷新页面 -->
    s += '</em><span><a href="javascript:;" id="fwin_dialog_close" class="flbc" onclick="hideMenu(\''
            + menuid + "', 'dialog')\" title=\"关闭\">关闭</a></span></h3>";
    /*s += mode == "confirm" ?'</em><span><a href="javascript:;" id="fwin_dialog_close" class="flbc" onclick="hideMenu(\''
            + menuid + "', 'dialog')\" title=\"关闭\">关闭</a></span></h3>"
            : '</em><span><a href="javascript:;" id="fwin_dialog_close_ex" class="flbc" onclick="hideMenu(\''
                + menuid + "', 'dialog')\" title=\"关闭\">关闭</a></span></h3>";
    */
    if (mode == "info") {
        s += msg ? msg : ""
    } else {
        s += '<div class="c'
                + (mode == "info" ? "" : " altw")
                + '"><div class="'
                + (mode == "alert" ? "alert_error"
                        : mode == "confirm" ? "confirm_info"
                                : mode == "right" ? "alert_right"
                                        : "alert_info") + '"><p>' + msg
                + "</p>"+m+"</div></div>";
        s += '<p class="o pns"><button id="fwin_dialog_submit" value="true" class="pn pnc"><strong>确定</strong></button>';
        s += mode == "confirm" ? '<button id="fwin_dialog_cancel" value="true" class="pn" onclick="hideMenu(\''
                + menuid + "', 'dialog')\"><strong>取消</strong></button>"
                : "";
        s += "</p>"
    }
    s += '</td></tr></table>';
    menuObj.innerHTML = s;
    if (document.getElementById("fwin_dialog_submit")) {
        document.getElementById("fwin_dialog_submit").onclick = function() {
            hideMenu(menuid, "dialog")
            if (typeof func == "function") {
                func()
            } else {
                $result = msg.indexOf("手机认证");
                if($result > 0){
                    func = "location.href = 'http://account.vsochina.com/auth/mobile'";
                }
                eval(func)
            }

        };
        document.getElementById("fwin_dialog_close").onclick = document
        .getElementById("fwin_dialog_submit").onclick
    }
    if (document.getElementById("fwin_dialog_cancel")) {
        document.getElementById("fwin_dialog_cancel").onclick = function() {
            if (typeof funccancel == "function") {
                funccancel()
            } else {
                eval(funccancel)
            }
            hideMenu(menuid, "dialog")
        };
        document.getElementById("fwin_dialog_close").onclick = document
                .getElementById("fwin_dialog_cancel").onclick
    }
    showMenu({
        mtype : "dialog",
        menuid : menuid,
        duration : 3,
        pos : "00",
        zindex : JSMENU.zIndex["dialog"],
        cache : 0,
        cover : cover
    })
}
function showDialog_act(msg, mode, t, func, cover, funccancel,service_id,user_name,moo) {
    cover = isUndefined(cover) ? (mode == "info" ? 0 : 1) : cover;
    mode = in_array(mode, [ "confirm", "notice", "info", "right" ]) ? mode
            : "alert";
    var menuid = "fwin_dialog";
    var menuObj = document.getElementById(menuid);
    if (menuObj) {
        hideMenu("fwin_dialog", "dialog")
    }
    menuObj = document.createElement("div");
    menuObj.style.display = "none";
    menuObj.className = "fwinmask";
    menuObj.id = menuid;
    document.getElementById("append_parent").appendChild(menuObj);
    var s = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="m_c"><h3 class="flb"><em>';
    var m="<a href='/index.php?do=service&sid="+service_id+"'><button class='tip_b'>查看</button></a>您投票的参赛作品编号：<span>"+service_id+"</span> <br/>参赛选手：<span>"+user_name+"</span><br/>您可以：<br/><a href='/activity/view/ipsocc/op/ipsocc_vote/ko/"+moo+".html'>欣赏其他参赛作品</a><a href='/index.php?do=creation'>开始创意空间</a><a href='/index.php'>返回首页</a>";
    if(mode=='alert')
    {
    var m="<p>每个IP地址，每隔两小时可以投票一次！</p><p>体验“创意云”，感受更多精彩！</p>您可以：<br/><a href='/activity/view/ipsocc/op/ipsocc_vote/ko/"+moo+".html'>欣赏其他参赛作品</a><a href='/index.php?do=creation'>开始创意空间</a><a href='/index.php'>返回首页</a>";
    }
    s += t ? t : "提示信息";
    s += '</em><span><a href="javascript:;" id="fwin_dialog_close" class="flbc" onclick="hideMenu(\''
            + menuid + "', 'dialog')\" title=\"关闭\">关闭</a></span></h3>";
    if (mode == "info") {
        s += msg ? msg : ""
    } else {
        s += '<div class="c'
                + (mode == "info" ? "" : " altw")
                + '"><div class="'
                + (mode == "alert" ? "alert_error"
                        : mode == "confirm" ? "confirm_info"
                                : mode == "right" ? "alert_right"
                                        : "alert_info") + '"><p class="tip_p">' + msg
                + "</p>"+m+"</div></div>";
        s += '<p class="o pns"><button id="fwin_dialog_submit" value="true" class="pn pnc"><strong>确定</strong></button>';
        s += mode == "confirm" ? '<button id="fwin_dialog_cancel" value="true" class="pn" onclick="hideMenu(\''
                + menuid + "', 'dialog')\"><strong>取消</strong></button>"
                : "";
        s += "</p>"
    }
    s += '</td></tr></table>';
    menuObj.innerHTML = s;
    if (document.getElementById("fwin_dialog_submit")) {
        document.getElementById("fwin_dialog_submit").onclick = function() {
            hideMenu(menuid, "dialog")
            if (typeof func == "function") {
                func()
            } else {
                $result = msg.indexOf("手机认证");
                if($result > 0){
                    func = "location.href = 'http://account.vsochina.com/auth/mobile'";
                }
                eval(func)
            }

        };
        document.getElementById("fwin_dialog_close").onclick = document
        .getElementById("fwin_dialog_submit").onclick
    }
    if (document.getElementById("fwin_dialog_cancel")) {
        document.getElementById("fwin_dialog_cancel").onclick = function() {
            if (typeof funccancel == "function") {
                funccancel()
            } else {
                eval(funccancel)
            }
            hideMenu(menuid, "dialog")
        };
        document.getElementById("fwin_dialog_close").onclick = document
                .getElementById("fwin_dialog_cancel").onclick
    }
    showMenu({
        mtype : "dialog",
        menuid : menuid,
        duration : 3,
        pos : "00",
        zindex : JSMENU.zIndex["dialog"],
        cache : 0,
        cover : cover
    })
}
function showDialog_download(msg, mode, t, func, cover, funccancel) {
    cover = isUndefined(cover) ? (mode == "info" ? 0 : 1) : cover;
    mode = in_array(mode, [ "confirm", "notice", "info", "right" ]) ? mode
            : "alert";
    var menuid = "fwin_dialog";
    var menuObj = document.getElementById(menuid);
    if (menuObj) {
        hideMenu("fwin_dialog", "dialog")
    }
    menuObj = document.createElement("div");
    menuObj.style.display = "none";
    menuObj.className = "fwinmask";
    menuObj.id = menuid;
    document.getElementById("append_parent").appendChild(menuObj);
    var s = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="m_c"><h3 class="flb"><em>';
    s += t ? t : "提示信息";
    <!-- hhzhou@2012-09-03 for 关闭刷新页面 -->
    s += '</em><span><a href="javascript:;" id="fwin_dialog_close" class="flbc" onclick="hideMenu(\''
            + menuid + "', 'dialog')\" title=\"关闭\">关闭</a></span></h3>";
    if (mode == "info") {
        s += msg ? msg : ""
    } else {
        s += '<div class="c'
                + (mode == "info" ? "" : " altw")
                + '"><div class="'
                + (mode == "alert" ? "alert_error"
                        : mode == "confirm" ? "confirm_info"
                                : mode == "right" ? "alert_right"
                                        : "alert_info") + '"><p>' + msg
                + "</p></div></div>";
        s += '<p class="o pns"><button id="fwin_dialog_submit" value="true" class="pn pnc"><strong>下载</strong></button>';
        s += mode == "confirm" ? '<button id="fwin_dialog_cancel" value="true" class="pn" onclick="hideMenu(\''
                + menuid + "', 'dialog')\"><strong>取消</strong></button>"
                : "";
        s += "</p>"
    }
    s += '</td></tr></table>';
    menuObj.innerHTML = s;
    if (document.getElementById("fwin_dialog_submit")) {
        document.getElementById("fwin_dialog_submit").onclick = function() {
            hideMenu(menuid, "dialog")
            if (typeof func == "function") {
                func()
            } else {
                $result = msg.indexOf("手机认证");
                if($result > 0){
                    func = "location.href = 'http://account.vsochina.com/auth/mobile'";
                }
                eval(func)
            }

        };
        document.getElementById("fwin_dialog_close").onclick = document
        .getElementById("fwin_dialog_submit").onclick
    }
    if (document.getElementById("fwin_dialog_cancel")) {
        document.getElementById("fwin_dialog_cancel").onclick = function() {
            if (typeof funccancel == "function") {
                funccancel()
            } else {
                eval(funccancel)
            }
            hideMenu(menuid, "dialog")
        };
        document.getElementById("fwin_dialog_close").onclick = document
                .getElementById("fwin_dialog_cancel").onclick
    }
    showMenu({
        mtype : "dialog",
        menuid : menuid,
        duration : 3,
        pos : "00",
        zindex : JSMENU.zIndex["dialog"],
        cache : 0,
        cover : cover
    })
}

function showDialog_from_studio(msg, mode, t, func, cover, funccancel) {
    cover = isUndefined(cover) ? (mode == "info" ? 0 : 1) : cover;
    mode = in_array(mode, [ "confirm", "notice", "info", "right" , "alerting" ]) ? mode
            : "alert";
    var menuid = "fwin_dialog";
    var menuObj = document.getElementById(menuid);
    if (menuObj) {
        hideMenu("fwin_dialog", "dialog")
    }
    menuObj = document.createElement("div");
    menuObj.style.display = "none";
    menuObj.className = "fwinmask";
    menuObj.id = menuid;
    document.getElementById("append_parent").appendChild(menuObj);
    var s = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="m_c"><h3 class="flb"><em>';
    s += t ? t : "提示信息";
    <!-- hhzhou@2012-09-03 for 关闭刷新页面 -->
    s += '</em><span><a href="javascript:;" id="fwin_dialog_close" class="flbc" onclick="hideMenu(\''
            + menuid + "', 'dialog')\" title=\"关闭\">关闭</a></span></h3>";
    /*s += mode == "confirm" ?'</em><span><a href="javascript:;" id="fwin_dialog_close" class="flbc" onclick="hideMenu(\''
            + menuid + "', 'dialog')\" title=\"关闭\">关闭</a></span></h3>"
            : '</em><span><a href="javascript:;" id="fwin_dialog_close_ex" class="flbc" onclick="hideMenu(\''
                + menuid + "', 'dialog')\" title=\"关闭\">关闭</a></span></h3>";
    */
    if (mode == "info") {
        s += msg ? msg : ""
    } else {
        s += '<div class="c'
                + (mode == "info" ? "" : " altw")
                + '"><div class="'
                + (mode == "alert" ? "alert_error"
                        : mode == "confirm" ? "confirm_info"
                                         : mode == "alerting"?"alerting_info"
                                : mode == "right" ? "alert_right"
                                        : "alert_info") + '"><p>' + msg
                + "</p></div></div>";
        s += '<p class="o pns">';
        s += mode == "alerting" ? '<button id="fwin_dialog_cancel" value="true" class="pn" onclick="hideMenu(\''
                + menuid + "', 'dialog')\"><strong>关闭</strong></button>"
                : "";
        s += "</p>"
    }
    s += '</td></tr></table>';
    menuObj.innerHTML = s;
    if (document.getElementById("fwin_dialog_submit")) {
        document.getElementById("fwin_dialog_submit").onclick = function() {
            if (typeof func == "function") {
                func()
            } else {
                $result = msg.indexOf("手机认证");
                if($result > 0){
                    func = "location.href = 'http://account.vsochina.com/auth/mobile'";
                }
                eval(func)
            }
            hideMenu(menuid, "dialog")
        };
        document.getElementById("fwin_dialog_close").onclick = document
        .getElementById("fwin_dialog_submit").onclick
    }
    if (document.getElementById("fwin_dialog_cancel")) {
        document.getElementById("fwin_dialog_cancel").onclick = function() {
            if (typeof funccancel == "function") {
                funccancel()
            } else {
                eval(funccancel)
            }
            hideMenu(menuid, "dialog")
        };
        document.getElementById("fwin_dialog_close").onclick = document
                .getElementById("fwin_dialog_cancel").onclick
    }
    showMenu({
        mtype : "dialog",
        menuid : menuid,
        duration : 3,
        pos : "00",
        zindex : JSMENU.zIndex["dialog"],
        cache : 0,
        cover : cover
    })
}

function showDialogDone(msg, mode, t,r) {
    mode = in_array(mode, [ "confirm", "notice", "info", "right" ]) ? mode: "alert";
    var menuid = "fwin_dialog";
    var menuObj = document.getElementById(menuid);
    if (menuObj) {
        hideMenu("fwin_dialog", "dialog")
    }
    menuObj = document.createElement("div");
    menuObj.style.display = "none";
    menuObj.className = "fwinmask";
    menuObj.id = menuid;
    document.getElementById("append_parent").appendChild(menuObj);
    var s = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="m_c"><h3 class="flb"><em>';
    s += t ? t : "提示信息";
    s += '</em><span><a href="javascript:;" id="fwin_dialog_close" class="flbc" onclick="hideMenu(\''
            + menuid + "', 'dialog')\" title=\"关闭\">关闭</a></span></h3>";
    if (mode == "info") {
        s += msg ? msg : ""
    } else {
        s += '<div class="c'
          + (mode == "info" ? "" : " altw")
          + '"><div class="'
          + (mode == "alert" ? "alerting_error": mode == "confirm" ? "confirm_info": mode == "right" ? "alert_right": "alert_info")
          + '"><p>'
          + msg + "</p>";
        if(r == 1)//已经购买了素材
            s +='<a class="msg_link" target="_blank" onclick="hideMenu(\'fwin_dialog\',\'dialog\');" href="index.php?do=working&op=material">前往“我的素材”查看。</a>'
        else if(r == 2)//已经购买了商品
            s +='<a class="msg_link" target="_blank" onclick="hideMenu(\'fwin_dialog\',\'dialog\');" href="index.php?do=ucenter&view=shopcenter&op=order">前往“用户中心”查看。</a>';
        else if(r == 3)//已经订购了软件
            s +='<a class="msg_link" target="_blank" onclick="hideMenu(\'fwin_dialog\',\'dialog\');" href="index.php?do=working">前往“我的工作室”查看。</a>';
        else if(r == 4)//订购软件
            s +='<a class="msg_link" target="_blank" onclick="hideMenu(\'fwin_dialog\',\'dialog\');" href="index.php?do=working">前往“我的工作室”查看。</a>';
        else if(r == 5)//邀请人才
            s +='<a class="msg_link" target="_blank" onclick="hideMenu(\'fwin_dialog\',\'dialog\');" href="index.php?do=working&op=studio">前往“我的工作室”查看</a>';
        else if(r == 6)//邀请人才
            s +='<a class="msg_link" target="_blank" onclick="hideMenu(\'fwin_dialog\',\'dialog\');"href="http://create.vsochina.com/working/studio">前往我的工作室</a>';
        else if(r==7)//已经购买了服务
            s +='<a class="msg_link" target="_blank" onclick="hideMenu(\'fwin_dialog\',\'dialog\');" href="index.php?do=ucenter&view=shopcenter&op=order">前往“用户中心”查看</a>';
        else if(r==8)//已经购买了素材但未付款
            s +='<a  class="msg_link" target="_blank" onclick="hideMenu(\'fwin_dialog\',\'dialog\');" href="index.php?do=ucenter&view=createcenter&op=order&obj_type=material">前往“用户中心”查看</a>';
        else if(r==9)//要进行的操作需要认证，提示先去进行实名认证
            s +='<a  class="msg_link" target="_blank" onclick="hideMenu(\'fwin_dialog\',\'dialog\');" href="http://account.vsochina.com/auth/realname">前往“实名认证”</a>';
        else if(r==10)//要进行的操作需要认证，提示先去进行企业认证
            s +='<a  class="msg_link" target="_blank" onclick="hideMenu(\'fwin_dialog\',\'dialog\');" href="http://account.vsochina.com/auth/enterprise">前往“企业认证”</a>';
        s +='</div></div><p class="o pns"><button onclick="hideMenu(\'fwin_dialog\',\'dialog\');" value="true" class="pn pnc"><strong>关闭</strong></button></p>';
    }
    s += '</td></tr></table>';
    menuObj.innerHTML = s;
    showMenu({
        mtype : "dialog",
        menuid : menuid,
        duration : 5,
        pos : "00",
        zindex : JSMENU.zIndex["dialog"],
        cache : 0,
        cover : 1
    })
}

function showDialogShop(msg, mode, t, func, cover, funccancel) {
    cover = isUndefined(cover) ? (mode == "info" ? 0 : 1) : cover;
    mode = in_array(mode, [ "confirm", "notice", "info", "right" ]) ? mode
            : "alert";
    var menuid = "fwin_dialog";
    var menuObj = document.getElementById(menuid);
    if (menuObj) {
        hideMenu("fwin_dialog", "dialog")
    }
    menuObj = document.createElement("div");
    menuObj.style.display = "none";
    menuObj.className = "fwinmask";
    menuObj.id = menuid;
    document.getElementById("append_parent").appendChild(menuObj);
    var s = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="m_c"><h3 class="flb"><em>';
    s += t ? t : "提示信息";
    <!-- hhzhou@2012-09-03 for 关闭刷新页面 -->
    s += '</em><span><a href="javascript:;" id="fwin_dialog_close" class="flbc" onclick="hideMenu(\''
            + menuid + "', 'dialog')\" title=\"关闭\">关闭</a></span></h3>";
    if (mode == "info") {
        s += msg ? msg : ""
    } else {
        s += '<div class="c'
                + (mode == "info" ? "" : " altw")
                + '"><div class="'
                + (mode == "alert" ? "alert_error"
                        : mode == "confirm" ? "confirm_info"
                                : mode == "right" ? "alert_right"
                                        : "alert_info") + '"><p>' + msg
                + "</p></div></div>";
        s += '<p class="o pns"><button id="fwin_dialog_submit" value="true" class="pn pnc"><strong>确定</strong></button>';
        s += mode == "confirm" ? '<button id="fwin_dialog_cancel" value="true" class="pn" onclick="hideMenu(\''
                + menuid + "', 'dialog')\"><strong>取消</strong></button>"
                : "";
        s += "</p>"
    }
    s += '</td></tr></table>';
    menuObj.innerHTML = s;
    if (document.getElementById("fwin_dialog_submit")) {
        document.getElementById("fwin_dialog_submit").onclick = function() {
            if (typeof func == "function") {
                func()
            } else {
                $result = msg.indexOf("手机认证");
                if($result > 0){
                    func = "location.href = 'http://account.vsochina.com/auth/mobile'";
                }
                eval(func)
            }
            hideMenu(menuid, "dialog")
        };
        document.getElementById("fwin_dialog_close").onclick = document
        .getElementById("fwin_dialog_submit").onclick
    }
    if (document.getElementById("fwin_dialog_cancel")) {
        document.getElementById("fwin_dialog_cancel").onclick = function() {
            if (typeof funccancel == "function") {
                funccancel()
            } else {
                eval(funccancel)
            }
            hideMenu(menuid, "dialog")
        };
        document.getElementById("fwin_dialog_close").onclick = document
                .getElementById("fwin_dialog_cancel").onclick
    }
    showMenu({
        mtype : "dialog",
        menuid : menuid,
        duration : 3,
        pos : "00",
        zindex : JSMENU.zIndex["dialog"],
        cache : 0,
        cover : cover
    })
}

//即时会议
function showDialogCurrent_meeting(msg, mode, t, func, cover, funccancel,meeting_id) {
        cover = isUndefined(cover) ? (mode == "info" ? 0 : 1) : cover;
        mode = in_array(mode, [ "confirm", "notice", "info", "right" ]) ? mode
                : "alert";
        var menuid = "fwin_dialog";
        var menuObj = document.getElementById(menuid);
        if (menuObj) {
            hideMenu("fwin_dialog", "dialog")
        }
        menuObj = document.createElement("div");
        menuObj.style.display = "none";
        menuObj.className = "fwinmask";
        menuObj.id = menuid;
        document.getElementById("append_parent").appendChild(menuObj);
        var s = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="m_c"><h3 class="flb"><em>';
        s += t ? t : "提示信息";
        <!-- hhzhou@2012-09-03 for 关闭刷新页面 -->
        s += '</em><span><a href="javascript:;" id="fwin_dialog_close" class="flbc" onclick="hideMenu(\''
                + menuid + "', 'dialog')\" title=\"关闭\">关闭</a></span></h3>";
        if (mode == "info") {
            s += msg ? msg : ""
        } else {
            s += '<div class="c'
                    + (mode == "info" ? "" : " altw")
                    + '"><div class="'
                    + (mode == "alert" ? "alert_error"
                            : mode == "confirm" ? "confirm_info"
                                    : mode == "right" ? "alert_right"
                                            : "alert_info") + '"><p id="p_dialog">' + msg
                    + "</p></div></div>";
                                                                                                                                            //onclick="hideDialog()"
            s += '<p class="o pns"><a style="text-decoration:underline" href="javascript:;" onclick="hideDialog_back()">取消</a><a href="javascript:;" onclick="hideDialog('+meeting_id+')"><button  value="true" class="pn pnc"><strong>立即进入会议</strong></button></a>';
            s += mode == "confirm" ? '<button id="fwin_dialog_cancel" value="true" class="pn" onclick="hideMenu(\''
                    + menuid + "', 'dialog')\"><strong>取消</strong></button>"
                    : "";
            s += "</p>"
        }
        s += '</td></tr></table>';
        menuObj.innerHTML = s;
        if (document.getElementById("fwin_dialog_submit")) {
            document.getElementById("fwin_dialog_submit").onclick = function() {
                if (typeof func == "function") {
                    func()
                } else {
                    $result = msg.indexOf("手机认证");
                    if($result > 0){
                        func = "location.href = 'http://account.vsochina.com/auth/mobile'";
                    }
                    eval(func)
                }
                hideMenu(menuid, "dialog")
            };
            document.getElementById("fwin_dialog_close").onclick = document
            .getElementById("fwin_dialog_submit").onclick
        }
        if (document.getElementById("fwin_dialog_cancel")) {
            document.getElementById("fwin_dialog_cancel").onclick = function() {
                if (typeof funccancel == "function") {
                    funccancel()
                } else {
                    eval(funccancel)
                }
                hideMenu(menuid, "dialog")
            };
            document.getElementById("fwin_dialog_close").onclick = document
                    .getElementById("fwin_dialog_cancel").onclick
        }
        showMenu({
            mtype : "dialog",
            menuid : menuid,
            duration : 3,
            pos : "00",
            zindex : JSMENU.zIndex["dialog"],
            cache : 0,
            cover : cover
        })
}


function checkTime(){
    var cover = document.getElementById('pagecover');
    var studio_cover = document.getElementById('studio_cover');
    if(cover && !studio_cover){
    showDialog('源文件上传中，请稍等！',"right","提示","",0);
    cover.innerHTML="<div id='fwin_dialog_cover' style='position: absolute; z-index: 10; top: 0px; left: 0px; width: 100%; height: 1525px; background-color: rgb(0, 0, 0); opacity: 0.5;filter: alpha(opacity=50);'></div>";
    }else{
        if(!cover && studio_cover){
            showDialog('工作室删除中，请稍等！',"right","提示","",0);
            studio_cover.innerHTML="<div id='fwin_dialog_cover' style='position: absolute; z-index: 10; top: 0px; left: 0px; width: 100%; height: 1525px; background-color: rgb(0, 0, 0); opacity: 0.5;filter: alpha(opacity=50);'></div>";
            }
    }
    }
function showDialog_mengban(msg, mode, t, func, cover, funccancel) {
    cover = isUndefined(cover) ? (mode == "info" ? 0 : 1) : cover;
    mode = in_array(mode, [ "confirm", "notice", "info", "right" ]) ? mode
            : "alert";
    var menuid = "fwin_dialog";
    var menuObj = document.getElementById(menuid);
    if (menuObj) {
        hideMenu("fwin_dialog", "dialog")
    }
    menuObj = document.createElement("div");
    menuObj.style.display = "none";
    menuObj.className = "fwinmask";
    menuObj.id = menuid;
    document.getElementById("append_parent").appendChild(menuObj);
    var s = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="m_c"><h3 class="flb"><em>';
    s += t ? t : "提示信息";
    s += '</em><span><a href="javascript:;" id="fwin_dialog_close" class="flbc" onclick="hideMenu(\''
            + menuid + "', 'dialog')\" title=\"关闭\">关闭</a></span></h3>";
    if (mode == "info") {
        s += msg ? msg : ""
    } else {
        s += '<div class="c'
                + (mode == "info" ? "" : " altw")
                + '"><div class="'
                + (mode == "alert" ? "alert_error"
                        : mode == "confirm" ? "confirm_info"
                                : mode == "right" ? "alert_right"
                                        : "alert_info") + '"><p>' + msg
                + "</p></div></div>";
        s += '<p class="o pns"><button id="fwin_dialog_submit" value="true" class="pn pnc"><strong>确定</strong></button>';
        s += mode == "confirm" ? '<button id="fwin_dialog_cancel" value="true" class="pn" onclick="hideMenu(\''
                + menuid + "', 'dialog')\"><strong>取消</strong></button>"
                : "";
        s += "</p>"
    }
    s += '</td></tr></table>';
    menuObj.innerHTML = s;
    if (document.getElementById("fwin_dialog_submit")) {
        document.getElementById("fwin_dialog_submit").onclick = function() {

            if (typeof func == "function") {
                checkTime();
                func()
            } else {
                checkTime();
                eval(func)
            }
            hideMenu(menuid, "dialog");

        };
        document.getElementById("fwin_dialog_close").onclick = document
        .getElementById("fwin_dialog_submit").onclick
    }
    if (document.getElementById("fwin_dialog_cancel")) {
        document.getElementById("fwin_dialog_cancel").onclick = function() {
            if (typeof funccancel == "function") {
                funccancel()
            } else {
                eval(funccancel)
            }
            hideMenu(menuid, "dialog")
        };
        document.getElementById("fwin_dialog_close").onclick = document
                .getElementById("fwin_dialog_cancel").onclick
    }
    showMenu({
        mtype : "dialog",
        menuid : menuid,
        duration : 3,
        pos : "00",
        zindex : JSMENU.zIndex["dialog"],
        cache : 0,
        cover : cover
    })
}
//k:名称
//url:展示页面
//mode: get 或者 post
//cache: 关闭时是隐藏还是移除
function showWindow(k, url, mode, cache, menuv, recall) {
    mode = isUndefined(mode) ? "get" : mode;
    cache = isUndefined(cache) ? 1 : cache;
    var menuid = "fwin_" + k;
    var menuObj = document.getElementById(menuid);
    var drag = null;
    var loadingst = null;
    var newLocation = null;
    var k = k;
    var url = url;
    if (disallowfloat && disallowfloat.indexOf(k) != -1) {
        if (location.href.indexOf("search_key=") != -1) {
            newLocation = escape(location.href.substring(0, location.href.indexOf("search_key=") + 10)) + location.href.substring(location.href.indexOf("search_key=") + 10);
        }
        else {
            newLocation = escape(location.href);
        }
        alert(newLocation);
        if (BROWSER.ie) {
            url += (url.indexOf("?") != -1 ? "&" : "?") + "referer=" + newLocation;
        }
        location.href = url;
        return
    }
    var func = function () {
        if (typeof recall == "function") {
            recall();
        }
        else {
            eval(recall);
        }
    };
    var fetchContent = function () {
        if (mode == "get") {    // here we go
            url += (url.search(/\?/) > 0 ? "&" : "?") + "infloat=yes&handlekey=" + k;
            url += cache == -1 ? "&t=" + (+new Date()) : "";
            // url = index.php?do=studio_list&show=invite_index&username_i=sdfsd&infloat=yes&handlekey=join
            ajaxget(url, "fwin_content_" + k, "ajaxwaitid", "请稍候...", "",
                function () {
                    initMenu();
                    show();
                    func();
                });
        }
        else {
            if (mode == "post") {
                menuObj.act = document.getElementById(url).action;
                ajaxpost(url, "fwin_content_" + k, "", "", "", function () {
                    initMenu();
                    show();
                    func();
                })
            }
        }
        loadingst = setTimeout(function () {
            showDialog("", "info", '<img src="http://www.vsochina.com/' + IMGDIR + '/loading.gif"> 请稍候...')
        }, 500)
    };
    var initMenu = function () {
        clearTimeout(loadingst);
        var objs = menuObj.getElementsByTagName("*");
        var fctrlidinit = false;
        for (var i = 0; i < objs.length; i++) {
            if (objs[i].id) {
                objs[i].setAttribute("fwin", k)
            }
            if (objs[i].className == "flb" && !fctrlidinit) {
                if (!objs[i].id) {
                    objs[i].id = "fctrl_" + k;
                }
                drag = objs[i].id;
                fctrlidinit = true;
            }
        }
    };
    var show = function () {
        hideMenu("fwin_dialog", "dialog");
        v = {
            mtype: "win",
            menuid: menuid,
            duration: 3,
            pos: "00",
            zindex: menuid == "fwin_work_eidt" ? 1402 : JSMENU.zIndex["win"],
            drag: typeof drag == null ? "" : drag,
            cache: cache
        };
        for (k in menuv) {
            v[k] = menuv[k];
        }
        showMenu(v);
    };
    if (!menuObj) {
        menuObj = document.createElement("div");
        menuObj.id = menuid;
        menuObj.className = "fwinmask";
        menuObj.style.display = "none";
        document.getElementById("append_parent").appendChild(menuObj);
        menuObj.innerHTML = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="tt_l" style="height:1px;width:1px;"></td><td class="tt_c" style="height:1px;width:1px;" ondblclick="hideWindow(\''
            + k
            + '\')"></td><td class="tt_r" style="height:1px;width:1px;"></td></tr><tr><td class="m_l" style="height:1px;width:1px;" ondblclick="hideWindow(\''
            + k
            + '\')"></td><td class="m_c" style="height:auto;width:auto;background:#FFF;" id="fwin_content_'
            + k
            + '"></td><td class="m_r" style="height:1px;width:1px;"  ondblclick="hideWindow(\''
            + k
            + '\')"></td></tr><tr><td class="b_l" style="height:1px;width:1px;"></td><td class="b_c" style="height:1px;width:1px;" ondblclick="hideWindow(\''
            + k + '\')"></td><td class="b_r" style="height:1px;width:1px;" ></td></tr></table>';

        if (mode == "html") {
            document.getElementById("fwin_content_" + k).innerHTML = url;
            initMenu();
            show();
        }
        else {
            fetchContent();
        }
    }
    else {
        if ((mode == "get" && url != menuObj.url)
            || (mode == "post" && document.getElementById(url).action != menuObj.act)) {
            fetchContent();
        }
        else {
            show();
        }
    }
    doane();
}
//k:名称
//url:展示页面
//mode: get 或者 post
//cache: 关闭时是隐藏还是移除
function showWindow2(k, url, mode, cache, menuv, recall) {
    url = "/personal/goods/ajax-report";
    mode = isUndefined(mode) ? "get" : mode;
    cache = isUndefined(cache) ? 1 : cache;
    var menuid = "fwin_" + k;
    var menuObj = document.getElementById(menuid);
    var drag = null;
    var loadingst = null;
    var newLocation = null;
    var k = k;
    var url = url;
    if (disallowfloat && disallowfloat.indexOf(k) != -1) {
        if (location.href.indexOf("search_key=") != -1) {
            newLocation = escape(location.href.substring(0, location.href.indexOf("search_key=") + 10)) + location.href.substring(location.href.indexOf("search_key=") + 10);
        }
        else {
            newLocation = escape(location.href);
        }
        alert(newLocation);
        if (BROWSER.ie) {
            url += (url.indexOf("?") != -1 ? "&" : "?") + "referer=" + newLocation;
        }
        location.href = url;
        return
    }
    var func = function () {
        if (typeof recall == "function") {
            recall();
        }
        else {
            eval(recall);
        }
    };
    var fetchContent = function () {
        if (mode == "get") {    // here we go
            url += (url.search(/\?/) > 0 ? "&" : "?") + "infloat=yes&handlekey=" + k;
            url += cache == -1 ? "&t=" + (+new Date()) : "";
            // url = index.php?do=studio_list&show=invite_index&username_i=sdfsd&infloat=yes&handlekey=join
            ajax_get(url, "fwin_content_" + k, "ajaxwaitid", "请稍候...", "",
                function () {
                    initMenu();
                    show();
                    func();
                });
        }
        else {
            if (mode == "post") {
                menuObj.act = document.getElementById(url).action;
                ajaxpost(url, "fwin_content_" + k, "", "", "", function () {
                    initMenu();
                    show();
                    func();
                })
            }
        }
        loadingst = setTimeout(function () {
            showDialog("", "info", '<img src="http://www.vsochina.com/' + IMGDIR + '/loading.gif"> 请稍候...')
        }, 500)
    };
    var initMenu = function () {
        clearTimeout(loadingst);
        var objs = menuObj.getElementsByTagName("*");
        var fctrlidinit = false;
        for (var i = 0; i < objs.length; i++) {
            if (objs[i].id) {
                objs[i].setAttribute("fwin", k)
            }
            if (objs[i].className == "flb" && !fctrlidinit) {
                if (!objs[i].id) {
                    objs[i].id = "fctrl_" + k;
                }
                drag = objs[i].id;
                fctrlidinit = true;
            }
        }
    };
    var show = function () {
        hideMenu("fwin_dialog", "dialog");
        v = {
            mtype: "win",
            menuid: menuid,
            duration: 3,
            pos: "00",
            zindex: menuid == "fwin_work_eidt" ? 1402 : JSMENU.zIndex["win"],
            drag: typeof drag == null ? "" : drag,
            cache: cache
        };
        for (k in menuv) {
            v[k] = menuv[k];
        }
        showMenu(v);
    };
    if (!menuObj) {
        menuObj = document.createElement("div");
        menuObj.id = menuid;
        menuObj.className = "fwinmask";
        menuObj.style.display = "none";
        document.getElementById("append_parent").appendChild(menuObj);
        menuObj.innerHTML = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="tt_l" style="height:1px;width:1px;"></td><td class="tt_c" style="height:1px;width:1px;" ondblclick="hideWindow(\''
            + k
            + '\')"></td><td class="tt_r" style="height:1px;width:1px;"></td></tr><tr><td class="m_l" style="height:1px;width:1px;" ondblclick="hideWindow(\''
            + k
            + '\')"></td><td class="m_c" style="height:auto;width:auto;background:#FFF;" id="fwin_content_'
            + k
            + '"></td><td class="m_r" style="height:1px;width:1px;"  ondblclick="hideWindow(\''
            + k
            + '\')"></td></tr><tr><td class="b_l" style="height:1px;width:1px;"></td><td class="b_c" style="height:1px;width:1px;" ondblclick="hideWindow(\''
            + k + '\')"></td><td class="b_r" style="height:1px;width:1px;" ></td></tr></table>';

        if (mode == "html") {
            document.getElementById("fwin_content_" + k).innerHTML = url;
            initMenu();
            show();
        }
        else {
            fetchContent();
        }
    }
    else {
        if ((mode == "get" && url != menuObj.url)
            || (mode == "post" && document.getElementById(url).action != menuObj.act)) {
            fetchContent();
        }
        else {
            show();
        }
    }
    doane();
}
var obj_href;
function showWindow1(k, url,jumpurl, mode, cache, menuv, recall) {
    if (isNaN(uid) || uid == 0 ) {
        showWindow('message', '/index.php?do=login_window')
        return;
    }
    obj_href = jumpurl;
    mode = isUndefined(mode) ? "get" : mode;
    cache = isUndefined(cache) ? 1 : cache;
    var menuid = "fwin_" + k;
    var menuObj = document.getElementById(menuid);
    var drag = null;
    var loadingst = null;
    var newLocation = null;

    if (disallowfloat && disallowfloat.indexOf(k) != -1) {
        if(location.href.indexOf("search_key=")!=-1){
            newLocation = escape(location.href.substring(0,location.href.indexOf("search_key=")+10))+location.href.substring(location.href.indexOf("search_key=")+10);
        }else{
            newLocation = escape(location.href);
        }
        alert(newLocation);
        if (BROWSER.ie) {
            url += (url.indexOf("?") != -1 ? "&" : "?") + "referer="
                    + newLocation
        }
        location.href = url;
        return
    }
    var func = function() {
        if (typeof recall == "function") {
            recall();
        }
        else {
            eval(recall);
        }
    };
    var fetchContent = function() {
        if (mode == "get") {
            menuObj.url = url;
            url += (url.search(/\?/) > 0 ? "&" : "?")
                    + "infloat=yes&handlekey=" + k;
            url += cache == -1 ? "&t=" + (+new Date()) : "";
            ajaxget(url, "fwin_content_" + k, "ajaxwaitid", "请稍候...", "",
                    function() {
                        initMenu();
                        show();
                        func()
                    })
        } else {
            if (mode == "post") {
                menuObj.act = document.getElementById(url).action;
                ajaxpost(url, "fwin_content_" + k, "", "", "", function() {
                    initMenu();
                    show();
                    func()
                })
            }
        }
        loadingst = setTimeout(function() {
            showDialog("", "info", '<img src="' + IMGDIR
                    + '/loading.gif"> 请稍候...')
        }, 500)
    };
    var initMenu = function() {
        clearTimeout(loadingst);
        var objs = menuObj.getElementsByTagName("*");
        var fctrlidinit = false;
        for ( var i = 0; i < objs.length; i++) {
            if (objs[i].id) {
                objs[i].setAttribute("fwin", k)
            }
            if (objs[i].className == "flb" && !fctrlidinit) {
                if (!objs[i].id) {
                    objs[i].id = "fctrl_" + k
                }
                drag = objs[i].id;
                fctrlidinit = true
            }
        }
    };
    var show = function() {
        hideMenu("fwin_dialog", "dialog");
        v = {
            mtype : "win",
            menuid : menuid,
            duration : 3,
            pos : "00",
            zindex : JSMENU.zIndex["win"],
            drag : typeof drag == null ? "" : drag,
            cache : cache
        };
        for (k in menuv) {
            v[k] = menuv[k]
        }
//        if(check_user_login1(a)){
//            window.location.href = obj_href;
//        }else{
            showMenu(v)
//        }
    };
    if (!menuObj) {
        menuObj = document.createElement("div");
        menuObj.id = menuid;
        menuObj.className = "fwinmask";
        menuObj.style.display = "none";
        document.getElementById("append_parent").appendChild(menuObj);
        menuObj.innerHTML = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="tt_l" style="height:1px;width:1px;"></td><td class="tt_c" style="height:1px;width:1px;" ondblclick="hideWindow(\''
                + k
                + '\')"></td><td class="tt_r" style="height:1px;width:1px;"></td></tr><tr><td class="m_l" style="height:1px;width:1px;" ondblclick="hideWindow(\''
                + k
                + '\')"></td><td class="m_c" style="height:auto;width:auto;background:#FFF;" id="fwin_content_'
                + k
                + '"></td><td class="m_r" style="height:1px;width:1px;"  ondblclick="hideWindow(\''
                + k
                + '\')"></td></tr><tr><td class="b_l" style="height:1px;width:1px;"></td><td class="b_c" style="height:1px;width:1px;" ondblclick="hideWindow(\''
                + k + '\')"></td><td class="b_r" style="height:1px;width:1px;" ></td></tr></table>';
        if (mode == "html") {
            document.getElementById("fwin_content_" + k).innerHTML = url;
            initMenu();
            show()
        } else {
            fetchContent()
        }
    } else {
        if ((mode == "get" && url != menuObj.url)
                || (mode == "post" && document.getElementById(url).action != menuObj.act)) {
            fetchContent()
        } else {
            show()
        }
    }
    doane()
}
//guring:studio弹出框
//k:名称
//url:展示页面
//mode: get 或者 post
//cache: 关闭时是隐藏还是移除
function showWindow_studio(k, url, mode, cache, menuv, recall) {
    mode = isUndefined(mode) ? "get" : mode;
    cache = isUndefined(cache) ? 1 : cache;
    var menuid = "fwin_" + k;
    var menuObj = document.getElementById(menuid);
    var drag = null;
    var loadingst = null;
    var newLocation = null;
    var k = k ;
    var url = url ;

    if (disallowfloat && disallowfloat.indexOf(k) != -1) {

        if(location.href.indexOf("search_key=")!=-1){
            newLocation = escape(location.href.substring(0,location.href.indexOf("search_key=")+10))+location.href.substring(location.href.indexOf("search_key=")+10);
        }else{
            newLocation = escape(location.href);
        }
        alert(newLocation);
        if (BROWSER.ie) {
            url += (url.indexOf("?") != -1 ? "&" : "?") + "referer="
                    + newLocation
        }

        location.href = url;
        return
    }
    var func = function() {
        if (typeof recall == "function") {
            recall()
        } else {
            eval(recall)
        }
    };
    var fetchContent = function() {

        if (mode == "get") {    // here we go

            menuObj.url = url;
            url += (url.search(/\?/) > 0 ? "&" : "?")
                    + "infloat=yes&handlekey=" + k;
            url += cache == -1 ? "&t=" + (+new Date()) : "";
            ajaxget(url, "fwin_content_" + k, "ajaxwaitid", "请稍候...", "",
                    function() {
                        initMenu();
                        show();
                        func()
                    })
        } else {
            if (mode == "post") {
                menuObj.act = document.getElementById(url).action;
                ajaxpost(url, "fwin_content_" + k, "", "", "", function() {
                    initMenu();
                    show();
                    func()
                })
            }
        }
        loadingst = setTimeout(function() {
            showDialog("", "info", '<img src="' + IMGDIR
                    + '/loading.gif"> 请稍候...')
        }, 500)
    };
    var initMenu = function() {
        clearTimeout(loadingst);
        var objs = menuObj.getElementsByTagName("*");
        var fctrlidinit = false;
        for ( var i = 0; i < objs.length; i++) {
            if (objs[i].id) {
                objs[i].setAttribute("fwin", k)
            }
            if (objs[i].className == "fwin" && !fctrlidinit) {
                if (!objs[i].id) {
                    objs[i].id = "fctrl_" + k
                }
                drag = objs[i].id;
                fctrlidinit = true
            }
        }
    };
    var show = function() {
        hideMenu("fwin_dialog", "dialog");
        v = {
            mtype : "win",
            menuid : menuid,
            duration : 3,
            pos : "00",
            zindex : JSMENU.zIndex["win"],
            drag : typeof drag == null ? "" : drag,
            cache : cache,
            cover:1
        };
        for (k in menuv) {
            v[k] = menuv[k]
        }
        showMenu(v)
    };
    if (!menuObj) {
        menuObj = document.createElement("div");
        menuObj.id = menuid;
        menuObj.className = "fwinmask";
        menuObj.style.display = "none";
        document.getElementById("append_parent").appendChild(menuObj);
        menuObj.innerHTML = '<table cellpadding="0" cellspacing="0" class="fwin" id="fwin_table_'+k+'"><tr><td style="height:1px;width:1px;"></td><td style="height:1px;width:1px;" ondblclick="hideWindow(\''
                + k
                + '\')"></td><td style="height:1px;width:1px;"></td></tr><tr><td style="height:1px;width:1px;" ondblclick="hideWindow(\''
                + k
                + '\')"></td><td style="height:1px;width:1px;" style="height:1px;width:1px;" id="fwin_content_'
                + k
                + '"></td><td style="height:1px;width:1px;"  ondblclick="hideWindow(\''
                + k
                + '\')"></td></tr><tr><td style="height:1px;width:1px;"></td><td style="height:1px;width:1px;" ondblclick="hideWindow(\''
                + k + '\')"></td><td style="height:1px;width:1px;" ></td></tr></table>';
        if (mode == "html") {
            document.getElementById("fwin_content_" + k).innerHTML = url;
            initMenu();
            show()
        } else {
            fetchContent()
        }
    } else {
        if ((mode == "get" && url != menuObj.url)
                || (mode == "post" && document.getElementById(url).action != menuObj.act)) {
            fetchContent()
        } else {
            show()
        }
    }
    doane()
}
function hideWindow(a, b) {
    if(a=="create"){
        $("#txt_meeting_title").val("");
        $("#requestlist").text("");
    }
    var id_cal = document.getElementById("calendar");
    if(id_cal){
        id_cal.style.display = "none";
    }
    b = isUndefined(b) ? 1 : b;

    if(a == 'work_hand'){
        document.getElementById("append_parent").innerHTML='';
    }else{
        hideMenu("fwin_" + a, "win");
    }
    if (b) {
        hideMenu()
    }
    hideMenu("", "prompt")
}
function hideWindow_submit(a, b) {
    if(a=="create"){
    $("#txt_meeting_title").val("");
    $("#requestlist").text("");}
    var id_cal = document.getElementById("calendar");
    if(id_cal){
        id_cal.style.display = "none";
    }

    b = isUndefined(b) ? 1 : b;
    hideMenu("fwin_" + a, "win");
    if (b) {
        hideMenu()
    }
    hideMenu("", "prompt")
}
function Ajax(c, b) {
    for ( var a = 0; a < AJAX.stack.length && AJAX.stack[a] != 0; a++) {
    }
    AJAX.stack[a] = 1;
    var d = new Object();
    d.loading = "loading...";
    d.recvType = c ? c : "XML";
    d.waitId = b ? document.getElementById(b) : "ajaxwaitid";
    d.resultHandle = null;
    d.sendString = "";
    d.targetUrl = "";
    d.stackId = 0;
    d.stackId = a;
    d.setLoading = function(f) {
        if (typeof f !== "undefined" && f !== null) {
            d.loading = f
        }
    };
    d.setRecvType = function(f) {
        d.recvType = f
    };
    d.setWaitId = function(f) {
        d.waitId = typeof f == "object" ? f : "ajaxwaitid"
    };
    d.createXMLHttpRequest = function() {
        var h = false;
        if (window.XMLHttpRequest) {
            h = new XMLHttpRequest();
            if (h.overrideMimeType) {
                h.overrideMimeType("text/xml")
            }
        } else {
            if (window.ActiveXObject) {
                var f = [ "Microsoft.XMLHTTP", "MSXML.XMLHTTP",
                        "Microsoft.XMLHTTP", "Msxml2.XMLHTTP.7.0",
                        "Msxml2.XMLHTTP.6.0", "Msxml2.XMLHTTP.5.0",
                        "Msxml2.XMLHTTP.4.0", "MSXML2.XMLHTTP.3.0",
                        "MSXML2.XMLHTTP" ];
                for ( var g = 0; g < f.length; g++) {
                    try {
                        h = new ActiveXObject(f[g]);
                        if (h) {
                            return h
                        }
                    } catch (j) {
                    }
                }
            }
        }
        return h
    };
    d.XMLHttpRequest = d.createXMLHttpRequest();
    d.showLoading = function() {
        if (d.waitId && (d.XMLHttpRequest.readyState != 4 || d.XMLHttpRequest.status != 200)) {
            $("#" + d.waitId).fadeIn()
        }
    };
    d.processHandle = function() {
        if (d.XMLHttpRequest.readyState == 4 && d.XMLHttpRequest.status == 200) {
            for (k in AJAX.url) {
                if (AJAX.url[k] == d.targetUrl) {
                    AJAX.url[k] = null
                }
            }
            if (d.waitId) {
                $("#" + d.waitId).fadeOut()
            }
            if (d.recvType == "HTML") {
                d.resultHandle(d.XMLHttpRequest.responseText, d)
            } else {
                if (d.recvType == "XML") {
                    if (!d.XMLHttpRequest.responseXML
                            || !d.XMLHttpRequest.responseXML.lastChild
                            || d.XMLHttpRequest.responseXML.lastChild.localName == "parsererror") {
                        d.resultHandle('<a href="'+ d.targetUrl+ '" target="_blank" style="color:red">XML解析错误</a>',d);
                    } else {
                        d.resultHandle(d.XMLHttpRequest.responseXML.lastChild.firstChild.nodeValue,d);
                    }
                }
            }
            AJAX.stack[d.stackId] = 0
        }
    };
    d.get = function(j, f) {
        setTimeout(function() {
            d.showLoading()
        }, 250);
        if (in_array(j, AJAX.url)) {
            return false
        } else {
            AJAX.url.push(j)
        }
        d.targetUrl = j;
        d.XMLHttpRequest.onreadystatechange = d.processHandle;
        d.resultHandle = f;
        var g = isUndefined(g) ? 0 : g;
        var h = g & 1 ? (d.stackId + 1) * 1001 : 100;
        if (window.XMLHttpRequest) {
            setTimeout(function() {
                d.XMLHttpRequest.open("GET", d.targetUrl);
                d.XMLHttpRequest.setRequestHeader("X-Requested-With",
                        "XMLHttpRequest");
                d.XMLHttpRequest.send(null)
            }, h)
        } else {
            setTimeout(function() {
                d.XMLHttpRequest.open("GET", j, true);
                d.XMLHttpRequest.setRequestHeader("X-Requested-With",
                        "XMLHttpRequest");
                d.XMLHttpRequest.send()
            }, h)
        }
    };
    d.post = function(h, g, f) {
        setTimeout(function() {
            d.showLoading()
        }, 250);
        if (in_array(h, AJAX.url)) {
            return false
        } else {
            AJAX.url.push(h)
        }
        d.targetUrl = h;
        d.sendString = g;
        d.XMLHttpRequest.onreadystatechange = d.processHandle;
        d.resultHandle = f;
        d.XMLHttpRequest.open("POST", h);
        d.XMLHttpRequest.setRequestHeader("Content-Type",
                "application/x-www-form-urlencoded");
        d.XMLHttpRequest.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        d.XMLHttpRequest.send(d.sendString)
    };
    return d
}
function newfunction(c) {
    var a = [];
    for ( var b = 1; b < arguments.length; b++) {
        a.push(arguments[b])
    }
    return function(d) {
        doane(d);
        window[c].apply(window, a);
        return false
    }
}
function evalscript(c) {
    if (c.indexOf("<script") == -1) {
        return c
    }
    var d = /<script[^\>]*?>([^\x00]*?)<\/script>/ig;
    var a = [];
    while (a = d.exec(c)) {
        var f = /<script[^\>]*?src=\"([^\>]*?)\"[^\>]*?(reload=\"1\")?(?:charset=\"([\w\-]+?)\")?><\/script>/i;
        var b = [];
        b = f.exec(a[0]);
        if (b) {
            appendscript(b[1], "", b[2], b[3])
        } else {
            f = /<script(.*?)>([^\x00]+?)<\/script>/i;
            b = f.exec(a[0]);
            appendscript("", b[2], b[1].indexOf("reload=") != -1)
        }
    }
    return c
}
function appendscript(g, f, b, j) {
    var h = hash(g + f);
    var c = [];
    if (!b && in_array(h, c)) {
        return
    }
    if (b && document.getElementById(h)) {
        document.getElementById(h).parentNode.removeChild(document
                .getElementById(h))
    }
    c.push(h);
    var a = document.createElement("script");
    a.type = "text/javascript";
    a.id = h;
    a.charset = j ? j : (BROWSER.firefox ? document.characterSet
            : document.charset);
    try {
        if (g) {
            a.src = g
        } else {
            if (f) {
                a.text = f
            }
        }
        document.getElementById("append_parent").appendChild(a)
    } catch (d) {
    }
}
function stripscript(a) {
    return a.replace(/<script.*?>.*?<\/script>/ig, "")
}
function ajaxupdateevents(b, a) {
    a = a ? a : "A";
    var d = b.getElementsByTagName(a);
    for (k in d) {
        var c = d[k];
        ajaxupdateevent(c)
    }
}
function ajaxupdateevent(b) {
    if (typeof b == "object" && b.getAttribute) {
        if (b.getAttribute("ajaxtarget")) {
            if (!b.id) {
                b.id = Math.random()
            }
            var a = b.getAttribute("ajaxevent") ? b.getAttribute("ajaxevent")
                    : "click";
            var c = b.getAttribute("ajaxurl") ? b.getAttribute("ajaxurl")
                    : b.href;
            _attachEvent(b, a, newfunction("ajaxget", c, b
                    .getAttribute("ajaxtarget"), b.getAttribute("ajaxwaitid"),
                    b.getAttribute("ajaxloading"), b
                            .getAttribute("ajaxdisplay")));
            if (b.getAttribute("ajaxfunc")) {
                b.getAttribute("ajaxfunc").match(/(\w+)\((.+?)\)/);
                _attachEvent(b, a, newfunction(RegExp.document.getElementById1,
                        RegExp.document.getElementById2))
            }
        }
    }
}
function ajax_get(url, showid, waitid, loading, display, recall) {
    $.get(url, showid, function(data){
        var dom = document.getElementById(showid);
        dom.innerHTML = data;
        if (typeof recall == "function") {
            recall()
        } else {
            eval(recall)
        }
    });
}
function ajaxget(url, showid, waitid, loading, display, recall) {
    waitid = typeof waitid == "undefined" || waitid === null ? showid : waitid;
    var x = new Ajax();
    x.setLoading(loading);
    x.setWaitId(waitid);
    x.display = typeof display == "undefined" || display == null ? "" : display;
    x.showId = document.getElementById(showid);
    if (x.showId) {
        x.showId.orgdisplay = typeof x.showId.orgdisplay === "undefined" ? x.showId.style.display
                : x.showId.orgdisplay
    }
    if (url.substr(strlen(url) - 1) == "#") {
        url = url.substr(0, strlen(url) - 1);
        x.autogoto = 1
    }
    var url = url + "&inajax=1&ajaxtarget=" + showid;
    x.get(url, function(s, x) {
        var evaled = false;
        if (s.indexOf("ajaxerror") != -1) {
            evalscript(s);
            evaled = true
        }
        if (!evaled && (typeof ajaxerror == "undefined" || !ajaxerror)) {
            if (x.showId) {
                x.showId.style.display = x.showId.orgdisplay;
                x.showId.style.display = x.display;
                x.showId.orgdisplay = x.showId.style.display;
                ajaxinnerhtml(x.showId, s);
                ajaxupdateevents(x.showId, showid);
                if (x.autogoto) {
                    scroll(0, x.showId.offsetTop)
                }
            }
        }
        ajaxerror = null;
        if (typeof recall == "function") {
            recall()
        } else {
            eval(recall)
        }
    })
}
function ajaxLogin(a) {
    var b = $("#log_remember").attr("checked");
    var d = $.trim($("#log_name").val());
    var f = $.trim($("#log_password").val());
    if (b) {
        var c = 1
    }
    if (!d) {
        $("#log_name").focus();
        $("#login_submit").addClass("animated shake").animate({
            border : 0
        }, 1000, function() {
            $(this).removeClass("animated shake")
        });
        return false
    } else {
        if (!f) {
            $("#log_password").focus();
            $("#login_submit").addClass("animated shake").animate({
                border : 0
            }, 1000, function() {
                $(this).removeClass("animated shake")
            });
            return false
        } else {
            $.post("/index.php?do=login", {
                log_remember : c,
                txt_account : d,
                pwd_password : f,
                login_type : 3
            }, function(j) {
                $("#load").addClass("hidden");
                $("#loading").removeClass("hidden");
                if (j.status) {
                    var m = j.data.balance;
                    var o = j.data.credit;
                    var n = j.data.username;
                    var g = j.data.pic;
                    var h = j.data.uid;
                    var l = j.data.is_admin;
                    $("head").append(j.data.syn);
                    loadHandle(a, j.msg, j.status, m, o, h, n, g, l)
                }
            }, "json")
        }
    }
}
function loadHandle(j, g, c, a, b, h, d, f, l) {
    $("#loading").addClass("hidden");
    $("#login_submit").removeClass("animated shake");
    if (c == "1") {
        if (!j || j == "index") {
            $("#load").removeClass("hidden");
            $("#logined").removeClass("hidden");
            $("#login").removeClass("selected");
            $("#login_box").addClass("hidden");
            $("#login_sub").addClass("hidden");
            l == 1 ? $("#manage_center").removeClass("hidden") : "";
            $("#avatar :first").attr("title", d).html(f + d);
            $("#money").html("￥" + a + "|" + b);
            $("#space").attr("href", "/index.php?do=space&member_id=" + h);
            window.document.location.reload();
        } else {
            window.document.location.reload();
        }
    } else {
        $("#loading_error").removeClass("hidden").addClass("selected").html(g);
        setTimeout("loginBoxShow()", 1500)
    }
}
function loginBoxShow() {
    $("#loading_error").removeClass("selected").addClass("hidden");
    $("#load").removeClass("hidden")
}
function ajaxpost(formid, showid, waitid, showidclass, submitbtn, recall) {
    var waitid = typeof waitid == "undefined" || waitid === null ? showid
            : (waitid !== "" ? waitid : "");
    var showidclass = !showidclass ? "" : showidclass;
    var ajaxframeid = "ajaxframe";
    var ajaxframe = document.getElementById(ajaxframeid);
    var formtarget = document.getElementById(formid).target;
    var handleResult = function() {
        var s = "";
        var evaled = false;
        showloading("none");
        try {
            s = document.getElementById(ajaxframeid).contentWindow.document.XMLDocument.text
        } catch (e) {
            try {
                s = document.getElementById(ajaxframeid).contentWindow.document.documentElement.firstChild.wholeText
            } catch (e) {
                try {
                    s = document.getElementById(ajaxframeid).contentWindow.document.documentElement.firstChild.nodeValue
                } catch (e) {
                    s = "XML解析错误"
                }
            }
        }
        if (isUndefined(s)) {
            s = "server return empty , Plase check php script"
        }
        if (s != "" && s.indexOf("ajaxerror") != -1) {
            evalscript(s);
            evaled = true
        }
        if (showidclass) {
            document.getElementById(showid).className = showidclass
        }
        if (submitbtn) {
            submitbtn.disabled = false
        }
        if (!evaled && (typeof ajaxerror == "undefined" || !ajaxerror)) {
            ajaxinnerhtml(document.getElementById(showid), s)
        }
        ajaxerror = null;
        if (document.getElementById(formid)) {
            document.getElementById(formid).target = formtarget
        }
        if (typeof recall == "function") {
            recall()
            if($('#ajaxwaitid')!=undefined)
                $('#ajaxwaitid').remove();
        } else {
            eval(recall)
        }
        if (!evaled) {
            evalscript(s)
        }
        ajaxframe.loading = 0;
        document.getElementById("append_parent").removeChild(
                ajaxframe.parentNode)
    };
    if (!ajaxframe) {
        var div = document.createElement("div");
        div.style.display = "none";
        div.innerHTML = '<iframe name="' + ajaxframeid + '" id="' + ajaxframeid
                + '" loading="1"></iframe>';
        document.getElementById("append_parent").appendChild(div);
        ajaxframe = document.getElementById(ajaxframeid)
    } else {
        if (ajaxframe.loading) {
            return false
        }
    }
    _attachEvent(ajaxframe, "load", handleResult);
    showloading();
    document.getElementById(formid).target = ajaxframeid;
    document.getElementById(formid).action += "&inajax=1";
    document.getElementById(formid).submit();
    if (submitbtn) {
        submitbtn.disabled = true
    }
    doane();
    return false
}
function ajaxmenu(ctrlObj, timeout, cache, duration, pos, recall) {
    var ctrlid = ctrlObj.id;
    if (!ctrlid) {
        ctrlid = ctrlObj.id = "ajaxid_" + Math.random()
    }
    var menuid = ctrlid + "_menu";
    var menu = document.getElementById(menuid);
    if (isUndefined(timeout)) {
        timeout = 3000
    }
    if (isUndefined(cache)) {
        cache = 1
    }
    if (isUndefined(pos)) {
        pos = "43"
    }
    if (isUndefined(duration)) {
        duration = timeout > 0 ? 0 : 3
    }
    var func = function() {
        showMenu({
            ctrlid : ctrlid,
            duration : duration,
            timeout : timeout,
            pos : pos,
            cache : cache,
            layer : 2
        });
        if (typeof recall == "function") {
            recall()
        } else {
            eval(recall)
        }
    };
    if (menu) {
        if (menu.style.display == "") {
            hideMenu(menuid)
        } else {
            func()
        }
    } else {
        menu = document.createElement("div");
        menu.id = menuid;
        menu.style.display = "none";
        menu.className = "p_pop";
        menu.innerHTML = '<div class="p_opt" id="' + menuid
                + '_content"></div>';
        document.getElementById("append_parent").appendChild(menu);
        var url = (!isUndefined(ctrlObj.href) ? ctrlObj.href
                : ctrlObj.attributes.href.value)
                + "&ajaxmenu=1";
        ajaxget(url, menuid + "_content", "ajaxwaitid", "", "", func)
    }
    doane()
}
function hash(b, d) {
    var d = d ? d : 32;
    var f = 0;
    var c = 0;
    var a = "";
    filllen = d - b.length % d;
    for (c = 0; c < filllen; c++) {
        b += "0"
    }
    while (f < b.length) {
        a = stringxor(a, b.substr(f, d));
        f += d
    }
    return a
}
function stringxor(f, c) {
    var g = "";
    var h = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var a = Math.max(f.length, c.length);
    for ( var d = 0; d < a; d++) {
        var b = f.charCodeAt(d) ^ c.charCodeAt(d);
        g += h.charAt(b % 52)
    }
    return g
}
function showloading(a, b) {
    $("#ajaxwaitid").fadeIn()
}
function ajaxinnerhtml(h, g) {

    if (h.tagName != "TBODY") {

        if (BROWSER.ie && BROWSER.ie < 9) {
            h.innerHTML = g;
        }
        else {
            $(h).html(g);
        }

    } else {
        while (h.firstChild) {
            h.firstChild.parentNode.removeChild(h.firstChild)
        }
        var f = document.createElement("DIV");
        f.id = h.id + "_div";
        f.innerHTML = '<table><tbody id="' + h.id + '_tbody">' + g
                + "</tbody></table>";
        document.getElementById("append_parent").appendChild(f);
        var a = f.getElementsByTagName("TR");
        var c = a.length;
        for ( var d = 0; d < c; d++) {
            h.appendChild(a[0])
        }
        var b = f.getElementsByTagName("INPUT");
        var c = b.length;
        for ( var d = 0; d < c; d++) {
            h.appendChild(b[0])
        }
        f.parentNode.removeChild(f)
    }
}
function simulateSelect(selectId, widthvalue) {
    var selectObj = document.getElementById(selectId);
    if (!selectObj) {
        return
    }
    var widthvalue = widthvalue ? widthvalue : 70;
    var defaultopt = selectObj.options[0] ? selectObj.options[0].innerHTML : "";
    var defaultv = "";
    var menuObj = document.createElement("div");
    var ul = document.createElement("ul");
    var handleKeyDown = function(e) {
        e = BROWSER.ie ? event : e;
        if (e.keyCode == 40 || e.keyCode == 38) {
            doane(e)
        }
    };
    var selectwidth = (selectObj.getAttribute("width", i) ? selectObj
            .getAttribute("width", i) : widthvalue)
            + "px";
    for ( var i = 0; i < selectObj.options.length; i++) {
        var li = document.createElement("li");
        li.innerHTML = selectObj.options[i].innerHTML;
        li.k_id = i;
        li.k_value = selectObj.options[i].value;
        if (selectObj.options[i].selected) {
            defaultopt = selectObj.options[i].innerHTML;
            defaultv = selectObj.options[i].value;
            li.className = "current";
            selectObj.setAttribute("selecti", i)
        }
        li.onclick = function() {
            if (document.getElementById(selectId + "_ctrl").innerHTML != this.innerHTML) {
                var lis = menuObj.getElementsByTagName("li");
                lis[document.getElementById(selectId).getAttribute("selecti")].className = "";
                this.className = "current";
                document.getElementById(selectId + "_ctrl").innerHTML = this.innerHTML;
                document.getElementById(selectId).setAttribute("selecti",
                        this.k_id);
                document.getElementById(selectId).options.length = 0;
                document.getElementById(selectId).options[0] = new Option("",
                        this.k_value);
                eval(selectObj.getAttribute("change"))
            }
            hideMenu(menuObj.id);
            return false
        };
        ul.appendChild(li)
    }
    selectObj.options.length = 0;
    selectObj.options[0] = new Option("", defaultv);
    selectObj.style.display = "none";
    selectObj.outerHTML += '<a href="javascript:;" hidefocus="true" id="'
            + selectId + '_ctrl" style="width:' + selectwidth
            + '" tabindex="1">' + defaultopt + "</a>";
    menuObj.id = selectId + "_ctrl_menu";
    menuObj.className = "sltm";
    menuObj.style.display = "none";
    menuObj.style.width = selectwidth;
    menuObj.appendChild(ul);
    document.getElementById("append_parent").appendChild(menuObj);
    document.getElementById(selectId + "_ctrl").onclick = function(e) {
        document.getElementById(selectId + "_ctrl_menu").style.width = selectwidth;
        showMenu({
            ctrlid : (selectId == "loginfield" ? "account" : selectId + "_ctrl"),
            menuid : selectId + "_ctrl_menu",
            evt : "click",
            pos : "13"
        });
        doane(e)
    };
    document.getElementById(selectId + "_ctrl").onfocus = menuObj.onfocus = function() {
        _attachEvent(document.body, "keydown", handleKeyDown)
    };
    document.getElementById(selectId + "_ctrl").onblur = menuObj.onblur = function() {
        _detachEvent(document.body, "keydown", handleKeyDown)
    };
    document.getElementById(selectId + "_ctrl").onkeyup = function(e) {
        e = e ? e : window.event;
        value = e.keyCode;
        if (value == 40 || value == 38) {
            if (menuObj.style.display == "none") {
                document.getElementById(selectId + "_ctrl").onclick()
            } else {
                lis = menuObj.getElementsByTagName("li");
                selecti = selectObj.getAttribute("selecti");
                lis[selecti].className = "";
                if (value == 40) {
                    selecti = parseInt(selecti) + 1
                } else {
                    if (value == 38) {
                        selecti = parseInt(selecti) - 1
                    }
                }
                if (selecti < 0) {
                    selecti = lis.length - 1
                } else {
                    if (selecti > lis.length - 1) {
                        selecti = 0
                    }
                }
                lis[selecti].className = "current";
                selectObj.setAttribute("selecti", selecti);
                lis[selecti].parentNode.scrollTop = lis[selecti].offsetTop
            }
        } else {
            if (value == 13) {
                var lis = menuObj.getElementsByTagName("li");
                lis[selectObj.getAttribute("selecti")].onclick()
            } else {
                if (value == 27) {
                    hideMenu(menuObj.id)
                }
            }
        }
    }
}
function detectCapsLock(d, c) {
    var a = d.keyCode ? d.keyCode : d.which;
    var b = d.shiftKey ? d.shiftKey : (a == 16 ? true : false);
    this.clearDetect = function() {
        c.className = "txt"
    };
    c.className = (a >= 65 && a <= 90 && !b || a >= 97 && a <= 122 && b) ? "clck txt"
            : "txt";
    if (BROWSER.ie) {
        event.srcElement.onblur = this.clearDetect
    } else {
        d.target.onblur = this.clearDetect
    }
}
function showselect(f, d, c, a) {
    if (!f.id) {
        var c = !c ? 0 : c;
        var a = !a ? 0 : a;
        f.id = "calendarexp_" + Math.random();
        div = document.createElement("div");
        div.id = f.id + "_menu";
        div.style.display = "none";
        div.className = "p_pop";
        document.getElementById("append_parent").appendChild(div);
        s = "";
        if (!c) {
            s += showselect_row(d, "一天", 1, 0, a);
            s += showselect_row(d, "一周", 7, 0, a);
            s += showselect_row(d, "一个月", 30, 0, a);
            s += showselect_row(d, "三个月", 90, 0, a);
            s += showselect_row(d, "自定义", -2)
        } else {
            if (document.getElementById(c)) {
                var b = document.getElementById(c).getElementsByTagName("LI");
                for (i = 0; i < b.length; i++) {
                    s += '<a href="javascript:;" onclick="document.getElementById(\''
                            + d
                            + "').value = this.innerHTML\">"
                            + b[i].innerHTML + "</a>"
                }
                s += showselect_row(d, "自定义", -1)
            } else {
                s += '<a href="javascript:;" onclick="document.getElementById(\''
                        + d + "').value = '0'\">永久</a>";
                s += showselect_row(d, "7 天", 7, 1, a);
                s += showselect_row(d, "14 天", 14, 1, a);
                s += showselect_row(d, "一个月", 30, 1, a);
                s += showselect_row(d, "三个月", 90, 1, a);
                s += showselect_row(d, "半年", 182, 1, a);
                s += showselect_row(d, "一年", 365, 1, a);
                s += showselect_row(d, "自定义", -1)
            }
        }
        document.getElementById(div.id).innerHTML = s
    }
    showMenu({
        ctrlid : f.id,
        evt : "click"
    });
    if (BROWSER.ie && BROWSER.ie < 7) {
        doane(event)
    }
}
function showColorBox(a, f, c) {
    if (!document.getElementById(a + "_menu")) {
        var j = document.createElement("div");
        j.id = a + "_menu";
        j.className = "p_pop colorbox";
        j.unselectable = true;
        j.style.display = "none";
        var b = [ "Black", "Sienna", "DarkOliveGreen", "DarkGreen",
                "DarkSlateBlue", "Navy", "Indigo", "DarkSlateGray", "DarkRed",
                "DarkOrange", "Olive", "Green", "Teal", "Blue", "SlateGray",
                "DimGray", "Red", "SandyBrown", "YellowGreen", "SeaGreen",
                "MediumTurquoise", "RoyalBlue", "Purple", "Gray", "Magenta",
                "Orange", "Yellow", "Lime", "Cyan", "DeepSkyBlue",
                "DarkOrchid", "Silver", "Pink", "Wheat", "LemonChiffon",
                "PaleGreen", "PaleTurquoise", "LightBlue", "Plum", "White" ];
        var g = [ "黑色", "赭色", "暗橄榄绿色", "暗绿色", "暗灰蓝色", "海军色", "靛青色", "墨绿色",
                "暗红色", "暗桔黄色", "橄榄色", "绿色", "水鸭色", "蓝色", "灰石色", "暗灰色", "红色",
                "沙褐色", "黄绿色", "海绿色", "间绿宝石", "皇家蓝", "紫色", "灰色", "红紫色", "橙色",
                "黄色", "酸橙色", "青色", "深天蓝色", "暗紫色", "银色", "粉色", "浅黄色", "柠檬绸色",
                "苍绿色", "苍宝石绿", "亮蓝色", "洋李色", "白色" ];
        var h = "";
        for ( var d = 0; d < 40; d++) {
            h += '<input type="button" style="background-color: '
                    + b[d]
                    + '"'
                    + (typeof setEditorTip == "function" ? " onmouseover=\"setEditorTip('"
                            + g[d] + "')\" onmouseout=\"setEditorTip('')\""
                            : "")
                    + ' onclick="'
                    + (typeof wysiwyg == "undefined" ? "seditor_insertunit('"
                            + c + "', '[color=" + b[d] + "]', '[/color]')"
                            : (a == editorid + "_tbl_param_4" ? "document.getElementById('"
                                    + a + "').value='" + b[d] + "';hideMenu(2)"
                                    : "KEKECODE('forecolor', '" + b[d] + "')"))
                    + '" title="' + g[d] + '" />'
                    + (d < 39 && (d + 1) % 8 == 0 ? "<br />" : "")
        }
        j.innerHTML = h;
        document.getElementById("append_parent").appendChild(j)
    }
    showMenu({
        ctrlid : a,
        evt : "click",
        layer : f
    })
}
function seditor_ctlent(event, script) {
    if (event.ctrlKey && event.keyCode == 13 || event.altKey
            && event.keyCode == 83) {
        eval(script)
    }
}
function parseurl(d, c, b) {
    if (isUndefined(b)) {
        b = true
    }
    if (b) {
        d = d.replace(/\s*\[code\]([\s\S]+?)\[\/code\]\s*/ig, function(f, g) {
            return codetag(g)
        })
    }
    d = d
            .replace(
                    /([^>=\]"'\/]|^)((((https?|ftp):\/\/)|www\.)([\w\-]+\.)*[\w\-\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&~`@':+!]*)+\.(jpg|gif|png|bmp))/ig,
                    c == "html" ? '$1<img src="$2" border="0">'
                            : "$1[img]$2[/img]");
    d = d
            .replace(
                    /([^>=\]"'\/@]|^)((((https?|ftp|gopher|news|telnet|rtsp|mms|callto|bctp|ed2k|thunder|synacast):\/\/))([\w\-]+\.)*[:\.@\-\w\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&~`@':+!#]*)*)/ig,
                    c == "html" ? '$1<a href="$2" target="_blank">$2</a>'
                            : "$1[url]$2[/url]");
    d = d
            .replace(
                    /([^\w>=\]"'\/@]|^)((www\.)([\w\-]+\.)*[:\.@\-\w\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&~`@':+!#]*)*)/ig,
                    c == "html" ? '$1<a href="$2" target="_blank">$2</a>'
                            : "$1[url]$2[/url]");
    d = d.replace(/([^\w->=\]:"'\.\/]|^)(([\-\.\w]+@[\.\-\w]+(\.\w+)+))/ig,
            c == "html" ? '$1<a href="mailto:$2">$2</a>'
                    : "$1[email]$2[/email]");
    if (b) {
        for ( var a = 0; a <= KEKECODE.num; a++) {
            d = d.replace("[\tCODE_" + a + "\t]", KEKECODE.html[a])
        }
    }
    return d
}
function codetag(a) {
    KEKECODE.num++;
    if (typeof wysiwyg != "undefined" && wysiwyg) {
        a = a.replace(/<br[^\>]*>/ig, "\n").replace(/<(\/|)[A-Za-z].*?>/ig, "")
    }
    KEKECODE.html[KEKECODE.num] = "[code]" + a + "[/code]";
    return "[\tCODE_" + KEKECODE.num + "\t]"
}
if (BROWSER.ie) {
    document.documentElement.addBehavior("#default#userdata")
}
function ctrlEnter(a, c, b) {
    if (isUndefined(b)) {
        b = 0
    }
    if ((a.ctrlKey || b) && a.keyCode == 13) {
        document.getElementById(c).click();
        return false
    }
    return true
}
function hasClass(b, a) {
    return b.className
            && (" " + b.className + " ").indexOf(" " + a + " ") != -1
}
function updatestring(c, b, a) {
    b = "_" + b + "_";
    return a ? c.replace(b, "") : (c.indexOf(b) == -1 ? c + b : c)
}
function parsepmcode(a) {
    a.message.value = parseurl(a.message.value)
}
function getClipboardData() {
    window.document.clipboardswf.SetVariable("str", clipboardswfdata)
}
function AC_GetArgs(b, d, g) {
    var a = new Object();
    a.embedAttrs = new Object();
    a.params = new Object();
    a.objAttrs = new Object();
    for ( var c = 0; c < b.length; c = c + 2) {
        var f = b[c].toLowerCase();
        switch (f) {
        case "classid":
            break;
        case "pluginspage":
            a.embedAttrs[b[c]] = "http://www.macromedia.com/go/getflashplayer";
            break;
        case "src":
            a.embedAttrs[b[c]] = b[c + 1];
            a.params.movie = b[c + 1];
            break;
        case "codebase":
            a.objAttrs[b[c]] = "http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0";
            break;
        case "onafterupdate":
        case "onbeforeupdate":
        case "onblur":
        case "oncellchange":
        case "onclick":
        case "ondblclick":
        case "ondrag":
        case "ondragend":
        case "ondragenter":
        case "ondragleave":
        case "ondragover":
        case "ondrop":
        case "onfinish":
        case "onfocus":
        case "onhelp":
        case "onmousedown":
        case "onmouseup":
        case "onmouseover":
        case "onmousemove":
        case "onmouseout":
        case "onkeypress":
        case "onkeydown":
        case "onkeyup":
        case "onload":
        case "onlosecapture":
        case "onpropertychange":
        case "onreadystatechange":
        case "onrowsdelete":
        case "onrowenter":
        case "onrowexit":
        case "onrowsinserted":
        case "onstart":
        case "onscroll":
        case "onbeforeeditfocus":
        case "onactivate":
        case "onbeforedeactivate":
        case "ondeactivate":
        case "type":
        case "id":
            a.objAttrs[b[c]] = b[c + 1];
            break;
        case "width":
        case "height":
        case "align":
        case "vspace":
        case "hspace":
        case "class":
        case "title":
        case "accesskey":
        case "name":
        case "tabindex":
            a.embedAttrs[b[c]] = a.objAttrs[b[c]] = b[c + 1];
            break;
        default:
            a.embedAttrs[b[c]] = a.params[b[c]] = b[c + 1]
        }
    }
    a.objAttrs.classid = d;
    if (g) {
        a.embedAttrs.type = g
    }
    return a
}
function AC_DetectFlashVer(b, l, c) {
    var n = -1;
    if (navigator.plugins != null
            && navigator.plugins.length > 0
            && (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"])) {
        var m = navigator.plugins["Shockwave Flash 2.0"] ? " 2.0" : "";
        var o = navigator.plugins["Shockwave Flash" + m].description;
        var d = o.split(" ");
        var f = d[2].split(".");
        var a = f[0];
        var p = f[1];
        var g = d[3];
        if (g == "") {
            g = d[4]
        }
        if (g[0] == "d") {
            g = g.substring(1)
        } else {
            if (g[0] == "r") {
                g = g.substring(1);
                if (g.indexOf("d") > 0) {
                    g = g.substring(0, g.indexOf("d"))
                }
            }
        }
        n = a + "." + p + "." + g
    } else {
        if (BROWSER.ie && !BROWSER.opera) {
            try {
                var h = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7");
                n = h.GetVariable("$version")
            } catch (j) {
            }
        }
    }
    if (n == -1) {
        return false
    } else {
        if (n != 0) {
            if (BROWSER.ie && !BROWSER.opera) {
                tempArray = n.split(" ");
                tempString = tempArray[1];
                versionArray = tempString.split(",")
            } else {
                versionArray = n.split(".")
            }
            var a = versionArray[0];
            var p = versionArray[1];
            var g = versionArray[2];
            return a > parseFloat(b)
                    || (a == parseFloat(b))
                    && (p > parseFloat(l) || p == parseFloat(l)
                            && g >= parseFloat(c))
        }
    }
}
function AC_FL_RunContent() {
    var c = "";
    if (AC_DetectFlashVer(9, 0, 124)) {
        var a = AC_GetArgs(arguments,
                "clsid:d27cdb6e-ae6d-11cf-96b8-444553540000",
                "application/x-shockwave-flash");
        if (BROWSER.ie && !BROWSER.opera) {
            c += "<object ";
            for ( var b in a.objAttrs) {
                c += b + '="' + a.objAttrs[b] + '" '
            }
            c += ">";
            for ( var b in a.params) {
                c += '<param name="' + b + '" value="' + a.params[b] + '" /> '
            }
            c += "</object>"
        } else {
            c += "<embed ";
            for ( var b in a.embedAttrs) {
                c += b + '="' + a.embedAttrs[b] + '" '
            }
            c += "></embed>"
        }
    } else {
        c = '此内容需要 Adobe Flash Player 9.0.124 或更高版本<br /><a href="http://www.adobe.com/go/getflashplayer/" target="_blank"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="下载 Flash Player" /></a>'
    }
    return c
}
function setCopy(d, c, b) {
    if (BROWSER.ie) {
        clipboardData.setData("Text", d);
        if (c) {
            showDialog(c, "right")
        }
    } else {
        var a = "resource/img/keke/clipboard.swf";
        b == "admin" ? a = "../../" + a : "";
        var c = '<div class="c"><div style="width: 200px; text-align: center; text-decoration:underline;padding-top:20px;color:#565656;">点此复制到剪贴板</div>'
                + AC_FL_RunContent("id", "clipboardswf", "name",
                        "clipboardswf", "devicefont", "false", "width", "200",
                        "height", "40", "src", a, "menu", "false",
                        "allowScriptAccess", "sameDomain", "swLiveConnect",
                        "true", "wmode", "transparent", "style",
                        "margin-top:-20px") + "</div>";
        showDialog(c, "info");
        d = d+'';
        d = d.replace(/[\xA0]/g, " ");
        clipboardswfdata = d
    }
}
function getscore() {
    var a = new Ajax();
    a.get("/index.php?do=ajax_score&op=getscore", function(b) {
        if (b) {
            msgwin(b, 2000)
        }
    })
}
function msgwin(c, b) {
    var d = document.getElementById("msgwin");
    if (!d) {
        var d = document.createElement("div");
        d.id = "msgwin";
        d.style.display = "none";
        d.style.position = "absolute";
        d.style.zIndex = "100000";
        document.getElementById("append_parent").appendChild(d)
    }
    d.innerHTML = c;
    d.style.display = "";
    d.style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity=0)";
    d.style.opacity = 0;
    var a = document.documentElement && document.documentElement.scrollTop ? document.documentElement.scrollTop
            : document.body.scrollTop;
    pbegin = a + (document.documentElement.clientHeight / 2);
    pend = a + (document.documentElement.clientHeight / 5);
    setTimeout(function() {
        showmsgwin(pbegin, pend, 0, b)
    }, 10);
    d.style.left = ((document.documentElement.clientWidth - d.clientWidth) / 2)
            + "px";
    d.style.top = pbegin + "px"
}
function showmsgwin(c, h, d, f) {
    step = (c - h) / 10;
    var g = document.getElementById("msgwin");
    newp = (parseInt(g.style.top) - step);
    if (newp > h) {
        g.style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity=" + d
                + ")";
        g.style.opacity = d / 100;
        g.style.top = newp + "px";
        setTimeout(function() {
            showmsgwin(c, h, d += 10, f)
        }, 10)
    } else {
        g.style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity=100)";
        g.style.opacity = 1;
        setTimeout("displayOpacity('msgwin', 100)", f)
    }
}
function displayOpacity(b, a) {
    if (!document.getElementById(b)) {
        return
    }
    if (a >= 0) {
        a -= 10;
        document.getElementById(b).style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity="
                + a + ")";
        document.getElementById(b).style.opacity = a / 100;
        setTimeout("displayOpacity('" + b + "'," + a + ")", 50)
    } else {
        document.getElementById(b).style.display = "none";
        document.getElementById(b).style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity=100)";
        document.getElementById(b).style.opacity = 1
    }
}
function display(b) {
    var a = document.getElementById(b);
    a.style.display = a.style.display == "" ? "none" : ""
}
function showPrompt(a, b, h, c) {
    var g = a ? a + "_pmenu" : "ntcwin";
    var f = c ? 0 : 3;
    if ($(g)) {
        $(g).parentNode.removeChild($(g))
    }
    var j = document.createElement("div");
    j.id = g;
    j.className = a ? "prmm up" : "ntcwin";
    j.style.display = "none";
    $("append_parent").appendChild(j);
    if (a) {
        h = '<div id="' + a + '_prompt" class="prmc"><ul><li>' + h
                + "</li></ul></div>"
    } else {
        h = '<table cellspacing="0" cellpadding="0" class="popupcredit"><tr><td class="pc_l">&nbsp;</td><td class="pc_c"><div class="pc_inner">'
                + h + '</td><td class="pc_r">&nbsp;</td></tr></table>'
    }
    j.innerHTML = h;
    if (a) {
        if ($(a).evt !== false) {
            var d = function() {
                showMenu({
                    mtype : "prompt",
                    ctrlid : a,
                    evt : b,
                    menuid : g,
                    pos : "210"
                })
            };
            if (b == "click") {
                $(a).onclick = d
            } else {
                $(a).onmouseover = d
            }
        }
        showMenu({
            mtype : "prompt",
            ctrlid : a,
            evt : b,
            menuid : g,
            pos : "210",
            duration : f,
            timeout : c,
            fade : 1,
            zindex : JSMENU.zIndex["prompt"]
        });
        $(a).unselectable = false
    } else {
        showMenu({
            mtype : "prompt",
            pos : "00",
            menuid : g,
            duration : f,
            timeout : c,
            fade : 1,
            zindex : JSMENU.zIndex["prompt"]
        })
    }
}
function swaptab(a, j, g, c, l, f) {
    var m = "tab_", d = "div_", b = {}, h = {};
    typeof (f) == "object" ? "" : f = {};
    f.mpre ? m = f.mpre : "";
    f.spre ? d = f.spre : "";
    for (i = 1; i <= c; i++) {
        h = $("#" + d + a + "_" + i);
        b = $("#" + m + a + "_" + i);
        if (i == l) {
            h.removeClass("hidden").addClass("block");
            b.attr("class", j);
            (f.ajax == 1 && f.url) && ajaxTab(d + a + "_" + i, f.data, f.url)
        } else {
            h.removeClass("block").addClass("hidden");
            b.attr("class", g)
        }
    }
}
function ajaxTab(f, d, c) {
    var a = $("#" + f);
    var b = $.trim(a.html());
    if (b == "" || b == "Data failed to load") {
        $.ajax({
            url : c,
            data : d,
            dataType : "text",
            success : function(g) {
                a.html(g)
            },
            error : function() {
                a.html("Data failed to load");
                return false
            }
        })
    }
}

function ajaxTabReload(f, d, c) {
    var a = $("#" + f);
    var b = $.trim(a.html());
        $.ajax({
            url : c,
            data : d,
            dataType : "text",
            success : function(g) {
                a.html(g)
            },
            error : function() {
                a.html("Data failed to load");
                return false
            }
        })
}

function ajaxTabReloadForPage(f, c, d) {
    var a = $("#" + f);
    var b = $.trim(a.html());
    $.ajax({
        url : c,
        data : d,
        dataType : "text",
        success : function(g) {
            a.html(g);
        },
        error : function() {
            a.html("Data failed to load");
            return false
        }
    });
}

var noflushwarper = document.getElementById("noflushwarper");
function page_load_get(b, a) {
    page_ajax_load_start();
    $.get(b, {
        ajaxflush : 1
    }, function(c) {
        $("#wrapper").html(c);
        a = parseInt(a);
        if (!isNaN(a)) {
            settimeout("page_ajax_load_end();", a * 1000)
        } else {
            page_ajax_load_end()
        }
    });
    return false
}
function page_load_post(b, a) {
    page_ajax_load_start();
    $.post(b, {
        ajaxflush : 1
    }, function(c) {
        $("#keke_content_body").html(c);
        a = parseInt(a);
        if (!isNaN(a)) {
            settimeout("page_ajax_load_end();", a * 1000)
        } else {
            page_ajax_load_end()
        }
    });
    return false
}
function page_load_form(c, a) {
    page_ajax_load_start();
    var d = $("#" + c).formSerialize();
    var b = $("#" + c).attr("action");
    if (b.match(/\?/)) {
        b += "&ajaxflush=1"
    } else {
        b += "?ajaxflush=1"
    }
    $.post(b, d, function(f) {
        $("#keke_content_body").html(f);
        a = parseInt(a);
        if (!isNaN(a)) {
            settimeout("page_ajax_load_end();", a * 1000)
        } else {
            page_ajax_load_end()
        }
    });
    return false
}
function page_ajax_load_start() {
    document.body.scrollHeight;
    noflushwarper.style.width = document.body.scrollWidth;
    noflushwarper.style.height = document.body.scrollHeight;
    $(noflushwarper).show()
}
function page_ajax_load_end() {
    $(noflushwarper).hide()
}
function ajaxpage(b, d, a) {
    var f = $("#" + b);
    var c = $("#" + b + a);
    if (c.length == 0 && a > 1) {
        f.load(d + " #" + b, function () {
            f.siblings().hide();
            f.show();
        });
        f.before(f.clone(true).hide());
        f.get(0).setAttribute("id", b + a)
    }
    else {
        if (a == 1) {
            f.show().siblings().hide()
        }
        else {
            c.show().siblings().hide()
        }
    }
    if ($("#taskScroll").length > 0) {
        $("html,body").animate({
            scrollTop: $("#taskScroll").offset().top
        })
    }
}
function getJson(b, a) {
    $.getJSON(b, function(c) {
        var d = c.status == 1 ? "right" : "alert";
        showDialog(c.data, d, c.msg, function() {
            a ? location.href = a : ""
        });
        return false
    })
}
function d_time(o) {
    var r = -1;
    var y = -1;
    var f = -1;
    var g = new Date(o * 1000);
    var l = 24 * 60 * 60 * 1000;
    var t = 60 * 60 * 1000;
    var u = 60 * 1000;
    var d = 1000;
    var w = new Array();
    var j = new Date();
    var h = j.getHours();
    var p = j.getMinutes();
    var x = j.getSeconds();
    var c = "" + ((h > 12) ? h - 12 : h);
    c += ((p < 10) ? ":0" : ":") + p;
    c += ((x < 10) ? ":0" : ":") + x;
    c += ((h > 12) ? " PM" : " AM");
    var n = r;
    var a = y;
    var m = f;
    var q = g.getTime() - j.getTime();
    if(q>0){
        r = Math.floor(q / l);
        q -= r * l;
        y = Math.floor(q / t);
        q -= y * t;
        f = Math.floor(q / u);
        q -= f * u;
        var b = Math.floor(q / d);
        if (n != r) {
            w.push(r);
        } else {
            w.push(0);
        }
        if (a != y) {
            w.push(y);
        } else {
            w.push(0);
        }
        if (m != f) {
            w.push(f);
        }else{
            w.push(0);
        }
        w.push(b);
    }else{
        w.push(0);
        w.push(0);
        w.push(0);
        w.push(0);
    }

    return w
}
window.onload = function() {
    $("body").ajaxStart(function() {
        $("#ajaxwaitid").fadeIn()
    }).ajaxComplete(function() {
        $("#ajaxwaitid").fadeOut()
    })
};
function clear_str(a) {
    a.value = a.value.replace(/([\D]*)/g, "");
    a.value = a.value.replace(/(^0[\d]*)/g, "0");
}

function clear_str1(a) {
    a.value = a.value.replace(/([\D]*)/g, "");
    a.value = a.value.replace(/(^0[\d]*)/g, "0");
}

function clear_fstr(a) {
    a.value = a.value.replace(/(^[0]+|^[^0-9]]+)|([^0-9\.]+)/g, "");
}
function sleep(numberMillis) {
    var now = new Date();
    var exitTime = now.getTime() + numberMillis;
    while (true) {
    now = new Date();
    if (now.getTime() > exitTime)
    return;
    }
}

var redurl;
var uid;

function release_thing(b, a,jump_url,d ,pay_item) {
    redurl = jump_url;
    uid = d;
    if (pay_item && pay_item == 1){
        showDialog("该作品正在审核中，暂不能购买！","alert","操作提示",0);
        return false;
    }
    if (!check_user_login1()) {
        showWindow1("message", "/index.php?do=login_window&redirectURI="+encodeURIComponent(jump_url));
        return false;
    }
    if(jump_url!=undefined||jump_url!=""){
        window.location.href= $("#base_href").attr("href")+jump_url;
    }
    return true;
}
function release_thing1(b, a,jump_url,d) {
    redurl = jump_url;
    uid = d;
    if (!check_user_login1()) {
        showWindow1("message", "/index.php?do=login_window&redirectURI="+encodeURIComponent(jump_url));
        return false;
    }
    if(jump_url!=undefined||jump_url!=""){
        window.open(jump_url);
    }
    return true;
}

//md5
  var hexcase = 0; /* hex output format. 0 - lowercase; 1 - uppercase */
  var b64pad = ""; /* base-64 pad character. "=" for strict RFC compliance */
  var chrsz = 8; /* bits per input character. 8 - ASCII; 16 - Unicode */
/*
  * These are the functions you'll usually want to call
  * They take string arguments and return either hex or base-64 encoded strings
  */
  function hex_md5(s){ return binl2hex(core_md5(str2binl(s), s.length * chrsz));}
  function b64_md5(s){ return binl2b64(core_md5(str2binl(s), s.length * chrsz));}
  function hex_hmac_md5(key, data) { return binl2hex(core_hmac_md5(key, data)); }
  function b64_hmac_md5(key, data) { return binl2b64(core_hmac_md5(key, data)); }
/* Backwards compatibility - same as hex_md5() */
  function calcMD5(s){ return binl2hex(core_md5(str2binl(s), s.length * chrsz));}
/*
  * Perform a simple self-test to see if the VM is working
  */
  function md5_vm_test()
  {
  return hex_md5("abc") == "900150983cd24fb0d6963f7d28e17f72";
  }
/*
  * Calculate the MD5 of an array of little-endian words, and a bit length
  */
  function core_md5(x, len)
  {
  /* append padding */
  x[len >> 5] |= 0x80 << ((len) % 32);
  x[(((len + 64) >>> 9) << 4) + 14] = len;
  var a = 1732584193;
  var b = -271733879;
  var c = -1732584194;
  var d = 271733878;
 for(var i = 0; i < x.length; i += 16)
  {
  var olda = a;
  var oldb = b;
  var oldc = c;
  var oldd = d;
  a = md5_ff(a, b, c, d, x[i+ 0], 7 , -680876936);
  d = md5_ff(d, a, b, c, x[i+ 1], 12, -389564586);
  c = md5_ff(c, d, a, b, x[i+ 2], 17, 606105819);
  b = md5_ff(b, c, d, a, x[i+ 3], 22, -1044525330);
  a = md5_ff(a, b, c, d, x[i+ 4], 7 , -176418897);
  d = md5_ff(d, a, b, c, x[i+ 5], 12, 1200080426);
  c = md5_ff(c, d, a, b, x[i+ 6], 17, -1473231341);
  b = md5_ff(b, c, d, a, x[i+ 7], 22, -45705983);
  a = md5_ff(a, b, c, d, x[i+ 8], 7 , 1770035416);
  d = md5_ff(d, a, b, c, x[i+ 9], 12, -1958414417);
  c = md5_ff(c, d, a, b, x[i+10], 17, -42063);
  b = md5_ff(b, c, d, a, x[i+11], 22, -1990404162);
  a = md5_ff(a, b, c, d, x[i+12], 7 , 1804603682);
  d = md5_ff(d, a, b, c, x[i+13], 12, -40341101);
  c = md5_ff(c, d, a, b, x[i+14], 17, -1502002290);
  b = md5_ff(b, c, d, a, x[i+15], 22, 1236535329);
 a = md5_gg(a, b, c, d, x[i+ 1], 5 , -165796510);
  d = md5_gg(d, a, b, c, x[i+ 6], 9 , -1069501632);
  c = md5_gg(c, d, a, b, x[i+11], 14, 643717713);
  b = md5_gg(b, c, d, a, x[i+ 0], 20, -373897302);
  a = md5_gg(a, b, c, d, x[i+ 5], 5 , -701558691);
  d = md5_gg(d, a, b, c, x[i+10], 9 , 38016083);
  c = md5_gg(c, d, a, b, x[i+15], 14, -660478335);
  b = md5_gg(b, c, d, a, x[i+ 4], 20, -405537848);
  a = md5_gg(a, b, c, d, x[i+ 9], 5 , 568446438);
  d = md5_gg(d, a, b, c, x[i+14], 9 , -1019803690);
  c = md5_gg(c, d, a, b, x[i+ 3], 14, -187363961);
  b = md5_gg(b, c, d, a, x[i+ 8], 20, 1163531501);
  a = md5_gg(a, b, c, d, x[i+13], 5 , -1444681467);
  d = md5_gg(d, a, b, c, x[i+ 2], 9 , -51403784);
  c = md5_gg(c, d, a, b, x[i+ 7], 14, 1735328473);
  b = md5_gg(b, c, d, a, x[i+12], 20, -1926607734);
 a = md5_hh(a, b, c, d, x[i+ 5], 4 , -378558);
  d = md5_hh(d, a, b, c, x[i+ 8], 11, -2022574463);
  c = md5_hh(c, d, a, b, x[i+11], 16, 1839030562);
  b = md5_hh(b, c, d, a, x[i+14], 23, -35309556);
  a = md5_hh(a, b, c, d, x[i+ 1], 4 , -1530992060);
  d = md5_hh(d, a, b, c, x[i+ 4], 11, 1272893353);
  c = md5_hh(c, d, a, b, x[i+ 7], 16, -155497632);
  b = md5_hh(b, c, d, a, x[i+10], 23, -1094730640);
  a = md5_hh(a, b, c, d, x[i+13], 4 , 681279174);
  d = md5_hh(d, a, b, c, x[i+ 0], 11, -358537222);
  c = md5_hh(c, d, a, b, x[i+ 3], 16, -722521979);
  b = md5_hh(b, c, d, a, x[i+ 6], 23, 76029189);
  a = md5_hh(a, b, c, d, x[i+ 9], 4 , -640364487);
  d = md5_hh(d, a, b, c, x[i+12], 11, -421815835);
  c = md5_hh(c, d, a, b, x[i+15], 16, 530742520);
  b = md5_hh(b, c, d, a, x[i+ 2], 23, -995338651);
 a = md5_ii(a, b, c, d, x[i+ 0], 6 , -198630844);
  d = md5_ii(d, a, b, c, x[i+ 7], 10, 1126891415);
  c = md5_ii(c, d, a, b, x[i+14], 15, -1416354905);
  b = md5_ii(b, c, d, a, x[i+ 5], 21, -57434055);
  a = md5_ii(a, b, c, d, x[i+12], 6 , 1700485571);
  d = md5_ii(d, a, b, c, x[i+ 3], 10, -1894986606);
  c = md5_ii(c, d, a, b, x[i+10], 15, -1051523);
  b = md5_ii(b, c, d, a, x[i+ 1], 21, -2054922799);
  a = md5_ii(a, b, c, d, x[i+ 8], 6 , 1873313359);
  d = md5_ii(d, a, b, c, x[i+15], 10, -30611744);
  c = md5_ii(c, d, a, b, x[i+ 6], 15, -1560198380);
  b = md5_ii(b, c, d, a, x[i+13], 21, 1309151649);
  a = md5_ii(a, b, c, d, x[i+ 4], 6 , -145523070);
  d = md5_ii(d, a, b, c, x[i+11], 10, -1120210379);
  c = md5_ii(c, d, a, b, x[i+ 2], 15, 718787259);
  b = md5_ii(b, c, d, a, x[i+ 9], 21, -343485551);
 a = safe_add(a, olda);
  b = safe_add(b, oldb);
  c = safe_add(c, oldc);
  d = safe_add(d, oldd);
  }
  return Array(a, b, c, d);
  }
/*
  * These functions implement the four basic operations the algorithm uses.
  */
  function md5_cmn(q, a, b, x, s, t)
  {
  return safe_add(bit_rol(safe_add(safe_add(a, q), safe_add(x, t)), s),b);
  }
  function md5_ff(a, b, c, d, x, s, t)
  {
  return md5_cmn((b & c) | ((~b) & d), a, b, x, s, t);
  }
  function md5_gg(a, b, c, d, x, s, t)
  {
  return md5_cmn((b & d) | (c & (~d)), a, b, x, s, t);
  }
  function md5_hh(a, b, c, d, x, s, t)
  {
  return md5_cmn(b ^ c ^ d, a, b, x, s, t);
  }
  function md5_ii(a, b, c, d, x, s, t)
  {
  return md5_cmn(c ^ (b | (~d)), a, b, x, s, t);
  }
/*
  * Calculate the HMAC-MD5, of a key and some data
  */
  function core_hmac_md5(key, data)
  {
  var bkey = str2binl(key);
  if(bkey.length > 16) bkey = core_md5(bkey, key.length * chrsz);
 var ipad = Array(16), opad = Array(16);
  for(var i = 0; i < 16; i++)
  {
  ipad[i] = bkey[i] ^ 0x36363636;
  opad[i] = bkey[i] ^ 0x5C5C5C5C;
  }
 var hash = core_md5(ipad.concat(str2binl(data)), 512 + data.length * chrsz);
  return core_md5(opad.concat(hash), 512 + 128);
  }
/*
  * Add integers, wrapping at 2^32. This uses 16-bit operations internally
  * to work around bugs in some JS interpreters.
  */
  function safe_add(x, y)
  {
  var lsw = (x & 0xFFFF) + (y & 0xFFFF);
  var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
  return (msw << 16) | (lsw & 0xFFFF);
  }
/*
  * Bitwise rotate a 32-bit number to the left.
  */
  function bit_rol(num, cnt)
  {
  return (num << cnt) | (num >>> (32 - cnt));
  }
/*
  * Convert a string to an array of little-endian words
  * If chrsz is ASCII, characters >255 have their hi-byte silently ignored.
  */
  function str2binl(str)
  {
  var bin = Array();
  var mask = (1 << chrsz) - 1;
  for(var i = 0; i < str.length * chrsz; i += chrsz)
  bin[i>>5] |= (str.charCodeAt(i / chrsz) & mask) << (i%32);
  return bin;
  }
/*
  * Convert an array of little-endian words to a hex string.
  */
  function binl2hex(binarray)
  {
  var hex_tab = hexcase ? "0123456789ABCDEF" : "0123456789abcdef";
  var str = "";
  for(var i = 0; i < binarray.length * 4; i++)
  {
  str += hex_tab.charAt((binarray[i>>2] >> ((i%4)*8+4)) & 0xF) +
  hex_tab.charAt((binarray[i>>2] >> ((i%4)*8 )) & 0xF);
  }
  return str;
  }
/*
  * Convert an array of little-endian words to a base-64 string
  */
  function binl2b64(binarray)
  {
  var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
  var str = "";
  for(var i = 0; i < binarray.length * 4; i += 3)
  {
  var triplet = (((binarray[i >> 2] >> 8 * ( i %4)) & 0xFF) << 16)
  | (((binarray[i+1 >> 2] >> 8 * ((i+1)%4)) & 0xFF) << 8 )
  | ((binarray[i+2 >> 2] >> 8 * ((i+2)%4)) & 0xFF);
  for(var j = 0; j < 4; j++)
  {
  if(i * 8 + j * 6 > binarray.length * 32) str += b64pad;
  else str += tab.charAt((triplet >> 6*(3-j)) & 0x3F);
  }
  }
  return str;
  }
  /**
 * flash 文件上传
 * @param (Object)
 *           paramReg 上传基本参数注册
 * @param (Object)
 *           contrReg 站内业务参数注册
 */
function uploadify_swf(paramReg,contrReg){
    var paramReg  = paramReg?paramReg:{};
    var contrReg  = contrReg?contrReg:{};
    var uploadify = {};
    var auto       = paramReg.auto==true?true:false;//是否自动提交
    var debug     = paramReg.debug==true?true:false;//是否开启debug调试
    var hide      = paramReg.hide==true?true:false;//上传完成后是否隐藏文件域
    var swf        = paramReg.swf?paramReg.swf:'/resource/js/uploadify/uploadify.swf';//flash路径
    var uploader  = paramReg.uploader?paramReg.uploader:$("#base_href").attr("href")+'/index.php?do=ajax&view=upload&flash=1';////上传基本路径
    //var uploader = '/upload';
    var deleter   = paramReg.deleter?paramReg.deleter:$("#base_href").attr("href")+'/index.php?do=ajax&view=file&ajax=delete';//文件删除路径
    var file=fname= paramReg.file?paramReg.file:'upload';//file 表单名name=id=upload
    var resText   = paramReg.text?paramReg.text:'file_ids';//上传完成后结果保存表单名.name=id=file_ids;
    var size      = paramReg.size;//文件大小限制
    var exts      = paramReg.exts;//文件类型限制
    var method    = paramReg.m?paramReg.m:'post';//上传方式
    var limit     = paramReg.limit?paramReg.limit:1;//上传个数限制
    var qlimit    = paramReg.qlimit?paramReg.qlimit:999;
    var text      = paramReg.text?paramReg.text:L.upload_file;//按钮文字
    var uploadedQueueName = paramReg.uploadedQueueName?paramReg.uploadedQueueName:"upload_accessory_queue";   // Houqd,初始化的时候赋值用户调用插件自己定义的变量
    var id    = paramReg.id?paramReg.id:"upload_accessory_queue";
    var uploadTotalLimits = paramReg.uploadTotalLimits?paramReg.uploadTotalLimits:"5";

    var task_id   =    parseInt(contrReg.task_id)+0;
    var work_id   = parseInt(contrReg.work_id)+0;
    var obj_id    = parseInt(contrReg.obj_id)+0;
    var plan_id   = parseInt(contrReg.plan_id)+0;
    var pre       = contrReg.mode=='back'?'../../':'';
    var fileType  = contrReg.fileType?contrReg.fileType:'att';
    var objType   = contrReg.objType?contrReg.objType:'task';
        swf          = pre+swf;
        deleter   = pre+deleter;
        uploader  = pre+uploader+'&file_name='+file+'&file_type='+fileType+'&obj_type='+objType+'&task_id='+task_id+'&work_id='+work_id+'&obj_id='+obj_id+'&plan_id='+plan_id;
        uploadify.auto              =    auto;
        uploadify.debug              =    debug;
        uploadify.hide              =    hide;
        uploadify.swf              =    swf;
        uploadify.uploader          = uploader;
        uploadify.deleter           = deleter;
        uploadify.fileObjName      =    file;
        uploadify.resText          =    resText;
        uploadify.fileSizeLimit      =    size;
        uploadify.fileTypeExts      =    exts;
        uploadify.uploadLimit     = limit;
        uploadify.queueSizeLimit  = qlimit;
        uploadify.method          = method;
        uploadify.uploadedQueueName   = uploadedQueueName;    // Houqd,将变量初始化uploadify,这是调用的新版的上传插件
        uploadify.id              = id;
        uploadify.uploadTotalLimits = uploadTotalLimits;
        uploadify.buttonText      = '';
        uploadify.width = 85;
        uploadify.height = 30;
        //uploadify.buttonImage='/resource/multi_uploadify/img/local_upload.png';
        uploadify.onUploadStart = function(){
            if($("#is_upload").length > 0 )
                $("#is_upload").val(1);
        }

        uploadify.onQueueComplete = function(){
            if($("#is_upload").length > 0 )
                $("#is_upload").val(0);
        }

        uploadify.onClearQueue = function(){
            if($("#is_upload").length > 0 )
                $("#is_upload").val(0);
        }
        uploadify.onUploadProgress = function(){
            if($("#is_upload").length > 0 )
                $("#is_upload").val(1);
        }
        uploadify.onSelect = function(file)
        {
            if($("#push_num").length > 0) {
                var num = $("#push_num").val();
                $("#push_num").val(parseInt(num) + 1);
            }
        }
        uploadify.onUploadSuccess =    function(file,json,response){
            json = eval('('+json+')');
            if(json.err){
                if(msgType==1){
                    tipsAppend(showTarget,json.err,'error','red');
                }else{
                    showDialog(decodeURI(json.err), 'alert', L.error_tips,'',0);
                }
                return false;
            }else{
                json.filename  = fname;
                typeof(uploadResponse)=='function'&&uploadResponse(json);
            }
        };
        uploadify.onFallback = function(){
            showDialog("您未安装FLASH控件，无法上传图片！请安装FLASH控件后再试(<a target='_blank' href='http://get.adobe.com/cn/flashplayer/'>点击下载安装</a>)。","alert","操作提示",0);
        };
      $("#"+file).uploadify(uploadify);
}
function uploadify_swf_1(paramReg,contrReg){
    var paramReg  = paramReg?paramReg:{};
    var contrReg  = contrReg?contrReg:{};
    var uploadify = {};
    var auto       = paramReg.auto==true?true:false;//是否自动提交
    var debug     = paramReg.debug==true?true:false;//是否开启debug调试
    var hide      = paramReg.hide==true?true:false;//上传完成后是否隐藏文件域
    var swf        = paramReg.swf?paramReg.swf:'/resource/js/uploadify/uploadify.swf';//flash路径
    var uploader  = paramReg.uploader?paramReg.uploader:$("#base_href").attr("href")+'/index.php?do=ajax&view=upload&flash=1';////上传基本路径
    //var uploader  = '/upload';
    var deleter   = paramReg.deleter?paramReg.deleter:$("#base_href").attr("href")+'/index.php?do=ajax&view=file&ajax=delete';//文件删除路径
    var file=fname= paramReg.file?paramReg.file:'upload';//file 表单名name=id=upload
    var resText   = paramReg.text?paramReg.text:'file_ids';//上传完成后结果保存表单名.name=id=file_ids;
    var size      = paramReg.size;//文件大小限制
    var exts      = paramReg.exts;//文件类型限制
    var method    = paramReg.m?paramReg.m:'post';//上传方式
    var limit     = paramReg.limit?paramReg.limit:1;//上传个数限制
    var qlimit    = paramReg.qlimit?paramReg.qlimit:999;
    var text      = paramReg.text?paramReg.text:L.upload_file;//按钮文字
    var uploadedQueueName = paramReg.uploadedQueueName?paramReg.uploadedQueueName:"upload_accessory_queue_1";   // Houqd,初始化的时候赋值用户调用插件自己定义的变量
    var id    = paramReg.par_id?paramReg.par_id:"upload_accessory_queue_1";
    var uploadTotalLimits = paramReg.uploadTotalLimits?paramReg.uploadTotalLimits:"5";

    var task_id   =    parseInt(contrReg.task_id)+0;
    var work_id   = parseInt(contrReg.work_id)+0;
    var obj_id    = parseInt(contrReg.obj_id)+0;
    var pre       = contrReg.mode=='back'?'../../':'';
    var fileType  = contrReg.fileType?contrReg.fileType:'att';
    var objType   = contrReg.objType?contrReg.objType:'task';
    swf          = pre+swf;
    deleter   = pre+deleter;
    uploader  = pre+uploader+'&file_name='+file+'&file_type='+fileType+'&obj_type='+objType+'&task_id='+task_id+'&work_id='+work_id+'&obj_id='+obj_id;
    uploadify.auto              =    auto;
    uploadify.debug              =    debug;
    uploadify.hide              =    hide;
    uploadify.swf              =    swf;
    uploadify.uploader          = uploader;
    uploadify.deleter           = deleter;
    uploadify.fileObjName      =    file;
    uploadify.resText          =    resText;
    uploadify.fileSizeLimit      =    size;
    uploadify.fileTypeExts      =    exts;
    //uploadify.uploadLimit     = limit;
    uploadify.queueSizeLimit  = qlimit;
    uploadify.method          = method;
    uploadify.uploadedQueueName   = uploadedQueueName;    // Houqd,将变量初始化uploadify,这是调用的新版的上传插件
    uploadify.id              = id;
    uploadify.uploadTotalLimits = uploadTotalLimits ;
    uploadify.buttonText      = text;
    uploadify.width=85;
    uploadify.height=30;
    //uploadify.buttonImage='/resource/multi_uploadify/img/local_upload.png';
    uploadify.onSelect = function(file)
    {
        if($("#push_num").length > 0) {
            var num = $("#push_num").val();
            $("#push_num").val(parseInt(num) + 1);
        }
    }
    uploadify.onUploadSuccess =    function(file,json,response){
        json = eval('('+json+')');
        if(json.err){
            if(msgType==1){
                tipsAppend(showTarget,json.err,'error','red');
            }else{
                showDialog(decodeURI(json.err), 'alert', L.error_tips,'',0);
            }
            return false;
        }else{
            json.filename  = fname;
            typeof(uploadResponse)=='function'&&uploadResponse_neww(json);
        }
    };
    $("#"+file).uploadify(uploadify);
}
function uploadify_swf_2(paramReg,contrReg){
    var paramReg  = paramReg?paramReg:{};
    var contrReg  = contrReg?contrReg:{};
    var uploadify = {};
    var multi     = paramReg.multi==false ? false:true;
    var auto      = paramReg.auto==true?true:false;//是否自动提交
    var debug     = paramReg.debug==true?true:false;//是否开启debug调试
    var hide      = paramReg.hide==true?true:false;//上传完成后是否隐藏文件域
    var swf        = paramReg.swf?paramReg.swf:'/resource/js/uploadify/uploadify.swf';//flash路径
    var uploader  = paramReg.uploader?paramReg.uploader:$("#base_href").attr("href")+'/index.php?do=ajax&view=upload&flash=1';////上传基本路径
    //var uploader  = '/upload';
    var deleter   = paramReg.deleter?paramReg.deleter:$("#base_href").attr("href")+'/index.php?do=ajax&view=file&ajax=delete';//文件删除路径
    var file=fname= paramReg.file?paramReg.file:'upload';//file 表单名name=id=upload
    var resText   = paramReg.text?paramReg.text:'file_ids_2';//上传完成后结果保存表单名.name=id=file_ids;
    var size      = paramReg.size;//文件大小限制
    var exts      = paramReg.exts;//文件类型限制
    var method    = paramReg.m?paramReg.m:'post';//上传方式
    var limit     = paramReg.limit?paramReg.limit:1;//上传个数限制
    var qlimit    = paramReg.qlimit?paramReg.qlimit:999;
    var text      = paramReg.text?paramReg.text:L.upload_file;//按钮文字
    var uploadedQueueName = paramReg.uploadedQueueName?paramReg.uploadedQueueName:"upload_accessory_queue_2";   // Houqd,初始化的时候赋值用户调用插件自己定义的变量
    var id    = paramReg.par_id?paramReg.par_id:"upload_accessory_queue_2";
    var uploadTotalLimits = paramReg.uploadTotalLimits?paramReg.uploadTotalLimits:"5";

    var task_id   =    parseInt(contrReg.task_id)+0;
    var work_id   = parseInt(contrReg.work_id)+0;
    var obj_id    = parseInt(contrReg.obj_id)+0;
    var pre       = contrReg.mode=='back'?'../../':'';
    var fileType  = contrReg.fileType?contrReg.fileType:'att';
    var objType   = contrReg.objType?contrReg.objType:'task';
    swf          = pre+swf;
    deleter   = pre+deleter;
    uploader  = pre+uploader+'&file_name='+file+'&file_type='+fileType+'&obj_type='+objType+'&task_id='+task_id+'&work_id='+work_id+'&obj_id='+obj_id;
    uploadify.auto              =    auto;
    uploadify.debug              =    debug;
    uploadify.hide              =    hide;
    uploadify.swf              =    swf;
    uploadify.uploader          = uploader;
    uploadify.deleter           = deleter;
    uploadify.fileObjName      =    file;
    uploadify.resText          =    resText;
    uploadify.fileSizeLimit      =    size;
    uploadify.fileTypeExts      =    exts;
    //uploadify.uploadLimit     = limit;
    uploadify.queueSizeLimit  = qlimit;
    uploadify.method          = method;
    uploadify.uploadedQueueName   = uploadedQueueName;    // Houqd,将变量初始化uploadify,这是调用的新版的上传插件
    uploadify.id              = id;
    uploadify.uploadTotalLimits = uploadTotalLimits ;
    uploadify.buttonText      = text;
    uploadify.width=85;
    uploadify.height=30;
    uploadify.multi = multi;
    //uploadify.buttonImage='/resource/multi_uploadify/img/local_upload.png';
    uploadify.onUploadSuccess =    function(file,json,response){
        json = eval('('+json+')');
        if(json.err){
            if(msgType==1){
                tipsAppend(showTarget,json.err,'error','red');
            }else{
                showDialog(decodeURI(json.err), 'alert', L.error_tips,'',0);
            }
            return false;
        }else{
            json.filename  = fname;
            typeof(uploadResponse2)=='function'&&uploadResponse2(json);
        }
    };
    $("#"+file).uploadify(uploadify);
}
/**
 * 个人中心
 * */
function uploadify_swf_user(paramReg,contrReg){
    var paramReg  = paramReg?paramReg:{};
    var contrReg  = contrReg?contrReg:{};
    var uploadify = {};
    var auto       = paramReg.auto==true?true:false;//是否自动提交
    var debug     = paramReg.debug==true?true:false;//是否开启debug调试
    var hide      = paramReg.hide==true?true:false;//上传完成后是否隐藏文件域
    var swf        = paramReg.swf?paramReg.swf:'resource/js/uploadify/uploadify.swf';//flash路径
    var uploader  = paramReg.uploader?paramReg.uploader:$("#base_href").attr("href")+'/index.php?do=ajax&view=upload&flash=1';////上传基本路径
    //var uploader  = '/upload';
    var deleter   = paramReg.deleter?paramReg.deleter:$("#base_href").attr("href")+'/index.php?do=ajax&view=file&ajax=delete';//文件删除路径
    var file=fname= paramReg.file?paramReg.file:'upload';//file 表单名name=id=upload
    var resText   = paramReg.text?paramReg.text:'file_ids';//上传完成后结果保存表单名.name=id=file_ids;
    var size      = paramReg.size;//文件大小限制
    var exts      = paramReg.exts;//文件类型限制
    var method    = paramReg.m?paramReg.m:'post';//上传方式
    var limit     = paramReg.limit?paramReg.limit:1;//上传个数限制
    var qlimit    = paramReg.qlimit?paramReg.qlimit:999;
    var text      = paramReg.text?paramReg.text:L.upload_file;//按钮文字
    var uploadedQueueName = paramReg.uploadedQueueName?paramReg.uploadedQueueName:file;   // Houqd,初始化的时候赋值用户调用插件自己定义的变量
    var id    = paramReg.id?paramReg.id:file;
    var uploadTotalLimits = paramReg.uploadTotalLimits?paramReg.uploadTotalLimits:"1"; //限上传一张

    var task_id   =    parseInt(contrReg.task_id)+0;
    var work_id   = parseInt(contrReg.work_id)+0;
    var obj_id    = parseInt(contrReg.obj_id)+0;
    var pre       = contrReg.mode=='back'?'../../':'';
    var fileType  = contrReg.fileType?contrReg.fileType:'att';
    var objType   = contrReg.objType?contrReg.objType:'';
        swf          = pre+swf;
        deleter   = pre+deleter;
        uploader  = pre+uploader+'&file_name='+file+'&file_type='+fileType+'&obj_type='+objType+'&task_id='+task_id+'&work_id='+work_id+'&obj_id='+obj_id;

        uploadify.auto              =    auto;
        uploadify.debug              =    debug;
        uploadify.hide              =    hide;
        uploadify.swf              =    swf;
        uploadify.uploader          = uploader;
        uploadify.deleter           = deleter;
        uploadify.fileObjName      =    file;
        uploadify.resText          =    resText;
        uploadify.fileSizeLimit      =    size;
        uploadify.fileTypeExts      =    exts;
        //uploadify.uploadLimit     = limit;
        uploadify.queueSizeLimit  = qlimit;
        uploadify.method          = method;
        uploadify.uploadedQueueName   = uploadedQueueName;    // Houqd,将变量初始化uploadify,这是调用的新版的上传插件
        uploadify.id              = id;
        uploadify.uploadTotalLimits = uploadTotalLimits ;
        uploadify.buttonText      = text;
        uploadify.width=85;
        uploadify.height=30;
        //uploadify.buttonImage='resource/multi_uploadify/img/local_upload.png';
        uploadify.onUploadSuccess =    function(file,json,response){
            json = eval('('+json+')');
            if(json.err){
                if(msgType==1){
                    tipsAppend(showTarget,json.err,'error','red');
                }else{
                    showDialog(decodeURI(json.err), 'alert', L.error_tips,'',0);
                }
                return false;
            }else{
                json.filename  = fname;
                typeof(uploadResponse)=='function'&&uploadResponse(json);
            }
        };
    $("#"+file).uploadify(uploadify);
}
/**
 * 验证字符串中是否包含关键词
 * @param str
 */
function is_keyword(str){
    var res_status;
    $.ajax({
        url: '/index.php?do=ajax&view=ajax&ac=keyword&content='+str,
        type: 'get',
        dataType: 'json',
        success : function(r) {
            if(r.status ==1){
                res_status =true;
            }else{
                res_status =false;
            }
        },
        error : function() {
            res_status =true;
        }
    });
    alert(res_status);
}
function goTopEx(){
      var obj=document.getElementById("goTopBtn");
      function getScrollTop(){
        return document.documentElement.scrollTop || document.body.scrollTop;
      }
      function setScrollTop(value){
        document.documentElement.scrollTop=value;
        document.body.scrollTop = value;
      }
      if(obj != null){
          obj.onclick=function(){
                var goTop=setInterval(scrollMove,10);
                function scrollMove(){
                  setScrollTop(getScrollTop()/1.2);
                  if(getScrollTop()<1)clearInterval(goTop);
                }
          }
      }
    }