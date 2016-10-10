/**
 * Utilities Of JS
 * Created by Huangbo
 *
 **/
(function ($) {

    //提示框Alert
    $._alert = function (title, msg) {
        _generate_html._alert_html(title, msg);
        _btn_ok();
        _btn_no(); 
    };

    //确认框Confirm
    $._confirm = function (title, msg, callback) {
        _generate_html._confirm_html(title, msg);
        _btn_ok(callback);
        _btn_no();
    };
  
    //生成HTML
    var _generate_html = {
        _alert_html : function (title, msg) {
            var _html = "";
            _html += '<div id="mb_box"></div><div id="mb_con"><span id="mb_tit">' + title + '</span>';
            _html += '<a id="mb_ico">x</a><div id="mb_msg">' + msg + '</div><div id="mb_btnbox">';
            _html += '<input id="mb_btn_ok" type="button" value="确定" />';
            _html += '</div></div>';
            //必须先将_html添加到body，再设置Css样式
            $("body").append(_html);
            _generate_css._msg_css();
        },
        _confirm_html : function (title, msg, callback) {
            var _html = "";
            _html += '<div id="mb_box"></div><div id="mb_con"><span id="mb_tit">' + title + '</span>';
            _html += '<a id="mb_ico">x</a><div id="mb_msg">' + msg + '</div><div id="mb_btnbox">';
            _html += '<input id="mb_btn_ok" type="button" value="确定" />';
            _html += '<input id="mb_btn_no" type="button" value="取消" />';
            _html += '</div></div>';
            //必须先将_html添加到body，再设置Css样式
            $("body").append(_html);
            _generate_css._msg_css();
        },
        

    };

    //生成CSS
    var _generate_css = {
        _msg_css : function () {
            $("#mb_box").css({ width: '100%', height: '100%', zIndex: '99999', position: 'fixed',
                filter: 'Alpha(opacity=60)', backgroundColor: 'black', top: '0', left: '0', opacity: '0.6'
            });
            $("#mb_con").css({ zIndex: '999999', width: '400px', position: 'fixed',
                backgroundColor: 'White', borderRadius: '15px'
            });
            $("#mb_tit").css({ display: 'block', fontSize: '14px', color: '#444', padding: '10px 15px',
                backgroundColor: '#DDD', borderRadius: '15px 15px 0 0',
                borderBottom: '3px solid #009BFE', fontWeight: 'bold'
            });
            $("#mb_msg").css({ padding: '20px', lineHeight: '20px',
                borderBottom: '1px dashed #DDD', fontSize: '13px'
            });
            $("#mb_ico").css({ display: 'block', position: 'absolute', right: '10px', top: '9px',
                border: '1px solid Gray', width: '18px', height: '18px', textAlign: 'center',
                lineHeight: '16px', cursor: 'pointer', borderRadius: '12px', fontFamily: '微软雅黑'
            });
            $("#mb_btnbox").css({ margin: '15px 0 10px 0', textAlign: 'center' });
            $("#mb_btn_ok,#mb_btn_no").css({ width: '85px', height: '30px', color: 'white', border: 'none' });
            $("#mb_btn_ok").css({ backgroundColor: '#168bbb' });
            $("#mb_btn_no").css({ backgroundColor: 'gray', marginLeft: '20px' });

            //右上角关闭按钮hover样式
            $("#mb_ico").hover(function () {
                $(this).css({ backgroundColor: 'Red', color: 'White' });
            }, function () {
                $(this).css({ backgroundColor: '#DDD', color: 'black' });
            });

            var _widht = document.documentElement.clientWidth; //屏幕宽
            var _height = document.documentElement.clientHeight; //屏幕高
            var boxWidth = $("#mb_con").width();
            var boxHeight = $("#mb_con").height();

            //让提示框居中
            $("#mb_con").css({ top: (_height - boxHeight) / 2 + "px", left: (_widht - boxWidth) / 2 + "px" });
        },
    };

    //确定按钮事件
    var _btn_ok = function (callback) {
        $("#mb_btn_ok").click(function () {
            $("#mb_box,#mb_con").remove();
            if (typeof (callback) == 'function') {
                callback();
            }
        });
    };

    //取消按钮事件
    var _btn_no = function (callback) {
        $("#mb_btn_no, #mb_ico").click(function () {
            $("#mb_box, #mb_con").remove();
        });
        if (typeof (callback) == 'function') {
            callback();
        }
    };

    //获取表单数据
    $._get_form_json = function (form) {
        var o = {};
        var a = $(form).serializeArray();
        $.each(a, function () {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    //校验表单必填数据
    $._check_form = function (dom_name) {
        var _is_pass = true;
        $(dom_name).find('.required').each(function () {
            var _this_dom = $(this);
            var _value = _this_dom.val();
            if (_value == '' || _value == undefined) {
                _this_dom.parent().addClass('has-error');
                _is_pass = false;
            } else {
                _this_dom.parent().removeClass('has-error');
            }
        });
        return _is_pass;
    };

    //必填项处理
    $._form_notice_tips = function (dom_name) {
        $(dom_name).find('.required').each(function () {
            var _this_dom = $(this);
            _this_dom.on('blur', function () {
                var _value = $(this).val();
                if (_value == '' || _value == undefined) {
                    $(this).parent().addClass('has-error');
                } else {
                    $(this).parent().removeClass('has-error');
                }
            });
        });
    };

    //清除表单数据 includeHidden 是否包含hidden的输入框
    $.fn._clear_form = function(includeHidden) {
        return this.each(function() {
            $('input,select,textarea', this)._clear_fields(includeHidden);   //this表示设置上下文环境，有多个表单时只作用调用的表单
        });
    };

    //清除输入框数据
    $.fn._clear_fields = $.fn._clear_inputs = function(includeHidden) {
        var re = /^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i; // 'hidden' is not in this list
        return this.each(function() {
            var t = this.type;
            tag = this.tagName.toLowerCase();
            if (re.test(t) || tag == 'textarea') {
                this.value = '';
            }
            else if (t == 'checkbox' || t == 'radio') {
                this.checked = false;
            }
            else if (tag == 'select') {
                this.selectedIndex = -1;
            }
            else if (t == "file") {
                if (/MSIE/.test(navigator.userAgent)) {
                    $(this).replaceWith($(this).clone(true));
                } else {
                    $(this).val('');
                }
            }
            else if (includeHidden) {
                if ( (includeHidden === true && /hidden/.test(t)) ||
                    (typeof includeHidden == 'string' && $(this).is(includeHidden)) ) {
                    this.value = '';
                }
            }
        });
    };

    //临时生成表单并提交数据
    $._request_form = function(action, data, n) {
        var _form = $("<form/>").attr('action', action).attr('method', 'post');
        var _form = $("<form/>", {
            'action': action,
            'method': post,
        });
        if (n) {
            _form.attr('target', '_blank');
        }
        var input = '';
        $.each(data, function (i, n) {
            input += '<input type="hidden" name="' + i + '" value="' + n + '" />';
        });
        _form.append(input).appendTo("body").css('display', 'none').submit();
        _form.remove();
    }

    //方式实现异步请求
    $._ajax = function (url, data, reqtype, rettype, callback) {
        if(url == '' || url == undefined){
            return
        }
        if ($(document).data(url) == false) {
            return
        }
        $(document).data(url, false);
        $.ajax({
            url: url,
            data: data,
            type: reqtype,
            dataType: rettype,
            success: function (d) {
                $(document).data(url, true);
                if (typeof callback == "function") {
                    callback(d);
                }
            },
        });
    };

    //ajax方式实现异步跨域请求数据-jsonp
    $._jsonp = function (url, data, reqtype, callback) {
        if (url) {
            $.ajax({
                url: url,
                data: data,
                type: reqtype,
                dataType: 'jsonp',
                jsonp: 'callback',
                success: function (d) {
                    if (typeof callback == "function") {
                        callback(d);
                    }
                }
            });
        }
    };

    //判断str字符数量，中文-2，英文和字符-1
    $._str_len = function (str) {
        str = $.trim(str);
        var len = 0;
        for (var i = 0; i < str.length; i++) {
            if (str[i].match(/[^\x00-\xff]/ig) != null) //全角
                len += 2;
            else
                len += 1;
        }
        return len;
    }

    //返回str在规定字节长度max内的值
    $._str_cut = function (str, max) {
        str = $.trim(str);
        var value = '';
        var length = 0;
        for (var i = 0; i < str.length; i++) {
            if (str[i].match(/[^\x00-\xff]/ig) != null){
                length += 2;
            }
            else{
                length += 1;
            }
            if (length > max){
                break;
            }
            value += str[i];
        }
        return value;
    }

    //设置浏览器缓存
    $._cache = {
        set : function(k, v, expire){
            var h = (new Date).getTime();
            if (!k || !v) {
                return undefined;
            }
            ex = h + parseInt(expire * 1000);
            d = {
                data: v,
                timeStamp: ex
            };
            try {
                localStorage.setItem(k, JSON.stringify(d))
            } catch(exeption) {
                if (exeption.name === 'QuotaExceededError') {//超出本地存储限额
                    this.flush();
                    localStorage.setItem(k, JSON.stringify(d))
                }
            }
        },
        get : function(k){
            var b = localStorage.getItem(k);
            var c = (new Date).getTime();
            if (b) {
                b = JSON.parse(b) || {};
                if (b.timeStamp < c) {
                    this.remove(k);
                    return undefined;
                }
                return b.data;
            }
            return undefined;
        },
        remove : function(k){
            localStorage.removeItem(k)
        },
        flush : function(){
            localStorage.clear();
        },
    };

    //加载文件,可以用于临时性的引入js,css等文件，不必在header部分添加
    $._loader = function(){
        this.browser = {
            ie: /msie/.test(window.navigator.userAgent.toLowerCase()),
            moz: /gecko/.test(window.navigator.userAgent.toLowerCase()),
            opera: /opera/.test(window.navigator.userAgent.toLowerCase()),
            safari: /safari/.test(window.navigator.userAgent.toLowerCase())
        };
    };
    $._loader.prototype = {
        jsLoader: function (sUrl, callback) {
            self = this;
            var _script = document.createElement('script');
            _script.setAttribute('type', 'text/javascript');
            _script.setAttribute('charset', 'utf-8');
            _script.setAttribute('src', sUrl);
            document.getElementsByTagName('head')[0].appendChild(_script);
            if (self.browser.ie) {
                _script.onreadystatechange = function () {
                    if (this.readyState == 'loaded' || this.readyState == 'complete') {
                        callback();
                    }
                };
            }
            else if (self.browser.moz) {
                _script.onload = function () {
                    callback();
                };
            }
            else {
                callback();
            }
        },
    };

    $.fn._error = function( msg, location, fading){
        var dom = this;
        if(msg == undefined || msg == ''){
            return ;
        }
        if(fading == undefined){
            fading = 1500;
        }
        var error = $('<p class="msg-error">'+ msg +'</p>');
        if(location == undefined || location == 'after'){
            $(dom).siblings('p.msg-error').remove();
            $(dom).after(error);
        }else if(location == 'append'){
            $(dom).children('p.msg-error').remove();
            $(dom).append(error);
        }
        error.fadeOut(fading);
    }


})(jQuery);