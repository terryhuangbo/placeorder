/**
 * Created by Qingwenjie on 2015/11/6.
 */
/*
 * 该文件依赖于jquery库
 */
if (typeof(STATIC_RC_JS_URL_PREFIX_PATH) == 'undefined') {
    //广告数据文件路径
    JS_FILE_URL_PATH = 'http://static.vsochina.com/rc/js/banners';
}
else {
    JS_FILE_URL_PATH = STATIC_RC_JS_URL_PREFIX_PATH + '/js/banners';
}
var MiniSite = new Object();
MiniSite.Browser = {
    ie: /msie/.test(window.navigator.userAgent.toLowerCase()),
    moz: /gecko/.test(window.navigator.userAgent.toLowerCase()),
    opera: /opera/.test(window.navigator.userAgent.toLowerCase()),
    safari: /safari/.test(window.navigator.userAgent.toLowerCase())
};
MiniSite.JsLoader = {
    load: function (sUrl, fCallback) {
        var _script = document.createElement('script');
        _script.setAttribute('type', 'text/javascript');
        _script.setAttribute('charset', 'utf-8');
        _script.setAttribute('src', sUrl);
        document.getElementsByTagName('head')[0].appendChild(_script);
        if (MiniSite.Browser.ie) {
            _script.onreadystatechange = function () {
                if (this.readyState == 'loaded' || this.readyState == 'complete') {
                    fCallback();
                }
            };
        }
        else if (MiniSite.Browser.moz) {
            _script.onload = function () {
                fCallback();
            };
        }
        else {
            fCallback();
        }
    }
};
jQuery(function () {
    //获取广告js节点
    jQuery('body').find('._web_ad_').each(function () {
        var _this_dom = jQuery(this);
        //获取广告参数
        var _this_ad_data = eval('(' + _this_dom.attr('ad_data') + ')');
        var b_id = parseInt(_this_ad_data.b_id);
        var row_num = parseInt(_this_ad_data.row_num);
        //获取无广告数据时是否清空广告位代码
        if (typeof(_this_ad_data.hide_code) == 'undefined') {
            var hide_code = 'false';
        }
        else {
            var hide_code = _this_ad_data.hide_code;
        }
        if (b_id && row_num) {
            var js_path = JS_FILE_URL_PATH + '/banner' + _this_ad_data.b_id + '.js';
            _is_exist(js_path, function (d) {
                if (d == true) {
                    //引入相关JS数据文件
                    MiniSite.JsLoader.load(js_path, function () {
                        //替换相关标签数据
                        var ad_data = eval('banner' + b_id);
                        if (ad_data && ad_data != '') {
                            var ad_code = '';//最终js代码
                            jQuery.each(ad_data, function (i) {
                                var timestamp = parseInt(new Date().getTime() / 1000);
                                var data = ad_data[i];
                                //判断是否在有效期内
                                if (data.status == 1 && (data.start_time <= timestamp || data.start_time == 0) && (data.end_time >= timestamp || data.end_time == 0)) {
                                    var ad_temp = _this_dom.html();
                                    if (i >= row_num) {
                                        return false;
                                    }
                                    //替换标签
                                    jQuery.each(ad_data[i], function (k, v) {
                                        ad_temp = ad_temp.replace(eval('/{' + k + '}/g'), v);
                                        if(ad_temp.indexOf('{' + k + '|encodeURI}') > -1){
                                            ad_temp = ad_temp.replace(eval('/' + '{' + k + '\\|encodeURI}/g'), encodeURI(v));
                                        }
                                    });
                                    ad_code += ad_temp;
                                }
                            });
                            //截取字符串，去除冗余字符
                            if (typeof(_this_ad_data.sub_str) != 'undefined') {
                                var _sub_str = _this_ad_data.sub_str.split(',');
                                var _start_code = parseInt(_sub_str[0]);
                                var _end_code = parseInt(ad_code.length) + parseInt(_sub_str[1]);
                                ad_code = ad_code.substr(_start_code, _end_code);
                            }
                            //去除空标签
                            _this_dom.html(ad_code.replace(/{\w+}/g, ''));
                        }
                        else {
                            if (hide_code == 'true') {//清空代码
                                _this_dom.remove();
                            }
                            else {
                                _this_dom.html(_this_dom.html().replace(/{\w+}/g, ''));
                            }
                        }
                        _this_dom.removeClass('_web_ad_');
                    });
                }
                else {
                    if (hide_code == 'true') {//清空代码
                        _this_dom.remove();
                    }
                    else {
                        //去除空标签
                        _this_dom.html(_this_dom.html().replace(/{\w+}/g, ''));
                    }
                    _this_dom.removeClass('_web_ad_');
                }
            });
        }
    });
});
function _is_exist(url, callBackFun) {
    if ('XDomainRequest' in window && window.XDomainRequest !== null) {

        var xdr = new XDomainRequest();
        xdr.open('get', url);
        xdr.onload = function () {
            var dom = new ActiveXObject('Microsoft.XMLDOM');
            dom.async = false;
            callBackFun(true);
        };

        xdr.onerror = function () {
            callBackFun(false);
        };

        xdr.send();
    }
    else {
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            data: "",
            success: function () {
                callBackFun(true);
            },
            error: function () {
                callBackFun(false);
            }
        });
    }
}
